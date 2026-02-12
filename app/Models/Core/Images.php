<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Web\Index;
use App\Models\Web\Imagetable;
use Image;

class Images extends Model
{

    protected $table = 'image_categories';
    //
    use Sortable;
    public $sortable =['id','name'];

    public function image_category(){

        return $this->hasMany('App\Image_category');
    }


    public static function getImageName($id){

        $image = DB::table('images')->where('id',$id)->first();

        $name = $image->name;

        return $name;

    }

    // Image Modal Load More

    public static function loadmore( $data ) {

        $images = self::getimages($data['load']);

        $previmages = isset($data['images']) ? $data['images'] : [] ;

        $html = '';
        
        $gallery = $data['gallery'];   

        foreach($images as $image ) : 

            if( !in_array($image['image_id'], $previmages ) ) :

                $html.= self::uploaderhtml( $image , false, $data['gallery']);

            endif;

        endforeach;

        return json_encode(['images' => $html]);
    }
    
    // Image Modal

    public static function gallery( $data ){
        $images = self::getimages(1,$data);
        // dd($images);

        $imginfo = $html = '';

        $ids = $previmages = $urls = [];
        
        $gallery = false;

        if( $data['val'] != '' ) :

            $previmages = explode(',', $data['val']);

            count($previmages) > 1 ? $gallery = true : '';

            foreach($previmages as $previmg ) :

                $array = self::where( [ ['image_id' , $previmg] , ['image_type' , 'OPTIMIZED' ] ] )->first();

                $array ? '' : $array = self::where( [ ['image_id' , $previmg] , ['image_type' , 'ACTUAL' ] ] )->first();

                $array ? $array =  $array->toArray() : '';

                $array['name'] = Imagetable::where('id',$previmg)->pluck('name')->first();
                $html.= self::uploaderhtml( $array , true , $gallery);

                $ids[] = $previmg;
                
                $urls[] = asset($array['path']);

            endforeach;

        endif;

        $data['type'] == 'multiple' ? $gallery = true : '';

        foreach($images as $image ) : 

            if( !in_array($image['image_id'], $previmages ) ) :

                $html.= self::uploaderhtml( $image , false,$gallery);

            endif;

        endforeach;

        if( $data['type'] != 'single' && str_contains($data['val'],',') ) :

            $data['val'] = explode(',', $data['val']);

            foreach($data['val'] as $img ) : 

                $path = Index::get_image_path( $img );

                $view = asset( $path );

                $imginfo.= '<div class="imageInfo" data-deleteid="'.$img.'">
                <figure>
                <a href="javascript:;" class="gallery-image-remove" data-id="'.$img.'">x</a>
                <img src="'.$view.'" class="w-100">
                </figure>
                </div>';

            endforeach;

        else :

            if( $data['val'] != '' ) :

                $image = self::where([ [ 'image_id',$data['val'] ],['image_type','ACTUAL'] ])->first()->toArray();

                $name = Imagetable::where('id',$data['val'])->pluck('name')->first();
                
                if( in_array( $image['extension'], ['webm','mp4','mpeg'] ) ) :

                    $imginfo = '<div class="imageInfo" data-deleteid="'.$data['val'].'">
                    <figure>
                    <video controls class="w-100">
                    <source src="'.asset($image['path']).'"/>
                    </video>
                    </figure>';

                elseif( in_array( $image['extension'] , ['jpg','webp','png','jpeg','svg'] ) ) :

                    $imginfo = '<div class="imageInfo" data-deleteid="'.$data['val'].'">
                    <figure>
                    <img src="'.asset($image['path']).'" class="w-100">
                    </figure>';                    
                else :

                    $imginfo = '<div class="imageInfo">
                    <figure>
                    <img src="'.asset('images/document.png').'" class="w-100">
                    </figure>';

                endif;


                $imginfo.='<figcaption>
                <a href="'.asset($image['path']).'" data-fancybox>View Full Size</a>
                <ul>
                <li><span>File Name</span> '.$name.'</li>
                <li><span>Dimensions</span> '.$image['width'].'x'.$image['height'].'</li>
                <li><span>Type</span> image</li>
                <li><span>File Type</span> '.$image['extension'].'</li>
                <li><span>Url</span> <input type="text" value="'.asset($image['path']).'" readonly></li>
                <li><span>ID</span>'.$data['val'].'</li>
                </ul>
                </figcaption>
                </div>';

            else :

                if($data['type'] == 'single') :

                    $imginfo = '<div class="imageInfo">
                    <figure>
                    <img src="'.asset('assets/images/placeholder.png').'" class="w-100">
                    </figure>
                    <figcaption>
                    <a href="'.asset('assets/images/placeholder.png').'" data-fancybox>View Full Size</a>
                    <ul>
                    <li><span>File Name</span> placeholder.png</li>
                    <li><span>Dimensions</span> 300x300</li>
                    <li><span>Type</span> image</li>
                    <li><span>File Type</span> png</li>
                    <li><span>Url</span> <input type="text" value="'.asset('assets/images/placeholder.png').'" readonly></li>
                    </ul>
                    </figcaption>
                    </div>';

                else :

                    $imginfo = '<div class="imageInfo">
                    <figure>
                    <img src="'.asset('assets/images/placeholder.png').'" class="w-100">
                    </figure>
                    </div>';

                endif;

            endif;


        endif;

        return json_encode(['images' => $html ,'imageinfo' => $imginfo, 'ids' => json_encode($ids) , 'urls' => json_encode($urls) ]);
    }


