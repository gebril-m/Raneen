<?php

namespace App\Http\Controllers;

use App\ReturnReason;
use Illuminate\Http\Request;
use Auth;
use App\OrderProduct;
use App\Withdraw;
class ReturnReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function return_request(Request $request, $product, $order, $reason, $bank_name, $bank_number){
        $check = OrderProduct::where('product_id','=',$product)->where('order_id','=',$order)->get()->first();
        if($check){
            $check->is_return = 1;
            $check->return_reason_id = $reason;
            $check->return_date = now();
            if($bank_name != 0){
                $check->return_bank = 1;
            }else{
                $check->return_bank = 0;
            }
            $check->save();
            if($bank_name != 0){
                $withdraw = new Withdraw;
                $withdraw->user_id = Auth::user()->id;
                $withdraw->amount = $check->price_after;
                $withdraw->bank_name = $bank_name;
                $withdraw->bank_number = $bank_number;
                $withdraw->notes = "Withdraw product #".$product." in order #".$order." Amount: ".$check->price_after;
                $withdraw->status = "New";
                $withdraw->order_line_id = $check->id;
                $withdraw->save();
            }
            return "true";
        }else{
            return "false";
        }
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
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnReason $returnReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnReason $returnReason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturnReason $returnReason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnReason $returnReason)
    {
        //
    }
}
