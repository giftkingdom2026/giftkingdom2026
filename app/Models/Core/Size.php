<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class Size extends Model
{
    //
    use Sortable;
    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function size_description(){
        return $this->belongsTo('App\size_description');
    }

    public $sortable =['size_id','created_at'];
    public $sortableAs =['size_name'];

    public function recursivesize(){
      $items = DB::table('size')
          ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
          ->select('size.size_id', 'size_description.size_name','size.size_slug', 'size.parent_id')
          ->where('language_id','=', 1)
          ->where('size_status', '1')
          //->orderby('size_id','ASC')
          ->get();
          $childs = array();
          foreach($items as $item)
              $childs[$item->parent_id][] = $item;

          foreach($items as $item) if (isset($childs[$item->size_id]))
              $item->childs = $childs[$item->size_id];
          if(count($childs)>0){
            $tree = $childs[0];
          }else{
            $tree = $childs;
          }

          return  $tree;
    }



    public function recursivewebslidersize(){
      $items = DB::table('web_slider_size')
          ->leftJoin('web_slider_size_description','web_slider_size_description.size_id', '=', 'web_slider_size.size_id')
          ->select('web_slider_size.size_id', 'web_slider_size_description.size_name', 'web_slider_size.parent_id')
          ->where('language_id','=', 1)
          ->where('size_status', '1')
          //->orderby('size_id','ASC')
          ->get();

          $childs = array();
          foreach($items as $item)
              $childs[$item->parent_id][] = $item;

          foreach($items as $item) if (isset($childs[$item->size_id]))
              $item->childs = $childs[$item->size_id];
          if(count($childs)>0){
            $tree = $childs[0];
          }else{
            $tree = $childs;
          }

          return  $tree;
    }



    public function editrecursivesize($data){
      $items = DB::table('size')
          ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
          ->select('size.size_id', 'size_description.size_name', 'size.parent_id')
          ->where('language_id','=', 1)
          // ->where('size.size_id','!=', $data->id)
          ->where('size_status', '1')
          ->get();

          $childs = array();
          foreach($items as $item)
              $childs[$item->parent_id][] = $item;

          foreach($items as $item) if (isset($childs[$item->size_id]))
              $item->childs = $childs[$item->size_id];

              if(count($childs)>0){
                  $tree = $childs[0];
                }else{
                  $tree = $childs;
                }
          return  $tree;
    }

    public function paginator(){
      $setting = new Setting();
      $myVarsetting = new SiteSettingController($setting);
      $commonsetting = $myVarsetting->commonsetting();

      $size = DB::table('size')
           ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
           ->LeftJoin('image_categories as sizeTable', function ($join) {
                $join->on('sizeTable.image_id', '=', 'size.size_image')
                    ->where(function ($query) {
                        $query->where('sizeTable.image_type', '=', 'THUMBNAIL')
                            ->where('sizeTable.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('sizeTable.image_type', '=', 'ACTUAL');
                    });
            })
         

            ->LeftJoin('size_description as parent_description', function ($join) {
                $join->on('parent_description.size_id', '=', 'size.parent_id')
                    ->where(function ($query) {
                        $query->where('parent_description.language_id', '=', 1)->limit(1);
                    });
            })
            ->select('size.size_id as id', 'size.size_image as image',
              'size.created_at as date_added',
            'size.updated_at as last_modified', 'size_description.size_name as name',
            'size_description.language_id','sizeTable.path as imgpath', 
            'size.size_status  as size_status', 'parent_description.size_name as parent_name','size.sort_order')
         
            ->where('size_description.language_id', '1')
            
            ->groupby('size.size_id')
            ->paginate(250);
        
          

            return ($size);
    }





    public function web_slider_paginator(){
      $setting = new Setting();
      $myVarsetting = new SiteSettingController($setting);
      $commonsetting = $myVarsetting->commonsetting();

      $size = DB::table('web_slider_size')
           ->leftJoin('web_slider_size_description','web_slider_size_description.size_id', '=', 'web_slider_size.size_id')
           ->LeftJoin('image_categories as sizeTable', function ($join) {
                $join->on('sizeTable.image_id', '=', 'web_slider_size.size_image')
                    ->where(function ($query) {
                        $query->where('sizeTable.image_type', '=', 'THUMBNAIL')
                            ->where('sizeTable.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('sizeTable.image_type', '=', 'ACTUAL');
                    });
            })
            ->LeftJoin('image_categories as iconTable', function ($join) {
                $join->on('iconTable.image_id', '=', 'web_slider_size.size_icon')
                    ->where(function ($query) {
                        $query->where('iconTable.image_type', '=', 'THUMBNAIL')
                            ->where('iconTable.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('iconTable.image_type', '=', 'ACTUAL');
                    });
            })

            ->LeftJoin('web_slider_size_description as parent_description', function ($join) {
                $join->on('parent_description.size_id', '=', 'web_slider_size.parent_id')
                    ->where(function ($query) {
                        $query->where('parent_description.language_id', '=', 1)->limit(1);
                    });
            })
            ->select('web_slider_size.size_id as id', 'web_slider_size.size_image as image',
            'web_slider_size.size_icon as icon',  'web_slider_size.created_at as date_added',
            'web_slider_size.updated_at as last_modified', 'web_slider_size_description.size_name as name',
            'web_slider_size_description.language_id','sizeTable.path as imgpath','iconTable.path as iconpath', 
            'web_slider_size.size_status  as size_status', 'parent_description.size_name as parent_name')
         
            ->where('web_slider_size_description.language_id', '1')
            
            ->groupby('web_slider_size.size_id')
            ->paginate(50);
         



            return ($size);
    }

    public function getter($language_id){
      $listingsize = DB::table('size')
          ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
          ->select('size.size_id as id', 'size.size_image as image',  'size.created_at as date_added', 'size.updated_at as last_modified', 'size_description.size_name as name', 'size.size_slug as slug'
          , 'size.parent_id')
          ->where('size_description.language_id','=', $language_id )
          ->where('parent_id','>', '0')
          ->where('size_status', '1')
          ->get();

       return $listingsize;
    }



    public function getterslidersize($language_id){
      $listingsize = DB::table('web_slider_size')
          ->leftJoin('web_slider_size_description','web_slider_size_description.size_id', '=', 'web_slider_size.size_id')
          ->select('web_slider_size.size_id as id', 'web_slider_size.size_image as image',  'web_slider_size.created_at as date_added', 'web_slider_size.updated_at as last_modified', 'web_slider_size_description.size_name as name', 'web_slider_size.size_slug as slug'
          , 'web_slider_size.parent_id')
          ->where('web_slider_size_description.language_id','=', $language_id )
 
          ->where('size_status', '1')
          ->get();

       return $listingsize;
    }


    public function gettersliderbrand($language_id){
      $listingsize = DB::table('web_slider_size')
          ->leftJoin('web_slider_size_description','web_slider_size_description.size_id', '=', 'web_slider_size.size_id')
          ->select('web_slider_size.size_id as id', 'web_slider_size.size_image as image',  'web_slider_size.created_at as date_added', 'web_slider_size.updated_at as last_modified', 'web_slider_size_description.size_name as name', 'web_slider_size.size_slug as slug'
          , 'web_slider_size.parent_id')
          ->where('web_slider_size_description.language_id','=', $language_id )

          ->where('size_status', '1')
          ->get();

       return $listingsize;
    }



    public function getterParent($language_id){
        $listingsize = DB::table('size')
            ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
            ->select('size.size_id as id', 'size.size_image as image',  'size.created_at as date_added', 'size.updated_at as last_modified', 'size_description.size_name as name', 'size.size_slug as slug'
            , 'size.parent_id')
            ->where('size_description.language_id','=', $language_id )
            ->where('parent_id', '0')
            ->where('size_status', '1')
            ->get();
  
         return $listingsize;
      }
      public function getterParent2($language_id){
        $listingsize = DB::table('size')
            ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
            ->select('size.size_id as id', 'size.size_image as image',  'size.created_at as date_added', 'size.updated_at as last_modified', 'size_description.size_name as name', 'size.size_slug as slug'
            , 'size.parent_id')
            ->where('size_description.language_id','=', $language_id )
            // ->where('parent_id', '0')
            ->where('size_status', '1')
            ->get();
  
         return $listingsize;
      }

    public function allsize($language_id){
        $listingsize = DB::table('size')
            ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
            ->select('size.size_id as id', 'size.size_image as image',  'size.created_at as date_added', 'size.updated_at as last_modified', 'size_description.size_name as name', 'size.size_slug as slug')
            ->where('size_description.language_id','=', $language_id )
            ->where('size_status', '1')
            ->get();
  
         return $listingsize;
      }


      public function allsizewebslider($language_id){
        $listingsize = DB::table('web_slider_size')
            ->leftJoin('web_slider_size_description','web_slider_size_description.size_id', '=', 'web_slider_size.size_id')
            ->select('web_slider_size.size_id as id', 'web_slider_size.size_image as image',  'web_slider_size.created_at as date_added', 'web_slider_size.updated_at as last_modified', 'web_slider_size_description.size_name as name', 'web_slider_size.size_slug as slug')
            ->where('web_slider_size_description.language_id','=', $language_id )
            ->where('size_status', '1')
            ->get();
  
         return $listingsize;
      }


    public function filter($data){
      $name = $data['FilterBy'];
      $param = $data['parameter'];

      switch ( $name ) {
          case 'Name':
              $size = size::sortable(['size_id'=>'ASC'])
                    ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
                        ->leftJoin('images','images.id', '=', 'size.size_image')
                        ->leftJoin('image_categories as sizeTable','sizeTable.image_id', '=', 'size.size_image')
                        ->leftJoin('image_categories as iconTable','iconTable.image_id', '=', 'size.size_icon')
                        ->select('size.size_id as id', 'size.size_image as image',
                        'size.size_icon as icon',  'size.created_at as date_added',
                        'size.updated_at as last_modified', 'size_description.size_name as name',
                        'size_description.language_id','sizeTable.path as imgpath','iconTable.path as iconpath','size.size_status  as size_status')
                        ->where('size_description.language_id', '1')
                        ->where(function($query) {
                            $query->where('sizeTable.image_type', '=',  'THUMBNAIL')
                                ->where('sizeTable.image_type','!=',   'THUMBNAIL')
                                ->orWhere('sizeTable.image_type','=',   'ACTUAL')
                                ->where('iconTable.image_type', '=',  'THUMBNAIL')
                                ->where('iconTable.image_type','!=',   'THUMBNAIL')
                                ->orWhere('iconTable.image_type','=',   'ACTUAL');
                        })
                        ->where('size_description.size_name', 'LIKE', '%' . $param . '%')
                        ->groupby('size.size_id')
                        ->paginate(10);

          break;
          case 'Main':

              $size = size::sortable(['size_id'=>'ASC'])
                  ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')

                  ->leftJoin('size as mainsize','mainsize.size_id', '=', 'size.size_id')
                  ->leftJoin('size_description as mainsizeDesc','mainsizeDesc.size_id', '=', 'size.parent_id')

                  ->leftJoin('image_categories as sizeTable','sizeTable.image_id', '=', 'size.size_image')
                  ->leftJoin('image_categories as iconTable','iconTable.image_id', '=', 'size.size_icon')

                  ->select(
                      'size.size_id as subId',
                      'size.size_image as image',
                      'size.size_icon as icon',
                      'size.created_at as date_added',
                      'size.updated_at as last_modified',
                      'size_description.size_name as subsizeName',
                      'mainsizeDesc.size_name as mainsizeName',
                      'size_description.language_id','sizeTable.path as imgpath','iconTable.path as iconpath'
                  )
                  ->where('size.parent_id', '>', '0')
                  ->where('mainsizeDesc.size_name', 'LIKE', '%' . $param . '%')
                  ->where('mainsizeDesc.language_id', '1')
                  ->where('size_description.language_id', '1')
                  ->groupby('size.size_id')
                  ->paginate(10);
              break;
          default:
              $size = size::sortable(['size_id'=>'ASC'])
                  ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')

                  ->leftJoin('size as mainsize','mainsize.size_id', '=', 'size.size_id')
                  ->leftJoin('size_description as mainsizeDesc','mainsizeDesc.size_id', '=', 'size.parent_id')

                  ->leftJoin('image_categories as sizeTable','sizeTable.image_id', '=', 'size.size_image')
                  ->leftJoin('image_categories as iconTable','iconTable.image_id', '=', 'size.size_icon')

                  ->select(
                      'size.size_id as subId',
                      'size.size_image as image',
                      'size.size_icon as icon',
                      'size.created_at as date_added',
                      'size.updated_at as last_modified',
                      'size_description.size_name as subsizeName',
                      'mainsizeDesc.size_name as mainsizeName',
                      'size_description.language_id','sizeTable.path as imgpath','iconTable.path as iconpath'
                  )
                  ->where('size.parent_id', '>', '0')->where('mainsizeDesc.language_id', '1')
                  ->where('size_description.language_id', '1')
                  ->groupby('size.size_id')
                  ->paginate(10);
              break;
            }
        return $size;
    }

    public function insert($uploadImage,$date_added,$parent_id,$uploadIcon,$uploadBanner,$size_status,$show_home,$sort_order , $show_on_page){
      // echo 'dscdsc';exit;
        $size = DB::table('size')->insertGetId([
            'size_image'   =>   $uploadImage,
            'created_at'		 =>   $date_added,
            'parent_id'		 	 =>   $parent_id,
            // 'size_icon'    =>   $uploadIcon,
            'size_banner'	 =>	  $uploadBanner,
            'size_slug'    =>   'Null',
            'size_status' => $size_status,
            'show_on_page' => $show_on_page,
            'show_home' => $show_home,
            'sort_order' => $sort_order,
        ]);
        return $size;
    }


    public function insertwebslider($uploadImage,$uploadImage2,$uploadImage3,$isfeatured,$featured_image2,$ad1,$ad2,$ad3,$ad4,$ad5,$ad6,$date_added,$parent_id,$uploadIcon,$size_status,$video){
        $size = DB::table('web_slider_size')->insertGetId([
            'size_image'   =>   $uploadImage,
            'featured_image'   =>   $uploadImage2,
            'advantage_image'  => $uploadImage3,
            'is_featured'     =>   $isfeatured,
            'featured_image2' =>    $featured_image2,
            'advantag_one'   =>   $ad1,
            'advantag_two'   =>   $ad2,
            'advantag_three'   =>   $ad3,
            'advantag_four'   =>   $ad4,
            'advantag_five'   =>   $ad5,
            'advantag_six'   =>   $ad6,
            'created_at'     =>   $date_added,
            'parent_id'      =>   $parent_id,
            'size_icon'  =>   $uploadIcon,
            'size_slug'    =>   'Null',
            'size_status' => $size_status,
            'video'=>$video
        ]);
        return $size;
    }



    public function insertsizedescription($sizeNameSub,$size_id,$languages_data_id,$description, $outline, $size_svg){
        DB::table('size_description')->insert([
            'size_name'   =>   $sizeNameSub,
            'size_id'     =>   $size_id,
            'description' =>          $description,
            'outline' => $outline,
            'language_id'       =>   $languages_data_id,
            'svg'                =>  $size_svg,

        ]);
    }


    public function insertwebslidersizedescription($sizeNameSub,$sizeDescSub,$size_id,$languages_data_id){
        DB::table('web_slider_size_description')->insert([
            'size_name'   =>   $sizeNameSub,
            'size_desc'   =>   $sizeDescSub,
            'size_id'     =>   $size_id,
            'language_id'       =>   $languages_data_id
        ]);
    }

    public function checkSulg($currentSlug){
        $checkSlug = DB::table('size')->where('size_slug',$currentSlug)->get();
        return $checkSlug;
    }


    public function checkWebSliderSulg($currentSlug){
        $checkSlug = DB::table('web_slider_size')->where('size_slug',$currentSlug)->get();
        return $checkSlug;
    }

    public function edit($request){
        $size = DB::table('size') ->leftJoin('images','images.id', '=', 'size.size_image')
            ->leftJoin('image_categories as ImageTable','ImageTable.image_id', '=', 'size.size_image')
            ->leftJoin('image_categories as IconTable','IconTable.image_id', '=', 'size.size_icon')
            ->leftJoin('image_categories as bannerTable','bannerTable.image_id', '=', 'size.size_banner')
            ->select('size.size_id as id', 'size.size_image as image',
            'size.size_icon as icon',  'size.created_at as date_added',
            'size.updated_at as last_modified', 'size.size_slug as slug',
            'ImageTable.path as imagepath','IconTable.path as iconpath','size.size_banner as banner','bannerTable.path as bannerpath','size.show_home','size.sort_order')
            ->where('size.size_id', $request->id)->get();
        return $size;
    }

    public function updaterecord($size_id,$uploadImage,$uploadIcon,$uploadBanner,$last_modified,$parent_id,$slug,$size_status,$show_home,$sort_order,
        $show_on_page){
      // dd($uploadBanner);
      DB::table('size')->where('size_id', $size_id)->update(
      [
          'size_image'   =>   $uploadImage,
          // 'size_icon'    =>   $uploadIcon,
          'updated_at'  	     =>   $last_modified,
          'parent_id' 		     =>   $parent_id,
          'size_slug'    =>   $slug,
          'size_banner'  => $uploadBanner,
          'size_status'=>$size_status,
            'show_home' => $show_home,
            'sort_order' => $sort_order,
            'show_on_page' => $show_on_page,

      ]);
    }




    public function updaterecordwebslider($size_id,$uploadImage,$uploadImage2,$uploadIcon,$uploadImage3,$uploadImageAd,$isfeatured,$ad1,$ad2,$ad3,$ad4,$ad5,$ad6,$last_modified,$parent_id,$slug,$size_status,$video){

      DB::table('web_slider_size')->where('size_id', $size_id)->update(
      [
          'size_image'   =>   $uploadImage,
          'size_icon'    =>   $uploadIcon,
          'advantage_image'    => $uploadImageAd,
          'featured_image'     =>   $uploadImage2,
          'is_featured'        =>   $isfeatured,
          'featured_image2'    =>   $uploadImage3,
          'advantag_one'       =>   $ad1,
          'advantag_two'       =>   $ad2,
          'advantag_three'       =>   $ad3,
          'advantag_four'       =>   $ad4,
          'advantag_five'       =>   $ad5,
          'advantag_six'       =>   $ad6,
          'updated_at'         =>   $last_modified,
          'parent_id'          =>   $parent_id,
          'size_slug'    =>   $slug,
          'size_status'=>$size_status,
          'video'=>$video
      ]);
    }



    public function checkExit($size_id,$languages_data){
        $checkExist = DB::table('size_description')->where('size_id','=',$size_id)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function checkExitWebSlider($size_id,$languages_data){
        $checkExist = DB::table('web_slider_size_description')->where('size_id','=',$size_id)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }



    public function updatedescription($size_name,$size_svg,$languages_data,$size_id,$description , $outline){
       $size =  DB::table('size_description')->where('size_id','=',$size_id)->where('language_id','=',$languages_data->languages_id)->update([
            'size_name'  	    		 =>  $size_name,
            'description'=>$description,
            'outline' => $outline,
            'svg'                =>  $size_svg,
        ]);
       return $size;
    }


    public function updatedescriptionwebslider($size_name,$size_desc,$languages_data,$size_id){
       $size =  DB::table('web_slider_size_description')->where('size_id','=',$size_id)->where('language_id','=',$languages_data->languages_id)->update([
            'size_name'            =>  $size_name,
            'size_desc'            =>  $size_desc
        ]);
       return $size;
    }


    public function checkSlug($currentSlug){
        $checkSlug = DB::table('size')->where('size_slug',$currentSlug)->get();
        return $checkSlug;
    }

    public function updateSlug($size_id,$slug){
       $updateSlug = DB::table('size')->where('size_id',$size_id)->update([
            'size_slug'	 =>   $slug
        ]);
       return $updateSlug;
    }


    public function updateWebSliderSlug($size_id,$slug){
       $updateSlug = DB::table('web_slider_size')->where('size_id',$size_id)->update([
            'size_slug'  =>   $slug
        ]);
       return $updateSlug;
    }

    public function subsizedes(){
        $size = DB::table('size')
            ->leftJoin('size_description','size_description.size_id', '=', 'size.size_id')
            ->select('size.size_id as mainId', 'size_description.size_name as mainName')
            ->where('parent_id', '0')->get();
        return $size;
    }


    public function subsizedeswebslider(){
        $size = DB::table('web_slider_size')
            ->leftJoin('web_slider_size_description','web_slider_size_description.size_id', '=', 'web_slider_size.size_id')
            ->select('web_slider_size.size_id as mainId', 'web_slider_size_description.size_name as mainName')
            ->where('parent_id', '0')->get();
        return $size;
    }


    public function editsubsize($request){
        $editSubsize = DB::table('size')
            ->leftJoin('image_categories as sizeTable','sizeTable.image_id', '=', 'size.size_image')
            // ->leftJoin('image_categories as iconTable','iconTable.image_id', '=', 'size.size_icon')
            ->leftJoin('image_categories as bannerTable','bannerTable.image_id', '=', 'size.size_banner')
            ->select('size.size_id as id', 'size.size_image as image',  'size.created_at as date_added', 'size.updated_at as last_modified',
            'size.size_slug as slug', 'size.size_status  as size_status', 'size.parent_id as parent_id','sizeTable.path as imgpath','size.show_home','bannerTable.path as size_banner_path','size.size_banner','size.sort_order' , 'size.show_on_page as show_on_page')
            ->where('size.size_id', $request->id)->get();
        return $editSubsize;
    }


    public function editsubsizewebslider($request){
        $editSubsize = DB::table('web_slider_size')
            ->leftJoin('image_categories as sizeTable','sizeTable.image_id', '=', 'web_slider_size.size_image')
            ->leftJoin('image_categories as iconTable','iconTable.image_id', '=', 'web_slider_size.size_icon')
            ->leftJoin('image_categories as advantage','advantage.image_id', '=', 'web_slider_size.advantage_image')
            ->leftJoin('image_categories as sizeTable2','sizeTable2.image_id', '=', 'web_slider_size.featured_image')
            ->leftJoin('image_categories as sizeTable3','web_slider_size.featured_image2','=','sizeTable3.image_id')
            ->select('web_slider_size.size_id as id', 'web_slider_size.size_image as image',
              'web_slider_size.featured_image as image2','web_slider_size.featured_image2 as image3','web_slider_size.size_icon as icon',  'web_slider_size.created_at as date_added', 'web_slider_size.updated_at as last_modified',
            'web_slider_size.size_slug as slug', 'web_slider_size.size_status  as size_status', 'web_slider_size.parent_id as parent_id','sizeTable.path as imgpath','sizeTable2.path as imgpath2','iconTable.path as iconpath','sizeTable3.path as imgpath3','advantage.image_id as advantage_id','advantage.path as advantage_path')
            ->groupBy('web_slider_size.size_id')
            ->where('web_slider_size.size_id', $request->id)->get();
        return $editSubsize;
    }




    public function editdescription($languages_id,$id){
        $description = DB::table('size_description')->where([
            ['language_id', '=', $languages_id],
            ['size_id', '=', $id],
        ])->get();
        return $description;
    }


    public function editdescriptionwebslider($languages_id,$id){
        $description = DB::table('web_slider_size_description')->where([
            ['language_id', '=', $languages_id],
            ['size_id', '=', $id],
        ])->get();
        return $description;
    }


    public function deleterecord($request){
        $size_id = $request->id;
        DB::table('size')->where('size_id', $size_id)->delete();
        DB::table('size_description')->where('size_id', $size_id)->delete();
        DB::table('products_to_size')->where('size_id', $size_id)->delete();
        return "success";
    }


    public function deleterecordwebslider($request){
        $size_id = $request->id;
        DB::table('web_slider_size')->where('size_id', $size_id)->delete();
        DB::table('web_slider_size_description')->where('size_id', $size_id)->delete();
        DB::table('web_slider_products_to_size')->where('size_id', $size_id)->delete();
        return "success";
    }
    

}
