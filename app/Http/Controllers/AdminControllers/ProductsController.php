<?php

namespace App\Http\Controllers\AdminControllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Web\Index;

use App\Models\Web\Reviews;

use App\Models\Web\Comments;

use App\Models\Core\Images;

use App\Models\Core\Products;

use App\Models\Core\ProductsToAttributes;

use App\Models\Core\Attributes;

use App\Models\Core\Templates;

use App\Models\Core\Categories;

use App\Models\Core\Values;

use App\Models\Core\Brands;

use App\Models\Core\Postmeta;

use App\Models\Web\Users;

use App\Models\Core\ProductsToCategories;

use App\Models\Core\ProductsToBrands;

use App\Models\Core\ProductToAttributeValues;

use App\Models\Core\VariationsToAttributeValues;

use DB;

use Auth;

class ProductsController extends Controller{

public function view(Request $request) {

    $perPage = $request->input('length', 10);
    $search = $request->input('s', null);
    $category = $request->input('cat', 'All');

	if(Auth::user()->role_id == 4){
    $query = Products::where('prod_parent', 0)->where('author_id',Auth()->user()->id)->orderBy('created_at', 'desc');
	}else{
    $query = Products::where('prod_parent', 0)->orderBy('created_at', 'desc');

	}
    if ($category && $category != 'All') {
        $ids = ProductsToCategories::where('category_ID', $category)->pluck('product_ID');
        $query->whereIn('ID', $ids);
    }

    if ($search) {
        $query->where('prod_title', 'like', '%' . $search . '%');
    }

    $products = $query->paginate($perPage);

    $productsArray = $products ? $products->toArray() : [];

    $productsArray['data'] = self::parsePostContent($productsArray['data']);

    foreach ($productsArray['data'] as &$data) {
        $catIds = ProductsToCategories::where('product_ID', $data['ID'])->pluck('category_ID');
        $catTitles = Categories::whereIn('category_ID', $catIds)->pluck('category_title')->toArray();

        $data['cat'] = $catTitles;

        $brandIds = ProductsToBrands::where('product_ID', $data['ID'])->pluck('brand_ID');
        $brandTitles = Brands::whereIn('brand_ID', $brandIds)->pluck('brand_title')->toArray();

        $data['brands'] = $brandTitles;
    }

    $cats = Categories::select('category_title', 'category_ID')->where('parent_ID', 0)->get()->toArray();

    $title = ['pageTitle' => 'Products | List'];

    return view("admin.products.index", $title)->with('data', $productsArray)->with('cats', $cats);
}



	public function add(Request $request){

		$data['template'] = Templates::where('type','product')->first();

		$title = ['pageTitle' => 'Products | Add' ];

		$categories = Categories::where('parent_id', 0)->get()->toArray();

		foreach ($categories as &$category) {
			$category['children'] = Categories::getChildren($category['category_ID']);
		}

		$data['categories'] = $categories;

		$products = Products::select('ID','prod_title')->get();

		$products ? $products = $products->toArray() : '';

		$data['products'] = $products;

		$data['deals'] = Categories::getRecursive($request->ID,'deals');

		$data['brands'] = Brands::get();

		return view("admin.products.add",$title)->with('data', $data);

	}

	public function edit(Request $request){

		$post['product'] = Products::where('ID', $request->ID)->first()->toArray();

		$post = self::parsePostContent($post);

		$post['categories'] = Categories::getRecursive($request->ID,'category');

		$post['brands'] = Brands::getBrandsById($request->ID);

		$meta_array = array();

		$meta= Postmeta::where([['posts_id' , $request->ID],['lang',1]])->get();

		foreach($meta as $post_meta) :

			$meta_array[$post_meta->meta_key] = $post_meta->meta_value;

		endforeach;

		$post['meta'] = $meta_array;

		$products = Products::select('ID','prod_title')->where('prod_type','!=','variation')->get();

		$products ? $products = $products->toArray() : '';

		$post['products'] = $products;

		return view("admin.products.edit",['pageTitle','Edit Product'])->with('data', $post);

	}

