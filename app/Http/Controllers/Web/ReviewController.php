<?php

namespace App\Http\Controllers\Web;

use App\Models\Web\Index;
use App\Models\Core\Products;
use App\Models\Web\Order;
use App\Models\Core\Orderitems;
use App\Models\Web\Users;
use App\Models\Web\Usermeta;
use App\Models\Web\Reviews;
use App\Http\Controllers\AdminControllers\MediaController;
use Auth;
use DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function submit(Request $request)
    {

        $data = $request->all();

        foreach ($data['upload'] as $media) :

            $file[] = MediaController::mediaUpload($media);

        endforeach;

        unset($data['_token']);

        unset($data['upload']);

        $data['media'] = serialize($file);

        $data['average_rating'] = ($data['object_rating'] + $data['delivery_rating']) / 2;


        $resp = Reviews::create($data);

        return redirect('/account/give-reviews');
    }
}
