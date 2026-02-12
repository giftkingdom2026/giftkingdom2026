<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Models\Web\Index;

use App\Models\Core\CategoriesToAttributes;

use App\Http\Controllers\AdminControllers\SiteSettingController;



class Values extends Model{



    public $table = 'attribute_values';

    public $guarded = [];



    public static function list( $id = null ){



        $arr = self::where( 'attribute_ID', $id )->get();



        $arr ? $arr = $arr->toArray() : '';



        return $arr;

    }



    public static function addValue($data){



        unset($data['_token']);

        // dd($data);
        if(isset($data['value_type']) && $data['value_type'] == 'image'){
            $value_image=$data['value_image'];
        }else{
            $value_image='';
        }
        $attr = self::create([

            'attribute_ID' => $data['attribute_ID'],

            'value_title' => $data['value_title'],

            'value_slug' => $data['value_slug'],

            'value_image' => $value_image,

            'value_type' => $data['value_type'],


        ]);



    }



    public static function search($keyword){



        $data = self::where('value_title', 'like' , '%'.$keyword.'%' )->get();



        $data ? $data = $data->toArray() : '';



        $arr = [];



        foreach($data as $item) :



            $arr[] = [ 'id' => $item['value_ID'], 'text' => $item['value_title'] ];



        endforeach;



        return json_encode($arr);



    }

}

