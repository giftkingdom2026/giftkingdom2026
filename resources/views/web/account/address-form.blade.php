


<div class="wrap h-100">

	<div class="address-head d-flex justify-content-between align-items-center pb-2">

		<?php

$label = isset($data['label']) 
    ? $data['label'] 
    : \App\Http\Controllers\Web\IndexController::trans_labels('Recipient Details');
		
$txt = isset($data['label']) 
    ? \App\Http\Controllers\Web\IndexController::trans_labels('Show') 
    : \App\Http\Controllers\Web\IndexController::trans_labels('Hide');

		$def = isset( $data['default'] ) && $data['default'] == 'yes' ? 'checked' : '';?>

		<div>
			<h5 class="mb-0"><?=$label?></h5>
<?= $def == 'checked' 
    ? '<small class="text-capitalize">(' . \App\Http\Controllers\Web\IndexController::trans_labels('Default Recipient Details') . ')</small>' 
    : '' 
?>
		</div>


		<div class="d-flex align-items-center justify-content-between gap-3">
			
			<?php if( isset($checkout) && Auth::check() ) : ?>

				<a href="javascript:;" class="edit change-address" data-bs-toggle="modal" data-bs-target="#addresses"><?=App\Http\Controllers\Web\IndexController::trans_labels('Change')?></a>

				<a href="javascript:;" class="edit edit-form btn btn2" data-show="booking-form"><?=$txt?></a>

			<?php elseif( isset($popup) ) :?>
				
				<a href="javascript:;" class="edit edit-form btn btn2" data-show="booking-form"><?=$txt?></a>

			<?php else : 

				$cr = $def == 'checked' ? 'd-none' : '';?>

				<a href="<?=asset('address/remove/'.$key)?>" class="edit <?=$cr?> remove"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.79612 13.7689C4.44356 13.7689 4.14185 13.6435 3.891 13.3926C3.64014 13.1418 3.5145 12.8399 3.51407 12.4869V4.15355H2.87305V2.87149H6.07817V2.23047H9.92433V2.87149H13.1295V4.15355H12.4884V12.4869C12.4884 12.8394 12.363 13.1414 12.1121 13.3926C11.8613 13.6439 11.5594 13.7694 11.2064 13.7689H4.79612ZM11.2064 4.15355H4.79612V12.4869H11.2064V4.15355ZM6.07817 11.2048H7.36023V5.4356H6.07817V11.2048ZM8.64228 11.2048H9.92433V5.4356H8.64228V11.2048Z" fill="#2D3C0A"/></svg></a>

				<a href="javascript:;" class="edit edit-form btn btn2" data-show="booking-form"><?=$txt?></a>

			<?php endif;?>

		</div>

	</div>

	<?php

	$data == '' || $data == null ? $address = '' : $address = 'active';

	$data == '' || $data == null ? $form = 'active' : $form = '';
	\Log::info("Data Comes Here:");
