<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\Products;
use App\Models\Web\Index;
use App\Models\Core\Termmeta;
use Illuminate\Support\Str;
class Categories extends Model{

    protected $table = 'categories';

    protected $guarded = [];

    public static function getCategory($id){

        $data = self::where('category_ID', $id)->first()->toArray();

        $data['category_image'] = [

            'path' => Index::get_image_path($data['category_image']) ,

            'id' => $data['category_image'] 
        ];

        $data['category_image_mobile'] = [

            'path' => Index::get_image_path($data['category_image_mobile']) ,

            'id' => $data['category_image_mobile'] 
        ];
        
        $parent = self::where('category_ID', $data['parent_ID'])->first();

        $parent ? $parent = $parent->toArray() : '';

        $data['parent_ID'] = $parent;

        $cond = session()->has('lang_id') && session('lang_id') != 1;

        if( $cond ) :

            $where = [['taxonomy_id',2147483647],['terms_id',$data['category_ID']],['meta_key','category_title'],['lang',session('lang_id')]];

            $checkcat = Termmeta::where($where)->pluck('meta_value')->first();
            
            $checkcat != '' ? $data['category_title'] = $checkcat : '';

        endif;

        return $data;
    }

    public static function getParentID($id){

        $data = self::where('category_ID', $id)->first()->toArray();

        if( $data['parent_ID'] == 0 )

            return $id;

        $parent = self::where('category_ID', $data['parent_ID'])->first();

        $parent ? $parent = $parent->toArray() : '';

        if( $parent['parent_ID'] == 0 )

            return $parent['category_ID'];
        
        $parent = self::where('category_ID', $parent['parent_ID'])->first();

        $parent ? $parent = $parent->toArray() : '';

        return $parent['category_ID'];

    }
    public static function getRecursive($id,$parent = 0){

        if( $parent == 0) :

            $categories = self::where([['parent_ID',0]])->where(function ($query) {
        $query->where('is_hidden', '!=', '1')
              ->orWhereNull('is_hidden');
    })
    ->where(function ($query) {
        $query->where('status', '!=', 'inactive')
              ->orWhereNull('status');
    })->whereNotIn('parent_ID',[18,13])->whereNotIn('category_ID',[18,13])->get();

        else :

            $categories = self::where([['parent_ID',$parent]])    ->where(function ($query) {
        $query->where('is_hidden', '!=', '1')
              ->orWhereNull('is_hidden');
    })
    ->where(function ($query) {
        $query->where('status', '!=', 'inactive')
              ->orWhereNull('status');
    })->get();

        endif;

        $categories ? $categories = $categories->toArray() : ''; 

        $check = ProductsToCategories::where('product_ID',$id)->pluck('category_ID');

        $check ? $check = $check->toArray() : ''; 

        $arr = $categories;

        $cond = session()->has('lang_id') && session('lang_id') != 1;

        foreach( $arr as &$cat ) :

            if( $cond ) :

                $where = [['taxonomy_id',2147483647],['terms_id',$cat['category_ID']],['meta_key','category_title'],['lang',session('lang_id')]];

                $checkcat = Termmeta::where($where)->pluck('meta_value')->first();
                
                $checkcat != '' ? $cat['category_title'] = $checkcat : '';

            endif;

            $cat['checked'] = in_array( $cat['category_ID'], $check ) ? 1 : 0;
            $catSlug = 'category/' . $cat['categories_slug'];
            if(Str::contains(request()->url(), $catSlug))
            {
                $cat['active'] = true;
            }
            $children = self::where('parent_ID',$cat['category_ID'] )    ->where(function ($query) {
        $query->where('is_hidden', '!=', '1')
              ->orWhereNull('is_hidden');
    })
    ->where(function ($query) {
        $query->where('status', '!=', 'inactive')
              ->orWhereNull('status');
    })->get();

            $children ? $children = $children->toArray() : ''; 

            $cat['children'] = $children;

            foreach( $cat['children'] as &$subchild ) :

                if( $cond ) :

                    $where = [['taxonomy_id',2147483647],['terms_id',$subchild['category_ID']],['meta_key','category_title'],['lang',session('lang_id')]];

                    $checkcat = Termmeta::where($where)->pluck('meta_value')->first();

                    $checkcat != '' ? $subchild['category_title'] = $checkcat : '';

                endif;

                $subchild['checked'] = in_array( $subchild['category_ID'], $check ) ? 1 : 0;

                $subchild['count'] = ProductsToCategories::where('category_ID',$subchild['category_ID'])->count();

            endforeach;

        endforeach;
        return $arr;
    }

