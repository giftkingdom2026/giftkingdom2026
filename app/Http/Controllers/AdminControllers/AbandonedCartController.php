<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Web\Cart;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use App\Models\Web\Users;
use App\Models\Web\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Mail;
class AbandonedCartController extends Controller
{
    public function __construct(Images $images,Setting $setting)
    {
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Setting = $setting;
       $this->images = $images;
    }
    
    public function list(Request $request){
        
        $cart = Cart::where([['cart_count','!=',0],['customer_id','!=',0]])->whereDate('created_at', '<' ,date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d')))))->paginate(25);

        $cart ? $result = $cart->toArray() : '';

        foreach( $result['data'] as $key => &$cart ) :

            $cart['customer'] = Users::getUserData( $cart['customer_id']);

            if( $cart['customer'] == null ) :

                unset($result['data'][$key]);

            endif;

        endforeach; 

        return view("admin.AbandonedCart.index", ['pageTitle' => 'Abandoned Cart'])->with('result', $result);
    }
    public function getAbandonedCarts(Request $request)
{
    $length = $request->input('length', 10);
    $start = $request->input('start', 0);
    $search = $request->input('search.value');
    $draw = $request->input('draw');

    $query = Cart::where('cart_count', '!=', 0)
        ->where('customer_id', '!=', 0)
        ->whereDate('created_at', '<', now()->subDays(3));

    // Apply search filter

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('customer', function ($q2) use ($search) {
                $q2->where('first_name', 'like', "%{$search}%")
                   ->orWhere('last_name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%")
                   ->orWhere('phone', 'like', "%{$search}%");
            });
        });
    }

    $total = $query->count();

    $carts = $query->offset($start)
        ->limit($length)
        ->orderBy('updated_at', 'desc')
        ->get();

    $data = [];

    foreach ($carts as $cart) {
        $customer = Users::getUserData($cart->customer_id);
        if (!$customer) {
            continue;
        }

        $fullName = $customer['first_name'] . ' ' . $customer['last_name'];
        $email = $customer['email'];
        $phone = $customer['phone'];
        $itemCount = $cart->cart_count;
        $totalPrice = number_format($cart->cart_total, 2);
        $date = \Carbon\Carbon::parse($cart->updated_at)->format('d M, Y');

        $action = '<a title="Email" href="' . asset('admin/abandonedcart/email/' . $email) . '" class="badge bg-light-blue">
                    <i class="fas fa-envelope"></i>
                   </a>';

        $data[] = [
            'cart_ID' => $cart->cart_ID,
            'customer_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'cart_count' => $itemCount,
            'cart_total' => $totalPrice,
            'updated_at' => $date,
            'action' => $action,
        ];
    }

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $data,
    ]);
}

    public function deleteAbandonedCart($id)
    {
        AbandonedCartBasket::where('customers_basket_id', $id)->update(array('is_delete' => '1'));

        return 1;
    }
    

    public function email(Request $request){

        return redirect()->back()->with('success','Email Sent Succesfully!');

    }
}
