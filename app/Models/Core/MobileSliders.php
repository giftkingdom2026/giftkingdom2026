<?php

namespace App\Models\Core;

use DB;
use Illuminate\Database\Eloquent\Model;
use Lang;

class MobileSliders extends Model
{
	  /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mobile_sliders'

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mobile_slider_id';
}