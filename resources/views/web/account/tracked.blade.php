@extends('web.layout')

@section('content')
<section class="main-section account-section contact-section-one order-tracked-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-3">
				@include('web.account.sidebar')
			</div>
			<div class="col-md-8 col-lg-9">
				
				<div class="acc-right">
					<div class="main-heading mb-4">
						<h2>{{$data['content']['header_text']}}</h2>
						<div class="breadcrumb mt-4">
							<ul class="d-inline-flex align-items-center gap-2">

								<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

								<li>></li>

								<li><a href="<?=asset('account/'.Auth()->user()->user_name)?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Account')?></a></li>

								<li>></li>

								<li><a href="<?=asset('account/track-order')?>">{{$data['content']['pagetitle']}}</a></li>

								<li>></li>

								<li><a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Tracking Details')?></a></li>

							</ul>
						</div>

					</div>
					
					<div class="contactWrap">
						<h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Please Contact')?></h5>
						<p><a class="link" href="mailto:info@thegiftkingdom.com">info@thegiftkingdom.com</a></p>
						<p><?=App\Http\Controllers\Web\IndexController::trans_labels('Order confirmed by thegiftkingdom, our rider will deliver your parcel ASAP')?></p>

						@php
						   $steps = [
					'In Process',
					'Completed',
					'Shipped',
					'Delivered',
					];

						    $currentStatus = $order['order_status'];
						    $currentIndex = array_search($currentStatus, $steps); 
						@endphp

						@if(in_array($currentStatus, $steps))
						    <div class="wizard">
						        <div class="wizard-inner position-relative text-center">
						            <div class="connecting-line"></div>
						            <ul class="nav nav-tabs custom-overlay position-relative row justify-content-between border-0" role="tablist">
						                @foreach($steps as $index => $step)
						                    @php
						                        $stepClass = $index <= $currentIndex ? 'active' : '';
						                    @endphp
						                    <li role="presentation" class="col {{ $stepClass }}">
						                        <a href="#step{{ $index + 1 }}" data-toggle="tab" aria-controls="step{{ $index + 1 }}" role="tab" aria-expanded="false">
						                            <span class="round-tab">{{ App\Http\Controllers\Web\IndexController::trans_labels($step) }}</span>
						                        </a>
						                    </li>
						                @endforeach
						            </ul>
						        </div> 
						    </div>
						@endif

						<h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Details')?></h2>

						<div class="row align-items-center gy-3">
							<div class="col-md-6">
								<div class="card p-4 bg-white">
									<div class="mb-3">
										<span><?=App\Http\Controllers\Web\IndexController::trans_labels('Your order number')?>:</span>		
										<p class="m-0">#<?=$order['ID']?></p>		
									</div>
									<div>
										<span><?=App\Http\Controllers\Web\IndexController::trans_labels('Your order status')?>:</span>		
										<p class="m-0">#<?=App\Http\Controllers\Web\IndexController::trans_labels($order['order_status'])?></p>		
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card p-4 bg-white">
									<div class="mb-3">
										<span><?=App\Http\Controllers\Web\IndexController::trans_labels('Your order from')?>:</span>		
										<p class="m-0">Downtown Dubai, UAE</p>		
									</div>
									<div>
										<span><?=App\Http\Controllers\Web\IndexController::trans_labels('Your order to')?>:</span>
										<?php

										$shipment = unserialize($order['shipping_data']); ?>		
										<p class="m-0"><?=$shipment['address']?></p>		
									</div>
								</div>
							</div>
						</div>
						<a href="tel:(+971) 50000000" class="btn mt-3" tabindex="0"><?=App\Http\Controllers\Web\IndexController::trans_labels('Call Now')?> 
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path></svg>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section>


	@endsection

