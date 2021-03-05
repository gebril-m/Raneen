<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;
use Auth;
use App\User;
class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index()
    {
        //
        $my_id = Auth::user()->id;
        $complaints = Complaint::where('to','=',$my_id)->orWhere('from','=',$my_id)->orderby('id','desc')->get();
        return view('website.users.complaint')->with(compact('complaints'));
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
        $from = Auth::user()->id;
        $to = User::where('is_admin','=',1)->orderBy('id','asc')->get()->first()->id;
        $title = $request->input('title');
        $body = $request->input('body');
        $check_exist = Complaint::where('from','=',$from)->where('to','=',$to)->where('title','=',$title)->where('body','=',$body)->get()->first();
        if(!$check_exist){
            $complaint = new Complaint;
            $complaint->from = $from;
            $complaint->to = $to;
            $complaint->title = $title;
            $complaint->body = $body;
            $complaint->save();
        }
        $my_id = Auth::user()->id;
        $complaints = Complaint::where('to','=',$my_id)->orWhere('from','=',$my_id)->get();
        return view('website.users.complaint')->with(compact('complaints'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
