<?php

namespace App\Http\Controllers\Admin;

use App\Inventory;
use App\InventoryProduct;
use App\InventoryTranslation;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;

class InventoryProductsController extends Controller
{
    public function __construct()
    {
        // permissions
        $this->middleware('permission:view_inventory');
        $this->middleware('permission:create_inventory', ['only' => ['create','store']]);
        $this->middleware('permission:edit_inventory', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_inventory', ['only' => ['destroy']]);

        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index(Inventory $inventory)
    {
        $products = $inventory->products;
        $data = [
            'rows' => $products,
            'inventory' => $inventory,
        ];
        return view('admin.inventory_products.index')->with($data);
    }

    public function create(Inventory $inventory)
    {
        return view('admin.inventory_products.create', compact('inventory'));
    }

    public function store(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            # 'slug.*' => 'required|unique:inventory_translations,slug',
        ]);

        $InventoryProduct = new InventoryProduct();
        $InventoryProduct->inventory_id = $inventory->id;
        $InventoryProduct->product_id = $request->product_id;
        $InventoryProduct->quantity = $request->quantity;
        $InventoryProduct->save();
        $logPayload = ['msg' => 'Inventory Product Added', 'model_id' => $InventoryProduct->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);        
        return redirect()->route('admin.inventory.products', $inventory->id);
    }

    public function show(Inventory $inventory)
    {
        $data = ['row' => $inventory];
        return view('admin.inventories.show')->with($data);
    }

    public function edit(Inventory $inventory)
    {
        $data = [
            'row'           => $inventory,
        ];
        return view('admin.inventories.edit')->with($data);
    }

    public function update(Request $request, Inventory $inventory)
    {

        $request->validate([
            'name.*' => 'required',
            # 'logo' => 'required',
        ]);

        $inventory->save();

        foreach($this->languages as $local){
            $inventoryTrans = InventoryTranslation::where([
                'inventory_id' => $inventory->id,
                'locale' => $local->locale,
            ])->first();
            if (!$inventoryTrans) $inventoryTrans = new InventoryTranslation();
            $inventoryTrans->inventory_id = $inventory->id;
            $inventoryTrans->name = $request->input('name.'.$local->locale);

            $inventoryTrans->locale = $local->locale;
            $inventoryTrans->save();
        }
        $logPayload = ['msg' => 'Inventory Product Updated', 'model_id' => $inventory->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);       
        return redirect()->route('admin.inventory.products', $inventory->id);

    }

    public function destroy(Inventory $inventory, InventoryProduct $inventoryProduct)
    {
        $inventoryProduct->delete();
        return redirect()->route('admin.inventory.products', $inventory->id);
    }

}
