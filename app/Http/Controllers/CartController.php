<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Product;
use App\BundleProduct;
use Illuminate\Support\Facades\App;
Use View;
class CartController extends Controller
{
    /* function store(Request $request){

        $id = ($request->input('id')) ? $request->input('id') : '' ;
        $name = ($request->input('name')) ? $request->input('name') : '' ;
        $price = ($request->input('price')) ? $request->input('price') : '';

        $cartSession = (session()->has('products.cart')) ? session()->get('products.cart') : [] ;

        if(!array_key_exists($id, $cartSession)){
            session()->push('products.cart.'.$id, ['id'=>$id, 'name'=>$name, 'price'=>$price]);
        }
        return redirect()->back();

    }

    function delete($id){

        $cartSession = (session()->has('products.cart')) ? session()->get('products.cart') : [] ;
        if(array_key_exists($id, $cartSession)){
            session()->forget('products.cart.'.$id);
        }
        return redirect()->back();

    } */

    public function __construct()
    {
        $locale = App::getLocale();
        View::share('key', 'value');
        View::share('locale',$locale);
    } 
    function show(){
        $cart = $this->getCart();
        $cart = $cart['cartProducts'];
        $total = $this->getCart()['totalPrice'];
        return view('website.users.cart')->with(compact('cart','total'));
    }
    function store(Request $request) {
        $id = ($request->input('id')) ? $request->input('id') : '' ;
        $price = ($request->input('price')) ? $request->input('price') : 0 ;
        $discount = ($request->input('discount')) ? $request->input('discount') : 0 ;
        $price_after = ($request->input('price_after')) ? $request->input('price_after') : 0 ;
        //dd($price);
        //Update Quantity
        $quantity = ($request->input('quantity')) ? $request->input('quantity') : 0 ;
        $attribute = ($request->input('attribute')) ? $request->input('attribute') : '' ;
        if($attribute == ''){
            $product = Product::find($id);
            $final_attrs = [];
            $groups = [];
            foreach($product->attributes as $attr){
                if(isset($attr->parentRow)){
                    if(!in_array($attr->parentRow->id,$groups)){
                        array_push($groups,$attr->parentRow->id);
                        $i=0;
                        foreach($product->get_attrs_child($attr->parentRow->id,$product->attributes) as $attr_c){
                            $i++;
                            if($i==1){
                                array_push($final_attrs,$attr_c->id);
                            }
                        }
                    }
                }
            }
            $attribute = implode(',',$final_attrs);
        }
        $myProduct = Product::find($id);
        # check stock availability
        $stockAvailable = $this->checkStock($id,$quantity); 
        
//        echo $stockAvailable['status'];
        // if(!$stockAvailable['status'])
        // return ['status' => 'fail'];
        $cartSession = (session()->has('products.cart') ) ? session()->get('products.cart') : [] ;
        
        if($request->input('type') == 'combo'){
            $products_obj = [];
            $combo = Product::find($request->input('combo_id'));
            $all_combos = BundleProduct::where('bundle_id','=',$request->input('combo_id'))->get();
            $combo_count = 0;
            foreach($all_combos as $combo_item){
                if(array_key_exists($combo_item->product_id, $cartSession)){
                    $combo_count++;
                    array_push($products_obj,$combo_item->product_id);
                }
            }
            if(!array_key_exists($id, $cartSession)){
                $combo_count++;
            }

            if($combo_count >= 1){
                $combo_count_str = "combo_".$combo_count;
                $combo_discount = $combo->$combo_count_str;
                if($combo_count == 5){
                    $combo_5_free = $combo->combo_5_free;
                    $product_free = 0;
                    $product_free_id = 0;
                    if($combo_5_free == 1){
                        foreach($combo->get_bundle_products($combo->id) as $product){
                            if(array_key_exists($product->id, $cartSession)){
                                if($product_free == 0){
                                    $product_free = $product->price;
                                    $product_free_id = $product->id;
                                }else{
                                    if($product->price < $product_free){
                                        $product_free = $product->price;
                                        $product_free_id = $product->id;
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                $combo_discount = 0;
            }
            if(!array_key_exists($combo->get_bundle_products($combo->id)[0]->id, $cartSession)){
                if($combo->get_bundle_products($combo->id)[0]->id == $id){
                    $this->add_to_cart_quick($request,$id,$cartSession,$quantity,$attribute,$combo_discount,'combo');
                }else{
                    return \response()->json( [
                        'status'=>'combo_not_found'
                    ]);
                }
                $this->combo_fix($combo->id,$cartSession,$combo_discount,$product_free_id,$request,$products_obj);
            }else{
                $product_get = Product::find($id);
                
                $this->add_to_cart_quick($request,$id,$cartSession,$quantity,$attribute,$combo_discount,'combo');
                array_push($products_obj, $id);
                $this->combo_fix($combo->id,$cartSession,$combo_discount,$product_free_id,$request,$products_obj);
            }

            
            // $this->combo_fix($combo->id,$cartSession,$combo_discount,$product_free_id,$request);
        }else{
            $check_product = Product::find($id);
            if($check_product){
                if($check_product->is_bundle == 1){
                    $productStock =[];
                    $status=[];

                    $check_sub = BundleProduct::where('bundle_id','=',$id)->get();
                    foreach($check_sub as $item){ 
                        $stockAvailable = $this->checkStock($item->product_id,$quantity);
                        $stockQuantity = $this->checkStockQuantity($item->product_id);

                        if(!$stockAvailable['status']){ 
                            $productStock[] = $stockQuantity['bundleQuantity'];
                            $status[] = 'fail';
                        }else{
                            $productStock[] = $stockQuantity['bundleQuantity'];
                            $status[] = 'true';
                        }
                    }

                
                    $status= (in_array("fail", $status) ? 'fail' : 'true' );    
                    $quantity=min($productStock); 
                    
                    if(array_key_exists($id, $cartSession)){ 
                        $cartQTY =$cartSession[$id][0]['quantity'];
                    }else{
                        $cartQTY =1;
                    }
                    
                    
                    
                    if(($status =="fail") || ($cartQTY > ( $quantity - 1))){
                        return ['status' => 'fail','msg'=>trans('Product.Out Of Stock')];
                    }else{
                        $this->add_to_cart_quick($request,$check_product->id,$cartSession,1,$attribute,$discount,'bundle');

                        return ['status' => 'success','msg'=>trans('home.Product_added_successfully')];
                    }

                    //dd($quantity);
                        
                }
                // }else{
                //     if(!$stockAvailable['status'])
                //     return ['status' => 'fail'];
                // }
                // if(!count($check_product->promotions()->get()) > 0)
                    //dd($check_product->promotions()->get());
            }
            
            if(!array_key_exists($id, $cartSession)){
                $cartItem = [
                    'id' => $id,
                    'quantity' => $quantity,
                    'attributes' => $attribute,
                    'price' => $price,
                    'discount'=>$myProduct->getFinalDiscountPriroty(),
                    'details' => [[
                        'attribute' => $attribute,
                        'quantity' => $quantity,
                    ]]
                ];
                session()->push('products.cart.'.$id, $cartItem);
            # in case if product already exists then we need to update
            } else {
    
                $itemArr = [];
                $currentItem = session()->get('products.cart.'.$id);
                
                $currentItemDetails = $currentItem[0]['details'];
                $qtyCounter = 0;
                $found = 0;
    
                foreach($currentItemDetails as $k => $d){
                    if( $d['attribute'] == $attribute){
                        // update quantity
                        if($request->input('type') == 'update'){
                            if($currentItemDetails[$k]['quantity'] != $quantity){
                                $currentItemDetails[$k]['quantity'] = $quantity;
                            }else{
                                return "already found same quantity";
                            }
                        }else{
                            $currentItemDetails[$k]['quantity'] = $currentItemDetails[$k]['quantity']+$quantity;
                        }
                        $found = 1;
                        break;
                    } else {
                        // echo 0;
                    }
                }
    
                // if attribute not exists before
                if(!$found){
                    $currentItemDetails[] = [
                        'attribute' => $attribute,
                        'quantity' => $quantity,
                    ];
                }
    
    
    
                $currentItemDetails = collect($currentItemDetails);
    
                $cartItem = [
                    'id' => $id,
                    'quantity' => $currentItemDetails->sum('quantity'),
                    'attributes' => $attribute,
                    'price' => $price,
                    'discount'=>$myProduct->getFinalDiscountPriroty(),
                    'details' => $currentItemDetails->toArray()
                ];
                //dd($cartItem);
                session()->forget('products.cart.'.$id);
                session()->push('products.cart.'.$id, $cartItem);
    
            }
        }
        
         // $segments = request()->segments();
         //    dd($segments);
        return \response()->json( [
            'status'=>'success','msg'=>trans('home.Product_added_successfully')
        ]);

    }
    function combo_fix($combo_id,$cartSession,$combo_discount,$product_free_id,$request,$products_obj){
        $all_combos_incart = Product::whereIn('id',$products_obj)->get();
            foreach($all_combos_incart as $combo_item){
                $this->add_to_cart_quick($request,$combo_item->id,$cartSession,1,'',$combo_discount,'combo');
                if(isset($product_free_id) && $product_free_id != 0 && $product_free_id == $combo_item->id){
                    $this->add_to_cart_quick($request,$product_free_id,$cartSession,1,'',$combo_discount,'combo_free');
                }
            }
    }
    function add_to_cart_quick($request,$id,$cartSession,$quantity,$attribute,$discount,$type){
        // if($type == 'combo'){
        //     $product = Product::find($id);
        //     $discount = $product->price*$discount/100;
        // }
        // if($type == 'combo_free'){
        //     $product = Product::find($id);
        //     $discount = $product->price;
        // }
        if(!array_key_exists($id, $cartSession)){
            $cartItem = [
                'id' => $id,
                'quantity' => $quantity,
                'attributes' => $attribute,
                'discount' => $discount,
                'type' => $type,
                'details' => [[
                    'attribute' => $attribute,
                    'quantity' => $quantity,
                    'type' => $type,
                    'discount' => $discount
                ]]
            ];
            session()->push('products.cart.'.$id, $cartItem);
        # in case if product already exists then we need to update
        } else {

            $itemArr = [];
            $currentItem = session()->get('products.cart.'.$id);
            
            $currentItemDetails = $currentItem[0]['details'];
            $qtyCounter = 0;
            $found = 0;

            foreach($currentItemDetails as $k => $d){
                if( $d['attribute'] == $attribute){
                    // update quantity
                    
                    if($request->input('type') == 'update'){
                        if($currentItemDetails[$k]['quantity'] != $quantity){
                            $currentItemDetails[$k]['quantity'] = $quantity;
                        }else{
                            return "already found same quantity";
                        }
                    }else{
                        $currentItemDetails[$k]['quantity'] = $currentItemDetails[$k]['quantity']+$quantity;
                    }
                    $found = 1;
                    break;
                } else {
                    // echo 0;
                }
            }

            // if attribute not exists before
            if(!$found){
                $currentItemDetails[] = [
                    'attribute' => $attribute,
                    'quantity' => $quantity,
                    'discount' => $discount,
                ];
            }



            $currentItemDetails = collect($currentItemDetails);
            if($type == 'combo' || $type == 'combo_free'){
                $cartItem = [
                    'id' => $id,
                    'quantity' => 1,
                    'attributes' => $attribute,
                    'discount' => $discount,
                    'details' => $currentItemDetails->toArray()
                ];
            }else{
                $cartItem = [
                    'id' => $id,
                    'quantity' => $currentItemDetails->sum('quantity'),
                    'attributes' => $attribute,
                    'discount' => $discount,
                    'details' => $currentItemDetails->toArray()
                ];
            }

            session()->forget('products.cart.'.$id);
            session()->push('products.cart.'.$id, $cartItem);

        }
    }

    function checkAttributes(Request $request){

        $id = ($request->input('id')) ? $request->input('id') : '' ;
        $quantity = ($request->input('quantity')) ? $request->input('quantity') : '' ;
        $attribute = ($request->input('attribute')) ? $request->input('attribute') : '' ;

        $product = Product::find($id);
        $status = false;

        $attrs = $product->attributes->pluck('pivot.quantity', 'name:en')->toArray();

        if(array_key_exists($attribute, $attrs)){
            $currentQuantity = $attrs[$attribute];
            if($quantity < $currentQuantity){
                $status = true;
            }
        }

        return [
            'status' => $status
        ];

    }

    function checkStock($id,$qty){

        $productStock = Product::find($id);
        if($productStock){
            return [
                'status' => ($productStock->stock >= $qty) ? 1 : 0 
            ];
        }else{
            return [
                'status' => 0 
            ];
        }

    }

    public function checkStockQuantity($id){
        //echo $id; die();
        $product = Product::find($id);
        if($product){
            return [
                'bundleQuantity' => $product->stock
            ];
        }else{
            return [
                'bundleQuantity' => 0 
            ];
        } 
    }

    function getCart(){
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

    function delete(Request $request){

        $id = ($request->input('id')) ? $request->input('id') : '' ;
        $cartSession = (session()->has('products.cart')) ? session()->get('products.cart') : [] ;
        
        if(array_key_exists($id, $cartSession)){
            session()->forget('products.cart.'.$id );
        }

        return [
            'status'=>'success'
        ];

    }

    function deleteAll(){
        session()->forget('products.cart');
        return [
            'status'=>'success'
        ];
    }

    function buynow(Request $request){
        $this->store($request);
        return redirect()->route('web.checkout.show');

    }

}
