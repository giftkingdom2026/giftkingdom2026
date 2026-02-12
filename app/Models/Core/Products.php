<?php

namespace App\Models\Core;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Web\Index;
use App\Models\Web\Wishlist;
use App\Models\Core\VariationsToAttributeValues;
use App\Models\Core\Attributes;
use App\Models\Core\Values;
use App\Models\Core\Categories;
use App\Models\Core\Brands;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\ProductsToBrands;
use App\Models\Core\ProductToAttributeValues;
use App\Models\Web\Users;
use App\Models\Web\Reviews;
use App\Models\Web\Comments;
use Auth;
use Route;

class Products extends Model{

	protected $table= 'products';

	protected $guarded = [];
public static function checkSlug($slug, $id = '')
{
    if ($slug == '') {
        return '';
    }

    $slug = str_replace([',', '.'], '', $slug);
    $slug = rtrim($slug, '-');

    $check = self::where('prod_slug', 'like', $slug . '%')->get();

    $existingNumbers = [];

    foreach ($check as $checking) {
        if (preg_match('/^(.*?)-(\d+)$/', $checking->prod_slug, $matches)) {
            $existingNumbers[] = (int) $matches[2];
        } else {
            if ($checking->prod_slug === $slug && ($id == '' || $checking->id != $id)) {
                $existingNumbers[] = 0;
            }
        }
    }

    if (empty($existingNumbers)) {
        return $slug;
    }

    $next = max($existingNumbers) + 1;
    return $slug . '-' . $next;
}


	public static function deductQuantity($id, $quantity) {
		DB::table('products')
		->where('ID', $id)
		->decrement('prod_quantity', $quantity);
	}

	public static function getVariations( $id ){

		$data = self::where([['products.prod_parent',$id],['products.prod_type','variation']])->get();

		$data2 = self::where([['products.prod_parent',$id],['products.prod_type','variation']])->pluck('ID')->toArray();

		$data3 = VariationsToAttributeValues::where([['product_ID',$id]])->whereIn('variation_ID',$data2)->get()->toArray();

		$data ? $data = $data->toArray() : '';

		foreach( $data as $key => &$item ) :

			$check = Route::current() != null && Route::current()->uri != '/';

			if( $check  ) :

				if(count($data3) != 0) :

					foreach( $data3 as $key3 => &$item3 ) :

						if($item['ID'] == $item3['variation_ID']):

							$item['variation'][$key3] = $item3; 

						endif;

					endforeach;

				else :

					$item['variation'] = [];

				endif;


			endif;

			$check = str_contains(Route::current()->uri, 'admin');

			if( $check ) :

				$item['prod_images'] = ['path' => Index::get_image_path2($item['prod_images']),'id' => $item['prod_images']];

				$item['prod_image'] = ['path' => Index::get_image_path2($item['prod_image']), 'id' => $item['prod_image']];

				$item['variation'] = VariationsToAttributeValues::where([['variation_ID',$item['ID']],['product_ID',$id]])->get()->toArray();

			endif;

		endforeach;
        // dd($data3,$data);

		return $data;

	}


	public static function getDashboardProducts(){
		
		$where = [['prod_parent',0],['prod_type','!=','variation'],['prod_status','active']];

		Auth::user()->role_id == 4 ? $where[] = ['author_id',Auth::user()->id] : '';  

		$products = self::where($where)->limit(5)->get()->toArray();

		foreach( $products as &$product ) : 

			$product['author_id'] = Users::getUserData($product['author_id']);
			$product['prod_image'] = Index::get_image_path($product['prod_image']);

		endforeach;

		return $products;
	}

	public static function insert($check){
		
		unset($check['fields']);

		$check['author_id'] = Auth::user()->id;

		$check['price'] = isset($check['sale_price']) && $check['sale_price'] != null ? 

		$check['sale_price'] : $check['prod_price'];
		$check['is_featured'] = isset($check['is_featured']) ? 1 : 0;

		$id = self::create($check);

		return $id;

	}

