<?php

namespace App\Models\Core;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Core\Categories;
use App\Models\Core\Postmeta;
use DB;
use Illuminate\Database\Eloquent\Model;
use Lang;

class Menus extends Model
{
    protected $table = 'menus';

    public static function menus($request)
    {
        return Menus::recursiveMenu($request);
    }

    public static function recursiveMenu($request)
    {   

        $where = isset($request->type) ? [[ 'menu',$request->type ]] : [['menu','get-to-know-us']];

        $items = self::where($where)->orderBy('sort_order', 'ASC')->get();

        $ul = '';
        if ($items->isNotEmpty()) {
            $childs = array();
            foreach ($items as $item) {
                $childs[$item->parent_id][] = $item;
            }

            foreach ($items as $item) {
                if (isset($childs[$item->id])) {
                    $item->childs = $childs[$item->id];
                }
            }

            if (!empty($childs[0])) {
                $menus = $childs[0];
            } else {
                $menus = $childs;
            }

            $parent_id = 0;
            $ul = '<ul id="easymm" class="ui-sortable">';

            foreach ($menus as $parents) {

                if ($parents->status == 0) {
                    $status = '<span class="label label-success">' . Lang::get("labels.Active") . '</span>';
                } else {
                    $status = '<span class="label label-success">' . Lang::get("labels.Active") . '</span>';
                }

                $ul .= '<li id="menu-' . $parents->id . '" class="sortable">
                <div class="ns-row">
                <div class="ns-title">' . $parents->menu_title . '</div>
                <div class="ns-url" style="width:400px">' . $parents->link . '</div>
                <div class="ns-class">' . $status . '</div>
                <div class="ns-actions">';
                $ul .='<a href="editmenu/' . $parents->id . '" class="badge bg-light-blue edit-menu">
                <i class="fas fa-edit"></i>
                </a>';
                $ul .='<a id="deleteProductId" products_id="' . $parents->id . '" class="badge bg-red delete-menu">
                <i class="fa fa-trash" aria-hidden="true"></i>
                </a>';
                $ul .='<input type="hidden" name="menu_id" value="' . $parents->id . '">
                </div>
                </div>';

                if (isset($parents->childs)) {
                    $ul .= '<ul>';
                    $ul .= Menus::childcat($parents->childs, $parent_id);
                    $ul .= '</ul>';
                } else {
                    $ul .= '</li>';
                }
            }
            $ul .= '</ul>';

        }
        return $ul;
    }

    public static function childcat($childs, $parent_id)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            if ($child->status == 0) {
                $status = '<span class="label label-success">' . Lang::get("labels.Active") . '</span>';
            } else {
                $status = '<span class="label label-success">' . Lang::get("labels.Active") . '</span>';
            }
            $contents .= '
            <li id="menu-' . $child->id . '" class="sortable">
            <div class="ns-row">
            <div class="ns-title">' . $child->menu_title . '</div>
            <div class="ns-url"  style="width:400px">' . $child->link . '</div>
            <div class="ns-class">' . $status . '</div>
            <div class="ns-actions">
            <a href="editmenu/' . $child->id . '" class="badge bg-light-blue edit-menu">
            <i class="fas fa-edit"></i>
            </a>
            <a id="deleteProductId" products_id="' . $child->id . '" class="badge bg-red delete-menu">
            <i class="fa fa-trash" aria-hidden="true" ></i>
            </a>
            <input type="hidden" name="menu_id" value="' . $child->id . '">
            </div>
            </div>
            ';
            if (isset($child->childs)) {
                $contents .= '
                <ul>';
                $contents .= Menus::childcat($child->childs, $parent_id);
                $contents .= '</li></ul>';
            } else {
                $contents .= '</li>';
            }

        }
        return $contents;
    }

    public static function addmenus()
    {

        $result = array();

        $menus = self::where('parent_id', 0)->get();

        $result["menus"] = $menus;


        return $result;
    }

    

