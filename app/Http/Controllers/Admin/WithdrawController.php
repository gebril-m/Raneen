<?php

namespace App\Http\Controllers\Admin;

use App\InventoryProduct;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Attribute;
use App\CountryTranslation;
use App\CityTranslation;
use function foo\func;
use App\Wallet;
use App\Withdraw;

class WithdrawController extends Controller
{

    public function index()
    {
        $withdraws = Withdraw::orderBy('id','desc')->get();
        return view('admin.withdraws.index', compact('withdraws'));
    }
}