	public static function createVar( $data ){
		$attrs =explode(',', $data['attrs'] );
		if( isset( $data['update'] ) ) :

			foreach( $attrs  as $attr ) :

				$checkarr = [

					['product_ID',$data['parent']],

					['attribute_ID',$attr],

					['value_ID',$data[$attr]],

					['variation_ID','!=',$data['update']],

				];

				$check[] = VariationsToAttributeValues::where($checkarr)->pluck('variation_ID')->first();

			endforeach;

			$check = array_unique($check);

			$checkcount = count($check);

			if( TRUE ){

				VariationsToAttributeValues::where([

					['product_ID' , $data['parent']],

					['variation_ID' , $data['update'] ]

				])->delete();

				foreach( $attrs  as $attr ) :

					VariationsToAttributeValues::create([

						'product_ID' => $data['parent'],

						'variation_ID' => $data['update'],

						'attribute_ID' => $attr,

						'value_ID' => $data[$attr],

					]);

				endforeach;

				!str_contains( $data['prod_images'], ',') ? $data['prod_images'].=',' : '';
				self::where('ID',$data['update'])->update([

					'prod_title' => $data['prod_title'] ?? null,
					'prod_title_ar' => $data['prod_title_ar'] ?? null,

					'prod_sku' => $data['sku'],

					'prod_price' => $data['prod_price'],

					'sale_price' => $data['sale_price'],

					'prod_quantity' => $data['prod_quantity'],

					'prod_image' => $data['prod_image'],

					'prod_images' => $data['prod_images'],
							'prod_short_description' => $data['prod_short_description'],
					'prod_description' => $data['prod_description'],
					'prod_features' => $data['prod_features'],
							'prod_short_description_ar' => $data['prod_short_description_ar'] ?? null,
					'prod_description_ar' => $data['prod_description_ar'] ?? null,
					'prod_features_ar' => $data['prod_features_ar'] ?? null,

					'author_id' => Auth::user()->id,

				]);

			}else{

				return 'Already Exists!';

			}

		else :

			foreach( $attrs  as $attr ) :

				$checkarr = [

					['product_ID',$data['parent']],

					['attribute_ID',$attr],

					['value_ID',$data[$attr]],

				];

				$check[] = VariationsToAttributeValues::where($checkarr)->pluck('variation_ID')->first();

			endforeach;

			$check = array_filter(array_unique($check));

			$checkcount = count($check);
			if( TRUE  ){
				$var = self::create([

					'prod_title' => $data['prod_title'],
					'prod_title_ar' => $data['prod_title_ar'],

					'prod_sku' => $data['sku'],

					'prod_price' => $data['prod_price'],

					'sale_price' => $data['sale_price'],

					'prod_quantity' => $data['prod_quantity'],

					'prod_image' => $data['prod_image'],

					'prod_images' => $data['prod_images'],

					'prod_parent' => $data['parent'],

					'prod_type' => 'variation',
					'prod_short_description' => $data['prod_short_description'],
					'prod_description' => $data['prod_description'],
					'prod_features' => $data['prod_features'],
					'prod_short_description_ar' => $data['prod_short_description_ar'],
					'prod_description_ar' => $data['prod_description_ar'],
					'prod_features_ar' => $data['prod_features_ar'],

					'author_id' => Auth::user()->id,

				]);

				VariationsToAttributeValues::where([

					['product_ID' , $data['parent']],

					['variation_ID' , $var->id ]

				])->delete();
				
				foreach( $attrs  as $attr ) :

					VariationsToAttributeValues::create([

						'product_ID' => $data['parent'],

						'variation_ID' => $var->id,

						'attribute_ID' => $attr,

						'value_ID' => $data[$attr],

					]);

				endforeach;

			}
			else{

				return 'Already Exists!';
			}


		endif;

		if( isset($var) ) :

			return $var;

		endif;
	}



