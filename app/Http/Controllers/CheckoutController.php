<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Product;
use App\Country;
use App\City;
use App\State;
use App\Order;
use App\UserDetail;
use App\CuponLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccess;
use App\ReturnReason;
use App\CityTranslation;
use App\Transaction;
use Auth;
use App\ShippingCompany;
use App\ShippingZone;
use Session;
use App\Point;
use Illuminate\Support\Facades\App;
use View;
use App\ProductCategory;
use App\Category;
use App\Wallet;
use App\MainSetting;
use App\OrderStatus;
use App\BundleProduct;
class CheckoutController extends Controller
{

    public function __construct()
    {
        $locale = App::getLocale();
        View::share('locale',$locale);
        session(['url' => '/checkout']);
        $this->middleware('verified');
    }
    public function get_cities($country_id){
      return City::where('country_id','=',$country_id)->get();
    }
    public function show()
    {
        if (Auth::user()) {
            $wallet = Wallet::where('user_id', '=', Auth::user()->id)->get()->sum('amount');
            $points = Point::where('user_id', '=', Auth::user()->id)->get()->sum('points');

            $points_value = MainSetting::where('key', '=', 'point_value')->get()->first();
            $money = $points * $points_value->value;
        } else {
            $wallet = 0;
            $points = 0;
            $money = 0;
        }
        $locale = App::getLocale();
        $cart = (session()->has('products.cart')) ? session()->get('products.cart') : [];


        $productsId = array_keys($cart);
        $productsTotalPrice =0;

        $products = Product::with('translations:id,product_id,name,locale,slug')
            ->whereIn('id', $productsId)
            ->where('stock', '!=', 0)

            ->select('id', 'thumbnail', 'price', 'weight', 'stock')
            ->get();



        if(count($products) == 0){
            return redirect('/'.$locale.'/cart')->with('message','no products');
        }
        $countries = Country::all();
        $cities = City::all();
        $states = State::all();
        $counter = 0;
        $pricesAfterCounter = 0;
        $discountsCounter = 0;
        $weights_counter = 0;
        $categories = [];
        $shipping_total = 0;
        $products = $products->map(function($item) use (&$weights, &$counter, &$pricesAfterCounter, &$discountsCounter, &$cart, &$categories, &$shipping_total){
          $proo=Product::find($item['id']);


            $category = ProductCategory::where('product_id','=',$item['id'])->get()->first();
            $category_details = Category::find($category->category_id);
            if(!in_array($category->category_id,$categories)){
                $shipping_total = (int)$shipping_total+$category_details->shipping_value;
                array_push($categories,$category->category_id);
            }else{
                if($category_details->shipping_type == 0){
                    $shipping_total = (int)$shipping_total+$category_details->shipping_value;
                }
            }
                   //dd($cart[$item['id']][0]['quantity']);
                    if ($cart[$item['id']][0]['quantity'] > $item['stock']) {
                        $qty = $item['stock'];
                    } else {
                        $qty = $cart[$item['id']][0]['quantity'];
                    }
                    $outPut = [];
                    $outPut['id'] = $item['id'];
                    $outPut['url'] = $item['url'];
                    $outPut['name'] = $item['name'];
                    $outPut['slug'] = $item['slug'];
                    $outPut['thumbnail'] = $item['thumbnail'];
                    $outPut['description'] = $item['description'];
                    $outPut['attribute'] = $cart[$item['id']][0]['attributes'];
                    $outPut['quantity'] = $qty;
                    $outPut['price'] = (float)str_replace(',', '', $proo->getFinalPriceAfterDiscountPriroty()) * $outPut['quantity'];
                    $outPut['discount'] = (isset($cart[$item['id']][0]['discount'])) ? $cart[$item['id']][0]['discount'] : 0;
                    $outPut['weight'] = $item['weight'] * $qty;
                    /**
                     * price after applying the discount
                     * if the price_after key exists then we use it (it already multiplied with quantity when we applied the cupon earlier)
                     * otherwise we use original price multiplied with the quantity
                     */
                    if (isset($cart[$item['id']][0]['price_after'])) {
                        $outPut['price_after'] = (isset($cart[$item['id']][0]['price_after']) && $cart[$item['id']][0]['price_after'] != 0) ? $cart[$item['id']][0]['price_after'] : $outPut['price'];
                        $counter = $counter + $outPut['price'];
                    } elseif (isset($cart[$item['id']][0]['discount']) && $cart[$item['id']][0]['discount'] != 0) {
                        $outPut['price_after'] = $outPut['price'];
                        $counter = $counter + $outPut['price'] + $cart[$item['id']][0]['discount'];
                    } else {
                        $outPut['price_after'] = $outPut['price'];
                        $counter = $counter + $outPut['price'];
                    }
                    // total the original prices
                    //dd($outPut['price']+$cart[$item['id']][0]['discount']);
                    //$counter = $counter+($outPut['price']+$cart[$item['id']][0]['discount'])*$qty;
                    if (is_numeric($cart[$item['id']][0]['discount']))
                        $discountsCounter += $cart[$item['id']][0]['discount'] * $qty;

                    $weights += $outPut['weight'];
                    // total of the prices after applying the discount
                    $pricesAfterCounter = $pricesAfterCounter + (float)$outPut['price_after'];
                    // total discounts
                    return $outPut;


        })->all();
        $total_shipping = 0;
        $user = [];
        if(auth()->check()){
            $uid = auth()->user()->id;
            $user = UserDetail::where('user_id', '=', $uid)->first();
            // Shipping Zone Checker
            $shipping_zone = Shippingzone::all();

            if(!$user){
                return redirect('/'.$locale.'/user/profile/'.$uid)->with('message','state_change');
            }else{
                if((int)$user->state < 1){
                    return redirect('/'.$locale.'/user/profile/'.$uid)->with('message','state_change');
                }
            }

            // Code Below will use it in Backend in future
            // if(!$user){
            //     return redirect('/'.$locale.'/user/profile/'.$uid)->with('message','state_change');
            // }else{
            //     if((int)$user->state < 1){
            //         return redirect('/'.$locale.'/user/profile/'.$uid)->with('message','state_change');
            //     }
            //     foreach($shipping_zone as $zone){
            //         if(in_array($user->state,json_decode($zone->areas))){
            //             $zone_id = $zone->id;
            //             $first_kg = $zone->first_kg;
            //             $additional_kg = $zone->additional_kg;
            //             $company_id = $zone->company_id;
            //             $company = ShippingCompany::find($company_id);
            //             $first_kg_number = $company->first_kg_number;
            //             $cod_values = explode(',',$zone->cod_values);


            //             $adds_kgs = $first_kg_number-(int)$weights;
            //             $adds_kgs = str_replace('-','',$adds_kgs);
            //             if((int)$weights > $first_kg_number){
            //                 $total_shipping += (int)$first_kg;
            //                 $total_shipping += $adds_kgs*$additional_kg;
            //             }
            //         }
            //     }
            //     // Shipping Properties Checker
            //     if($company_id){
            //         $fuel = $company->fuel;
            //         $post = $company->post;
            //         $vat = $company->vat;
            //         $cod = $company->cod;
            //     }

            //     // COD Values Checker
            //     if($cod){
            //         $selected_cod = 0;
            //         $cods = explode(',',$cod);
            //         $i=0;
            //         foreach($cods as $item){
            //             if($item <= $counter){
            //                 $selected_cod = $i;
            //             }
            //             $i++;
            //         }
            //     }
            //     if(isset($selected_cod)){
            //         $cod = $cod_values[$selected_cod];
            //         if(strpos($cod,'%') !== false){
            //             $total_shipping += $counter*str_replace('%','',$cod)/100;
            //         }else{
            //             $total_shipping += $cod;
            //         }
            //     }

            //     if($fuel){
            //         $total_shipping += $total_shipping*$fuel/100;
            //     }
            //     if($post){
            //         $total_shipping += $total_shipping*$post/100;
            //     }
            //     if($vat){
            //         $total_shipping += $total_shipping*$vat/100;
            //     }
            //     $nproducts['company_id'] = $company_id;
            //     $nproducts['zone_id'] = $zone_id;
            //     $nproducts['totalShipping'] = $total_shipping;
            // }
            $main_settings = MainSetting::where('key','=','free_shipping')->get()->first();
            if($main_settings){
                $main_settings = $main_settings->value;
            }
            $nproducts['totalPrice'] = $counter;
            if($nproducts['totalPrice'] >= $main_settings){
              $nproducts['totalShipping'] = 0;
            }else{
              $nproducts['totalShipping'] = $shipping_total;
            }
            $nproducts['cartProducts'] = $products;
            // use this amount in payment process >>
            $nproducts['totalPriceAfter'] = $pricesAfterCounter;
            $nproducts['totalDiscounts'] = $discountsCounter;
            //dd($counter);
        }else{

            return redirect('/'.$locale.'/login');
        }


            $totalCheckoutPrice = $this->getCartData()['totalPrice'];

            $totalCheckoutDiscount = 0;

            foreach($this->getCartData()['cartProducts'] as $key=> $cart_product_value){
                if(isset($cart_product_value['discount'])){
                //dd($cart_product_value);
                  $totalCheckoutDiscount += $cart_product_value['discount'] * $cart_product_value['quantity'];
                }
            }

            $cartDetails = session()->get('products.cart');

            $cartDetails_counter = 0;
            if ($cartDetails)
            foreach ($cartDetails as $c){
                $cartDetails_counter += $c[0]['quantity'] ? $c[0]['quantity'] : 1 ;
            }

        // return view('checkout.form')->with( compact('user', 'nproducts', 'countries', 'cities'));
        return view('website.users.checkout')->with( compact('user', 'nproducts','cartDetails_counter', 'countries', 'cities','states','wallet','points','money','totalCheckoutPrice','totalCheckoutDiscount'));
    }

