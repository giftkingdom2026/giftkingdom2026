<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Language;
use App\Models\Core\Setting;
use App\Models\Web\Index;
use App\Models\Core\Categories;
use App\Models\Core\Brands;
use App\Models\Core\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class SiteSettingController extends Controller
{

    public function __construct()
    {
        $setting = new Setting();
        $this->Setting = $setting;

    }

    public function commonsetting()
    {
        $result = array('pagination' => '20');
        return $result;
    }

    public function getSetting()
    {

        $setting = $this->Setting->getSettings();
        return $setting;
    }

    public function imageType()
    {
        $extensions = array('gif', 'jpg', 'jpeg', 'png');
        return $extensions;
    }


    //setting page
    public function setting(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.setting"));

        $result = array();

        $settings = $this->Setting->getallsetting();

        $result['settings'] = $settings->unique('id')->keyBy('id');
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.settings.general.setting", $title)->with('result', $result);
    }

    public function updateSetting(Request $request)
    {

        $data = $request->all();

        $lang = isset($data['lang']) ? $data['lang'] : 1;

        foreach ($data as $key => $value)  :

            Setting::settingUpdate($key, $value,$lang);

        endforeach;

        return redirect()->back()->withErrors(['Settings Updated Successfully!']);
    }

    public function getlanguages()
    {
        $languages = $this->Setting->fetchLanguages();
        return $languages;
    }
        public function popup(Request $request)
    {

        $images = new Images;
        $allimage = $images->getimages();
        $title = array('pageTitle' => Lang::get("labels.setting"));

        $result = array();

        $settings = $this->Setting->websetting();

        $result['settings'] = $settings->unique('id')->keyBy('id');
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.settings.general.popup", $title)->with('result', $result)->with('allimage', $allimage);

    }
    //webSettings

    public function webSettings(Request $request){

        $images = new Images;
        $allimage = $images->getimages();
        $title = array('pageTitle' => Lang::get("labels.setting"));
        $result = array();
        $settings = $this->Setting->websetting();
        $result['settings'] = $settings->unique('id')->keyBy('id');
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.settings.general.websetting", $title)->with('result', $result)->with('allimage', $allimage);

    }

    public function homeContent(Request $request)
    {

        $title = ['pageTitle' => 'Home Page Content'];

        $result['commonContent'] = $this->Setting->commonContent();
        
        $products = Products::all();

        $products ? $products = $products->toArray() : '';

        $result['products'] = $products;

        $categories = Categories::where('category_type','category')->get();
        
        $categories ? $categories = $categories->toArray() : '';

        $result['categories'] = $categories;
        
        $result['deals'] = Categories::where('category_type','deals')->get();

        $result['brands'] = Brands::all()->toArray();
        
        return view("admin.settings.home-content", $title)->with('result', $result);

    }


    public function changeLang(Request $request){

        $cond = str_contains(request()->fullUrl(), 'setting');

        if( $cond ) :

           $result = array();
           $settings = $this->Setting->websetting($request->lang);
           $result['settings'] = $settings->unique('id')->keyBy('id');
           $result['commonContent'] = $this->Setting->commonContent($request->lang);

           return view("admin.settings.general.fields")->with('result', $result)->render();

       else :

        $title = ['pageTitle' => 'Home Page Content'];
        
        $result['commonContent'] = $this->Setting->commonContent($request->lang);
        
        $products = Products::all();

        $products ? $products = $products->toArray() : '';

        $result['products'] = $products;

        $categories = Categories::where('category_type','category')->get();
        
        $categories ? $categories = $categories->toArray() : '';

        $result['categories'] = $categories;

        return view("admin.settings.fields", $title)->with('result', $result)->render();

    endif;

}

}
