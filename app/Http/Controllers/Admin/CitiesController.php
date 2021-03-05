<?php

namespace App\Http\Controllers\Admin;

use App\CityTranslation;
use App\Country;
use App\Language;
use App\Page;
use App\City;
use App\Rules\UniqueCity;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use DataTables;
use Spatie\Permission\Models\Role;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
        return view ('admin.cities.index');
    }

    public function data($controller = false){

        $cities = City::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $cities->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($cities)
        ->addColumn('country', function (City $city){
            return $city->country->name;
        })
        ->addColumn('options', function (City $city){

            $back = "";
            # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
            $back .= '&nbsp;<a href="'. route('admin.cities.edit', $city->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

            $back .= \Form::open(['url'=>route('admin.cities.destroy', $city->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
            $back .= method_field('DELETE');
            $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
            $back .= \Form::close();

            return $back;

        })->rawColumns(['options'])
        ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $dbCity = City::get();
        // $cities = [];
        // $this->getCities($dbCity, $cities);
        $countries = Country::all();
        $states = State::all();

        return view('admin.cities.create', compact('countries', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'          => 'required',
            'country_id'    => 'required|max:15|exists:countries,id',
        ]);

        $city = new City();
        $city->country_id   = $request->country_id;
        $city->save();

        foreach($this->languages as $local){
            $cityTrans = new CityTranslation();
            $cityTrans->city_id = $city->id;
            $cityTrans->name = $request->input('name.'.$local->locale);

//            $cityTrans->meta_title = $request->input('meta_title.'.$local->locale);
//            $cityTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
//            $cityTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $cityTrans->locale = $local->locale;
            $cityTrans->save();
        }
        $logPayload = ['msg' => 'City Added', 'model_id' => $city->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.cities.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {

        $countries = Country::all();
        $states = State::all();
        $row = $city;

        return view('admin.cities.edit', compact('countries', 'states', 'row'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city =  City::find($id);

        $this->validate($request,[
            'name'          => 'required',
            'country_id'    => 'required|max:15|exists:countries,id',
        ]);

        $city->country_id = $request->country_id;
        $city->save();


        foreach($this->languages as $local){
            $cityTrans = CityTranslation::where([
                'city_id' => $city->id,
                'locale' => $local->locale,
            ])->first();
            if (!$cityTrans) $cityTrans = new CityTranslation();
            $cityTrans->city_id = $city->id;
            $cityTrans->name = $request->input('name.'.$local->locale);
            $cityTrans->locale = $local->locale;
            $cityTrans->save();
        }
        $logPayload = ['msg' => 'City Updated', 'model_id' => $city->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.cities.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index');
    }
}
