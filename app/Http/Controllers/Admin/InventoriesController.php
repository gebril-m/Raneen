<?php

namespace App\Http\Controllers\Admin;

use App\Inventory;
use App\InventoryTranslation;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\State;

class InventoriesController extends Controller
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

    public function index()
    {
    	$query = Inventory::query();

        $query->orderBy('id', 'desc');
        $inventory = $query->get();

        $data = ['rows' => $inventory];
        return view('admin.inventories.index')->with($data);
    }

    public function create()
    {
        $areas = State::all();
        return view('admin.inventories.create')->with(compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.*' => 'required',
            # 'slug.*' => 'required|unique:inventory_translations,slug',
        ]);

        $inventory = new Inventory();
        # $inventory->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $inventory->areas = implode(',',$request->input('areas'));
        $inventory->save();

        foreach($this->languages as $local){
            $inventoryTrans = new InventoryTranslation();
            $inventoryTrans->inventory_id = $inventory->id;
            $inventoryTrans->name = $request->input('name.'.$local->locale);

            $inventoryTrans->locale = $local->locale;
            $inventoryTrans->save();
        }
        $logPayload = ['msg' => 'Inventory Added', 'model_id' => $inventory->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.inventories.index');
    }

    public function show(Inventory $inventory)
    {
        $data = ['row' => $inventory];
        return view('admin.inventories.show')->with($data);
    }

    public function edit(Inventory $inventory)
    {
        $areas = State::all();
        $data = [
            'row'           => $inventory,
            'areas'           => $areas,
        ];
        return view('admin.inventories.edit')->with($data);
    }

    public function update(Request $request, Inventory $inventory)
    {

        $request->validate([
            'name.*' => 'required',
            # 'logo' => 'required',
        ]);

        $inventory->areas = $request->input('areas');
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
        $logPayload = ['msg' => 'Inventory Updated', 'model_id' => $inventory->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.inventories.index');

    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('admin.inventories.index');
    }

}
