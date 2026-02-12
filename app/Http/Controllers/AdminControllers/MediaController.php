<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Image;
use Lang;
use App\Models\Web\Imagetable;

class MediaController extends Controller
{
    //
    public function __construct(Images $images, Setting $setting)
    {
        $this->Images = $images;
        $this->Setting = $setting;

    }
        public function loadMoreImage(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 24;

        $images = Imagetable::orderBy('id', 'DESC')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->toArray();

        $allImages = [];

        foreach ($images as $image) {
            $img = Images::where([
                ['image_id', $image['id']],
                ['image_type', 'OPTIMIZED'],
            ])->first();

            if (!$img) {
                $img = Images::where([
                    ['image_id', $image['id']],
                    ['image_type', 'ACTUAL'],
                ])->first();
            }

            if ($img) {
                $img = $img->toArray();
                $img['name'] = $image['name'];
                array_push($allImages, $img);
            }
        }

        return view('admin.media.loadmore', ['images' => $allImages]);
    }
    public function add()
    {
        $Images = new Images();
        $images = $Images->getimages();
        $result['commonContent'] = $this->Setting->commonContent();

        return view('admin.media.addimages')->with('images', $images)->with('result', $result);
    }

    public function gallery(Request $request){

        $data = $request->all();

        return Images::gallery($data);

    }

    public function loadmore(Request $request){

        $data = $request->all();

        return Images::loadmore($data);

    }

    public function refresh(Request $request)
    {
        // dd($request->all());
        $data['val'] = '';

        $data['type'] = $request->type;
        $data['search_img']=$request->search_img;
        return Images::gallery($data);
    }

    public function display()
    {
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.media.index")->with('result', $result);
    }


    public function updateAlt(Request $request){

        Images::where('id',$request->id)->update(['alt'=>$request->val]);    

    }

    public static function mediaUpload($data){

        // Creating a new time instance, we'll use it to name our file and declare the path

        $time = Carbon::now();

        // Requesting the file from the form

        $image = $data;

        $name = $image->getClientoriginalName();

        $extensions = Setting::imageType();

        $filedata =  $_FILES;


        if ( in_array($image->getClientOriginalExtension() , ['pdf' , 'docx' , 'png' , 'jpg' , 'jpeg','webp', 'webm' , 'mp4','svg']) ) {
            // getting size
            $extension = $image->getClientOriginalExtension();

            $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');

            $filename = $name;
            
            $upload_success = $image->storeAs($directory, $filename, 'public');

            $Path = 'images/media/' . $directory . '/' . $filename;
            
            $Images = new Images();
            
            $imagedata = $Images->imagedata($filename, $Path, '', '',1,$extension);
        }
        else{

            $Path = false;
        }


        return $imagedata;

    }

    public static function mediaUploadByCustomer($data,$customer_id){

        // Creating a new time instance, we'll use it to name our file and declare the path

        $time = Carbon::now();

        // Requesting the file from the form

        $image = $data;

        $name = $image->getClientoriginalName();

        $extensions = Setting::imageType();

        $filedata =  $_FILES;

        if ( in_array($image->getClientOriginalExtension() , ['pdf' , 'docx' , 'png' , 'jpg' , 'jpeg' ]) ) {
            // getting size
            $extension = $image->getClientOriginalExtension();

            $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');

            $filename = $name;
            
            $upload_success = $image->storeAs($directory, $filename, 'public');

            $Path = 'images/media/' . $directory . '/' . $filename;
            
            $Images = new Images();
            
            $imagedata = $Images->imagedataByCustomer($filename, $Path, '', '',1,$extension,$customer_id);
        }
        else{

            $Path = false;
        }


        return $imagedata;

    }

