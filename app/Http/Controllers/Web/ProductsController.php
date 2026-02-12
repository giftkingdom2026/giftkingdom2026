<?php
namespace App\Http\Controllers\Web;

use App\Models\Web\Currency;
use App\Models\Web\Wishlist;
use App\Models\Web\Index;
use App\Models\Web\Reviews;
use App\Models\Core\VariationsToAttributeValues;
use App\Models\Core\CategoriesToAttributes;
use App\Models\Web\Products;
use App\Models\Core\ProductsToBrands;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\Attributes;
use App\Models\Web\Categories;
use App\Models\Core\Termmeta;
use App\Models\Core\Postmeta;
use App\Models\Web\Comments;
use App\Models\Web\SearchAnalytics;
use App\Models\Core\Brands;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Route;
use Session;
use App\Models\Core\Content;
use App\Models\Core\Pages;
class ProductsController extends Controller
{

    public function shop(Request $request){

        $category = $deal = 0;

        $breadcrumb = $brand =[];
        
        $meta = [];
        
        $result = Products::getProductsForShop($request);

        isset( $result['category'] ) ? $category = $result['category'] : '';
        
        $catdata = isset( $result['category'] ) ? Categories::getCategory($result['category']) : [];
        
        isset( $result['deal'] ) ? $deal = $result['deal'] : '';

        isset( $result['brand'] ) ? $brand = $result['brand'] : '';

        $keywords = isset($result['keyword']) ? $result['keyword'] : '';
        
        $result = $result['products'];
        
        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        if( $result ) :

            foreach( $result['data'] as &$item ) :

                if( $lang != 1 ) :

                    $checkmeta = Postmeta::where([['posts_id',$item['ID']],['lang',$lang],['meta_key','prod_title']])->pluck('meta_value')->first();

                    $item['prod_title'] = $checkmeta ?? $item['prod_title'];

                endif;
if( $lang != 1 ){
                                        $image = Postmeta::where([['posts_id',$item['ID']],['lang',$lang],['meta_key','prod_image']])->pluck('meta_value')->first();
    if($image){

        $item['prod_image'] = Index::get_image_path($image);
    }else{
            $item['prod_image'] = Index::get_image_path($item['prod_image']);

    }

}else{
    $item['prod_image'] = Index::get_image_path($item['prod_image']);
}

                if( $item['prod_type'] == 'variable' ) :

                    // $variation = Products::getFirstVariation($item['ID']);
                    $variation = Products::getMinimumPriceVariation($item['ID']);

                // $item['default_variation'] = $variation['ID'];

                    $item['sale_price'] = $variation['sale_price'];

                    $item['prod_price'] = $variation['prod_price'];

                    $item['price'] = Products::getPrice($variation);

                else :

                    $item['price'] = Products::getPrice($item);

                endif;

                $item['discount'] = Products::getDiscount($item);
                
            endforeach;

        endif;

        $filter['brands'] = Brands::getBrandsFilter($brand);

        $filter['categories'] = Categories::getRecursive($category);

        $filter['recipients'] = Categories::getRecursive($category,18);
        
        $filter['occassions'] = Categories::getRecursive($category,13);
        $category != 0 ? $meta = Termmeta::getTermmeta($category,true)  : '';        
        $category == 0 ? $category = null : $category = Categories::getParentID($category);

        $category != 0 ? $filter['attributes'] = CategoriesToAttributes::getData($category)  : '';

        if( str_contains( Route::current()->uri, 'category' ) ) :

            foreach( $filter['categories']  as $fitem ) :

                if( isset( $fitem['active'] ) ) :

                    $breadcrumb[] = $fitem;

                endif;

            endforeach;

        endif;
$category = Route::current()->parameter('category');

if (in_array($category, ['subscription', 'events', 'executive-gifting'])) {
    return redirect('shop');
}

        if( isset($keywords) ) :

            $filter['keywords'] = $keywords;

        else :

            $filter['keywords'] = isset( $request->keywords ) && $request->keywords != '' ? $request->keywords : '';

        endif;

        $activefilters = self::getActiveFilters($filter);

$page = Pages::where('slug', 'shop')->first();

$lang = session()->has('lang_id') ? session('lang_id') : 1;

$content = Content::where([
    ['page_id', $page->page_id],
    ['lang', $lang]
])->get();

if ($content->isEmpty() && $lang != 1) {
    $content = Content::where([
        ['page_id', $page->page_id],
        ['lang', 1]
    ])->get();
}

$result['content'] = \App\Http\Controllers\Web\IndexController::parseContent($content->toArray());
        return view("web.shop.index", ['title' => 'Shop'])->with('result', $result)->with('filter',$filter)->with('breadcrumb',$breadcrumb)
        ->with('activefilter',$activefilters)->with('meta',$meta)->with('catdata',$catdata);
    }

    public function detail(Request $request){

        $result = Products::getProductBySlug($request->slug);

        if( !$result ) :

            return view('errors.404');
            
        endif;

        $related = Products::getRelated($request->slug);
        
        $meta = isset( $result['meta'] ) ? $result['meta']  : [];
        $meta['title'] = $result['prod_title'];

        return view("web.shop.detail", ['prodtitle' => $result['prod_title']])->with('result', $result)->with('related',$related)->with('meta',$meta);
    }

public function filter(Request $request)
{
    $category = $deal = $brand = 0;
    $brand = [];

    $request = $request->all();

    if (isset($request['page'])) {
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($request) {
            return $request['page'];
        });
    }

