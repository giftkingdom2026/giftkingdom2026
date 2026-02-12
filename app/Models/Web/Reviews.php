<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use App\Models\Web\Index;
use App\Models\Web\Users;
use App\Models\Core\Products;

class Reviews extends Model
{

    protected $table = 'reviews';

    protected $guarded = [];

    public static function getRating($id)
    {

        $rating = 0;

        $check = self::where([['object_ID', $id], ['approved', 1]])->get();

        if ($check->isNotEmpty()) :

            $check = $check->toArray();

            foreach ($check as $item) :

                $rating += $item['average_rating'];

            endforeach;

            $rating = ($rating / count($check));

        endif;

        return ['rating' => $rating, 'count' => count($check)];
    }

    public static function getReviews($id)
    {

        $rating = 0;

        $check = self::where([['object_ID', $id], ['approved', 1]])->orderBy('created_at', 'desc')->get();

        if ($check->isNotEmpty()) :

            $check = $check->toArray();

            foreach ($check as &$item) :

                $item['rating'] = $item['average_rating'];

                $item['user'] = Users::getUserData($item['customer_ID']);

                $media = $item['media'] != null ? unserialize($item['media']) : [];

                foreach ($media as &$data) :

                    $data = Index::get_image_path($data);

                endforeach;

                $item['media'] = $media;

            endforeach;

        endif;

        return $check;
    }


    public static function getStoreReviews($id)
    {

        $data = Products::where([['prod_parent', 0], ['prod_type', '!=', 'variation']])->where('author_id', '=', $id)->get();

        $object_rating = $seller_rating = $delivery_rating = $average_rating = 0;

        $store = [];
        $store['average_rating']    = 0;
        $store['seller_rating']     = 0;
        $store['object_rating']     = 0;
        $store['delivery_rating']   = 0;

        foreach ($data as &$prod) :

            $check = self::where([['object_ID', $prod->ID], ['approved', 1]])->get();

            $check ? $check = $check->toArray() : '';

            if (!empty($check)) :

                $object_rating = 0;
                $seller_rating = 0;
                $delivery_rating = 0;
                $average_rating = 0;

                foreach ($check as $item) :

                    $object_rating      += $item['object_rating'];
                    $seller_rating      += $item['seller_rating'];
                    $delivery_rating    += $item['delivery_rating'];
                    $average_rating     += $item['average_rating'];

                endforeach;

                $store['average_rating']    += ($average_rating / count($check));
                $store['seller_rating']     += ($seller_rating / count($check));
                $store['object_rating']     += ($object_rating / count($check));
                $store['delivery_rating']   += ($delivery_rating / count($check));

            endif;

        endforeach;

        $store['average_rating'] = ($store['average_rating'] / 5);
        $store['seller_rating'] = ($store['seller_rating'] / 5);
        $store['object_rating'] = ($store['object_rating'] / 5);
        $store['delivery_rating'] = ($store['average_rating'] / 5);


        $store['average_rating_percent']    = round(($store['average_rating'] / 5) * 100);
        $store['seller_rating_percent']     = round(($store['seller_rating'] / 5) * 100);
        $store['object_rating_percent']     = round(($store['object_rating'] / 5) * 100);
        $store['delivery_rating_percent']   = round(($store['delivery_rating'] / 5) * 100);

        $store['average_rating']    = round($average_rating);
        $store['seller_rating']     = round($seller_rating);
        $store['object_rating']     = round($object_rating);
        $store['delivery_rating']   = round($delivery_rating);

        return $store;
    }

    public static function getReviewCommentsHTML($id)
    {
        $reviews = self::where([['object_ID', $id], ['approved', 1]])->get();

        if ($reviews->isEmpty()) {
return '<h5>' . \App\Http\Controllers\Web\IndexController::trans_labels('No Reviews Yet') . '</h5>';
        }

        $reviews = $reviews->toArray();
        $html = '';

        $stars = range(1, 5);
        krsort($stars);

foreach ($reviews as $review) {
    $user = Users::getUserData($review['customer_ID']);
    $firstName = htmlspecialchars($user['first_name'] ?? '');
    $displayName = $review['showusername'] === 'on' 
        ? $firstName 
        : \App\Http\Controllers\Web\IndexController::trans_labels('Anonymous');

    $reviewText = htmlspecialchars($review['review'] ?? '');
    $rating = $review['average_rating'] ?? 0;

    $media = !empty($review['media']) ? unserialize($review['media']) : [];
    $mediaPaths = array_map(function ($img) {
        return asset(\App\Http\Controllers\Web\IndexController::get_image_path($img));
    }, $media);

    // ✅ translated "time ago" parts
    $createdAt = isset($review['created_at']) ? strtotime($review['created_at']) : time();
    $now = time();
    $diffInSeconds = $now - $createdAt;

    if ($diffInSeconds < 60) {
        $ago = $diffInSeconds . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels('seconds ago');
    } elseif ($diffInSeconds < 3600) {
        $ago = floor($diffInSeconds / 60) . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels('minutes ago');
    } elseif ($diffInSeconds < 86400) {
        $ago = floor($diffInSeconds / 3600) . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels('hours ago');
    } elseif ($diffInSeconds < 2592000) {
        $ago = floor($diffInSeconds / 86400) . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels('days ago');
    } elseif ($diffInSeconds < 31536000) {
        $ago = floor($diffInSeconds / 2592000) . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels('months ago');
    } else {
        $ago = floor($diffInSeconds / 31536000) . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels('years ago');
    }

    $html .= '<div class="productdetail-three mb-4">';
    $html .= '<div class="d-flex align-items-center justify-content-between mb-2">';
    $html .= '<div class="d-flex align-items-center gap-3">';
    $html .= '<div class="rating-box d-flex">';
    $html .= '<div class="rating-container">';

    foreach ($stars as $star) {
        $css = $star <= $rating ? 'style="color:#FFBC11"' : '';
        $html .= '<input type="radio" name="rating" value="' . $star . '" id="star-' . $star . '"> ';
        $html .= '<label ' . $css . ' for="star-' . $star . '">&#9733;</label>';
    }

    $html .= '</div></div>';
    $html .= '<h5 class="mb-0">' . $displayName . '</h5>';
    $html .= '</div>';
    $html .= '<aside>' . $ago . '</aside>';
    $html .= '</div>';

    $html .= '<p>' . $reviewText . '</p>';

    if (!empty($mediaPaths)) {
        $html .= '<div class="mt-3 d-flex flex-wrap gap-2">';
        foreach ($mediaPaths as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $videoTypes = ['mp4', 'webm', 'ogg'];

            if (in_array($ext, $videoTypes)) {
                $html .= '<video width="150" controls>
                    <source src="' . $file . '" type="video/' . $ext . '">
                    ' . \App\Http\Controllers\Web\IndexController::trans_labels('Your browser does not support the video tag.') . '
                </video>';
            } else {
                $html .= '<img src="' . $file . '" width="150" alt="*" />';
            }
        }
        $html .= '</div>';
    }

    $html .= '</div>';
}



        return $html;
    }
}
