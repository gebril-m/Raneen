<?php

namespace App\Http\Controllers\Admin;

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

class ShippingCompanyController extends Controller
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
        return view ('admin.shipping-companies.index');
    }

    public function data($controller = false){

        $companies = ShippingCompany::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $companies->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($companies)
        ->addColumn('name', function (ShippingCompany $company){
            return $company->name;
        })
        ->addColumn('fuel', function (ShippingCompany $company){
            return $company->fuel;
        })
        ->addColumn('post', function (ShippingCompany $company){
            return $company->post;
        })
        ->addColumn('vat', function (ShippingCompany $company){
            return $company->vat;
        })
        ->addColumn('cod', function (ShippingCompany $company){
            return $company->cod;
        })
        ->addColumn('first_kg_number', function (ShippingCompany $company){
            return $company->first_kg_number;
        })
        ->addColumn('options', function (ShippingCompany $company){

            $back = "";
            # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
            $back .= '&nbsp;<a href="'. route('admin.shipping_companies.edit', $company->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

            $back .= \Form::open(['url'=>route('admin.shipping_companies.destroy', $company->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
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
        // $dbCity = ShippingCompany::get();
        // $cities = [];
        // $this->getCities($dbCity, $cities);
        $countries = Country::all();
        $states = State::all();

        return view('admin.shipping-companies.create', compact('countries', 'states'));
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
        ]);

        $shipping = new ShippingCompany();
        $shipping->name   = $request->name;
        $shipping->fuel   = $request->fuel ? $request->fuel : 0;
        $shipping->post   = $request->post ? $request->post : 0;
        $shipping->vat   = $request->vat ? $request->vat : 0;
        $shipping->cod   = $request->cod ? $request->cod : 0;
        $shipping->first_kg_number   = $request->first_kg_number ? $request->first_kg_number : 0;
        $shipping->save();
        $logPayload = ['msg' => 'Shipping Company Added', 'model_id' => $shipping->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.shipping_companies.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCompany $company, $id)
    {

        $countries = Country::all();
        $states = State::all();
        $row = ShippingCompany::find($id);
        return view('admin.shipping-companies.edit', compact('countries', 'states', 'row'));

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
        $shipping =  ShippingCompany::find($id);

        $this->validate($request,[
            'name'          => 'required',
        ]);

        $shipping->name = $request->name;
        $shipping->fuel   = $request->fuel ? $request->fuel : 0;
        $shipping->post   = $request->post ? $request->post : 0;
        $shipping->vat   = $request->vat ? $request->vat : 0;
        $shipping->cod   = $request->cod ? $request->cod : 0;
        $shipping->first_kg_number   = $request->first_kg_number ? $request->first_kg_number : 0;
        $shipping->save();


        $logPayload = ['msg' => 'Company Updated', 'model_id' => $shipping->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.shipping_companies.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingCompany $company,$id)
    {
        $company = ShippingCompany::find($id);
        $company->delete();
        return redirect()->route('admin.shipping_companies.index');
    }
}

