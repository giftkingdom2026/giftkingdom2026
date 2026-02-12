<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Session;
use DB;
use Auth;

class ShippingAddressController extends Controller
{


	function getTimeSlots(Request $request)
	{

		date_default_timezone_set("Asia/Dubai");

		$arr = self::timeSlots();

		$slots = $arr[$request->val ?? 'crown-standard']['time-slots'];

		$cond = true;

		if (isset($request->date)) :

			$cond = strtotime(date('Y-m-d', strtotime($request->date))) == strtotime(date('Y-m-d')) ? true : false;

		endif;

		if ($cond) :

			foreach ($slots as $key => $slot) :

				$checktime = substr($slot['time'], 0, 8);

				$check = strtotime(date('H:i')) > strtotime(date('H:i', strtotime($checktime))) || strtotime(date('H:i')) == strtotime(date('H:i', strtotime($checktime)));

				if ($check):

					unset($slots[$key]);

				endif;

			endforeach;

		endif; ?>

		<div class="careerFilter">

			<div class="form-group ct-slct">

				<div class="child_option position-relative">

<button class="form-control text-start w-100 d-flex align-items-center justify-content-between open-menu2 <?php echo !isset($request->data_validate_slots) ? 'p-4' : ''; ?>"
						type="button">Select Time Slot<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1L7 7L13 1" stroke="black"></path>
						</svg></button>

					<div class="dropdown-menu2 dropdown-menu-right" style="display: none;">

						<ul class="careerFilterInr">

							<?php

							if (!empty($slots)) :

								foreach ($slots as $key => $slot) : ?>

									<li><a href="javascript:;" class="dropdown_select change-slot" value="<?= $slot['time'] ?>" data-value="<?= $key ?>"><?= $slot['time'] ?></a></li>

								<?php endforeach;

							else : ?>

								<li><a href="javascript:;" class="dropdown_select change-slot" value="No Slot Available" data-value="000000000">No Slot Available</a></li>

							<?php endif; ?>

						</ul>

					</div>

				</div>
				
<input 
    type="hidden" 
    name="<?php echo isset($request->data_validate_slots) ? 'time-slot-' . $request->data_validate_slots : 'time-slot'; ?>" 
    required 
    value="" 
    class="inputhide"
>
			


			</div>

		</div>

<?php

	}

	function getSlotPrice(Request $request)
	{

		date_default_timezone_set("Asia/Dubai");

		$arr = self::timeSlots();

		$prices = $arr[$request->opt]['time-slots'][$request->val]['prices'];

		if ($request->price > 1 && $request->price <= 150) :

			$key = 0;

		elseif ($request->price > 151 && $request->price <= 500):

			$key = 1;

		elseif ($request->price > 501 && $request->price <= 1000):

			$key = 2;

		elseif ($request->price > 1001):

			$key = 3;

		endif;

		return $prices[$key];
	}


	static function timeSlots()
	{

		$arr = [

			'crown-standard' => [

				'title' => 'Crown Standard',
				'duration' => 'Within the day',
				'time-slots' => [
					['time' => '8:00 AM – 4:00 PM', 'prices' => [30, 0, 0, 0]],
					['time' => '4:00 PM – 11:00 PM', 'prices' => [30, 0, 0, 0]]
				],

			],

			'royal-priority' => [
				'title' => 'Royal Priority',
				'duration' => 'Within two hours',
				'time-slots' => [
					['time' => '8:00 AM - 11:00 PM', 'prices' => [50, 30, 0, 0]],
					['time' => '12:00 PM - 3:00 PM', 'prices' => [50, 30, 0, 0]],
					['time' => '4:00 PM - 7:00 PM', 'prices' => [50, 30, 0, 0]],
					['time' => '8:00 PM - 11:00 PM', 'prices' => [50, 30, 0, 0]]

				]
			],

			'chariot-express' => [
				'title' => 'Chariot Express',
				'duration' => 'Within 60 minutes',
				'time-slots' => [
					['time' => '8:00 AM - 9:00 AM', 'prices' => [100, 75, 50, 0]],
					['time' => '9:00 AM - 10:00 AM', 'prices' => [100, 75, 50, 0]],
					['time' => '10:00 AM - 11:00 AM', 'prices' => [100, 75, 50, 0]],
					['time' => '11:00 AM - 12:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '12:00 PM - 1:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '1:00 PM - 2:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '2:00 PM - 3:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '3:00 PM - 4:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '5:00 PM - 6:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '6:00 PM - 7:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '7:00 PM - 8:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '9:00 PM - 10:00 PM', 'prices' => [100, 75, 50, 0]],
					['time' => '10:00 PM - 11:00 PM', 'prices' => [100, 75, 50, 0]],

				]
			],

			'moonlight-express' => [
				'title' => 'Moonlight Express',
				'duration' => 'Midnight delivery',
				'time-slots' => [
					['time' => '11:00 PM – 12:00 AM', 'prices' => [100, 100, 100, 100]],
				],

			]
		];

		return $arr;
	}

