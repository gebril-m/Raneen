<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PromotionsRequest;
use App\Http\Controllers\Controller;
use App\Promotion;
use App\Category;
use App\Product;
use Carbon\Carbon;
use App\BundleProduct;
use App\ProductCombo;
use App\Periortysetting;

class PromotionsController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_cupon');
        $this->middleware('permission:create_cupon', ['only' => ['create','store']]);
        $this->middleware('permission:edit_cupon', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_cupon', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = ['rows' => Promotion::with('products')->get()];
        return view('admin.promotions.index')->with($data);
    }

    public function create()
    {

        $categories = Category::listsTranslations('name', 'id')->pluck('name', 'id');
        $products   = Product::listsTranslations('name', 'id')->pluck('name', 'id');
        
        $data = [
            'products' => $products,
            'categories' => $categories
        ];
        
        return view('admin.promotions.create')->with($data);

    }

    public function store(PromotionsRequest $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        #Check Priorty
        if(Periortysetting::first()->enable==1){
            $order_id=\App\Periorty::where('name','promotion')->first()->order_id;
            foreach($request->product_id as $i => $id){
                if(!priorty($order_id,$id)){
                    $sub_product=Product::find($id);
                    session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }
            }
        }

        $start = Carbon::parse($request->get('start'))->format('Y-m-d H:i:s') ?? null;
        $end = Carbon::parse($request->get('end'))->format('Y-m-d H:i:s') ?? null;
        $request->merge(['start' => $start]);
        $request->merge(['end' => $end]);
        $promotion = Promotion::create($request->all());
        # attach products
        // $promotion->products()->sync( $request->input('product_id') );
        # attach categories
        $promotion->categories()->sync( $request->input('category_id') );
        $cat_ids=$promotion->categories()->pluck('id')->toArray();
        foreach ($cat_ids as $id) {
            $cat=Category::find($id);
            $product_ids=$cat->products->pluck('id')->toArray();
            $promotion->products()->sync($product_ids);
        }
        # Delete Another Offers
        // foreach($request->product_id as $i => $id){
        //     $sub_product=Product::find($id);
        //     $sub_product->on_sale=0;
        //     $sub_product->is_hot=0;
        //     $sub_product->cupons()->sync([]);
        //     $sub_product->save();
        //     BundleProduct::where('product_id',$id)->delete();
        //     ProductCombo::where('product_id',$id)->delete();
        // }

        $logPayload = ['msg' => 'Promotion Added', 'model_id' => $promotion->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);     
        return redirect()->route('admin.promotions.index');
    }

    public function show($id)
    {
        $data = ['row' => Promotion::find($id)];
        return view('admin.promotions.show')->with($data);
    }

    public function edit($id)
    {
        $categories = Category::get();
        $products = Product::get();
        $promotion = Promotion::with('products', 'categories')->find($id);
        $promotion->products = $promotion->products->pluck('id');
        $promotion->categories = $promotion->categories->pluck('id');
        $data = ['row' => $promotion, 'products' => $products, 'categories' => $categories];
        return view('admin.promotions.edit')->with($data);
    }

    public function update(PromotionsRequest $request, $id)
    {   
        
        $request->merge(['is_active' => $request->has('is_active')]);
        #Check Priorty
        if(Periortysetting::first()->enable==1){
            $order_id=\App\Periorty::where('name','promotion')->first()->order_id;
            foreach($request->product_id as $i => $id2){
                if(!priorty($order_id,$id2)){
                    $sub_product=Product::find($id2);
                    session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }
            }
        }

        $start = Carbon::parse($request->get('start'))->format('Y-m-d H:i:s') ?? null;
        $end = Carbon::parse($request->get('end'))->format('Y-m-d H:i:s') ?? null;
        $request->merge(['start' => $start]);
        $request->merge(['end' => $end]);
        $promotion = Promotion::find($id);
        $promotion->update($request->all());
        # attach products  
        #$promotion->products()->sync( $request->input('product_id') );
        # attach categories
        $product_ids=$request->input('product_id');
        $promotion->categories()->sync( $request->input('category_id') );
        $cat_ids=$promotion->categories()->pluck('id')->toArray();
        foreach ($cat_ids as $id) {
            $cat=Category::find($id);
            $product_ids=$cat->products->pluck('id')->toArray();
            $promotion->products()->sync($product_ids);
        }
        # Delete Another Offers
        // foreach($request->product_id as $i => $id){
        //     $sub_product=Product::find($id);
        //     $sub_product->on_sale=0;
        //     $sub_product->is_hot=0;
        //     $sub_product->cupons()->sync([]);
        //     $sub_product->save();
        //     BundleProduct::where('product_id',$id)->delete();
        //     ProductCombo::where('product_id',$id)->delete();
        // }

        $logPayload = ['msg' => 'Promotion Updated', 'model_id' => $promotion->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);  
        return redirect()->route('admin.promotions.index');
    }

    public function destroy($id)
    {
        $promotion=Promotion::find($id);
        $promotion->categories()->sync([]);
        $promotion->products()->sync([]);
        $promotion->delete();
        return redirect()->route('admin.promotions.index');
    }
}
