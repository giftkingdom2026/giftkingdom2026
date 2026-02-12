<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Web\Index;
use App\Models\Web\Wishlist;
use App\Models\Core\VariationsToAttributeValues;
use App\Models\Core\Attributes;
use App\Models\Core\Values;
use App\Models\Core\Categories;
use App\Models\Core\Postmeta;
use App\Models\Core\Brands;
use App\Models\Core\Termmeta;
use App\Models\Core\ProductsToCategories;
use App\Models\Core\ProductsToBrands;
use App\Models\Core\ProductToAttributeValues;
use App\Models\Web\Users;
use App\Models\Web\Reviews;
use App\Models\Web\Comments;
use Auth;
use Route;

class Products extends Model

{

    protected $table = 'products';

    protected $guarded = [];

    public static function getProductsForShop($request)
    {

        $products = [];

        if (isset($request->category)) :

            $category = Categories::where('categories_slug', $request->category)->pluck('category_ID')->first();
            $return['category'] = $category;

            $arr = ProductsToCategories::where('category_ID', $category)->get('product_ID');

            $count = count($arr);

            $arr ? $arr = $arr->toArray() : '';

            foreach ($arr as $item) :

                $products[] = $item['product_ID'];

            endforeach;

        endif;

        $data = null;

        if (!empty($products)) :

            $where = [['prod_type', '!=', 'variation'], ['prod_status', 'active']];

            isset($request->featured)  ? $where[] = ['is_featured', 1] : '';

            isset($request->keywords) ? $where[] = ['prod_title', 'like', '%' . $request->keywords . '%'] : '';

            if (isset($request->price)) :

                $order = $request->price == 'low-to-high' ? 'asc' : 'desc';

                $data = self::whereIn('ID', $products)->where($where)->orderBy('price', $order)->paginate(9);


            else :

                $data = self::whereIn('ID', $products)->where($where)->paginate(9);

            endif;

        elseif (Route::current()->uri() == 'shop') :

            $where = [

                ['prod_type', '!=', 'variation'],
                ['prod_status', 'active']

            ];

            isset($request->keywords) ? $where[] = ['prod_title', 'like', '%' . $request->keywords . '%'] : '';

            $query = self::where($where);

            $data = $query->paginate(9);

        endif;

        $data ? $data = $data->toArray() : '';
        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        if (!empty($data['data'])) {
            foreach ($data['data'] as &$product) {
                if ($lang != 1) {
                    $translatedTitle = Postmeta::where([
                        ['posts_id', $product['ID']],
                        ['meta_key', 'prod_title'],
                        ['lang', $lang]
                    ])->pluck('meta_value')->first();

                    $product['prod_title'] = $translatedTitle ?? $product['prod_title'];
                }
            }
        }

        $check = empty($data) && isset($request->keywords);

        if ($check) :

            $data = self::getSearchProducts($request->keywords);

            $return['keyword'] = $data['keyword'];

            $data = $data['data'];

        endif;

        $return['products'] = $data;

        return $return;
    }


    public static function getRelated($slug)
    {

        $product = self::where('prod_slug', $slug)->pluck('ID')->first();

        $category = ProductsToCategories::where('product_ID', $product)->pluck('category_ID')->first();

        $products = ProductsToCategories::where('category_ID', $category)->pluck('product_ID');
        $data = self::whereIn('ID', $products)->limit(4)->get();

        $data ? $data = $data->toArray() : '';

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        foreach ($data as &$item) :

            if ($lang != 1) :

                $checkmeta = Postmeta::where([['posts_id', $item['ID']], ['lang', $lang], ['meta_key', 'prod_title']])->pluck('meta_value')->first();

                $item['prod_title'] = $checkmeta ?? $item['prod_title'];

            endif;

            if ($lang != 1) {
                $image = Postmeta::where([['posts_id', $item['ID']], ['lang', $lang], ['meta_key', 'prod_image']])->pluck('meta_value')->first();
                if ($image) {

                    $item['prod_image'] = Index::get_image_path($image);
                } else {
                    $item['prod_image'] = Index::get_image_path($item['prod_image']);
                }
            } else {
                $item['prod_image'] = Index::get_image_path($item['prod_image']);
            }
            if ($item['prod_type'] == 'variable') :

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


        return $data;
    }
    public static function getFeatured()
    {

        $products = Products::where('is_featured', '1')->where('prod_status', 'active')->pluck('ID');

        $data = self::whereIn('ID', $products)->limit(4)->get();

        $data ? $data = $data->toArray() : '';

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        foreach ($data as &$item) :

            if ($lang != 1) :

                $checkmeta = Postmeta::where([['posts_id', $item['ID']], ['lang', $lang], ['meta_key', 'prod_title']])->pluck('meta_value')->first();

                $item['prod_title'] = $checkmeta ?? $item['prod_title'];

            endif;

            if ($lang != 1) {
                $image = Postmeta::where([['posts_id', $item['ID']], ['lang', $lang], ['meta_key', 'prod_image']])->pluck('meta_value')->first();
                if ($image) {

                    $item['prod_image'] = Index::get_image_path($image);
                } else {
                    $item['prod_image'] = Index::get_image_path($item['prod_image']);
                }
            } else {
                $item['prod_image'] = Index::get_image_path($item['prod_image']);
            }
            if ($item['prod_type'] == 'variable') :

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

        return $data;
    }
    public static function getCategoryProducts($cat)
    {

        $products = ProductsToCategories::where('category_ID', $cat)->pluck('product_ID');

        $products ? $products = $products->toArray() : '';

        $products = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'products.prod_image')
            ->select('products.*', 'categoryTable.path as prod_image')
            ->whereIn('products.ID', $products)
            ->where([['products.prod_status', 'active'], ['products.prod_type', '!=', 'variation'], ['categoryTable.extension', 'webp']])
            ->groupBy('products.ID')
            ->limit(15)
            ->get()
            ->toArray();

