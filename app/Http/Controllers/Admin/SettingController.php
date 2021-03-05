<?php

namespace App\Http\Controllers\Admin;

use App\Field;
use App\Language;
use App\Option;
use App\OptionValue;
use App\Setting;
use App\SettingTranslation;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artisan;
use App\MainSetting;
class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view_setting');
        $this->middleware('permission:create_setting', ['only' => ['create','store']]);
        $this->middleware('permission:edit_setting', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_setting', ['only' => ['destroy']]);
    }

    public function index()
    {
        $setting = Setting::all();
        return view ('admin.setting.index',compact('setting'));
    }
    function setEnv($name, $value)
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
            ));
        }
    }
    public function main_setting()
    {
        $this->main_settings_rows();
        $settings = MainSetting::all();
        $facebook_id = env('FACEBOOK_CLIENT_ID');
        $facebook_secret = env('FACEBOOK_CLIENT_SECRET');
        $google_id = env('GOOGLE_CLIENT_ID');
        $google_secret = env('GOOGLE_CLIENT_SECRET');
        $twitter_id = env('TWITTER_CLIENT_ID');
        $twitter_secret = env('TWITTER_CLIENT_SECRET');
        return view ('admin.setting.main')->with(compact('facebook_id','facebook_secret','google_id','google_secret','twitter_id','twitter_secret','settings'));
    }
    public function main_settings_rows(){
        $keys = ['point_value','free_shipping','cancel_orders_status','ended_orders_status','discount_priority'];
        foreach ($keys as $key) {
            $check = MainSetting::where('key','=',$key)->get()->first();
            if(!$check){
                $insert = new MainSetting;
                $insert->key = $key;
                $insert->value = '';
                $insert->save();
            }
        }
    }
    public function main_setting_post(Request $request)
    {
        $this->setEnv('FACEBOOK_CLIENT_ID',$request->input('facebook_id'));
        $this->setEnv('FACEBOOK_CLIENT_SECRET',$request->input('facebook_secret'));
        $this->setEnv('GOOGLE_CLIENT_ID',$request->input('google_id'));
        $this->setEnv('GOOGLE_CLIENT_SECRET',$request->input('google_secret'));
        $this->setEnv('TWITTER_CLIENT_ID',$request->input('twitter_id'));
        $this->setEnv('TWITTER_CLIENT_SECRET',$request->input('twitter_secret'));

        $main = MainSetting::all();
        foreach($main as $setting){
            $setting->value = strtolower($request->input($setting->key));
            $setting->save();
        }


        return redirect('/big-boss/main_setting');
    }

    public function create()
    {
        $len = Language::all();
        return view('admin.setting.create',compact('len'));
    }

    public function store(Request $request)
    {
        $lan = Language::all();
        $setting = new Setting();
        $setting->save();
        foreach($lan as $local) {
            $set = new SettingTranslation();
            $set->setting_id = $setting->id ;
            $set->locale = $local->locale ;
            $set->name = $request->get('name_'.$local->locale);
            $set->description = $request->get('description_'.$local->locale);
            $set->save();
        }
        $logPayload = ['msg' => 'Setting Added', 'model_id' => $setting->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);  
        return redirect()->route('admin.setting.index');

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $len = Language::all();
        $setting = Setting::find($id);
        return view('admin.setting.edit',compact('len','setting'));
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $lan = Language::all();
        $setting = Setting::find($id);
        foreach($lan as $local) {
            $set = SettingTranslation::where(['setting_id'=>$id,"locale"=>$local->locale])->first();
            $set->locale = $local->locale ;
            $set->name = $request->get('name_'.$local->locale);
            $set->description = $request->get('description_'.$local->locale);
            $set->save();
        }
        $logPayload = ['msg' => 'Setting Updated', 'model_id' => $setting->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.setting.index');

    }

    public function destroy($id)
    {
        Setting::find($id)->delete();
        return redirect()->route('admin.setting.index');
    }
}