	function changeLang(Request $request){

		$meta_array = array();

		$meta = Postmeta::where([['posts_id' , $request->id],['lang',$request->lang]])->get();

		foreach($meta as $post_meta) :

			$meta_array[$post_meta->meta_key] = $post_meta->meta_value;

		endforeach;

		$post['product'] = Products::where('ID', $request->id)->first()->toArray();

		if( $request->lang != 1) :

			$post['product']['prod_title'] = $meta_array['prod_title'] ?? '';
			$post['product']['prod_description'] = $meta_array['prod_description'] ?? '';
			$post['product']['prod_short_description'] = $meta_array['prod_short_description'] ?? '';
			$post['product']['prod_image'] = $meta_array['prod_image'] ?? '';
			$post['product']['prod_images'] = $meta_array['prod_images'] ?? '';

		endif;


		$post = self::parsePostContent($post);
		
		if( $post['product']['prod_type'] == 'variable' ) :

			$variations = Products::getVariations($request->id);

			$attrs = self::getAttrs($request,'get');

			$allattrs = Attributes::all();

			$allattrs ? $allattrs = $allattrs->toArray() : '';

			$post['variations'] = 

			view('admin.products.variable')->with('id',$request->id)

			->with('variations',$variations)

			->with('attrs',$attrs)

			->with('allattrs',$allattrs)->render();

		endif;

		$post['categories'] = Categories::getRecursive($request->id,'category');

		$post['meta'] = $meta_array;

		$products = Products::select('ID','prod_title')->where('prod_type','!=','variation')->get();

		$products ? $products = $products->toArray() : '';

		$post['products'] = $products;

		return view("admin.products.fields")->with('data', $post)->render();
	}

	public function update(Request $request){

		$check = $request->all();

		if( $request->lang != 1) :

			$check['meta']['prod_title'] = $check['prod_title'];
			$check['meta']['prod_description'] = $check['prod_description'];
			$check['meta']['prod_short_description'] = $check['prod_short_description'];
			$check['meta']['prod_image'] = $check['prod_image'];
			$check['meta']['prod_images'] = $check['prod_images'];

			unset($check['prod_title']);
			unset($check['prod_description']);
			unset($check['prod_short_description']);
			unset($check['prod_image']);
			unset($check['prod_images']);
			unset($check['prod_slug']);

		endif;

		if( $check['meta'] ) :

			foreach( $check['meta'] as $key => $item) :

				is_array($item) ? $item = implode(',',$item) : '';

				$meta[] = [

					'posts_id' => $request->ID,

					'meta_key' => $key,

					'meta_value' => $item,

					'lang' => $request->lang,

				]; 

			endforeach;

			unset($check['meta']);

		endif;

		$post = Products::updatepost($check,$request->lang);

		if( isset( $meta ) && !empty($meta) ) : Postmeta::where([['posts_id' , $request->ID],['lang',$request->lang]])->delete(); DB::table('postmeta')->insert($meta); endif;

		return back()->with('success', 'Product Updated Successfully!');

	}

	public function search(Request $request){

		$products = Products::search($request->search);

		return $products;

	}

	public function getVariations(Request $request)
	{
		$variations = Products::where([
			['prod_parent', $request->id],
			['prod_type', 'variation'],
			['prod_quantity', '>', 0]
		])->get();

		if ($variations->isNotEmpty()) {
			foreach ($variations as $var) {
				$attribute_links = \App\Models\Core\VariationsToAttributeValues::where('variation_ID', $var->ID)->get();
				$attribute_titles = [];

				foreach ($attribute_links as $link) {
					$attribute = \App\Models\Core\Values::where('value_ID', $link->value_ID)->first();
					if ($attribute) {
						$attribute_titles[] = $attribute->value_title;
					}
				}

				$attribute_string = implode(' | ', $attribute_titles);
				if ($var->prod_quantity > 0) {
					echo '<option value="' . $var->ID . '" data-stock="' . $var->prod_quantity . '">' .
						$var->prod_title . ' | #' . $var->ID . ' | ' . $attribute_string .
						'</option>';
				} else {
					echo '<option disabled value="' . $var->ID . '" data-stock="' . $var->prod_quantity . '">' .
						$var->prod_title . ' | #' . $var->ID . ' | ' . $attribute_string . ' (Out Of Stock) </option>';
				}
			}
		}
	}

	public function delete(Request $request){

		Products::where('ID',$request->id)->delete();

		ProductsToCategories::where('product_ID',$request->id)->delete();

		ProductsToBrands::where('product_ID',$request->id)->delete();

		ProductToAttributeValues::where('product_ID',$request->id)->delete();

		VariationsToAttributeValues::where('product_ID',$request->id)->delete();

		Reviews::where('object_ID',$request->id)->delete();

		Comments::where('product_ID',$request->id)->delete();

		return back()->with('success','Item Deleted!');
	}