	public static function updatepost($check,$lang = 1){
		unset($check['_token']);

		$check['is_featured'] = isset($check['is_featured']) ? 1 : 0;

		$price = self::getPrice($check['ID']);

		$arr = [

			'prod_sku' => $check['prod_sku'],

			'prod_status' => $check['prod_status'],

			'prod_price' => $check['prod_price'],

			'sale_price' => $check['sale_price'],

			'price' => $price,

			'prod_quantity' => $check['prod_quantity'],

			'prod_type' => $check['prod_type'],

			'is_featured' => $check['is_featured']
		];
if (isset($check['prod_slug']) && $check['prod_slug'] !== '') {
    $arr['prod_slug'] = $check['prod_slug'];
}

		if( $lang == 1 ):

			$arr['prod_title'] = $check['prod_title'];

			$arr['prod_description'] = $check['prod_description'];

			$arr['prod_short_description'] = $check['prod_short_description'];
			$arr['prod_features'] = $check['prod_features'];

			$arr['prod_image'] = $check['prod_image'];

			$arr['prod_images'] = $check['prod_images'];

		endif;

		$post = self::where('ID', $check['ID'])

		->update($arr);

		if( isset($check['category']) ) : 

			ProductsToCategories::where('product_ID',$check['ID'])->delete();

			foreach( $check['category'] as $cat ) :

				ProductsToCategories::create([

					'product_ID' => $check['ID'],

					'category_ID' => $cat,

				]);

			endforeach;

		endif;


		if( isset($check['brand']) ) :

			ProductsToBrands::where('product_ID',$check['ID'])->delete();

			ProductsToBrands::create([

				'product_ID' => $check['ID'],

				'brand_ID' => $check['brand']

			]);

		endif;

	}

	public static function getPrice($product){

		if( is_array($product) ) :

			$price =    isset($product['sale_price']) && $product['sale_price'] != null ? 

			$product['sale_price'] : $product['prod_price'];

		else :

			$prod = self::where('ID',$product)->first()->toArray();

			$price =    isset($prod['sale_price']) && $prod['sale_price'] != null ? 

			$prod['sale_price'] : $prod['prod_price'];

		endif;

		return $price;

	}

	public static function updateOrder($data){

		foreach($data['posts'] as $post):

			self::where('ID',$post['id'])->update(['sort_order' => $post['order']]);

		endforeach;

	}



	// GET DATA


	public static function getProduct( $id ){

		$data = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'products.prod_image')
		->select('products.*', 'categoryTable.path as prod_image')
		->where('products.ID',$id)
		->groupBy('products.ID')
		->first();

		$data ? $data = $data->getAttributes() : '';

		if( empty($data) ) :

			return null;

		endif;

		if($data['prod_parent'] != 0){

			$data['prod_slug'] = self::where('ID' , $data['prod_parent'])->value('prod_slug');
		}

		$data['price'] = self::getPrice($data);



		return $data;

	}

	// public static function deductQuantity($id, $quantity) {
	// 	DB::table('products')
	// 	->where('ID', $id)
	// 	->decrement('prod_quantity', $quantity);
	// }

	public static function getVariationData($variation){

		!is_array($variation) ? $variation = self::where('ID',$variation)->first()->toArray() : '';

		$arr = ProductsToAttributes::leftJoin('attributes','attributes.attribute_ID','=','product_to_attributes.attribute_ID')
		->select('attributes.attribute_slug','attributes.attribute_ID')
		->where('product_to_attributes.product_ID',$variation['prod_parent'])
		->groupBy('product_to_attributes.attribute_ID')
		->get();

		$arr ? $arr = $arr->toArray() : '';

		$meta = [];

		if( !empty($arr) ) :

			foreach($arr as $item) :

				$meta[$item['attribute_slug']] = VariationsToAttributeValues::where([

					['product_ID',$variation['prod_parent']],
					
					['variation_ID',$variation['ID']],

					['attribute_ID',$item['attribute_ID']],

				])->pluck('value_ID')->first();

			endforeach;

		endif;
		
		return $meta;
	}

}	





