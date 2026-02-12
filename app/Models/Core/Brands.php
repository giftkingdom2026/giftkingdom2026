<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Web\Index;
use App\Models\Core\CategoriesToBrands;
use App\Models\Core\ProductsToBrands;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class Brands extends Model{

    public $table = 'brands';
    public $guarded = [];

public static function list($id = null, $active = 0, $perPage = 10, $search = null)
{
    $query = self::query();

    // Handle category-brand linking
    if ($id !== null && $id != 0) {
        $brandMapping = CategoriesToBrands::selectRaw('category_ID, group_concat(brand_ID) as brands')
            ->where('category_ID', $id)
            ->get()
            ->toArray();

        $brandMapping = array_filter(array_shift($brandMapping));

        if (!empty($brandMapping)) {
            $brandIds = explode(',', $brandMapping['brands']);
            $query->whereIn('brand_ID', $brandIds);
        } else {
            // No brands linked, return empty result
            $query->whereIn('brand_ID', [0]); // Will return nothing
        }
    }

    // Search filtering
    if (!empty($search)) {
        $query->where('brand_title', 'LIKE', '%' . $search . '%');
    }

    // Final query: Order and paginate
    $paginated = $query->orderBy('created_at', 'DESC')->paginate($perPage)->toArray();

    // Enhance each item with image + count + active flag
    foreach ($paginated['data'] as &$item) {
        $item['brand_image'] = Index::get_image_path($item['brand_image']);
        $item['active'] = ($item['brand_ID'] == $active);
        $item['count'] = ProductsToBrands::where('brand_ID', $item['brand_ID'])->count();
    }

    return [
        'data' => $paginated['data'],
        'paginator' => [
            'current_page' => $paginated['current_page'],
            'per_page' => $paginated['per_page'],
            'total' => $paginated['total'],
            'last_page' => $paginated['last_page'],
            'links' => $paginated['links'],
        ]
    ];
}


    public static function getBrandsFilter( $active = [] ){

        $arr = self::where('brand_ID','!=','0')->where('brand_status','1')->orderBy('brand_title','ASC')->get();

        $arr ? $arr = $arr->toArray() : '';

        foreach( $arr as $key => &$item ) :

            in_array($item['brand_ID'], $active) ? $item['active'] = true : '';

            $item['count'] = ProductsToBrands::where('brand_ID',$item['brand_ID'])->count();

        endforeach;

        return $arr;
    }

    public static function addBrand($data){

        unset($data['_token']);

        $order = self::max('sort_order');

        $order = $order != null ? ($order + 1) : 0; 

        $brand = self::create([

          'brand_title' => $data['brand_title'],
          'brand_slug' => $data['brand_slug'],
          'brand_image' => $data['brand_image'],
          'brand_status' => $data['brand_status'],
          'sort_order' => $order,

      ]);

        CategoriesToBrands::insert($data['category_ID'],$brand->id);
    }

    public static function getBrandsById( $id ){

        $brands = self::all();

        $brands ? $brands = $brands->toArray() : '';

        foreach( $brands as &$brand ) :

            $brand['checked'] = ProductsToBrands::exists( $brand['brand_ID'], $id );

        endforeach;

        return $brands;
    }


    public static function getHomeBrands($brands){

        $ids = unserialize($brands);

        $arr = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'brands.brand_image')
        ->select('brands.*', 'categoryTable.path as brand_image')
        ->whereIn('brand_ID',$ids)
        ->groupBy('brands.brand_ID')
        ->get()->toArray();
        
        return $arr;
    }


    public static function searchBrands($keywords){

        if( $keywords == '' ) :

            $brands = self::all();

        else:

            $brands = self::where('brand_title','like','%'.$keywords.'%')->get();

        endif;

        $brands ? $brands = $brands->toArray() : '';

        foreach($brands as $key => &$brand) :

            $brand['count'] = ProductsToBrands::where('brand_ID',$brand['brand_ID'])->count(); 

        endforeach;

        // $data = ProductsToBrands::all();

        // foreach($data as $item):

        //     $check = Products::where('ID',$item->product_ID)->first();

        //     $check ? $check = $check->toArray() : '';

        //     if(empty($check)) :

        //         ProductsToBrands::where('ID',$item->ID)->delete();

        //     endif;

        // endforeach;

        return $brands; 
    }

    public static function assignOrCreate( $title, $id){

        $check = self::where('brand_title',$title)->first();

        $check ? $check = $check->toArray() : '';

        if( empty( $check ) ) :

            $order = self::max('sort_order');

            $order = $order != null ? ($order + 1) : 0; 

            $brand = self::create([

              'brand_title' => $title,
              'brand_slug' => strtolower(str_replace(' ', '-', $title)),
              'brand_image' => 8570,
              'brand_status' => 1,
              'sort_order' => $order,

          ]);

            $brandid = $brand->id; 

        else :

            $brandid = $check['brand_ID'];

        endif;

        ProductsToBrands::create([

            'product_ID' => $id,

            'brand_ID' => $brandid,

        ]);
    }
}
