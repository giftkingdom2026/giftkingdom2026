@extends('web.layout')


@section('content')

<div class="modal fade" id="refund" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog w-50 modal-dialog-centered">
		<div class="modal-content p-0">
			<button type="button" style="z-index: 999999;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.3945 15.3947L29.6051 29.6053" stroke="#333333" stroke-width="2" stroke-linecap="round" />
					<path d="M29.6055 15.3947L15.3949 29.6053" stroke="#333333" stroke-width="2" stroke-linecap="round" />
				</svg></button>
			<div class="modal-body mt-3 checkout-section">
				<div class="container">
					<form method="post" action="<?= asset('order/changestatus') ?>">
						@csrf
						<input type="hidden" name="ID" value="<?= $order['ID'] ?>">
						<input type="hidden" name="status" value="Return">
						<div class="row">
							<div class="col-md-12 careerFilter">
								<div class="form-group ct-slct">

									<label class="form-label mb-1 ms-3">
										<h3><?=App\Http\Controllers\Web\IndexController::trans_labels('Reason')?></h3>
									</label>

									<div class="child_option position-relative">

										<button id="hotel" class="form-control open-menu2 text-start d-flex align-items-center justify-content-between active" type="button"><?=App\Http\Controllers\Web\IndexController::trans_labels('Select')?><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round"></path>
											</svg></button>

										<div class="dropdown-menu2 dropdown-menu-right">
											<ul class="careerFilterInr ">
												@if($reasons > 0)
												@foreach($reasons as $reason)
												<li><a href="javascript:;" class="dropdown_select {{$reason['reason_type']}}" value="{{$reason['post_title']}}">{{$reason['post_title']}}</a></li>
												@endforeach
												@endif
											</ul>

										</div>

										<input type="text" class="inputhide" required="" name="comments" value="" style="width: 0px;height: 0px;opacity: 0;margin: 0;padding: 0;position: absolute;">

									</div>

								</div>
							</div>
						</div>
						<button type="submit" id="checkship" class="btn"><?=App\Http\Controllers\Web\IndexController::trans_labels('Submit')?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="shipment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content p-0">
			<button type="button" style="z-index: 999999;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.3945 15.3947L29.6051 29.6053" stroke="#333333" stroke-width="2" stroke-linecap="round" />
					<path d="M29.6055 15.3947L15.3949 29.6053" stroke="#333333" stroke-width="2" stroke-linecap="round" />
				</svg></button>
			<div class="modal-body checkout-section">
				<div class="container">
					<div class="main-heading mt-4">
						<h5>Shipment Details</h5>
					</div>
					<ul class="d-flex flex-column align-items-center gap-3 shipment-data">

					</ul>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="breadcrumb mt-0 mt-lg-4">

	<div class="container">
		<div class="row align-items-center">
			<div class="col-sm-6">

			</div>
			<div class="col-sm-6 text-end">

			</div>
		</div>
	</div>
</div>

<section class="main-section account-section return-section order-detail-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-3">
				@include('web.account.sidebar')
			</div>
			<div class="col-md-8 col-lg-9">
				<div class="acc-right">
					<div class="row align-items-center mb-4 order-top">
						<div class="col-sm-6 col-lg-9">
							<div class="main-heading mb-0">
								<h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Details')?></h2>
								<div class="breadcrumb mt-3 mb-3 mb-lg-0">
									<ul class="d-inline-flex align-items-center gap-2">
										<li><a href="<?= asset('') ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

										<li>></li>

										<li><a href="<?= asset('account/' . Auth()->user()->user_name) ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Account')?></a></li>

										<li>></li>
										<li><a href="javascript:;"><?= App\Http\Controllers\Web\IndexController::trans_labels('Order')?> #<?= $order['ID'] ?></a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-3 text-lg-end">
							<a href="<?= asset('account/orders') ?>" class="back mt-2 mt-sm-0 justify-content-sm-end text"><svg class="me-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.6562 7.5H2.34375" stroke="#6D7D36" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M6.5625 3.28125L2.34375 7.5L6.5625 11.7188" stroke="#6D7D36" stroke-linecap="round" stroke-linejoin="round" />
								</svg><?=App\Http\Controllers\Web\IndexController::trans_labels('Previous Page')?></a>
