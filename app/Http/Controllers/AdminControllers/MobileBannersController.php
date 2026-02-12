<?php
namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\Images;
//for password encryption or hash protected
use App\Models\Core\Languages;
use App\Models\Core\Setting;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use Illuminate\Support\Facades\Storage;

//for authenitcate login data
use Lang;

//for requesting a value

class MobileBannersController extends Controller
{

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
        $this->myVarsetting = new SiteSettingController($setting);

    }
    /*-------------------------------------------------Slider-----------------------------------------*/
    public function MobileBanner(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingSliders"));
        $result = array();
        $message = array();
         $banners = DB::table('mob_banner')
                ->leftJoin('languages', 'languages.languages_id', '=', 'mob_banner.languages_id')
            ->leftJoin('image_categories', 'mob_banner.mob_banner_image', '=', 'image_categories.image_id')
            ->select('mob_banner.*', 'image_categories.path',  'languages.name as language_name')
            ->where('image_categories.image_type','ACTUAL')
            ->groupBy('mob_banner.mob_banner_id')
            ->paginate(20);
         
        $result['message'] = $message;
        $result['sliders'] = $banners;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.web.mob_banner.index", $title)->with('result', $result);
    }
    /*-------------------------------------------------Add Slider Images-----------------------------------------*/
     public function addMobileBannerimage(Request $request)
    {
         
        $title = array('pageTitle' => Lang::get("labels.AddSliderImage"));
        $result = array();
        $message = array();
        $images = new Images();
        $allimage = $images->getimages();
        $myVar = new Languages();
        $result['languages'] = $myVar->getter();
        $result['message'] = $message;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.web.mob_banner.add", $title)->with(['result' => $result, 'allimage' => $allimage]);
    }
    /*-------------------------------------------------Add New Slide -----------------------------------------*/
    public function addMobileBanner(Request $request)
    {

        $images = new Images();
        $allimage = $images->getimages();
        $myVar = new Languages();
        $result['languages'] = $myVar->getter();
        $expiryDate = str_replace('/', '-', $request->expires_date);
        $expiryDateFormate = date('Y-m-d H:i:s', strtotime($expiryDate));
        $type = $request->type;
        $name = $request->title;
        $sliders_url = $request->sliders_url;
        if ($request->image_id) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = '';
        }
        DB::table('mob_banner')->insert([
            'mob_banner_title' => $name,
            'mob_banner_image' => $uploadImage,
            'mob_banner_url' => $sliders_url,
            'languages_id' => $request->languages_id,
        ]);

        $message = Lang::get("labels.SliderAddedMessage");
        return redirect()->back()->withErrors([$message]);
    }
    /*-------------------------------------------------Edit Slide -----------------------------------------*/
    public function editMobileBanner(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditSliderImage"));
        $result = array();
        $result['message'] = array();
        $banners = DB::table('mob_banner')
            ->leftJoin('image_categories', 'mob_banner.mob_banner_image', '=', 'image_categories.image_id')
            ->select('mob_banner.*', 'image_categories.path')
            ->where('mob_banner_id', $request->id)
            ->groupBy('mob_banner.mob_banner_id')
            ->first();
        $result['sliders'] = $banners;
        $images = new Images();
        $allimage = $images->getimages();
        $myVar = new Languages();
        $result['languages'] = $myVar->getter();
        $result['commonContent'] = $this->Setting->commonContent();
        return view('admin.settings.web.mob_banner.edit', $title)->with(['result' => $result, 'allimage' => $allimage]);
    }
    /*-------------------------------------------------Update Slide -----------------------------------------*/
    public function updateMobileBanner(Request $request)
    {   
        $myVar = new Languages();
        $languages = $myVar->getter();
        $expiryDate = str_replace('/', '-', $request->expires_date);
        $expiryDateFormate = date('Y-m-d H:i:s', strtotime($expiryDate));
        $name = $request->title;
        $sliders_url = $request->sliders_url;
        if ($request->image_id) {
            $uploadImage = $request->image_id;
            $countryUpdate = DB::table('mob_banner')->where('mob_banner_id', $request->id)->update([
                'mob_banner_title' => $name,
                'mob_banner_image' => $uploadImage,
                'mob_banner_url' => $sliders_url,
            ]);
        } else {
            $countryUpdate = DB::table('mob_banner')->where('mob_banner_id', $request->id)->update([
                'mob_banner_title' => $name,
                'mob_banner_url' => $sliders_url,
            ]);
        }
        $message = Lang::get("labels.SliderUpdatedMessage");
        return redirect()->back()->withErrors([$message]);
    }
    /*-------------------------------------------------Delete Slide -----------------------------------------*/
    public function deleteMobileBanner(Request $request)
    {
        DB::table('mob_banner')->where('mob_banner_id', $request->mob_banner_id)->delete();
        return redirect()->back()->withErrors([Lang::get("labels.SliderDeletedMessage")]);
    }

 
}
