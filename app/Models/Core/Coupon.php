<?php



namespace App\Models\Core;



use http\Env\Request;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Models\Web\Cart;


class Coupon extends Model

{

    use Sortable;



    protected $table = 'coupons';

    protected $guarded = [];


    public static function apply($code)
    {

        $check = self::where([['coupon_code', $code]])->whereDate('expiry_date', '>', date('Y-m-d h:i:s', strtotime("-1 days")))->first();

        $check ? $check = $check->toArray() : '';

        if (!empty($check)) :

            if ($check['usage_count'] != $check['usage_limit']) :

                $cart = Cart::getCart();

                if ($cart->cart_itemstotal > $check['minimum_amount']) :

                    Cart::where('cart_ID', $cart->cart_ID)->update(['cart_coupon' => $code]);

                    return true;

                else :

                    return false;

                endif;

            else :

                return false;

            endif;


        else :

            return false;

        endif;
    }




    public static function updateCoupon($request)
    {


        self::where('coupon_ID', $request->id)->update([

            'coupon_code'                =>   $request->coupon_code,
            'status'                =>   $request->status,

            'coupon_description'         =>   $request->coupon_description,

            'discount_type'              =>   $request->discount_type,

            'discount_amount'            =>   $request->discount_amount,

            'individual_use'             =>   0,

            'usage_limit'                =>   $request->usage_limit,

            'usage_limit_per_user'       =>   100,

            'limit_usage_to_x_items'     =>   0,

            'product_categories'         =>   0,

            'excluded_product_categories' =>   0,

            'exclude_sale_items'         =>   0,

            'email_restrictions'         =>   0,

            'minimum_amount'             =>   $request->minimum_amount,

            'maximum_amount'             =>   0,

            'expiry_date'                =>   $request->expiry_date,

            'free_shipping'              =>   0,

            'is_redeem'                  =>   0,

            'product_ids'                =>   $request->product_ids,

        ]);
    }

    public function email()
    {

        $emails = DB::table('users')->select('email')->get();

        return $emails;
    }


    public function cutomers()
    {

        $products = DB::table('products')

            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')

            ->select('products_name', 'products.products_id', 'products.products_model')->get();


        return $products;
    }



    public function categories()
    {

        $categories = DB::table('categories')

            ->LeftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')

            ->select('categories_name', 'categories.categories_id')

            ->where('parent_id', '>', '0')

            ->get();


        return $categories;
    }



    public  function coupon($code)
    {

        $couponInfo = DB::table('coupons')->where('code', '=', $code)->get();

        return $couponInfo;
    }



    public function addcoupon(
        $code,
        $description,

        $discount_type,
        $amount,
        $individual_use,
        $product_ids,

        $exclude_product_ids,
        $usage_limit,
        $usage_limit_per_user,
        $usage_count,
        $used_by,
        $limit_usage_to_x_items,
        $product_categories,
        $excluded_product_categories,

        $exclude_sale_items,
        $email_restrictions,
        $minimum_amount,
        $maximum_amount,
        $expiry_date,
        $free_shipping,
        $is_redeem
    ) {


        $coupon_id = DB::table('coupons')->insertGetId([

            'code'                       =>   $code,

            'created_at'                 =>   date('Y-m-d H:i:s'),

            'description'                =>   $description,

            'discount_type'              =>   $discount_type,

            'amount'                     =>   $amount,

            'individual_use'             =>   $individual_use,

            'product_ids'                =>   $product_ids,

            'exclude_product_ids'        =>   $exclude_product_ids,

            'usage_limit'                =>   $usage_limit,

            'usage_limit_per_user'       =>   $usage_limit_per_user,

            'usage_count'                =>           $usage_count,

            'used_by'                =>           $used_by,

            'limit_usage_to_x_items'     =>   $limit_usage_to_x_items,

            'product_categories'         =>   $product_categories,

            'excluded_product_categories' =>   $excluded_product_categories,

            'exclude_sale_items'         =>   $exclude_sale_items,

            'email_restrictions'         =>   $email_restrictions,

            'minimum_amount'             =>   $minimum_amount,

            'maximum_amount'             =>   $maximum_amount,

            'expiry_date'                =>   $expiry_date,

            'free_shipping'              =>   $free_shipping,

            'is_redeem'                  => $is_redeem ?? 0,

            'overall_usage'              => 0

        ]);


        if ($is_redeem == 1) {

            DB::table('coupons')->where('coupans_id', '!=', $coupon_id)->update(['is_redeem' => 0]);
        }

        return $coupon_id;
    }

    public function getcoupon($id)
    {



        $coupon = DB::table('coupons')->where('coupans_id', '=', $id)->get();





        return $coupon;
    }



    public function getemail()
    {



        $emails = DB::table('users')->select('email')->get();



        return $emails;
    }



    public function getproduct()
    {



        $products = DB::table('products')

            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')

            ->select('products_name', 'products.products_id', 'products.products_model')->get();





        return $products;
    }

    public function getcategories()
    {



        $categories = DB::table('categories')

            ->LeftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')

            ->select('categories_name', 'categories.categories_id')

            ->where('parent_id', '>', '0')

            ->get();



        return $categories;
    }



    public function getcode($code)
    {



        $couponInfo = DB::table('coupons')->where('code', '=', $code)->get();





        return $couponInfo;
    }



    public function couponupdate(
        $coupans_id,
        $code,
        $description,
        $discount_type,
        $amount,
        $individual_use,

        $product_ids,
        $exclude_product_ids,
        $usage_limit,
        $usage_limit_per_user,
        $usage_count,

        $limit_usage_to_x_items,
        $product_categories,
        $used_by,
        $excluded_product_categories,

        $request,
        $email_restrictions,
        $minimum_amount,
        $maximum_amount,
        $expiry_date,
        $free_shipping,
        $is_redeem
    ) {



        //insert record

        $coupon_id = DB::table('coupons')->where('coupans_id', '=', $coupans_id)->update([

            'code'                      =>   $code,

            'updated_at'                =>   date('Y-m-d H:i:s'),

            'description'               =>   $description,

            'discount_type'                 =>   $discount_type,

            'amount'                    =>   $amount,

            'individual_use'            =>   $individual_use,

            'product_ids'               =>   $product_ids,

            'exclude_product_ids'       =>   $exclude_product_ids,

            'usage_limit'               =>   $usage_limit,

            'usage_limit_per_user'      =>   $usage_limit_per_user,

            'usage_count'       =>           $usage_count,

            'limit_usage_to_x_items'    =>   $limit_usage_to_x_items,

            'product_categories'        =>   $product_categories,

            'used_by'       =>   $used_by,

            'excluded_product_categories' =>   $excluded_product_categories,

            'exclude_sale_items'        =>   $request->exclude_sale_items,

            'email_restrictions'        =>   $email_restrictions,

            'minimum_amount'            =>   $minimum_amount,

            'maximum_amount'            =>   $maximum_amount,

            'expiry_date'               =>   $expiry_date,

            'free_shipping'                 =>   $free_shipping,

            'is_redeem'                 => $is_redeem,

        ]);

        if ($is_redeem == 1) {

            DB::table('coupons')->where('coupans_id', '!=', $coupans_id)->update(['is_redeem' => 0]);
        }

        return $coupon_id;
    }



    public function deletecoupon($request)
    {



        $deletecoupon = DB::table('coupons')->where('coupans_id', '=', $request->id)->delete();





        return $deletecoupon;
    }





    public function couponproduct()
    {



        $coupons = DB::table('products')->get();





        return $coupons;
    }
}