    public static function uploaderhtml($imagearray,$prev = false , $gallery = false){

        $imageformats = ['gif', 'jpg', 'jpeg', 'png','webp','svg'];

        $videoformats = ['webm','mpeg','mp4'];
        
        in_array($imagearray['extension'], $imageformats) ? $img = asset( $imagearray['path'] ) : $img = asset( 'images/document.png' ); 

        in_array( $imagearray['extension'], $videoformats ) ? $img = asset( 'images/video.png' ) : '' ;

        $prev != false ? $class = 'selected' : $class = '';

        $html ='<div class="uploaded_image blurred '.$class.'" title="" data-imageid="'.$imagearray['image_id'].'">
        <div class="imgWrap">
        <img src="'.$img.'" class="w-100">
        </div>
        <imageinfo style="display: none;">
        <div class="imageInfo" data-deleteid="'.$imagearray['image_id'].'">
        <figure>';

        $gallery == true ? $html.='<a href="javascript:;" class="gallery-image-remove" data-id="'.$img.'">x</a>' : '' ;

        if( str_contains($img, 'video.png') ): 

            $html.='<video controls class="w-100">
            <source src="'.asset($imagearray['path']).'" class="w-100">
            </video>';

        else :

            $html.='<img src="'.asset($img).'" class="w-100">';

        endif;

        if( $gallery == true ) : 

            $html.='</figure>
            </div>
            </imageinfo>
            </div>';

        else :

            $html.='</figure>
            <figcaption>
            <a href="'.asset($imagearray['path']).'" data-fancybox>View Full Size</a>
            <ul>
            <li><span>File Name</span>'.$imagearray['name'].'</li>
            <li><span>Dimensions</span>'.$imagearray['width'].'x'.$imagearray['height'].'</li>
            <li><span>Type</span> image</li>
            <li><span>File Type</span>'.$imagearray['extension'].'</li>
            <li><span>Url</span> <input type="text" value="'. $imagearray['path'].'" readonly></li>
            <li><span>ID</span> '. $imagearray['image_id'].'</li>
            </ul>
            </figcaption>
            </div>
            </imageinfo>
            </div>';

        endif;

        return $html;

    }

