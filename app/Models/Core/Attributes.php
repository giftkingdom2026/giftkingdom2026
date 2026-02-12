<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Models\Web\Index;

use App\Models\Core\CategoriesToAttributes;

use App\Models\Core\Categories;

use App\Models\Core\ProductToAttributeValues;

use App\Models\Core\ProductsToAttributes;

use App\Models\Core\VariationsToAttributeValues;

use App\Models\Core\Products;

use App\Models\Core\Termmeta;

use App\Models\Core\Values;

use App\Http\Controllers\AdminControllers\SiteSettingController;

class Attributes extends Model{

    public $table = 'attributes';

    public $guarded = [];


public static function list($id = null, $perPage = 10, $search = null) {
    // Step 1: Start base query
    if ($id && $id != 0) {
        $attrIdsRow = CategoriesToAttributes::selectRaw('group_concat(attribute_ID) as attr')
            ->where('category_ID', $id)
            ->first();

        $attrIds = $attrIdsRow && $attrIdsRow->attr ? explode(',', $attrIdsRow->attr) : [];

        $query = self::whereIn('attribute_ID', $attrIds);
    } else {
        $query = self::query();
    }

    // Step 2: Apply search
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('attribute_title', 'like', "%{$search}%")
              ->orWhere('attribute_slug', 'like', "%{$search}%");
        });
    }

    // Step 3: Paginate (Laravel's paginator)
    $paginator = $query->orderBy('attribute_ID', 'asc')
        ->paginate($perPage)
        ->appends([
            'length' => $perPage,
            's' => $search,
            'cat' => $id
        ]);

    // Step 4: Return both paginated data and paginator metadata
    return [
        'data' => $paginator->items(),
        'paginator' => $paginator->toArray()
    ];
}




    public static function addAttr($data){

        unset($data['_token']);

        $attr = self::create([

            'attribute_title' => $data['attribute_title'],

            'attribute_slug' => $data['attribute_slug'],

        ]);

        if( isset($data['category_ID']) ) :

            if( is_array( $data['category_ID'] ) ) :

                if( array_shift($data['category_ID']) == 'all' ) :

                    $cats = Categories::all();

                    foreach( $cats as $id ) :

                        CategoriesToAttributes::create([

                            'category_ID' => $id->category_ID,
                            'attribute_ID' => $attr->id,

                        ]);

                    endforeach;

                else :

                    foreach( $data['category_ID'] as $id ) :

                        CategoriesToAttributes::create([

                            'category_ID' => $id,
                            'attribute_ID' => $attr->id,

                        ]);

                    endforeach;

                endif;

            else :

                CategoriesToAttributes::create([

                    'category_ID' => $data['category_ID'],
                    'attribute_ID' => $attr->id,

                ]);

            endif;

        endif;
        
    }


    public static function assignOrCreate( $attrs ,$id, $var = false ){

        $attrs = array_filter($attrs);

        foreach( $attrs as $values ) :

            $values = explode(':', $values);

            $attribute = ucwords(str_replace(' ','',$values[0]));

            $check = self::where('attribute_title',$attribute)->pluck('attribute_ID')->first();

            if( !$check ) :

                $attr = self::create([

                    'attribute_title' => ucwords($attribute),

                    'attribute_slug' => strtolower(str_replace(' ', '', $values[0])),

                ]);

                $attr = $attr->id;

            else :

                $attr = $check;

            endif;

            $check = Values::where('value_title',$values[1])->pluck('value_ID')->first();

            if( !$check ) :

                $value = Values::create([

                    'attribute_ID' => $attr,

                    'value_title' => $values[1],

                    'value_slug' => strtolower(str_replace(' ', '', $values[1])),

                    'value_type' => 'text',

                ]);

                $value = $value->id;
                
            else :

                $value = $check;

            endif;

            ProductsToAttributes::create([

                'product_ID' => $id,

                'attribute_ID' => $attr,

            ]);

            ProductToAttributeValues::create([

                'product_ID' => $id,

                'attribute_ID' => $attr,

                'value_ID' => $value

            ]);

            if( $var ) :

                VariationsToAttributeValues::create([

                    'product_ID' => $id,

                    'variation_ID' => $var->id,

                    'attribute_ID' => $attr,

                    'value_ID' => $value,

                ]);

            endif;

        endforeach;

    }


    public static function getAttrs($attrs){



        $attrs['attrs'] = explode(',', $attrs['attrs'] );

        $arr = self::whereIn( 'attribute_ID', $attrs['attrs'] )->get();

        $arr ? $arr = $arr->toArray() : '';

        return $arr;

    }



    public static function search($keyword){



        $data = self::where('attribute_title', 'like' , '%'.$keyword.'%' )->get();



        $data ? $data = $data->toArray() : '';



        $arr = [];



        foreach($data as $item) :



            $arr[] = [ 'id' => $item['attribute_ID'], 'text' => $item['attribute_title'] ];



        endforeach;



        return json_encode($arr);



    }



    public static function getAttributesAndValues($data,$id){

        $arr = [];

        // dd($data);
        
        foreach( $data as $var ) :

            foreach( $var['variation'] as $item ) :

                $arr[$item['attribute_ID']]['attribute'] = $item['attribute_ID'];

                isset( $arr[$item['attribute_ID']]['values'] ) ? '' : 

                $arr[$item['attribute_ID']]['values'] = [];

                !in_array($item['value_ID'], $arr[$item['attribute_ID']]['values']) ? 


                $arr[$item['attribute_ID']]['values'][] = $item['value_ID'] : '';

            endforeach;

        endforeach;
        
        $lang = session()->has('lang_id') ? session('lang_id') : 1;

        foreach($arr as &$item) :

            $attr = self::where('attribute_ID',$item['attribute'])->first();

            $attr ? $attr = $attr->toArray() : '';

            $where = [['taxonomy_id',447218073],['terms_id',$attr['attribute_ID']],['meta_key','attribute_title'],['lang',$lang]];

            $checkattr = Termmeta::where($where)->pluck('meta_value')->first();

            $checkattr != '' ? $attr['attribute_title'] = $checkattr : '';

            $item['attribute'] = $attr;

            foreach( $item['values'] as &$val ) :

                $val = Values::where([['value_ID',$val],['attribute_ID',$item['attribute']['attribute_ID']]])->first();

                $val ? $val = $val->toArray() : '';
                
                $where = [['taxonomy_id',741035],['terms_id',$val['value_ID']],['meta_key','value_title'],['lang',$lang]];

                $checkval = Termmeta::where($where)->pluck('meta_value')->first();

                $checkval != '' ? $val['value_title'] = $checkval : '';

            endforeach;

            $item['values'] = array_filter($item['values']);

        endforeach;

        return $arr;

    }

}

