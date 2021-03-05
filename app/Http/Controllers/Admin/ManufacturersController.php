<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ManufacturersExport;
use App\Imports\ManufacturersImport;
use App\Manufacturer;
use App\ManufacturerTranslation;
use App\Language;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class ManufacturersController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_manufacture');
        $this->middleware('permission:create_manufacture', ['only' => ['create','store']]);
        $this->middleware('permission:edit_manufacture', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_manufacture', ['only' => ['destroy']]);

        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {

    	$query = Manufacturer::query();
        $manufacturer = $query->get();

        $data = ['rows' => $manufacturer];
        return view('admin.manufacturers.index')->with($data);
    }

    public function export() {
        return Excel::download(new ManufacturersExport(), 'manufacturers.xlsx');
    }

    public function import() {
        Excel::import(new ManufacturersImport,request()->file('file'));
        return back();
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name.*' => 'required',
            'logo' => 'required',
            # 'slug.*' => 'required|unique:manufacturer_translations,slug',
        ]);

        $manufacturer = new Manufacturer();

        $logo = upload_file($request->file('logo'), 'manufacturers');
        if ($logo) $manufacturer->logo = $logo;
        
        $manufacturer->save();

        foreach($this->languages as $local){
            $manufacturerTrans = new ManufacturerTranslation();
            $manufacturerTrans->manufacturer_id = $manufacturer->id;
            $manufacturerTrans->name = $request->input('name.'.$local->locale);

            $manufacturerTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $manufacturerTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $manufacturerTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $manufacturerTrans->locale = $local->locale;
            $manufacturerTrans->save();
        }

        # Manufacturer::create($request->all());
        $logPayload = ['msg' => 'Manufacturer Added', 'model_id' => $manufacturer->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);      
        return redirect()->route('admin.manufacturers.index');

    }

    public function show(Manufacturer $manufacturer)
    {
        $data = ['row' => $manufacturer];
        return view('admin.manufacturers.show')->with($data);
    }


    public function edit(Manufacturer $manufacturer)
    {

        $data = [
            'row'           => $manufacturer,
        ];
        return view('admin.manufacturers.edit')->with($data);
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {

        $request->validate([
            'name.*' => 'required',
            'logo' => 'required',
            # 'slug.*' => 'required',
        ]);

        $logo = upload_file($request->file('logo'), 'manufacturers');
        if ($logo) $manufacturer->logo = $logo;
        $manufacturer->save();

        foreach($this->languages as $local){
            $manufacturerTrans = ManufacturerTranslation::where([
                'manufacturer_id' => $manufacturer->id,
                'locale' => $local->locale,
            ])->first();
            if (!$manufacturerTrans) $manufacturerTrans = new ManufacturerTranslation();
            $manufacturerTrans->manufacturer_id = $manufacturer->id;
            $manufacturerTrans->name = $request->input('name.'.$local->locale);

            $manufacturerTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $manufacturerTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $manufacturerTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $manufacturerTrans->locale = $local->locale;
            $manufacturerTrans->save();
        }
        $logPayload = ['msg' => 'Manufacturer Updated', 'model_id' => $manufacturer->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);      
        return redirect()->route('admin.manufacturers.index');

    }


    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturerTrans = ManufacturerTranslation::where('manufacturer_id','=',$manufacturer->id)->delete();
        $manufacturer->delete();
        return redirect()->route('admin.manufacturers.index');
    }

}
