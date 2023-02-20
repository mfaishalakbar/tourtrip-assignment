<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Trip;
use App\Models\Hotel;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionMember;
use Illuminate\Support\Facades\DB;
use App\DataTables\PublicTransactionDataTable;

class HomeController extends Controller
{
    public function index() {
        $cities = City::all();
        return view('pages.public.index', ['cities' => $cities]);
    }

    public function login(Request $request) {
        $first_number = rand(10,100);
        $second_number = rand(10,100);
        $prompt = $first_number . " + " . $second_number;

        $counter = $request->session()->put('captcha', $first_number + $second_number);

        return view('pages.public.login', ['captcha' => $prompt]);
    }

    public function search(Request $request) {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'city' => 'required|integer',
        ]);

        $start = New \DateTime($request->get('start_date') . ' 00:00:00');
        $end = New \DateTime($request->get('end_date') . ' 00:00:00');
        $diff_date = $end->diff($start)->format("%a") + 1;
        if ($diff_date > 7) {
            return back();
        }

        // Search Trip by City ID
        $availableTrip = Trip::where('city_id', '=', $request->get('city'))->get();
        // Search Hotel by City ID
        $availableHotel = Hotel::where('city_id', '=', $request->get('city'))->get();

        return view('pages.public.search', ['trips' => $availableTrip, 'hotels' => $availableHotel, 'start_date' => $request->get('start_date'), 'end_date' => $request->get('end_date')]);
    }

    public function submitTransaction(Request $request) {
        $validated = $request->validate([
            "start_date" => "required",
            "end_date" => "required",
            "trips" => "required",
            "hotels" => "required",
            "member_name" => "required",
            "member_place_of_birth" => "required",
            "member_date_of_birth" => "required",
            "member_address" => "required",
            "member_gender" => "required",
        ]);

        $start = New \DateTime($request->get('start_date') . ' 00:00:00');
        $end = New \DateTime($request->get('end_date') . ' 00:00:00');
        $diff_date = $end->diff($start)->format("%a") + 1;

        // Create Transaction
        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'customer_id' => $request->user()->customer_id,
                'total_day' => $diff_date,
                'start_date' => $start,
                'end_date' => $end,
                'total' => 0,
                'status' => 'PENDING'
            ]);

            $numberTotal = 0;

            // Fetch Hotel First
            foreach ($request->get('hotels') as $value) {
                $currentHotel = Hotel::where('id', "=", $value)->first();
                $totalPrice = $currentHotel->price * $diff_date;
                $numberTotal += $totalPrice;
                $_hotelTx = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'hotel_id' => $currentHotel->id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'price' => $currentHotel->price,
                    'total_price' => $totalPrice
                ]);
            }

            // Fetch Trip
            foreach ($request->get('trips') as $value) {
                $currentTrip = Trip::where('id', "=", $value)->first();
                $totalPrice = $currentTrip->price;
                $numberTotal += $totalPrice;

                $_tripTx = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'trip_id' => $currentTrip->id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'price' => $currentTrip->price,
                    'total_price' => $currentTrip->price
                ]);
            }

            foreach ($request->get('member_name') as $index => $value) {
                $txMember = TransactionMember::create([
                    'transaction_id' => $transaction->id,
                    'name' => $request->get('member_name')[$index],
                    'place_of_birth' => $request->get('member_place_of_birth')[$index],
                    'date_of_birth' =>  $request->get('member_date_of_birth')[$index],
                    'address' =>  $request->get('member_address')[$index],
                    'gender' =>  $request->get('member_gender')[$index],
                ]);
            }


            $transaction->total = $numberTotal;
            $transaction->save();
            DB::commit();

            return redirect()->route('public.transaction');
        } catch (\PDOException $e) {
            DB::rollBack();
            return back();
        }
    }

    public function listTransaction(Request $request, PublicTransactionDataTable $dataTable) {
        return $dataTable->render('pages.public.transaction');
    }

    public function detailTransaction(Request $request, string $id ) {
        $txData = Transaction::where('id', '=', $id)->first();
        if ($txData == null) {
            return back();
        }

        $start = New \DateTime($txData->start_date . ' 00:00:00');
        $end = New \DateTime($txData->end_date . ' 00:00:00');
        $diff_date = $end->diff($start)->format("%a") + 1;

        return view('pages.public.transaction_detail', ['transaction' => $txData, 'days' => $diff_date]);
    }


    public function register() {
        return view('pages.public.register');
    }

    public function reset_password() {
        return view('pages.public.resetpassword');
    }

    public function reset_password_confirm(Request $request) {
        if (!$request->session()->has('reset_password_username')) {
            return redirect('/login');
        }
        
        return view('pages.public.resetpasswordconfirm', ['current_username' => $request->session()->get('reset_password_username')]);
    }
}
