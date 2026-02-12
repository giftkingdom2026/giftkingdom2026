<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\MediaController;
use App\Models\Web\Index;
use App\Models\Web\Cart;
use App\Models\Core\Setting;
use App\Models\Core\Images;
use App\Models\Core\Pages;
use App\Models\Core\Terms;
use App\Models\Core\Termmeta;
use App\Models\Web\Products;
use App\Models\Web\Wallet;
use App\Models\Core\Brands;
use App\Models\Core\Postmeta;
use App\Models\Web\Analytics;
use App\Models\Core\Posts;
use App\Models\Core\Content;
use App\Models\Core\TermRelations;
use App\Models\Web\Categories;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\Megamenu;
use App\Http\Controllers\AdminControllers\PostsController;
use App\Http\Controllers\Web\ShippingAddressController;
use App\Models\Web\Wishlist;
use App\Models\Web\Users;
use App\Models\Web\EventInquiry;
use App\Models\Web\Order;
use App\Models\Web\Usermeta;
use App\Models\Web\WebSetting;
use App\Models\Web\Reviews;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use GuzzleHttp\Client;
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
use Illuminate\Pagination\LengthAwarePaginator;

class IndexController extends Controller
{

    public function index(Request $request)
    {

        Index::setCurrency();

        $data['content'] = Setting::getHomeContent();

        $data['products'] = isset($data['content']['home_s3_products']) ? Products::getProducts(unserialize($data['content']['home_s3_products'])) : [];

        $data['banners'] = Index::getBanners();

        $data['categories'] = Categories::getHomeCategories(unserialize($data['content']['home_s1_categories']));
        $data['categories2'] = Categories::getHomeCategories(unserialize($data['content']['home_s3_categories']));
        $data['categories3'] = Categories::getHomeCategories(unserialize($data['content']['home_s6_categories']));
        $data['categories4'] = Categories::getHomeCategories(unserialize($data['content']['home_s7_categories']));

        $data['category1'] = Categories::getHomeCategory($data['content']['home_s2_cat']);

        $data['category2'] = Categories::getHomeCategory($data['content']['home_s4_cat']);

        return view("web.index", ['title' => 'Home'])->with('data', $data);
    }

    public function blogDetail(Request $request)
    {

        $data = Posts::select('ID', 'post_title', 'post_excerpt', 'post_content', 'post_name', 'featured_image', 'created_at')
            ->where([['post_type', 'blogs'], ['post_status', 'publish'], ['post_name', $request->slug]])->first();


        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        $meta = Postmeta::getMetaData($data['ID'], $lang);

        $query = TermRelations::leftJoin('taxonomy_terms', 'taxonomy_term_relations.term_id', '=', 'taxonomy_terms.terms_id')
            ->where('taxonomy_term_relations.post_id', $data['ID'])
            ->groupBy('taxonomy_term_relations.post_id');

        if ($lang != 1) :

            $termid = $query->pluck('taxonomy_terms.terms_id')->first();

            $where = [['taxonomy_id', 1], ['terms_id', $termid], ['meta_key', 'term_title'], ['lang', $lang]];

            $cat = Termmeta::where($where)->pluck('meta_value')->first();

        else :

            $cat = $query->pluck('taxonomy_terms.term_title')->first();

        endif;

        $data['cat'] = $cat;

        $data['featured_image'] = Index::get_image_path($data['featured_image']);

        $related = Posts::select('ID', 'post_title', 'post_excerpt', 'post_name', 'featured_image', 'created_at')
            ->where([['post_type', 'blogs'], ['post_status', 'publish'], ['ID', '!=', $data['ID']]])->orderBy('sort_order', 'ASC')->limit(2)->get();

        $related ? $related = $related->toArray() : '';

        $related = Postmeta::getMetaData($related, $lang);

        $related = PostsController::parsePostContent($related);

        foreach ($related as &$blog) :

            $query = TermRelations::leftJoin('taxonomy_terms', 'taxonomy_term_relations.term_id', '=', 'taxonomy_terms.terms_id')
                ->where('taxonomy_term_relations.post_id', $blog['ID'])
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

        if ($data) :

            return view("web.blog-detail", ['title' => 'Blogs'])->with('data', $data)->with('related', $related)->with('meta', $meta);

        else :

            return view('errors.404', ['title' => '404']);

        endif;
    }

