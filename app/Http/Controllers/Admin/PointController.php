<?php

namespace App\Http\Controllers\Admin;

use App\Point;
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
use App\MainSetting;

class PointController extends Controller
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
        $settings = MainSetting::where('key','=','point_value')->get();
        return view ('admin.points.index')->with(compact('settings'));
    }
    public function index_post(Request $request){
        $point_value = MainSetting::where('key','=','point_value')->get()->first();
        $point_value->value = $request->input('point_value');
        $point_value->save();
        return redirect()->back();
    }

    public function data($controller = false){

        $points = Point::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $points->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($points)
        ->addColumn('user_id', function (Point $point){
            return $point->user->id;
        })
        ->addColumn('points', function (Point $point){
            return $point->points;
        })
        ->addColumn('order_value', function (Point $point){
            return $point->total;
        })
        ->addColumn('order_id', function (Point $point){
            return $point->order_id;
        })
        ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $dbCity = Point::get();
        // $cities = [];
        // $this->getCities($dbCity, $cities);
        $countries = Country::all();
        $states = State::all();

        return view('admin.points.create', compact('countries', 'states'));
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
            'fuel'    => 'required',
            'post'    => 'required',
            'vat'    => 'required',
            'cod'    => 'required',
        ]);

        $shipping = new Point();
        $shipping->name   = $request->name;
        $shipping->fuel   = $request->fuel;
        $shipping->post   = $request->post;
        $shipping->vat   = $request->vat;
        $shipping->cod   = $request->cod;
        $shipping->save();
        $logPayload = ['msg' => 'Shipping Company Added', 'model_id' => $shipping->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.points.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point, $id)
    {

        $countries = Country::all();
        $states = State::all();
        $row = Point::find($id);
        return view('admin.points.edit', compact('countries', 'states', 'row'));

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
        $shipping =  Point::find($id);

        $this->validate($request,[
            'name'          => 'required',
            'fuel'    => 'required',
            'post'    => 'required',
            'vat'    => 'required',
            'cod'    => 'required',
        ]);

        $shipping->name = $request->name;
        $shipping->fuel   = $request->fuel;
        $shipping->post   = $request->post;
        $shipping->vat   = $request->vat;
        $shipping->cod   = $request->cod;
        $shipping->save();


        $logPayload = ['msg' => 'Company Updated', 'model_id' => $shipping->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.points.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point,$id)
    {
        $point = Point::find($id);
        $point->delete();
        return redirect()->route('admin.points.index');
    }
}