	function checkArea(Request $request)
	{

		$chariot = [
			'Dubai' => [
				'Al Badaa',
				'Al Barsha 1-3',
				'Al Barsha South',
				'Al Diyafah Street',
				'Al Hudaiba',
				'Al Jaddaf',
				'Al Jaffliya',
				'Al Khail Gate-D',
				'Al Manara',
				'Al Quoz 1-4',
				'Al Quoz Industrial Area 1-4',
				'Al Safa 1-2',
				'Al Satwa',
				'Al Sufouh 1-2',
				'Al Wasl',
				'Al Wasl Club',
				'Arabian Ranches 1-2',
				'Arjan Dubailand',
				'Barsha Heights - Tecom',
				'Bluewaters Island',
				'Burj Residences Tower 1-9',
				'Burj View',
				'Business Bay',
				'City Walk',
				'DIFC',
				'Downtown Burj Khalifa',
				'Dubai Design District',
				'Dubai Healthcare City',
				'Dubai Hills',
				'Dubai Marina',
				'Dubai Miracle Garden',
				'Dubai Production City',
				'Emaar Square Bldg 1-6',
				'Emirates Golf Club',
				'Emirates Hills',
				'Greens',
				'IMPZ',
				'Internet City',
				'JBR',
				'JLT - Jumeirah Lake Towers',
				'Jumeirah 1-3',
				'Jumeirah Heights',
				'Jumeirah Islands',
				'Jumeirah Park',
				'Jumeirah Village Circle',
				'Jumeirah Village Triangle',
				'Knowledge Village',
				'La Mer',
				'Meadows 1-9',
				'Media City',
				'Meydan',
				'Motor City',
				'Mudon',
				'Oud Metha',
				'Palm Jumeirah',
				'Safa Park',
				'Sheikh Zayed Road',
				'Sports City',
				'Springs 1-15',
				'The Lakes',
				'Trade Center 1-2',
				'Umm Al Sheif',
				'Umm Suqeim 1-3',
				'Zaabeel 1-2'
			],

			'Abu Dhabi' => [
				'Abu Dhabi Gate City',
				'Abu Dhabi Hills',
				'Abu Dhabi University',
				'Al Forsan Intl Sports Resort',
				'Al Forsan Village',
				'Al Maqta',
				'Al Maqta - Bain Al Jesrain',
				'Al Mariad - Capital Center',
				'Al Mafraq',
				'Al Muntazah',
				'Al Muntazah AUH',
				'Al Rabdan',
				'Al Raha',
				'Al Raha Beach',
				'Al Raha Gardens',
				'Al Rayyana',
				'Al Rowdah',
				'Al Sa\'Adah',
				'Al Saada',
				'Al Zafranah',
				'Al Zeina (Al Raha)',
				'Bani Yas East',
				'Bani Yas West',
				'Bawabat Abu Dhabi',
				'Burjeel Medical City',
				'Capital Centre',
				'Forsan Compound',
				'Golf Gardens',
				'Gulf Garden',
				'ICAD',
				'ICAD 1',
				'Khalifa City A',
				'Khor Al Maqtaa',
				'LLH Hospital Musaffah',
				'Madinat Khalifa - A',
				'Mangrove Village',
				'MBZ Etihad Accom',
				'Mohamed Bin Zayed',
				'Mohammed Bin Zayed City',
				'Mussafah',
				'Mussafah Shabyah',
				'Raha Garden Villas',
				'Rowdhat Abu Dhabi',
				'Sas Al Nakheel Village',
				'Sas Al Nakheel (Khalifa - A)',
				'Sh Zayed Grand Mosque',
				'Zayed Sports City'
			]

		];

		$arr = [

			'Dubai' => [
				'Hatta',
				'Al Lisailli ',
				'Al Ghadeer ',
				'Dubai Industrial City ',
				'Al Marmoum ',
				'Lahbab ',
				'Umm Al Daman ',
				'Tijarah Town'
			],

			'Abu Dhabi' => [
				'Gharbia ',
				'Bida Zayed ',
				'Liwa ',
				'Dhafra ',
				'Riyasi ',
				'Western Region ',
				'Khatam ',
				'Ruwaise ',
				'Madina Zayed',
				'Sila ',
				'Mirfa ',
				'Buhasa ',
				'Tareef ',
				'Al Humra AUH ',
				'Tarif ',
				'Giyathi ',
				'Beda Zayed ',
				'Zayed City'
			],

			'Al Ain' => [
				'Suhwan',
				'Al Wagan',
				'Al Qua',
				'Al Khazna',
				'Abu Samrah',
				'Nahil',
				'Al Yaher',
				'Rimah',
				'Dhahira',
				'Al Araad',
				'Al Faqa',
				'Sweihan',
				'Al Hiyar',
				'Bin Asmad',
				'Al Shuwaib Dam'
			],

			'Sharjah' => [
				'Dhaid ',
				'Maliha ',
				'Madam ',
				'Nazwa ',
				'Soban Musafi Road ',
				'Wadia Al Hello ',
				'Wadi Asma ',
				'Al Zubair ',
				'Muhafiz ',
				'Ibn-E-Rasheed ',
				'Al Batayeh ',
				'Sohaila ',
				'Bir Al Rafiaa'
			],

			'Ajman' => [
				'Manama',
				'Masfoot ',
				'Muzairah'
			],

			'Umm Al Quwain' => [
				'Falaj Al Muwalah',
				'Rashidiya',
				'Madab',
				'Kabir'
			],

			'Fujairah' => [
				'Wadia Mai',
				'Wadi Ejili',
				'Bathna',
				'Al Halla',
				'Tayyaba',
				'Khulaybiyah',
				'Wadi Al Kor',
				'Wadi Munai',
				'Margham',
				'Basna',
				'Wadi Heillo'
			],

			'RAK' => [
				'Khor Khuwair',
				'Havelat',
				'Khatt',
				'Adhan',
				'Al Ghail',
				'Shaam',
				'Galila',
				'Al Jeer',
				'Humrania',
				'Kudra',
				'Masafi',
				'Wadia Sijji'
			]
		];
	}
}
