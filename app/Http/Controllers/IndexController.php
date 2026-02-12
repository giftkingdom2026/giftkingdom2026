<?php
namespace App\Http\Controllers\App;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Web\Index;
use App\Models\Web\Cart;
use App\Models\Core\Setting;
use App\Models\Core\Images;
use App\Models\Core\Pages;
use App\Models\Core\Terms;
use App\Models\Core\Products;
use App\Models\Core\Brands;
use App\Models\Core\Posts;
use App\Models\Core\Content;
use App\Models\Core\Categories;
use App\Models\Web\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use App\Models\Web\Index;

use Auth;
use Carbon\Carbon;
use Image;
use Mail;
use Lang;
use DB;
use Hash;
use Illuminate\Support\Facades\Validator;
use Route;
use Session;
class IndexController extends Controller
{

    public function index(Request $request){

        // $data['slider'] = DB::table('mobile_sliders')->where('end_date','>',date(''));
        $slider = DB::table('mobile_sliders')->orderBy('mobile_slider_id','DESC')->get();
        $slider ? $slider = $slider->toArray() : '';
        foreach($slider as &$prod) :

            // dd($prod->mobile_slider_banner_id);
            if($prod->mobile_slider_type == "product"){
               $prod->product = DB::table('products')->where('ID',$prod->mobile_slider_redirect)->first();
            }elseif($prod->mobile_slider_type == "category"){
               $prod->category = DB::table('categories')->where('category_ID',$prod->mobile_slider_redirect)->first();
            }
            $prod->mobile_slider_banner = ['path' => Index::get_image_path($prod->mobile_slider_banner_id), 'id' => $prod->mobile_slider_banner_id];
        endforeach;
        if(count($slider) >  0){
            $data['slider']=$slider;
        }else{
            $data['slider']=[];
        }
         $top_deals= $this->allDeals();
         if(count($top_deals) >  0){
            $data['top_deals']=$top_deals['categories'];
        }else{
            $data['top_deals']=[];
        }
        $featured_products = Products::getFeaturedProducts();
        if(count($featured_products) >  0){
            $data['featured_products']=$featured_products;
        }else{
            $data['featured_products']=[];
        }
        $brands = Brands::getHomeBrands();
        if(count($brands) >  0){
            $data['brands']=$brands;
        }else{
            $data['brands']=[];
        }
        $categories = Categories::getHomeCategories();
        if(count($categories) >  0){
            $data['categories']=$categories;
        }else{
            $data['categories']=[];
        }
        $cart_data = Cart::where('customer_id' , $request->customer_id )->first();
        if( $cart_data ) :
            $cart_data->items = Cartitems::getItems($cart_data->cart_ID);
        endif;
        if(!empty($cart_data)){
            $data['cart_data']=$cart_data;
        }else{
            $data['cart_data']=[];
        }
        return response()->json(["status" => 1,"message" => "Data has been returned successfully!","data" => $data]);
    }
    public function allCategories(Request $request){
        $categories=Categories::list('category');
        if(count($categories) >  0){
            $data=$categories;
        }else{
            $data['categories']=[];
        }
        return response()->json(["status" => 1,"message" => "Data has been returned successfully!","data" => $data]);
    }
    public function allBrands(Request $request){
        $categories=Brands::list();
        if(count($categories) >  0){
            $data=$categories;
        }else{
            $data['categories']=[];
        }
        return response()->json(["status" => 1,"message" => "Data has been returned successfully!","data" => $data]);
    }
    public function allDeals(){
        $all_deals=Categories::list('deals');
        return $all_deals;
    }
    public function getCurrencies(){
        $data['currencies'] =DB::table('currencies')
                    ->select('currencies.*')
                    ->get();
        return response()->json(["status" => 1,"message" => "Data has been returned successfully!","data" => $data]);


    }
    
}
