<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;



class AbandonedCartBasket extends Model
{
    public $table = "customers_basket";
    use Sortable;

    

}
