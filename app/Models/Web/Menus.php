<?php

namespace App\Models\Web;
use Illuminate\Database\Eloquent\Model;
use App\Models\Web\Categories;
use App\Models\Core\Postmeta;

class Menus extends Model{

    protected $table = 'menus';

    public static function getMenu($type = 'main'){
        $menus = self::where([['parent_id',0],['menu',$type]])->orderBy('sort_order','asc')->where('status','1')->get();

        $menus ? $menus = $menus->toArray() : '';

        foreach( $menus as &$menu ):

            $cond = session()->has('lang_id') && session('lang_id') != 1;
            if( $cond  ) :

                $menu['menu_title'] = Postmeta::where([['posts_id',$menu['id']],['meta_key','menu_title'],['lang',session('lang_id')]])->pluck('meta_value')->first();

            endif;

            $menu['type'] == 2 ? $menu['link'] = Categories::where('category_ID',$menu['page_id'])->pluck('categories_slug')->first() : '';

            if( isset( $menu['id'] ) ) :

                $childmenus = self::where('parent_id', $menu['id'])->orderBy('sort_order','asc')->get();

                $childmenus ? $childmenus = $childmenus->toArray() : '';

                foreach($childmenus as &$child) :

                    if( $cond  ) :

                        $child['menu_title'] = Postmeta::where([['posts_id',$child['id']],['meta_key','menu_title'],['lang',session('lang_id')]])->pluck('meta_value')->first();

                    endif;

                endforeach;

                $menu['children'] = $childmenus;

            endif;

        endforeach;
        return $menus;
    }
}
