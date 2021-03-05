<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cupon;
use App\CuponLog;
use App\Product;
use Auth;
use App\ProductCategory;
class CuponsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function applyCupon($cuponCode){

        return $this->checkCupon( $cuponCode );

    }

    public function checkCupon($cuponCode){

        $cupon = Cupon::where('code', $cuponCode)->first();
        $errorFlag = 0;
        $usersCupons = CuponLog::where('user_id',Auth::user()->id)->where('cupon',$cuponCode)->count();



        # check if exist
        if(empty($cupon))
            return redirect()->back()->with('message', 'cupon not exists');

        # check date
        if($cupon->end->isPast())
            return redirect()->back()->with('message', 'cupon is expired');
        if($cupon->start > now())
            return redirect()->back()->with('message', 'Cupon will start soon');
        # check cupon usages
        if(!$this->isCuponUsable($cupon))
            return redirect()->back()->with('message', 'cupon max usages reached');

        if($usersCupons >= $cupon->user_usage_times)
            return redirect()->back()->with('message', 'You used This Cupon before');

        $cart = $this->getCart();
        $cartProductsTotalPrice = Product::whereIn('id', array_keys($cart))->pluck('price')->sum();

        if( $cupon->min_order >= $cartProductsTotalPrice )
            return redirect()->back()->with('message', 'minimum value is (' . $cupon->min_order . ') for this cupon');


        $cuponCategories = $cupon->categories()->get();
        $cuponProducts = $cupon->products()->get();
        $cuponProductsIds = $cuponProducts->pluck('id')->toArray();
        # loop in cart
        # check if it has the products that the cupon provide
        $f = 0;
        $productsTotalCounter = 0;
        foreach($cart as $ck => $cv){

            if(count($cuponCategories) == 0 && count($cuponProducts) == 0){
                $product = Product::find($cv[0]['id']);
                if(has_this_cupon($cupon->id,$product->id) && cupon_has_priroty($product->id)){
                        $f = 1;
                        $discountDetails = $this->createDiscount($cupon, $product->price * $cv[0]['quantity']);
                        $cart[$ck][0]['cupon'] = $cupon->code;
                        $cart[$ck][0]['discount'] = $discountDetails['discount'];
                        $cart[$ck][0]['type'] = $discountDetails['type'];
                        $cart[$ck][0]['price_before'] = $discountDetails['price_before'];
                        $cart[$ck][0]['price_after'] = $discountDetails['price_after'];

                }
            }
            if(count($cuponCategories) > 0){
                foreach($cuponCategories as $cuponCategory){
                    $this_product = ProductCategory::where('product_id','=',$cv[0]['id'])->where('category_id','=',$cuponCategory->id)->get()->first();
                    if($this_product){
                        $product = Product::find($this_product->product_id);

                        if(has_this_cupon($cupon->id,$product->id) && cupon_has_priroty($product->id)){
                                $f = 1;
                                $discountDetails = $this->createDiscount($cupon, $product->price * $cv[0]['quantity']);
                                $cart[$ck][0]['cupon'] = $cupon->code;
                                $cart[$ck][0]['discount'] = $discountDetails['discount'];
                                $cart[$ck][0]['type'] = $discountDetails['type'];
                                $cart[$ck][0]['price_before'] = $discountDetails['price_before'];
                                $cart[$ck][0]['price_after'] = $discountDetails['price_after'];

                        }
                    }
                }
            }
            if(count($cuponProducts) > 0){
                foreach($cuponProducts as $cuponProduct){
                   // dd($cuponProduct->id);
                    if($cv[0]['id'] == $cuponProduct->id){

                        if(has_this_cupon($cupon->id,$cuponProduct->id) && cupon_has_priroty($cuponProduct->id)){
                                $f = 1;
                                $discountDetails = $this->createDiscount($cupon, $cuponProduct->price * $cv[0]['quantity']);
                                $cart[$ck][0]['cupon'] = $cupon->code;
                                $cart[$ck][0]['discount'] = $discountDetails['discount'];
                                $cart[$ck][0]['type'] = $discountDetails['type'];
                                $cart[$ck][0]['price_before'] = $discountDetails['price_before'];
                                $cart[$ck][0]['price_after'] = $discountDetails['price_after'];

                        }
                    }
                }
            }
        }
        # update session
        $outPut = [];
        if($f){
            # log used cupon
            session()->forget('products.cart');
            session()->put('products.cart' , $cart);
        } else {

            return redirect()->back()->with('message', 'cupon not provided for this products');
        }
        return redirect()->back()->with('message', 'cupon applied');
    }

    public function getCart(){
        $cart = (session()->has('products.cart')) ? session()->get('products.cart') : [] ;
        return $cart;
    }

    public function createDiscount ($cupon, $originalPrice){
        $outPut = [];
        // coupon use percentage value
        if($cupon->type == 'p'){
            $outPut = [
                'price_before' => $originalPrice,
                'discount' => ($originalPrice*$cupon->amount)/100,
                'type' => $cupon->type,
                // apply the coupon percentage value substraction from the original price
                'price_after' => $originalPrice - ($originalPrice*$cupon->amount)/100
            ];
        // coupon use fixed value
        } else if($cupon->type == 'f'){
            $outPut = [
                'price_before' => $originalPrice,
                'discount' => $cupon->amount,
                'type' => $cupon->type,
                // apply the coupon fixed value substraction from the original price
                'price_after' => $originalPrice - $cupon->amount,
            ];
        }
        return $outPut;
    }

    public function isCuponUsable ($cupon) {

        $allowedUsageTimes = $cupon->usage_times;
        $allowedUserUsageTimes = $cupon->user_usage_times;
        $cuponName = $cupon->name;
        $uid = auth()->user()->id;

        $currentCuponUsages = CuponLog::where('cupon' , $cuponName)->get();
        $currentUserUsages = $currentCuponUsages->where('user_id', $uid)->count();
        $currentCuponUsagesCount = $currentCuponUsages->count();
        $flag = 1;

        # max usages for cupon is limited.
        # or max usage for user is limited.
        if( $currentCuponUsagesCount >= $allowedUsageTimes || $currentUserUsages >= $allowedUserUsageTimes)
            $flag = 0;

        return $flag;

    }

}
