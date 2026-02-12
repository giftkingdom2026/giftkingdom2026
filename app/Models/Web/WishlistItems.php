<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use App\Models\Web\Index;
use App\Models\Web\Products;
use App\Models\Core\Values;
use App\Models\Core\Attributes;

class WishlistItems extends Model{

	protected $table= 'wishlist_items';
	protected $guarded = [];



	public static function addOrRemoveItem($wish, $prod, $var_id , $variable = [] , $serial)
	{	
		empty( $variable ) ? $var = 0 : $var = $variable['variation'];

	    $productIdToStore = (!empty($var_id) && $var_id != 0) ? $var_id : $prod;

	    $item_meta_data = (isset($variable['attributes']) &&
                   isset($variable['attributes']['values']) &&
                   is_array($variable['attributes']['values']))
                 ? serialize($variable['attributes']['values'])
                 : null;

	    $query = self::where('product_ID', $productIdToStore)
	                 ->where('wishlist_ID', $wish);

	    $existingRow = $query->first();
if($var_id != null && $var_id !='0'){
	$productTitle = Products::where('ID', $var_id)->value('prod_title');
}else{

	$productTitle = Products::where('ID', $prod)->value('prod_title');
}
	    if ($existingRow) {
	        $query->delete();
	        $message = "{$productTitle} removed from wishlist!";
	    } else {

	        self::insert([
	            'product_ID'   => $productIdToStore,
	            'wishlist_ID'  => $wish,
	            'variation_id' => $var_id,
	            'created_at'   => now(),
	            'updated_at'   => now(),
	            'item_meta' => !empty($item_meta_data) ? $item_meta_data : $serial,
	        ]);

	        $message = "{$productTitle} added to wishlist!";
	    }

	    return [
	        'message' => $message,
	        'count'   => self::where('wishlist_ID', $wish)->count(),
	    ];
	}



	public static function getItems($id){

		$items = self::where('wishlist_ID',$id)->get();

		$items ? $items = $items->toArray() : '';

		foreach($items as $key => &$item):

			$product = Products::where('ID',$item['product_ID'])->first();

			if( $product ) :

				$product = $product->toArray();

				$product['prod_image'] = Index::get_image_path($product['prod_image']);

				$product['price'] = Products::getPrice($product);

				$product['review'] = Reviews::getRating($product['ID']);

				$product['created_at'] = date('d-m-Y', strtotime($item['created_at']));

				$product['prod_type'] == 'variation' ? $product['prod_slug'] = Products::where('ID',$product['prod_parent'])->pluck('prod_slug')->first() : '';

				if(isset($item['item_meta']) && $item['item_meta'] != '' ) :

					$item['serial_meta'] = $item['item_meta'];

					$item['item_meta'] = unserialize($item['item_meta']);

					foreach( $item['item_meta'] as $key => &$meta) :

						$arr = [];

						$attr = Attributes::where('attribute_slug',$key)->first();

						$attr ? $attr = $attr->toArray() : '';

						$arr['attribute'] = $attr;

						if( $arr['attribute'] != null ) :

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

				
				$item['product'] = $product;

			else :

				unset($items[$key]);

			endif;

		endforeach;

		return $items;
	}

	// public static function getItems( $id,$order = false ){

	// 	$where = [ ['wishlist_ID',$id] ];

	// 	$items = self::where($where)->get();

	// 	$items ? $items = $items->toArray() : '';

	// 	foreach( $items as $key => &$item ) :

	// 		$prod = $item['product_ID'];
		
	// 		$product = Products::select('prod_title','prod_image','sale_price','prod_price','price','prod_quantity','prod_parent','prod_slug','prod_type')->where([['ID',$prod]])->first();

			
	// 		$product ? $product = $product->toArray() : '';

	// 		dd($product);

	// 		$item['product'] = $product;
			
	// 		$item['product']['prod_image'] = Index::get_image_path($item['product']['prod_image']);

	// 		$item['product']['prod_type'] == 'variation' ? $item['product']['prod_slug'] = Products::where('ID',$item['product']['prod_parent'])->pluck('prod_slug')->first() : '';

	// 		$item['product']['wishlist'] = Wishlist::productExists($item['product_ID']);

	// 		if( $item['product'] == null ) :
				
	// 			unset( $items[$key] );

	// 		else :

	// 			if( $item['item_meta'] != '' ) :

	// 				$item['item_meta'] = unserialize($item['item_meta']);

	// 				if( !$order ) :

	// 					foreach( $item['item_meta'] as $key => &$meta) :

	// 						$arr = [];

	// 						$attr = Attributes::where('attribute_slug',$key)->first();

	// 						$attr ? $attr = $attr->toArray() : '';

	// 						$arr['attribute'] = $attr;

	// 						if( $arr['attribute'] != null ) :

	// 							$value = Values::where([

	// 								['value_ID',$meta],

	// 								['attribute_ID',$arr['attribute']['attribute_ID']],

	// 							])->first();

	// 							$value ? $value = $value->toArray() : '';

	// 							$arr['value'] = $value;

	// 						else :

	// 							$arr['value'] = $meta;
							
	// 						endif;

	// 						$item['item_meta'][$key] = $arr;

	// 					endforeach;

	// 				endif;

	// 			endif;
				
	// 			if( $item['trade_in'] != '' ) :

	// 				$item['trade_in'] = unserialize($item['trade_in']);

	// 				foreach( $item['trade_in'] as &$device ) :

	// 					$device['exchange'] = Posts::getPostByID($device['exchange']);

	// 				endforeach;

	// 			endif;

	// 		endif;

	// 	endforeach;

	// 	return $items;
	// }
}	


