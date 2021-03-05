<?php

namespace App\Http\Controllers\Admin;
use App\Package;
use App\PackageTranslation;
use App\Page;
use App\Language;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackagesController extends Controller
{
    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
        $packages = Package::all();
        $data = ['rows' => $packages];
        return view('admin.packages.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'name.*'                => 'required',
            'price'               => 'required',
            'duration'            => 'required',
            'description.*'         => 'required',
        ]);

        $package = new Package();
        $package->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $package->price = $request->input('price');
        $package->duration = $request->input('duration');

        $package->save();

        foreach($this->languages as $local){
            $packageTrans = new PackageTranslation();
            $packageTrans->package_id = $package->id;
            $packageTrans->name = $request->input('name.'.$local->locale);
            $packageTrans->description = $request->input('description.'.$local->locale);

            $packageTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $packageTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $packageTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $packageTrans->locale = $local->locale;
            $packageTrans->save();
        }

        $logPayload = ['msg' => 'Package Added', 'model_id' => $package->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.packages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        $data = ['row' => $package];
        return view('admin.packages.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $data = [
            'row'           => $package,
        ];
        return view('admin.packages.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name.*'                => 'required',
            'price.*'               => 'required',
            'duration'            => 'required',
            'description'         => 'required',
        ]);

        $package->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $package->duration = $request->input('duration');
        $package->price = $request->input('price');
        $package->save();

        foreach($this->languages as $local){
            $packageTrans = PackageTranslation::where([
                'locale' => $local->locale,
            ])->first();
            if (!$packageTrans) $categoryTrans = new PackageTranslation();
            $packageTrans->name = $request->input('name.'.$local->locale);
            $packageTrans->description = $request->input('description.'.$local->locale);

            $packageTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $packageTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $packageTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $packageTrans->locale = $local->locale;
            $packageTrans->save();
        }
        $logPayload = ['msg' => 'Package Updated', 'model_id' => $package->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index');
    }
}
