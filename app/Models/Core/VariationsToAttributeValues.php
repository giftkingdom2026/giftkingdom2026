<?php



namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Web\Index;

use App\Models\Web\Products;

use Session;

class VariationsToAttributeValues extends Model{


	protected $table= 'variations_to_attribute_values';

	protected $guarded = [];

	
	public static function checkRelation($data){

		$product = $data['product']; unset($data['product']);

		$attr = $data['attr']; unset($data['attr']);

		$val = $data['val']; unset($data['val']);

		$checkvars = self::where([['product_ID',$product]])->get();

		$checkvars ? $checkvars = $checkvars->toArray() : '';

		$parsedvars = [];

		foreach($checkvars as $key => $var) :

			$parsedvars[$var['variation_ID']][] = ['attr' => $var['attribute_ID'],'val' => $var['value_ID']];

		endforeach;

		foreach($parsedvars as $key => $var) :

			$cond = [];

			foreach($var as $item) :

				$cond[] = $item['attr'] == $attr && $item['val'] == $val ? 'true' : 'false';

			endforeach;

			if( !in_array('true', $cond) ) :

				unset($parsedvars[$key]);

			endif;

		endforeach;

		$values = [];

		foreach($parsedvars as $key => $var) :

			foreach($var as $item) :

				$values[]  = $item['val'];

			endforeach;

		endforeach;

		foreach( $data as $key => $item ) : 

			$arr[] = self::where([

				['product_ID',$product],
				['attribute_ID',$key],
				['value_ID',$item]

			])->pluck('variation_ID');

		endforeach;

		foreach( $arr as &$item) :

			$item ? $item = $item->toArray() : '' ;

		endforeach;


		if( count( $arr ) == 1 ) :

			$result = $arr[0];

		elseif( count( $arr ) == 2 ) :

			$result = array_intersect($arr[0],$arr[1]);

		elseif( count( $arr ) == 3 ) :

			$result = array_intersect($arr[0],$arr[1],$arr[2]);

		elseif( count( $arr ) == 4 ) :

			$result = array_intersect($arr[0],$arr[1],$arr[2],$arr[3]);

		elseif( count( $arr ) == 5 ) :

			$result = array_intersect($arr[0],$arr[1],$arr[2],$arr[3],$arr[4]);

		endif;

		if( empty($result ) ) : 

			return json_encode(['no_variation' => true,'available' => $values]);			

		endif;

		$result = array_shift($result);

		$product = Products::getProduct($result);
		$product['prod_image'] = asset($product['prod_image']);
if (!empty($product['prod_images'])) {
    if (is_array($product['prod_images'])) {
        foreach ($product['prod_images'] as &$img) {
            $img = asset($img);
        }
    } else {
        $product['prod_images'] = asset($product['prod_images']);
    }
}

		$product['prod_price'] = ($product['prod_price'] * session('currency_value'));

		$product['sale_price'] = ($product['sale_price'] * session('currency_value'));

		$product['price'] = ($product['price'] * session('currency_value'));

		$lang = session('lang');

		if($lang == 'ar'){
			$product['short_description'] = $product['prod_short_description_ar'];
			$product['prod_description'] = $product['prod_description_ar'];
			$product['prod_features'] = $product['prod_features_ar'];
			$product['prod_title'] = $product['prod_title_ar'];
		}

		$product['symbol'] = Session::get('symbol_right').''.Session::get('symbol_left');
		$return = ['relations' => $product, 'available' => $values];
		return json_encode($return);
	}
}	





