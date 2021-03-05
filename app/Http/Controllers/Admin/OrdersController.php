<?php

namespace App\Http\Controllers\Admin;

use App\InventoryProduct;
use App\OrderStatus;
use App\Point;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Attribute;
use App\CountryTranslation;
use App\CityTranslation;
use function foo\func;
use Auth;
use App\ShippingCompany;
use App\ShippingZone;
use App\MainSetting;
class OrdersController extends Controller
{

    public function index()
    {

        $status_array = explode(',',Auth::user()->order_status_permissions);
        $orders = Order::whereIn('status_id',$status_array)->get();
        $main_settings = MainSetting::where('key','=','ended_orders_status')->get()->first();

        if($main_settings){
            $main_settings = explode(',',$main_settings->value);
        }
        return view('admin.orders.index', compact('orders','main_settings'));
    }
    public function cancelled_orders(){
        $status = OrderStatus::where('name','=','Cancelled')->first();
//        dd($status);
        $status_array = explode(',',Auth::user()->order_status_permissions);
        $orders = Order::where('status_id','=',$status->id)->get();
        $main_settings = MainSetting::where('key','=','ended_orders_status')->get()->first();

        if($main_settings){
            $main_settings = explode(',',$main_settings->value);
        }
        return view('admin.orders.cancelled_orders', compact('orders','main_settings'));
    }

    public function create()
    {
        $data = [
            'products' => Product::get(),
            'pattributes' => Attribute::with('childrensRow')->parents()->get(),
            'countries' => CountryTranslation::pluck('name', 'id'),
            'cities' => CityTranslation::pluck('name', 'id')
        ];
        return view('admin.orders.create')->with($data);
    }

