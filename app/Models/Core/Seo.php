<?php

namespace App\Models\Core;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Core\NewsCategory;
use App\Models\Core\NewsToNewsCategory;
use App\Models\Core\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Lang;

class Seo extends Model
{

    public $sortable = ['seo_id', 'is_feature', 'created_at'];
    public $sortableAs = ['news_name'];
    protected $table = "seo";
    use Sortable;

    public function paginator()
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $commonsetting = $myVarsetting->commonsetting();
        $language_id = '1';
        $seo = DB::table('seo')
            ->leftJoin('image_categories', 'image_categories.image_id', '=', 'seo.og_image')
            ->select('seo.*', 'image_categories.path as path')
            // ->where('post_type', '=','page')
            ->get();
        return $seo;
    }


    public function insert($request)
    {
        // dd($request->all());
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $myVaralter = new AlertController($setting);
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        $date_added = date('Y-m-d h:i:s');
        if ($request->image_id !== null) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = '';
        }
        // if ($request->image_id2 !== null) {
        //     $uploadImage2 = $request->image_id2;
        // } else {
        //     $uploadImage2 = '';
        // }

        $seo_id = DB::table('seo')->insertGetId([
            'og_image' => $uploadImage,
            'page_name' => $request->page_name,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            // 'og_keywords' => $request->og_keywords,
            // 'twiter_image' => $uploadImage2,
            // 'twitter_title' => $request->twitter_title,
            // 'twitter_description' => $request->twitter_description,
            // 'twiter_keywords' => $request->twiter_keywords,
            'page_slug' => '0',
            'post_type'=>$request->post_type,

        ]);
        if(isset($request->old_slug) && $request->old_slug != ''){
            DB::table('seo')->where('seo_id', $seo_id)->update([
                'page_slug' => $request->old_slug,
            ]);
        }else{
            $slug_flag = false;
            if ($slug_flag == false) {
                $slug_flag = true;
                $slug = $request->page_name;
                $old_slug = $request->page_name;
                $slug_count = 0;
                do {
                    if ($slug_count == 0) {
                        $currentSlug = $myVarsetting->slugify($slug);
                    } else {
                        $currentSlug = $myVarsetting->slugify($old_slug . '-' . $slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = DB::table('seo')->where('page_slug', $currentSlug)->get();
                    $slug_count++;
                } while (count($checkSlug) > 0);

                DB::table('seo')->where('seo_id', $seo_id)->update([
                    'page_slug' => $slug,
                ]);
            }
        }
        return $seo_id;
    }




    



    public function edit($request)
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $myVaralter = new AlertController($setting);
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        $language_id = '1';
        $seo_id = $request->id;
        $seo_slug = $request->slug;
        $seo_type = $request->type;
        $category_id = '0';
        $result = array();
        $result['languages'] = $myVarsetting->getLanguages();
        if($seo_slug != '' && $seo_id == ''){
            $seo = $this->GetNewsBySlug($seo_slug,$seo_type);
        }else{
            $seo = $this->GetNewsById($seo_id);
        }
        $description_data = array();
        $result['seo'] = $seo;
        return $result;
    }

    public function updaterecord($request)
    {
        // dd($request->all());
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $myVaralter = new AlertController($setting);
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        $language_id = '1';
        $seo_id = $request->id;
        $seo_last_modified = date('Y-m-d h:i:s');
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        if ($request->old_slug != $request->slug) {
            $slug = $request->slug;
            $slug_count = 0;
            do {
                if ($slug_count == 0) {
                    $currentSlug = $myVarsetting->slugify($request->slug);
                } else {
                    $currentSlug = $myVarsetting->slugify($request->slug . '-' . $slug_count);
                }
                $slug = $currentSlug;
                $checkSlug = DB::table('seo')->where('page_slug', $currentSlug)->where('seo_id', '!=', $seo_id)->get();
                $slug_count++;
            } while (count($checkSlug) > 0);

        } else {
            $slug = $request->slug;
        }

        if ($request->image_id) {
            $uploadImage = $request->image_id;

        } else {
            $uploadImage = $request->oldImage;
        }
        // if ($request->image_id2) {
        //     $uploadImage2 = $request->image_id2;

        // } else {
        //     $uploadImage2 = $request->oldImage2;
        // }
        DB::table('seo')->where('seo_id', '=', $seo_id)->update([
            'og_image' => $uploadImage,
            'page_name' => $request->page_name,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
             'meta_keywords' => $request->meta_keywords,
            'og_title' => $request->og_title,
            'og_description' => $request->og_description,
            // 'og_keywords' => $request->og_keywords,
            // 'twitter_title' => $request->twitter_title,
            // 'twitter_description' => $request->twitter_description,
            // 'twiter_keywords' => $request->twiter_keywords,
            // 'twiter_image' => $uploadImage2,
            'page_slug' => $request->slug,
        ]);
    }
    public function GetNewsById($seo_id)
    {

        $seo = DB::table('seo')
            ->leftJoin('image_categories as im1', 'im1.image_id', '=', 'seo.og_image')
            ->leftJoin('image_categories as im2', 'im2.image_id', '=', 'seo.twiter_image')
            ->select('seo.*', 'im1.path as path','im2.path as path2')
            ->where('seo.seo_id', '=', $seo_id)
            ->get();
        return $seo;
    }
     public function GetNewsBySlug($page_slug)
    {
        $seo = DB::table('seo')
            ->leftJoin('image_categories as im1', 'im1.image_id', '=', 'seo.og_image')
            ->leftJoin('image_categories as im2', 'im2.image_id', '=', 'seo.twiter_image')
            ->select('seo.*', 'im1.path as path','im2.path as path2')
            ->where('seo.page_slug', '=', $page_slug)
            ->get();
        return $seo;
    }

    public function destroyrecord($request)
    {
        DB::table('seo')->where('seo_id', $request->id)->delete();
        return 'success';
    }







}
