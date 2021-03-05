<?php

namespace App\Http\Controllers\Admin;

use App\Translation;
use App\Language;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;

class TranslationsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:view_translation');
        $this->middleware('permission:create_translation', ['only' => ['create','store']]);
        $this->middleware('permission:edit_translation', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_translation', ['only' => ['destroy']]);
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {

        $groups = Translation::distinct('group')->pluck('group')->toArray();

        $data = [
            "groups" => $groups
        ];
        return view('admin.translations.index')->with($data);
    }

    public function data() {

        $isOrder = \request()->get('order');

        if ($isOrder) $query = Translation::query();
        else $query = Translation::query()->orderBy('id','desc')->limit(10);

        $locale = \request()->get('locale');
        if($locale && $locale != 'all') {
            $query->where('locale', $locale);
        }

        $group = \request()->get('group');
        if($group && $group != 'all') {
            $query->where('group', $group);
        }

        return datatables()->of($query)
            ->addColumn('options', function (Translation $product) {

                $back = "";
//                $back .= '<a href="'. route('admin.translations.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
                $back .= '&nbsp;<a href="'. route('admin.translations.edit', $product->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

                $back .= \Form::open(['url'=>route('admin.translations.destroy', $product->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                $back .= method_field('DELETE');
                $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
                $back .= \Form::close();

                return $back;
            })
            ->rawColumns(['options', 'brand_manufacturer', 'name', 'is_active'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.translations.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'locale'    => 'required|max:2',
            'group'     => 'required|max:50',
            'item'      => 'required|max:255',
            'text'      => 'required',
        ]);

        $translation = new Translation();
        $translation->locale = $request->get('locale');
        $translation->group = $request->group;
        $translation->item = $request->item;
        $translation->text = $request->text;
        $translation->save();
        $logPayload = ['msg' => 'Translation Added', 'model_id' => $translation->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.translations.index');

    }

    public function show(Translation $translation)
    {
        $data = ['row' => $translation];
        return view('admin.translations.show')->with($data);
    }

    public function edit(Translation $translation)
    {

        $data = [
            'row'           => $translation,
        ];
        return view('admin.translations.edit')->with($data);
    }

    public function update(Request $request, Translation $translation)
    {

        $this->validate($request, [
            'locale'    => 'required|max:2',
            'group'     => 'required|max:50',
            'item'      => 'required|max:255',
            'text'      => 'required',
        ]);

        $translation->locale = $request->get('locale');
        $translation->group = $request->group;
        $translation->item = $request->item;
        $translation->text = $request->text;
        $translation->save();
        $logPayload = ['msg' => 'Translation Updated', 'model_id' => $translation->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);        
        return redirect()->route('admin.translations.index');

    }


    public function destroy(Translation $translation)
    {
        $translation->delete();
        return redirect()->route('admin.translations.index');
    }

}
