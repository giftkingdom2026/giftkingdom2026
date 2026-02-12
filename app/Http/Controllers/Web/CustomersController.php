<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\AlertController;
use App\Http\Controllers\AdminControllers\MediaController;
use App\Http\Controllers\Web\IndexController;
use App\Models\Web\Cart;
use App\Models\Web\Currency;
use App\Models\Web\Customer;
use App\Models\Web\Index;
use App\Models\Web\Languages;
use App\Models\Web\Products;
use App\Models\Core\Setting;
use App\Models\Core\OrderItemsDelivery;
use App\Models\Web\Order;
use App\Models\Core\Orderitems;
use App\Models\Core\Attributes;
use App\Models\Core\Values;
use App\Models\Core\Posts;
use App\Models\Core\Pages;
use App\Models\Core\OrderHistory;
use App\Models\Web\Wishlist;
use App\Models\Web\Content;
use App\Models\Web\Users;
use App\Models\Web\Referrals;
use App\Models\Web\Reviews;
use App\Models\Web\Wallet;
use App\Models\Web\Usermeta;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Session;
use Socialite;
use Validator;
use Hash;
use Mail;
use App\Http\Controllers\AdminControllers\PostsController;
use App\Models\Core\Postmeta;

class CustomersController extends Controller
{

    protected static function validator(array $data)
    {

        $validator = Validator::make($data, [

            'firstname' => 'required|string|max:255',

            'lastname' => 'required|string|max:255',

            'email' => 'required|string|email|max:255',

            'phone' => 'required|string|max:15',

            'password' => 'required|min:8|',

            'confirmpassword' => 'required|same:password',

        ]);

        return $error = $validator->messages()->toArray();
    }



    public static function register(Request $request)
    {

        $error = 'somtething went wrong!';

        $user = false;

        if (Auth::check()) :

            $user = Auth::user();

            $username = Auth::user()->user_name;

            $message = IndexController::trans_labels('Already logged in!');

            return json_encode(['message' => $message, 'redirect' => asset('account/' . $username)]);

        else :

            $data = $request->all();

            isset($data['data']) ? $data = $data['data'] : '';

            $num = rand(0, 100);

            $username = $data['firstname'] . '_' . $data['lastname'] . $num;

            $check = User::where('user_name', $username)->first();

            if ($check):

                $num = rand(0, 100);

                $username = $data['firstname'] . '_' . $data['lastname'] . $num;

            endif;

            $validate = self::validator($data);

            if (empty($validate)) :

                $check = !User::where('email', $data['email'])->first();

                if ($check) :

                    $referrer = isset($data['referrer']) ? $data['referrer'] : 'none';

                    $user = User::create([

                        'user_name' => strtolower($username),

                        'role_id' => 3,

                        'first_name' => $data['firstname'],

                        'last_name' => $data['lastname'],

                        'email' => $data['email'],

                        'phone' => $data['phone'],

                        'password' => Hash::make($data['password']),

                        'referrer' => $referrer

                    ]);

                    $message = $data['firstname'] . ' ' . IndexController::trans_labels('has been registered!');

                    $settings = Setting::commonContent();




                else :

                    $error = IndexController::trans_labels('This email has already been registered!');

                endif;


            else :

                $error = IndexController::trans_labels('Please check your input and Try Again!');

                if (isset($validate['confirmpassword'])) :

                    $error = IndexController::trans_labels('Passwords do not match!');

                else :

                    !empty($validate) ? $error = array_shift($validate) : '';

                endif;

            endif;

        endif;

        if ($user):

            Auth::login($user);

            return json_encode(['message' => $message, 'redirect' => asset('account/' . $username)]);

        else :

            return json_encode(['message' => $error, 'redirect' => '']);

        endif;
    }