    public static function fileUpload(Request $request , $typess = ''){

        $time = Carbon::now();

        $image = $request->file('file');

        $name = $image->getClientoriginalName();

        $extensions = Setting::imageType();

        if ($request->hasFile('file') && in_array(strtolower($image->getClientOriginalExtension()), $extensions)) :

            $size = getimagesize($image);

        list($width, $height, $type, $attr) = $size;

        // $extension = $image->getClientOriginalExtension();

        $extension = strtolower($image->getClientOriginalExtension());

        $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');

        $filename = $name;

        $Path = 'images/media/' . $directory . '/' . $filename;

        (file_exists(public_path($Path))) ? $filename = self::checkfile($Path,$extension,$directory) : '';

        (file_exists(public_path($Path))) ? $Path = 'images/media/' . $directory . '/' . $filename : '';

        $actualname = pathinfo($Path, PATHINFO_FILENAME);

        $upload_success = $image->storeAs($directory, $filename, 'public');

        $Images = new Images();

        $imagedata = $Images->imagedata($filename, $Path, $width, $height,null,$extension);

        if( in_array($extension, ['jpg','jpeg', 'png','webp']) ) :

            self::ResizeImage($image, $filename, $directory, 'thumbnail', $imagedata,$extension);

        endif;

        if( in_array($extension, ['jpg','jpeg', 'png'])  ) :

            $img = self::imagecreatefromfile( public_path( $Path )  );

            if( $img ) :

                $path = 'images/media/' . $directory . '/' .$actualname.'.webp';

                imagepalettetotruecolor($img);

                imagewebp( $img , public_path( $path ) , 80 );

                $data = getimagesize( public_path( $path ) );

                list($width, $height, $type, $attr) = $data;

                Images::saveImageData($path, $width, $height,5,$imagedata,'webp');

            endif;

        endif; 

        $imageformats = ['gif', 'jpg', 'svg', 'jpeg', 'png','webp'];

        $videoformats = ['webm','mpeg','mp4'];

        if( in_array($extension, $imageformats)  ) :

            $img = asset( 'images/media/'.$upload_success );

            $fieltype = 'image';

        elseif( in_array( $extension, $videoformats ) ) :

            $img = asset( 'images/video.png' );

            $fieltype = 'video';

        else:

            $img = asset( 'images/document.png' );

            $fieltype = 'document';

        endif;

        $data['html'] = '<div class="uploaded_image blurred selected" data-imageid="' . $imagedata . '">
        <div class="imgWrap">
        <img src="' . $img . '" class="w-100" >
        </div>
        <imageinfo style="display: none;">
        <div class="imageinfo" data-deleteid="' . $imagedata . '">
        <figure>
        <img src="'.$img.'" class="w-100">
        </figure>
        <figcaption>
        <a href="'.$img.'" data-fancybox="">View Full Size</a>
        <ul>
        <li><span>File Name</span> '.$filename.' </li>
        <li><span>Dimensions</span> '.$width.'x'.$height.'</li>
        <li><span>Type</span> '.$fieltype.'</li>
        <li><span>File Type</span> '.$extension.'</li>
        <li><span>Url</span> <input type="text" value="'.$img.'" readonly=""></li>
        <li><span>Alt</span><form id="alt-form"><input type="text" name="alt"></form></li>
        </ul>
        </figcaption>
        </imageinfo>
        </div>
        </div>';

        $data['id'] = $imagedata;

        $data['path'] = $img;

        echo json_encode($data);


    else :

        return json_encode(['html' => '', 'id' => '' , 'path' => '' ,'message' => 'Invalid Image']);
        
    endif;

}

public static function imagecreatefromfile( $filename ) {

    if (!file_exists($filename)) {

        return false;
    }
    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
        case 'jpeg':
        return imagecreatefromjpeg($filename);
        break;
        
        case 'jpg':

            try {

                $filename = imagecreatefromjpeg($filename);
                 
             } catch (Exception $e) {
                
                $filename = false;  
             } 

        return $filename;

        break;

        case 'png':
        return imagecreatefrompng($filename);
        break;

        case 'gif':
        return imagecreatefromgif($filename);
        break;
        
        case 'avif' :
        return imagecreatefromavif($filename);
        break;

        default:
        return false;
        break;
    }
}

public function optimizeimages(){

    $images = Images::where('image_type','ACTUAL')->get()->toArray();

    Images::where('image_type','OPTIMIZED')->delete();

    foreach ($images as $key => $image)  :

        if( in_array($image['extension'], ['png','jpg','jpeg']) ) :

            if( file_exists( public_path( $image['path'] ) ) ) :

                $img = self::imagecreatefromfile( public_path( $image['path'] )  );

                if( $img ) :

                    imagepalettetotruecolor($img);

                    $time = Carbon::now();

                    $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');

                    $actualname = pathinfo( $image['path'], PATHINFO_FILENAME);

                    $path = 'images/media/' . $directory . '/' .$actualname.rand(1,100).'.webp';

                    imagewebp( $img , public_path( $path ) , 80 );

                    $data = getimagesize( public_path( $path ) );

                    list($width, $height, $type, $attr) = $data;

                    Images::saveImageData($path, $width, $height,5,$image['image_id'],'webp');

                endif;

            endif;

        endif;

    endforeach;

}

public static function ResizeImage($image, $filename, $directory , $size = '',$id,$extension){

    $imagesize = ['thumbnail' => [150,150,false]];

    list($width,$height,$grayscale) = $imagesize[$size];

    $uploaddir = public_path('images/media/' . $directory . '/');

    $reziedimage = Image::make($image->getRealPath());

    $reziedimage->height() > $reziedimage->width() ? $width=null : $height=null;

    $reziedimage->resize($width, $height, function ($constraint) {

        $constraint->aspectRatio();

    })->save($uploaddir . $size . $filename);

    $path = 'images/media/' . $directory . '/' . $size . $filename;

    $reziedimage = public_path($path);

    $data = getimagesize($reziedimage);

    list($width, $height, $type, $attr) = $data;

    $type = ['thumbnail' => 2 , 'medium' => 4 , 'large' => 3];

    Images::saveImageData($path, $width, $height,$type[$size],$id,$extension);
}

public static function checkfile($path,$ext,$directory){

    $actualname = pathinfo($path, PATHINFO_FILENAME);

    $new = $actualname.rand(0,99).'.'.$ext;

    $path = 'images/media/' . $directory . '/' . $new;

    if( ( file_exists( public_path( $path ) ) ) ) :

       $new = self::checkfile( $path,$ext,$directory );

       return $new;

   else :

       return  $new;

   endif;


}

public function deleteimage(Request $request){
    $imagedelete = Images::imagedelete($request->id);

    return 'success';

}

}
