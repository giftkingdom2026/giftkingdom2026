<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class ProductsToAttributes extends Model{

    public $table = 'product_to_attributes';
    
    public $guarded = [];

    public static function insert($cat,$attr){

        self::create([
        
            'product_ID' => $cat,
        
            'attribute_ID' => $attr,
        
        ]);
    }


    public static function getProductAttributes($id){

        $attrs = self::selectRaw('product_ID, group_concat(attribute_ID) as attrs')->where( 'product_ID', $id )->get();

        $attrs ? $attrs = $attrs->toArray() : '';

        $attrs = array_filter(array_shift( $attrs ));

        return $attrs;

    }

}
