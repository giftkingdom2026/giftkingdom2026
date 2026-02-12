<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Seo;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Lang;
use DB;

class SeoController extends Controller
{

    public function __construct(Seo $seo,  Images $images, Setting $setting)
    {
        $this->Seo = $seo;
        $this->images = $images;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myalertsetting = new AlertController($setting);
        $this->Setting = $setting;

    }
    public function display(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.News"));
        $seo = $this->Seo->paginator();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.seo.index", $title)->with('seo', $seo)->with('result', $result);
    }

    public function add(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.AddNews"));
        $language_id = '1';
        $result = array();
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.seo.add", $title)->with('result', $result)->with('allimage', $allimage);

    }
    //addNewNews
    public function insert(Request $request)
    {
        // dd($request->all());
        $title = array('pageTitle' => Lang::get("labels.AddNews"));
        $seo_id = $this->Seo->insert($request);
        // $alertSetting = $this->myalertsetting->newsNotification($seo_id);
        $message = 'Seo has been added successfully';
        return redirect()->back()->withErrors([$message]);
    }
    //editnew
    public function edit(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.EditNews"));
        $result = $this->Seo->edit($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.seo.edit", $title)->with('result', $result)->with('allimage', $allimage);
    }
    //updatenew
    public function update(Request $request)
    {
        $this->Seo->updaterecord($request);
        $message = 'Seo has been update successfully!';
        return redirect()->back()->withErrors([$message]);
    }
    //deleteNews
    public function delete(Request $request)
    {
        $this->Seo->destroyrecord($request);
        return redirect()->back()->withErrors(['Seo has been deleted successfully!']);
    }

}