    public function renderPage(Request $request)
    {

        $slug = Route::current()->uri();

        $page = Pages::where('slug', $slug)->first();

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


        if ($slug == 'our-blogs') :

            $data['blogs'] = Index::getBlogs();

        elseif ($slug == 'events') :

            $data['events'] = Index::getEvents();

        elseif ($slug == 'career') :

            $data['categories'] = Index::getCareerCategories();

        elseif ($slug == 'faq') :

            $data['faq'] = Index::getFaqs();

        elseif ($slug == 'help-center') :

            $data['help-center'] = Index::getHelpCenter();

            $data['most-asked'] = Index::getHelpCenter('most');

        endif;

        $check = view()->exists("web." . $page->file);

        if ($check) :

            return view("web." . $page->file, ['title' => ucwords($slug)])->with('data', $data);

        else :

            return view("web.page", ['title' => ucwords($slug)])->with('data', $data);

        endif;
    }


    public function getSizes(Request $request)
    {

        return Index::getSizes($request->id, $request->count);
    }

    public function careerCategory(Request $request)
    {

        $data['term'] = Terms::getTermBySlug($request->slug);

        $data['job-count'] = TermRelations::where('term_id', $data['term']['terms_id'])->count();

        $data['jobs'] = Posts::getPostsByTerm($data['term']['terms_id'], $data['term']['taxonomy_id']);

        return view("web.career-category", ['title' => 'Career Category'])->with('data', $data);;
    }

    public function jobDetail(Request $request)
    {

        $data = Posts::getPostBySlug($request->slug, 'jobs');

        if (!$data) :

            return view('errors.404');

        endif;

        return view("web.job-detail", ['title' => 'Job'])->with('data', $data);
    }

    public function eventDetail(Request $request)
    {

        $data = Posts::getPostBySlug($request->slug, 'events');

        if (!$data) :

            return view('errors.404');

        endif;

        $data['events'] = Index::getEvents();
        return view("web.event-detail", ['title' => 'Event'])->with('data', $data);
    }
    public function eventDetailQuote(Request $request)
    {

        try {
            EventInquiry::create($request->all());

            echo json_encode(['message' => IndexController::trans_labels("Submitted Successfully!"), 'redirect' => '']);
        } catch (\Exception $e) {
            echo json_encode(['message' => IndexController::trans_labels("An Error Occurred"), 'redirect' => '']);
        }
    }
    public function jobSearch(Request $request)
    {

        $data = Posts::searchJob($request);

        return view("web.career-search", ['title' => 'Search Job'])->with('data', $data);
    }

    public function searchQuestion(Request $request)
    {

        $data['help-center'] = Posts::searchQuestion($request);

        $data['most-asked'] = Index::getHelpCenter('most');

        return view("web.help-center", ['title' => 'Search Question'])->with('data', $data);
    }

    public function checkout()
    {

        $page = Pages::where('slug', 'checkout')->first();
        $lang = session()->get('lang_id', 1);

        // Try to get content for the current language
        $content = Content::where('page_id', $page->page_id)
            ->where('lang', $lang)
            ->get();

        // Fallback to default language if none found
        if ($content->isEmpty() && $lang != 1) {
            $content = Content::where('page_id', $page->page_id)
                ->where('lang', 1)
                ->get();
        }

        $content = $content->toArray();


        Cart::updateCart();

        $data['cart'] = Cart::getCart();

        $count = 0;

        foreach ($data['cart']->items as $item) : $item['in_order'] == 1 ? $count++ : '';
        endforeach;

        if ($count == 0) : return redirect(asset('cart'));
        endif;

        Auth::check() ? $data['user'] = Users::getUserData() : $data['user'] = [];

        $credit = \App\Models\Web\CashbackCredit::getAvailableNew();

        $data['content'] = self::parseContent($content);

        $data['timeslots'] = ShippingAddressController::timeSlots();
        return view("web.checkout", ['title' => 'Checkout'])->with('data', $data)->with('credit', $credit);
    }