    public static function getimages($gallery = false,$data = ''){
        if( $gallery ) :

            $gallery == 1 ? $limit = 50 : $limit  = 10;

            $gallery == 1 ? $gallery = 0 : '';
            if($data != '' && isset($data['search_img']) && $data['search_img'] != ''){
                $images = Imagetable::where('name', 'LIKE', '%' . $data['search_img'] . '%')->orderBy('id','DESC')->offset($gallery)->limit(24)->get()->toArray();
            }else{
                $images = Imagetable::orderBy('id','DESC')->offset($gallery)->limit($limit)->get()->toArray();
            }
            
        else :
            if($data != '' && isset($data['search_img']) && $data['search_img'] != ''){
                $images = Imagetable::where('name', 'LIKE', '%' . $data['search_img'] . '%')->orderBy('id','DESC')->limit(100000)->get()->toArray();
            }else{
                $images = Imagetable::orderBy('id','DESC')->limit(100000)->get()->toArray();
            }


        endif;

        $allimages = [];

        foreach($images as $image) :

            $img =  Images::where([ 

                ['image_id',$image['id']], 

                ['image_type','THUMBNAIL'] 

            ])->first();

            if( $img ) :

                $img = $img->toArray();

            else  :

                $img =  Images::where([ 
                    ['image_id',$image['id']], 

                    ['image_type','OPTIMIZED'] 

                ])->first();

                if( $img ) :

                    $img = $img->toArray();

                else :

                    $img =  Images::where([ 
                        ['image_id',$image['id']], 

                        ['image_type','ACTUAL'] 

                    ])->first();

                    if( $img ) :

                        $img = $img->toArray();

                    endif;

                endif;

            endif;


            if($img) : $img['name'] = $image['name']; array_push($allimages, $img); endif;

        endforeach;
        // dd($allimages);
        return $allimages;

    }




    public function imagedata($filename, $Path, $width, $height, $user_id = null,$extension){


        $user_id == null ? $user_id = 15 : $user_id = 1;

        $imagedata = DB::table('images')->insertGetId(

            [
                'name' => $filename, 

                'user_id' => Auth()->user()->id

            ]

        );

        $imagecatedata = DB::table('image_categories')->insert([

            [

                'image_id' => $imagedata,

                'image_type' => '1',

                'height' =>$height,

                'width' =>$width,

                'path' =>$Path ,

                'extension' => $extension

            ]

        ]);
        return $imagedata;

    }

    public function imagedataByCustomer($filename, $Path, $width, $height, $user_id = null,$extension,$customer_id){


        $user_id == null ? $user_id = 15 : $user_id = 1;

        $imagedata = DB::table('images')->insertGetId(

            [
                'name' => $filename, 

                'user_id' => $customer_id

            ]

        );

        $imagecatedata = DB::table('image_categories')->insert([

            [

                'image_id' => $imagedata,

                'image_type' => '1',

                'height' =>$height,

                'width' =>$width,

                'path' =>$Path ,

                'extension' => $extension

            ]

        ]);
        return $imagedata;

    }


    public static function saveImageData($Path,$width,$height,$type,$id,$extension){


      $imagecatedata = DB::table('image_categories')->insert([

          [
              'image_id' => $id, 

              'image_type' => $type, 

              'height' =>$height,

              'width' =>$width,

              'path' =>$Path,

              'extension' => $extension

          ]

      ]);

  }


  public static function imagedelete($id){

    $check = DB::table('images')->where('id',$id)->delete();

    $check = self::where('image_id',$id)->delete();

    return  $check;
}








