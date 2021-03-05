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

class ReturnOrdersController extends Controller
{

    public function index()
    {
        $orders = OrderProduct::where('is_return','=',1)->get();
        return view('admin.orders.returns', compact('orders'));
    }
    public function approve_return(Request $request){
        $user = $request->input('user');
        $notes = $request->input('notes');
        $order = $request->input('order');
        $amount = $request->input('amount');

        $update_order = OrderProduct::find($order);
        $update_order->is_return = 2;
        $update_order->save();

        if($update_order->return_bank == 1){
            $withdraw = Withdraw::where('order_line_id','=',$update_order)->get()->first();
            if($withdraw){
                $withdraw->status = "Approved";
                $withdraw->save();
            }
        }else{
            $wallet = new Wallet;
            $wallet->user_id = $user;
            $wallet->notes = "Refund for order number #".$order;
            $wallet->order_id = $order;
            $wallet->amount = $amount;
            $wallet->save();
        }

        return "true";
    }
    public function disapprove_return(Request $request){
        $order = $request->input('order');

        $update_order = OrderProduct::find($order);
        $update_order->is_return = 0;
        $update_order->save();
        return "true";
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
        $order->products->map(function (Product $product) use ($request) {

            if(isset($request->get('inventory')[$product->id])) {
                $product_inventory = InventoryProduct::where('inventory_id', $request->get('inventory')[$product->id])
                    ->where('product_id', $product->id)
                    ->first();

                if($request->status_id == 2) {
                    $product_inventory->decrement('quantity', $product->pivot->quantity);
                    $product_inventory->save();
                }

            }

            return $product;
        });

        $order->save();
        return redirect()->route('admin.orders.index');

    }

    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);

        $total_price = 0;

        $order->products->map(function (Product $product) use (&$total_price) {

            $total_price += ceil($product->pivot->price * $product->pivot->quantity);

            return $product;
        });

        return view('admin.orders.show', compact('order', 'total_price'));
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
            $productsList[$k]['attributes'] = $attrs[$k];
            $productsList[$k]['quantity'] = $quantities[$k];
        }
        $products = $this->getOrderProducts($pids, $productsList);

        $pInfo = [];
        foreach($products as $product){
            $pIds[] = $product['id'];
            $pInfo[] = [
            'attribute_id' => (int)$product['attribute'],
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
}