    public function updateCheckout(Request $request)
    {

        $data['cart'] = Cart::getCart();

        $data['shipping'] = $request->shipping;

        $credit = \App\Models\Web\CashbackCredit::getAvailableNew();
        return view("web.checkout-summary")->with('data', $data)->with('credit', $credit)->render();
    }

    public function maintance()
    {

        return view('errors.maintance');
    }

    public function error()
    {

        return view('errors.general_error', ['msg' => $msg]);
    }

    public function logout()
    {

        Auth::guard('customer')->logout();
        return redirect()->back();
    }

    //setcookie

    public function setcookie(Request $request)
    {
        Cookie::queue('cookies_data', 1, 4000);
        return json_encode(array('accept' => 'yes'));
    }

    public function changeCurrency(Request $request)
    {

        $settings = new WebSetting();

        $currency = $settings->getCurrency($request->currency_id);

        session(['currency_id' => $currency->id]);
        session(['currency_title' => $currency->code]);
        session(['symbol_right' => $currency->symbol_right]);
        session(['symbol_left' => $currency->symbol_left]);
        session(['currency_code' => $currency->code]);
        session(['currency_value' => $currency->value]);
        session(['currency_flag' => $currency->flag]);

        echo 'success';
    }

    public function changeLang(Request $request)
    {
        $lang = DB::table('languages')->where('languages_id', $request->lang)->first();

        session(['lang' => $lang->code]);
        session(['lang_id' => $lang->languages_id]);
    }

    public static function trans_labels($value)
    {

        $labels = DB::table('labels')->leftJoin('label_value', 'label_value.label_id', '=', 'labels.label_id')
            ->where('label_value.language_id', '=', session('lang_id'))
            ->where('labels.label_name', '=', $value)
            ->first();

        if (!isset($labels->label_value)) :

            return $value;

        else :

            return $labels->label_value;

        endif;
    }

    public function Inquiry(Request $request)
    {

        $data = $request->all();

        if (!empty($data)) :

            $settings = Setting::commonContent();

            DB::table('inquiry')->insert([
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'subject' => $data['subject'] ?? '',
                'message' => $data['message'] ?? '',
                'vendor_id' => $data['vendor_id'] ?? null,
                'support_category' => $data['support_category'] ?? '',
                'created_at' => now(),
            ]);

            if (isset($data['file'])) :

                $file = MediaController::mediaUpload($data['file']);

                $file = Index::get_image_path($file);

                unset($data['file']);

            // $settings['setting']['email']

            else :

                $response = true;

            // $fromname = 'The Gift Kingdom';
            // $headers = '';
            // $headers .= "From: ".$fromname."<no-reply@thegiftkingdom.com>\r\n";
            // $headers .= "MIME-Version: 1.0\r\n";
            // $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

            // $view = view("mail.contactUs")->with('data', $data);

            // $response = mail($settings['setting']['email'], $fromname.' | Inquiry', $view,$headers);
            //     try {
            //        $response =  Mail::send('mail.contactUs', ['data' => $data], function($message) use ($request, $fromname) {
            // // $settings = Setting::commonContent();

            //         $message->from('sales@thegiftkingdom.com', $fromname)
            //         ->to('no-reply@thegiftkingdom.com', $fromname)
            //         ->subject( $fromname.' | Inquiry');
            //     });
            //    } catch (\Exception $e) {
            //     dd('Error: ' . $e->getMessage());
            // }

            endif;

            if ($response) :

                $message = isset($request->subscribe) ? IndexController::trans_labels('Subscription Successfull!') : IndexController::trans_labels('Email Sent Successfully!');

                echo json_encode(['message' => $message, 'redirect' => '']);

                $status = 'sent';

            else :

                echo json_encode(['message' => 'Please Try Again!', 'redirect' => '']);

                $status = 'failed';

            endif;

        else :

            $status = 'failed';

            echo json_encode(['message' => 'Required fields missing!', 'redirect' => '']);

        endif;

        // Index::record_inquiry($data,$status);

    }