    $data = Products::filter($request);
    $sort = $data['sort'];
    $data = $data['data'];

    $category = $request['filter']['category'] ?? 0;
    $brand = isset($request['filter']['brand']) ? json_decode($request['filter']['brand']) : [];

    $filter['categories'] = Categories::getRecursive($category);
    $filter['recipients'] = Categories::getRecursive($category, 18);
    $filter['occassions'] = Categories::getRecursive($category, 13);

    $category = ($category == 0) ? null : Categories::getParentID($category);

    $attrs = $request['filter']['attrtibutes'] ?? [];
    if ($category != 0) {
        $filter['attributes'] = CategoriesToAttributes::getData($category, $attrs);
    }

    $filter['brands'] = Brands::getBrandsFilter($brand);
    $filter['lastactive'] = $request['filter']['lastactive'] ?? null;

    if (!empty($request['filter']['price-from'])) {
        $filter['price'] = [
            'from' => $request['filter']['price-from'],
            'to' => $request['filter']['price-to']
        ];
    }

    if (!empty($request['filter']['rating'])) {
        $filter['rating'] = $request['filter']['rating'];
    }

    if (!empty($request['filter']['keywords'])) {
        $filter['keywords'] = $request['filter']['keywords'];
    }

    $activefilters = self::getActiveFilters($filter);

    $arr['loop'] = view("web.shop.loop")->with('result', $data)->render();

    $filter['sort'] = $sort;
    $arr['filter'] = view("web.shop.filter")->with('filter', $filter)->render();
    $arr['activefilter'] = view("web.shop.activefilter")->with('activefilter', $activefilters)->render();

    return json_encode($arr);
}


    public function recordSearch(Request $request){

        $data = $request->all();

        $cats = ProductsToCategories::where('product_ID',$data['id'])->pluck('category_ID');

        $cats ? $cats = $cats->toArray() : '';

        foreach($cats as $cat):

            SearchAnalytics::create([

                'product_ID' => $data['id'],

                'category_ID' => $cat,
                
                'user_ID' => $_SERVER['REMOTE_ADDR'],

            ]);

        endforeach;

    }



    public static function getActiveFilters($data){

        $active = [];

        foreach( $data['categories'] as $cat ) :

            isset($cat['active']) ? $active['category'] = $cat : '';

            if( isset($cat['children'] ) ) :

                foreach( $cat['children'] as $subcat ) :

                    isset($subcat['active']) ? $active['category'] = $subcat : '';

                    if( isset($subcat['children'] ) ) :

                        foreach( $subcat['children'] as $subcatchild ) :

                            isset($subcatchild['active']) ? $active['category'] = $subcatchild : '';

                        endforeach; 

                    endif;

                endforeach; 

            endif;

        endforeach;

        if( isset( $data['price'] ) ) :

            $active['price-filter'] = 'Price: '.$data['price']['from'] .'-'. $data['price']['to'];

        endif;

        // if( isset( $data['keywords'] ) && $data['keywords']  != '' ) :

            // $active['keywords'] = 'Keywords: '.$data['keywords'];

        // endif;

        return $active;

    }

    public function suggestions(Request $request){

        $data = Products::suggestions($request->all());

        return view("web.shop.suggestions")->with('result', $data);

    }

    public function variationRelation(Request $request){

        $arr = VariationsToAttributeValues::checkRelation($request->all());

        return $arr;
    }    


    public function askQuestion(Request $request){

        $data = $request->all();

        unset($data['_token']);

        Comments::create($data);

        return redirect()->back();
    }

    public function searchBrand(Request $request){

        $data = $request->all();

        $brands = Brands::searchBrands($data['keywords']);
        ?>

        <ul class="brands-list">

            <li>

                <div class="form-group position-relative mt-3 mb-4">

                    <input type="text" name="Name" id="brand" placeholder="Search" class="form-control">

                    <button class="position-absolute border-0 bg-transparent p-0" id="brand_search"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.7499 15.75L12.4927 12.4927M12.4927 12.4927C13.0498 11.9356 13.4918 11.2741 13.7933 10.5461C14.0949 9.81816 14.2501 9.03792 14.2501 8.24997C14.2501 7.46202 14.0949 6.68178 13.7933 5.95381C13.4918 5.22584 13.0498 4.56439 12.4927 4.00722C11.9355 3.45006 11.274 3.00809 10.5461 2.70655C9.8181 2.40502 9.03786 2.24982 8.24991 2.24982C7.46196 2.24982 6.68172 2.40502 5.95375 2.70655C5.22578 3.00809 4.56433 3.45006 4.00716 4.00722C2.88191 5.13247 2.24976 6.65863 2.24976 8.24997C2.24976 9.84131 2.88191 11.3675 4.00716 12.4927C5.13241 13.618 6.65857 14.2501 8.24991 14.2501C9.84125 14.2501 11.3674 13.618 12.4927 12.4927Z" stroke="#01A4DB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>

                </div>

            </li>

            <?php

            foreach( $brands as $brand ) :  ?>

                <li>

                    <div class="form-check p-0 m-0">

                        <input class="form-check-input filter-item" data-type="brand" data-value="<?=$brand['brand_ID']?>" type="radio" name="brand" id="<?=$brand['brand_slug']?>" value="<?=$brand['brand_slug']?>">

                        <label class="form-check-label" for="<?=$brand['brand_slug']?>"><?=$brand['brand_title']?> <span class="filter-count">(<?=$brand['count']?>)</span></label>

                    </div>

                </li>


            <?php endforeach; ?>

        </ul>
        
        <?php

    }
}
