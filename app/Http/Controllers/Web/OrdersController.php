<?php
namespace App\Http\Controllers\Web;

//validator is builtin class in laravel
use App\Http\Controllers\Web\CartController;
//for password encryption or hash protected
use App\Http\Controllers\Web\ShippingAddressController;
use DB;
//for authenitcate login data
use App\Models\Web\Cart;
use App\Models\Web\Currency;

//for requesting a value
use App\Models\Web\Index;
use App\Models\Web\Languages;
use App\Models\Web\Order;
use App\Models\Web\Products;
use App\Models\Web\Shipping;
use App\Models\Web\Users;
use App\Models\Core\Orderitems;
use App\Models\Core\Values;
use App\Models\Core\Attributes;
use App\Models\Web\ShippingHistory;
use App\Models\Core\OrderHistory;
use App\Models\Core\OrderItemsDelivery;
use App\Models\Core\Setting;
use App\Models\Core\Posts;
use App\Models\Core\Pages;
use App\Models\Core\Content;

//for Carbon a value
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
use Session;
use Mail;
use App\Models\Core\Images;

//email

class OrdersController extends Controller{


    public function placeOrder(Request $request){
        date_default_timezone_set('Asia/Dubai');

        if( !Cart::isEmpty() ) :

            $data = $request->all();
            $order = Order::createOrder($data); 

            Cart::cleanAfterOrder();

            $order = Order::where('ID',$order->id)->first()->toArray();

            $order['customer'] = Auth::check() ? Users::getUserData(Auth::user()->id) : [];

            $order['items'] =  Orderitems::where([['order_ID',$order['ID']]])->get()->toArray();

            foreach( $order['items'] as &$item ) :

                $item['product_ID'] = Products::getProduct($item['product_ID']);

            endforeach;

            

                $settings = Setting::commonContent();   

                

                return redirect('thankyou/'.$order['ID']);



        else :

            return redirect('cart/');

        endif;

    }

 

    

   

  
    public function tracking(){

        $data['content'] = Setting::getHomeContent();

        return view("web.tracking", ['title' => 'Track Order'])->with('data', $data);
    }

    public function trackingViewOrder(Request $request){

        $result = Order::getOrder($request->order_id);

        if ( !$result ) :

            return redirect()->back()->with('error', 'Sorry, the order could not be found. Please contact us if you are having difficulty finding your order details.');

        else :

            return view("web.order-tracked", ['title' => 'Order Tracking'])->with(['result' => $result]);

        endif;
    }

    public function thankyou(Request $request){

        $order = Order::where('ID',$request->ID)->first()->toArray();

        $items = Orderitems::where('order_ID',$request->ID)->get();

        $items ? $items = $items->toArray() : '';

        $order['items'] = $items;

        foreach( $order['items'] as &$item ) :

            $item['product'] = Products::getProduct($item['product_ID']);
            $deliveryItems = OrderItemsDelivery::where('order_item_id', $item['ID'])->get();
            $item['delivery_items'] = $deliveryItems ? $deliveryItems->toArray() : [];
            if($item['product']['prod_parent'] != '' && $item['product']['prod_parent'] != null && $item['product']['prod_parent'] != '0'){
                $parentSlug = Products::where('ID', $item['product']['prod_parent'])->value('prod_slug');
                $item['product']['prod_slug'] = $parentSlug;
            }
            if( $item['item_meta'] != '' ) :

                $item['item_meta'] = unserialize($item['item_meta']);

                if( $order ) :

                    foreach( $item['item_meta'] as $key => &$meta) :

                        $arr = [];

                        $attr = Attributes::where('attribute_slug',$key)->first();

                        $attr ? $attr = $attr->toArray() : '';

                        $arr['attribute'] = $attr;

                        if( $key != 'personal-message') :

                            $value = Values::where([

                                ['value_ID',$meta],

                                ['attribute_ID',$arr['attribute']['attribute_ID']],

                            ])->first();

                            $value ? $value = $value->toArray() : '';

                            $arr['value'] = $value;

                        else :

                            $arr['value'] = $meta;
                            
                        endif;

                        $item['item_meta'][$key] = $arr;

                    endforeach;

                endif;

            endif;

            if( $item['trade_in'] != '' ) :

                $item['trade_in'] = unserialize($item['trade_in']);

                foreach( $item['trade_in'] as &$device ) :

                    $device['exchange'] = Posts::getPostByID($device['exchange']);

                endforeach;

            endif;

        endforeach;
        $featured = Products::getFeatured();

$page = Pages::where('slug', 'thank-you')->first();

$lang = session()->has('lang_id') ? session('lang_id') : 1;

$content = Content::where([
    ['page_id', $page->page_id],
    ['lang', $lang]
])->get();

if ($content->isEmpty() && $lang != 1) {
    $content = Content::where([
        ['page_id', $page->page_id],
        ['lang', 1]
    ])->get();
}

$data['content'] = self::parseContent($content->toArray());
        return view('web.thankyou', ['title' => 'Thankyou'])->with('order',$order)->with('data',$data)->with('featured',$featured);

    }