    function getCartData(){
        $cart = (session()->has('products.cart')) ? session()->get('products.cart') : [] ;
        $products = Product::with('translations:id,product_id,name,locale,slug')
                    ->whereIn('id', array_keys($cart))
                    ->select('id', 'thumbnail', 'price', 'stock','before_price','is_bundle','bundle_image')
                    ->get();

        $counter = 0;
        $products = $products->map(function($item) use (&$counter, &$cart){
            if($cart[$item['id']][0]['quantity'] > $item['stock']){
                $qty = $item['stock'];
            }else{
                $qty = $cart[$item['id']][0]['quantity'];
            }
            if(isset($cart[$item['id']][0]['type']) && $cart[$item['id']][0]['type'] == 'combo'){
                if(isset($cart[$item['id']][0]['discount'])){
                    $price = $item['price']*$cart[$item['id']][0]['discount']/100;
                }else{
                    $price = isset($cart[$item['id']][0]['price_after']) && $cart[$item['id']][0]['price_after'] != 0 ? $cart[$item['id']][0]['price_after'] : $item['product_price'];
                }
            }else{
            //dd($cart[$item['id']]);
                $price = 1;
                if(isset($cart[$item['id']][0]['discount'])){
                    $price = $item['price'];//$cart[$item['id']][0]['price'];
                }else{
                    $price =$item['price']; #isset($cart[$item['id']][0]['price_after']) && $cart[$item['id']][0]['price_after'] != 0 ? $cart[$item['id']][0]['price_after'] : $item['product_price'];
                }
            }
            $outPut = [];
            $outPut['id'] = $item['id'];
            $outPut['attrs_details'] = $item->get_attr($cart[$item['id']][0]['attributes']);
            $outPut['url'] = $item['url'];
            $outPut['name'] = $item['name'];
            $outPut['before_price'] = $item['before_price'];
            $outPut['stock'] = $item['stock'];
            $outPut['slug'] = $item['slug'];
            $outPut['price'] = (float) str_replace(',', '', $price);
            if ($item['is_bundle']==1) {
                $outPut['thumbnail'] = image('product', $item['bundle_image']);
                //dd($item['bundle_image']);
            }else{
                $outPut['thumbnail'] = $item->thumbnail_url;
            }
            $outPut['description'] = $item['description'];
            $outPut['attribute'] = $cart[$item['id']][0]['attributes'];
            if (isset( $cart[$item['id']][0]['discount'] ) && $cart[$item['id']][0]['discount'] > 0) {
                $outPut['discount'] = $cart[$item['id']][0]['discount'];
            }
            $_quantity = $cart[$item['id']][0]['quantity'] ? $cart[$item['id']][0]['quantity'] : 1;
            $outPut['quantity'] = $_quantity;

            // dd($outPut['price']);
              $counter += $outPut['price'] * $_quantity;
            //dd($_quantity);
            return $outPut;
        })->all();

        $nproducts['cartProducts'] = $products;
        $nproducts['totalPrice'] = $counter." ".__('product.currency');
        session()->put('cart.totalPrice',$counter);
        return $nproducts;
    }

