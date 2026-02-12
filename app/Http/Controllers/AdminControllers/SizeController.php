<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Size;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Models\Core\Manufacturers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;

class SizeController extends Controller
{
  public function __construct(Size $size, Setting $setting,Manufacturers $manufacturer)
  {
      $this->size = $size;
      $this->manufacturer = $manufacturer;
      $this->varseting = new SiteSettingController($setting);
      $this->Setting = $setting;
  }

  public function display(){
    $title = array('pageTitle' => Lang::get("labels.Subsize"));
    $size = $this->size->paginator();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.size.index",$title)->with('size', $size)->with('result', $result);
  }

  public function web_slide_display(){
    $title = array('pageTitle' => Lang::get("labels.Subsize"));
    $size = $this->size->web_slider_paginator();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.web_slider_size.index",$title)->with('size', $size)->with('result', $result);
  }


  public function filter(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Subsize"));
    $size = $this->size->filter($request);
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.size.index", $title)->with('result', $result)->with(['size'=> $size, 'name'=> $request->FilterBy, 'param'=> $request->parameter]);
  }

  public function add(Request $request){
    $title = array('pageTitle' => Lang::get("labels.AddSubsize"));
    $images = new Images;
    $allimage = $images->getimages();
    $result = array();
    $result['message'] = array();
    //get function from other controller
    $result['languages'] = $this->varseting->getLanguages();
    $size = $this->size->recursivesize();
    $parent_id = 0;
    $option = '<option value="0">'. Lang::get("labels.Leave As Parent").'</option>';
      foreach($size as $parents){
        $option .= '<option value="'.$parents->size_id.'">'.$parents->size_name.'</option>';
          if(isset($parents->childs)){
            $i = 1;
            $option .= $this->childcat($parents->childs, $i, $parent_id);
          }
      }
    $result['size'] = $option;
    $result['commonContent'] = $this->Setting->commonContent();
    $result['manufacturer'] = $this->manufacturer->getter(1);

    return view("admin.size.add",$title)->with('result', $result)->with('allimage', $allimage);
  }


  public function web_slide_add(Request $request){
    $title = array('pageTitle' => Lang::get("labels.AddSubsize"));

    $images = new Images;
    $allimage = $images->getimages();

    $result = array();
    $result['message'] = array();
    //get function from other controller
    $result['languages'] = $this->varseting->getLanguages();
    $size = $this->size->recursivewebslidersize();

    $parent_id = 0;
    $option = '<option value="0">'. Lang::get("labels.Leave As Parent").'</option>';

      foreach($size as $parents){
        $option .= '<option value="'.$parents->size_id.'">'.$parents->size_name.'</option>';

          if(isset($parents->childs)){
            $i = 1;
            $option .= $this->childcat($parents->childs, $i, $parent_id);
          }

      }

    $result['size'] = $option;
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.web_slider_size.add",$title)->with('result', $result)->with('allimage', $allimage);
  }

  public function childcat($childs, $i, $parent_id){
    $contents = '';
    foreach($childs as $key => $child){
      $dash = '';
      for($j=1; $j<=$i; $j++){
          $dash .=  '-';
      }
      //print(" <i>   ".$i." chgild");  echo '<pre>'.print_r($childs, true).'</pre>';
      if($child->size_id==$parent_id){
        $selected = 'selected';
      }else{
        $selected = '';
      }

      $contents.='<option value="'.$child->size_id.'" '.$selected.'>'.$dash.$child->size_name.'</option>';
      if(isset($child->childs)){

        $k = $i+1;
        $contents.= $this->childcat($child->childs,$k,$parent_id);
      }
      elseif($i>0){
        $i=1;
      }

    }
    return $contents;
  }