public static function addnewmenu($request)
{
    $order = DB::table('menus')->max('sort_order') + 1;

    if ($request->type == 2) {
        $category = Categories::where('category_ID', $request->category)->first();
        $slug = $category ? $category->categories_slug : null;

        $link = asset('shop/category/') . '/' . $slug;

    } else {
        $link = $request->external_link  ?? $request->link;
    }
$alreadyExists = DB::table('menus')->where('type', $request->type)->where('link', $link)->first();
if($alreadyExists){
    return redirect()->back()->with('error','Menu Already Exists');
}else{
    $arr = [
        'parent_id' => 0,
        'type' => $request->type,
        'status' => $request->status,
        'menu_title' => $request->menuName_1,
        'external_link' => $link,
        'link' => $link,
        'menu' => $request->menu,
        'sort_order' => $order
    ];
}

    if ($request->type == 2) {
        $arr['page_id'] = $request->category;
    }

    $menu_id = DB::table('menus')->insertGetId($arr);
}


    public static function editmenu($id)
    {

        $menus = self::where('id', $id)->first()->toArray();

        return $menus;
    }

    public static function langData($id,$lang){

        if($lang == 1) :

            $title = self::where('id', $id)->pluck('menu_title')->first();

        else :

            $title = Postmeta::where([['posts_id',$id],['meta_key','menu_title'],['lang',$lang]])->pluck('meta_value')->first();

        endif;

        return $title;
    }

public static function updatemenu($request)
{
    $data = $request->all();
    $menu_id = $request->id;

    // Determine the link
    if ($request->type == 2) {
        $category = Categories::where('category_ID', $request->category)->first();
        $slug = $category ? $category->categories_slug : null;
        $link = asset('shop/category') . '/' . $slug;
    } else {
        $link = $request->link ?? $request->external_link;
    }

    // Prepare the update array
    $arr = [
        'type' => $request->type,
        'external_link' => $link,
        'status' => $request->status,
        'link' => $link,
        'menu' => $request->menu,
    ];

    // Handle multilingual title
    if ($request->lang == 1) {
        $arr['menu_title'] = $request->menu_title;
    } else {
        Postmeta::updateOrCreate([
            'posts_id' => $menu_id,
            'meta_key' => 'menu_title',
            'lang' => $request->lang,
        ], [
            'posts_id' => $menu_id,
            'meta_key' => 'menu_title',
            'lang' => $request->lang,
            'meta_value' => $request->menu_title
        ]);
    }

    // Set page_id if it's a category-based menu
    if ($request->type == 2) {
        $arr['page_id'] = $request->category;
    }

    // Update the menu record
    self::where('id', $menu_id)->update($arr);
}


    public static function deletemenu($id)
    {
        DB::table('menus')->where('id', $id)->delete();
    }

    public static function savePosition($request)
    {
        $sort_order = 1;
        foreach ($request->menu as $key => $value) {
            $menu_id = $key;
            if ($value == null) {
                $parent_id = 0;
            } else {
                $parent_id = $value;
            }

            if ($parent_id > 0) {
                $sort_order2 = 0;
            }

            DB::table('menus')->where('id', '=', $menu_id)->update([
                'parent_id' => $parent_id,
                'sort_order' => $sort_order,
            ]);

            $sort_order++;

        }
    }

    public static function catalogmenu(){
        $language = new SiteSettingController();
        $languages = $language->getLanguages();
        $items = DB::table('categories')
        ->leftJoin('image_categories', 'categories.categories_icon', '=', 'image_categories.image_id')
        ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
        ->select('categories.categories_id', 'image_categories.path as image_path', 'categories.categories_slug as slug', 'categories_description.categories_name', 'categories.parent_id')
        ->where('categories_description.language_id', '=', 1)
        ->groupBy('categories.categories_id')
        ->get();
        $contents = '';
        
        if ($items->isNotEmpty()) {
            $childs = array();
            foreach ($items as $item) {
                $childs[$item->parent_id][] = $item;
            }

            foreach ($items as $item) {
                if (isset($childs[$item->categories_id])) {
                    $item->childs = $childs[$item->categories_id];
                }
            }

            $categories = $childs[0];
            
                // insert menu named as catalog                
            $order = DB::table('menus')->max('sort_order');
            $order = $order + 1;

            $parent_menu_id = DB::table('menus')->insertGetId([
                'parent_id' => 0,
                'type' => '3',
                'status' => 1,
                'external_link' => '',
                'link' => '#',
                'sort_order' => $order,
                'page_id' => '',
            ]);



            foreach ($languages as $languages_data) {
                DB::table('menu_translation')->insert([
                    'menu_id' => $parent_menu_id,
                    'language_id' => $languages_data->languages_id,
                    'menu_name' => 'Catalog',
                ]);
            }
            

            foreach ($categories as $parents) {
                    //insert parent record

                $order = DB::table('menus')->max('sort_order');
                $order = $order + 1;

                $menu_id = DB::table('menus')->insertGetId([
                    'parent_id' => $parent_menu_id,
                    'type' => '3',
                    'status' => 1,
                    'external_link' => '',
                    'link' => $parents->slug,
                    'sort_order' => $order,
                    'page_id' => '',
                ]);

                foreach ($languages as $languages_data) {

                        //get detail of categories
                    $description = DB::table('categories_description')
                    ->where('categories_description.language_id','=', $languages_data->languages_id )
                    ->where('categories_id','=', $parents->categories_id )
                    ->first();

                    if($description){
                        DB::table('menu_translation')->insert([
                            'menu_id' => $menu_id,
                            'language_id' => $languages_data->languages_id,
                            'menu_name' => $description->categories_name,
                        ]);   
                    }

                }





                if (isset($parents->childs)) {
                 Menus::childInsert($parents->childs, $menu_id);
             }

         }

         return '';

     }
     return $contents;
 }


 public static function childInsert($childs, $parent_id)
 {
    $language = new SiteSettingController();
    $languages = $language->getLanguages();
    $contents = '';
    foreach ($childs as $key => $child) {


                //dd($child);
        $order = DB::table('menus')->max('sort_order');
        $order = $order + 1;

        $menu_id = DB::table('menus')->insertGetId([
            'parent_id' => $parent_id,
            'type' => '3',
            'status' => 1,
            'external_link' => '',
            'link' => $child->slug,
            'sort_order' => $order,
            'page_id' => '',
        ]);

        foreach ($languages as $languages_data) {

                //get detail of categories
            $description = DB::table('categories_description')
            ->where('categories_description.language_id','=', $languages_data->languages_id )
            ->where('categories_id','=', $child->categories_id )
            ->first();

            if($description){
                DB::table('menu_translation')->insert([
                    'menu_id' => $menu_id,
                    'language_id' => $languages_data->languages_id,
                    'menu_name' => $description->categories_name,
                ]);   
            }

        }




        if (isset($child->childs)) {
            $contents .= Menus::childInsert($child->childs, $menu_id);
        } 

    }
    return $contents;
}