<h5 class="mb-0 mt-3 text-capitalize">
    <?= $order['payment_status'] == 'Unpaid' && $order['payment_method'] == 'Hyperpay' 
        ? \App\Http\Controllers\Web\IndexController::trans_labels('Payment Pending') 
        : \App\Http\Controllers\Web\IndexController::trans_labels('Order') . ' ' . \App\Http\Controllers\Web\IndexController::trans_labels($order['order_status']) ?>
</h5>
							<?php
							if ($order['order_status'] == 'In Process' && $order['shipmentID'] != null) : ?>

								<a href="javascript:;" class="btn track-shipment" ship-id="<?= $order['shipmentID'] ?>">Track Shipment</a>

							<?php endif; ?>

							<?php

							if ($order['payment_method'] == 'Hyperpay' && $order['payment_status'] == 'Unpaid') : ?>
								<a href="<?= asset('hyperpay/' . $order['ID']) ?>" class="btn">Complete Payment</a>
							<?php endif; ?>

						</div>
					</div>
					<p class="order-detail"><?= App\Http\Controllers\Web\IndexController::trans_labels('Order')?> #<?= $order['ID'] ?> <?= App\Http\Controllers\Web\IndexController::trans_labels('was placed on')?> <?= date('M d, Y', strtotime($order['created_at'])) ?> <?= App\Http\Controllers\Web\IndexController::trans_labels('and is currently')?> <?= App\Http\Controllers\Web\IndexController::trans_labels($order['order_status']) ?>.</p>

					<?php

					if ($order['order_status'] == 'In Process' && $order['shipmentID'] != null) :

						if (date('H', strtotime($order['created_at'])) < 3) : ?>

							<p>Delivery Date: <?= date('d M, Y', strtotime($order['created_at'] . ' + 2 days')); ?> - <?= date('d M, Y', strtotime($order['created_at'] . ' + 3 days')); ?> </p>

						<?php else : ?>

							<p>Delivery Date: <?= date('d M, Y', strtotime($order['created_at'] . ' + 3 days')); ?> - <?= date('d M, Y', strtotime($order['created_at'] . ' + 4 days')); ?> </p>

						<?php endif; ?>

					<?php endif; ?>

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
								$stepClass = $index <= $currentIndex ? 'active' : '' ;
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



					<div class="table-responsive">
						<table class="w-100 cart-section">
							<tr>
								<th><?= App\Http\Controllers\Web\IndexController::trans_labels('Order')?></th>
								<th><?= App\Http\Controllers\Web\IndexController::trans_labels('Total')?></th>
							</tr>

							<?php

							$total = $productsdiscount = $itemtotal = 0;

							$sub = $order['order_subtotal'];

							$total = $order['order_total'];

							$symbol = $order['currency'];

							foreach ($order['items'] as $item) :

  $cond = $item['item_sale_price'] != 0 && $item['item_sale_price'] != null;

                                $price = $cond ? $item['item_sale_price'] * $order['currency_value'] * $item['product_quantity'] : $item['item_price'] * $order['currency_value'] * $item['product_quantity'];

                                if ($cond) :

                                    $defprice = $item['item_price'] * $order['currency_value'] * $item['product_quantity'];

                                else :

                                    $defprice = false;

                                endif;

                                $itemtotal += $defprice ? $defprice : $price;

                                $productsdiscount += $defprice ? $defprice - $price  : 0; 
	
							?>

								<tr>
									<td><?= $item['product']['prod_title'] ?> × <?= $item['product_quantity'] ?><br>

										<?php


										if ($item['item_meta'] != '' && $item['item_meta'] != null) : $meta = '';
											foreach ($item['item_meta'] as $key => $attr) :

												if (isset($attr['attribute']) && $attr['attribute'] != null) :

													$meta .= $attr['attribute']['attribute_title'] . ': ' . $attr['value']['value_title'] . ', ';

												else :

													if (isset($attr['value']) && $attr['value'] != ''):

														$meta .= '<br>Personalized Message: ' . $attr['value'];

													endif;

												endif;

											endforeach; ?>

											<p class="mb-0"><?= rtrim($meta, ', ') ?></p>

										<?php endif; ?>
										@if(isset($item['item_meta']['personal-message']) )
										<p class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Personalized Message')?>: <?= $item['item_meta']['personal-message'] ?></p>
										@endif

									<td>
										<div class="d-flex align-items-center justify-content-between">
											<div>
												<?php

												if ($cond) : ?>

													<span class="price"><?= $symbol ?> <?= number_format($item['item_sale_price'] * $order['currency_value'] * $item['product_quantity'], 2) ?></span>

													<del><small><?= $symbol ?> <?= number_format($item['item_price'] * $order['currency_value'] *  $item['product_quantity'], 2) ?></del></small>

												<?php else : ?>

													<span class="price"><?= $symbol ?> <?= number_format($price * $item['product_quantity'], 2) ?></span>

												<?php endif; ?>

											</div>
											<?php
											$data_attributes = '';
											if (!empty($item['item_meta'])) {
												foreach ($item['item_meta'] as $attr) {
													if (is_array($attr)) {
														if (isset($attr['attribute']) && !empty($attr['attribute'])) {
															$slug = $attr['attribute']['attribute_slug'];

															if (is_array($attr['value']) && isset($attr['value']['value_ID'])) {
																$valueID = $attr['value']['value_ID'];
															} else {
																$valueID = is_string($attr['value']) ? $attr['value'] : '';
															}

															$data_attributes .= ' data-' . htmlspecialchars($slug) . '="' . htmlspecialchars($valueID) . '"';
														} else {
															if (isset($attr['value'])) {
																$personalMsg = is_string($attr['value']) ? $attr['value'] : '';
																$data_attributes .= ' data-personal-message="' . htmlspecialchars($personalMsg) . '"';
															} else {
																$personalMsg = $attr ? $attr : '';
																$data_attributes .= ' data-personal-message="' . htmlspecialchars($personalMsg) . '"';
															}
														}
													} else {
														$data_attributes .= ' data-personal-message="' . htmlspecialchars($attr) . '"';
													}
												}
											}

											?>
											<?php if ($order['order_status'] == 'Delivered') : ?>
												<div class="form-check">
													<input class="form-check-input order-his-check" required type="checkbox" <?= $data_attributes ?> data-variation="<?= $item['variation_ID'] ?>" data-product-id="<?= $item['product_ID'] ?>" data-product-qty="1" id="<?= $item['product_ID'] ?>">
												</div>
											<?php endif; ?>
										</div>



									</td>


								</tr>
								<?php if (!empty($item['delivery_items'])): ?>
									<?php foreach ($item['delivery_items'] as $delivery): ?>
										<tr>
											<td colspan="2">
												<div class="cart-item">
													<div class="row gy-3">
														<!-- Address Column -->
														<div class="col-md-6">
															<div class="address-section">
																<h6 class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Address')?> #{{$delivery['label']}}</h6>
																<address class="mb-0">
																	<p class="mb-0"><strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Name')?>:</strong> <?= $delivery['name'] ?></p>
																	<p class="mb-0"><strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Address')?>:</strong> <?= $delivery['address'] ?></p>
																	<p class="mb-0"><strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Phone')?>:</strong> <?= $delivery['phone'] ?></p>
																</address>
															</div>
														</div>

														<!-- Delivery Details Column -->
														<div class="col-md-6">
															<div class="delivery-details-section">
																<h6 class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Delivery Details')?></h6>
																<p class="mb-0"><strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Delivery Date')?>:</strong> <?= $delivery['delivery_date'] ?></p>
																<p class="mb-0"><strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Time Slot')?>:</strong> <?= $delivery['delivery_time'] ?></p>
															</div>
														</div>
													</div>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endforeach; ?>
							<tr>
								<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Items Total')?>:</td>
								<td><span class="price"><?= $symbol ?> <?= number_format($itemtotal, 2) ?></span></td>
							</tr>
							<?php

							if ($productsdiscount != 0) : ?>



								<tr>
									<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Products Discount')?>:</td>
									<td><span class="price"><?= $symbol ?> -<?= number_format(abs($productsdiscount), 2) ?></span></td>
								</tr>

							<?php endif; ?>

							<tr>
								<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Subtotal')?>:</td>
								<td><span class="price"><?= $symbol ?> <?= number_format($sub, 2) ?></span></td>
							</tr>

							<?php

							if ($order['coupon_code'] != '') : ?>

								<tr>
									<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Coupon')?> (<?= $order['coupon_code'] ?>):</td>
									<td><?= $symbol ?> -<?= number_format($order['coupon_amount'], 2) ?></td>
								</tr>

							<?php endif; ?>

							<?php

							if ($order['credit_amount'] != '' && $order['credit_amount'] != null && $order['credit_amount'] != 0) : ?>

								<tr>
									<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Credit')?> :</td>
									<td>-<?= $symbol ?> <?= number_format($order['credit_amount'] * $order['currency_value'], 2) ?></td>
								</tr>

							<?php endif; ?>

							<tr>
								<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Shipping')?>:</td>
								<td><?= $order['shipping_cost'] == 0 ? 'Free Shipping' : $symbol . ' ' . $order['shipping_cost'] ?></td>
							</tr>

							<tr>
								<td><?= App\Http\Controllers\Web\IndexController::trans_labels('VAT')?>:</td>
								<td><span class="price"><?= $symbol ?> <?= number_format($order['vat'], 2) ?></span></td>
							</tr>

							<tr>
								<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Total')?>:</td>
								<td>
									<span class="total price">
										<?= $symbol ?> <?= number_format($total, 2) ?>
									</span>
								</td>
							</tr>

							<tr>
								<td><?= App\Http\Controllers\Web\IndexController::trans_labels('Payment method')?>:</td>
								<td><?= $order['payment_method'] == 'Hyperpay' ? 'Card Payment' : App\Http\Controllers\Web\IndexController::trans_labels($order['payment_method']) ?></td>
							</tr>

						</table>
					</div>

					<div class="addressWrap mt-4 pt-2">
						<div class="row gy-4">
							<div class="col-lg-6">
								<div class="billing-address">
									<div class="address-head pb-3">
										<h5 class="mb-0"><?= App\Http\Controllers\Web\IndexController::trans_labels('Address')?></h5>
									</div>
									<div class="address-detail active">
										<address class="pt-2 mb-0">

											<?php
											$billing = unserialize($order['billing_data']);
											echo $billing['address'] ?>

											<?= isset($billing['addresstwo']) && $billing['addresstwo'] != '' ? '<br>' . $billing['addresstwo'] : ''; ?>

											<br><?= isset($billing['emirate']) && $billing['emirate'] != '' ? $billing['emirate'] : '' ?>



											<br><?= isset($billing['country']) && $billing['country'] != '' ? $billing['country'] : '' ?>


										</address>


										<span class="d-flex align-items-center gap-2 mt-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M6.78937 2.26714L8.21223 1.83857C8.85993 1.64316 9.55661 1.69014 10.1722 1.97074C10.7878 2.25133 11.2803 2.74637 11.5577 3.36343L12.4431 5.33314C12.6817 5.86377 12.7481 6.45578 12.6331 7.0261C12.5182 7.59642 12.2275 8.11642 11.8019 8.51314L10.2548 9.95572C10.2363 9.9741 10.2207 9.9952 10.2085 10.0183C10.0465 10.3491 10.2925 11.2329 11.0631 12.5683C11.9322 14.0734 12.6034 14.6683 12.9145 14.5766L14.9451 13.9551C15.5012 13.7853 16.0965 13.7938 16.6475 13.9793C17.1986 14.1648 17.6778 14.5181 18.0179 14.9897L19.2762 16.7323C19.6713 17.2794 19.8543 17.9514 19.7912 18.6233C19.7281 19.2952 19.4233 19.9213 18.9334 20.3854L17.8508 21.4097C17.4743 21.7663 17.0172 22.0265 16.5184 22.1682C16.0196 22.3098 15.4939 22.3287 14.9862 22.2231C11.9717 21.5957 9.2708 19.1683 6.86051 14.994C4.44937 10.8171 3.69766 7.26 4.66623 4.33457C4.82836 3.84481 5.106 3.40126 5.4757 3.04142C5.84539 2.68157 6.29541 2.416 6.78937 2.26714ZM7.16223 3.498C6.86584 3.58727 6.59529 3.74658 6.37344 3.96246C6.1516 4.17833 5.98498 4.44444 5.88766 4.73829C5.0528 7.25914 5.72909 10.4614 7.9748 14.3511C10.2188 18.2383 12.6514 20.424 15.2494 20.964C15.554 21.0272 15.8694 21.0158 16.1686 20.9307C16.4679 20.8457 16.7421 20.6894 16.9679 20.4754L18.0497 19.452C18.3136 19.2022 18.4778 18.865 18.5119 18.5032C18.5459 18.1414 18.4475 17.7795 18.2348 17.4849L16.9765 15.7414C16.7934 15.4876 16.5354 15.2973 16.2388 15.1974C15.9421 15.0975 15.6216 15.0929 15.3222 15.1843L13.2865 15.8074C12.1602 16.1426 11.1008 15.204 9.95051 13.2103C8.97594 11.5234 8.63823 10.3046 9.0548 9.45343C9.13594 9.28772 9.24394 9.14172 9.3788 9.01543L10.9259 7.57286C11.1552 7.35924 11.3118 7.0792 11.3737 6.77205C11.4357 6.4649 11.3999 6.14606 11.2714 5.86029L10.3851 3.89143C10.2357 3.55908 9.97052 3.29246 9.63896 3.14135C9.30741 2.99024 8.93219 2.96498 8.58337 3.07029L7.16223 3.498Z" fill="#2D3C0A" />
											</svg><?= $billing['phone'] ?></span>
										<span class="d-flex align-items-center gap-2 mt-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M7 9L12 12.5L17 9" stroke="#2D3C0A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
												<path d="M2 17V7C2 6.46957 2.21071 5.96086 2.58579 5.58579C2.96086 5.21071 3.46957 5 4 5H20C20.5304 5 21.0391 5.21071 21.4142 5.58579C21.7893 5.96086 22 6.46957 22 7V17C22 17.5304 21.7893 18.0391 21.4142 18.4142C21.0391 18.7893 20.5304 19 20 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17Z" stroke="#2D3C0A" stroke-width="1.2" />
											</svg><?= $billing['email'] ?></span>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="delivery-details">
									<div class="address-head pb-3">
										<h5 class="mb-0"><?= App\Http\Controllers\Web\IndexController::trans_labels('Delivery')?></h5>
									</div>
									<div class="address-detail active">
										<address class="pt-2 mb-0">

											<strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Delivery Option')?>: </strong><span><?= str_replace('-', ' ', $order['delivery_option']) ?></span>
											<br>
											<strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Delivery Date')?>: </strong><span><?= $order['delivery_date'] ?></span>
											<br>
											<strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Time Slot')?>: </strong><span><?= $order['time_slot'] ?></span>

										</address>

									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<?php

							if ($order['order_information'] != '') : ?>

								<div class="col-md-12">
									<div class="wrap">
										<h5><?= App\Http\Controllers\Web\IndexController::trans_labels('Order Note')?>:</h5>
										<p><?= $order['order_information'] ?></p>
									</div>
								</div>

							<?php endif; ?>

							<?php

							$refcanc = false;

							if ($order['order_status'] == 'Refund' && isset($order['refund'])) : $refcanc = true; ?>

								<div class="col-md-12">
									<div class="wrap">
										<h5><?= App\Http\Controllers\Web\IndexController::trans_labels('Reason of refund')?>:</h5>
										<p><?= $order['refund'] ?></p>
									</div>
								</div>

							<?php endif; ?>

							<?php

							if ($order['order_status'] == 'Cancelled' && isset($order['cancel'])) : $refcanc = true; ?>

								<div class="col-md-12">
									<div class="wrap">
										<h5><?= App\Http\Controllers\Web\IndexController::trans_labels('Reason for cancellation')?>:</h5>
										<p><?= $order['cancel'] ?></p>
									</div>
								</div>

							<?php endif; ?>
							<div class="col-md-12">

								<div class="d-flex justify-content-sm-end flex-wrap gap-3">
									<?php

									if (!$refcanc) : ?>
										<?php if ($order['order_status'] == 'Delivered') : ?>
											<a href="javascript:;" class="reorder-to-cart btn"><?= App\Http\Controllers\Web\IndexController::trans_labels('Order Again')?></a>
										<?php endif; ?>


										<?php if ($order['order_status'] == 'Delivered' && $order['payment_method'] == 'Cash on Delivery') :

											date_default_timezone_set('Asia/Dubai');

											$curr = strtotime(date('Y/m/d H:i:s'));

											$update = strtotime(date('Y/m/d H:i:s', strtotime($order['updated_at'] . '+ 3 days'))); ?>

											<a href="javascript:;" class="btn cancel-refund" data-bs-toggle="modal" data-bs-target="#refund"><?= App\Http\Controllers\Web\IndexController::trans_labels('Request Refund')?></a>

										<?php

										elseif ($order['order_status'] == 'In Process' && $order['payment_method'] == 'Cash on Delivery') : ?>

											<a href="javascript:;" class="btn cancel-refund cancel" data-bs-toggle="modal" data-bs-target="#refund"><?= App\Http\Controllers\Web\IndexController::trans_labels('Cancel This Order')?></a>

										<?php

										endif; ?>

								</div>
							</div>

						<?php endif; ?>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
</section>

@endsection