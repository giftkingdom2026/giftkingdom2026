<?php

namespace App\Models\Web;

use App\Http\Controllers\Web\AlertController;
use App\Models\Web\Cart;
use App\Models\Web\Currency;
use App\Models\Web\Index;
use App\Models\Web\Products;
use App\Models\Web\Users;
use App\Models\Web\Wallet;
use App\Models\Core\Coupon;
use App\Models\Core\Orderitems;
use App\Models\Core\CartItemAddress;
use App\Models\Core\OrderItemsDelivery;
use App\Models\Web\ShippingHistory;
use Auth;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Lang;
use Session;
use App\Models\Core\OrderHistory;

class Order extends Model
{

    protected $table = 'orders';
    protected $guarded = [];


    public static function createOrder($data)
    {
        $id = Auth::check() ? Auth::user()->id : 0;

        $guest = Auth::check() ? 1 : 0;

        $data['billing'] = $data['address'];

        $email = $data['billing']['email'];

        $sessionID = Session::getId();

        if (!isset($data['ship-to-a-different-address'])) :

            $data['shipping'] = serialize($data['billing']);

        else :

            $data['shipping'] = serialize($data['shipping']);

        endif;

        $data['billing'] = serialize($data['billing']);

        // true to get all cart items for order

        $cart = Cart::getCart(true);

        $credit = $usablecredit = 0;

        $check = isset($data['credit_amount']) && Auth::check();

        if ($check) :

            $credit = $usablecredit = Wallet::getCredit();

            if ($data['payment_method'] == 'Wallet') :

                $usablecredit = $data['credit_amount'];

                $remainingcredit = ($credit - $data['credit_amount']);

            else:
                if (isset($data['credit_amount'])) {
                    $usablecredit = $data['credit_amount'];

                    $remainingcredit = ($credit - $data['credit_amount']);
                }


            // $data['order-total'] -= $credit;

            endif;

        endif;
        $arr = [
            'customer' => $id,
            'session_id' => $sessionID,
            'email' => $email,
            'billing_data' => $data['billing'],
            'shipping_data' => $data['shipping'],
            'payment_method' => $data['payment_method'],
            'order_subtotal' => $data['order-subtotal'],
            'order_total' => $data['order-total'],
            'order_information' => $data['order-notes'],
            'shipping_method' => $data['shipping_method'],
            'shipping_cost' => $data['shipping_cost'],
            'currency' => session('currency_title'),
            'currency_value' => session('currency_value'),
            'guest_checkout' => $guest,
            'ordered_source' => 1,
            'credit_amount' => $usablecredit,
            'delivery_option' => $data['delivery_option'],
            'delivery_date' => $data['delivery-date'],
            'time_slot' => $data['time-slot'],
            'vat' => $data['vat'],
        ];
        $data['shipping_method'] == 'Hyperpay' ? $data['order-total'] = $data['order-total'] - 20 : '';

        isset($data['coupon']) ? $arr['coupon_amount'] = $data['discount'] : '';

        isset($data['coupon']) ? $arr['coupon_code'] = $data['coupon'] : '';

        $order = self::create($arr);

        if (isset($remainingcredit)) :

        // Wallet::addRemainder($remainingcredit, $order->id);

        endif;

        if (isset($data['coupon'])):

            $coupon = Coupon::where('coupon_code', $data['coupon'])->pluck('coupon_ID')->first();

            Coupon::where('coupon_code', $data['coupon'])->increment('usage_count');

            if (Auth::check()):

                DB::table('coupon_usage')->insert([

                    'coupon_ID' => $coupon,

                    'user_ID' => Auth::user()->id,

                    'order_ID' => $order->id,

                ]);

            else:

                DB::table('coupon_usage')->insert([

                    'coupon_ID' => $coupon,

                    'user_ID' => $sessionID,

                    'order_ID' => $order->id,

                ]);

            endif;

        endif;
        foreach ($cart->items as $item) :

            if ($item['in_order'] == 1) :

                $meta = $item['item_meta'] != null ? serialize($item['item_meta']) : null;
                $trade = $item['trade_in'] != null ? serialize($item['trade_in']) : null;
                $product = Products::where('ID', $item['product_ID'])->first();
                $order_item_id = DB::table('order_items')->insertGetId([
                    'order_ID' => $order->id,
                    'product_ID' => $item['product_ID'],
                    'variation_ID' => $item['variable_ID'],
                    'product_quantity' => $item['product_quantity'],
                    'item_price' => $item['product']['prod_price'],
                    'item_sale_price' => $item['product']['sale_price'],
                    'author_id' => $product->author_id,
                    'item_meta' => $meta,
                    'trade_in' => $trade,

                ]);

                    $cartItemAddresses = \App\Models\Core\CartItemAddress::where('cart_item_id', $item['id'])->get();
                    foreach ($cartItemAddresses as $addressItem) {
                        if ($item['product_ID'] == $addressItem['product_id']) {
                            OrderItemsDelivery::create([
                                'order_item_id'   => $order_item_id,
                                'label'           => $addressItem['label'],
                                'name'            => $addressItem['name'],
                                'phone'           => $addressItem['phone'],
                                'address'         => $addressItem['address'],
                                'delivery_date'   => $addressItem['delivery_date'],
                                'delivery_time'   => $addressItem['delivery_time'],
                            ]);
                        }
                    }
                $id = $item['variable_ID'] != 0 ? $item['variable_ID'] : $item['product_ID'];

                Products::detuctQuantity($id, $item['product_quantity']);

            endif;

        endforeach;
        CartItemAddress::query()->delete();
        // $credit = $data['order-total'];

        // if (Auth::check()) :

        //     Wallet::creditOrder('credit', $credit, $order->id);
        //     if (isset($data['credit_amount'])) {
        //         $userWalletCredit = Wallet::getCredit();
        //         $remainingcredit = ($userWalletCredit - $data['credit_amount']);
        //         Wallet::creditOrder('debit', $data['credit_amount'], $order->id);
        //     }
        // endif;
$defaultCurrencyValue = \App\Models\Web\Currency::where('is_default',1)->value('value');
$sessionCurrencyTitle = session('currency_title');
$sessionCurrencyValue = \App\Models\Web\Currency::where('title', $sessionCurrencyTitle)->value('value');
if($sessionCurrencyValue != $defaultCurrencyValue){
    $credit = $data['order-total'] / $sessionCurrencyValue;
} else {
    $credit = $data['order-total'];
}
        if (Auth::check()) {

            if (isset($data['credit_amount']) && $data['credit_amount'] > 0) {
                Wallet::creditOrder('debit', $data['credit_amount'], $order->id);
            }

            if ($credit > 0) {
                Wallet::creditOrder('credit', $credit, $order->id);
            }
        }
        
		        OrderHistory::create([

            'order_id' => $order->id,
            'order_status' => 'In Process',
            'comments' => 'Order Placed',

        ]);
        return $order;
    }

    public static function getOrder($id, $email = null)
    {

        $email == null ? $where = [['ID', $id]] : $where = [['ID', $id], ['email', $email]];

        $order = self::where($where)->first();

        if ($order) :

            if ($email == null) :

                $order->items = DB::table('order_items')->where('order_ID', $id)->get();

                foreach ($order->items as &$item) :

                    $item->product = Products::getProduct($item->product_ID);

                endforeach;

            else :

                $order = $order->toArray();

                $items = Orderitems::where('order_ID', $id)->get();

                $items ? $items = $items->toArray() : '';

                $order['items'] = $items;

                foreach ($order['items'] as &$item) :

                    $item['product'] = Products::getProduct($item['product_ID']);

                endforeach;

            endif;

        endif;

        return $order;
    }


    public static function updateShipment() {}
}
