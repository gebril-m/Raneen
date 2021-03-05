<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Product;
use App\Review;
class HomeController extends Controller
{
    public function index(){
    	$orders = Order::where('status_id','=','1')->get();
    	$total_orders = Order::all();
    	$users = User::where('is_admin','=',0)->get();
    	$products = Product::all();
    	$reviews = Review::orderBy('id','desc')->limit(5)->get();
    	$orders_recent = Order::orderBy('id','desc')->limit(11)->get();
    	
    	
        return view('admin.index')->with(compact('users','orders','total_orders','products','reviews','orders_recent'));
    }
}
