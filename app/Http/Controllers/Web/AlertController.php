<?php

namespace App\Http\Controllers\Web;

use Validator;
use Mail;
use DB;
use Hash;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Lang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon;
use App\Models\Web\Alert;

class AlertController extends Controller

{
	public function userDevice($customers_id)
	{

		$alert = new Alert();

		$device = $alert->getUserDevices($customers_id);

		if (count($device) > 0) {

			return $device[0]->device_id;
		} else {

			return '';
		}
	}

	//alert Setting

	public function getAlertSetting()
	{

		$alert = new Alert();

		$setting = $alert->getAlertSetting();

		return $setting;
	}

	//alert Setting

	public function setting()
	{

		$alert = new Alert();

		$setting = $alert->setting();

		return $setting;
	}

	//listingDevices

	public function createUserAlert($existUser)
	{

		//alert setting

		$alertSetting = $this->getAlertSetting();

		//setting

		$setting = $this->setting();

		$existUser[0]->app_name = $setting[18]->value;

		if ($alertSetting[0]->create_customer_email == 1 and !empty($existUser[0]->email)) {

			Mail::send('/mail/createAccount', ['userData' => $existUser], function ($m) use ($existUser) {

				$m->to($existUser[0]->email)->subject('BlingBlingSabaya')->getSwiftMessage()

					->getHeaders()

					->addTextHeader('x-mailgun-native-send', 'true');
			});
		}

		// if($alertSetting[0]->create_customer_notification==1){

		// 	$title = Lang::get("labels.userThankYou");

		// 	$message = Lang::get("labels.welcomeemailtext").$setting[18]->value;

		// 	$sendData = array

		// 		  (

		// 			'body' 	=> $message,

		// 			'title'	=> $title ,

		// 					'icon'	=> 'myicon',/*Default Icon*/

		// 					'sound' => 'mySound',/*Default sound*/

		// 					'image' => '',

		// 		  );

		// 	if($setting[54]->value=='fcm'){

		// 		$functionName = 'fcmNotification';

		// 	}elseif($setting[54]->value=='onesignal'){

		// 		$functionName = 'onesignalNotification';

		// 	}

		// 	//get device id

		// 	$device_id = $this->userDevice($existUser[0]->customers_id);

		// 	if(!empty($device_id)){

		// 		$response = $this->$functionName($device_id, $sendData);

		// 	}

		// }

	}


	//orderAlert

	public function orderAlert($ordersData)
	{

		$alertSetting = $this->getAlertSetting();

		$setting = $this->setting();

		$ordersData['app_name'] = $setting[18]->value;
		$ordersData['orders_data'][0]->admin_email = $setting[70]->value;

		$customer_info = DB::table('users')
			->where('users.id', $ordersData['orders_data'][0]->customers_id)
			->first();
		$ordersData['orders_data'][0]->customer = $customer_info;

		$shipping_info = DB::table('zones')
			->leftJoin('countries', 'countries.countries_id', '=', 'zones.zone_country_id')
			->where('zones.zone_id', $ordersData['orders_data'][0]->billing_city)
			->first();

		$ordersData['orders_data'][0]->shipping_info = $shipping_info;

		// echo view("mail.orderEmail")->with('ordersData', $ordersData)->with('settings' , $setting); exit;

		if ($alertSetting[0]->order_email == 1) {
			if (!empty($ordersData['orders_data'][0]->email)) {

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= 'From: Your name <info@address.com>' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				mail($ordersData['orders_data'][0]->email, 'BlingBling Sabaya: An order has been placed', view("mail.orderEmail")->with('ordersData', $ordersData)->with('settings', $setting), $headers);
			}


			// 	if(!empty($ordersData['orders_data'][0]->admin_email)){

			// 			$headers = "MIME-Version: 1.0" . "\r\n"; 
			// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			// mail($ordersData['orders_data'][0]->admin_email,Lang::get("BlingBling Sabaya: An order has been placed"),view("mail.orderEmail")->with('ordersData', $ordersData),$headers);


			// 	}

		}

		if ($alertSetting[0]->order_notification == 1) {

			$title = Lang::get("labels.OrderTitle");

			$message = Lang::get("labels.OrderDetail") . $setting[18]->value;

			$sendData = array(

				'body' 	=> $message,
				'title'	=> $title,
				'icon'	=> 'myicon',/*Default Icon*/
				'sound' => 'mySound',/*Default sound*/
				'image' => '',
			);

			if ($setting[54]->value == 'fcm') {

				$functionName = 'fcmNotification';
			} elseif ($setting[54]->value == 'onesignal') {

				$functionName = 'onesignalNotification';
			}

			//get device id

			$device_id = $this->userDevice($ordersData['orders_data'][0]->customers_id);

			if (!empty($device_id)) {

				$response = $this->$functionName($device_id, $sendData);
			}
		}
	}

