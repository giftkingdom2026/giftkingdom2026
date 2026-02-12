<?php

namespace App\Models\Web;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Session;
use Auth;
use Mail;

class Usermeta extends Model
{
	

	protected $table = 'usermeta';

	protected $guarded = [];
	
	
	public static function getMeta($id){


		$data = self::where('user_id',$id)->get();

		$data ? $data = $data->toArray() : '';

		$arr = [];

		foreach( $data as $item ) :

			$arr[$item['meta_key']]  = $item['meta_value'];

		endforeach;

		return $arr;
		
	}

	public static function updateAddress($data){

		unset( $data['_token'] );

		if( isset( $data['billing'] ) ) :

			self::updateOrCreate( ['meta_key' => 'billing_address'], [

				'user_id' =>  Auth()->user()->id,

				'meta_key' => 'billing_address',

				'meta_value' => serialize( $data['billing'] )

			]);

		elseif( isset( $data['address'] ) ) :

			$check = self::where([['user_id',Auth::user()->id],['meta_key','address']])->pluck('meta_value')->first();

			if( $check ) :

				$address = unserialize( $check );

				if( isset( $data['address']['default'] ) ) :

					foreach($address as $key => &$addr) :

						if( isset($addr['default']) ) : unset($addr['default']); endif;

					endforeach;

				else :

					$count = count($address);
					
					$check2 = false;

					foreach($address as $key => &$addr) :

						isset($addr['default']) ? $check2 = true : '';

					endforeach;

					!$check2 && isset($address[0]) ? $address[0]['default'] = 'yes' : ''; 

				endif;

				$cond = isset( $data['address']['key'] ) && $data['address']['key'] != 'New';

				if( $cond ) :

					$address[$data['address']['key']] = $data['address'];

				else :

					count($address) == 0 ? $data['address']['default'] = 'yes' : '';
					
					$address[] = $data['address'];

				endif;

				self::where([['user_id',Auth()->user()->id],['meta_key','address']])->update(['meta_value' => serialize($address)]);

			else :

				$data['address']['default'] = 'yes';

				$address[] = $data['address'];

				self::create([

					'user_id' =>  Auth()->user()->id,

					'meta_key' => 'address',

					'meta_value' => serialize( $address )

				]);


			endif;

			// $fromname = 'The Gift Kingdom';
			// $headers = '';
			// $headers .= "From: ".$fromname."<no-reply@thegiftkingdom.com>\r\n";
			// $headers .= "MIME-Version: 1.0\r\n";
			// $headers .= "Content-Type: text/html; charset=iso-8859-1\n";

			// $view = view("mail.address")->with('data', Auth()->user());

			// // $response  = mail(Auth()->user()->email, $fromname.' | Address Added', $view,$headers);
			// $customer_email = Auth()->user()->email;
         // try {
         //       $response =  Mail::send('mail.address', ['data' => Auth()->user()], function($message) use ( $fromname,$customer_email) {
         //    // $settings = Setting::commonContent();

         //            $message->from('sales@thegiftkingdom.com', $fromname)
         //            ->to($customer_email)
         //            ->subject( $fromname.' | Address Added');
         //        });
         //       } catch (\Exception $e) {
         //        dd('Error: ' . $e->getMessage());
         //    }

		elseif( isset( $data['shipping'] ) ) :

			self::updateOrCreate( ['meta_key' => 'shipping_address'], [

				'user_id' =>  Auth()->user()->id,

				'meta_key' => 'shipping_address',

				'meta_value' => serialize( $data['shipping'] )

			]);
			
		endif;
	}
}
