<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Module;
use App\ModuleTranslation;
use App\Language;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use function PHPSTORM_META\type;
use Spatie\Permission\Models\Role;

class ModulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_module');
        $this->middleware('permission:create_module', ['only' => ['create','store']]);
        $this->middleware('permission:edit_module', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_module', ['only' => ['destroy']]);
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {

    	$query = Module::query();

        $query->orderBy('order_id', 'asc');

        $module = $query->get();

        $data = ['rows' => $module];
        return view('admin.modules.index')->with($data);
    }

    public function show(Module $module)
    {
        $data = ['row' => $module];
        return view('admin.modules.show')->with($data);
    }

    public function edit(Module $module)
    {
        $dbCat = Category::get();
        $categories = [];
        $this->getCategories($dbCat, $categories);

        $data = [
            'row'           => $module,
            'categories'    => $categories,
            'content'       => json_decode($module->content)
        ];
        return view('admin.modules.edit')->with($data);
    }

    function getCategories($categories, &$result, $parent_id = 0, $depth = 0)
    {
        //filter only categories under current "parent"
        $cats = $categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        //loop through them
        foreach ($cats as $cat)
        {
            //add category. Don't forget the dashes in front. Use ID as index
            $result[$cat->id] = str_repeat('-', $depth) . ($depth ? ' ' : '') . $cat->name;
            //go deeper - let's look for "children" of current category
            $this->getCategories($categories, $result, $cat->id, $depth + 1);
        }
    }

    private function fixIt($data) {
        $_data = [];
        foreach ($data as $key => $input) {
            if ($input instanceof UploadedFile) {
                if ($input->isValid()) {
                    $_data[$key] = upload_file($input, 'modules');
                } else {
                    $_data[$key] = '';
                }
            } else {

                if (gettype($input) == 'array') {
                    $_data[$key] = $this->fixIt($input);
                } else {
                    if(substr($key, -1) == '~') {
                        $key = substr($key, 0, -1);
                    }
                    $_data[$key] = $input;
                }
            }
        }
        return $_data;
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            # 'name.*' => 'required',
            # 'logo' => 'required',
        ]);

        $module = Module::find($id);
        $module->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $module->order_id = $request->get('order_id');
        # $module->place = $request->get('place');
        # $module->save();

        $data = $request->except(['_method', '_token', 'active']);

        # if($request->get('slide')) {
        #    $data = $request->all()['slide'];
        # }

        $_data = $this->fixIt($data);

        $module->content = json_encode($_data);
        $module->save();
        $logPayload = ['msg' => 'Module Updated', 'model_id' => $module->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);          
        return redirect()->route('admin.modules.index');

    }

    public function saveOrder(Request $request) {

        $order = 1;
        foreach ($request->get('ids') as $id) {
            Module::where('id', $id)->update([
                'order_id' => $order
            ]);
            $order++;
        }


        return $request->ajax() ? [] : back();
    }

    public function active(Request $request, $id, $active) {

        Module::where('id', $id)->update([
            'is_active' => $active
        ]);

        return $request->ajax() ? [] : back();
    }


    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index');
    }

}
