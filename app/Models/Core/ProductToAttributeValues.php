<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;



use App\Models\Core\Values;



class ProductToAttributeValues extends Model{



    public $table = 'products_to_attributevalues';

    public $guarded = [];



    public static function insert($data){

        self::where('product_ID', $data['product_ID'])->where('attribute_ID', $data['attribute_ID'])->delete(); 
        foreach( $data['values'] as $val ) :

            self::create([

                'product_ID' => $data['product_ID'],

                'attribute_ID' => $data['attribute_ID'],

                'value_ID' => $val

            ]);

        endforeach;

    }


    public static function getRealtion( $prod,$attr,$get = false ){

        if( !$get ) :

            $values = self::where( [

                ['product_ID', $prod],

                ['attribute_ID', $attr]

            ] )->pluck('value_ID');

        else :

            $values = self::where( [

                ['product_ID', $prod],

                ['attribute_ID', $attr]

            ] )->get();

        endif;

        $values ? $values = $values->toArray() : '';

        return $values;

    }



}