	public function variable(Request $request){
		if( $request->id == 'undefined' ) :

			return 'new';

		else:

			$variations = Products::getVariations($request->id);
			$attrs = self::getAttrs($request,'get');

			$allattrs = Attributes::all();

			$allattrs ? $allattrs = $allattrs->toArray() : '';

			return 

			view('admin.products.variable')->with('id',$request->id)

			->with('variations',$variations)

			->with('attrs',$attrs)

			->with('allattrs',$allattrs);

		endif;

	}

	public function searchAttrs(Request $request){

		$attrs = Attributes::search($request->search);

		return $attrs;

	}

	public function getAttrs(Request $request, $arr = null ){

		$attrs = ProductsToAttributes::getProductAttributes($request->id);

		if( !empty( $attrs ) ) :

			$attrs = Attributes::getAttrs($attrs);

			foreach($attrs as &$item) :

				$vals = Values::where( 'attribute_ID' , $item['attribute_ID'] )->get();

				$vals ? $vals = $vals->toArray() : '';

				$item['values'] = $vals;

				$item['selected_values_check'] = ProductToAttributeValues::getRealtion( $request->id , $item['attribute_ID'] );

				$vals = Values::whereIn( 'value_ID' , $item['selected_values_check'] )->get();

				$vals ? $vals = $vals->toArray() : '';

				$item['selected_values'] = $vals;

			endforeach;

		endif;

		if( $arr != null ) :

			return $attrs;

		else :

			return view('admin.products.attributes')->with('attrs',$attrs);

		endif;

	}

	public function assignAttrs(Request $request){

		ProductsToAttributes::create([

			'product_ID' => $request->product_ID,

			'attribute_ID' => $request->attribute_ID,

		]);

	}

	public function searchValues(Request $request){

		$values = Values::search($request->search);

		return $values;
	}

	public function saveValues(Request $request){

		ProductToAttributeValues::insert($request->all());

	}

	public function addVariation(Request $request){

		$data = self::getAttrs($request,'get');

		return view('admin.products.variations')->with('attrs',$data);

	}

	public function removeVariation(Request $request){

		$data = Products::where('ID',$request->id)->delete();

		VariationsToAttributeValues::where('variation_ID',$request->id)->delete();


	}

	public function createVariation(Request $request){

		$data = Products::createVar($request->all());

		return json_encode($data);
	}


	public function import(Request $request){

		$title = ['pageTitle' => 'Products | Import' ];
		
		return view("admin.products.import",$title);

	}

