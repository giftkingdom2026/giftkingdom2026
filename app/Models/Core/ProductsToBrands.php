<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class ProductsToBrands extends Model{

    public $table = 'products_to_brands';
    public $guarded = [];


    public static function exists( $brand, $id ){

        $check = self::where([
            ['product_ID',$id],
            ['brand_ID',$brand],
        ])->first();

        $return = $check ? 1 : 0;

        return $return;
    }
}