    public static function getHomeCategories($ids){

        $categories = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'categories.category_image')
        ->select('categories.*', 'categoryTable.path as category_image')
        ->whereIn('categories.category_ID',$ids)->where('categories.category_type','category')
        ->groupBy('categories.category_ID')
        ->get()
        ->toArray();

        if( session()->has('lang_id')  && session('lang_id') != 1 ) :

            foreach($categories as &$cat):

                $cat['category_title'] = Termmeta::where([['taxonomy_id',2147483647],['terms_id',$cat['category_ID']],['meta_key','category_title'],['lang',session('lang_id')]])->pluck('meta_value')->first();

            endforeach;

        endif;

        return $categories;
    }

    public static function getHomeCategory($id){

        $category = self::where('category_ID',$id)->where('category_type','category')->first();

        $category ? $category = $category->toArray() : ''; 

        $cond = session()->has('lang_id')  && session('lang_id') != 1;

        if( $cond ) :

            $category['category_title'] = Termmeta::where([['taxonomy_id',2147483647],['terms_id',$category['category_ID']],['meta_key','category_title'],['lang',session('lang_id')]])->pluck('meta_value')->first();

        endif;

        $category['category_image'] = Index::get_image_path($category['category_image']);

        $category['children'] = self::getChildren($id);

        return $category;

    }

    public static function getHomeCatBrands($cat){

        $ids = unserialize($cat);

        $categories = self::whereIn('category_ID',$ids)->where('category_type','category')->get();

        $categories ? $categories = $categories->toArray() : ''; 

        foreach( $categories as $key => &$cat ) :

            $brands = CategoriesToBrands::where('category_ID',$cat['category_ID'])->pluck('brand_ID');

            $brands ? $brands = $brands->toArray() : '';

            if( !empty($brands) ) :

                $brands = Brands::whereIn('brand_ID',$brands)->limit(3)->get();

                $brands ? $brands = $brands->toArray() : ''; 

                foreach( $brands as &$brand ) :

                    $brand['brand_image'] = Index::get_image_path($brand['brand_image']);

                    if( $brand['featured_product'] ) : 

                        $brand['featured_product'] = Products::where('ID',$brand['featured_product'])->first();

                        $brand['featured_product']->prod_image = Index::get_image_path($brand['featured_product']->prod_image);

                    endif;

                endforeach;

                $cat['brands'] = $brands;

            else :

                unset( $categories[$key]);

            endif;

        endforeach;

        return $categories;
    }


    public static function getChildren($parentId)
    {
        $children = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'categories.category_image')
        ->select('categories.*', 'categoryTable.path as category_image')
        ->where('categories.parent_ID', $parentId)->where('categories.category_type','category')
        ->groupBy('categories.category_ID')
        ->get();

        $children ? $children = $children->toArray() : '';

        if( session()->has('lang_id')  && session('lang_id') != 1 ) :

            foreach($children as &$cat):

                $cat['category_title'] = Termmeta::where([['taxonomy_id',2147483647],['terms_id',$cat['category_ID']],['meta_key','category_title'],['lang',session('lang_id')]])->pluck('meta_value')->first();

            endforeach;

        endif;

        return $children;
    }

}
