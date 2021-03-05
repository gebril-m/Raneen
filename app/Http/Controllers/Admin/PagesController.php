<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use App\Page;
use App\PageTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_page');
        $this->middleware('permission:create_page', ['only' => ['create','store']]);
        $this->middleware('permission:edit_page', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_page', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
//        return $pages;
        return view('admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $len = Language::all();
        return view('admin.pages.create',compact('len'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lan = Language::all();
        $page = new Page();
        $page->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $page->show_footer = $request->get('footer') == "on" ? 1 : 0 ;
        $page->show_header = $request->get('header') == "on" ? 1 : 0 ;
        $page->save();
        foreach($lan as $local){
            $pageTran = new PageTranslation();
            $pageTran->page_id = $page->id;
            $pageTran->name = $request->get('title_'.$local->locale);
            $pageTran->slug = trim(str_replace(' ',"-",$request->get('title_'.$local->locale)));
            $pageTran->body = $request->get('body_'.$local->locale);
            $pageTran->meta_title = $request->get('meta_title_'.$local->locale);
            $pageTran->meta_keywords = $request->get('meta_keywords_'.$local->locale);
            $pageTran->meta_description = $request->get('meta_description_'.$local->locale);
            $pageTran->locale = $local->locale;
            $pageTran->save();
        }
        $logPayload = ['msg' => 'Page Added', 'model_id' => $page->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return ['message'=>"The page was added successfully",'status'=>true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        $len = Language::all();
//        return $page ;
        return view('admin.pages.edit',compact('page','len'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lan = Language::all();
        $page = Page::find($id);
        $page->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $page->show_footer = $request->get('footer') == "on" ? 1 : 0 ;
        $page->show_header = $request->get('header') == "on" ? 1 : 0 ;
        $page->save();
        foreach($lan as $local){
            $pageTran = PageTranslation::where(['page_id'=>$id,"locale"=>$local->locale])->first();
            $pageTran->page_id = $id;
            $pageTran->name = $request->get('title_'.$local->locale);
            $pageTran->slug = trim(str_replace(' ',"-",$request->get('title_'.$local->locale)));
            $pageTran->body = $request->get('body_'.$local->locale);
            $pageTran->meta_title = $request->get('meta_title_'.$local->locale);
            $pageTran->meta_keywords = $request->get('meta_keywords_'.$local->locale);
            $pageTran->meta_description = $request->get('meta_description_'.$local->locale);
            $pageTran->locale = $local->locale;
            $pageTran->save();
        }
        $logPayload = ['msg' => 'Page Updated', 'model_id' => $page->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return ['message'=>"The page was added successfully",'status'=>true];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        Page::destroy($id);
//        return redirect()->back();
//    }
    public function uploadImage(Request $request)
    {

        if ($request->method() == 'GET') return [];

        $photo = $request->file('file');
        $img_new_name = str_random();
        $image_extension = $photo->getClientOriginalExtension();

        $path = strtolower("media/pages/" . str_slug($img_new_name) . "." . $image_extension);
        $image = file_get_contents($photo);
        Storage::put($path, $image);
//        return (new Response(json_encode(['fileName'=>$path , 'uploaded'=>1 , 'url' => $photoPath ]
//            , JSON_PRETTY_PRINT), 200))
//            ->header('Content-Type', 'application/json');
        return [
            "uploaded" => true,
            "default" => url('/' . $path)
        ];
    }

}
