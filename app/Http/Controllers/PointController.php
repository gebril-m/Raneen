<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Auth;
use App\MainSetting;
use App\Wallet;
class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $uid = Auth::user()->id;
        $points = Point::where('user_id','=',$uid)->get();
        $points_value = MainSetting::where('key','=','point_value')->get()->first();
        $money = $points->sum('points')*$points_value->value;
        return view('website.users.points')->with(compact('points','money'));
    }
    public function convert_points(){
        $uid = Auth::user()->id;
        $points = Point::where('user_id','=',$uid)->get();

        $points_value = MainSetting::where('key','=','point_value')->get()->first();
        $money = $points->sum('points')*$points_value->value;
        $wallet = new Wallet;
        $wallet->user_id = $uid;
        $wallet->amount = $money;

        $wallet->notes = "Convert ".$points->sum('points')." Points";
        $wallet->save();
        foreach($points as $point){
            $point->delete();
        }
        return redirect()->back()->with(['message'=>'Your Points Has Been Successfully Converted']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        //
    }
}