public static function catalogmenuold()
{
    $language_id = 1;
    $language = new SiteSettingController();
    $languages = $language->getLanguages();
    $myVar = new Categories();
    $categories = $myVar->getter($language_id);
    if(!empty($categories)  and count($categories)>0){
            //check catalog exist
        $menus = DB::table('menus')
        ->leftJoin('menu_translation', 'menu_translation.menu_id', '=', 'menus.id')
        ->where([
            ['menu_translation.language_id', '=', 1],
            ['menus.type', '=', 3],
            ['menu_translation.menu_name', '=', 'Catalog']
        ])
        ->first();

        if($menus){
            $parent_menu_id = $menus->id;
        }else{

                // insert menu named as catalog

            $order = DB::table('menus')->max('sort_order');
            $order = $order + 1;

            $parent_menu_id = DB::table('menus')->insertGetId([
                'parent_id' => 0,
                'type' => '3',
                'status' => 1,
                'external_link' => '',
                'link' => '#',
                'sort_order' => $order,
                'page_id' => '',
            ]);



            foreach ($languages as $languages_data) {
                DB::table('menu_translation')->insert([
                    'menu_id' => $parent_menu_id,
                    'language_id' => $languages_data->languages_id,
                    'menu_name' => 'Catalog',
                ]);
            }
        }

        foreach ($languages as $languages_data) {
            foreach($categories as $category){

                    //check exist 
                $menus = DB::table('menus')
                ->where([
                    ['menus.type', '=', 3],
                    ['menus.link', '=', $category->slug],
                ])
                ->first();

                if(!$menus){

                    if($category->parent_id == 0){
                        $parent_id =  $parent_menu_id;
                    }else{
                        $parent_id =  $menu_id;
                    }

                    $order = DB::table('menus')->max('sort_order');
                    $order = $order + 1;

                    $menu_id = DB::table('menus')->insertGetId([
                        'parent_id' => $menu_id,
                        'type' => '3',
                        'status' => 1,
                        'external_link' => '',
                        'link' => $category->slug,
                        'sort_order' => $order,
                        'page_id' => '',
                    ]);

                    foreach ($languages as $languages_data) {

                                //get detail of categories
                        $description = DB::table('categories_description')
                        ->where('categories_description.language_id','=', $languages_data->languages_id )
                        ->where('categories_id','=', $category->id )
                        ->first();

                        if($description){
                            DB::table('menu_translation')->insert([
                                'menu_id' => $menu_id,
                                'language_id' => $languages_data->languages_id,
                                'menu_name' => $description->categories_name,
                            ]);   
                        }

                    }

                }

            }
        }
    }
}

}
