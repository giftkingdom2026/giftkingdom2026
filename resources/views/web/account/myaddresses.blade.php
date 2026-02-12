@extends('web.layout')



@section('content')


<div class="modal fade checkout-section contact-section-one" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body p-0">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"/><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"/></svg></button>
				<div class="col-md-12 mt-5">
					<form>
						<div class="mb-3 form-group">
							<input type="text" id="pac-input" class="form-control" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter your address')?>">
						</div>
					</form>
					<div id="map" style="height: 300px; width: 100%;"></div>
					<button id="showStep2Btn" class="btn mt-3 mb-3" disabled><?=App\Http\Controllers\Web\IndexController::trans_labels('Confirm Location')?></button>
				</div>
			</div>
		</div>
	</div>
</div>





<section class="main-section account-section return-section order-detail-section my-add-sec">

	<div class="container">

		<div class="row">

			<div class="col-md-4 col-lg-3">

				@include('web.account.sidebar')

			</div>



			<div class="col-md-8 col-lg-9">

				@if(session()->has('message'))

				<?php $c = str_contains(session()->get('message'), 'Donot') ? 'alert-danger' : 'alert-success';?>

				<div class="alert <?=$c?> msg_alert">

					{{ session()->get('message') }}

				</div>

				@endif
				
				<div class="acc-right">

					<div class="main-heading">
						<h2>{{$data['content']['pagetitle']}}</h2>
						<div class="breadcrumb mt-3">

						<div class="container">

							<ul class="d-inline-flex align-items-center gap-2">

								<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

								<li>></li>

								<li><a href="<?=asset('account/'.Auth()->user()->user_name)?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Account')?></a></li>

								<li>></li>

								<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>

							</ul>

						</div>

					</div>
					</div>
						
					

						
						<div class="addressWrap">
							
							<div class="add_form_address">

								<div class="row gy-4">

								<?php

								$meta = $result['metadata'];

								$addresses = isset($meta['address']) ? unserialize($meta['address']) : []; 

								$cond = count($addresses) == 1 ? true : false;


								foreach($addresses as $key => $addr) : ?>

									<div class="col-md-12 col-xl-12">

									@include('web.account.address-form',['data' => $addr, 'key' => $key, 'cond' => $cond])

									</div>

								<?php endforeach;?>

								</div>

							</div>

							<div>
									<a href="javascript:;" class="btn btn2 add-address" data-bs-toggle="modal" data-bs-target="#addressModal"><?=App\Http\Controllers\Web\IndexController::trans_labels('Add Address')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#fff"></path></svg>
									</a>
							</div>

						</div>


				</div>

			</div>

		</div>

	</div>

</div>

</section>

@push('scripts')

<script src="<?=asset('assets/js/map.js')?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjacv_lH_wEwBBWJmewcMXhwTmK4tg2y8&callback=initAutocomplete&libraries=places&v=weekly">
</script>

@endpush

@endsection



