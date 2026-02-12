<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\Products;
use App\Models\Web\Index;

class Categories extends Model{

    protected $table = 'categories';

    protected $guarded = [];

    use Sortable;
    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function categories_description(){
        return $this->beliesngsTo('App\Categories_description');
    }

public static function list($type, $id = 0, $parent = 0, $active = 0, $filter = null, $perpage = 10, $search = null)
{
    // Build base query
    $query = self::where([
        ['parent_ID', $id],
        ['category_type', $type]
    ])->orderBy('created_at','DESC');

    // Apply search filter if provided
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('category_title', 'like', "%$search%")
              ->orWhere('categories_slug', 'like', "%$search%");
        });
    }

    // Apply pagination with appends for consistent links
    $categories = $query->paginate($perpage)->appends([
        'length' => $perpage,
        'search' => $search
    ]);

    // Convert pagination object to array
    $categoriesArray = $categories ? $categories->toArray() : [];

    $arr['categories'] = $categoriesArray['data'];

    // Process each top-level category
    foreach ($arr['categories'] as &$cat) {
        // Get children
        $children = self::where('parent_ID', $cat['category_ID'])->get();
        $childrenArray = $children ? $children->toArray() : [];

        // Add image path
        $cat['category_image'] = [
            'path' => Index::get_image_path($cat['category_image']),
            'id' => $cat['category_image']
        ];

        // Mark as active if applicable
        if ($active == $cat['category_ID']) {
            $cat['active'] = true;
        }

        $cat['children'] = $childrenArray;

        // Process second-level children
        foreach ($cat['children'] as &$subchild) {
            $subchildren = self::where('parent_ID', $subchild['category_ID'])->get();
            $subchildrenArray = $subchildren ? $subchildren->toArray() : [];

            $subchild['category_image'] = [
                'path' => Index::get_image_path($subchild['category_image']),
                'id' => $subchild['category_image']
            ];

            if ($active == $subchild['category_ID']) {
                $subchild['active'] = true;
                $cat['active'] = true;
            }

            // Process third-level children
            foreach ($subchildrenArray as &$lastchild) {
                $lastchild['category_image'] = [
                    'path' => Index::get_image_path($lastchild['category_image']),
                    'id' => $lastchild['category_image']
                ];

                if ($active == $lastchild['category_ID']) {
                    $lastchild['active'] = true;
                    $subchild['active'] = true;
                    $cat['active'] = true;
                }
            }

            $subchild['children'] = $subchildrenArray;
        }
    }

    $arr['has_children'] = ($id != 0);
    $arr['parent'] = $parent;

    // Modify pagination links — replace 'create' with 'list'
    if (isset($categoriesArray['links']) && is_array($categoriesArray['links'])) {
        foreach ($categoriesArray['links'] as &$link) {
            if (isset($link['url']) && strpos($link['url'], 'create') !== false) {
                $link['url'] = str_replace('create', 'list', $link['url']);
            }
        }
    }

    return [
        'list' => $arr,
        'cat' => $categoriesArray
    ];
}



    public static function getCategory($id){

        $data = self::where('category_ID', $id)->first()->toArray();

        $data['category_image'] = [

            'path' => Index::get_image_path($data['category_image']) ,

            'id' => $data['category_image'] 
        ];
        $parent = self::where('category_ID', $data['parent_ID'])->first();

        $parent ? $parent = $parent->toArray() : '';

        $data['parent_ID'] = $parent;

        return $data;
    }
    
    public static function getCategoryForSearch($ids,$keyword){
        // dd($ids);
        $data = self::whereIn('category_ID', $ids)->get();
        // dd($data);
        $parentData = [];
        foreach ($data as $parent) {
            if ($parent->parent_ID == 0) {

                $child = self::where('parent_ID', '!=', '0')
                    ->where(function ($query) use ($keyword) {
                    $query->where('category_title', 'like', "%" . $keyword . "%")
                          ->orWhere('category_title', 'like', "%" . str_replace(' ', '%', $keyword) . "%");
                          $words = explode(" ", $keyword);
                          foreach($words as $word){
                            $new_w=str_replace(' ', '', $word);
                            $query->orWhere('category_title', 'like',"%".$new_w."%");
                            // dd($new_w);
                        }
                })->get();
                if(count($child) == 0){
                    $child = self::where('parent_ID', $parent->category_ID)->get();

                }

                $parent->child = $child;
            }
                $parentData[] = $parent;
        }
        // dd($parentData);
        return $parentData;
    }

    public static function addCategory($data,$type){

        unset($data['_token']);

        $order = self::max('sort_order');

        $order = $order != null ? ($order + 1) : 0; 

        isset( $data['parent_ID'] ) ? $parent = $data['parent_ID'] : $parent = 0;

        $cat = self::create([

            'category_title' => $data['category_title'],
            'categories_slug' => $data['categories_slug'],
            'is_hidden' => $data['is_hidden'],
            'parent_ID' => $parent,
            'category_image' => $data['category_image'],
            'sort_order' => $order,
            'category_type' => $type,
            'status' => $data['status'],

        ]);

        return $cat;
    }       

    public static function getRecursive( $id){

        $categories = self::where([['parent_ID',0]])->get();

        $categories ? $categories = $categories->toArray() : ''; 

        $check = ProductsToCategories::where('product_ID',$id)->pluck('category_ID');

        $check ? $check = $check->toArray() : ''; 

        $arr = $categories;

        foreach( $arr as &$cat ) :

            $cat['checked'] = in_array( $cat['category_ID'], $check ) ? 1 : 0;

            $children = self::where('parent_ID',$cat['category_ID'] )->get();

            $children ? $children = $children->toArray() : ''; 

            $cat['children'] = $children;

            foreach( $cat['children'] as &$subchild ) :

                $subchild['checked'] = in_array( $subchild['category_ID'], $check ) ? 1 : 0;

                $subchildren = self::where('parent_ID',$subchild['category_ID'] )->get();

                $subchildren ? $subchildren = $subchildren->toArray() : ''; 

                $subchild['children'] = $subchildren;

                foreach( $subchild['children'] as &$last ):

                    $last['checked'] = in_array( $last['category_ID'], $check ) ? 1 : 0;

                endforeach;

            endforeach;

        endforeach;
        return $arr;
    }
    
    public static function assignOrCreate( $cat , $id){

        $check[0]['id'] = self::where([['category_title',$cat['category']],['parent_ID',0]])->pluck('category_ID')->first();
        
        $check[0]['title'] = $cat['category'];

        if( $cat['child']['category'] != '' ) :

            $check[1]['id'] = self::where([['category_title',$cat['child']['category']]])->pluck('category_ID')->first();

            $check[1]['title'] = $cat['child']['category'];

            if( $cat['child']['child'] != '' ) :

                $check[2]['id'] = self::where([['category_title',$cat['child']['child']]])->pluck('category_ID')->first();

                $check[2]['title'] = $cat['child']['child'];

            endif;

        endif;

        foreach( $check as $key => $category ) :

            $parent = isset($categories)  ? $categories[ $key - 1 ] : 0;

            if( !$category['id'] ) :

                $order = self::max('sort_order');

                $order = $order != null ? ($order + 1) : 0; 

                $parentcat = self::create([

                    'category_title' => $category['title'],
                    'categories_slug' => strtolower(str_replace(' ', '-', $category['title'])),
                    'parent_ID' => $parent,
                    'category_image' => 8570,
                    'sort_order' => $order,
                    'category_type' => 'category',

                ]);

                $categories[] = $parentcat->id;

            else :

                $categories[] = $category['id'];

            endif;

        endforeach;

        foreach( $categories as $catid ) :

            ProductsToCategories::create([

                'product_ID' => $id,

                'category_ID' => $catid,

            ]);

        endforeach;

    }

    public static function ajax( $data , $type ){

        $data = self::where([['category_title','like','%'.$data['search'].'%'],['category_type',$type]])->get();

        $data ? $data = $data->toArray() : '';

        $arr = [];

        foreach($data as $item) : 

            $arr[] = [ 'id' => $item['category_ID'], 'text' => $item['category_title'] ];

        endforeach;

        return json_encode($arr);
    }

    public static function updateOrder($data){

        foreach($data['category'] as $post):

            self::where('category_ID',$post['id'])->update(['sort_order' => $post['order']]);

        endforeach;

    }

    public static function getVendoreCategories($id){

        $products = Products::where('author_id',$id)->pluck('ID');

        $categories = ProductsToCategories::whereIn('product_ID',$products)->pluck('category_ID');

        $categories = self::whereIn('category_ID',$categories)->get();
        
        $categories ? $categories = $categories->toArray() : ''; 
        
        foreach( $categories as &$cat ) :

            $cat['category_image'] = Index::get_image_path($cat['category_image']);

        endforeach;

        return $categories;

    }

    public static function getChildren($parentId)
    {
        $children = self::where('parent_ID', $parentId)->get();
        $children ? $children = $children->toArray() : '';

        foreach ($children as &$child) {
            $child['children'] = self::getChildren($child['category_ID']);
        }

        return $children;
    }
}
