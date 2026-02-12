<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Countries;
use App\Models\Core\Setting;
use App\Models\Core\Tax_class;
use App\Models\Core\Tax_rate;
use App\Models\Core\Zones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use App\Models\Core\Categories;
use App\Models\Core\Products;

class MobileSliderController extends Controller
{
    //

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingCountries"));
        $sliderData = array();
        $message = array();
        $errorMessage = array();
        $sliderData['message'] = "Slider Not Found";
        $result['commonContent'] = $this->Setting->commonContent();
        $sliderData['slider']=DB::table('mobile_sliders')
        ->leftJoin('image_categories','image_categories.image_id','=','mobile_sliders.mobile_slider_banner_id')
        ->select('image_categories.path','mobile_sliders.*')
        ->where('image_type','=','ACTUAL')
        ->get();
        // dd($sliderData);
        return view("admin.mobile-slider.index", $title)->with('result', $result)->with('sliderData', $sliderData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => "Add Slider");
        $categories = Categories::get()->toArray();
        $products = Products::get()->toArray();
        $result['categories'] = $categories;
        $result['products'] = $products;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.mobile-slider.add", $title)->with('result', $result);
    }

    public function insert(Request $request)
    {
        // $title = array('pageTitle' => Lang::get("labels.EditCountry"));
        // $countryData = array();
        
        $data = $request->all();
        unset($data['_token']);
        if($data['mobile_slider_type'] == "category"){
            $data['mobile_slider_redirect'] =$data['mobile_slider_category'];
        }else if($data['mobile_slider_type'] =="product"){
            $data['mobile_slider_redirect'] = $data['mobile_slider_products'];

        }
        unset($data['mobile_slider_category']);
        unset($data['mobile_slider_products']);
        // dd($data);
        DB::table('mobile_sliders')->insert($data);
        // $categories_id = $this->Countries->insert($request);
        $message = "Mobile slider add successfully!";
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => "Edit Slider");
        $sliderData['slider']=DB::table('mobile_sliders')
        ->leftJoin('image_categories','image_categories.image_id','=','mobile_sliders.mobile_slider_banner_id')
        ->select('image_categories.path','mobile_sliders.*')
        ->where('image_type','=','ACTUAL')
        ->where('mobile_sliders.mobile_slider_id','=',$id)
        ->first();
        $categories = Categories::get()->toArray();
        $products = Products::get()->toArray();
        $result['categories'] = $categories;
        $result['products'] = $products;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.mobile-slider.edit", $title)->with('result', $result)->with('sliderData', $sliderData);
    }

    public function update(Request $request)
    {
        // $this->Countries->updaterecord($request);
        // dd($request->all());

        $data = $request->all();
        $id = $data['mobile_slider_id'];
        unset($data['_token']);
        if($data['mobile_slider_type'] == "category"){
            $data['mobile_slider_redirect'] =$data['mobile_slider_category'];
        }else if($data['mobile_slider_type'] =="product"){
            $data['mobile_slider_redirect'] = $data['mobile_slider_products'];

        }
        unset($data['mobile_slider_category']);
        unset($data['mobile_slider_products']);
        unset($data['mobile_slider_id']);
        $data['updated_at'] = date("Y-m-d H:i:s d m y");
        DB::table('mobile_sliders')->where('mobile_slider_id','=',$id)->update($data);
        $message = "Mobile slider update successfully!";
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        // $this->Countries->deleterecord($request);
        // dd($request->all());
        DB::table('mobile_sliders')->where('mobile_slider_id','=',$request->id)->delete();
        return redirect()->back()->withErrors("Mobile slider delete successfully!");
    }

    
}
