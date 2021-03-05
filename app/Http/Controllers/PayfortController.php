<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

class PayfortController extends Controller
{
    public function getToken(Request $request){
        $payfort = new \App\Helpers\Payment\Payfort();
        return $payfort->token();
    }
    public function getOperation(Request $request){
        $payfort = new \App\Helpers\Payment\Payfort();
        return $payfort->operation();
    }
    public function getOrderSession(Request $request){
        session()->put('orderData',$request->all());
        return response()->json(['status'=>200]);

    }
    public function finish(Request $request){
        $data = session()->get('orderData');
        return redirect()->route('payfortSave',$data);
    }
    public function save(CheckoutRequest $request){
        app('App\Http\Controllers\CheckoutController')->checkout($request);
        return redirect()->route('web.order.success')->with('orderId', session()->get('orderId'));

    }

}