    public static function login(Request $request)
    {

        if (is_array($request)) :

            $data = $request->all();

        else :

            $data = $request;

        endif;

        $key = filter_var($data['email_phone'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials[$key] = $data['email_phone'];
        $user = Users::where('email', $credentials['email'])->first();

        if (isset($user->status) && $user->status == 0) {

            return json_encode(['message' => 'Your Account Is Not Yet Activated', 'redirect' => '']);
        }
        $credentials['password'] = $data['password'];

        $sessionID = Session::getId();

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            Cart::mergeItems($sessionID);

            Wishlist::mergeItems($sessionID);

            return json_encode(['message' => IndexController::trans_labels('Logged in successfully!'), 'redirect' => '', 'loggedin' => true]);
        } else {

            return json_encode(['message' => IndexController::trans_labels('The provided credentials do not match our records.'), 'redirect' => '']);
        }
    }

    public function resetEmail(Request $request){

        $check = Users::where('email',$request->email)->first();

        if( $check ) :
            $response = Mail::send('mail.forgot',['title' => 'Forgot','data' => $check], function($message) use($request){

                $settings = Setting::commonContent();

                $message->from($settings['setting']['email'],$settings['setting']['site-name'])->to( $request->email, $settings['setting']['site-name'])
                ->subject($settings['setting']['site-name'].' | Password Reset!');

            });

            if ($response ) :

                $message = 'Email Sent Successfully!';

                echo json_encode(['message'=> $message,'redirect' => '' , 'status' => true]);

                $status = 'sent';

            else :

                echo json_encode(['message'=>'Please Try Again!','redirect' => '' , 'status' => false]);

                $status = 'failed';

            endif;

        else :

            $status = 'failed';

            echo json_encode(['message'=>'User does not exist!','redirect' => '' , 'status' => false]);

        endif;

    }

    public function authenticate(Request $request)
    {

        $user = Users::where('email', $request->id)->first();

        if (Auth::loginUsingId($user->id)) :

            $request->session()->regenerate();

            $user = Auth::user();

            return json_encode(['message' => 'Logged In Successfully!', 'redirect' => '', 'loggedin' => true]);

        else :

            return json_encode(['message' => 'Logged In Successfully!', 'redirect' => '', 'loggedin' => false]);

        endif;
    }


    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function user_account(Request $request)
    {

$page = Pages::where('slug', 'account-profile')->first();
$lang = session()->get('lang_id', 1);

// Get content for current language
$content = Content::where('page_id', $page->page_id)
                  ->where('lang', $lang)
                  ->get();

// Fallback to default language if no content
if ($content->isEmpty() && $lang != 1) {
    $content = Content::where('page_id', $page->page_id)
                      ->where('lang', 1)
                      ->get();
}

$data['content'] = IndexController::parseContent($content->toArray());


        $username = $request->username;

        $id = Users::where('user_name', $username)->pluck('id')->first();

        $user = Users::getUserData($id);

        $credit = \App\Models\Web\CashbackCredit::getAvailableNew();

        return view("web.account.profile", ['title' => 'Account | Profile'])->with(['result' => $user])->with('data', $data)->with('credit', $credit);
    }

    public function updateProfile(Request $request)
    {

        $data = $request->all();
        unset($data['_token']);

        $message = isset($data['meta']['bank_name']) ? 'Payment Method has been updated Successfully' : 'Profile has been updated successfully';

        if (isset($data['meta'])) :

            foreach ($data['meta'] as $key => $val) :

                $check = Usermeta::where([['meta_key', $key], ['user_id', Auth()->user()->id]])->first();

                $check ? $check = $check->toArray() : '';

                if (!empty($check)) :

                    Usermeta::where([['meta_key', $key], ['user_id', Auth()->user()->id]])->update(['meta_value' => $val]);

                else :

                    Usermeta::create([
                        'meta_key' => $key,
                        'user_id' => Auth()->user()->id,
                        'meta_value' => $val
                    ]);

                endif;

            endforeach;

            unset($data['meta']);

        endif;

        unset($data['old_pass']);

        User::where('id', Auth::user()->id)->update($data);

        $data['email'] = Auth::user()->email;

        $data['user_name'] = Auth::user()->user_name;

        return redirect()->back()->with('message', $message);
    }

    public function updatePassword(Request $request)
    {

        $data = $request->all();

        $data = array_filter($data);

        unset($data['_token']);

        if (isset($data['password'])) :

            if (Hash::check($data['old_pass'], Auth::user()->password)) :

                if (!Hash::check($data['password'], Auth::user()->password)) :

                    if ($data['password'] == $data['confirmpassword']) :

                        unset($data['confirmpassword']);

                        $hashedPassword = Hash::make($data['password']);

                        $user = User::find(Auth::id());

                        $user->password = $hashedPassword;

                        $user->save();

                        $message = 'Password updated successfully!';

                        return redirect()->back()->with('message', $message)->with('password', true);

                    else :

                        $message = 'Passwords do not match!';

                        return redirect()->back()->with('message', $message)->with('password', true);

                    endif;

                else :

                    $message = 'New password cannot be old password!';

                    return redirect()->back()->with('message', $message)->with('password', true);

                endif;

            else :

                $message = 'Invalid old password!';

                return redirect()->back()->with('message', $message)->with('password', true);

            endif;

        endif;
    }


    public function removeAddress(Request $request)
    {

        if ($request->key != 'New'):

            $check = Usermeta::where([['user_id', Auth::user()->id], ['meta_key', 'address']])->pluck('meta_value')->first();

            if ($check) :

                $address = unserialize($check);

                unset($address[$request->key]);

            endif;

            $check2 = false;

            foreach ($address as $addr) :

                isset($addr['default']) ? $check2 = true : '';

            endforeach;

            !$check2 && isset($address[0]) ? $address[0]['default'] = 'yes' : '';

            Usermeta::where([['user_id', Auth()->user()->id], ['meta_key', 'address'],])->update(['meta_value' => serialize($address)]);

        endif;

        return redirect()->back()->with('message', IndexController::trans_labels('Address removed successfully!'));
    }

    public function updateAddress(Request $request)
    {


        $data = $request->all();

        $data = array_shift($data);

        $count = 0;

        foreach ($data as $key => $value) :

            $check = Usermeta::where([

                ['user_id', Auth::user()->id],

                ['meta_key', $key]

            ])->first();

            if ($check) :

                $response = Usermeta::where([

                    ['user_id', Auth::user()->id],

                    ['meta_key', $key]

                ])->update(['meta_value' => $value]);

            else :

                $response = Usermeta::create([

                    'user_id' => Auth::user()->id,

                    'meta_key' => $key,

                    'meta_value' =>  $value

                ]);

            endif;

            $response ? $count++ : '';

        endforeach;

        $count == count($data) ? $message = 'No values were changed!' : $message = 'Address updated successfully!';

        return response()->json(['message' => $message]);
    }

    public function addAddresses(Request $request)
    {

        $data = '';

        $address = view('web.account.address-form', ['data' => $data, 'key' => 'New'])->render();

        return $address;
    }

    public function addresses(Request $request)
    {

$page = Pages::where('slug', 'account-addresses')->first();
$lang = session()->get('lang_id', 1);

// Fetch content for selected language
$content = Content::where('page_id', $page->page_id)
                  ->where('lang', $lang)
                  ->get();

// Fallback to default language if none found
if ($content->isEmpty() && $lang != 1) {
    $content = Content::where('page_id', $page->page_id)
                      ->where('lang', 1)
                      ->get();
}

$data['content'] = IndexController::parseContent($content->toArray());


        $result = Users::getUserData();

        return view('web.account.myaddresses', ['title' => 'My Address'])->with('result', $result)->with('data', $data);
    }

    public function getAddresses(Request $request)
    {

        $result = Users::getUserData();
        if ($request->ajax() && $request->get('is_ajax')) {
            if ($result && count($result) > 0) {
                $meta = $result['metadata'] ?? [];
                $addresses = isset($meta['address']) ? unserialize($meta['address']) : [];
                return response()->json(array_values($addresses));
            } else {
                return response()->json([]);
            }
        }

        return view('web.account.address-list')->with('result', $result)->render();
    }

    public function MyAccount(Request $request)
    {

        $result = Users::getUserData();

        return view('web.account.my-account', ['title' => 'My Account'])->with('result', $result);
    }


    public function wallet(Request $request)
    {

        $social = Usermeta::where([['user_id', Auth()->user()->id], ['meta_key', 'social_share']])->pluck('meta_value')->first();

        date_default_timezone_set('Asia/Dubai');

        if ($social != null) :

            $social = unserialize($social);

            foreach ($social as $key => &$item) :

                if ($item['completed'] == 0) :

                    if (strtotime($item['date']) + 86400 < strtotime(date('d-M-Y H:i:s'))):

                        Wallet::create([

                            'user_id' => Auth()->user()->id,
                            'transaction_type' => 'credit',
                            'transaction_points' => 1000,
                            'transaction_status' => 'Social',
                            'transaction_comment' => 'Social Share ' . $key,
                            'transaction_madeby' => Auth()->user()->id,
                            'expiry_date' => now()->addYear()

                        ]);
                        $check = Users::updateMeta('store_credit', 1000);
                        $item['completed'] = 1;
                    endif;

                endif;

            endforeach;

        else :

            $social = [];

        endif;

        Users::updateMeta('social_share', serialize($social));

        $result = Users::getUserData();

        $referrals = Referrals::where('user_id', Auth()->user()->id)->get();

        $referrals ? $referrals = $referrals->toArray() : '';

        $result['referral_count'] = 0;

        foreach ($referrals as &$ref) :

            $ref['referral_id'] = Users::getUserData($ref['referral_id']);

            $result['referral_count']++;

        endforeach;

        $result['referral_revenue'] = ($result['referral_count'] * 400);

        if ($result['referrer'] != 'none') :

            $result['referrer'] = Users::where('user_name', $result['referrer'])->pluck('id')->first();

            $result['referrer'] = Users::getUserData($result['referrer']);

        endif;

        return view('web.account.wallet', ['title' => 'My Wallet'])->with('result', $result)->with('referrals', $referrals)->with('social', $social);
    }

    public function walletHistory(Request $request)
    {

        // $result['credit'] = Usermeta::where([['user_id',Auth()->user()->id],['meta_key','store_credit']])->pluck('meta_value')->first();
        // $result['credit'] = \App\Models\Web\CashbackCredit::getAvailable();
        $result['credit'] = \App\Models\Web\CashbackCredit::getAvailableNew();
        $result['user'] = Users::getUserData();
        $result['total_earned'] = Wallet::where('user_id', Auth::user()->id)->where('transaction_type', 'credit')->where('transaction_status', 'completed')->sum('transaction_points');
        $result['total_redeemed'] = Wallet::where('user_id', Auth::user()->id)->where('transaction_type', 'debit')->where('transaction_status', 'completed')->sum('transaction_points');


        $wallet = Wallet::where('user_id', Auth()->user()->id)->orderBy('created_at', 'DESC')->get();

        $wallet ? $wallet = $wallet->toArray() : '';

        $result['history'] = $wallet;

$page = Pages::where('slug', 'wallet-history')->first();

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

$data['content'] = IndexController::parseContent($content->toArray());
        return view('web.account.wallethistory', ['title' => 'Wallet History'])->with('result', $result)->with('data', $data);
    }

    public function updateAddresses(Request $request)
    {

        Usermeta::updateAddress($request->all());

        $data = Users::getUserData();

        $view = view('web.account.addresses')->with('data', $data)->render();

        return json_encode(['message' => 'Address updated successfully!', 'redirect' => '', 'html' => $view]);
    }

    public function setDefault(Request $request)
    {

        $check = Usermeta::where([['user_id', Auth::user()->id], ['meta_key', 'address']])->pluck('meta_value')->first();

        if ($check) :

            $address = unserialize($check);

            foreach ($address as $key => &$addr) :

                if (isset($addr['default'])) : unset($addr['default']);
                endif;

            endforeach;

            $address[$request->index]['default'] = 'yes';

            $newarr[] = $address[$request->index];
            unset($address[$request->index]);

            foreach ($address as $addr) :

                isset($addr['default']) && $addr['default'] == 'yes' ? '' : $newarr[] = $addr;

            endforeach;

            Usermeta::where([['user_id', Auth()->user()->id], ['meta_key', 'address']])->update(['meta_value' => serialize($newarr)]);

        endif;
    }

    public function paymentOption(Request $request)
    {

        $result = Users::getUserData();

        return view('web.account.payment-option', ['title' => 'Payment Option'])->with('result', $result);
    }

    public function orders(Request $request)
    {

        $where = [['customer', Auth()->user()->id]];

$page = Pages::where('slug', 'account-order-status')->first();
$lang = session()->get('lang_id', 1);

if (isset($request->status)) {
    if ($request->status === 'Refunded') {
        $where[] = ['order_status', 'like', 'Re%'];
        $page = Pages::where('slug', 'account-order-returns')->first();
    }
}

$content = Content::where('page_id', $page->page_id)
                  ->where('lang', $lang)
                  ->get();

if ($content->isEmpty() && $lang != 1) {
    $content = Content::where('page_id', $page->page_id)
                      ->where('lang', 1)
                      ->get();
}

$data['content'] = IndexController::parseContent($content->toArray());


        $orders = Order::where($where)->orderBy('created_at', 'DESC')->paginate('15');

        $orders ? $orders = $orders->toArray() : '';

        foreach ($orders['data'] as &$order) :

            $order['items'] = Orderitems::where('order_ID', $order['ID'])->count();

        endforeach;

        return view('web.account.orders', ['title' => 'Order Status'])->with('orders', $orders)->with('data', $data);
    }

    public function orderDetail(Request $request)
    {

        $order = Order::where('ID', $request->id)->first()->toArray();

        if ($order['customer'] != Auth::user()->id) :
            return redirect(asset('/account/orders'));
            die();
        endif;

        $order['refund'] = OrderHistory::where([['order_id', $request->id], ['order_status', 'Refund']])->pluck('comments')->first();

        $order['cancel'] = OrderHistory::where([['order_id', $request->id], ['order_status', 'Cancelled']])->pluck('comments')->first();

        $items = Orderitems::where('order_ID', $request->id)->get();

        $items ? $items = $items->toArray() : '';
        $order['items'] = $items;

        foreach ($order['items'] as &$item) :
            $item['product'] = Products::getProduct($item['product_ID']);
            $deliveryItems = OrderItemsDelivery::where('order_item_id', $item['ID'])->get();
            $item['delivery_items'] = $deliveryItems ? $deliveryItems->toArray() : [];
            if ($item['item_meta'] != '') :

                $item['item_meta'] = unserialize($item['item_meta']);
                if ($order) :
                    foreach ($item['item_meta'] as $key => &$meta) :
                        if ($key === 'personal-message') {
                            continue;
                        }
                        $arr = [];

                        $attr = Attributes::where('attribute_slug', $key)->first();

                        $attr ? $attr = $attr->toArray() : '';

                        if (!empty($attr)) :

                            $arr['attribute'] = $attr;

                            $value = Values::where([

                                ['value_ID', $meta],

                                ['attribute_ID', $arr['attribute']['attribute_ID']],

                            ])->first();

                            $value ? $value = $value->toArray() : '';

                            $arr['value'] = $value;

                        endif;

                        $item['item_meta'][$key] = $arr;

                    endforeach;

                endif;

            endif;

        endforeach;
$reasons = Posts::where('post_type', 'reasons')
    ->where('post_status', 'publish')
    ->orderByRaw("
        CASE 
            WHEN sort_order IS NULL OR sort_order = 0 THEN 0 
            ELSE 1 
        END ASC
    ")
    ->orderByRaw("
        CASE 
            WHEN sort_order IS NULL OR sort_order = 0 THEN created_at 
            ELSE NULL 
        END DESC
    ")
    ->orderBy('sort_order', 'ASC')
    ->get();
        $reasons ? $reasons = $reasons->toArray() : '';

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

$reasons = Postmeta::getMetaData($reasons, $lang);

foreach ($reasons as &$reason) {
    if ($lang != 1 && isset($reason['metadata']['meta_title']) && !empty($reason['metadata']['meta_title'])) {
        $reason['post_title'] = $reason['metadata']['meta_title'];
    }
}
unset($reason);

$reasons = PostsController::parsePostContent($reasons);

        return view('web.account.orderdetail', ['title' => 'My Return'])->with('order', $order)->with('reasons', $reasons);
    }


    public function giveReviews(Request $request)
    {

        $where = [['customer', Auth()->user()->id], ['order_status', 'Delivered']];

        $orders = Order::where($where)->pluck('ID');

        $orders ? $orders = $orders->toArray() : '';
        $items = Orderitems::whereIn('order_ID', $orders)->orderBy('created_at', 'DESC')->get();
        $items ? $items = $items->toArray() : '';

        foreach ($items as $key => &$item) :
            $order = Order::find($item['order_ID']);
            $item['order_currency_value'] = $order['currency_value'];
            $item['order_currency'] = $order['currency'];
            if($item['variation_ID'] != null && $item['variation_ID'] != 0){

                $item['is_reviewed'] = Reviews::where([['object_ID', $item['product_ID']], ['customer_ID', Auth()->user()->id], ['variation_ID', $item['variation_ID']]])->count();
            }else{
                $item['is_reviewed'] = Reviews::where([['object_ID', $item['product_ID']], ['customer_ID', Auth()->user()->id]])->count();

            }
            $id = $item['variation_ID'] != 0 ? $item['variation_ID'] : $item['product_ID'];

            $product = Products::where('ID', $id)->first(['prod_image', 'prod_slug', 'prod_title', 'price', 'prod_parent']);

            if (isset($product) && $product->prod_parent != "0") {
                $product->prod_slug = Products::where('ID', $product->prod_parent)->value('prod_slug');
            }

            $product ? $product = $product->toArray() : '';

            if ($product) :

                $product['prod_image'] = Index::get_image_path($product['prod_image']);

                $item['product'] = $product;

            else :

                unset($items[$key]);

            endif;

            if ($item['item_meta'] != '') :

                $item['item_meta'] = unserialize($item['item_meta']);
                // dd($item['item_meta']);
                foreach ($item['item_meta'] as $key => &$meta) :
                    if ($key === 'personal-message') {
                        continue; // keep personal-message untouched
                    }

                    $arr = [];

                    $attr = Attributes::where('attribute_slug', $key)->first();
                    $attr ? $attr = $attr->toArray() : '';

                    if (!empty($attr)) {
                        $arr['attribute'] = $attr;

                        $value = Values::where([
                            ['value_ID', $meta],
                            ['attribute_ID', $arr['attribute']['attribute_ID']],
                        ])->first();

                        $value ? $value = $value->toArray() : '';

                        $arr['value'] = $value;

                        $item['item_meta'][$key] = $arr;
                    }
                endforeach;


            endif;

        endforeach;
        
$page = Pages::where('slug', 'reviews')->first();

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

$data['content'] = IndexController::parseContent($content->toArray());
        return view('web.account.give-reviews', ['title' => 'Past Purchases'])->with('items', $items)->with('data', $data);
    }

public function addReview(Request $request)
{
    $page = Pages::where('slug', 'reviews')->first();

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

$data['content'] = IndexController::parseContent($content->toArray());
    $item = Orderitems::where('ID', $request->id)->first()->toArray();
    $item['order'] = Order::find($item['order_ID']);
    $item['product'] = Products::getProduct($item['product_ID']);
    if($item['product']['prod_type'] == 'variation'){

        $item['variation'] = Products::getProduct($item['variation_ID']);
    }

    if (!empty($item['item_meta']) && is_string($item['item_meta'])) {
        $item['item_meta'] = unserialize($item['item_meta']);
    }

    if (!empty($item['item_meta']) && is_array($item['item_meta'])) {
        foreach ($item['item_meta'] as $key => &$meta) {
            if ($key === 'personal-message') {
                continue;
            }

            $arr = [];

            $attr = Attributes::where('attribute_slug', $key)->first();
            $attr ? $attr = $attr->toArray() : '';

            if (!empty($attr)) {
                $arr['attribute'] = $attr;

                $value = Values::where([
                    ['value_ID', $meta],
                    ['attribute_ID', $arr['attribute']['attribute_ID']],
                ])->first();

                $value ? $value = $value->toArray() : '';

                $arr['value'] = $value;
            }

            $item['item_meta'][$key] = $arr;
        }
        unset($meta);
    }

    return view('web.account.add-review', [
        'title' => 'My Reviews',
        'item'  => $item
    ])->with('data', $data);
}





    public function forgot(Request $request)
    {

        return view('web.account.forgot', ['title' => 'Forgot Password']);
    }

    public function resetPassword(Request $request){
if(Auth::check()){
    return redirect('/');
}
        return view('web.account.reset',['title' => 'Rest Password']);

    }

    public function reset(Request $request)
    {

        $data = Users::where('user_name', $request->username)->first();

        $data ? $data = $data->toArray() : '';

        if ($request->password != $request->confirmpassword) :

            echo json_encode(['message' => 'Passwords do not match!', 'redirect' => '']);

        else :

            if (Hash::check($request->password, $data['password'])) :

                $message = 'New password cannot be old password!';

                echo json_encode(['message' => 'New password cannot be old password!', 'redirect' => '']);

            else :

                if (strlen($request->password) < 8) :

                    echo json_encode(['message' => 'The password must be at least 8 characters.', 'redirect' => '']);

                else :

                    Users::where('user_name', $request->username)->update(['password' => Hash::make($request->password)]);

                    echo json_encode(['message' => 'Password changed successfully!', 'redirect' => asset('?login')]);

                endif;

            endif;

        endif;
    }

    public function trackOrder()
    {
$page = Pages::where('slug', 'tracking')->first();
$lang = session()->get('lang_id', 1);

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

$data['content'] = IndexController::parseContent($content->toArray());


        return view("web.account.track", ['title' => 'Account | Track Order'])->with('data', $data);
    }

    public function trackedOrder(Request $request)
    {
$page = Pages::where('slug', 'tracking')->first();
$lang = session()->get('lang_id', 1);

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

$data['content'] = IndexController::parseContent($content->toArray());
        $order = Order::where('ID', $request->order_id)->first();

        if (!$order) {
            return redirect()->back()->with('error','Order Not Found');
        }

        $order = $order->toArray();


        if ($order['customer'] != Auth::user()->id) :

            return redirect(asset('/account/orders'));
            die();

        endif;

        $order['refund'] = OrderHistory::where([['order_id', $request->order_id], ['order_status', 'Refund']])->pluck('comments')->first();

        $order['cancel'] = OrderHistory::where([['order_id', $request->order_id], ['order_status', 'Cancelled']])->pluck('comments')->first();

        $items = Orderitems::where('order_ID', $request->order_id)->get();

        $items ? $items = $items->toArray() : '';

        $order['items'] = $items;

        foreach ($order['items'] as &$item) :

            $item['product'] = Products::getProduct($item['product_ID']);

            if ($item['item_meta'] != '') :

                $item['item_meta'] = unserialize($item['item_meta']);

                if ($order) :

                    foreach ($item['item_meta'] as $key => &$meta) :

                        $arr = [];

                        $attr = Attributes::where('attribute_slug', $key)->first();

                        $attr ? $attr = $attr->toArray() : '';

                        if (!empty($attr)) :

                            $arr['attribute'] = $attr;

                            $value = Values::where([

                                ['value_ID', $meta],

                                ['attribute_ID', $arr['attribute']['attribute_ID']],

                            ])->first();

                            $value ? $value = $value->toArray() : '';

                            $arr['value'] = $value;

                        endif;

                        $item['item_meta'][$key] = $arr;

                    endforeach;

                endif;

            endif;

        endforeach;

        if (!$order) :

            return redirect()->back()->with('error', 'Sorry, the order could not be found. Please contact us if you are having difficulty finding your order details.');

        else :

            return view("web.account.tracked", ['title' => 'Tracking'])->with(['order' => $order])->with('data', $data);

        endif;
    }

    public function filterWalletHistory(Request $request)
    {
        $type = $request->input('type');

        $wallet = Wallet::where('user_id', Auth()->user()->id)->orderBy('created_at', 'desc')->get();

        $wallet ? $wallet = $wallet->toArray() : '';

        if ($type) {
            $history = array_filter($wallet, function ($item) use ($type) {
                if ($type != 'All') {
                    return strtolower($item['transaction_type']) === $type;
                } else {
                    return strtolower($item['transaction_type']);
                }
            });
        }

        $view = view('web.partials.wallet_history_table', ['history' => $history])->render();

        return response()->json(['view' => $view]);
    }

    public function becomeSeller(Request $request){

    $result = Users::getUserData();

    return view('web.account.becomeseller',['title' => 'Become A Vendor'])->with('result',$result);

}

public function updateVendor(Request $request){

    $data = $request->all();

    $role = Auth()->user()->role_id == 1 ? 1 : 4;
    

    User::where('id', Auth::user()->id)->update(['role_id' => $role ]);

    if( isset( $data['meta']['files'] ) ) :

        $files = $data['meta']['files']; unset($data['meta']['files']);

        $files = array_filter($files);

        foreach($files as $key => $value ):

            if( $key == 'residence_id' ) :

                $arr = [];

                foreach( $value as $subitem ) :

                    $arr[] = MediaController::mediaUpload($subitem);

                endforeach;

$data['meta'][$key] = implode(',', $arr);

            else :

                $data['meta'][$key] = MediaController::mediaUpload($value);

            endif;

        endforeach;

    endif;

    if( isset( $data['meta'] ) ) :

        $data['meta'] = array_filter($data['meta']);
        
        foreach($data['meta'] as $key => $val ) :

            Usermeta::updateOrCreate(['meta_key' => $key,'user_id' => Auth()->user()->id],[

                'user_id' => Auth()->user()->id,
                'meta_key' => $key,
                'meta_value' => $val
            ]);

        endforeach;

    endif;
    
    $message = $role == 4 || $role == 1 ? 'Vendor Updated!' : 'Vendor Application Submitted!';

    return redirect()->back()->with('message', $message );

}
}