	public function importData(Request $request){

		$data = $request->all();

		$file = $data['file'];

		$file_path = $file->getRealPath();

		$file_handle = fopen($file_path, 'r');

		if ($file_handle === FALSE) :

			echo '<div class="notice notice-error"><p>Could not open the file.</p></div>';

			return;

		endif;

		$i = 0;

		$variations = [];

		while ( ($row = fgetcsv( $file_handle, 1000, "," ) ) !== FALSE ) :

			if( $i != 0 && count($row) > 15 ) :

				$slug = $row[15] != 'Variation' ? strtolower( str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '', $row[2] ) ) ) : '';

				$arr[] = [

					'prod_sku' => $row[0],
					'parent_sku' => $row[1],
					'prod_title' => $row[2],
					'prod_slug' => $slug,
					'prod_description' => $row[3],
					'prod_short_description' => $row[4],
					'categories' => ['category' => $row[5],'child' => [ 'category' => $row[6], 'child' => $row[7] ] ],
					'brand' => $row[8],
					'specifications' => $row[9],
					'attributes' => ['Color:'.$row[10]],
					'prod_price' => str_replace(',','',$row[11]),
					'sale_price' => str_replace(',','',$row[12]),
					'purchase_price' => 0,
					'prod_quantity' => $row[14],
					'prod_type' => strtolower($row[15]),
					'prod_image' => $row[16],
					'prod_images' => $row[17]

				];

			endif;

			$i++;

		endwhile;

		foreach($arr as $key => &$data ) :

			if( $data['prod_type'] == 'variable' ) :

				foreach( $arr as $subitems ) :

					if($subitems['parent_sku'] == $data['prod_sku']) :

						$data['variations'][] = $subitems;

					endif;

				endforeach;

			elseif(  $data['prod_type'] == 'variation' ) :

				unset($arr[$key]);

			endif;

		endforeach;

		foreach($arr as $product) :

			$check = Products::where('prod_sku',$product['prod_sku'])->pluck('ID')->first();

			if( $check ) :

				Products::where('ID',$check)->update([
					
					'prod_image' => $product['prod_image'],
					'prod_images'=> $product['prod_images']

				]);

				// Postmeta::create([

				// 	'posts_id' => $check,

				// 	'meta_key' => 'specifications',

				// 	'meta_value' => $product['specifications']

				// ]);

				if( isset( $product['variations'] ) ) : 

					foreach( $product['variations'] as $var) :

						$check2 = Products::where('prod_sku',$var['prod_sku'])->pluck('ID')->first();

						if( $check2 ) :

							Products::where('ID',$check2)->update([

								'prod_image' => $product['prod_image'],
								'prod_images'=> $product['prod_images']

							]);

						endif;

					endforeach;

				endif;

			else :

				$otherdata['categories'] = $product['categories'];

				$otherdata['brand'] = $product['brand'];

				$otherdata['specifications'] = $product['specifications'];

				$otherdata['attributes'] = $product['attributes'];

				unset( $product['attributes'] );

				unset( $product['parent_sku'] );

				unset( $product['specifications'] );

				unset( $product['brand'] );

				unset( $product['categories'] );

				$otherdata['variations'] = [];

				if( isset( $product['variations'] ) ) : 

					$otherdata['variations'] = $product['variations'];

					unset($product['variations']);

				endif;

				$id = Products::insert($product);

				foreach( $otherdata['variations'] as $prod ) :

					$variation = self::createVariationFromCsv( $prod, $id->id );

				endforeach;

				Attributes::assignOrCreate( $otherdata['attributes'] , $id->id );

				Brands::assignOrCreate( $otherdata['brand'] , $id->id );

				Categories::assignOrCreate( $otherdata['categories'] , $id->id );

				Postmeta::create([

					'posts_id' => $id->id,

					'meta_key' => 'specifications',

					'meta_value' => $otherdata['specifications']

				]);

			endif;

		endforeach;

		fclose($file_handle);

	}

	public static function createVariationFromCsv($product,$id){

		$otherdata['categories'] = $product['categories'];

		$otherdata['brand'] = $product['brand'];

		$otherdata['specifications'] = $product['specifications'];

		$otherdata['attributes'] = $product['attributes'];

		unset( $product['attributes'] );

		unset( $product['parent_sku'] );

		unset( $product['specifications'] );

		unset( $product['brand'] );

		unset( $product['categories'] );

		$product['prod_parent'] = $id;

		$id = Products::insert($product);

		Brands::assignOrCreate( $otherdata['brand'] , $id );

		Categories::assignOrCreate( $otherdata['categories'] , $id );

		Attributes::assignOrCreate( $otherdata['attributes'] , $product['prod_parent'] , $id );

		return $id;
	}

	public function create(Request $request)
	{

		$check = $request->all();

		unset($check['_token']);
		unset($check['category']);
		unset($check['brand']);

		$prodmeta = $check['meta'] ?? [];

		unset($check['meta']);


		$check['prod_slug'] = Products::checkSlug($check['prod_slug']);

		$post = Products::insert($check);

		if (!empty($prodmeta)) :

			foreach ($prodmeta as $key => $item) :

				is_array($item) ? $item = implode(',', $item) : '';

				$meta[] = [

					'posts_id' => $post->id,

					'meta_key' => $key,

					'meta_value' => $item,

				];

			endforeach;



		endif;


		if (isset($request->category)) :

			foreach ($request->category as $cat) :

				ProductsToCategories::create([

					'product_ID' => $post->id,

					'category_ID' => $cat,

				]);

			endforeach;

		endif;

		if (isset($request->brand)) :

			ProductsToBrands::create([

				'product_ID' => $post->id,

				'brand_ID' => $request->brand,

			]);

		endif;

		if (isset($meta) && !empty($meta)) :  DB::table('postmeta')->insert($meta);
		endif;

		return redirect(asset('admin/product/edit/' . $post->id))->with('success', 'Product Created Successfully!');
	}
	
	public static function parsePostContent($result){

		foreach( $result as $key => $data ) :

			foreach($data as $subkey => &$subdata ) :

				if( str_contains( $subkey , 'images') ) :

					if( !str_contains($subdata, ',') ) :

						$subdata.=',';

					endif;

					$result[$key][$subkey] = ['path' => Index::get_image_path( $subdata ) , 'id' => $subdata ];

				elseif( str_contains( $subkey , 'image') ) :

					$result[$key][$subkey] = ['path' => Index::get_image_path( $subdata ) , 'id' => $subdata ];

				endif;

				if( $subkey == 'metadata' ) :

					foreach($subdata as $metakey => $metadata) :

						if( str_contains($metakey, 'image') ) :

							$result[$key][$subkey][$metakey] = [

								'path'=> Index::get_image_path($metadata) ,

								'id' => $metadata

							];

						endif;

					endforeach;

				endif;

			endforeach;

		endforeach;

		return $result;

	}

	public function inventory(Request $request){

		if( in_array(Auth::user()->role_id, [1,2])) :

			$products = Products::where([['prod_type','!=','variation']])->paginate(25);

		else :

			$products = Products::where([['author_id',Auth()->user()->id],['prod_type','!=','variation']])->paginate(25);

		endif;

		$products ? $products = $products->toArray() : '';

		foreach($products['data'] as &$product) :

			$product = Products::getProduct($product['ID']);

			$product['author_id'] = Users::getUserData( $product['author_id'] );

		endforeach;

		return view("admin.products.inventory.index",['pageTitle','Inventory'])->with('data', $products);

	}

	public function inventoryEdit(Request $request){

		$product = Products::getProduct($request->id);

		return view("admin.products.inventory.edit",['pageTitle','Edit Inventory'])->with('data', $product);
	}

	public function inventoryUpdate(Request $request){

		$data = $request->all();

		Products::where('ID',$data['ID'])->update([

			'prod_quantity' => $data['prod_quantity'],

			'purchase_price' => $data['purchase_price']

		]);

		return redirect('admin/product/inventory')->with('success','Inventory Updated Successfully!');

	}
		public function getInventoryAjax(Request $request)
	{
		$perPage = $request->input('length', 10);
		$start = $request->input('start', 0);
		$draw = $request->input('draw');
		$search = $request->input('search.value');
if(Auth::user()->role_id == 4){
	$query = Products::where('prod_status', 'active')->where('author_id',Auth()->user()->id)
                 ->whereIn('prod_type', ['variation', 'simple']);
}else{
$query = Products::where('prod_status', 'active')
                 ->whereIn('prod_type', ['variation', 'simple']);
}


		if (!empty($search)) {
			$query->where(function ($q) use ($search) {
				$q->where('prod_title', 'like', "%{$search}%")
					->orWhere('ID', 'like', "%{$search}%");
			});
		}

		$totalRecords = $query->count();

		$products = $query
			->offset($start)
			->limit($perPage)
			->get();

		$data = [];

		foreach ($products as $index => $product) {
			$fullProduct = Products::getProduct($product->ID);
			$author = Users::getUserData($fullProduct['author_id']);

			$prodTitle = $fullProduct['prod_title'];

			if ($fullProduct['prod_type'] === 'variation') {
				$attribute_links = \App\Models\Core\VariationsToAttributeValues::where('variation_ID', $fullProduct['ID'])->get();
				$attribute_titles = [];

				foreach ($attribute_links as $link) {
					$attribute = \App\Models\Core\Values::where('value_ID', $link->value_ID)->first();
					if ($attribute) {
						$attribute_titles[] = $attribute->value_title;
					}
				}

				$attribute_string = implode(' | ', $attribute_titles);

				$prodTitle = '#' . $fullProduct['prod_sku'] . ' ' . $fullProduct['prod_title'];

				if (!empty($attribute_string)) {
					$prodTitle .= ' | ' . $attribute_string;
				}
			}

			$actionUrl = '';

			if ($fullProduct['prod_type'] === 'variation') {
				$actionUrl = asset('admin/product/edit/' . $fullProduct['prod_parent']) . '?var=' . $fullProduct['ID'];
			} else {
				$actionUrl = asset('admin/product/edit/' . $fullProduct['ID']);
			}

			$data[] = [
				'id' => $fullProduct['ID'],
				'image' => '<img src="' . asset($fullProduct['prod_image']) . '" height="70" style="object-fit: cover;">',
				'title' => e($prodTitle),
				'stock' => $fullProduct['prod_quantity'],
				'purchase_price' => $fullProduct['prod_price'],
				'sell_price' => $fullProduct['sale_price'],
				'author' => $author['email'] ?? 'N/A',
				'action' => '<a title="Edit" href="' . $actionUrl . '" class="badge bg-light-blue"><i class="fas fa-edit"></i></a>',
			];
		}


		return response()->json([
			'draw' => intval($draw),
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => $totalRecords,
			'data' => $data
		]);
	}
}

