<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Brands;
use App\Models\Core\Products;
use App\Models\Core\Setting;
use App\Models\Web\Index;
use App\Models\Core\ProductsToBrands;
use App\Models\Core\CategoriesToBrands;
use App\Models\Core\Categories;
use Illuminate\Http\Request;
use App\Models\Core\Manufacturers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;

class BrandsController extends Controller {

public function list(Request $request)
{
    $id = $request->input('cat', null);
    $perPage = $request->input('length', 10);
    $search = $request->input('s', null);

    $products = Products::where([
        ['prod_type', '!=', 'variation'],
        ['prod_status', 'active']
    ])->get()->toArray();

    $data['products'] = $products;
    $data['brands'] = Brands::list($id, 0, $perPage, $search);
    $data['cat'] = $id;

    return view('admin.brands.index')->with('data', $data);
}



    public function insert(Request $request){

        Brands::addBrand($request->all());

        $data['brands'] = Brands::list($request->category_ID);

        return view('admin.brands.table')->with('data',$data);
    }

    public function edit(Request $request){

        $brand = Brands::where('brand_ID',$request->id)->first();

        $brand ? $brand = $brand->toArray() : '';

        $brand['brand_image'] = ['id' => $brand['brand_image'], 'path' => Index::get_image_path($brand['brand_image']) ];

        $cat = CategoriesToBrands::where('brand_ID',$request->id)->first();
        
        $cat ? $cat = $cat->toArray() : '';

        if(!empty($cat)) :

            $cat['title'] = Categories::where('category_ID',$cat['category_ID'])->pluck('category_title')->first();

        endif;

        $brand['cat'] = $cat;

        $data['brand'] = $brand;

        $products = ProductsToBrands::where('brand_ID',$request->id)->pluck('product_ID');

        $products = Products::whereIn('ID',$products)->get();

        $products ? $products = $products->toArray() : '';

        $data['products'] = $products;

        return view('admin.brands.edit')->with('data',$data);
    }


    public function update(Request $request){

        $data = $request->all();

        $cat = isset($data['category_ID']) ? $data['category_ID'] : null;

        if(isset($data['category_ID'])) : unset($data['category_ID']); endif;

        unset($data['_token']);

        Brands::where('brand_ID',$data['brand_ID'])->update($data);

        if( $cat ) :

            CategoriesToBrands::where('brand_ID',$data['brand_ID'])->delete();

            CategoriesToBrands::insert($cat,$data['brand_ID']);

        endif;
        
        return redirect()->back()->with('success','Brand updated successfully!');

    }

    public function delete(Request $request){

        Brands::where('brand_ID',$request->id)->delete();

        ProductsToBrands::where('brand_ID',$request->id)->delete();
        
        CategoriesToBrands::where('brand_ID',$request->id)->delete();

        return redirect()->back()->with('success','Brand deleted successfully!');

    }
}
