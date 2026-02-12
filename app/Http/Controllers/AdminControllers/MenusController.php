<?php

namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\Menus;
use App\Models\Web\Index;
use App\Models\Core\Categories;
use App\Models\Core\Pages;
use App\Models\Core\Posts;
use App\Models\Core\Postmeta;
use App\Models\Core\Content;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Megamenu;
use Lang;
use DB;

class MenusController extends Controller
{
    public function __construct(Setting $setting )
    {
        $this->Setting = $setting;
        
    }
    /*------------------------------------------------Menus-----------------------------------------*/
    public function menus(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.menus"));
        $result['menus'] = Menus::menus($request);  
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.menus.index", $title)->with('result', $result);
    }
    /*------------------------------------------------Add Menus-----------------------------------------*/



    public function megaMenu(Request $request){

        $menu = Megamenu::orderBy('sort_order','ASC')->get();

        $menu ? $menu = $menu->toArray() : '';
        
        foreach($menu as &$item) :

            $item['category_icon'] = Index::get_image_path($item['category_icon']);

            $cat = Categories::where('category_ID',$item['category_ID'])->first();
            
            $cat ? $cat = $cat->toArray() : '';

            $item['category_ID'] = $cat;

        endforeach;

        return view("admin.megamenu.index", ['pageTitle' => 'Mega Menu'])->with('menus', $menu);

    }

    public function megaAdd(Request $request){

        $result['categories'] = Categories::all()->toArray();

        $result['offers'] = Posts::where('post_type','offers')->get()->toArray();

        return view("admin.megamenu.add", ['pageTitle' => 'Add Mega Menu'])->with('result', $result);

    }       

    public function megaEdit(Request $request){

        $result['menu'] = Megamenu::where('ID',$request->id)->first()->toArray();

        $result['menu']['category_icon'] = ['path' => Index::get_image_path( $result['menu']['category_icon'] ), 'id' => $result['menu']['category_icon'] ];

        $result['categories'] = Categories::all()->toArray();

        $result['offers'] = Posts::where('post_type','offers')->get()->toArray();

        return view("admin.megamenu.edit", ['pageTitle' => 'Edit Mega Menu'])->with('result', $result);

    }

    public function megaCreate(Request $request){

        $data = $request->all();

        $data['category_icon'] = 11458;

        unset($data['_token']); 

        !isset($data['offers']) ? $data['offers'] = [] : '';

        $data['menu_offers'] = serialize($data['offers']); unset($data['offers']); $data['sort_order'] = 0;

        Megamenu::create($data);

        return redirect('admin/mega-menu')->with('success', 'Menu Added Successfully!');

    }

    public function megaUpdate(Request $request){

        $data = $request->all();

        !isset($data['offers']) ? $data['offers'] = [] : '';
        
        unset($data['_token']); $data['menu_offers'] = serialize($data['offers']); unset($data['offers']); $data['sort_order'] = 0;

        Megamenu::where('ID',$data['ID'])->update($data);

        return redirect()->back()->with('success', 'Menu Updated Successfully!');

    }

    public function deleteMega(Request $request){

        Megamenu::where('ID',$request->id)->delete();

        return redirect('admin/mega-menu')->with('success', 'Menu Deleted Successfully!');

    }
    public function addmenus(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.addmenus"));

        $result = Menus::addmenus();          

        $result['commonContent'] = $this->Setting->commonContent();

        $pages = Pages::all();  
        
        $categories = Categories::all();  

        $categories ? $categories = $categories->toArray() : '';

        $result['categories'] = $categories;

        $pages ? $pages = $pages->toArray() : '';

        foreach($pages as $key => &$page) :

            $page['page_title'] = current(Content::where([

                ['page_id', '=', $page['page_id']],
                ['content_key', '=','pagetitle']

            ])->pluck('content_value')->toArray());

        endforeach;

        $result['pages'] = $pages;

        return view("admin.menus.add", $title)->with('result', $result);
    }

    /*------------------------------------------------Add New Menus-----------------------------------------*/
    public function addnewmenu(Request $request)
    {
        $result['commonContent'] = $this->Setting->commonContent();

        $title = array('pageTitle' => Lang::get("labels.AddMenu"));
            $order = DB::table('menus')->max('sort_order') + 1;

    if ($request->type == 2) {
        $category = Categories::where('category_ID', $request->category)->first();
        $slug = $category ? $category->categories_slug : null;

        $link = asset('shop/category/') . '/' . $slug;

    } else {
        $link = $request->external_link  ?? $request->link;
    }
$alreadyExists = DB::table('menus')->where('menu', $request->menu)->where('link', $link)->first();
if($alreadyExists){
    return redirect()->back()->with('success','Menu Already Exists');
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
    $menu_id = DB::table('menus')->insertGetId($arr);

    return redirect()->back()->with('success','Menu Added Successfully');
}

    if ($request->type == 2) {
        $arr['page_id'] = $request->category;
    }



    }

    /*------------------------------------------------Edit Menus-----------------------------------------*/
    public function editmenu(Request $request, $id)
    {

        $title = array('pageTitle' => Lang::get("labels.EditPage"));

        $result['menus'] = Menus::editmenu($id);

        $pages = Pages::all();  

        $pages ? $pages = $pages->toArray() : '';

        foreach($pages as $key => &$page) :

            $page['page_title'] = current(Content::where([

                ['page_id', '=', $page['page_id']],
                ['content_key', '=','pagetitle']

            ])->pluck('content_value')->toArray());

        endforeach;

        $result['pages'] = $pages;

        $categories = Categories::all();  

        $categories ? $categories = $categories->toArray() : '';

        $result['categories'] = $categories;
        
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.menus.edit", $title)->with('result', $result);
    }

    function changeLang(Request $request){

        $title = Menus::langData($request->id,$request->lang);

        return view('admin.menus.fields')->with('title',$title)->render();
    } 


    /*------------------------------------------------Update Menus-----------------------------------------*/
    public function updatemenu(Request $request)
    {
        Menus::updatemenu($request);
        $message = Lang::get("labels.MenuUpdateMessage");
        return redirect()->back()->withErrors([$message]);

    }
    /*------------------------------------------------Delete Menus-----------------------------------------*/
    public function deletemenu(Request $request)
    {
        Menus::deletemenu($request->id);
        $message = Lang::get("labels.MenuDeleteMessage");
        return redirect()->back()->withErrors([$message]);
    }
    /*------------------------------------------------Postion Menus-----------------------------------------*/
    public function menuposition(Request $request)
    {

        Menus::savePosition($request);
    }
    /*------------------------------------------------Catalog Menus-----------------------------------------*/
    public function catalogmenu()
    {
        Menus::catalogmenu();
        $message = Lang::get("labels.Catalogcreatedsuccessfully");
        return redirect()->back()->withErrors([$message]);
    }    
    

}
