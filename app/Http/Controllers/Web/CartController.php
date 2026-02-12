<?php

namespace App\Http\Controllers\Web;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\IndexController;
use App\Models\Web\Index;
use App\Models\Core\Images;
use App\Models\Web\Products;
use App\Models\Web\Cart;
use App\Models\Core\Coupon;
use App\Models\Core\CartItemAddress;
use App\Models\Core\Pages;
use App\Models\Web\Content;
use App\Models\Web\Wallet;
use App\Models\Web\Cartitems;
use App\Models\Web\Usermeta;
use Session;
use Auth;
use DB;

class CartController extends Controller
{


	public function view(Request $request)
	{

$page = Pages::where('slug', 'cart')->first();
$lang = session()->get('lang_id', 1);

// Try to get content for the selected language
$content = Content::where('page_id', $page->page_id)
                  ->where('lang', $lang)
                  ->get();

// Fallback to default language if none found and not already default
if ($content->isEmpty() && $lang != 1) {
    $content = Content::where('page_id', $page->page_id)
                      ->where('lang', 1)
                      ->get();
}

$content = $content->toArray(); // Always safe now


		Cart::updateCart();

		$cart = Cart::getCart();

		if ($cart && $cart->cart_coupon != "") {

			$get_coupon = Coupon::where('coupon_code', $cart->cart_coupon)->first();

			if ($get_coupon) {

				if ((int)$get_coupon->minimum_amount > (int)$cart->cart_subtotal) {

					$this->clearCartCoupon();
				}
			}
		}

		if ($cart) :

			$inorder = Cartitems::where([['cart_ID', $cart->cart_ID], ['in_order', 1]])->count();

		else :

			$inorder = 0;

		endif;

		$title = ['title' => 'Cart'];

		$cart['content'] = IndexController::parseContent($content);

		$related = Products::getRandom();
		// dd($cart);
		return view("web.cart.index", $title)->with('data', $cart)->with('inorder', $inorder)->with('related', $related);
	}


	public function add(Request $request)
	{

		$data = Cart::add($request->all());

		$arr['message'] = $data['added'] ?

			$data['product']['prod_title'] . ' (' . $data['qty'] . ') has been added to cart!' :

			$data['product']['prod_title'] . ' is already in cart!';

		$arr['img'] =  $data['product']['prod_image'];
		$arr['cart_item'] = $data['cart_item'];
		return json_encode($arr);
	}

	public function emptyCart(Request $request)
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$cart = Cart::where([$where])->first();