    public function checkout(CheckoutRequest $request){
           $user = auth()->user();
           $products = $this->getCart();


           $pIds = [];
           $pInfo = [];
           $total = 0;
           $totalPoints = 0;

           foreach($products as $product){


              if ($product['is_bundle'] == 1){

                $bundleProducts = BundleProduct::where('bundle_id',$product['id'])->get(); //get the products related to that bundle

                $productsStockUpdated = $bundleProducts->map(function ($item) use ($product) {

                    $bundleElement = Product::where('id',$item['product_id'])->first();

                    if($bundleElement->stock < $item['quantity'] * $product['quantity']){
                      return back()->with('message', 'Out of Stock');
                    }

                    $bundleElement->stock -= $item['quantity'] * $product['quantity'];
                    $bundleElement->save();
                    return $bundleElement;

                });

                $pIds[] = $product['id'];
                $pInfo[] = [

                   'price' => isset($product['product_price']) ? $product['product_price'] : $product['price'],
                   'quantity' => $product['quantity'],
                   'total' => $product['total'],
                   'discount' => $product['discount'],
                   'price_after' => $product['price_after'],
                   'discount_type' => $product['discount_type'],
                   'cupon' => $product['cupon'],
                   'reward_points' => 0
               ];




              }
              else{


              if((isset($product['discount']) && $product['discount'] != 0) && ($product['total'] == $product['price_after'])){
                $price_after = $product['price']*$product['quantity'];
              }else{
                $price_after = $product['price_after'];
              }
               $db_product = Product::find($product['id']);
               if ($db_product->stock < $product['quantity']) throw new \Exception(sprintf("Product %d, %s has quantity %d but you asked for %s!", $db_product->id, $db_product->name, $db_product->stock, $product['quantity']));

               $pIds[] = $product['id'];
               if(!empty($db_product->reward_points)){
                $totalPoints = (int)$db_product['reward_points'] * $product['quantity'];
               }
               $pInfo[] = [
                   'attribute_id' => $product['attribute'],
                   'price' => isset($product['product_price']) ? $product['product_price'] : $product['price'],
                   'quantity' => $product['quantity'],
                   'total' => $product['total'],
                   'discount' => $product['discount'],
                   'price_after' => $price_after,
                   'discount_type' => $product['discount_type'],
                   'cupon' => $product['cupon'],
                   'reward_points' => $totalPoints
               ];

               # Decrease products by the quantity
               # Product::where('id', $product['id'])->decrement('stock', $product['quantity']);
                  if($db_product->is_bundle == 0){ // to stop decrementing the stock of the bundle itself
                      $db_product->decrement('stock', $product['quantity']);
                  }

               $total += $product['price_after'];
           }
         }
           $productFinal = array_combine($pIds, $pInfo);

           # add order
           $request->merge(['user_id'=>$user->id]);
           // dd($productFinal);
           // dd($request->all());
           $order = Order::create( $request->all() );
           $order_find = Order::find($order->id);
        //    $order_find->zone_id = $request->input('zone_id');
        //    $order_find->company_id = $request->input('company_id');
           $order_find->shipping_amount = $request->input('shipping_amount');
           $order_find->save();
           # assign products
           //dd($productFinal);
           foreach ($productFinal as $key => $pro) {
             if ($productFinal[$key]['discount']=='') {
                $productFinal[$key]['discount']=0.00;
             }
           }
            //dd($productFinal);
           $order->products()->sync($productFinal);

           $transaction = new Transaction;
           $transaction->user_id = Auth::user()->id;

           if($request->input('radio1') == 'cod'){
                $transaction->payment_type = "Cash On Delivery";
            }elseif($request->input('radio1') == 'wallet'){
                $transaction->payment_type = "Wallet";
            }else{
                $transaction->payment_type = "Credit Card";
            }
           $transaction->order_id = $order->id;
           $transaction->amount = $total+$request->input('shipping_amount');


           if(isset($request->location_id)){
                $transaction->inventory_id=(int)$request->location_id;
           }else{
                $transaction->shipping_to_home=1;
           }

           $transaction->save();
           if($request->input('radio1') == 'wallet'){
               $wallet_action = new Wallet;
               $wallet_action->user_id = Auth::user()->id;
               $wallet_action->amount = "-".($total+$request->input('shipping_amount'));
               $wallet_action->order_id = $order->id;
               $wallet_action->notes = "Purchase Order #".$order->id;
               $wallet_action->save();
           }
           elseif ($request->input('radio1') == 'credit'){

           }


//           if($totalPoints != 0){
//            $points = new Point;
//            $points->user_id = Auth::user()->id;
//            $points->points = $totalPoints;
//            $points->total = $total+$request->input('shipping_amount');
//            $points->order_id = $order->id;
//            $points->save();
//           }
           # send email for order success
           if(isset($user->details->email)){
                $emailNotificationTo=$user->details->email;
           }else{
                $emailNotificationTo=$user->email;
           }
                //Mail::to($emailNotificationTo)->send(new OrderSuccess($order));
           # send phone message
           $sms = 'Payment Is Successfully Processsed And Your Order Is On The Way';
        //    sendPhoneMessageNotification($sms, $user->contact_number);



           # flush cart
           session()->forget('products.cart');

           # log the used cupon if any
           $this->LogUsedCupon($order->id, $productFinal);
           session()->put('orderId',$order->id);
           Session::put('order',$order->id);
           return redirect()->route('web.order.success')->with('orderId', $order->id);

    }