\Log::info($data);
	?>

	<div class="address-detail pt-3 <?=$address?>">

		<address class="m-0">

			<?php

			if( !empty($data) ) : ?>

				<p class="mb-1"><?=$data['firstname']?></p>
				<p class="mb-1"><?=$data['address']?> <?=$data['emirate']?> <?=$data['country']?></p>
				<p class="mb-1 tel"><strong>T:</strong> +971 <?=$data['phone']?> </p>

			<?php else :?>

				<?=App\Http\Controllers\Web\IndexController::trans_labels('No Address Saved Yet!')?>

			<?php endif;?>

		</address>

	</div>

	<div class="form mt-4 <?=$form?>">
		<form class="js-form validate has-response" id="address_form" action="<?=asset('account/update-address')?>" method="POST">

			@csrf

			<div class="row align-items-center careerFilter">

				<?php

				if( isset( $data['url'] ) ) : ?>

					<div class="col-md-12 map-url">
						<a href="javascript:;" class="map-overlap"><svg width="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#6D7D36" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg></i><?=App\Http\Controllers\Web\IndexController::trans_labels('Edit')?></a>
						<iframe src="<?=$data['url']?>" width="100%"></iframe>
						<input type="hidden" name="address[url]" value="<?=$data['url']?>">
					</div>

				<?php endif;

				$cr = $def == 'checked' ? 'd-none' : '';?>


				<div class="col-md-12 mt-4 default-check <?=$cr?>">
					<div class="d-flex justify-content-end">
						<div class="form-group m-0 me-3">
							<label class="form-check-label">
								<input type="checkbox" name="address[default]" <?=$def?> value="yes" class="form-check-input"> <?=App\Http\Controllers\Web\IndexController::trans_labels('Default')?>
							</label>
						</div>
					</div>
				</div>


				<div class="col-lg-12">

					<div class="form-group mb-4 mt-3">

						<label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Address Label')?> *</label>

						<?php $label = isset($data['label']) ? $data['label'] : '';?>

						<input type="text" required name="address[label]" value="<?=$label?>" class="form-control">

						<input type="hidden" name="address[key]" value="<?=$key?>">

					</div>

				</div>

				<div class="col-lg-12">

					<div class="form-group mb-4">

						<label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Recipient Name')?> *</label>

						<?php $firstname = isset($data['firstname']) ? $data['firstname'] : '';?>

						<input type="text" required name="address[firstname]" value="<?=$firstname?>" class="form-control">

					</div>

				</div>

				<!-- <div class="col-lg-6">

					<div class="form-group mb-4">

						<label class="form-label mb-1 ms-3">Last Name *</label>

						<?php $lastname = isset($data['lastname']) ? $data['lastname'] : '';?>

						<input type="text" required name="address[lastname]" class="form-control" value="<?=$lastname?>">

					</div>

				</div> -->

				<div class="col-md-12">

					<div class="form-group mb-3">

						<label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Address')?> *</label>

						<?php $address = isset($data['address']) ? $data['address'] : '';?>

						<input type="text" required name="address[address]" value="<?=$address?>" class="form-control" placeholder="House number and street name">

					</div>

					<div class="form-group mb-3">

						<?php $addressdetails = isset($data['address-details']) ? $data['address-details'] : '';?>

						<input type="text" name="address[address-details]" value="<?=$addressdetails?>" class="form-control" placeholder="Additional address details">

					</div>

				</div>

				<div class="col-lg-6">

					<div class="form-group ct-slct mb-4">

						<label class="mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Country / Region')?> *</label>

						<div class="child_option position-relative">

							<button class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" disabled type="button">UAE<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L7 7L13 1" stroke="black"/></svg></button> 

							<div class="dropdown-menu2 dropdown-menu-right">   

								<ul class="careerFilterInr">

									<li><a href="javascript:;" class="dropdown_select" value="">UAE</a></li>

								</ul>

							</div>

						</div>

						<input type="hidden" name="address[country]" class="inputhide" value="United Arab Emirates">

					</div>

				</div>

				<div class="col-lg-6">

					<div class="form-group ct-slct mb-4">

						<label class="mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Emirate')?> *</label>

						<?php $emirate = isset($data['emirate']) ? $data['emirate'] : '';?>

						<div class="child_option position-relative">

							<button class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" type="button"><?=$emirate != '' ? $emirate : 'Select Emirate' ?><svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L7 7L13 1" stroke="black"/></svg></button> 

							<div class="dropdown-menu2 dropdown-menu-right">   

								<ul class="careerFilterInr">

									<li><a href="javascript:;" class="dropdown_select" value="Abu Dhabi">Abu Dhabi</a></li>

									<li><a href="javascript:;" class="dropdown_select" value="Dubai">Dubai</a></li>

									<li><a href="javascript:;" class="dropdown_select" value="Sharjah">Sharjah</a></li>

									<li><a href="javascript:;" class="dropdown_select" value="Ajman">Ajman</a></li>

									<li><a href="javascript:;" class="dropdown_select" value="Umm Al Quwain">Umm Al Quwain</a></li>

									<li><a href="javascript:;" class="dropdown_select" value="Ras Al Khaimah">Ras Al Khaimah</a></li>

									<li><a href="javascript:;" class="dropdown_select" value="Fujairah">Fujairah</a></li>

								</ul>

							</div>

						</div>	

						<input type="hidden" name="address[emirate]" required value="<?=$emirate?>" class="inputhide">

					</div>

				</div>

				

				<div class="col-lg-6">

					<div class="form-group position-relative mb-4">

						<label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Recipient Phone')?> *</label>

						<?php $phone = isset($data['phone']) ? $data['phone'] : '';?>

						<input type="phone" minlength="9" maxlength="9" required name="address[phone]" value="<?=$phone?>" class="form-control">
						<div class="invalid"><svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#ff0000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg></div>
						<div class="valid"><svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#04ff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></div>
					</div>

				</div>

			</div>

			<?php

			if( !isset( $checkout ) ) : ?>
				
				<div class="row">

					<div class="col-lg-6">

						<?php

						$attr = $key == 'New' ? 'disabled' : '';?>
						<button type="submit" class="btn w-100" <?=$attr?>><?=App\Http\Controllers\Web\IndexController::trans_labels('Save')?></button>

					</div>

				</div>

				<div class="response"></div>
			<?php endif;?>

		</form>
	</div>



</div>