  public function insert(Request $request){


        $date_added	= date('y-m-d h:i:s');
        $result = array();

        $languages = $this->varseting->getLanguages();

        $sizeName = $request->sizeName;
        $parent_id = $request->parent_id;

        $uploadImage = $request->image_id;
        $uploadIcon  = $request->image_icone;
        $uploadBanner  = $request->image_icone2;
        $size_status  = $request->size_status;
        $show_on_page = $request->show_on_page;
        if(isset($request->show_home) && $request->show_home != ''){
         $show_home=$request->show_home;
       }else{
         $show_home='';
       }
       $sort_order=$request->sort_order;
        $size_id = $this->size->insert($uploadImage,$date_added,$parent_id,$uploadIcon,$uploadBanner,$size_status,$show_home,$sort_order,
          $show_on_page);
        
        $slug_flag = false;

    
        foreach($languages as $languages_data){
            $sizeName= 'sizeName_'.$languages_data->languages_id;
            $des='description'.$languages_data->languages_id;
            $outline_new='outline'.$languages_data->languages_id;

            //slug
            if($slug_flag==false){
                $slug_flag=true;
                $slug = $request->$sizeName;
                $old_slug = $request->$sizeName;
                $slug_count = 0;
                do{
                    if($slug_count==0){
                        $currentSlug = $this->varseting->slugify($old_slug);
                    }else{
                        $currentSlug = $this->varseting->slugify($old_slug.'-'.$slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = $this->size->checkSlug($currentSlug);
                    $slug_count++;
                }
                  while(count($checkSlug)>0);
                  $updateSlug = $this->size->updateSlug($size_id,$slug);
                }
            $sizeNameSub = $request->$sizeName;
            $languages_data_id = $languages_data->languages_id;
            $description=$request->$des;
            $outline=$request->$outline_new;
            $svg=$request->svg;
            $subcatoger_des = $this->size->insertsizedescription($sizeNameSub,$size_id,$languages_data_id,$description,$svg ,$outline);
        }

        $size =  $this->size->subsizedes();
        $result['size'] = $size;
        $message = Lang::get("labels.AddsizeMessage");
        return redirect()->back()->withErrors('Brand has been added');
  }




  public function web_slide_insert(Request $request){   

        $date_added = date('y-m-d h:i:s');
        $result = array();

        //get function from other controller
        $languages = $this->varseting->getLanguages();

        $sizeName = $request->sizeName;
        $sizeDesc = $request->sizeDesc;
        $parent_id = $request->parent_id;

        $uploadImage = $request->image_id;
        $uploadIcon  = $request->image_icone;
        $uploadImage2 = $request->image_id2;
        $uploadImage3 = $request->image_id3;
        $ad1 = $request->ad1;
        $ad2 = $request->ad2;
        $ad3 = $request->ad3;
        $ad4 = $request->ad4;
        $ad5 = $request->ad5;
        $ad6 = $request->ad6;
        $video = $request->file;

        if($request->isfeatured == "on"){
          $isfeatured = 1;
        }
        else{
          $isfeatured = 0;
        }


        $featured_image2 = $request->image_id4;


        $size_status  = $request->size_status;

        $size_id = $this->size->insertwebslider($uploadImage,$uploadImage2,$uploadImage3,$isfeatured,$featured_image2,$ad1,$ad2,$ad3,$ad4,$ad5,$ad6,$date_added,$parent_id,$uploadIcon,$size_status,$video);
        $slug_flag = false;

        //multiple lanugauge with record
        foreach($languages as $languages_data){
            $sizeName= 'sizeName_'.$languages_data->languages_id;
            $sizeDesc= 'sizeDesc_'.$languages_data->languages_id;
            //slug
            if($slug_flag==false){
                $slug_flag=true;
                $slug = $request->$sizeName;
                $old_slug = $request->$sizeName;
                $slug_count = 0;
                do{
                    if($slug_count==0){
                        $currentSlug = $this->varseting->slugify($old_slug);
                    }else{
                        $currentSlug = $this->varseting->slugify($old_slug.'-'.$slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = $this->size->checkWebSliderSulg($currentSlug);
                    $slug_count++;
                }
                  while(count($checkSlug)>0);
                  $updateSlug = $this->size->updateWebSliderSlug($size_id,$slug);
                }
            $sizeNameSub = $request->$sizeName;
            
            $sizeDescSub = $request->$sizeDesc;
            $languages_data_id = $languages_data->languages_id;
            $subcatoger_des = $this->size->insertwebslidersizedescription($sizeNameSub,$sizeDescSub,$size_id,$languages_data_id);
        }

        $size =  $this->size->subsizedeswebslider();
        $result['size'] = $size;
        $message = Lang::get("labels.AddsizeMessage");
        return redirect()->back()->withErrors([$message]);
  }






  public function edit(Request $request){
    // dd($request->id);
    $title = array('pageTitle' => Lang::get("labels.Editsize"));
    $images = new Images;
    $allimage = $images->getimages();

    $result = array();
    $result['message'] = array();

    //get function from other controller
    $result['languages'] = $this->varseting->getLanguages();
    $editSubsize = $this->size->editsubsize($request);
    // dd($editSubsize);
    $description_data = array();
    foreach($result['languages'] as $languages_data){
        $languages_id = $languages_data->languages_id;
        $id = $request->id;
        $description = $this->size->editdescription($languages_id,$id);
        // echo "<pre>";print_r($description);exit;
        if(count($description)>0){
            $description_data[$languages_data->languages_id]['name'] = $description[0]->size_name;
            $description_data[$languages_data->languages_id]['description'] = $description[0]->description;
            $description_data[$languages_data->languages_id]['outline'] = $description[0]->outline;

            $description_data[$languages_data->languages_id]['svg'] = $description[0]->svg;
            $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
            $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
        }else{
            $description_data[$languages_data->languages_id]['name'] = '';
            $description_data[$languages_data->languages_id]['description'] = '';
            $description_data[$languages_data->languages_id]['outline'] = '';

            $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
            $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
        }
    }

    $result['description'] = $description_data;
    $result['editSubsize'] = $editSubsize;

    $size = $this->size->editrecursivesize($request);
    $parent_id = $editSubsize[0]->parent_id;
    $option = '<option value="0">'. Lang::get("labels.Leave As Parent").'</option>';
    foreach($size as $parents){
      if($parents->size_id==$parent_id){
        $selected = 'selected';
      }else{
        $selected = '';
      }

      $option .= '<option value="'.$parents->size_id.'"  '.$selected.' >'.$parents->size_name.'</option>';
        $i = 1;
        if(isset($parents->childs)){
          $option .= $this->childcat($parents->childs, $i, $parent_id);
        }
    }

    $result['size'] = $option;
    $result['commonContent'] = $this->Setting->commonContent();
    
    return view("admin.size.edit",$title)->with('result', $result)->with('allimage', $allimage);
   }


   public function web_slide_edit(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Editsize"));
    $images = new Images;
    $allimage = $images->getimages();

    $result = array();
    $result['message'] = array();

    //get function from other controller
    $result['languages'] = $this->varseting->getLanguages();
    $editSubsize = $this->size->editsubsizewebslider($request);

    $description_data = array();
    foreach($result['languages'] as $languages_data){
        $languages_id = $languages_data->languages_id;
        $id = $request->id;
        $description = $this->size->editdescriptionwebslider($languages_id,$id);

        if(count($description)>0){
            $description_data[$languages_data->languages_id]['name'] = $description[0]->size_name;
            $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
            $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
        }else{
            $description_data[$languages_data->languages_id]['name'] = '';
            $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
            $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
        }
    }


    $size_description = DB::table('web_slider_size_description')->where([
            ['language_id', '=', $languages_id],
            ['size_id', '=', $id],
        ])->select('size_desc')->get();



    $result['size_description'] = $size_description;
    $result['description'] = $description_data;
    $result['editSubsize'] = $editSubsize;

    $size = $this->size->recursivewebslidersize($request);
  //  dd($editSubsize[0]->parent_id);
    $parent_id = $editSubsize[0]->parent_id;
    $option = '<option value="0">'. Lang::get("labels.Leave As Parent").'</option>';
    foreach($size as $parents){
      if($parents->size_id==$parent_id){
        $selected = 'selected';
      }else{
        $selected = '';
      }

      $option .= '<option value="'.$parents->size_id.'"  '.$selected.' >'.$parents->size_name.'</option>';
        $i = 1;
        if(isset($parents->childs)){
          $option .= $this->childcat($parents->childs, $i, $parent_id);
        }
    }

    $result['size'] = $option;
    $result['commonContent'] = $this->Setting->commonContent();


    $web_slider_cate = DB::table('web_slider_size')->where('size_id',$request->id)->get();
    $result['web_slider_size'] = $web_slider_cate;

    return view("admin.web_slider_size.edit",$title)->with('result', $result)->with('allimage', $allimage);
   }





   public function update(Request $request){
     $title = array('pageTitle' => Lang::get("labels.EditSubsize"));
     $result = array();
     $result['message'] = Lang::get("labels.size has been updated successfully");
     $last_modified 	=   date('y-m-d h:i:s');
     $parent_id = $request->parent_id;
     $size_id = $request->id;
     $size_status  = $request->size_status;
     $show_on_page  = $request->show_on_page;

     //get function from other controller
     $languages = $this->varseting->getLanguages();
     $extensions = $this->varseting->imageType();

     //check slug
     if($request->old_slug!=$request->slug){
         $slug = $request->slug;
         $slug_count = 0;
         do{
             if($slug_count==0){
                 $currentSlug = $this->varseting->slugify($request->slug);
             }else{
                 $currentSlug = $this->varseting->slugify($request->slug.'-'.$slug_count);
             }
             $slug = $currentSlug;
             $checkSlug = DB::table('size')->where('size_slug',$currentSlug)->where('size_id','!=',$request->id)->get();
             $slug_count++;
         }
         while(count($checkSlug)>0);
     }else{
         $slug = $request->slug;
     }
     if($request->image_id!==null){
         $uploadImage = $request->image_id;
     }else{
         $uploadImage = $request->oldImage;
     }

     if($request->image_icone !==null){
         $uploadIcon = $request->image_icone;
     }	else{
         $uploadIcon = $request->oldIcon;
     }

     if($request->image_icone2 !==null){
         $uploadBanner = $request->image_icone2;
     }  else{
         $uploadBanner = $request->oldIcon2;
     }
     if(isset($request->show_home) && $request->show_home != ''){
         $show_home=$request->show_home;
       }else{
         $show_home='';
       }
       $sort_order=$request->sort_order;

     $updatesize = $this->size->updaterecord($size_id,$uploadImage,$uploadIcon,$uploadBanner,$last_modified,$parent_id,$slug,$size_status,$show_home,$sort_order,$show_on_page);

     foreach($languages as $languages_data){
       $size_name = 'size_name_'.$languages_data->languages_id;
       $des='description'.$languages_data->languages_id;
       $outline_new='outline'.$languages_data->languages_id;
       $checkExist = $this->size->checkExit($size_id,$languages_data);
         $size_name = $request->$size_name;
         $size_svg = $request->svg;
         $description=$request->$des;
         $outline=$request->$outline_new;
         
         if(count($checkExist)>0){
           $size_des_update = $this->size->updatedescription($size_name,$size_svg,$languages_data,$size_id,$description,$outline);
       }else{
           $updat_des = $this->size->insertsizedescription($size_name,$size_svg,$size_id, $languages_data->languages_id,$description,$outline);
       }
     }

     $message = Lang::get("labels.CategorieUpdateMessage");
     return redirect()->back()->withErrors('Brand has been updated');
    }


    public function web_slide_update(Request $request){

    

     $title = array('pageTitle' => Lang::get("labels.EditSubsize"));
     $result = array();
     $result['message'] = Lang::get("labels.size has been updated successfully");
     $last_modified   =   date('y-m-d h:i:s');
     $parent_id = $request->parent_id;
     $size_id = $request->id;
     $size_status  = $request->size_status;

     //get function from other controller
     $languages = $this->varseting->getLanguages();
     $extensions = $this->varseting->imageType();

     //check slug
     if($request->old_slug!=$request->slug){
         $slug = $request->slug;
         $slug_count = 0;
         do{
             if($slug_count==0){
                 $currentSlug = $this->varseting->slugify($request->slug);
             }else{
                 $currentSlug = $this->varseting->slugify($request->slug.'-'.$slug_count);
             }
             $slug = $currentSlug;
             $checkSlug = DB::table('web_slider_size')->where('size_slug',$currentSlug)->where('size_id','!=',$request->id)->get();
             $slug_count++;
         }
         while(count($checkSlug)>0);
     }else{
         $slug = $request->slug;
     }
     if($request->image_id!==null){
         $uploadImage = $request->image_id;
     }else{
         $uploadImage = $request->oldImage;
     }

      if($request->image_id2!==null){
         $uploadImage2 = $request->image_id2;
     }else{
         $uploadImage2 = $request->oldImage2;
     }


      if($request->image_id4!==null){
         $uploadImage3 = $request->image_id4;
     }else{
         $uploadImage3 = $request->oldImage3;
     }


     if($request->image_id5!==null){
         $uploadImageAd = $request->image_id5;
     }else{
         $uploadImageAd = $request->oldadvantage;
     }

     if($request->image_icone !==null){
         $uploadIcon = $request->image_icone;
     }  else{
         $uploadIcon = $request->oldIcon;
     }

     if($request->isfeatured == "on"){
        $isfeatured = 1;
     }
     else{
        $isfeatured = 0;
     }



     $ad1 = $request->ad1;
     $ad2 = $request->ad2;
     $ad3 = $request->ad3;
     $ad4 = $request->ad4;
     $ad5 = $request->ad5;
     $ad6 = $request->ad6;

     $video = $request->file;

     $updatesize = $this->size->updaterecordwebslider($size_id,$uploadImage,$uploadImage2,$uploadIcon,$uploadImage3,$uploadImageAd,$isfeatured,$ad1,$ad2,$ad3,$ad4,$ad5,$ad6,$last_modified,$parent_id,$slug,$size_status,$video);

     foreach($languages as $languages_data){
       $size_name = 'size_name_'.$languages_data->languages_id;
       $size_desc = 'size_desc_'.$languages_data->languages_id;
       $checkExist = $this->size->checkExitWebSlider($size_id,$languages_data);
         $size_name = $request->$size_name;
         $size_desc = $request->$size_desc;
         if(count($checkExist)>0){
           $size_des_update = $this->size->updatedescriptionwebslider($size_name,$size_desc,$languages_data,$size_id);
       }else{
           $updat_des = $this->size->insertwebslidersizedescription($size_name,$size_desc,$size_id, $languages_data->languages_id);
       }
     }

     $message = Lang::get("labels.CategorieUpdateMessage");
     return redirect()->back()->withErrors([$message]);
    }



    public function delete(Request $request){
      $deletesize = $this->size->deleterecord($request);
      $message = Lang::get("labels.sizeDeleteMessage");
      return redirect()->back()->withErrors('Brand has been deleted');
    }


    public function web_slide_delete(Request $request){
      $deletesize = $this->size->deleterecordwebslider($request);
      $message = Lang::get("labels.sizeDeleteMessage");
      return redirect()->back()->withErrors('Brand has been deleted');
    }
    

    public function followed_size(){

      $title = array('pageTitle' => Lang::get("labels.Subsize"));
      $size = $this->size->paginator();
      $result['commonContent'] = $this->Setting->commonContent();
      $followed_size = DB::table('follow_requests')->get();

      $result['followed_size']= $followed_size;

      return view("admin.size.followed",$title)->with('size', $size)->with('result', $result);
    }

    public function delete_followed_size(Request $request){

      DB::table('follow_requests')->where('id' , $request->id)->delete();

      return redirect()->back()->withErrors('Record has been deleted');
    }
}
