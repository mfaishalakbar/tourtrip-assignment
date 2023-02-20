<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Rules\UserPasswordRule;
use App\Models\User;
use App\Models\UserPasswordResets;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthenticationController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ]);
        
        $existingUser = User::where('email', '=', $request->get('email'))->count();
        if($existingUser > 0) {
            throw ValidationException::withMessages(['email' => 'Email already used!']);
        }

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        // Find newly created user, assign to staff role
        $userCustomer = User::where('email', $request->get('email'))->first();
        $userCustomer->assignRole(Role::where('name', '=', 'customer')->first());

        // Create staff object
        $newCustomer = Customer::create([
            'user_id' => $userCustomer->id,
            'place_of_birth' => $request->get('place_of_birth'),
            'date_of_birth' => $request->get('date_of_birth'),
            'address' => $request->get('address'),
            'gender' => $request->get('gender')
        ]);
        
        // Update user with new staff_id
        $userCustomer->customer_id = $newCustomer->id;
        $userCustomer->save();

        return redirect('/login')->with('status', 'Registration success!');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if (!$request->session()->has('captcha') || $request->session()->get('captcha') != $request->get('captcha')) {
            throw ValidationException::withMessages(['captcha' => 'Invalid captcha']);
        }
        
        if ($request->session()->has('wrong_password_cooldown')) {
            $current_cooldown = $request->session()->get('wrong_password_cooldown');
            $delta = time() - $current_cooldown;
            if($delta < 30) {
                throw ValidationException::withMessages(['password' => 'Multiple incorrect login attempt. Please wait for ' . strval(30 - $delta) . ' seconds.']);
            }

            $request->session()->forget(['wrong_password_cooldown', 'wrong_password_attempt']);
        }

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $request->session()->forget(['wrong_password_cooldown', 'wrong_password_attempt']);

            $request->session()->regenerate();
            $user = User::where('email', $request->get('email'))->first();
            Auth::login($user);
            return redirect('/');
        }

        // Set wrong attempt counter
        $counter = 0;
        if ($request->session()->has('wrong_password_attempt')) {
            $counter = $request->session()->get('wrong_password_attempt');
            $counter = $counter + 1;
        }
        $request->session()->put('wrong_password_attempt', $counter);

        if($counter >= 3) {
            $request->session()->put('wrong_password_cooldown', time());
        }

        throw ValidationException::withMessages(['password' => 'Invalid username or password']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->regenerate();
        return redirect('/');
    }

    public function reset_password(Request $request) {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $existingUser = User::where('email', '=', $request->get('email'))->count();
        if($existingUser == 0) {
            throw ValidationException::withMessages(['email' => 'Email not exists']);
        }

        $request->session()->put('reset_password_email', $request->get('email'));
        return redirect('/reset-password/confirm');
    }

    public function reset_password_confirm(Request $request) {
        if (!$request->session()->has('reset_password_email')) {
            return redirect('/login');
        }

        $this->validate($request, [
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ]);

        $existingUser = User::where('email', '=', $request->session()->get('reset_password_email'))->count();
        if($existingUser == 0) {
            throw ValidationException::withMessages(['email' => 'Email not exists']);
        }

        $current = User::where('email', '=', $request->session()->get('reset_password_email'))->first();
        $current->forceFill(['password' => bcrypt($request->get('password'))]);
        $current->save();

        $request->session()->forget('reset_password_email');

        return redirect('/login')->with('status', 'Password Reset Successfully!');
    }
}
