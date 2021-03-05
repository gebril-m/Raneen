<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\LocationTranslation;
use App\Language;
use App\Page;
use App\Location;
use App\Rules\UniqueLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;

class LocationsController extends Controller
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
        return view ('admin.locations.index');
    }

    public function data($controller = false){

        $locations = Location::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $locations->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($locations)
            ->addColumn('location', function (Location $location){
                return $location->location;
            })
            ->addColumn('city', function (Location $location){
                return $location->city ? $location->city->name : 0;
            })
            ->addColumn('options', function (Location $location){

                $back = "";
                # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
                $back .= '&nbsp;<a href="'. route('admin.locations.edit', $location->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

                $back .= \Form::open(['url'=>route('admin.locations.destroy', $location->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
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
        // $dbLocation = Location::get();
        // $location = [];
        // $this->getLocations($dbLocation, $location);

        $cities = City::all();
        return view('admin.locations.create', compact('cities'));
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
            'city_id'    => 'required',
            'location.*'    => 'required',
        ]);

        $location = new Location();
        $location->city_id = $request->city_id;
        $location->save();

        foreach($this->languages as $local){
            $locationTrans = new LocationTranslation();
            $locationTrans->location_id = $location->id;
            $locationTrans->location = $request->input('location.'.$local->locale);

            $locationTrans->locale = $local->locale;
            $locationTrans->save();
        }
        $logPayload = ['msg' => 'Location Added', 'model_id' => $location->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);      
        return redirect()->route('admin.locations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $location = Location::findOrFail($id);
        return [
            'status'=>200,
            'data'  => $location
        ];
    }

    // or

    // public function show(Location $location)
    // {
    //     return [
    //         'status'=>200,
    //         'data'=> $location
    //     ];
    // }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {

        $cities = City::all();
        $row = $location;

        return view('admin.locations.edit', compact('cities', 'row'));

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
        $location =  Location::find($id);

        $this->validate($request,[
            'city_id'    => 'required',
            'location.*'    => 'required',
        ]);

        $location->city_id = $request->city_id;
        $location->save();

        foreach($this->languages as $local){
            $locationTrans = LocationTranslation::where([
                'location_id' => $location->id,
                'locale' => $local->locale,
            ])->first();
            if (!$locationTrans) $locationTrans = new LocationTranslation();
            $locationTrans->location_id = $location->id;
            $locationTrans->location = $request->input('location.'.$local->locale);
            $locationTrans->save();
        }
        $logPayload = ['msg' => 'Location Updated', 'model_id' => $location->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);      
        return redirect()->route('admin.locations.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('admin.locations.index');
    }
}