    //regenerate section
public function regenerate($image_id, $id, $width, $height)
{
    $origianl_record = DB::table('image_categories')
    ->select('path')
    ->where('image_categories.image_id',$image_id)
    ->where('image_categories.image_type','ACTUAL')
    ->first();

    $required_record = DB::table('image_categories')
    ->select('path')
    ->where('image_categories.id',$id)
    ->first();


    $original_image_path = $origianl_record->path;
    $required_image_full_path = $required_record->path;

        //delete old size image
    if(file_exists($required_image_full_path)){
        unlink($required_image_full_path);
    }


        //get name and path of required image
    $total_string = strlen($required_image_full_path);
    $required_imag_path = substr($required_image_full_path, 0,21);
    $filename = substr($required_image_full_path, 21,$total_string);

    $destinationPath = public_path($required_imag_path);
    $saveimage = Image::make($original_image_path, array(

        'width' => $width,

        'height' => $height,

        'grayscale' => false));

    $namethumbnail = $saveimage->save($destinationPath . $filename);

    $Path = $required_image_full_path;
    $destinationFile = public_path($Path);
    $size = getimagesize($destinationFile);
    list($width, $height, $type, $attr) = $size;

    DB::table('image_categories')->where('id', $id)->update(
        [
            'width'   =>   $width,
            'height'          =>   $height,
            'updated_at'     => date('y-m-d h:i:s')
        ]);

    return $namethumbnail;
}

public function regenrateAll($request){
        //get settings
    $AllImagesSettingData = $this->AllimagesHeightWidth();

    $images = DB::table('images')
    ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
    ->where('image_type', 'ACTUAL')
        //->where('image_categories.image_id',446)
    ->get();

    foreach($images as $image){
        $image_path = $image->path;
        $image_id = $image->image_id;

        $size = getimagesize($image_path);
        list($width, $height, $type, $attr) = $size;

        switch (true) {
            case ($width >= $AllImagesSettingData[5]->value || $height >= $AllImagesSettingData[4]->value):

            $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0]->value, $AllImagesSettingData[1]->value, 'THUMBNAIL');
            $mediumimage = $this->regenerateimages($image_id, $AllImagesSettingData[2]->value, $AllImagesSettingData[3]->value, 'MEDIUM');
            $largeimage = $this->regenerateimages($image_id, $AllImagesSettingData[4]->value, $AllImagesSettingData[5]->value, 'LARGE');
            break;
            case ($width >= $AllImagesSettingData[3]->value || $height >= $AllImagesSettingData[2]->value):
            $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0]->value, $AllImagesSettingData[1]->value, 'THUMBNAIL');
            $mediumimage = $this->regenerateimages($image_id, $AllImagesSettingData[2]->value, $AllImagesSettingData[3]->value, 'MEDIUM');
            break;
            case ($width >= $AllImagesSettingData[0]->value || $height >= $AllImagesSettingData[1]->value):
            $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0]->value, $AllImagesSettingData[1]->value, 'THUMBNAIL');
            break;
        }

    }




}

    //regenerate section
public function regenerateimages($image_id, $width, $height, $image_type)
{
    $origianl_record = DB::table('image_categories')
    ->select('path')
    ->where('image_categories.image_id',$image_id)  
    ->where('image_categories.image_type','ACTUAL')
    ->first();

    $required_record = DB::table('image_categories')
        //->where('image_categories.id',$id)
    ->where('image_categories.image_id',$image_id) 
    ->where('image_categories.image_type',$image_type)
    ->first();

    $original_image_path = $origianl_record->path;

    if($required_record){
        $required_image_full_path = $required_record->path;
        $id = $required_record->id;

            //delete old size image
        if(file_exists($required_image_full_path)){
            unlink($required_image_full_path);                
        }

        $total_string = strlen($required_image_full_path);
        $required_imag_path = substr($required_image_full_path, 0,21);
        $filename = substr($required_image_full_path, 21,$total_string); 

    }else{
        $required_image_full_path = $original_image_path;
        $total_string = strlen($original_image_path);
        $required_imag_path = substr($original_image_path, 0,21);
        $filename = substr($original_image_path, 21,$total_string);
        $filename = strtolower($image_type).time() . $filename;
    }

    $destinationPath = public_path($required_imag_path);
    $saveimage = Image::make($original_image_path, array(

        'width' => $width,

        'height' => $height,

        'grayscale' => false));

    $namethumbnail = $saveimage->save($destinationPath . $filename);

    $path = $required_imag_path . $filename;
    $destinationFile = $path;
    $size = getimagesize($destinationFile);
    list($width, $height, $type, $attr) = $size;

        //check insert or update
    if($required_record){

        DB::table('image_categories')->where('id', $id)->update(
            [
                'width'   =>   $width,
                'height'          =>   $height,
                'updated_at'     => date('y-m-d h:i:s')
            ]);
    }else{
        DB::table('image_categories')->insert(
            [
                'width'   =>   $width,
                'height'     =>   $height,
                'created_at' => date('y-m-d h:i:s'),
                'image_id'  =>   $image_id,
                'path'  => $path,
                'image_type' => $image_type
            ]);
    }       

    return $namethumbnail;
}


}
