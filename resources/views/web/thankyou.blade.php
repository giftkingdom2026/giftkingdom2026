@extends('web.layout')

@section('content')



<pre style="display:none">



	<?php

	print_r($order);

	?>

	<?php

	$order['billing_data'] = unserialize($order['billing_data']);

	$payment = $order['payment_method'] == 'Hyperpay' ? 'Credit' : 'COD'; ?>

</pre>

<section class="main-section inner-banner thankyou-banner">

	<div class="container">

		<div class="wizard">
			<div class="wizard-inner position-relative text-center">
				<div class="connecting-line"></div>
				<ul class="nav nav-tabs custom-overlay position-relative row justify-content-between border-0" role="tablist">
					<li role="presentation" class="col active">
						<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">Cart</span></a>
					</li>
					<li role="presentation" class="col active">
						<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">Order Summary</span></a>
					</li>
					<li role="presentation" class="col active">
						<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" aria-expanded="false"><span class="round-tab">Order Placed</span></a>
					</li>
				</ul>
			</div>
		</div>

		<article class="py-2 overflow-hidden">

			<div class="row justify-content-between align-items-center">

				<div class="col-md-5">

					<div class="d-flex gap-3 flex-column wow fadeInUp">
						<h1 class="mb-0">{{$data['content']['banner_text']}}</h1>

						<p class="mb-0">{{$data['content']['desc_banner']}}</p>

						<a href="{{$data['content']['btn_link']}}" class="btn btn2 mt-2">{{$data['content']['btn_text']}} <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#fff"></path>
							</svg></a>

					</div>

				</div>

				<div class="col-md-4">

					<figure class="overflow-hidden mt-3 mt-lg-0">

						<img src="<?= asset('images/media/2025/02/THank you.png') ?>" alt="*" class="wow">

					</figure>

				</div>

			</div>

		</article>

	</div>

</section>

<section class="main-section thankyou-section-one py-0 abt-secs">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-lg-12 col-xl-10">

				<div class="thankyou-inner-one">

					<div class="account-section cart-section mt-0 return-section order-detail-section">

						<div class="acc-right">

							<div class="main-heading mb-5">
								<h2 class="mb-3">Order Details</h2>
								<h5 class="m-0 text-uppercase fw-bold">Order <?= $order['order_status'] ?></h3>
							</div>
							<div class="table-responsive">
								<table class="w-100">
									<tr>
										<th>Order #<?= $order['ID'] ?></th>
										<th>Total</th>
									</tr>
									<?php
									$total = $productsdiscount = $itemtotal = 0;

									$sub = $order['order_subtotal'];
									$total = $order['order_total'];
								
									$symbol = $order['currency'];
									foreach ($order['items'] as $item) :
										$cond = $item['item_sale_price'] != 0 && $item['item_sale_price'] != null;

$regular_price = $item['item_price'] * $order['currency_value'];
$sale_price = $item['item_sale_price'] * $order['currency_value'];

$price = $cond ? $sale_price : $regular_price;

$itemtotal += $item['item_price'] * $item['product_quantity'] * $order['currency_value'];

$productsdiscount += $cond ? ($regular_price - $sale_price) * $item['product_quantity'] : 0;

									?>

										<tr>
											<td colspan="2"> <!-- Or split into multiple <td>s if needed -->
												<div class="cart-item">
													<div class="cart-item-select">
														<ul class="d-flex justify-content-between align-items-center flex-wrap gap-2 gap-md-0">
															<li class="cart-item-thumb">
																<div class="d-flex align-items-center gap-4">
																	<figure>
																		<img src="<?= asset($item['product']['prod_image']) ?>" class="w-100 wow">
																	</figure>
																	<div class="cart-item-meta text-start">
																		<h5 class="text-capitalize">
																			<a href="<?= asset('product/' . $item['product']['prod_slug']) ?>">
																				<?= $item['product']['prod_title'] ?>
																			</a>
																		</h5>

																		<?php
																		if (!empty($item['item_meta'])):
																			$meta = '';
																			foreach ($item['item_meta'] as $attr):
																				if (!empty($attr['attribute'])) {
																					$meta .= $attr['attribute']['attribute_title'] . ': ' . $attr['value']['value_title'] . ', ';
																				} elseif (!empty($attr['value'])) {
																					$meta .= '<br>Personalized Message: ' . $attr['value'];
																				}
																			endforeach;
																			echo '<p class="mb-2">' . rtrim($meta, ', ') . '</p>';
																		endif;
																		?>
																	</div>
																</div>
															</li>
															<li class="cart-item-totals">
																<span class="d-block">Qty: <?= $item['product_quantity'] ?></span>
															</li>
															<li class="reviews">
@php
    $updatedPrice = !empty($item['item_sale_price']) && $item['item_sale_price'] > 0
        ? (float) $item['item_sale_price']
        : (float) $item['item_price'];
@endphp
<strong class="d-block fw-normal total">
    {{ $order['currency'] }} {{ number_format($updatedPrice * $order['currency_value'] * $item['product_quantity'], 2) }}
