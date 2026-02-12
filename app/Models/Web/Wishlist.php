<?php



namespace App\Models\Web;



use Illuminate\Database\Eloquent\Model;



use App\Models\Web\Index;



use App\Models\Web\WishlistItems;



use Session;



use Auth;



class Wishlist extends Model{



	protected $table= 'wishlist';

	protected $guarded = [];

	

	public static function productExists($id){

		$check = self::wishlistExists();

		if( $check ) :

			$item = WishlistItems::where([['product_ID',$id],['wishlist_ID',$check->wishlist_ID]])->first();

			return $item;			

		else : 

			return false;

		endif;

	}



	public static function addOrRemove($data){
		$session = Session::getId();

		$user = Auth::check() ? Auth::user()->id : 0;

		$data['var_id'] = isset($data['var_id']) ? $data['var_id'] : 0;

		Auth::check() ? $where = ['user_id', Auth::user()->id] : $where = ['session_id', $session];

		$check = self::where([$where])->first();

		if( !$check ) :

			$wish = self::create([

				'session_id' => $session,

				'user_id' => $user,

				'wishlist_count' => 1,

			]);


			$wishid = $wish->id;

		else :

			$wishid = $check->wishlist_ID;


		endif;

		if(isset($data['variation'])) : 

			$var['variation'] = $data['variation'];

			$var['attributes'] = $data['attributes'];

		else :

			$var = [];

		endif;

		$data['serial'] = $data['serial'] ?? '';
		$response = WishlistItems::addOrRemoveItem($wishid,$data['id'] , $data['var_id'] , $var , $data['serial']);

		return $response;

	}


	public static function mergeItems($sessionID){
		
		$where = ['session_id',$sessionID];
		
		$where2 = ['user_id',Auth()->user()->id];

		$wishprev = self::where([$where] )->first();
		
		$wishnew = self::where([$where2] )->first();

		if( $wishprev ) :

			WishlistItems::where('wishlist_ID',$wishprev->wishlist_ID)->update(['wishlist_ID'=>$wishnew->wishlist_ID]);

			$items = WishlistItems::where('wishlist_ID',$wishnew->wishlist_ID)->get();

			$items ? $items = $items->toArray() : '';

			foreach($items as $item) :

				isset($count[$item['product_ID']]) ?  $count[$item['product_ID']]['count']++ : $count[$item['product_ID']]['count'] = 1; 

				$count[$item['product_ID']]['item'] = $item['id'];

			endforeach;

			foreach($count as $em) :

				if($em['count'] > 1) :
					
					WishlistItems::where('id',$em['item'])->delete();

				endif;

			endforeach;

		endif;
	}


	public static function getWishlist(){

		$session = Session::getId();

		$user = Auth::check() ? Auth::user()->id : 0;

		Auth::check() ? $where = ['user_id', Auth::user()->id] : $where = ['session_id', $session];

		$check = self::where([$where])->first();

		if( $check ) :

			$check->toArray();

			$check['items'] = WishlistItems::getItems($check['wishlist_ID']);

		endif;

		return $check;

	}



	public static function getCount(){

		$session = Session::getId();

		$user = Auth::check() ? Auth::user()->id : 0;

		Auth::check() ? $where = ['user_id', Auth::user()->id] : $where = ['session_id', $session];

		$check = self::where([$where])->first();

		$count = 0;

		if( $check ) :

			$check->toArray();

			$items = WishlistItems::getItems($check['wishlist_ID']);

			$count = count($items);

		endif;

		return $count;

	}



	public static function wishlistExists(){

		$session = Session::getId();

		$user = Auth::check() ? Auth::user()->id : 0;

		Auth::check() ? $where = ['user_id', Auth::user()->id] : $where = ['session_id', $session];

		$check = self::where([$where])->first();

		return $check;

	}


	public static function removeItem($id) {

		WishlistItems::where('item_ID',$id)->delete();

	} 

}	





