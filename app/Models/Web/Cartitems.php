<?php

namespace App\Models\Web;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Products;
use App\Models\Core\Attributes;
use App\Models\Core\Values;
use App\Models\Core\CartItemAddress;
use App\Models\Core\Posts;
use App\Models\Web\Wishlist;

use Auth;

use Session;


class Cartitems extends Model
{

	protected $table = 'cart_items';
	protected $guarded = [];
public static function add($cart, $product, $qty, $variable = [], $serial = null)
{
    empty($variable) ? $var = 0 : $var = $variable['variation'];
    $incomingMessage = $variable['attributes']['values']['personal-message'] ?? null;

    $productModel = Products::find($product['ID']); 
    if ($productModel && $productModel->prod_type === 'simple') {
        $check = self::where([
            ['cart_ID', $cart->cart_ID],
            ['product_ID', $product['ID']],
        ])->first();

        if ($check) {
            $check->product_quantity += $qty;
        } else {
            $check = new Cartitems();
            $check->cart_ID = $cart->cart_ID ?? $cart->id;
            $check->product_ID = $product['ID'];
            $check->product_quantity = $qty;
            $check->variable_ID = 0;
            $check->in_order = 1;
            $check->item_meta = ''; 
        }

        isset($product['devices']) ? $check->trade_in = $product['devices'] : '';
        $check->save();

        return $check;
    }

    $matchingItems = self::where([
        ['cart_ID', $cart->cart_ID],
        ['product_ID', $product['ID']],
        ['variable_ID', $var],
    ])->get();

    $check = null;

    foreach ($matchingItems as $item) {
        $meta = @unserialize($item->item_meta);
        if ($meta !== false && is_array($meta)) {
            $existingMessage = $meta['personal-message'] ?? null;

            if (
                $existingMessage === $incomingMessage ||
                (is_null($existingMessage) && is_null($incomingMessage))
            ) {
                $check = $item;
                break;
            }
        }
    }

    if ($check) {
        $unserializedMeta = @unserialize($check->item_meta);
        if ($unserializedMeta !== false && is_array($unserializedMeta)) {
            $unserializedMeta['personal-message'] = $incomingMessage;
            $check->item_meta = serialize($unserializedMeta);
        }

        $check->product_quantity = ($check->product_quantity + $qty);
        isset($product['devices']) ? $check->trade_in = $product['devices'] : '';
    } else {
        $check = new Cartitems();
        $check->cart_ID = $cart->cart_ID ?? $cart->id;
        $check->product_ID = $product['ID'];
        $check->product_quantity = $qty;
        $check->variable_ID = $var;
        $check->in_order = 1;

        if ($var != 0) {
            $check->item_meta = serialize($variable['attributes']['values']);
        } else {
            $check->item_meta = $serial ?? '';
        }

        isset($product['devices']) ? $check->trade_in = $product['devices'] : '';
    }

    $check->save() ? $message = 'Saved!' : $message = 'Error!';

    if ($check->item_meta != '') {
        $check->serial_meta = $check->item_meta;

        $unserialized = @unserialize($check->item_meta);
        $item = [];

        if ($unserialized !== false && is_array($unserialized)) {
            foreach ($unserialized as $key => $meta) {
                $arr = [];

                $attr = Attributes::where('attribute_slug', $key)->first();
                $arr['attribute'] = $attr ? $attr->toArray() : null;

                if ($arr['attribute'] != null) {
                    $value = Values::where([
                        ['value_ID', $meta],
                        ['attribute_ID', $arr['attribute']['attribute_ID']],
                    ])->first();

                    $arr['value'] = $value ? $value->toArray() : null;
                } else {
                    $arr['value'] = $meta;
                }

                $item['item_meta'][$key] = $arr;
            }
        }

        if (isset($item['item_meta']) && $item['item_meta'] != null) {
            $check->display_meta = $item['item_meta'];
        }
    }

    return $check;
}



	public static function getItems($id, $order = false)
	{

		$where = [['cart_ID', $id]];

		$items = self::where($where)->get();

		$items ? $items = $items->toArray() : '';

		foreach ($items as $key => &$item) :

			$prod = $item['variable_ID'] != 0 ? $item['variable_ID'] : $item['product_ID'];

			$product = Products::select('prod_title', 'prod_image', 'sale_price', 'prod_price', 'price', 'prod_quantity', 'prod_parent', 'prod_slug', 'prod_type')->where([['ID', $prod]])->first();

			$product ? $product = $product->toArray() : '';
			$addresses = CartItemAddress::where('cart_item_id', $item['id'])->get();
			$addresses ? $addresses = $addresses->toArray() : '';
			$item['product'] = $product;

			$item['addresses'] = $addresses;
			$item['product']['prod_image'] = Index::get_image_path($item['product']['prod_image']);

			$item['product']['prod_type'] == 'variation' ? $item['product']['prod_slug'] = Products::where('ID', $item['product']['prod_parent'])->pluck('prod_slug')->first() : '';

			$item['product']['wishlist'] = Wishlist::productExists($item['product_ID']);

			if ($item['product'] == null) :

				unset($items[$key]);

			else :

				// $item['wishlist'] = Wishlist::productExists($item['product']['ID']);

				if ($item['item_meta'] != '') :

					$item['serial_meta'] = $item['item_meta'];

					$item['item_meta'] = unserialize($item['item_meta']);

					if (!$order) :

						foreach ($item['item_meta'] as $key => &$meta) :

							$arr = [];

							$attr = Attributes::where('attribute_slug', $key)->first();

							$attr ? $attr = $attr->toArray() : '';

							$arr['attribute'] = $attr;

							if ($arr['attribute'] != null) :

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

				if ($item['trade_in'] != '') :

					$item['trade_in'] = unserialize($item['trade_in']);

					foreach ($item['trade_in'] as &$device) :

						$device['exchange'] = Posts::getPostByID($device['exchange']);

					endforeach;

				endif;

			endif;

		endforeach;
		return $items;
	}


	public static function updateQty($id, $qty)
	{
		Cartitems::where('id', $id)->update(['product_quantity' => $qty]);
	}
}
