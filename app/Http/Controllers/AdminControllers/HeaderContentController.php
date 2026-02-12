<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\News;
use App\Models\Core\NewsCategory;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Lang;
use DB;

class HeaderContentController extends Controller
{

    public function __construct(News $news, NewsCategory $news_category, Images $images, Setting $setting)
    {
        $this->News = $news;
        $this->NewsCategory = $news_category;
        $this->images = $images;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myalertsetting = new AlertController($setting);
        $this->Setting = $setting;

    }

    public function display_header_content(Request $request){

        $responseData = DB::table('header_content')
          ->leftjoin('image_categories','image_categories.image_id','=','header_content.image')
        ->select('header_content.*','image_categories.path')
        ->where('image_categories.image_type','=','ACTUAL')
        ->get();

        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.header_content.index")->with('header_contents', $responseData)->with('result', $result);
        
    }

    public function add_header_content(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddNews"));
        $allimage = $this->images->getimages();
        $language_id = '1';
        $result = array();
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.header_content.add", $title)->with('result', $result)->with('allimage', $allimage);
    }
    
    public function insert_header_content(Request $request)
    {     
        if ($request->image_id !== null) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = '';
        }
        $date_added = date('Y-m-d h:i:s');
        DB::table('header_content')->insert([
            'title' => $request->title,
            'image'=>$uploadImage,
            'outline' => $request->outline,
            'created_at' => $date_added
        ]);
        $message = Lang::get("machine has been added successfully");
        return redirect()->back()->withErrors([$message]);
    }

    public function edit_header_content($id)
    {
        $result['machine'] = DB::table('header_content')
        ->leftjoin('image_categories','image_categories.image_id','=','header_content.image')
        ->select('header_content.*','image_categories.path')
        ->where('image_categories.image_type','=','ACTUAL')
        ->where('header_content.id','=',$id)->get();
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.EditNews"));
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.header_content.edit", $title)->with('result', $result)->with('allimage', $allimage);
    }
    public function update_header_content(Request $request)
    {
        // dd($request->all());
        if ($request->image_id !== null) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = $request->oldImage;
        }
        DB::table('header_content')->where('id','=',$request->id)->update([
            'title' => $request->title,
            'outline' => $request->outline,
            'image'=>$uploadImage,
        ]);

        $message = Lang::get("machine has been updated successfully");
        return redirect()->back()->withErrors([$message]);
    }
    public function delete_header_content(Request $request)
    {
        DB::table('header_content')->where('id', $request->id)->delete();
        return redirect()->back()->withErrors(['machine has been deleted successfully!']);
    }
     public function header_content_content(request $request){
        $result['header_content_content'] = DB::table('header_content_content')
        ->leftjoin('image_categories','image_categories.image_id','=','header_content_content.image')
        ->select('header_content_content.*','image_categories.path as image_path')
        ->where('image_categories.image_type','=','ACTUAL')
        ->where('header_content_content.id','=','1')
        ->get();
        $title = array('pageTitle' => Lang::get("labels.EditNews"));
        $result['commonContent'] = $this->Setting->commonContent();
        $allimage = $this->images->getimages();

        return view("admin.header_content.content", $title)->with('result', $result)->with('allimage',$allimage);
    }
    public function header_content_contentUpdate(request $request){
      if ($request->image_id) {
            $uploadImage = $request->image_id;

        } else {
            $uploadImage = $request->oldImage;
        }
         DB::table('header_content_content')->where('id', '1')->update([
                    'heading1' => $request->heading1,
                    'text1' => $request->text1,
                    'heading2' => $request->heading2,
                    'text2' => $request->text2,
                    'image'=>$uploadImage,
                   
                ]);
        return redirect()->back()->withErrors(['machine Content has been updated successfully!']);

    }

}