		Cartitems::where([['cart_ID', $cart->cart_ID]])->delete();
	}

	public function updateCart(Request $request)
	{

		Cart::updateCart();

		$cart = Cart::getCart();
		$loop = view("web.cart.loop")->with('data', $cart)->render();
		$summary = view("web.cart.summary")->with('data', $cart)->render();

		return json_encode(['loop' => $loop, 'summary' => $summary]);
	}

	public function cartCount(Request $request)
	{

		$cart = Cart::getCart();

		$cart ? $count = $cart->cart_count : $count = 0;

		return $count;
	}

	public function applyCoupon(Request $request)
	{

		$check = Coupon::where('coupon_code', $request->code)->where('status', '1')->first();

		if ($check) :

			if (Auth::check()):

				$usage = DB::table('coupon_usage')->where([['coupon_ID', $check->coupon_ID], ['user_ID', Auth()->user()->id]])->count();

				// if ($usage == 0) :

				$total = Cart::where('customer_id', Auth()->user()->id)->pluck('cart_subtotal')->first();

				if ($total < $check->minimum_amount) :

					return 'Cart amount must be higher than ' . $check->minimum_amount;

				endif;

				if (str_contains($check->discount_type, 'product')) {

					$cart_products = collect(Cart::getCart()['items'])
						->pluck('product_ID')
						->unique()
						->values()
						->all();

					$coupon_products = $check->product_ids ?? [];

					if (is_string($coupon_products)) {
						$decoded = json_decode($coupon_products, true);
						$coupon_products = json_last_error() === JSON_ERROR_NONE
							? $decoded
							: explode(',', $coupon_products);
					}

					$coupon_products = array_map('intval', $coupon_products);

					$common_products = array_intersect($coupon_products, $cart_products);

					if (count($common_products) === 0) {
						return 'None of the products in the cart have discount';
					}
				}


				$check2 = Coupon::apply($request->code);

				if ($check2) :

					return 'Coupon Applied';

				else :

					return 'Coupon Expired!';

				endif;

			// else :

			// 	return 'Coupon already redeemed!';

			// endif;

			else:

				$sessionID = Session::getId();

				$total = Cart::where('session_id', $sessionID)->pluck('cart_subtotal')->first();

				if ($total < $check->minimum_amount) :

					return 'Cart amount must be higher than ' . $check->minimum_amount;

				endif;


				$check2 = Coupon::apply($request->code);

				if ($check2) :

					return 'Coupon Applied';

				else :

					return 'Coupon Expired!';

				endif;



			endif;

		else :

			return 'Invalid Coupon';

		endif;
	}

	public function storeCredit(Request $request)
	{

		$cart = Cart::getCart();

		$credit = \App\Models\Web\CashbackCredit::getAvailableNew();
$data['shipping'] = (int) round($request->shipping / session('currency_value'));
$total = $cart->cart_total;
$cartTotal = $total + $data['shipping'];	
if ($credit > $cartTotal):
			$credit = $cartTotal;
		endif;
		Cart::where('customer_id', Auth::user()->id)->update(['use_credit' => 1, 'credit_points' => $credit]);
		$updatedCart = Cart::getCart();
		
		$data['cart'] = $updatedCart;
        return view("web.checkout-summary")->with('data', $data)->with('credit', $credit)->render();

	}



	public static function quantityUpdate(Request $request)
	{
		// \App\Models\Core\CartItemAddress::where('cart_item_id', $request->item)->where('label', '!=',$request->qty)->delete();

		Cartitems::updateQty($request->item, $request->qty);
	}

	public function deleteItem(Request $request)
	{
		$cartItem = Cartitems::find($request->id);

		if (!$cartItem) {
			return back()->with('error', 'Cart item not found.');
		}

		if (Auth::check()) {
			Cart::where('cart_ID', $cartItem->cart_ID)
				->where('customer_id', Auth::user()->id)
				->update(['use_credit' => 0, 'credit_points' => 0.00]);
		}

		// Delete associated delivery addresses first
		\App\Models\Core\CartItemAddress::where('cart_item_id', $cartItem->id)
			->where('product_ID', $cartItem->product_ID)
			->delete();

		// Now delete the cart item itself
		$cartItem->delete();

		Cart::updateCart();
		$cart = Cart::getCart();

		// (Your coupon logic stays here if needed)

		return back()->with('success', 'Item Deleted Successfully!');
	}

	public function checkout(Request $request)
	{

		Cart::addItemsToOrder($request->all());

		return redirect('checkout');
	}

	public function moveToOrder(Request $request)
	{

		Cartitems::where([['id', $request->id]])->update(['in_order' => $request->in_order]);
	}

	public function removeCoupon(Request $request)
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		Cart::where([$where])->update(['cart_coupon' => '', 'cart_discount' => '']);

		return redirect()->back();
	}

	private function clearCartCoupon()
	{
		$sessionID = Session::getId();
		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];
		Cart::where([$where])->update(['cart_coupon' => '', 'cart_discount' => '']);
	}

	public function saveCartItemAddresses(Request $request)
	{
		$deliveries = $request->input('deliveries', []);
		if (empty($deliveries)) {
			return response()->json(['status' => 'error', 'message' => 'No delivery data received.']);
		}
		try {
			foreach ($deliveries as $delivery) {
				$existing = CartItemAddress::where('cart_item_id', $delivery['cart_item_id'] ?? null)
					->where('product_id', $delivery['product_id'] ?? null)
					->where('label', $delivery['label'] ?? null)
					->first();

				if ($existing) {
					// Update everything EXCEPT the label
					$existing->update([
						'select_type'   => $delivery['select_type'] ?? null,
						'name'          => $delivery['name'] ?? '',
						'phone'         => $delivery['phone'] ?? '',
						'address'       => $delivery['address'] ?? '',
						'delivery_date' => $delivery['delivery_date'] ?? null,
						'delivery_time' => $delivery['time_slot'] ?? null,
					]);
				} else {
					// Create new row with label
					CartItemAddress::create([
						'select_type'   => $delivery['select_type'] ?? null,
						'cart_item_id'  => $delivery['cart_item_id'] ?? null,
						'product_id'    => $delivery['product_id'] ?? null,
						'name'          => $delivery['name'] ?? '',
						'phone'         => $delivery['phone'] ?? '',
						'address'       => $delivery['address'] ?? '',
						'delivery_date' => $delivery['delivery_date'] ?? null,
						'delivery_time' => $delivery['time_slot'] ?? null,
						'label'         => $delivery['label'] ?? null, // only on create
					]);
				}
			}

			return response()->json([
				'status'  => 'success',
				'message' => 'Addresses saved successfully.'
			]);
		} catch (\Throwable $th) {
			\Log::error('Delivery address saving failed', [
				'error' => $th->getMessage(),
				'trace' => $th->getTraceAsString(),
			]);

			return response()->json([
				'status'  => 'error',
				'message' => 'An error occurred while saving addresses.'
			], 500);
		}
	}
}