        $data['products'] = $products;

        foreach ($data['products'] as &$prod) :

            if ($prod['prod_type'] == 'variable') :

                // $variation = self::getFirstVariation($prod['ID']);
                $variation = self::getMinimumPriceVariation($prod['ID']);

                $prod['default_variation'] = $variation['ID'];

                $prod['sale_price'] = $variation['sale_price'];

                $prod['prod_price'] = $variation['prod_price'];

                if (!empty($variations)) :

                    $prod['price'] = self::getVarPrice($variations);

                else :

                    $prod['price'] = (Products::getPrice($prod));

                endif;

            endif;

            $prod['prod_image'] = ['path' => $prod['prod_image']];

            $prod['wishlist'] = Wishlist::productExists($prod['ID']);

        endforeach;

        $data['cat'] = Categories::select('categories_slug')->where('category_ID', $cat)->first();

        $data['products'] = array_chunk($data['products'], round(count($data['products']) / 2));

        return $data;
    }

    public static function getRandom()
    {
        $products = self::where([
            ['prod_status', 'active'],
            ['prod_type', '!=', 'variation']
        ])
            ->inRandomOrder()
            ->take(20)
            ->pluck('ID')
            ->toArray();
        return self::getProducts($products);
    }



    public static function getFeaturedProducts()
    {

        $data = self::where([['is_featured', 1], ['prod_status', 'active']])->get();

        $data ? $data = $data->toArray() : '';

        foreach ($data as &$prod) :

            $prod['prod_image'] = ['path' => Index::get_image_path($prod['prod_image']), 'id' => $prod['prod_image']];

            $prod['wishlist'] = Wishlist::productExists($prod['ID']);

            $prod['review'] = Reviews::getRating($prod['ID']);

            if ($prod['prod_type'] == 'variable') :

                $variations = Products::getVariations($prod['ID']);

                if (!empty($variations)) :

                    $prod['price'] = self::getVarPrice($variations);

                else :

                    $prod['price'] = (Products::getPrice($prod));

                endif;

            else :

                $prod['price'] = self::getPrice($prod);

            endif;

        endforeach;

        return $data;
    }

    public static function getPrice($product)
    {

        if (is_array($product)) {
            $regular = $product['prod_price'];
            $sale = $product['sale_price'];

            $has_sale = $sale != 0 && $sale != null && $sale != $regular;

            return $has_sale ? $sale : $regular;
        } else {
            $prod = self::where('ID', $product)->first()->toArray();

            $regular = $prod['prod_price'];
            $sale = $prod['sale_price'];

            $has_sale = $sale != 0 && $sale != null && $sale != $regular;

            return $has_sale ? $sale : $regular;
        }
    }

    public static function getPriceNew($product)
    {
        if (is_array($product)) {
            return $product['prod_price'];
        } else {
            $prod = self::where('ID', $product)->first()->toArray();
            return $prod['prod_price'];
        }
    }

    public static function getVarPrice($variations)
    {

        $variation = array_shift($variations);

        $price = self::getPrice($variation);

        // $prices = [];

        // foreach($variations as $var) :

        //  $prices[] = $var['sale_price'];

        //  $prices[] = $var['prod_price'];

        // endforeach;

        // array_unique($prices);

        // $text = (number_format(min($prices) )).' - '. (number_format(max($prices)));

        // return $text;

        return $price;
    }
    public static function getProductOffer($id)
    {

        $data = self::select('products.*')
            ->where('products.ID', $id)
            ->groupBy('products.ID')
            ->first();



        return $data;
    }

    public static function getProduct($id)
    {
        $data = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'products.prod_image')
            ->select('products.*', 'categoryTable.path as prod_image')
            ->where('products.ID', $id)
            ->groupBy('products.ID')
            ->first();

        $data ? $data = $data->getAttributes() : '';

        if (empty($data)) {
            return null;
        }

        // Fix image path for frontend routes
        if (Route::current() != null && Route::current()->uri != '/') {
            $data['prod_images'] = Index::get_image_path2($data['prod_images']);
        }

        // Price logic
        if ($data['prod_type'] == 'variable') {
            $variations = Products::getVariations($data['ID']);
            $data['price'] = !empty($variations)
                ? self::getVarPrice($variations)
                : self::getPrice($data);
        } else {
            $data['price'] = self::getPrice($data);
        }

        // Other attributes
        $data['discount'] = self::getDiscount($data);
        $data['wishlist'] = Wishlist::productExists($id);
        $data['review'] = Reviews::getRating($id);
        $data['review_comments'] = Reviews::getReviewCommentsHTML($id);

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        if ($lang != 1) {
            if ($data['prod_type'] === 'variation' && !empty($data['prod_title_ar'])) {
                $data['prod_title'] = $data['prod_title_ar'];
            } else {
                $translatedTitle = Postmeta::where([
                    ['posts_id', $data['ID']],
                    ['meta_key', 'prod_title'],
                    ['lang', $lang],
                ])->pluck('meta_value')->first();

                if ($translatedTitle) {
                    $data['prod_title'] = $translatedTitle;
                }
            }
        }

        return $data;
    }


    public static function getDiscount($product)
    {

        $discount = 0;

        if (!is_array($product)) :

            $product = self::where('ID', $product)->first()->toArray();

        endif;

        if (isset($product['sale_price']) && $product['sale_price'] != null && $product['sale_price'] != 0):

            $discount = round((($product['prod_price'] - $product['sale_price']) * 100) / $product['prod_price']);

        endif;

        return $discount;
    }

    public static function getProducts($product_ids)
    {

        $where = [['products.prod_type', '!=', 'variation'], ['products.prod_status', 'active']];

        $data = self::leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'products.prod_image')
            ->select('products.*', 'categoryTable.path as prod_image')
            ->whereIn('products.ID', $product_ids)->where($where)
            ->groupBy('products.ID')
            ->get();

        $data ? $data = $data->toArray() : '';

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        foreach ($data as &$item) :

            // Handle translated title
            if ($lang != 1) :
                $checkmeta = Postmeta::where([
                    ['posts_id', $item['ID']],
                    ['lang', $lang],
                    ['meta_key', 'prod_title']
                ])->pluck('meta_value')->first();

                $item['prod_title'] = $checkmeta ?? $item['prod_title'];
            endif;

            // Only replace the image if a translated version exists
            if ($lang != 1) :
                $checkImage = Postmeta::where([
                    ['posts_id', $item['ID']],
                    ['lang', $lang],
                    ['meta_key', 'prod_image']
                ])->pluck('meta_value')->first();

                if (!empty($checkImage)) {
                    $item['prod_image'] = Index::get_image_path($checkImage);
                }
            // ✅ If $checkImage is null, do nothing — keep the original $item['prod_image']
            endif;

            // Pricing logic
            if ($item['prod_type'] == 'variable') :
                $variation = self::getMinimumPriceVariation($item['ID']);
                $item['sale_price'] = $variation['sale_price'];
                $item['prod_price'] = $variation['prod_price'];
                $item['price'] = self::getPrice($variation);
            else :
                $item['price'] = self::getPrice($item);
            endif;

            $item['discount'] = self::getDiscount($item);

        endforeach;


        return $data;
    }

    public static function getProductBySlug($slug)
    {

        $data = self::where('prod_slug', $slug)->first();

        $data ? $data = $data->toArray() : '';

        if ($data == null) :

            return false;

        endif;

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        $arr = Postmeta::where([['posts_id', $data['ID']], ['lang', $lang]])->get();

        $arr ? $arr = $arr->toArray() : '';

        $meta = [];

        foreach ($arr as $item) :

            $item['meta_value'] = $item['meta_key'] == 'bought_together' ? self::getProducts(explode(',', $item['meta_value'])) : $item['meta_value'];

            $meta[$item['meta_key']] = $item['meta_value'];


        endforeach;

        $data['meta'] = $meta;
        $Storearr = Usermeta::where('user_id', $data['author_id'])->get();

        $Storearr ? $Storearr = $Storearr->toArray() : '';

        $store_meta = [];
        foreach ($Storearr as $item) :

            if ($item['meta_key'] === 'store_logo_image' && !empty($item['meta_value'])) {
                $item['meta_value'] = Index::get_image_path2($item['meta_value']);
            }

            $store_meta[$item['meta_key']] = $item['meta_value'];

        endforeach;



        $data['store_meta'] = $store_meta;

        if ($lang != 1) :

            $data['prod_title'] = $meta['prod_title'] ?? '';
            $data['prod_description'] = $meta['prod_description'] ?? '';
            $data['prod_short_description'] = $meta['prod_short_description'] ?? '';
            $data['prod_features'] = $meta['prod_features'] ?? '';
            $data['prod_image'] = $meta['prod_image'] ?? '';
            $data['prod_images'] = $meta['prod_images'] ?? '';

        endif;

        $data['prod_image'] = Index::get_image_path2($data['prod_image']);

        $data['prod_images'] = Index::get_image_path2($data['prod_images']);

        if ($data['prod_type'] == 'variable') :

            $variations = self::getVariations($data['ID']);

            $data['variations'] = Attributes::getAttributesAndValues($variations, $data['ID']);

            // Only shift if more than 1 variation
            if (count($variations) > 1) {
                $variation = array_shift($variations); // removes first item
            } else {
                $variation = $variations[0]; // just reference, keep array intact
            }

            $data['default_variation'] = $variation['ID'];
            $data['sale_price']        = $variation['sale_price'];
            $data['prod_price']        = $variation['prod_price'];

            if (!empty($variations)) :
                $item['price'] = self::getVarPrice($variations);
            else :
                $item['price'] = Products::getPrice($item);
            endif;

        endif;

        // dd($data);

        $data['wishlist'] = Wishlist::productExists($data['ID']);

        $data['price'] = self::getPrice($data);

        // $data['vendor'] = Users::getUserData($data['author_id']);

        // $data['vendor']['product_count'] = Products::where('author_id',$data['author_id'])->count();

        $data['review'] = Reviews::getRating($data['ID']);

        $data['reviews'] = Reviews::getReviews($data['ID']);

        $data['comments'] = Comments::getComments($data['ID']);

        $data['discount'] = self::getDiscount($data);

        // $categories = ProductsToCategories::where('product_ID',$data['ID'])->pluck('category_ID');

        // $categories = Categories::whereIn('category_ID',$categories)->where('parent_ID','!=',0)->first(); 

        // $categories ? $categories = $categories->toArray() : ''; 

        // if( !empty($categories) ) : 

        //  $categories['parent_ID'] = Categories::getCategory($categories['parent_ID']);

        //  $data['category'] = $categories;

        // endif;

        // $mobile = Categories::where('category_title','Mobiles')->pluck('category_ID')->first();

        $categories = ProductsToCategories::where('product_ID', $data['ID'])
            ->leftjoin('categories', 'categories.category_ID', '=', 'products_to_categories.category_ID')
            ->where('category_type', '=', 'category')
            ->limit(3)
            ->get();

        $categories ? $categories = $categories->toArray() : '';

        $cat = '';

        foreach ($categories as $key => $category) :

            $where = [['taxonomy_id', 2147483647], ['terms_id', $category['category_ID']], ['meta_key', 'category_title'], ['lang', $lang]];

            $lang != 1 ? $category['category_title'] = Termmeta::where($where)->pluck('meta_value')->first() : '';

            $cat .= $category['category_title'] . ', ';

        endforeach;

        $data['categories'] = $cat;

        return $data;
    }


    public static function getMinimumPriceVariation($id)
    {
        $data = self::select('ID', 'sale_price', 'prod_price')
            ->where('prod_parent', $id)
            ->where('prod_type', 'variation')
            ->whereNotNull('sale_price')
            ->where('sale_price', '!=', '')
            ->whereColumn('sale_price', '!=', 'prod_price')
            ->orderByRaw('CAST(sale_price AS DECIMAL(10,2)) ASC') // 🔥 force numeric sort
            ->first();

        return $data ? $data->toArray() : null;
    }



    public static function getFirstVariation($id)
    {

        $data = self::select('ID', 'sale_price', 'prod_price')->where([['products.prod_parent', $id], ['products.prod_type', 'variation']])->first();

        $data ? $data = $data->toArray() : '';

        return $data;
    }

    public static function getVariations($id)
    {

        $data = self::where([['products.prod_parent', $id], ['products.prod_type', 'variation']])->get();

        $data2 = self::where([['products.prod_parent', $id], ['products.prod_type', 'variation']])->pluck('ID')->toArray();

        $data3 = VariationsToAttributeValues::where([['product_ID', $id]])->whereIn('variation_ID', $data2)->get()->toArray();

        $data ? $data = $data->toArray() : '';

        foreach ($data as $key => &$item) :

            $check = Route::current() != null && Route::current()->uri != '/';

            if ($check) :

                if (count($data3) != 0) :

                    foreach ($data3 as $key3 => &$item3) :

                        if ($item['ID'] == $item3['variation_ID']):

                            $item['variation'][$key3] = $item3;

                        endif;

                    endforeach;

                else :

                    $item['variation'] = [];

                endif;


            endif;

            $check = str_contains(Route::current()->uri, 'admin');

            if ($check) :

                $item['prod_images'] = ['path' => Index::get_image_path2($item['prod_images']), 'id' => $item['prod_images']];

                $item['prod_image'] = ['path' => Index::get_image_path2($item['prod_image']), 'id' => $item['prod_image']];

                $item['variation'] = VariationsToAttributeValues::where([['variation_ID', $item['ID']], ['product_ID', $id]])->get()->toArray();

            endif;

        endforeach;
        // dd($data3,$data);
        return $data;
    }



    public static function getVariation($id)
    {

        $data = self::where([

            ['prod_parent', $id],

            ['prod_type', 'variation'],

        ])->get();

        $data ? $data = $data->toArray() : '';

        foreach ($data as &$item) :

            $item['variation'] = VariationsToAttributeValues::where('variation_ID', $item['ID'])->get()->toArray();

            $item['prod_image'] = ['path' => Index::get_image_path($item['prod_image']), 'id' => $item['prod_image']];

            $item['prod_images'] = ['path' => Index::get_image_path($item['prod_images']), 'id' => $item['prod_images']];

        endforeach;

        return $data;
    }



    public static function search($keyword)
    {

        $data = self::where([['prod_title', 'like', '%' . $keyword . '%'], ['prod_type', '!=', 'variation'], ['prod_status', 'active']])->limit(9)->get();

        $data ? $data = $data->toArray() : '';

        $arr = [];

        foreach ($data as $item) :

            $arr[] = ['id' => $item['prod_slug'], 'text' => $item['prod_title']];

        endforeach;

        return json_encode($arr);
    }
    public static function suggestions($data)
    {
        $keyword = $data['val'] ?? '';
        $categoryId = $data['cat'] ?? null;
        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        $categories = Categories::select('category_ID', 'category_title')
            ->where('parent_ID', 0)
            ->get();

        // Translate category titles
        if (session()->has('lang_id') && session('lang_id') != 1) {
            foreach ($categories as &$cat) {
                $translated = Termmeta::where([
                    ['taxonomy_id', 2147483647],
                    ['terms_id', $cat['category_ID']],
                    ['meta_key', 'category_title'],
                    ['lang', session('lang_id')],
                ])->pluck('meta_value')->first();

                if ($translated) {
                    $cat['category_title'] = $translated;
                }
            }
        }

        $data['categories'] = $categories->toArray();
        $data['keyword'] = $keyword;
        $data['recentproducts'] = [];
        $data['popularproducts'] = [];

        // ALWAYS set this upfront to avoid undefined key issues
        $data['active_category_id'] = $categoryId ?? 0;

        if (!empty($keyword)) {
            $keywords = explode(' ', $keyword);
            $baseQuery = self::query()
                ->where('prod_type', '!=', 'variation')
                ->where('prod_status', 'active');

            foreach ($keywords as $word) {
                $query = clone $baseQuery;
                $query->where('prod_title', 'like', "%{$word}%");

                if ($query->exists()) {
                    $products = $query->leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'products.prod_image')
                        ->select(
                            'products.prod_image',
                            'products.ID',
                            'products.prod_slug',
                            'products.prod_title',
                            'products.prod_price',
                            'products.sale_price',
                            'products.prod_type',
                            'products.price',
                            'categoryTable.path as prod_image'
                        )
                        ->groupBy('products.ID')
                        ->get()
                        ->toArray();

                    foreach ($products as &$item) {
                        if ($lang != 1) {
                            $image = Postmeta::where([
                                ['posts_id', $item['ID']],
                                ['lang', $lang],
                                ['meta_key', 'prod_image']
                            ])->pluck('meta_value')->first();

                            if (!empty($image)) {
                                $item['prod_image'] = Index::get_image_path($image);
                            }
                        }

                        if ($item['prod_type'] === 'variable') {
                            $variation = Products::getMinimumPriceVariation($item['ID']);
                            if ($variation) {
                                $item['sale_price'] = $variation['sale_price'];
                                $item['prod_price'] = $variation['prod_price'];
                                $item['price'] = Products::getPrice($variation);
                            } else {
                                $item['price'] = null;
                            }
                        } else {
                            $item['price'] = Products::getPrice($item);
                        }
                    }


                    $data['products'] = $products;
                    return $data;
                }
            }

            $data['products'] = [];
            return $data;
        }

        if (!empty($categoryId)) {
            $query = ProductsToCategories::leftJoin('products', 'products.ID', '=', 'products_to_categories.product_ID')
                ->where('products_to_categories.category_ID', $categoryId)
                ->where('products.prod_type', '!=', 'variation')
                ->where('products.prod_status', '=', 'active')
                ->leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'products.prod_image')
                ->select(
                    'products.prod_image',
                    'products.ID',
                    'products.prod_slug',
                    'products.prod_title',
                    'products.prod_price',
                    'products.sale_price',
                    'products.prod_type',
                    'products.price',
                    'categoryTable.path as prod_image'
                )
                ->groupBy('products.ID')
                ->limit(5)
                ->get()
                ->toArray();

            foreach ($query as &$item) {
                if ($item['prod_type'] === 'variable') {
                    $variation = Products::getMinimumPriceVariation($item['ID']);
                    if ($variation) {
                        $item['sale_price'] = $variation['sale_price'];
                        $item['prod_price'] = $variation['prod_price'];
                        $item['price'] = Products::getPrice($variation);
                    } else {
                        $item['price'] = null;
                    }
                } else {
                    $item['price'] = Products::getPrice($item);
                }
            }

            $data['products'] = $query;
            return $data;
        }

        $analyticsWhere = [['user_ID', $_SERVER['REMOTE_ADDR']]];

        $recentIds = SearchAnalytics::where($analyticsWhere)
            ->groupBy('product_ID')
            ->pluck('product_ID')
            ->toArray();

        $popularIds = SearchAnalytics::where($analyticsWhere)
            ->groupBy('product_ID')
            ->orderByRaw('COUNT(*) DESC, product_ID ASC')
            ->limit(10)
            ->pluck('product_ID')
            ->toArray();

        $data['recentproducts'] = self::select('ID', 'prod_title', 'prod_slug')
            ->where('prod_status', 'active')
            ->whereIn('ID', $recentIds)
            ->get()
            ->toArray();

        $data['popularproducts'] = self::select('ID', 'prod_title', 'prod_slug')
            ->where('prod_status', 'active')
            ->whereIn('ID', $popularIds)
            ->get()
            ->toArray();

        $data['products'] = [];
        return $data;
    }





    public static function filter($args)
    {

        $offset = isset($args['offset']) ? $args['offset'] : false;

        $products = $count = $categoryproducts = $dealproducts = $brandproducts = $priceproducts = $ratingproducts = [];

        $sort = $args['filter']['sort'];

        if ($args['filter']['category']) :

            $query = ProductsToCategories::leftjoin('products', 'products.ID', '=', 'products_to_categories.product_ID')
                ->where('products_to_categories.category_ID', $args['filter']['category'])
                ->where('products.prod_type', '!=', 'variation')
                ->where('products.prod_status', '=', 'active')
                ->groupBy('products.ID');

            $categoryproducts = $query->pluck('products_to_categories.product_ID');

            $categoryproducts ? $categoryproducts = $categoryproducts->toArray() : '';

            $products = empty($products) ? array_merge($products, $categoryproducts) : array_intersect($products, $categoryproducts);

        endif;

        if ($args['filter']['brand'] && !empty(json_decode($args['filter']['brand']))) :

            $brands = json_decode($args['filter']['brand']);

            $query = ProductsToBrands::leftjoin('products', 'products.ID', '=', 'products_to_brands.product_ID')
                ->whereIn('products_to_brands.brand_ID', $brands)
                ->where('products.prod_type', '!=', 'variation')
                ->where('products.prod_status', '=', 'active')
                ->groupBy('products.ID');

            $brandproducts = $query->pluck('product_ID');

            $brandproducts ? $brandproducts = $brandproducts->toArray() : '';

            $products = empty($products) ? array_merge($products, $brandproducts) : array_intersect($products, $brandproducts);

        endif;

        if (isset($args['filter']['price-from']) && $args['filter']['price-from'] != null) :

            $query = self::whereBetween('price', [$args['filter']['price-from'], $args['filter']['price-to']])
                ->where('prod_type', '!=', 'variation')
                ->where('prod_status', '=', 'active')
                ->groupBy('products.ID');

            $priceproducts = $query->pluck('ID');

            $priceproducts ? $priceproducts = $priceproducts->toArray() : '';

            $products = empty($products) ? array_merge($products, $priceproducts) : array_intersect($products, $priceproducts);

        endif;

        if (isset($args['filter']['attrtibutes'])) :

            $args['filter']['attrtibutes'] = array_filter($args['filter']['attrtibutes']);

            if (!empty($args['filter']['attrtibutes'])) :

                $attrs = [];

                foreach ($args['filter']['attrtibutes'] as $key => $val) :

                    $attrproducts = VariationsToAttributeValues::where([['value_ID', $val], ['attribute_ID', $key]])->pluck('product_ID');

                    $attrproducts ? $attrs += $attrproducts->toArray() : '';

                endforeach;

                $products = empty($products) ? array_merge($products, $attrs) : array_intersect($products, $attrs);

                $count = count($products);

            endif;

        endif;

        $check = array_filter($args['filter']);
        unset($check['lastactive']);
        unset($check['sort']);

        $bcond = isset($check['brand']) && empty(json_decode($check['brand']));

        if ($bcond) : unset($check['brand']);
        endif;

        if (isset($check['keywords'])) : unset($check['keywords']);
        endif;

        if (empty($check)) :

            $query = self::where('prod_type', '!=', 'variation')
                ->where('prod_status', '=', 'active')
                ->groupBy('products.ID');

            $count = count($query->get());

            $products = $query->pluck('ID');

        endif;

        $keywords = $args['filter']['keywords'];

        $data = self::getFilterProducts($products, $offset, $sort, $keywords, '1');

        $data['data'] = $data['data'];

        $data['sort'] = $sort;

        return $data;
    }


    public static function getFilterProducts($product_ids, $offset = false, $sort = 'default', $keywords = '', $no_filter = '')
    {
        $where = [['prod_type', '!=', 'variation'], ['prod_status', 'active']];

        $keywords != '' ? $where[] = ['prod_title', 'like', '%' . $keywords . '%'] : '';

        if ($sort == 'default') {
            $data = self::whereIn('ID', $product_ids)->where($where);

            $data = $offset !== false
                ? $data->skip($offset)->paginate(9)
                : $data->paginate(9);
        } else {
            $key = 'created_at';
            $val = 'desc';
            $orderByRaw = null;

            if (str_contains($sort, 'alpha')) {
                $key = 'prod_title';
                $val = str_contains($sort, 'asc') ? 'asc' : 'desc';
            } elseif (str_contains($sort, 'price')) {
                $key = 'price';
                $val = str_contains($sort, 'asc') ? 'asc' : 'desc';
            } elseif (str_contains($sort, 'featured')) {
                $key = 'created_at';
                $val = 'desc';
                $where[] = ['is_featured', '=', 1];
            } elseif (str_contains($sort, 'best-sellers')) {
                $bestSellingProductIds = DB::table('order_items')
                    ->join('orders', 'order_items.order_ID', '=', 'orders.id')
                    ->where('orders.order_status', 'completed')
                    ->select('order_items.product_ID', DB::raw('COUNT(*) as total_sales'))
                    ->groupBy('order_items.product_ID')
                    ->orderByDesc('total_sales')
                    ->pluck('order_items.product_ID')
                    ->toArray();

                if ($product_ids instanceof \Illuminate\Support\Collection) {
                    $product_ids = $product_ids->toArray();
                }

                $bestSellingProductIds = array_map('intval', $bestSellingProductIds);
                $product_ids = array_map('intval', $product_ids);

                $bestSellingProductIds = array_values(array_intersect($bestSellingProductIds, $product_ids));

                $orderedIds = implode(',', $bestSellingProductIds);
                $orderByRaw = DB::raw("FIELD(ID, $orderedIds)");

                $product_ids = $bestSellingProductIds;
            }

            $query = self::whereIn('ID', $product_ids)->where($where);

            if ($orderByRaw) {
                $query = $query->orderByRaw($orderByRaw);
            } else {
                $query = $query->orderBy($key, $val);
            }

            $data = $offset !== false
                ? $query->skip($offset)->paginate(9)
                : $query->paginate(9);
        }

        $data = $data ? $data->toArray() : [];

        foreach ($data['data'] as &$item) {
            $lang = session()->has('lang_id') ? session('lang_id') : 1;

            // Handle translated title
            if ($lang != 1) {
                $translatedTitle = Postmeta::where([
                    ['posts_id', $item['ID']],
                    ['meta_key', 'prod_title'],
                    ['lang', $lang]
                ])->pluck('meta_value')->first();

                $item['prod_title'] = $translatedTitle ?? $item['prod_title'];
            }

            // Handle translated image ONLY if it exists
            if ($lang != 1) {
                $translatedImage = Postmeta::where([
                    ['posts_id', $item['ID']],
                    ['meta_key', 'prod_image'],
                    ['lang', $lang]
                ])->pluck('meta_value')->first();

                if (!empty($translatedImage)) {
                    $item['prod_image'] = $translatedImage;
                }
                // If empty, keep original $item['prod_image']
            }

            // Always resolve image path for display
            $item['prod_image'] = [
                'path' => Index::get_image_path($item['prod_image']),
                'id'   => $item['prod_image']
            ];

            // Pricing logic
            if ($item['prod_type'] == 'variable') :
                $variation = self::getMinimumPriceVariation($item['ID']);
                if ($variation):
                    $item['default_variation'] = $variation['ID'];
                    $item['sale_price'] = $variation['sale_price'];
                    $item['prod_price'] = $variation['prod_price'];
                    $item['price'] = Products::getPrice($variation);
                endif;
            else :
                $item['price'] = Products::getPrice($item);
            endif;

            $item['discount'] = self::getDiscount($item);
            $item['wishlist'] = Wishlist::productExists($item['ID']);
        }


        return ['data' => $data];
    }


    public static function detuctQuantity($product, $quantity)
    {

        $qty = self::where('ID', $product)->pluck('prod_quantity')->first();

        $qty = $qty - $quantity;

        self::where('ID', $product)->update(['prod_quantity' => $qty]);
    }

    public static function getSearchProducts($keywords)
    {

        $where = [

            ['prod_type', '!=', 'variation'],
            ['prod_status', 'active']

        ];

        $keywords = explode(' ', $keywords);

        foreach ($keywords as $word) :

            $query = self::where($where);

            $query->where('prod_title', 'like', '%' . $word . '%');

            $count = $query->count();

            if ($count != 0) :

                $data = $query->paginate(9)();

                $data ? $data = $data->toArray() : '';

                return ['data' => $data, 'count' => $count, 'keyword' => $word];

                die();

            endif;

        endforeach;

        if (!isset($data)) :

            $query = self::where($where);

            $query->where('prod_title', 'like', '%Product Does Not Exist At All%');

            $count = $query->count();

            $data = $query->paginate(9)->get();

            $data ? $data = $data->toArray() : '';

            return ['data' => $data, 'count' => $count, 'keyword' => ''];

        endif;
    }

    public static function getStoreProducts($author_id)
    {
        $products = Products::where('author_id', $author_id)->where('prod_status', 'active')->where('prod_type', '!=', 'variation')->pluck('ID');

        $data = self::whereIn('ID', $products)->limit(3)->get();

        $data ? $data = $data->toArray() : '';

        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        foreach ($data as &$item) :

            if ($lang != 1) :

                $checkmeta = Postmeta::where([['posts_id', $item['ID']], ['lang', $lang], ['meta_key', 'prod_title']])->pluck('meta_value')->first();

                $item['prod_title'] = $checkmeta ?? $item['prod_title'];

            endif;

            if ($lang != 1) {
                $image = Postmeta::where([['posts_id', $item['ID']], ['lang', $lang], ['meta_key', 'prod_image']])->pluck('meta_value')->first();
                if ($image) {

                    $item['prod_image'] = Index::get_image_path($image);
                } else {
                    $item['prod_image'] = Index::get_image_path($item['prod_image']);
                }
            } else {
                $item['prod_image'] = Index::get_image_path($item['prod_image']);
            }

            if ($item['prod_type'] == 'variable') :

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

        return $data;
    }
}
