<?php

namespace App\Http\Controllers\Admin;

use App\ShippingZone;
use App\ShippingCompany;
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

class ShippingZoneController extends Controller
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
        return view ('admin.shipping-zones.index');
    }

    public function data($controller = false){

        $zones = ShippingZone::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $zones->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($zones)
        ->addColumn('zone_name', function (ShippingZone $zone){
            return $zone->zone_name;
        })
        // ->addColumn('areas', function (ShippingZone $zone){
        //     return $zone->get_areas();
        // })
        ->addColumn('first_kg', function (ShippingZone $zone){
            return $zone->first_kg;
        })
        ->addColumn('additional_kg', function (ShippingZone $zone){
            return $zone->additional_kg;
        })
        ->addColumn('company_id', function (ShippingZone $zone){
            return $zone->company->name;
        })
        ->addColumn('options', function (ShippingZone $zone){

            $back = "";
            # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
            $back .= '&nbsp;<a href="'. route('admin.shipping_zones.edit', $zone->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

            $back .= \Form::open(['url'=>route('admin.shipping_zones.destroy', $zone->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
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
        // $dbCity = ShippingZone::get();
        // $cities = [];
        // $this->getCities($dbCity, $cities);
        $companies = ShippingCompany::all();
        $areas = State::all();

        return view('admin.shipping-zones.create', compact('companies', 'areas'));
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
            'zone_name'          => 'required',
            'first_kg'    => 'required',
            'additional_kg'    => 'required',
            'areas'    => 'required',
            'company_id'    => 'required',
        ]);

        $shipping = new ShippingZone();
        $shipping->zone_name   = $request->zone_name;
        $shipping->first_kg   = $request->first_kg;
        $shipping->additional_kg   = $request->additional_kg;
        $shipping->areas   = json_encode($request->areas);
        $shipping->company_id   = $request->company_id;
        $shipping->cod_values   = $request->cod_values ? $request->cod_values : 0;
        $shipping->save();
        $logPayload = ['msg' => 'Zone Added', 'model_id' => $shipping->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.shipping_zones.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingZone $zone, $id)
    {

        $companies = ShippingCompany::all();
        $areas = State::all();
        $row = ShippingZone::find($id);
        return view('admin.shipping-zones.edit', compact('companies', 'areas', 'row'));

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
        $shipping =  ShippingZone::find($id);

        $this->validate($request,[
            'zone_name'          => 'required',
            'first_kg'    => 'required',
            'additional_kg'    => 'required',
            'areas'    => 'required',
            'company_id'    => 'required',
        ]);

        $shipping->zone_name   = $request->zone_name;
        $shipping->first_kg   = $request->first_kg;
        $shipping->additional_kg   = $request->additional_kg;
        $shipping->areas   = json_encode($request->areas);
        $shipping->company_id   = $request->company_id;
        $shipping->cod_values   = $request->cod_values;
        $shipping->cod_values   = $request->cod_values ? $request->cod_values : 0;
        $shipping->save();


        $logPayload = ['msg' => 'Zone Updated', 'model_id' => $shipping->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.shipping_zones.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingZone $zone,$id)
    {
        $company = ShippingZone::find($id);
        $company->delete();
        return redirect()->route('admin.shipping_zones.index');
    }
}