</strong>
																@if($item['item_sale_price'] && $item['item_sale_price'] != 0 && $item['item_sale_price'] != $item['item_price'])
																<del><small class="d-block fw-light mb-2"><?= $order['currency'] ?> <?= number_format($item['item_price'] * $order['currency_value'] * $item['product_quantity'],2) ?> </small></del>
																@endif
															</li>
														</ul>
													</div>
												</div>
											</td>
										</tr>
	<?php if (!empty($item['delivery_items'])): ?>
										<?php foreach ($item['delivery_items'] as $delivery): ?>
											<tr>
												<td colspan="2">
													<div class="cart-item text-start">
														<div class="row gy-3">
															<!-- Address Column -->
															<div class="col-md-6">
																<div class="address-section">
																	<h6 class="mb-2">Address #<?= $delivery['label'] ?></h6>
																	<address class="mb-0">
																		<p class="mb-0"><strong>Name:</strong> <?= $delivery['name'] ?></p>
																		<p class="mb-0"><strong>Address:</strong> <?= $delivery['address'] ?></p>
																		<p class="mb-0"><strong>Phone:</strong> <?= $delivery['phone'] ?></p>
																	</address>
																</div>
															</div>

															<!-- Delivery Details Column -->
															<div class="col-md-6">
																<div class="delivery-details-section">
																	<h6 class="mb-2">Delivery Details</h6>
																	<p class="mb-0"><strong>Delivery Date:</strong> <?= $delivery['delivery_date'] ?></p>
																	<p class="mb-0"><strong>Time Slot:</strong> <?= $delivery['delivery_time'] ?></p>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
									<?php endforeach; ?>

								

							</div>
							</td>
							</tr>
							<?php

							if ($productsdiscount != 0) : ?>

								<tr>
									<td>Items Total:</td>
									<td><span class="price"><?= $symbol ?> <?= number_format($itemtotal, 2) ?></span></td>
								</tr>

								<tr>
									<td>Products Discount:</td>
									<td><span class="price"><?= $symbol ?> -<?= number_format(abs($productsdiscount), 2) ?></span></td>
								</tr>

							<?php endif; ?>

							<tr>
								<td>Subtotal:</td>
								<td><span class="price"><?= $symbol ?> <?= number_format($sub, 2) ?></span></td>
							</tr>

							<?php

							if ($order['coupon_code'] != '') : ?>

								<tr>
									<td>Coupon (<?= $order['coupon_code'] ?>):</td>
									<td>-<?= $symbol ?> <?= number_format($order['coupon_amount'], 2) ?></td>
								</tr>

							<?php endif; ?>


							<tr>
								<td>Shipping:</td>
								<td><?= $order['shipping_cost'] == 0 ? 'Free Shipping' : $symbol . ' ' . $order['shipping_cost'] ?></td>
							</tr>

							<tr>
								<td>VAT:</td>
								<td><span class="price"><?= $symbol ?> <?= number_format($order['vat'], 2) ?></span></td>
							</tr>

							<?php

							if ($order['credit_amount'] != 0 && $order['credit_amount'] != '' && $order['credit_amount'] != null) : ?>

								<tr>
									<td>Used Wallet Balance</b></td>
									<td>-<?= $symbol ?> <?= number_format($order['credit_amount'] * $order['currency_value'], 2) ?></td>
								</tr>

							<?php endif; ?>

							<tr>
								<td>Total:</td>
								<td>
									<span class="total price">
										<?= $symbol ?> <?= number_format($total, 2) ?>
									</span>
								</td>
							</tr>
							<tr>
								<td>Payment method:</td>
								<td><?= ($order['payment_method']) ?></td>
							</tr>
							</table>
						</div>

						<div class="addressWrap mt-2 mt-lg-5 pt-0 pt-lg-2">
							<div class="row wrap">
								<div class="col-lg-6">
									<div class="billing-address">
										<div class="address-head pb-3">
											<h5 class="mb-0">Address</h5>
										</div>


										<div class="address-detail active">
											<address class="pt-2 mb-0">

												<?php
												$billing = ($order['billing_data']);

												echo $billing['address'] ?>

												<?= isset($billing['addresstwo']) && $billing['addresstwo'] != '' ? '<br>' . $billing['addresstwo'] : ''; ?>

												<br><?= isset($billing['emirate']) && $billing['emirate'] != '' ? $billing['emirate'] : '' ?>


												<br><?= $billing['country'] ?>


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
											<h5 class="mb-0">Delivery</h5>
										</div>
										<div class="address-detail active">
											<address class="pt-2 mb-0">

												<strong>Delivery Option: </strong><span><?= str_replace('-', ' ', $order['delivery_option']) ?></span>
												<br>
												<strong>Delivery Date: </strong><span><?= $order['delivery_date'] ?></span>
												<br>
												<strong>Time Slot: </strong><span><?= $order['time_slot'] ?></span>

											</address>

										</div>
									</div>
								</div>
							</div>

							<?php

							if ($order['order_information'] != '') : ?>

								<div class="row mt-3">
									<div class="col-md-12">
										<div class="wrap">
											<h5>Order Note:</h5>
											<p><?= $order['order_information'] ?></p>
										</div>
									</div>
								</div>

							<?php endif; ?>

						</div>
					</div>

				</div>
			</div>

		</div>

	</div>

	</div>

</section>

<section class="home-section-three main-section">
	<div class="container">
		<div class="main-heading text-center wow">
			<h2>Featured Products</h2>
		</div>
		<div class="related-pro-slider section-slider-pro section-slider related-pro">

		<?php

				foreach( $featured as $product ) : ?>

					<div class="gallery">

						@include('web.product.content',['product' => $product])

					</div>

				<?php endforeach;?>
		</div>
	</div>
</section>
@endsection