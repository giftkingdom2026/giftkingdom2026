<?php



namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Web\Products;

use App\Models\Web\Cartitems;

use App\Models\Web\Index;

use App\Models\Core\Coupon;
use App\Models\Core\CartItemAddress;

use Auth;

use Session;


class Cart extends Model

{

	protected $table = 'cart';

	protected $guarded = [];


	public static function Appadd($data)
	{

		$customer_id = $data['customer_id'];
		$check = self::where('customer_id', $customer_id)->first();
		$product = Products::where('ID', $data['ID'])->first()->toArray();
		$product['prod_image'] = asset(Index::get_image_path($product['prod_image']));
		$price = Products::getPrice($product);
		if ($check) :
			$cart = self::where('session_id', $customer_id)->update([
				'customer_id' => $customer_id,
				'cart_count' => ($check['cart_count'] + $data['qty']),
				'cart_subtotal' => ($check['cart_subtotal'] + ($price * $data['qty'])),
				'cart_total' => ($check['cart_total'] + ($price * $data['qty'])),
			]);
			$cart = $check;
		else :
			$cart = self::create([
				'session_id' => '0',
				'customer_id' => $customer_id,
				'cart_count' => $data['qty'],
				'cart_subtotal' => ($price * $data['qty']),
				'cart_total' => ($price * $data['qty']),
			]);
		endif;
		if (isset($data['variation'])) :
			$var['variation'] = $data['variation'];
			$var['attributes'] = $data['attributes'];
		else :
			$var = [];
		endif;
		Cartitems::add($cart, $product, $data['qty'], $var);
		$cart = self::where('customer_id', $customer_id)->first();
		if ($cart) :
			$cart->items = Cartitems::getItems($cart->cart_ID);
		endif;
		if (!empty($cart)) {
			return $cart;
		}
	}

	public static function getCart($order = false)
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$cart = self::where([$where])->first();

		if ($cart) :

			$cart->items = Cartitems::getItems($cart->cart_ID, $order);

		endif;

