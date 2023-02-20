<?php

namespace App\Http\Controllers;

use App\DataTables\HotelDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Hotel;
use App\Models\City;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class AdminHotelsController extends Controller
{
    public function index(Request $request, HotelDataTable $dataTable)
    {
        if($request->user()->cannot('hotel:browse')) {
            return redirect()->route('dashboard');
        }

        return $dataTable->render('pages.admin.hotels.index');
    }

    public function add(Request $request) {
        if($request->user()->cannot('hotel:add')) {
            return redirect()->route('dashboard');
        }

        $cities = City::all();

        return view('pages.admin.hotels.add', ['cities' => $cities]);
    }

    public function submitAdd(Request $request) {
        if($request->user()->cannot('hotel:add')) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer|min:1',
            'city' => 'required|integer|min:1',
            'image_url' => 'required',
        ]);

        Hotel::create([
            'name' => $request->input('name'), 
            'description' => $request->input('description'), 
            'price' => $request->input('price'), 
            'city_id' => $request->input('city'), 
            'image_url' => $request->input('image_url')
        ]);
        return redirect()->route('hotels.index');
    }

    public function edit(Request $request, string $id) {
        if($request->user()->cannot('hotel:edit')) {
            return redirect()->route('dashboard');
        }

        $hotel = Hotel::where('id', '=', $id)->first();
        if ($hotel == null) {
            return back();
        }
        $cities = City::all();

        return view('pages.admin.hotels.edit', ['data' => $hotel, 'cities'=> $cities]);
    }

    public function submitEdit(Request $request, string $id) {
        if($request->user()->cannot('hotel:edit')) {
            return redirect()->route('dashboard');
        }

        $hotel = Hotel::where('id', '=', $id)->first();
        if ($hotel == null) {
            return back();
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer|min:1',
            'city' => 'required|integer|min:1',
            'image_url' => 'required',
        ]);

        $hotel->name = $request->get('name');
        $hotel->description = $request->get('description');
        $hotel->price = $request->get('price');
        $hotel->city_id = $request->get('city');
        $hotel->image_url = $request->get('image_url');
        $hotel->save();

        return redirect()->route('hotels.index');
    }

    public function delete(Request $request, string $id) {
        if($request->user()->cannot('hotel:delete')) {
            return back();
        }

        $city = Hotel::where('id', '=', $id)->first();
        if ($city == null) {
            return back();
        }
        $city->delete();

        return redirect()->route('hotels.index');
    }
}