    public function changeStatus(Request $request){

        $order = Order::where('ID',$request->ID)->update(['order_status' => $request->status]);

        $data = Order::where('ID',$request->ID)->first();

        OrderHistory::create([

            'order_id' => $request->ID,
            'order_status' => $request->status,
            'comments' => $request->comments,

        ]);

        $order = Order::where('ID',$request->ID)->first()->toArray();

        $order['customer'] = Users::getUserData(Auth::user()->id);

        $order['items'] =  Orderitems::where([['order_ID',$order['ID']]])->get()->toArray();

        foreach( $order['items'] as &$item ) :

            $item['product_ID'] = Products::getProduct($item['product_ID']);

        endforeach;

        if( isset($order['address']) ) : $data = unserialize($order['address']); endif;

        // $fromname = 'The Gift Kingdom';
        // $headers = '';
        // $headers .= "From: ".$fromname."<no-reply@thegiftkingdom.com>\r\n";
        // $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

        // $view = view("mail.statusChange")->with('data', Auth()->user())->with('order',$order);

        // $response  = mail($data['email'], $fromname.' |  | Order Status Changed!', $view,$headers);
        // $customer_email = $data['email'];
    //     try {
    //        $response =  Mail::send('mail.statusChange', ['data' =>  Auth()->user(),'order'=>$order], function($message) use ($request, $fromname,$customer_email) {
    //         // $settings = Setting::commonContent();

    //         $message->from('sales@thegiftkingdom.com', $fromname)
    //         ->to($customer_email)
    //         ->subject( $fromname.' | Order Status Changed!');
    //     });
    //    } catch (\Exception $e) {
    //     dd('Error: ' . $e->getMessage());
    // }
    return redirect()->back();
}

public function addReorderCart(Request $request)
{
    $messages = [];
    $images = [];

    $items = $request->input('items', []);

    foreach ($items as $item) {
        $data = Cart::add($item);

        if ($data['added']) {
            $messages[] = $data['product']['prod_title'] . ' (' . $data['qty'] . ') has been added to cart!';
        } else {
            $messages[] = $data['product']['prod_title'] . ' is already in cart!';
        }

        if (isset($data['product']['prod_image'])) {
            $images[] = $data['product']['prod_image'];
        }
    }

    $arr = [
        'message' => implode("\n", $messages),
        'images'  => $images,
    ];

    return json_encode($arr);
}
    public static function parseContent($result)
    {

        $parse = [];

        if ($result != 'default') :

            foreach ($result as $key => $data) :

                $parse[$data['content_key']] = $data['content_value'];

            endforeach;

            foreach ($parse as $key => $data) :

                if (

                    str_contains($key, 'image') ||
                    str_contains($key, 'video')
                ) :

                    $parse[$key] = [

                        'id' => $data,
                        'path' => self::get_image_path($data)


                    ];

                endif;

            endforeach;

        endif;

        return $parse;
    }
        public static function get_image_path($id)
    {

        if (str_contains($id, ',')) :

            $ids = explode(',', $id);

            $path = [];

            foreach ($ids as $id):

                $url = Images::where([
                    ['image_id', '=', $id],

                    ['image_type', '=', 'OPTIMIZED']

                ])->pluck('path')->first();

                if ($url === '' || $url === null) :

                    $url = Images::where([
                        ['image_id', '=', $id],

                        ['image_type', '=', 'ACTUAL']

                    ])->pluck('path')->first();

                endif;

                array_push($path, $url);

            endforeach;


        else :

            $path = Images::where([
                ['image_id', '=', $id],

                ['image_type', '=', 'OPTIMIZED']

            ])->pluck('path')->first();

            if ($path === '' || $path === null) :

                $path = Images::where([
                    ['image_id', '=', $id],

                    ['image_type', '=', 'ACTUAL']

                ])->pluck('path')->first();

            endif;

        endif;

        return $path;
    }
}