    public function orderSuccess(){
        if(Session::has('order')){
            $orderId = Session::get('order');
            $order = Order::find($orderId);
            return view('website.users.order-success')->with( compact('order'));
        } else {
            return redirect()->route('web.order.history');
        }

    }
    public function cancel_order($id){

      $status = OrderStatus::where('name','=','Cancelled')->get()->first();
      $userId = auth()->user()->id;
      $order = Order::where('id','=',$id)->where('user_id', $userId)->get()->first();
      if($order){
        $order->status_id = $status->id;
        $order->save();
      }
      return redirect()->back();
    }
    public function orderHistory(){
        $userId = auth()->user()->id;
        $orders = Order::with('products')->where('user_id', $userId)->latest()->get();
        $reasons = ReturnReason::all();
        // return view('checkout.history')->with( compact('orders'));
        return view('website.users.order-history')->with( compact('orders','reasons'));
    }
    public function orderHistoryOrder($id){
        $locale = App::getLocale();
        if(!auth()->user()){
            return redirect('/'.$locale.'/login');
        }
        $userId = auth()->user()->id;
        $orders = Order::with('products')->where('user_id', $userId)->where('id','=',$id)->get()->first();

        $reasons = ReturnReason::all();

        $main_settings = MainSetting::where('key','=','cancel_orders_status')->get()->first();

        if($main_settings){
            $main_settings = explode(',',$main_settings->value);
        }

        // return view('checkout.history')->with( compact('orders'));
        return view('website.users.order-details')->with( compact('orders','reasons','main_settings'));
    }
    function getCart(){

        $cart = (session()->has('products.cart')) ? session()->get('products.cart') : [] ;

        $products = Product::with('translations:id,product_id,name,locale,slug')
                    ->whereIn('id', array_keys($cart))
                    ->select('id', 'thumbnail', 'price', 'is_bundle')
                    ->get();


        $counter = 0;
        $products = $products->map(function($item) use ($cart){

            $outPut = [];
            $outPut['id'] = $item['id'];
            $outPut['name'] = $item['name'];
            $outPut['price'] = $item['product_price'];
            $outPut['attribute'] = $cart[$item['id']][0]['attributes'];
            $outPut['quantity'] = $cart[$item['id']][0]['quantity'];
            $outPut['price'] = (float) str_replace(',', '', $item['product_price']);
            $outPut['total'] = (float) str_replace(',', '', $item['product_price']) * $outPut['quantity'];
            $outPut['discount'] = (empty($cart[$item['id']][0]['discount'])) ? $cart[$item['id']][0]['discount'] : 0;
            $outPut['price_after'] = (isset($cart[$item['id']][0]['price_after'])) ? $cart[$item['id']][0]['price_after'] : $outPut['total'];
            $outPut['discount_type'] = (isset($cart[$item['id']][0]['type'])) ? $cart[$item['id']][0]['type'] : '';
            $outPut['cupon'] = (isset($cart[$item['id']][0]['cupon'])) ? $cart[$item['id']][0]['cupon'] : '';
            $outPut['is_bundle'] = $item['is_bundle'];

            return $outPut;
        })->all();

        return $products;

    }

    public function LogUsedCupon($oid, $productFinal){
        $productFinal = collect($productFinal);
        $total = $productFinal->sum('total');
        $totalAfterDiscount = $productFinal->sum('price_after');
        $discount = $productFinal->sum('discount');
        $cupon = $productFinal->pluck('cupon')->filter();

        if( $cupon->count() > 0 ){
            CuponLog::create([
                'cupon_id' => 0,
                'user_id' => auth()->user()->id,
                'order_id' => $oid,
                'amount_before' => $total,
                'amount_after' => $totalAfterDiscount,
                'cupon' => (!empty($cupon)) ? $cupon[0] : ''
            ]);
        }
    }


}
