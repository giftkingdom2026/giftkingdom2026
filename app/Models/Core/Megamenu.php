<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Categories;
use App\Models\Core\Products;
use App\Models\Core\Brands;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\Posts;
use App\Models\Web\Index;

class Megamenu extends Model
{

    public $table = 'megamenu';

    public $guarded =[];

    public static function updateOrder($data){

        foreach($data['megamenu'] as $post):

            self::where('ID',$post['id'])->update(['sort_order' => $post['order']]);

        endforeach;

    }

    public static function getMenu(){

        $menu = self::orderBy('sort_order','ASC')->get()->toArray();

        foreach( $menu as &$item ) :

            $arr = Categories::select('category_ID','categories_slug','category_title','category_image')->where('category_ID',$item['category_ID'])->first();

            $arr ? $arr = $arr->toArray() : '';
            if(isset($arr['category_ID'])){
                    $children = Categories::where('parent_ID',$arr['category_ID'] )->get();
            }else{
                $children = [];
            }

            $children ? $children = $children->toArray() : ''; 

            $arr['children'] = $children;

            foreach( $arr['children'] as &$subchild ) :

                $subchildren = Categories::where('parent_ID',$subchild['category_ID'] )->get();

                $subchild['count'] = ProductsToCategories::where('category_ID',$subchild['category_ID'])->count();


                foreach($subchildren as $key => $val) :

                endforeach;

                $subchildren ? $subchildren = $subchildren->toArray() : ''; 

                $subchild['children'] = $subchildren;

            endforeach;

            $item['brands'] = Brands::list($item['category_ID']);

            if( !empty($item['menu_offers']) ) : 

                $item['menu_offers'] = unserialize( $item['menu_offers'] );
                // $item['menu_offers'] = Index::getOffers($item['menu_offers']);

            endif;


            $item['category_ID'] = $arr;

        endforeach;

        return $menu;
    }
}