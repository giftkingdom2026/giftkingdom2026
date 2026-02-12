<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Core\Order;
use App\Models\Core\Orderitems;
use App\Models\Core\OrderItemsDelivery;
use App\Models\Core\Attributes;
use App\Models\Core\Values;
use App\Models\Core\Posts;
use App\Models\Core\Coupon;
use App\Models\Core\Wallet;
use App\Models\Core\Products;
use App\Models\Web\Users;
use App\Models\Core\OrderHistory;
use App\Http\Controllers\AdminControllers\PostsController;
use App\Models\Core\Postmeta;
use Auth;

class OrdersController extends Controller
{
	//
	public function getOrdersAjax(Request $request)
	{
		$perPage = $request->input('length', 10);
		$start = $request->input('start', 0);
		$draw = $request->input('draw');
		$search = $request->input('search.value');
    $settings = \App\Models\Core\Setting::getWebSettings();

		if (!in_array(Auth::user()->role_id, [1, 2])) {
			$authorOrderIDs = Orderitems::where('author_id', Auth()->user()->id)->pluck('order_ID')->toArray();

			$query = Order::whereIn('ID', $authorOrderIDs);
		} else {
			$query = Order::query();
		}

		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('ID', 'like', "%{$search}%")
					->orWhere('email', 'like', "%{$search}%")
					->orWhere('order_status', 'like', "%{$search}%")
					->orWhere('currency', 'like', "%{$search}%")
					->orWhere('ordered_source', 'like', "%{$search}%")
					->orWhereRaw("DATE_FORMAT(created_at, '%d %b, %Y') LIKE ?", ["%{$search}%"]);
			});
		}


		$totalRecords = $query->count();

		$orders = $query
			->orderBy('created_at', 'desc')
			->offset($start)
			->limit($perPage)
			->get();

		$data = [];

		foreach ($orders as $index => $order) {
    $orderTotal = 0;
    $subtotal = 0;
    $productsDiscount = 0;

    if (!in_array(Auth::user()->role_id, [1, 2])) {
        $items = Orderitems::where([
            ['author_id', Auth()->user()->id],
            ['order_ID', $order->ID]
        ])->get();

        foreach ($items as $item) {
            $cond = $item->item_sale_price != 0 && $item->item_sale_price != null;
            $price = $cond ? $item->item_sale_price * $order->currency_value * $item->product_quantity : $item->item_price * $order->currency_value * $item->product_quantity;

            $defprice = $cond ? $item->item_price * $order->currency_value * $item->product_quantity : false;
            $subtotal += $defprice ? $defprice : $price;
            $productsDiscount += $defprice ? $defprice - $price : 0;
        }

        $subtotal -= $productsDiscount;

        $vat = $subtotal * 0.05;
        $orderTotal = $subtotal + $vat;

        if (isset($settings['admin_commission'])) {
            $commission = ($settings['admin_commission'] / 100) * $subtotal;
            $orderTotal -= $commission;
        }

    } else { 
        $orderTotal = $order->order_total;
    }

    $data[] = [
        'id' => $order->ID,
        'email' => $order->email,
        'created_at' => $order->created_at->format('d M, Y'),
        'order_status' => $order->order_status,
        'order_total' => $order->currency . ' ' . number_format($orderTotal, 2),
        'origin' => $order->ordered_source == 1 ? 'Website' : 'App',
        'action' => '
            <a title="Edit" href="' . asset('admin/orders/edit/' . $order->ID) . '" class="badge bg-light-blue">
            <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <a href="javascript:delete_popup(\'' . asset('admin/orders/delete') . '\',' . $order->ID . ');" 
            class="badge delete-popup bg-red">
            <i class="fa fa-trash" aria-hidden="true"></i>
            </a>'
    ];
}


		return response()->json([
			'draw' => intval($draw),
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $totalRecords,
			'data' => $data
		]);
	}
	public function __construct(Setting $setting, Order $order)
	{
		$this->myVarsetting = new SiteSettingController($setting);
		$this->Setting = $setting;
		$this->Order = $order;
	}

	//add listingOrders
	public function display()
	{

		$orders = Order::paginator();

		return view("admin.orders.index", ['pageTitle' => 'Orders'])->with('orders', $orders);
	}

