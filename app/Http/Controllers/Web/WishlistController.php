<?php

namespace App\Http\Controllers\Web;





use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\IndexController;

use App\Models\Core\Pages;
use App\Models\Web\Content;
use App\Models\Web\Wishlist;
use App\Models\Core\Products;
use App\Models\Web\WishlistItems;

use App\Models\Web\Cart;

use Route;


class WishlistController extends Controller{

	public function list(Request $request){

$page = Pages::where('slug', 'wishlist')->first();
$lang = session()->get('lang_id', 1);

$content = Content::where('page_id', $page->page_id)
                  ->where('lang', $lang)
                  ->get();

if ($content->isEmpty() && $lang != 1) {
    $content = Content::where('page_id', $page->page_id)
                      ->where('lang', 1)
                      ->get();
}

$data['content'] = IndexController::parseContent($content->toArray());


		$data['wishlist'] = Wishlist::getWishlist();

		if( empty($data['wishlist']->items) ) :

			// $data['products'] = Products::getRandom();

		endif;

		$title = ['title' => 'Wishlist' ];
			$data['products'] = \App\Models\Web\Products::getRandom();

		$view = (Route::current()->uri == 'account/wishlist') ? 'account.wishlist' : 'wishlist';

		return view("web.".$view, $title)->with('data', $data);

	}


	public function addOrRemove(Request $request){
		$response = Wishlist::addOrRemove($request->all());

		return json_encode(['message' => $response['message'],'count' => $response['count']]);
	}



	public function removeFromCart(Request $request){

		$response = Wishlist::addOrRemove($request->all());

		Cart::removeItem($request->id);

		return json_encode(['message' => $response['message'],'count' => $response['count']]);

	}

	public function removeItem(Request $request){

		Wishlist::removeItem($request->id);

		return redirect()->back()->with('message','Item Removed!');

	}

	public function addCart(Request $request){

		if( isset( $request->id ) ) :

			$item = WishlistItems::where('item_ID',$request->id)->first();
		    $exists = Cart::checkIfExists($item['product_ID'], $item->item_meta);

		    if ($exists) {
			    return response()->json(['status' => 'exists']);
		    } 
			Cart::add(['ID' => $item['product_ID'], 'qty'=> 1 , 'serial' => $item->item_meta]);

			// Wishlist::removeItem($request->id);

		else:

			$data = Wishlist::getWishlist();

			foreach($data['items'] as $item):

				$serial_meta = isset($item['serial_meta']) ? $item['serial_meta'] : '';

				Cart::add(['ID' => $item['product_ID'], 'qty'=> 1 , 'serial' => $serial_meta]);

				// Wishlist::removeItem($item['item_ID']);

			endforeach;

		endif;

	}

	public function empty(Request $request){

		$data = Wishlist::getWishlist();

		foreach($data['items'] as $item):

			Wishlist::removeItem($item['item_ID']);

		endforeach;
	}
	
}

