<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Web\Index;
use App\Models\Core\Menus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Session;

class Setting extends Model
{
    protected $table = 'settings';
    protected $guarded = [];

    public static function imageType()
    {
        $extensions = array('gif', 'jpg', 'jpeg', 'png','webp','svg','webm','mpeg','mp4','pdf','docx','doc');
        return $extensions;
    }

    //
    public function getSettings()
    {
        $setting = DB::table('settings')->orderby('id', 'ASC')->get();
        return $setting;
    }

    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
   
    public function settingmedia($requeest)
    {
        $mediasetting_Th = DB::table('settings')->where('name', 'Thumbnail_height')
        ->update(['value' => $requeest->ThumbnailHeight]);
        $mediasetting_Tw = DB::table('settings')
        ->where('name', 'Thumbnail_width')
        ->update(['value' => $requeest->ThumbnailWidth]);
        $mediasetting_Mh = DB::table('settings')
        ->where('name', 'Medium_height')
        ->update(['value' => $requeest->MediumHeight]);
        $mediasetting_Mt = DB::table('settings')
        ->where('name', 'Medium_width')
        ->update(['value' => $requeest->MediumWidth]);
        $mediasetting_Lh = DB::table('settings')
        ->where('name', 'Large_height')
        ->update(['value' => $requeest->LargeHeight]);
        $mediasetting_Lw = DB::table('settings')
        ->where('name', 'Large_width')
        ->update(['value' => $requeest->LargeWidth]);
        return "success";
    }

    public function alterSetting()
    {

        $setting = DB::table('alert_settings')->get();

        return $setting;

    }

    public static function settingUpdate($key, $value, $lang){
        is_array($value) ? $value = serialize($value) : '';

        $check = self::where([['name', '=', $key],['lang',$lang]])->update(['value' => $value]);

        if( !$check ) :

            $checkagain = self::create(['name' => $key , 'value' => $value, 'lang' => $lang ]);

        endif;

    }

    public function websetting($lang=1)
    {

        $settings = DB::table('settings')
        ->leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'settings.value')
        ->select('settings.*', 'categoryTable.path')
        ->where('lang',$lang)
        ->orderBy('id')->get();

        return $settings;
    }

    public static function getHomeContent(){

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        $settings =  DB::table('settings')
        ->leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'settings.value')
        ->select('settings.*', 'categoryTable.path as value')
        ->where('name','like','%image%')->where('lang',$lang)
        ->groupBy('settings.id')
        ->get();

        

        foreach($settings as $key => $value){

            $arr[ $value->name ] = $value->value;

        }

        $settings = self::where([['name','like','%home%'],['name','not like','%image%'],['lang',$lang]])->get();

        $settings ? $settings = $settings->toArray() : '';

        foreach($settings as $key => $value){

            $arr[ $value['name'] ] = $value['value'];

        }

        return $arr;
    }

    public static function getWebSettings($lang = null){
$lang = session()->has('lang_id') ? session('lang_id') : 1;

        $settings = self::where([['name','not like','%home%'],['lang',$lang]])->get();

        $settings ? $settings = $settings->toArray() : '';

        foreach($settings as $key => $value){

            $arr[ $value['name'] ] = $value['value'];

        }
        $arr['header-logo'] = Index::get_image_path($arr['header-logo']);
        $arr['footer-image'] = Index::get_image_path($arr['footer-image']);
        $arr['footer_brand_image_one'] = Index::get_image_path($arr['footer_brand_image_one']);
$arr['footer_brand_image_two'] = Index::get_image_path($arr['footer_brand_image_two']);
$arr['footer_brand_image_three'] = Index::get_image_path($arr['footer_brand_image_three']);
$arr['footer_brand_image_four'] = Index::get_image_path($arr['footer_brand_image_four']);
$arr['footer_brand_image_five'] = Index::get_image_path($arr['footer_brand_image_five']);
$arr['footer_brand_image_six'] = Index::get_image_path($arr['footer_brand_image_six']);

        $arr['payment_image_one'] = Index::get_image_path($arr['payment_image_one']);
$arr['payment_image_two'] = Index::get_image_path($arr['payment_image_two']);
$arr['payment_image_three'] = Index::get_image_path($arr['payment_image_three']);
$arr['payment_image_four'] = Index::get_image_path($arr['payment_image_four']);

$coupons = Coupon::where('expiry_date', '>=', Carbon::today())
    ->where('status', '1')
    ->where(function ($query) {
        $query->whereNull('usage_limit')
              ->orWhereRaw('(
                  SELECT COUNT(*) 
                  FROM coupon_usage 
                  WHERE coupon_usage.coupon_ID = coupons.coupon_ID
              ) < usage_limit');
    })
    ->get();

$arr['coupons'] = $coupons;

        return $arr;
    }

    public static function commonContent($lang = 1){
        
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

        $setting = [];

        $settings = self::where('lang',$lang)->get();

        foreach($settings as $key => $value){

            if( str_contains( $value->name , 'logo' ) || 
                str_contains( $value->name , 'background' ) || 
                str_contains( $value->name , 'image' )  ||
                str_contains( $value->name , 'pdf' )  

            ) :

                $setting[ $value->name ] = [    

                    'path' => Index::get_image_path( $value->value ),

                    'id' => $value->value 
                ];            

            else:

                $setting[ $value->name ] = $value->value;

            endif;

        }

        $result['setting'] = $setting;

        $result['menus'] = Menus::where('status','1')->orderBy('sort_order','ASC')->get()->toArray();
        $result['currencies'] =DB::table('currencies')
        ->select('currencies.*')
        ->get();


        $result['common_order_history'] = DB::table('orders_status_history')
                                            ->leftJoin('orders' , 'orders_status_history.order_id' , '=' , 'orders.ID')
                                            ->where('orders.customer' , auth()->id())
                                            ->select('orders_status_history.*')
                                            ->orderBy('created_at','DESC')
                                            ->get();
                                            if(Auth::check()){

                                                $cartMenu = \App\Models\Web\Cart::where('customer_id', auth()->id())->first();
                                                if($cartMenu){

                                                    $cartMenu['cart_items'] = \App\Models\Web\Cartitems::where('cart_ID', $cartMenu->cart_ID)->get()->toArray();
                                                    $result['cartMenu'] = $cartMenu;
                                                }
                                            }
        return $result;
    }


}