	//listingDevices

	public function forgotPasswordAlert($existUser)
	{

		//alert setting

		$alertSetting = $this->getAlertSetting();
		//setting

		$setting = $this->setting();

		$existUser[0]->app_name = $setting[18]->value;

		if ($alertSetting[0]->forgot_email == 1 and !empty($existUser[0]->email)) {

			// Mail::send('/mail/recoverPassword', ['existUser' => $existUser], function($m) use ($existUser){

			// 	$m->to($existUser[0]->email)->subject(Lang::get("labels.fogotPasswordEmailTitle"))->getSwiftMessage()

			// 	->getHeaders()

			// 	->addTextHeader('x-mailgun-native-send', 'true');

			// });

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			mail($existUser[0]->email, 'Password Recovery', view("mail.recoverPassword")->with('existUser', $existUser), $headers);
		}

		if ($alertSetting[0]->forgot_notification == 1) {

			$title = Lang::get("labels.forgotNotificationTitle");

			$message = Lang::get("labels.forgotNotificationMessage");

			$sendData = array(

				'body' 	=> $message,

				'title'	=> $title,

				'icon'	=> 'myicon',/*Default Icon*/

				'sound' => 'mySound',/*Default sound*/

				'image' => '',

			);

			if ($setting[54]->value == 'fcm') {

				$functionName = 'fcmNotification';
			} elseif ($setting[54]->value == 'onesignal') {

				$functionName = 'onesignalNotification';
			}
			//get device id

			$device_id = $this->userDevice($existUser[0]->id);

			if (!empty($device_id)) {

				$response = $this->$functionName($device_id, $sendData);
			}
		}
	}

	public function fcmNotification($device_id, $sendData)
	{

		//get function from other controller

		$setting = $this->setting();

		#API access key from Google API's Console

		if (!defined('API_ACCESS_KEY')) {

			define('API_ACCESS_KEY', $setting[12]->value);
		}

		$fields = array(
			'to'		=> $device_id,
			'data'	=> $sendData
		);

		$headers = array(

			'Authorization: key=' . API_ACCESS_KEY,

			'Content-Type: application/json'

		);

		#Send Reponse To FireBase Server

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);

		$data = json_decode($result);

		if ($result === false)

			die('Curl failed ' . curl_error());



		curl_close($ch);



		if (!empty($data->success) and $data->success >= 1) {

			$response = '1';
		} else {

			$response = '0';
		}

		//print $response;

	}


	public function onesignalNotification($device_id, $sendData)
	{

		//get function from other controller

		$setting = $this->setting();

		$content = array(

			"en" => $sendData['body']

		);

		$headings = array(

			"en" => $sendData['title']

		);

		$big_picture = array(

			"id1" => $sendData['image']

		);

		$fields = array(

			'app_id' => $setting[55]->value,

			'include_player_ids' => array($device_id),

			'contents' => $content,

			'headings' => $headings,

			'big_picture' => $sendData['image']

		);


		$fields = json_encode($fields);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',

			'Authorization: Basic ZTJhZTcwNzItODQ4Ni00Y2FiLWFjZjEtMGY4ODZhZGZlMGZl'
		));

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_POST, TRUE);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);



		$result = curl_exec($ch);

		$data = json_decode($result);

		curl_close($ch);



		if (!empty($data->recipients) and $data->recipients >= 1) {

			$response = '1';
		} else {

			$response = '0';
		}



		//print $response;



	}
}