public function add(Request $request)
{
    $order['customers'] = Users::where('role_id', 3)->get();

    $order['products'] = Products::where([
        ['prod_type', '!=', 'variation'],
        ['prod_status', 'active'],
    ])->get();

    $order['coupons'] = Coupon::whereDate('expiry_date', '>', now())
        ->where(function ($query) {
            $query->whereNull('usage_limit')
                  ->orWhereRaw('(
                      SELECT COUNT(*) 
                      FROM coupon_usage 
                      WHERE coupon_usage.coupon_ID = coupons.coupon_ID
                  ) < usage_limit');
        })
        ->get();

    return view("admin.orders.add", ['pageTitle' => 'Add Order'])->with('order', $order);
}


	public function insert(Request $request)
	{
		$data = $request->all();
		date_default_timezone_set('Asia/Dubai');

		$requiredFields = [
			'customer',
			'billing.email',
			'product',
			'quantity',
			'order_information',
		];

		foreach ($requiredFields as $field) {
			if (!$request->filled($field)) {
				return redirect()->back()->with('error', ucfirst(str_replace('.', ' ', $field)) . ' is required.');
			}
		}

		if (empty($data['product']) || !is_array($data['product'])) {
			return redirect()->back()->with('error', 'Products are required.');
		}

		if (empty($data['quantity']) || !is_array($data['quantity'])) {
			return redirect()->back()->with('error', 'Quantity is required.');
		}
		$i = 0;

		foreach ($data['product'] as $key => &$prodId) {
			$product = Products::getProduct($prodId);

			if ($product['prod_type'] == 'variable') {
				$variationId = $data['variation'][$i] ?? 0;
				$product['variation'] = Products::getProduct($variationId);
				$i++;
			}

			$prodId = $product;
		}


		$billing = serialize($data['billing']);
		$data['shipping'] = array_filter($data['billing']);
		$shipping = !empty($data['shipping']) ? serialize($data['shipping']) : $billing;

		$ordersubtotal = $ordertotal = $count = 0;

		foreach ($data['product'] as $key => $prod) {
			if ($prod['prod_type'] == 'variable') {
				$price = $prod['variation']['price'];
				$defprice = ($prod['variation']['sale_price'] !== null && $prod['variation']['sale_price'] != 0)
					? $prod['variation']['sale_price']
					: $prod['variation']['prod_price'];
			} else {
				$price = $prod['price'];
				$defprice = ($prod['sale_price'] != 0 && $prod['sale_price'] !== null)
					? $prod['sale_price']
					: $prod['prod_price'];
			}

			$quantity = $data['quantity'][$key];
			$count += $quantity;
			$ordersubtotal += $defprice * $quantity;
			$ordertotal += $price * $quantity;
		}

		if (!empty($data['coupon_code'])) {
			$coupon = Coupon::where('coupon_code', $data['coupon_code'])->first();

			if ($coupon) {
				$orderdiscount = 0;

				if (in_array($coupon->discount_type, ['product', 'product_percent'])) {
					$coupon_products = $coupon->product_ids ?? [];

					if (is_string($coupon_products)) {
						$decoded = json_decode($coupon_products, true);
						if (json_last_error() === JSON_ERROR_NONE) {
							$coupon_products = $decoded;
						} else {
							$coupon_products = explode(',', $coupon_products);
						}
					}

					$coupon_products = array_map('intval', (array)$coupon_products);

					foreach ($data['product'] as $key => $prod) {
						$productIdToCheck = isset($prod['variation']) ? $prod['variation']['ID'] : $prod['ID'];

						if (in_array($productIdToCheck, $coupon_products)) {
							$quantity = $data['quantity'][$key] ?? 0;

							if ($prod['prod_type'] == 'variable') {
								$defprice = ($prod['variation']['sale_price'] != 0 && $prod['variation']['sale_price'] !== null)
									? $prod['variation']['sale_price']
									: $prod['variation']['prod_price'];
							} else {
								$defprice = ($prod['sale_price'] != 0 && $prod['sale_price'] !== null)
									? $prod['sale_price']
									: $prod['prod_price'];
							}

							if ($coupon->discount_type === 'product') {
								$orderdiscount += $coupon->discount_amount * $quantity;
							} elseif ($coupon->discount_type === 'product_percent') {
								$orderdiscount += ($coupon->discount_amount / 100) * ($defprice * $quantity);
							}
						}
					}
				} elseif ($coupon->discount_type === 'fixed_cart') {
					$orderdiscount = $coupon->discount_amount;
				} elseif ($coupon->discount_type === 'percent') {
					$orderdiscount = ($coupon->discount_amount / 100) * $ordersubtotal;
				}

				$ordertotal = max(0, $ordertotal - $orderdiscount);
			}
		}


$vat = round($ordertotal * 0.05, 2);
$ordertotal += $vat;


		if (!empty($data['shipping_cost']) && is_numeric($data['shipping_cost'])) {
			$ordertotal += (float)$data['shipping_cost'];
		}

		$currencyValue = \App\Models\Core\Currency::where('title', 'AED')->first();
		// Create order
		$orderData = [
			'customer' => $data['customer'],
			'email' => $data['billing']['email'],
			'billing_data' => $billing,
			'shipping_data' => $shipping,
			'payment_method' => 'Cash on Delivery',
			'order_subtotal' => $ordersubtotal,
			'order_total' => $ordertotal,
			'order_information' => $data['order_information'],
			'shipping_method' => 'Free Shipping',
			'shipping_cost' => $data['shipping_cost'] ?? 0,
			'currency' => 'AED',
			'currency_value' => $currencyValue->value ?? 1,
			'guest_checkout' => 0,
			'delivery_option' => $data['delivery_option'] ?? '',
			'delivery_date' => $data['delivery_date'] ?? '',
			'time_slot' => $data['time_slot'] ?? '',
			'ordered_source' => 1,
			'order_status' => $data['order_status'],
			'vat' => $vat,
		];

		if (isset($orderdiscount)) {
			$orderData['coupon_code'] = $data['coupon_code'];
			$orderData['coupon_amount'] = $orderdiscount;
		}


		$order = Order::create($orderData);
        if (isset($data['coupon_code'])):

            $coupon = Coupon::where('coupon_code', $data['coupon_code'])->pluck('coupon_ID')->first();

            Coupon::where('coupon_code', $data['coupon_code'])->increment('usage_count');

                DB::table('coupon_usage')->insert([

                    'coupon_ID' => $coupon,

                    'user_ID' => $data['customer'],

                    'order_ID' => $order->id,

                ]);

        endif;
		// Create order items
		foreach ($data['product'] as $key => $item) {
			$variationId = $item['variation']['ID'] ?? 0;

			$orderitem = [
				'order_ID' => $order->id,
				'product_ID' => $item['ID'],
				'variation_ID' => $variationId,
				'product_quantity' => $data['quantity'][$key],
				'author_id' => $item['author_id'],
			];

			if ($item['prod_type'] === 'variable') {
				if ($item['variation']['sale_price'] != 0 && $item['variation']['sale_price'] !== null) {
					$orderitem['item_price'] = $item['variation']['prod_price'];
					$orderitem['item_sale_price'] = $item['variation']['sale_price'];
				} else {
					$orderitem['item_price'] = $item['variation']['price'];
					$orderitem['item_sale_price'] = 0;
				}
			} else {
				if ($item['sale_price'] != 0 && $item['sale_price'] !== null) {
					$orderitem['item_price'] = $item['prod_price'];
					$orderitem['item_sale_price'] = $item['price'];
				} else {
					$orderitem['item_price'] = $item['price'];
					$orderitem['item_sale_price'] = 0;
				}
			}

			$itemMeta = $variationId ? Products::getVariationData($variationId) : [];
			if (!empty($itemMeta)) {
				$orderitem['item_meta'] = serialize($itemMeta);
			}

			DB::table('order_items')->insert($orderitem);

			$deductId = $variationId ?: $item['ID'];
			Products::deductQuantity($deductId, $data['quantity'][$key]);
		}

		return redirect(asset('admin/orders/edit/' . $order->id))->with('success', 'Order Created Successfully!');
	}



	public function edit(Request $request)
	{

		$order = Order::where('ID', $request->id)->first()->toArray();

		$order['customers'] = Users::where('role_id', 3)->get();

		$order['customer'] = Users::getUserData($order['customer']);
		$order['refund'] = OrderHistory::where('order_id', $request->id)
			->whereIn('order_status', ['Refunded', 'Refund Requested'])
			->latest()
			->value('comments');

		$order['cancel'] = OrderHistory::where('order_id', $request->id)
			->whereIn('order_status', ['Cancelled', 'Cancel Requested'])
			->latest()
			->value('comments');
			                                    if(!in_array(Auth::user()->role_id, [1, 2])){
		$items = Orderitems::where([['order_ID', $request->id], ['author_id', Auth()->user()->id]])->get();
												}else{
		$items = Orderitems::where([['order_ID', $request->id]])->get();
												}

		$items ? $items = $items->toArray() : '';

		$order['items'] = $items;

		foreach ($order['items'] as &$item) :

			$item['product_ID'] = Products::getProduct($item['product_ID']);
			$deliveryItems = OrderItemsDelivery::where('order_item_id', $item['ID'])->get();
			$item['delivery_items'] = $deliveryItems ? $deliveryItems->toArray() : [];
			if ($item['item_meta'] != '') :

				$item['item_meta'] = unserialize($item['item_meta']);

				if ($order) :

					$item['item_meta'] = array_filter($item['item_meta']);

					foreach ($item['item_meta'] as $key => &$meta) :

						$arr = [];

						$attr = Attributes::where('attribute_slug', $key)->first();

						$attr ? $attr = $attr->toArray() : '';

						$arr['attribute'] = $attr;

						if ($key != 'personal-message') :

							$value = Values::where([

								['value_ID', $meta],

								['attribute_ID', $arr['attribute']['attribute_ID']],

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

		endforeach;
		$reasons = Posts::where('post_type', 'reasons')->where('post_status', 'publish')->get();
		$reasons ? $reasons = $reasons->toArray() : '';

		$lang = session()->has('lang_id') ? session('lang_id') : 1;

		$reasons = Postmeta::getMetaData($reasons, $lang);

		$reasons = PostsController::parsePostContent($reasons);
		return view("admin.orders.edit", ['pageTitle' => 'Edit Order'])->with('order', $order)->with('reasons', $reasons);
	}

	public function returnToWallet(Request $request)
	{

		$order = Order::where('ID', $request->ID)->first();

		Users::updateMeta('store_credit', $order->order_total, $order->customer);

		Order::where('ID', $request->ID)->update(['order_status' => 'Refunded to Wallet']);

		Wallet::create([

			'user_id' => $request->user_id,
			'transaction_type' => 'debit',
			'transaction_points' => $order->order_total,
			'transaction_status' => 'Refund',
			'transaction_comment' => $request->transaction_comment,
			'transaction_madeby' => Auth()->user()->id

		]);

		return redirect()->back()->with('success', 'Order Amount Refunded to Wallet!');
	}

	public function update(Request $request)
	{
		$data = $request->all();

		$data = array_filter($data);

		unset($data['_token']);

		$data['billing_data'] = serialize($data['billing']);
		unset($data['billing']);

		if ($data['order_status'] === 'Delivered') {
			Wallet::where('user_id', $data['customer'])
				->where('transaction_order', $data['ID'])
				->where('transaction_type', 'credit')
				->update([
					'transaction_status' => 'completed',
				]);

			Wallet::where('user_id', $data['customer'])
				->where('transaction_order', $data['ID'])
				->where('transaction_type', 'debit')
				->update([
					'transaction_status' => 'completed',
				]);

			\App\Models\Web\CashbackCredit::where('user_id', $data['customer'])
				->where('order_id', $data['ID'])
				->update(['confirmed' => 1]);
		} else if ($data['order_status'] === 'In Process') {
			Wallet::where('user_id', $data['customer'])
				->where('transaction_order', $data['ID'])
				->where('transaction_type', 'credit')
				->update([
					'transaction_status' => 'pending_payment',
				]);

			Wallet::where('user_id', $data['customer'])
				->where('transaction_order', $data['ID'])
				->where('transaction_type', 'debit')
				->update([
					'transaction_status' => 'pending_payment',
				]);

			\App\Models\Web\CashbackCredit::where('user_id', $data['customer'])
				->where('order_id', $data['ID'])
				->update(['confirmed' => 0]);
		}



		// $data['shipping_data'] = serialize($data['shipping']); unset($data['shipping']);
		$order = Order::where('ID', $data['ID'])->first();
		$data['created_at'] = $order->created_at;
		if ($data['order_status'] == 'Refunded' || $data['order_status'] == 'Cancelled' || $data['order_status'] == 'Refund Requested' || $data['order_status'] == 'Cancel Requested') {
			OrderHistory::create([
				'order_id' => $data['ID'],
				'order_status' => $data['order_status'],
				'comments' => !empty($data['reason']) ? $data['reason'] : 'No Reason',
			]);
		} else {

			OrderHistory::create([

				'order_id' => $data['ID'],
				'order_status' => $data['order_status'],
				'comments' => 'Order Status Changed To' . ' ' . $data['order_status'],

			]);
		}
		unset($data['reason']);
		Order::where('ID', $data['ID'])->update($data);

		return redirect()->back()->with('success', 'Order Updated Successfully!');
	}

	public function print(Request $request)
	{

		$order = Order::where('ID', $request->id)->first()->toArray();

		$order['customers'] = Users::where('role_id', 3)->get();

		$order['customer'] = Users::getUserData($order['customer']);

		$order['items'] =  Orderitems::where([['order_ID', $request->id], ['author_id', Auth()->user()->id]])->get()->toArray();

		foreach ($order['items'] as &$item) :

			$item['product_ID'] = Products::getProduct($item['product_ID']);
			$deliveryItems = OrderItemsDelivery::where('order_item_id', $item['ID'])->get();
			$item['delivery_items'] = $deliveryItems ? $deliveryItems->toArray() : [];
			if ($item['item_meta'] != '') :

				$item['item_meta'] = unserialize($item['item_meta']);

				if ($order) :

					$item['item_meta'] = array_filter($item['item_meta']);

					foreach ($item['item_meta'] as $key => &$meta) :

						$arr = [];

						$attr = Attributes::where('attribute_slug', $key)->first();

						$attr ? $attr = $attr->toArray() : '';

						$arr['attribute'] = $attr;

						if ($key != 'personal-message') :

							$value = Values::where([

								['value_ID', $meta],

								['attribute_ID', $arr['attribute']['attribute_ID']],

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

		endforeach;

		return view("admin.orders.invoiceprint", ['pageTitle' => 'Print Invoice'])->with('order', $order);
	}

	public function delete(Request $request)
	{

		Order::where('ID', $request->id)->delete();

		Orderitems::where('order_ID', $request->id)->delete();

		\App\Models\Web\CashbackCredit::where('order_id', $request->id)->delete();
		\App\Models\Web\Wallet::where('transaction_order', $request->id)->delete();

		return redirect()->back()->with('success', 'Order Deleted Successfully!');
	}

	public function getDefaultAddress(Request $request)
	{
		$addresses = DB::table('usermeta')
			->where('user_id', $request->user_id)
			->where('meta_key', 'address')
			->get();

		$defaultBillingAddress = null;

		$user = DB::table('users')->where('ID', $request->user_id)->first();
		$userEmail = $user ? $user->email : null;

		foreach ($addresses as $key => $address) {
			$metaValue = $address->meta_value;

			if (is_string($metaValue) && @unserialize($metaValue) !== false) {
				$unserialized = unserialize($metaValue);

				foreach ($unserialized as $addressItem) {
					if (isset($addressItem['default']) && $addressItem['default'] === "yes") {
						// 📨 Attach email here
						$addressItem['email'] = $userEmail;
						$defaultBillingAddress = [$addressItem];
						break;
					}
				}
			}

			if ($defaultBillingAddress) break; // stop after finding the default one
		}

		if ($defaultBillingAddress) {
			return response()->json([
				'success' => true,
				'billing_address' => $defaultBillingAddress,
			]);
		}

		return response()->json([
			'success' => false,
			'message' => 'Default addresses not found.',
			'billing_address' => $defaultBillingAddress,
		]);
	}
}
