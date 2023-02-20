<?php

namespace App\Http\Controllers;

use App\DataTables\TripDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Trip;
use App\Models\City;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class AdminTripsController extends Controller
{
    public function index(Request $request, TripDataTable $dataTable)
    {
        if($request->user()->cannot('trip:browse')) {
            return redirect()->route('dashboard');
        }

        return $dataTable->render('pages.admin.trips.index');
    }

    public function add(Request $request) {
        if($request->user()->cannot('trip:add')) {
            return redirect()->route('dashboard');
        }

        $cities = City::all();

        return view('pages.admin.trips.add', ['cities' => $cities]);
    }

    public function submitAdd(Request $request) {
        if($request->user()->cannot('trip:add')) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'days' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'city' => 'required|integer|min:1',
            'image_url' => 'required',
        ]);

        Trip::create([
            'name' => $request->input('name'), 
            'description' => $request->input('description'), 
            'days' => $request->input('days'), 
            'price' => $request->input('price'), 
            'city_id' => $request->input('city'), 
            'image_url' => $request->input('image_url')
        ]);
        return redirect()->route('trips.index');
    }

    public function edit(Request $request, string $id) {
        if($request->user()->cannot('trip:edit')) {
            return redirect()->route('dashboard');
        }

        $trip = Trip::where('id', '=', $id)->first();
        if ($trip == null) {
            return back();
        }
        $cities = City::all();

        return view('pages.admin.trips.edit', ['data' => $trip, 'cities'=> $cities]);
    }

    public function submitEdit(Request $request, string $id) {
        if($request->user()->cannot('trip:edit')) {
            return redirect()->route('dashboard');
        }

        $trip = Trip::where('id', '=', $id)->first();
        if ($trip == null) {
            return back();
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'days' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'city' => 'required|integer|min:1',
            'image_url' => 'required',
        ]);

        $trip->name = $request->get('name');
        $trip->description = $request->get('description');
        $trip->days = $request->get('days');
        $trip->price = $request->get('price');
        $trip->city_id = $request->get('city');
        $trip->image_url = $request->get('image_url');
        $trip->save();

        return redirect()->route('trips.index');
    }

    public function delete(Request $request, string $id) {
        if($request->user()->cannot('trip:delete')) {
            return back();
        }

        $city = Trip::where('id', '=', $id)->first();
        if ($city == null) {
            return back();
        }
        $city->delete();

        return redirect()->route('trips.index');
    }
}
