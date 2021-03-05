<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\CuponsRequest;
use App\Http\Controllers\Controller;
use App\Cupon;
use App\Category;
use App\Product;
use App\CuponLog;
use App\BundleProduct;
use App\ProductCombo;
use App\Periortysetting;
class CuponsController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_cupon');
        $this->middleware('permission:create_cupon', ['only' => ['create','store']]);
        $this->middleware('permission:edit_cupon', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_cupon', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = ['rows' => Cupon::with('products')->get()];
        return view('admin.cupons.index')->with($data);
    }

    public function create()
    {

        $categories = Category::listsTranslations('name', 'id')->pluck('name', 'id');
        $products   = Product::listsTranslations('name', 'id')->pluck('name', 'id');
        
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        
        return view('admin.cupons.create')->with($data);

    }

    public function store(CuponsRequest $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        #Check Priorty
        // if(Periortysetting::first()->enable==1){
        //     $order_id=\App\Periorty::where('name','promotion')->first()->order_id;
        //     foreach($request->product_id as $i => $id){
        //         if(!priorty($order_id,$id)){
        //             $sub_product=Product::find($id);
        //             session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
        //             return back();
        //         }
        //     }
        // }

        $cupon = Cupon::create($request->all());
        # attach products  
        $cupon->products()->sync( $request->input('product_id') );
        # attach categories
        $cupon->categories()->sync( $request->input('category_id') );
        $cat_ids=$cupon->categories()->pluck('id')->toArray();
        $product_ids=[];
        foreach ($cat_ids as $id) {
            $cat=Category::find($id);
            $product_ids=$cat->products->pluck('id')->toArray();
            $cupon->products()->attach($product_ids);
        }
        # Delete Another Offers
        // dd($request->product_id);
        // foreach($request->product_id as $i => $id){
        //     $sub_product=Product::find($id);
        //     $sub_product->on_sale=0;
        //     $sub_product->is_hot=0;
        //     $sub_product->promotions()->sync([]);
        //     $sub_product->save();
        //     BundleProduct::where('product_id',$id)->delete();
        //     ProductCombo::where('product_id',$id)->delete();
        // }

        $logPayload = ['msg' => 'Coupon Added', 'model_id' => $cupon->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.cupons.index');
    }

    public function show($id)
    {
        $cupon = Cupon::with('products', 'categories')->find($id);
        $log = CuponLog::where('cupon' , $cupon->code)->get()->count();
        $data = ['row' => Cupon::find($id), 'log'=>$log];
        return view('admin.cupons.show')->with($data);
    }

    public function edit($id)
    {
        $categories = Category::get();
        $products = Product::get();
        $cupon = Cupon::with('products', 'categories')->find($id);
        $log = CuponLog::where('cupon' , $cupon->code)->get()->count();
        $cupon->products = $cupon->products->pluck('id');
        $cupon->categories = $cupon->categories->pluck('id');
        $data = ['row' => $cupon, 'products' => $products, 'categories' => $categories, 'log'=>$log];
        return view('admin.cupons.edit')->with($data);
    }

    public function update(CuponsRequest $request, $id)
    {   
        $request->merge(['is_active' => $request->has('is_active')]);
        //Check Priorty
        // if(Periortysetting::first()->enable==1){
        //     $order_id=\App\Periorty::where('name','coupon')->first()->order_id;
        //     foreach($request->product_id as $i => $id2){
        //         if(!priorty($order_id,$id2)){
        //             $sub_product=Product::find($id2);
        //             session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
        //             return back();
        //         }
        //     }
        // }

        $cupon = Cupon::find($id);
        $cupon->update($request->all());
        # attach products  
        $cupon->products()->sync( $request->input('product_id') );
        # attach categories
        $cupon->categories()->sync( $request->input('category_id') );
        $cat_ids=$cupon->categories()->pluck('id')->toArray();
        $product_ids=[];
        foreach ($cat_ids as $id) {
            $cat=Category::find($id);
            $product_ids=$cat->products->pluck('id')->toArray();
            $cupon->products()->attach($product_ids);
        }
        //Delete Another Offers
        // foreach($request->product_id as $i => $id){
        //     $sub_product=Product::find($id);
        //     $sub_product->on_sale=0;
        //     $sub_product->is_hot=0;
        //     $sub_product->save();
        //     $sub_product->promotions()->sync([]);
        //     BundleProduct::where('product_id',$id)->delete();
        //     ProductCombo::where('product_id',$id)->delete();
        // }

        $logPayload = ['msg' => 'Coupon Updated', 'model_id' => $cupon->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.cupons.index');
    }

    public function destroy($id)
    {
        Cupon::find($id)->delete();
        return redirect()->route('admin.cupons.index');
    }
}
