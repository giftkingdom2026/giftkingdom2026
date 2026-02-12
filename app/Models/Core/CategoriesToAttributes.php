<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Models\Web\Index;

use App\Models\Core\Values;

use App\Models\Core\Termmeta;

use App\Models\Core\Attributes;

use App\Http\Controllers\AdminControllers\SiteSettingController;



class CategoriesToAttributes extends Model{



    public $table = 'categories_to_attributes';

    public $guarded = [];


    public static function getData($cat,$attrs = []){

        $arr = Attributes::whereNotIn('attribute_ID',[18,17])->pluck('attribute_ID');

        $arr ? $arr = $arr->toArray() : '';

        foreach($arr as $key => &$attr) :

            $id = $attr;

            $attr = [];

            $attribute = Attributes::where('attribute_ID',$id)->first();
            
            $attribute ? $attribute = $attribute->toArray() : '';
            
            if( !empty($attribute) ) :

                $cond = session()->has('lang_id') && session('lang_id') != 1;

                if( $cond ) :

                    $where = [['taxonomy_id',447218073],['terms_id',$attribute['attribute_ID']],['meta_key','attribute_title'],['lang',session('lang_id')]];

                    $attribute['attribute_title'] = Termmeta::where($where)->pluck('meta_value')->first();

                endif;

                $attr['attribute'] = $attribute;

                $values = Values::where('attribute_ID',$id)->get();

                $values ? $values = $values->toArray() : '';

                foreach($values as $key => &$val) :

                    if( $cond ) :

                        $where = [['taxonomy_id',741035],['terms_id',$val['value_ID']],['meta_key','value_title'],['lang',session('lang_id')]];

                        $val['value_title'] = Termmeta::where($where)->pluck('meta_value')->first();

                    endif;

                    in_array($val['value_ID'], $attrs) ? $val['active'] = true : '';
                    
                    in_array($val['value_ID'], $attrs) ? $attr['active'] = true : '';

                endforeach;

                $attr['values'] = $values;

            endif;

        endforeach;

        $arr = array_filter($arr);


        return $arr;
    }

    public static function insert($cat,$attr){

        self::create([

            'category_ID' => $cat,

            'attribute_ID' => $attr,

        ]);

    }

}

