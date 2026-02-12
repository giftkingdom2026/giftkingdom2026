<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Categories;
use App\Models\Core\CategoriesToBrands;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\Termmeta;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Models\Core\Images;
use Route;
class CategoriesController extends Controller
{
    public function list(Request $request){

        $type = str_contains(Route::current()->uri, 'deals') ? 'deals' : 'category';
$perPage = $request->input('length', 10);
$search = $request->input('search');
        $title = ['pageTitle' => 'Category'];

        $data = Categories::list($type, 0, 0, 0, null, $perPage, $search);

        return view("admin.categories.index",$title)->with('data', $data);

    }

    public function ajax(Request $request){

        $type = str_contains(Route::current()->uri, 'deals') ? 'deals' : 'category';

        return Categories::ajax($request->all(),$type);

    }

    public function insert(Request $request){

        $type = str_contains(Route::current()->uri, 'deals') ? 'deals' : 'category';

        $data = $request->all();

        if( isset( $data['meta'] ) ) :

            $meta = $data['meta'];

            unset($data['meta']);

        endif;

        $cat = Categories::addCategory($data,$type);

        if( isset( $meta ) ) :

            $meta = array_filter($meta);

            Termmeta::where([['taxonomy_id',2147483647,],['terms_id',$cat->id]])->delete();

            foreach($meta as $key => $val ) :

                Termmeta::insert([

                    'taxonomy_id' => 2147483647,

                    'terms_id' => $cat->id,

                    'meta_key' => $key,

                    'meta_value' => $val

                ]);

            endforeach;

        endif;

        $data = Categories::list($type);

        return view('admin.categories.table')->with('data',$data)->with('success','Category Added Successfully!');
    }

    public function showChildren(Request $request){

        $type = str_contains(Route::current()->uri, 'deals') ? 'deals' : 'category';

        $data = Categories::list( $type, $request->ID , $request->parent,0,null,250);

        return view('admin.categories.table')->with('data',$data);

    }

    public function edit(Request $request){

        $data = Categories::getCategory($request->id);

        $lang = 1;

        $meta = Termmeta::where([['taxonomy_id',2147483647],['terms_id',$request->id],['lang',$lang]])->get();
        
        $meta ? $meta = $meta->toArray() : '';

        $arr = [];

        foreach($meta as $m) :

            $arr[$m['meta_key']] = $m['meta_value'];

        endforeach;

        $data['meta'] = $arr;

        return view('admin.categories.edit')->with('data',$data);
    }

    public function changeLang(Request $request){

        $lang = $request->lang;

        $data = Categories::getCategory($request->id);

        $meta = Termmeta::where([['taxonomy_id',2147483647],['terms_id',$request->id],['lang',$lang]])->get();
        
        $meta ? $meta = $meta->toArray() : '';

        $arr = [];

        foreach($meta as $m) :

            $arr[$m['meta_key']] = $m['meta_value'];

        endforeach;

        $data['meta'] = $arr;

        return view('admin.categories.fields')->with('data',$data)->render();

    }

    public function update(Request $request){

        $data = $request->all();

        $data['lang'] != 1 ? $data['meta']['category_title'] = $data['category_title'] : '';

        if( isset( $data['meta'] ) ) :

            $data['meta'] = array_filter($data['meta']);

            Termmeta::where([['taxonomy_id',2147483647,],['terms_id',$data['category_ID']],['lang',$data['lang']]])->delete();

            foreach($data['meta'] as $key => $val ) :

                Termmeta::insert([

                    'taxonomy_id' => 2147483647,

                    'terms_id' => $data['category_ID'],

                    'meta_key' => $key,

                    'meta_value' => $val,

                    'lang' => $data['lang']

                ]);

            endforeach;

            unset($data['meta']);

        endif;

        unset($data['_token']);
        
        $type = str_contains(Route::current()->uri, 'deals') ? 'deals' : 'category';

        if( $data['lang'] != 1 ) :

            unset($data['category_title']);

        endif;

        unset($data['lang']);

        Categories::where('category_ID',$data['category_ID'])->update($data);

        return redirect()->back()->with('success', ucwords($type).' updated successfully' );
    }

    public function delete(Request $request){

        $uri = str_contains(Route::current()->uri, 'deals') ? 'deals' : 'category';

        Categories::where('category_ID',$request->id)->delete();

        Categories::where('parent_ID',$request->id)->update(['parent_ID'=>0]);

        ProductsToCategories::where('category_ID',$request->id)->delete();
        
        CategoriesToBrands::where('category_ID',$request->id)->delete();

        return redirect()->back()->with('success', ucwords($uri).' deleted successfully' );
    }
}
