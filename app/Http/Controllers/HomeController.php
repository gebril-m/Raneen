<?php

namespace App\Http\Controllers;

use App\Category;
use App\Module;
use App\Subscribers;
use App\Page;
use App\PageTranslation;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
Use View;
use App\Order;
use App\User;
use App\UserDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccess;
use Illuminate\Support\Facades\Log;
use Auth;
use Hash;
use Session;
use App\Mail\VerificationCode;
class HomeController extends Controller
{

    public function __construct()
    {

        $locale = App::getLocale();
        View::share('key', 'value');
        View::share('locale',$locale);
        // $this->middleware('verified',['except' => ['createAccount']]);
    }
    public function show_compare(){
        if(Session::has('compare')){
            $compare = Session::get('compare');
        }else{
            $compare = [];
        }
        if(count($compare) > 0){
            $compares = Product::whereIn('id',$compare)->get();
        }else{
            $compares = [];
        }
        return view('website.users.compare')->with(compact('compares'));
    }
    public function remove_compare($id){
        if(Session::has('compare')){
            $session = Session::get('compare');
        }
        $array = [];
        foreach ($session as $item) {
            if($item != $id){
                array_push($array, $item);
            }
        }
        Session::put('compare',$array);
        return "true";
    }
    public function compare($id){

        if(Session::has('compare')){
            $session = Session::get('compare');
        }else{
            $array = [];
            Session::put('compare',$array);
            $session = Session::get('compare');
        }
        if(Session::has('compare_cat') && count($session) > 0){
            $cat = Session::get('compare_cat');
            $product = ProductCategory::where('product_id','=',$id)->where('category_id','=',$cat)->orderBy('id','desc')->get()->first();
        }else{
            $product = ProductCategory::where('product_id','=',$id)->orderBy('id','desc')->get()->first();
            Session::put('compare_cat',$product->category_id);
            $cat = Session::get('compare_cat');
        }
        if($product){
            if(count($session) > 0){
                if(count($session) < 3){
                    if(!in_array($id, $session)){
                        if($cat == $product->category_id){
                            array_push($session, $id);
                            Session::put('compare',$session);
                            return "added";
                        }else{
                            return "Not the same category";
                        }
                    }else{
                        return "exist";
                    }
                }else
                return "limit";

            }else{
                if($product){
                    array_push($session, $id);
                    Session::put('compare',$session);
                    return "added";
                }
            }
        }else{
            return "Not the same category";
        }
        return Session::get('compare');
    }
    public function new()
    {
        $module = new Module();
        $homeCircleCategories = $module->homeCircleCategories();
        $homeCategories = $module->homeCategories();
        $bigSale = $module->bigSale();
        $slider = $module->slider();
        $homeTwoCards = $module->homeTwoCards();


        return view('website.index',compact('homeCircleCategories','homeCategories','bigSale','slider','homeTwoCards'));
    }

    public function login(Request $request)
    {
        if(Auth::user()){
            if($request->session()->has('url'))
       {
            $value = $request->session()->pull('url');

            return redirect($value);
        }
        return redirect('/');
        }
        return view('auth.login');
    }
    public function register()
    {
        if(Auth::user()){
            return redirect('/');
        }
        $page=Page::find(3);
        //dd($page);
        return view('auth.register',compact('page'));
    }

    public function createAccount(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => 'required',

        ]);

        $code = genRandomCode();

        // save user data
        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'verification_code' => $code,
            'contact_number' => $request->contact_number,
            'dob' => $request->dob,
            'password' => Hash::make($request->password),
            'is_active' => 1
        ]);
        // save details data
        UserDetail::create([
            'first_name' => $request->name,
            'user_id' => $user->id,
            'email' => $request->email,
        ]);

        // email
        Mail::to($user->email)->send(new VerificationCode($code) );
        // phone sms
        $sms = 'Your Raneen Account Verification Code Is ' . $code;
        //sendPhoneMessageNotification($sms, $request->contact_number);
        auth()->login($user);
        return redirect(route('web.account.verify.show'));
        return $user;
    }



    public function index(){
        dd('last_recentdfghedhg_orders');
        $last_recent_orders = \App\Order::latest()->limit(4)->get();
        return view('home.index',compact('last_recent_orders'));
    }

    public function page($slug){

        $locale = App::getLocale();
//        $page = $this->page($slug);
        $page =Page::whereHas('translations', function ($query) use($slug) {
            $query->where('slug', $slug);
        })->first();



        $contact = 0 ;
        if ((strpos(strtolower($page->name), 'contact') !== false) || (strpos($page->slug, 'اتصل') !== false)) {
            $contact = 1 ;
        }
        if(empty($page)){
            $locale = $locale == 'ar' ? 'en' :'ar' ;
            $url = url('/'.$locale.'/'.$slug.'/page');
            $page =Page::whereHas('translations', function ($query) use($slug,$locale) {
                $query->where('locale', $locale)
                    ->where('slug', $slug);
            })->first();
            if($page){
                return redirect()->to($url);
            }else{
                return redirect(404);
            }
        }

        return view('website.pages.page',compact('page','locale','contact'));

        // return view('pages.page',compact('page','locale','contact'));
    }

    public function response (){
        $response = session()->get('response');
        return view('response',compact('response'));
    }

    public function showMap (Request $request){
        $coords = [
            'lat' => $request->lat,
            'lng' => $request->lng
        ];

        return view('checkout.gmap')->with($coords);
    }

    public function trysms(){
        $text = 'Ranen Notification For The App';
        $receiver = '010********';
        sendPhoneMessageNotification($text, $receiver);
    }

    public function tryemail(){
        $order = Order::find(1);
        $email = 'a@a.com';
        Mail::to($email)->send(new OrderSuccess($order));
        return 'abcde';
    }

    public function trylogger(){
        return Log::channel('db')->info('m', ['message' => 'logging message', 'model_id' => 11]);
    }

    public function getPage($slug){
        $page =Page::whereHas('translations', function ($query) use($slug) {
            $query->where('slug', $slug);
        })->first();
        return $page ;

    }
    public function subscribe($email){
        $res=[];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $res=['status'=>'error','message' => __('home.not email')];
            return $res;
        }
        $check = Subscribers::where('email','=',$email)->get();
        if(count($check) > 0){
            $res=['status'=>'error','message' => __('home.exsited email')];
            return $res;
        }else{
            $new = new Subscribers;
            $new->email = $email;
            $new->save();
            $res=['status'=>'success','message' => __('home.subscribe success')];
            return $res;
        }
    }

    public function get_agree_terms()
    {
        $page=Page::find(3);
        return view('terms',compact('page'));
    }
}
