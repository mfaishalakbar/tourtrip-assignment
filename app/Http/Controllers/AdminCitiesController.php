<?php

namespace App\Http\Controllers;

use App\DataTables\CityDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\City;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class AdminCitiesController extends Controller
{
    public function index(Request $request, CityDataTable $dataTable)
    {
        if($request->user()->cannot('city:browse')) {
            return redirect()->route('dashboard');
        }

        return $dataTable->render('pages.admin.cities.index');
    }

    public function add(Request $request) {
        if($request->user()->cannot('city:add')) {
            return redirect()->route('dashboard');
        }

        return view('pages.admin.cities.add');
    }

    public function submitAdd(Request $request) {
        if($request->user()->cannot('city:add')) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'country' => 'required',
            'image_url' => 'required',
        ]);

        City::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'country' => $request->get('country'),
            'image_url' => $request->get('image_url'),
        ]);
        return redirect()->route('cities.index');
    }

    public function edit(Request $request, string $id) {
        if($request->user()->cannot('city:edit')) {
            return redirect()->route('dashboard');
        }

        $city = City::where('id', '=', $id)->first();
        if ($city == null) {
            return back();
        }

        return view('pages.admin.cities.edit', ['data' => $city]);
    }

    public function submitEdit(Request $request, string $id) {
        if($request->user()->cannot('city:edit')) {
            return redirect()->route('dashboard');
        }

        $city = City::where('id', '=', $id)->first();
        if ($city == null) {
            return back();
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'country' => 'required',
            'image_url' => 'required',
        ]);

        $city->name = $request->get('name');
        $city->description = $request->get('description');
        $city->country = $request->get('country');
        $city->image_url = $request->get('image_url');
        $city->save();

        return redirect()->route('cities.index');
    }

    public function delete(Request $request, string $id) {
        if($request->user()->cannot('city:delete')) {
            return back();
        }

        $city = City::where('id', '=', $id)->first();
        if ($city == null) {
            return back();
        }
        $city->delete();

        return redirect()->route('cities.index');
    }
}
