<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Web\Usermeta;
use App\Models\Web\Reviews;

use App\Models\Web\Index;

use Auth;

use Session;

class Users extends Model{

	protected $table= 'users';

	protected $guarded = [];


	public static function getUserData($id = 'default'){
		
		$data = [];

		if( Auth::check() ) : $id = $id == 'default' ? Auth()->user()->id : $id; endif;
		
		$data = self::where('id', $id )->first();

		$data ? $data = $data->toArray() : '';

		if( empty ( $data ) ) :

			return null;
			
		endif;

		$meta = Usermeta::where('user_id',$id)->get();

		$meta ? $meta = $meta->toArray() : '';

		$arr = [];

		foreach($meta as $item) :

			$item['meta_value'] = str_contains($item['meta_key'],'image') ? Index::get_image_path( $item['meta_value'] ) : $item['meta_value'];
			
			str_contains($item['meta_key'],'registration') ? $item['meta_value'] = Index::get_image_path( $item['meta_value'] ) : '';
			
			if( $item['meta_key'] == 'residence_id' ) :

				if( $item['meta_key'] != '' ) :

					$val = explode(',',$item['meta_value']);

					foreach( $val as &$file):

						$file =  Index::get_image_path( $file );

					endforeach;
					
					$item['meta_value'] = $val;

				endif;

			endif;

			$item['meta_key'] == 'residence_visa' ? $item['meta_value'] = Index::get_image_path( $item['meta_value'] ) : '';

			$item['meta_key'] == 'bank_confirmation' ? $item['meta_value'] = Index::get_image_path( $item['meta_value'] ) : '';

			$arr[$item['meta_key']] = $item['meta_value'];

		endforeach; 

		$data['metadata'] = $arr;

		if( $data['role_id'] == 4 || $data['role_id'] == 1) :

			$data['review'] =  Reviews::getStoreReviews($id);

		endif; 

		return $data;
		
	}

	public static function getDashboardCustomers(){

		$customers = self::where('role_id',3)->orderBy('created_at', 'DESC')->limit(9)->get()->toArray();

		foreach( $customers as &$customer ) :

			$customer['meta'] = Usermeta::getMeta( $customer['id'] );

		endforeach;

		return $customers;
	}

	public static function updateMeta($key,$value,$id = null ){
		
		$id = $id == null ? Auth()->user()->id : $id;

		if( $key == 'store_credit' ) :

			$check = Usermeta::where([['user_id',$id],['meta_key','store_credit']])->pluck('meta_value')->first();

			!$check ? $check = 0 : '';
			
			$value != 0 ? $value+= $check : '';

			Usermeta::where([['meta_key',$key],['user_id',$id]])->update(['meta_value' => $value]);

		endif;

		$check = Usermeta::where([['meta_key',$key],['user_id',$id]])->first();

		$check ? $check = $check->toArray() : '';

		if( !empty($check) ) :

			Usermeta::where([['meta_key',$key],['user_id',$id]])->update(['meta_value' => $value]);

		else :
			
			Usermeta::create([
				'meta_key' => $key,
				'user_id' => $id,
				'meta_value' => $value
			]);

		endif;

	}



}