<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

class DataController extends Controller
{

    function getCitiesByCountryId (Request $request){
        $countryId = $request->country_id;
        $cities = City::where('country_id', $countryId)->pluck('name', 'id');
        return view('snippets.cities')->with(compact('cities'));
    }

}