		return $cart;
	}

	public static function getCount()
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$cart = self::where([$where])->pluck('cart_count')->first();

		return $cart;
	}
	public static function add($data)
	{
		$sessionID = Session::getId();

		$data['serial'] = isset($data['serial']) ? $data['serial'] : '';

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$check = self::where([$where])->first();

		$id = (isset($data['variation']) && $data['variation'] != 0) ? $data['variation'] : $data['ID'];
		$product = Products::where('ID', $id)->first()->toArray();

		isset($data['devices']) ? $product['devices'] = serialize($data['devices']) : '';

		if ($product['prod_type'] == 'variable' && !isset($data['variation'])) :

			$variation = Products::where('prod_parent', $data['ID'])->first();

			$variation ? $variation = $variation->toArray() : '';

			if (empty($variation)) :

				return;

			else :

				$product = $variation;

			endif;

		endif;

		$product['prod_image'] = asset(Index::get_image_path($product['prod_image']));

		$price = Products::getPrice($product);
		$userid = Auth::check() ? Auth::user()->id : 0;

		if ($check) :

			$count = Cartitems::where([['cart_ID', $check->cart_ID], ['product_ID', $product['ID']]])->first();

			$count = isset($count->product_quantity) ? $count->product_quantity : 0;

			if ($product['prod_quantity'] >= ($count + $data['qty'])) :

				self::where([$where])->update([
					'customer_id' => $userid,
					'cart_count' => ($check['cart_count'] + $data['qty']),
					'cart_subtotal' => ($check['cart_subtotal'] + ($price * $data['qty'])),
					'order_subtotal' => ($check['order_subtotal'] + ($product['prod_price'] * $data['qty'])),
					'cart_total' => ($check['cart_total'] + ($price * $data['qty'])),
					'order_total' => ($check['order_total'] + ($price * $data['qty'])),
				]);

			endif;

			$cart = $check;

		else :

			$cart = self::create([
				'session_id' => $sessionID,
				'customer_id' => $userid,
				'cart_count' => $data['qty'],
				'cart_subtotal' => ($price * $data['qty']),
				'cart_total' => ($price * $data['qty']),
				'order_subtotal' => ($price * $data['qty']),
				'order_total' => ($price * $data['qty']),
			]);

		endif;

		if (isset($data['variation']) && $data['variation'] != 0) :

			$var['variation'] = $data['variation'];

			$var['attributes'] = $data['attributes'];

		else :

			$var = [];

		endif;

		$return = ['product' => $product, 'qty' => $data['qty']];

		$count = Cartitems::where([['cart_ID', $cart->cart_ID], ['product_ID', $product['ID']]])->first();

		$count = isset($count->product_quantity) ? $count->product_quantity : 0;

		if (($product['prod_quantity'] >= ($count + $data['qty']))) :
			$cart_item = Cartitems::add($cart, $product, $data['qty'], $var, $data['serial']);

			if (is_object($cart_item)) {
				$cart_item->product = $product;
			} elseif (is_array($cart_item)) {
				$cart_item['product'] = $product;
			}

			$return['added'] = true;
			$return['cart_item'] = $cart_item;
			$return['cart_item']['addresses'] = CartItemAddress::where('cart_item_id', $cart_item->id)->get();


		else :

			$return['added'] = false;

		endif;
		return $return;
	}

	public static function mergeItems($sessionID)
	{

		$where = ['session_id', $sessionID];

		$where2 = ['customer_id', Auth()->user()->id];

		$cartprev = self::where([$where])->first();

		$cartnew = self::where([$where2])->first();

		if ($cartprev) :

			Cartitems::where('cart_ID', $cartprev->cart_ID)->update(['cart_ID' => $cartnew->cart_ID]);

			$items = Cartitems::where('cart_ID', $cartnew->cart_ID)->get();

			$items ? $items = $items->toArray() : '';

			foreach ($items as $item) :

				isset($count[$item['product_ID'] . '-' . $item['variable_ID']]) ?  $count[$item['product_ID'] . '-' . $item['variable_ID']]['count']++ : $count[$item['product_ID'] . '-' . $item['variable_ID']]['count'] = 1;

				$count[$item['product_ID'] . '-' . $item['variable_ID']]['item'] = $item['id'];

			endforeach;

			foreach ($count as $em) :

				if ($em['count'] > 1) :

					Cartitems::where('id', $em['item'])->delete();

				endif;

			endforeach;

		endif;
	}

	public static function cleanAfterOrder()
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$check = self::where([$where])->first();

		$response[] = Cartitems::where([

			['cart_ID', $check->cart_ID],
			['in_order', 1]

		])->delete();

		$response[] = !empty($cart->cart_coupon);

		if (!empty($cart->cart_coupon)) :

			$coupon = Coupon::where('coupon_code', $cart->cart_coupon)->pluck('usage_count')->first();

			$response[] = Coupon::where('coupon_code', $cart->cart_coupon)->update(['usage_count' => ($coupon + 1)]);

		endif;

		$response[] = self::where([$where])->update(['cart_coupon' => null, 'use_credit' => 0, 'credit_points' => 0, 'order_total' => 0]);

		$response[] = self::updateCart();
	}

	public static function updateCart()
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$cart = self::where([$where])->first();

		if ($cart) :

			$cart->items = Cartitems::getItems($cart->cart_ID);

			$subtotal = $total = $ordertotal = $ordersubtotal = $itemstotal = 0;
			$count = 0;

			foreach ($cart->items as $item) :

				$quantity = $item['product_quantity'];

				$regular_price = $item['product']['prod_price'];
				$sale_price = $item['product']['sale_price'];

				$has_sale = $sale_price != 0 && $sale_price != null && $sale_price != $regular_price;
				$final_price = $has_sale ? $sale_price : $regular_price;

				$itemstotal += $item['product']['prod_price'] * $quantity;

				$subtotal += $final_price * $quantity;
				$total += $final_price * $quantity;

				$count += $quantity;

				if ($item['in_order'] == 1) {
					$ordersubtotal += $final_price * $quantity;
					$ordertotal += $final_price * $quantity;
				}

			endforeach;
			self::where([$where])->update(['cart_itemstotal' => $itemstotal]);

			// dd($total);

			if ($cart->cart_coupon != '') :

				$coupon = Coupon::where('coupon_code', $cart->cart_coupon)->first();

				if ($coupon) :

					if ($coupon->discount_type == 'fixed_cart') :

						$discount = round(min($coupon->discount_amount, $total), 2);
						$total = round(max(0, $total - $discount), 2);
						$ordertotal = round(max(0, $ordertotal - $discount), 2);



					elseif ($coupon->discount_type == 'percent') :
						$discount = ($coupon->discount_amount / 100) * $subtotal;
						$orderdiscount = ($coupon->discount_amount / 100) * $ordersubtotal;

						$total = max(0, $total - $discount);
						$ordertotal = max(0, $ordertotal - $orderdiscount);


					elseif ($coupon->discount_type == 'product'):

						$cart_products = collect($cart->items)
							->pluck('product_ID')
							->unique()
							->values()
							->all();

						$coupon_products = $coupon->product_ids ?? [];

						if (is_string($coupon_products)) {
							$decoded = json_decode($coupon_products, true);
							$coupon_products = json_last_error() === JSON_ERROR_NONE ? $decoded : explode(',', $coupon_products);
						}

						$coupon_products = array_map('intval', $coupon_products);


						$common_products = array_intersect($coupon_products, $cart_products);

						$discount = 0;
						$orderdiscount = 0;

						foreach ($cart->items as $item) {
							if (in_array($item['product_ID'], $common_products, true)) {
								$lineDiscount = $coupon->discount_amount * $item['product_quantity'];
								$discount += $lineDiscount;
								if ($item['in_order'] == 1) {
									$orderdiscount += $lineDiscount;
								}
							}
						}

						$total      = $subtotal      - $discount;
						$ordertotal = $ordersubtotal - $orderdiscount;

					elseif ($coupon->discount_type == 'product_percent'):

						$cart_products = collect($cart->items)
							->pluck('product_ID')
							->unique()
							->values()
							->all();

						$coupon_products = $coupon->product_ids ?? [];

						if (is_string($coupon_products)) {
							$decoded = json_decode($coupon_products, true);
							$coupon_products = json_last_error() === JSON_ERROR_NONE ? $decoded : explode(',', $coupon_products);
						}

						$coupon_products = array_map('intval', $coupon_products);

						$common_products = array_intersect($coupon_products, $cart_products);

						$discount = 0;
						$orderdiscount = 0;

						foreach ($cart->items as $item) {
							if (in_array($item['product_ID'], $common_products, true)) {
								$lineDiscount = ($coupon->discount_amount / 100) * $item['product']['price'] * $item['product_quantity'];
								$discount += $lineDiscount;
								if ($item['in_order'] == 1) {
									$orderdiscount += $lineDiscount;
								}
							}
						}

						$total      = $subtotal      - $discount;
						$ordertotal = $ordersubtotal - $orderdiscount;

					endif;

					self::where([$where])->update(['cart_discount' => $discount]);

				else :

					self::where([$where])->update(['cart_coupon' => '', 'cart_discount' => '']);

				endif;

			endif;
			$vat = round($total * 0.05, 2);
			
			$total = round($total + $vat, 2);
			$ordertotal = round($ordertotal + $vat, 2);



			if ($cart->use_credit == 1) :

				if ($cart->credit_points >= $total) :

					$total = $ordertotal = 0;

				else :

					$total -= $cart->credit_points;

				endif;

			endif;

			$update = [

				'cart_count' => $count,

				'cart_subtotal' => $subtotal,

				'cart_total' => $total,

				'order_subtotal' => $ordersubtotal,

				'order_total' => $ordertotal,

				'cart_tax' => $vat,

			];

			self::where([$where])->update($update);

		endif;
	}



	public static function addItemsToOrder($data)
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$cart = self::where([$where])->first();

		Cartitems::where('cart_ID', $cart->cart_ID)->update(['in_order' => 0]);

		foreach ($data['order'] as $item) :

			Cartitems::where('id', $item)->update(['in_order' => 1]);

		endforeach;
	}

	public static function removeItem($id)
	{

		$sessionID = Session::getId();

		$where = Auth::check() ? ['customer_id', Auth()->user()->id] : ['session_id', $sessionID];

		$cart = self::where([$where])->first();

		Cartitems::where([

			['cart_ID', $cart->cart_ID],
			['product_ID', $id]

		])->delete();
	}


	public static function isEmpty()
	{

		$cart = self::getCart();

		$return = empty($cart->items) ? true : false;

		return $return;
	}
	public static function checkIfExists($productID, $serial = null)
	{
		$cart = self::getCart();
		foreach ($cart['items'] ?? [] as $item) {
			if ($item['product_ID'] == $productID) {
				return true;
			}
		}

		return false;
	}
}