    public  function mailchimpRequest(Request $request)
    {
        if (isset($request['subscribe'])) :

            $apiKey = '9fabe37decd9c4cb42ef06b5776e86f8-us13';

            $listId = '57387bf19c';

            $json = json_encode([

                'apikey'        => $apiKey,

                'email_address' => $request['subscribe'],

                'status'        => 'subscribed',

            ]);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://us13.api.mailchimp.com/3.0/lists/' . $listId . '/members/');

            curl_setopt($ch, CURLOPT_USERPWD, 'uname:' . $apiKey);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            $json = $result;

            $return = json_decode($json, true);

            $message = isset($return['status']) && $return['status'] == 'subscribed' ? 'Subscription Successfull!' : 'Member already exists!';

            echo json_encode(['message' => $message, 'redirect' => '']);

        else :

            echo json_encode(['message' => 'Required fields missing!', 'redirect' => '']);

        endif;
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


    public static function getCommonData()
    {
        $result['commonContent'] = Setting::commonContent();

        // $result['commonContent']['setting']['home_prod_1_slug'] = Products::where('prod_slug', $result['commonContent']['setting']['home_prod_1'])->first()->prod_slug;

        $result['cart'] = Cart::getCount();

        $result['wishlist'] = Wishlist::getCount();
        $result['megamenu'] = Megamenu::getMenu();
        // dd('a');

        if (Auth::check()) :

            $default = '';

            $addresses = [];

            $addresses = Usermeta::where([['user_id', Auth::user()->id], ['meta_key', 'address']])->pluck('meta_value')->first();

            $addresses = unserialize($addresses);

            $addresses == null ? $addresses = [] : '';

            foreach ($addresses as $addr) :

                isset($addr['default']) ? $default = $addr : '';

            endforeach;


            $result['default-addr'] = $default;

        endif;
        return $result;
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


    public function analytics(Request $request)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://www.geoplugin.net/json.gp?ip=' . $request->ip);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $data = curl_exec($ch);

        Analytics::recorduser($data, $request);
    }

    public function notifications()
    {
        $perPage = request()->get('per_page', 10);
        $page = request()->get('page', 1);

        $order_history = Setting::commonContent()['common_order_history']->toArray();

        $wallet_notifications = \App\Models\Web\Wallet::where('user_id', auth()->user()->id)
            ->where('transaction_comment', '!=', 'Order Purchase')
            ->get()
            ->toArray();

        $order_notifications = array_map(function ($item) {
            $id = $item->order_id;
            $status = $item->order_status;
            $comments = $item->comments ?? '';
            $created_at = $item->created_at;
            $timestamp = strtotime($created_at);
            $date = date('l, d F Y', $timestamp);

            $title = "#$id | $status";
            if (!empty($comments)) {
                $title .= " : $comments";
            }
            $title .= " - $date";

            return [
                'type' => 'order',
                'title' => $title,
                'id' => $id,
                'created_at' => $created_at,
                'timestamp' => $timestamp,
            ];
        }, $order_history);

        usort($order_notifications, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        $wallet_notifications = array_map(function ($wallet) {
            $id = $wallet['ID'];
            $comment = $wallet['transaction_comment'] ?? '';
            $created_at = $wallet['created_at'];
            $timestamp = strtotime($created_at);
            $date = date('l, d F Y', $timestamp);

            $title = $comment . " - $date";

            return [
                'type' => 'wallet',
                'title' => $title,
                'id' => $id,
                'created_at' => $created_at,
                'timestamp' => $timestamp,
            ];
        }, $wallet_notifications);

        usort($wallet_notifications, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        $all_notifications = array_merge($order_notifications, $wallet_notifications);

        usort($all_notifications, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']); // final sort

        $offset = ($page - 1) * $perPage;
        $pagedData = array_slice($all_notifications, $offset, $perPage);

        $paginatedNotifications = new LengthAwarePaginator(
            $pagedData,
            count($all_notifications),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $pageData = Pages::where('slug', 'notifications')->first();
        $lang = session()->get('lang_id', 1);

        $content = Content::where([
            ['page_id', $pageData->page_id],
            ['lang', $lang]
        ])->get();

        if ($content->isEmpty() && $lang != 1) {
            $content = Content::where([
                ['page_id', $pageData->page_id],
                ['lang', 1]
            ])->get();
        }

        $data['content'] = self::parseContent($content->toArray());


        return view("web.notifications", [
            'title' => 'Notifications',
            'all_notifications' => $paginatedNotifications,
            'result' => $paginatedNotifications->toArray()
        ])->with('data', $data);
    }

    public function markRead(Request $request)
    {
        $notifications = $request->input('notifications', []);

        foreach ($notifications as $item) {
            if ($item['type'] === 'wallet') {
                \App\Models\Web\Wallet::where('id', $item['id'])
                    ->where('user_id', auth()->id())
                    ->update(['is_read' => 1]);
            } elseif ($item['type'] === 'order') {
                DB::table('orders_status_history')
                    ->where('id', $item['id'])
                    ->update(['is_read' => 1]);
            }
        }

        return response()->json(['message' => 'Notifications marked as read.']);
    }

    public function getSavedCartitemAddresses(Request $request)
    {
        $cartItemAddress = \App\Models\Core\CartItemAddress::query()
            ->where('label', $request->label)
            ->where('product_id', $request->product_id)
            ->where('cart_item_id', $request->cart_item_id)
            ->first();

        if ($cartItemAddress) {
            return response()->json([
                'success' => true,
                'data' => $cartItemAddress
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => null
        ]);
    }
    public function storeDetail(Request $request)
    {

        $id = Usermeta::where([['meta_key', 'store_name'], ['meta_value', $request->storename]])->pluck('user_id')->first();
        $data['user'] = Users::getUserData($id);
        $data['store'] = Users::getUserData($id);

        $data['rand-products'] = Products::getStoreProducts($id);

        return view("web.store-details", ['title' => 'Home'])->with('data', $data);
    }

    public function stores(Request $request)
    {
        $pageData = Pages::where('slug', 'stores')->first();
        $lang = session()->get('lang_id', 1);

        $content = Content::where([
            ['page_id', $pageData->page_id],
            ['lang', $lang]
        ])->get();

        if ($content->isEmpty() && $lang != 1) {
            $content = Content::where([
                ['page_id', $pageData->page_id],
                ['lang', 1]
            ])->get();
        }

        $data['content'] = self::parseContent($content->toArray());
        $query = Users::where('role_id', 4);

        $approvedVendors = Usermeta::where('meta_key', 'approved')
            ->where('meta_value', '1')
            ->pluck('user_id')
            ->toArray();

        $query->whereIn('id', $approvedVendors);

        if ($request->filled('search')) {
            $searchedIds = Usermeta::where('meta_key', 'store_name')
                ->where('meta_value', 'like', '%' . $request->search . '%')
                ->pluck('user_id')
                ->toArray();

            $query->whereIn('id', $searchedIds);
        }

        $vendors = $query->paginate(12);

        $data['stores'] = [];
        foreach ($vendors as $vendor) {
            $userData = Users::getUserData($vendor->id);

            if (
                empty($userData['metadata']['store_name']) ||
                ($userData['metadata']['approved'] ?? 0) != 1
            ) {
                continue;
            }

            $data['stores'][] = $userData;
        }

        $result = [
            'total' => $vendors->total(),
            'per_page' => $vendors->perPage(),
            'links' => $vendors->linkCollection()->toArray(),
        ];

        if ($request->ajax()) {
            $html = view('web.partials.store_results', compact('data', 'result'))->render();
            return response()->json(['html' => $html]);
        }

        return view('web.stores', [
            'title' => 'Stores',
            'data' => $data,
            'result' => $result
        ]);
    }
}
