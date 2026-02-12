<?php



namespace App\Models\Core;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

use App\Models\Web\Index;

use App\Http\Controllers\AdminControllers\SiteSettingController;



class CategoriesToBrands extends Model{



    public $table = 'categories_to_brands';

    public $guarded = [];



    public static function insert($cat,$brand){

        self::create([
            'category_ID' => $cat,
            'brand_ID' => $brand,
        ]);

    }



}

