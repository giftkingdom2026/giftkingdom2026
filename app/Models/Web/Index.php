<?php

namespace App\Models\Web;

use App;
use App\Models\Web\Cart;
use App\Models\Core\Posts;
use App\Models\Core\Postmeta;
use App\Models\Core\Terms;
use App\Models\Core\Termmeta;
use App\Models\Core\TermRelations;
use App\Models\Web\Products;
use App\Models\Web\Images;
use DB;
use Session;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AdminControllers\PostsController;

class Index extends Model{

    public static function getSectionFive(){

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        $settings =  DB::table('settings')->select('name','value')
        ->whereIn('name',['home_s6_image1','home_s6_title','home_s6_text','home_s6_image2','home_s6_title2','home_s6_text2','home_s6_image3','home_s6_title3','home_s6_text3','home_s6_image4','home_s6_title4','home_s6_text4'])->where('lang',$lang)
        ->groupBy('id')
        ->get();

        foreach($settings as $key => $value):  $arr[ $value->name ] = $value->value; endforeach;

        return $arr;
    }
public static function getBlogs()
{
    $lang = session()->has('lang_id') ? session('lang_id') : 1;

    $blogs = Posts::select('posts.ID','posts.post_title','posts.post_excerpt','posts.post_name','posts.featured_image','posts.created_at')
        ->leftJoin('taxonomy_term_relations as rel', 'rel.post_id', '=', 'posts.ID')
        ->leftJoin('taxonomy_terms as t', 't.terms_id', '=', 'rel.term_id')
        ->where('posts.post_type', 'blogs')
        ->where('posts.post_status', 'publish')
        ->where(function($query) {
            $query->where('t.status', 'active')
                  ->orWhereNull('t.status');
        })
        ->orderByRaw("
            CASE 
                WHEN posts.sort_order IS NULL OR posts.sort_order = 0 THEN 0 
                ELSE 1 
            END ASC,
            CASE 
                WHEN posts.sort_order IS NULL OR posts.sort_order = 0 THEN posts.created_at 
                ELSE NULL 
            END DESC,
            posts.sort_order ASC
        ")
        ->groupBy('posts.ID')
        ->paginate(9);

    $blogs ? $blogs = $blogs->toArray() : '';

    $blogs['data'] = Postmeta::getMetaData($blogs['data'], $lang);
    $blogs['data'] = PostsController::parsePostContent($blogs['data']);

    foreach ($blogs['data'] as &$blog) :
        $query = TermRelations::leftJoin('taxonomy_terms','taxonomy_term_relations.term_id','=','taxonomy_terms.terms_id')
            ->where('taxonomy_term_relations.post_id', $blog['ID'])
            ->where(function($q) {
                $q->where('taxonomy_terms.status', 'active')
                  ->orWhereNull('taxonomy_terms.status');
            })
            ->groupBy('taxonomy_term_relations.post_id');

        if ($lang != 1) :
            $termid = $query->pluck('taxonomy_terms.terms_id')->first();
            $where = [['taxonomy_id', 1], ['terms_id', $termid], ['meta_key', 'term_title'], ['lang', $lang]];
            $cat = Termmeta::where($where)->pluck('meta_value')->first();
        else :
            $cat = $query->pluck('taxonomy_terms.term_title')->first();
        endif;

        $blog['cat'] = $cat;
    endforeach;

    return $blogs;
}



    public static function getBanners(){

$banners = Posts::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'posts.featured_image')
    ->select('posts.*', 'categoryTable.path as featured_image')
    ->where('post_type', 'banners')
    ->orderByRaw("
        CASE 
            WHEN posts.sort_order IS NULL OR posts.sort_order = 0 THEN 0 
            ELSE 1 
        END ASC
    ")
    ->orderByRaw("
        CASE 
            WHEN posts.sort_order IS NULL OR posts.sort_order = 0 THEN posts.created_at 
            ELSE NULL 
        END DESC
    ")
    ->orderBy('posts.sort_order', 'ASC')
    ->groupBy('posts.ID')
    ->get()
    ->toArray();


        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        $banners = Postmeta::getMetaData( $banners,$lang);

        foreach($banners as &$banner):

            $cond = session()->has('lang_id') && session('lang_id') != 1;

            if( $cond  ) :

                $data = Postmeta::where([['posts_id',$banner['ID']],['lang',session('lang_id')]])->whereIn('meta_key',['pagetitle','post_content','featured_image'])->get();

                $meta = [];

                foreach($data as $item) :

                    $meta[$item->meta_key] = $item->meta_value;

                endforeach;
                
                $banner['post_title'] = $meta['pagetitle'];
                $banner['post_content'] = $meta['post_content'];
                $banner['featured_image'] = self::get_image_path($meta['featured_image']);

            endif;

            isset($banner['metadata']['mobile_image']) ? $banner['metadata']['mobile_image'] = self::get_image_path($banner['metadata']['mobile_image']) : '';

        endforeach;

        return $banners;
    }

public static function getFaqs()
{
    $faqs = Posts::where([
            ['post_type', 'faqs'],
            ['post_status', 'publish']
        ])
        ->orderByRaw("
            CASE 
                WHEN sort_order IS NULL OR sort_order = 0 THEN 0 
                ELSE 1 
            END ASC,
            CASE 
                WHEN sort_order IS NULL OR sort_order = 0 THEN created_at 
                ELSE NULL 
            END DESC,
            sort_order ASC
        ")
        ->get();

    $faqs = $faqs ? $faqs->toArray() : [];

    $lang = session()->has('lang_id') ? session('lang_id') : 1;

    $faqs = Postmeta::getMetaData($faqs, $lang);

    $faqs = PostsController::parsePostContent($faqs);

    return $faqs;
}


    public static function getHelpCenter($most = false){

        if( $most != false ) :

            $questions = Terms::where('term_slug','most-asked')->pluck('terms_id')->first();

            $questions = TermRelations::where('term_id',$questions)->pluck('post_id');

            $questions = Posts::whereIn('ID',$questions)->where([['post_type','questions'],['post_status','publish']])->get();

        else :

            $questions = Posts::where([['post_type','questions'],['post_status','publish']])->orderBy('sort_order','ASC')->get();

        endif;

        $questions ? $questions = $questions->toArray() : '';
        
        $questions = Postmeta::getMetaData($questions);

        $questions = PostsController::parsePostContent($questions);

        return $questions;
    }

    public static function getEvents( $ids = null ){

        $where = [['post_type','events'],['post_status','publish']];

if ($ids != null) {
    $events = Posts::where($where)
        ->whereIn('ID', $ids)
        ->orderByRaw("
            CASE 
                WHEN sort_order IS NULL OR sort_order = 0 THEN 0 
                ELSE 1 
            END ASC,
            CASE 
                WHEN sort_order IS NULL OR sort_order = 0 THEN created_at 
                ELSE NULL 
            END DESC,
            sort_order ASC
        ")
        ->get();
} else {
    $events = Posts::where($where)
        ->orderByRaw("
            CASE 
                WHEN sort_order IS NULL OR sort_order = 0 THEN 0 
                ELSE 1 
            END ASC,
            CASE 
                WHEN sort_order IS NULL OR sort_order = 0 THEN created_at 
                ELSE NULL 
            END DESC,
            sort_order ASC
        ")
        ->get();
}


        $events ? $events = $events->toArray() : '';

        $lang = session()->has('lang_id') ? session('lang_id') : 1;
        $events = Postmeta::getMetaData($events,$lang);

        $events = PostsController::parsePostContent($events);
        return $events;
    }
    
    public static function singleBlog($slug){

        $blogs = Posts::where([['post_type','blogs'],['post_status','publish']])->where('post_name',$slug)->with('metadata')->first();

        $blogs->featured_images = ['path' => Index::get_image_path($blogs->featured_image), 'id' => $blogs->featured_image];

        return $blogs;
    }

    public static function getCareerCategories(){

        $categories = Terms::where('taxonomy_id','1')->get(); 

        $categories ? $categories = $categories->toArray() : '';

        foreach($categories as &$cat) :

            $meta = Termmeta::where('terms_id',$cat['terms_id'])->get();
            
            $meta ? $meta = $meta->toArray() : '';

            $arr = [];

            foreach($meta as $item) :

                $arr[$item['meta_key']] = $item['meta_value'];

            endforeach;

            $cat['metadata'] = $arr;

            $cat['job-count'] = TermRelations::where('term_id',$cat['terms_id'])->count();

        endforeach;

        $categories = PostsController::parsePostContent($categories);

        return $categories;
    }

    public static function get_image_alt($id){

        $alt = Images::where('id',$id)->pluck('alt')->first();

        return $alt;
    }

    public static function get_image_path($id){

        if( str_contains($id, ',') ) :

            $ids = array_filter( explode(',',$id) );

            $path = [];

            foreach($ids as $id):

                $url = Images::where( [
                    ['image_id', '=', $id ],

                    ['image_type', '=', 'OPTIMIZED']

                ])->pluck('path')->first();

                if( $url === '' || $url === null ) :

                    $url = Images::where( [
                        ['image_id', '=', $id ],

                        ['image_type', '=', 'ACTUAL']

                    ])->pluck('path')->first();

                endif;

                array_push($path, $url);

            endforeach;


        else :

            $path = Images::where( [
                ['image_id', '=', $id ],

                ['image_type', '=', 'OPTIMIZED']

            ])->pluck('path')->first();

            if( $path === '' || $path === null ) :

                $path = Images::where( [
                    ['image_id', '=', $id ],

                    ['image_type', '=', 'ACTUAL']

                ])->pluck('path')->first();

            endif;

        endif;

        return $path;
    }

    public static function get_image_path2($id){

     if( str_contains($id, ',') ) :

        $ids = array_filter( explode(',',$id) );

        $path = [];

        foreach($ids as $id) :

            $path[] = Images::where('image_id', $id)->whereIn('image_type',['OPTIMIZED','ACTUAL'])
            ->pluck('path')->first();

        endforeach;


    else :
        $path ='';

        $path = Images::where( [
            ['image_id', '=', $id ],

        ])->whereIn('image_type',['OPTIMIZED','ACTUAL'])->pluck('path')->first();


    endif;

    return $path;
}


public static function parseContent($result){

    $parse = [];

    if($result != 'default') :

        foreach($result as $key => $data) : 

            $parse[$data['content_key']] = $data['content_value'];

        endforeach;

        foreach($parse as $key => $data) : 

            if( 

                str_contains($key, 'image') || 
                str_contains($key, 'video') 
            ) :

                $parse[$key] = [

                 'id' => $data , 'path' => self::get_image_path( $data ) , 'alt' => self::get_image_alt($data)


             ];

         endif;

     endforeach;

 endif;

 return $parse;
}

public static function setCurrency(){

    $currency = DB::table('currencies')
    ->where('is_default', 1)
    ->where('is_current', 1)
    ->first();

    if (empty(Session::get('currency_id'))) {
        session(['currency_id' => $currency->id]);
    }
    if (empty(Session::get('currency_title'))) {
        session(['currency_title' => $currency->code]);
    }
    if (empty(Session::get('symbol_right')) && empty(Session::get('symbol_left'))) {
        session(['symbol_right' => $currency->symbol_right]);
    }
    if (empty(Session::get('symbol_left')) && empty(Session::get('symbol_right'))) {
        session(['symbol_left' => $currency->symbol_left]);
    }
    if (empty(Session::get('currency_code'))) {
        session(['currency_code' => $currency->code]);
    }

    if (empty(Session::get('currency_value'))) {
        session(['currency_value' => $currency->value]);
    }

    if (empty(Session::get('currency_flag'))) {
        session(['currency_flag' => $currency->flag]);
    }

}

public function commonContent()
{   
    $languages = DB::table('languages')
    ->leftJoin('image_categories', 'languages.image', 'image_categories.image_id')
    ->select('languages.*', 'image_categories.path as image_path')
    ->where('languages.is_default', '1')
    ->get();

    if (empty(Session::get('language_id'))) {
        session(['language_id' => $languages[0]->languages_id]);
    }
    if (empty(Session::get('language_image'))) {
        session(['language_image' => $languages[0]->image_path]);
    }
    if (empty(Session::get('language_name'))) {
        session(['language_name' => $languages[0]->name]);
    }

    if (!Session::has('custom_locale')) {
        $locale = $languages[0]->code;
        session()->put('language_id', $languages[0]->languages_id);
        session()->put('direction', $languages[0]->direction);
        session()->put('locale', $languages[0]->code);
        session()->put('language_name', $languages[0]->name);
        session()->put('language_image', $languages[0]->image_path);
        App::setLocale($locale);
    }

    if(isset(Route::getCurrentRoute()->parameters['slug'])  && Route::getCurrentRoute()->parameters['slug'] != ''){

      if(Route::current()->uri == 'product-detail/{slug}'){
        $page_slug='Product-Detail';
    }

    elseif(Route::current()->uri == 'news-detail/{slug}'){
        $page_slug='Blog-Detail';
    }
    elseif(Route::current()->uri == 'view-order/{id}'){
        $page_slug='View-Order';
    }


    else{

        $page_slug=Route::getCurrentRoute()->parameters['slug'];

    }

}else{
    if(Route::getCurrentRoute() == null){
        $page_slug='404';
    }else{
        $page_slug=Route::getCurrentRoute()->uri();
    }
}

$result = array();
$page_seo = DB::table('seo')
->leftJoin('image_categories as im1', 'im1.image_id', '=', 'seo.og_image')
->leftJoin('image_categories as im2', 'im2.image_id', '=', 'seo.twiter_image')
->select('seo.*', 'im1.path as path','im2.path as path2')
->where('seo.page_slug', '=', $page_slug)
->first();

$result['page_seo']=$page_seo;

$result['pages'] = DB::table('pages')
->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
->leftJoin('image_categories', 'image_categories.image_id', '=', 'pages.banner_image')
->select('pages.*' , 'pages_description.*' , 'image_categories.path as path')
->where([['type', '2'], ['status', '1'], ['pages_description.language_id', session('language_id')]])
->where('pages.slug' , $page_slug)
->groupBy('pages.page_id')
->orderBy('pages_description.name', 'ASC')->get();

            // dd($result['pages']);

$result['currency'] = $currency;

$result['coupon-theme'] = DB::table('coupon-theme')
->leftjoin('image_categories' , 'image_categories.image_id' , '=' , 'coupon-theme.image')
->select('coupon-theme.*' , 'image_categories.path')
->where('coupon-theme.id' , 1)
->first();

$result['logout-banner']=  DB::table('logout_banner')
->leftjoin('image_categories' , 'image_categories.image_id' , '=' , 'logout_banner.image')
->select('logout_banner.*' , 'image_categories.path as path')
->where('logout_banner.id' , 1)
->first();

$result['offer-image']=  DB::table('offer_image')
->leftjoin('image_categories' , 'image_categories.image_id' , '=' , 'offer_image.offer_image')
->select('offer_image.*' , 'image_categories.path as path')
->where('offer_image.id' , 1)
->first();



$result['shippingAddress']=$this->getShippingAddress();

if(!empty(auth()->guard('customer')->user())){
    $result['orders']=DB::table('orders')->where('customers_id' ,auth()->guard('customer')->user()->id)->count();
}

$top_offers = DB::table('top_offers')
->where('language_id', Session::get('language_id'))
->first();
$result['top_offers'] = $top_offers;


$result['banners']=$this->facilities();

$result['city_zones']= DB::table('zones')->select('*')->get();

$items = DB::table('menus')
->leftJoin('menu_translation', 'menus.id', '=', 'menu_translation.menu_id')
->select('menus.*', 'menu_translation.menu_name as name', 'menus.parent_id')
->where('menu_translation.language_id', '=', Session::get('language_id'))
->where('menus.status', '=', 1)
->orderBy('menus.sort_order', 'ASC')
->groupBy('menus.id')
->get();

$coupons = DB::table('coupons')->select('*')
->where('is_redeem' , 1)
->where('status','1')
->first();

$result['coupons']=$coupons;
if ($items->isNotEmpty()) {
    $childs = array();
    foreach ($items as $item) {
        $childs[$item->parent_id][] = $item;
    }

    foreach ($items as $item) {
        if (isset($childs[$item->id])) {
            $item->childs = $childs[$item->id];
        }
    }

    if (!empty($childs[0])) {
        $menus = $childs[0];
    } else {
        $menus = $childs;
    }

    $result["menus"] = $menus;
} else {

    $result["menus"] = array();
}

$result["menusRecursive"] = $this->menusRecursive();
$result["menusRecursiveMobile"] = $this->menusRecursiveMobile();
$data = array();
$data = array('type' => 'header');
$cart = $this->cart($data);
$result['cart'] = $cart;
if (count($result['cart']) == 0) {
    session(['step' => '0']);
    session(['coupon' => array()]);
    session(['coupon_discount' => array()]);
    session(['billing_address' => array()]);
    session(['shipping_detail' => array()]);
    session(['payment_method' => array()]);
    session(['braintree_token' => array()]);
    session(['order_comments' => '']);
}

$setting = DB::table('settings')->orderby('id', 'ASC')->get();
$result['setting']=$setting; 

$settings = array();
foreach($setting as $key=>$value){
  $settings[$value->name]=$value->value;
}

$result['settings'] = $settings;

$result['home_banner'] = $this->home_banner();



$result['categories_home'] = $this->categories_home();
        //liked_products
$total_wishlist = 0;
if(isset($_COOKIE['is_like']))
{
    $current_user=$_COOKIE['is_like'];
}else{
    $current_user=session('customers_id');
}
if (!empty($current_user)) {
    $total_wishlist = DB::table('liked_products')
    ->leftjoin('products', 'products.products_id', '=', 'liked_products.liked_products_id')
    ->where('liked_customers_id', '=',$current_user)
    ->count();
}

else{
    $total_wishlist = 0;
}


$result['total_wishlist'] = $total_wishlist;


$result['header_content']= DB::table('header_content')
->leftjoin('image_categories','image_categories.image_id','=','header_content.image')
->select('header_content.*','image_categories.path')
->where('image_categories.image_type','=','ACTUAL')
->orderBy('header_content.id','ASC')
->get();
$result['banner_images']=$this->banner_images();

$result['header_banner'] = $this->header_banner();

$result['currencies'] = $this->currencies();

if(!empty(auth()->guard('customer')->user())){

    $result['total_Cart']=DB::table('customers_basket')->where('customers_id', auth()->guard('customer')->user()->id)->where('is_order' ,0)->count();
    
}
else{
    $result['total_Cart']=0;
}

return $result;
}


}