    public function store(Request $request)
    {
        $pids = $request->input('products');
        $attrs = $request->input('attributes');
        $quantities = $request->input('quantities');

        $productsList = [];
        foreach($pids as $k => $pid){
            $productsList[$k]['attributes'] = $attrs[$k];
            $productsList[$k]['quantity']   = $quantities[$k];
        }
        $products = $this->getOrderProducts($pids, $productsList);

        $pInfo = [];
        foreach($products as $product){
            $pIds[] = $product['id'];
            $pInfo[] = [
                'attribute_id'  => (int)$product['attribute'],
                'price'         => $product['price'],
                'quantity'      => $product['quantity'],
                'total'         => $product['total'],
            ];
        }
        $productFinal = array_combine($pIds, $pInfo);
        # add order
        $request->merge(['user_id'=>auth()->user()->id]);
        $order = Order::create( $request->all() );

        # assign products
        $order->products()->sync($productFinal);
        $logPayload = ['msg' => 'Order Added', 'model_id' => $order->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.orders.index');
    }

    public function save(Request $request, Order $order) {

        $order->status_id = $request->status_id;
        $totalPrice =0;
        $totalPoints =0;



       $total = $order->products->map(function (Product $product) use ($request,$totalPrice,$totalPoints) {


            if(isset($request->get('inventory')[$product->id])) {
                $product_inventory = InventoryProduct::where('inventory_id', $request->get('inventory')[$product->id])
                    ->where('product_id', $product->id)
                    ->first();

                if($request->status_id == 2) {
                    $product_inventory->decrement('quantity', $product->pivot->quantity);
                    $product_inventory->save();
                }
            }

            $totalPrice += $product->pivot->price_after;
            $totalPoints += $product->pivot->reward_points;
            return [$totalPrice, $totalPoints];
        });


        if($order->status_id == 3){ // the status is completed

            $points = new Point;
            $points->user_id = Auth::user()->id;
            $points->points = $total->sum(1);
            $points->total = $total->sum(0) + $request->input('shipping_amount');
            $points->order_id = $order->id;
            $points->save();
        }

        $order->save();
        return redirect()->route('admin.orders.index');

    }

    public function show($id)
    {

        $main_settings = MainSetting::where('key','=','ended_orders_status')->get()->first();

        if($main_settings){
            $main_settings = explode(',',$main_settings->value);
        }
        $order = Order::with('products')->findOrFail($id);
        $total_price = 0;
        $weights = 0;
        $counter = 0;
        $order->products->map(function (Product $product) use (&$total_price, &$weights, &$counter) {
            if($product->pivot->total != $product->pivot->price_after){
                $total_price += $product->pivot->price_after;
            }else{
                $total_price += $product->pivot->total;
            }
            $weights += (($product->length*$product->width*$product->height)/3000)*$product->pivot->quantity;
            return $product;
        });

        $shipping_zone = ShippingZone::all();
        $results = [];
        $company_id = 0;
        $cod = 0;
        $fuel = 0;
        $post = 0;
        $vat = 0;
        $cod = 0;
        $company = null;
        foreach($shipping_zone as $zone){
            $total_shipping = 0;
            if(in_array($order->state,json_decode($zone->areas))){
                $zone_id = $zone->id;
                $first_kg = $zone->first_kg;
                $additional_kg = $zone->additional_kg;
                $company_id = $zone->company_id;
                $company = ShippingCompany::find($company_id);
                $first_kg_number = $company->first_kg_number;
                $cod_values = explode(',',$zone->cod_values);


                $adds_kgs = $first_kg_number-(int)$weights;
                $adds_kgs = str_replace('-','',$adds_kgs);
                if((int)$weights > $first_kg_number){
                    $total_shipping += (int)$first_kg;
                    $total_shipping += $adds_kgs*$additional_kg;
                }else{
                    $total_shipping += (int)$first_kg;
                }
            }

            // Shipping Properties Checker
            if($company_id != 0){
                $fuel = $company->fuel;
                $post = $company->post;
                $vat = $company->vat;
                $cod = $company->cod;
            }

            // COD Values Checker
            if($cod != 0){
                $selected_cod = 0;
                $cods = explode(',',$cod);
                $i=0;
                foreach($cods as $item){
                    if($item <= $total_price){
                        $selected_cod = $i;
                    }
                    $i++;
                }
                if(isset($selected_cod) && $selected_cod != 0){
                    $cod = $cod_values[$selected_cod];
                    if(strpos($cod,'%') !== false){
                        $total_shipping += $total_price*str_replace('%','',$cod)/100;
                    }else{
                        $total_shipping += $cod;
                    }
                }
            }

            if($fuel != 0){
                $total_shipping += $total_shipping*$fuel/100;
            }
            if($post != 0){
                $total_shipping += $total_shipping*$post/100;
            }
            if($vat != 0){
                $total_shipping += $total_shipping*$vat/100;
            }
            if ($company != null){
                            array_push($results,[ 'company_id' => $company_id, 'company_name'=> $company->name, 'cost' => $total_shipping  ]);
            }
            else{
                            array_push($results,[ 'company_id' => $company_id, 'company_name'=> '', 'cost' => $total_shipping  ]);
            }
        }
        $order->admin_viewed=1;
        $order->save();
        
        return view('admin.orders.show', compact('order', 'total_price', 'results','main_settings'));
    }

    public function edit($id)
    {
        $data = [
            'products' => Product::get(),
            'attributes' => Attribute::childrens()->get(),
            'order' => Order::with('products')->findOrFail($id),
            'countries' => CountryTranslation::pluck('name', 'id'),
            'cities' => CityTranslation::pluck('name', 'id')
        ];
        return view('admin.orders.edit')->with( $data );
    }

    public function update(Request $request, $id)
    {

        $pids = $request->input('products');

        $attrs = $request->input('attributes');
        $quantities = $request->input('quantities');
        $productsList = [];
        foreach($pids as $k => $pid){
            $attrs_ar = [];
            foreach($pids as $i => $one){
                if($pid == $one){
                    array_push($attrs_ar,$attrs[$i]);
                }
            }
            $productsList[$k]['product_id'] = $pid;
            $productsList[$k]['attributes'] = implode(',',$attrs_ar);
            $productsList[$k]['quantity'] = $quantities[$k];
        }
        $products = $this->getOrderProducts($pids, $productsList);

        $pInfo = [];
        foreach($products as $product){
            $pIds[] = $product['id'];
            $pInfo[] = [
            'attribute_id' => $product['attribute'],
            'price' => $product['price'],
            'quantity' => $product['quantity'],
            'total' => $product['total'],
            ];
        }
        $productFinal = array_combine($pIds, $pInfo);
        $order = Order::findOrFail($id);
        $order->update( $request->all() );
        # assign products

        $order->products()->sync($productFinal);
        $logPayload = ['msg' => 'Order Updated', 'model_id' => $order->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        $order->products()->detach();
        \App\Transaction::where('order_id',$order->id)->delete();
        return redirect()->route('admin.orders.index');
    }

    public function getOrderProducts($pids, $productsList){

        $products = Product::with('translations:id,product_id,name,locale,slug')
                    ->whereIn('id', $pids)
                    ->select('id', 'thumbnail', 'price')
                    ->get();

        $counter = 0;
        $products = $products->map(function($item, $k) use ($pids, $productsList){
            $outPut = [];
            $outPut['id'] = $item['id'];
            $outPut['name'] = $item['name'];
            $outPut['price'] = $item['price'];
            $outPut['attribute'] = $productsList[$k]['attributes'];
            $outPut['quantity'] = $productsList[$k]['quantity'];
            $outPut['price'] = $item['price'];
            $outPut['total'] = $item['price'] * $outPut['quantity'];
            return $outPut;
        })->all();

        return $products;

    }

    public function show_bundle($id,$bundle_id)
    {
        $order=Order::find($id);
        $product=$order->products()->where('is_bundle',1)->get();
        $bundle=$product->where('id','=',$bundle_id)->first();
        $product_ids=\App\BundleProduct::where('bundle_id',$bundle->id)->pluck('product_id')->toArray();
        $products=Product::whereIn('id',$product_ids)->get();
        return view('admin.orders.showBundle',compact('bundle','products','order'));
    }
}
