@extends('web.layout')



@section('content')



<div class="breadcrumb">



	<div class="container">

		<div class="row">

			<div class="col-md-6">

				<ul class="d-inline-flex align-items-center gap-2">



					<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>



					<li>></li>



					<li><a href="<?=asset('account/'.Auth()->user()->user_name)?>">Account</a></li>z



					<li>></li>

					<li><a href="javascript:;">Order #<?=$result['ID']?></a></li>

				</ul>

			</div>

			<div class="col-md-6 text-end">

				<a href="<?=URL::previous()?>" class="back"><svg class="me-3" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6562 7.5H2.34375" stroke="#333333" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5625 3.28125L2.34375 7.5L6.5625 11.7188" stroke="#333333" stroke-linecap="round" stroke-linejoin="round"/></svg>Previous Page</a>

			</div>

		</div>

	</div>

</div>



<section class="main-section account-section return-section order-detail-section">

	<div class="container">

		<div class="row">



			<div class="col-md-12 col-lg-12">

				<div class="acc-right">

					<p class="order-detail">Order #<?=$result['ID']?> was placed on <?=date('M d, Y', strtotime($result['created_at']))?> and is currently <?=$result['order_status']?>.</p>

					<div class="main-heading mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3 gap-sm-0">

						<h2>Order Details</h2>

						<h5 class="m-0 text-uppercase">Order <?=$result['order_status']?></h5>

					</div>

					<div class="table-responsive">

						<table class="w-100">

							<tr>

								<th>Order</th>

								<th>Total</th>

							</tr>



							<?php



							foreach($result['items'] as $item) : ?> 

								<tr>

									<td><?=$item['product']['prod_title']?> × <?=$item['product_quantity']?><br>



										<?php



										if( isset( $item['product']['metadata']['store_name'] ) ) : ?>



											Vendor: <?=$item['product']['metadata']['store_name']?><br>



										<?php endif;?>



										<?php



										if( $item['item_meta'] ) : ?>



											Color: Black<br>Storage: 16GB</td>



										<?php endif;?>



										<td><span class="price">AED <?=number_format($item['product']['price'] * $item['product_quantity'])?></span></td>

									</tr>



								<?php endforeach;?>



								<tr>

									<td>Subtotal:</td>

									<td><span class="price">AED <?=number_format($result['order_subtotal'])?></span></td>

								</tr>

								<tr>

									<td>Shipping:</td>

									<td><?=$result['shipping_cost']?></td>

								</tr>

								<?php



								if( $result['coupon_code'] != '' ) : ?>



									<tr>

									<td>Coupon (<?=$result['coupon_code']?>):</td>

									<td>{{ Session::get('symbol_right') }} {{ Session::get('symbol_left') }} -{{ number_format((int)(($result['order_subtotal'] - $result['order_total'])  + 0)) }}</td>

								</tr>



								<?php endif;?>



								<tr>

									<td>Payment method:</td>

									<td><?=($result['payment_method'])?></td>

								</tr>

								<tr>

									<td>Total:</td>

									<td>

										<span class="total price">

											AED <?=number_format($result['order_total'])?>

										</span>

									</td>

								</tr>

							</table>

						</div>



						<div class="addressWrap mt-4 pt-2">

							<div class="row">

								<div class="col-lg-12">

									<div class="wrap billing-address">

										<div class="address-head">

											<h5 class="mb-0">Address</h5>

										</div>

										<div class="address-detail">

											<address class="m-0">



												<?php 



												$billing = unserialize($result['billing_data']);



												echo $billing['address']?>



												<?=isset($billing['addresstwo']) && $billing['addresstwo'] != '' ? '<br>'.$billing['addresstwo'] : '';?>



												<br><?=isset($billing['emirate']) && $billing['emirate'] != '' ? $billing['emirate'] : ''?>



												<br><?=$billing['country']?>



											</address>





											<span class="d-flex align-items-center gap-2 mt-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.78937 2.26714L8.21223 1.83857C8.85993 1.64316 9.55661 1.69014 10.1722 1.97074C10.7878 2.25133 11.2803 2.74637 11.5577 3.36343L12.4431 5.33314C12.6817 5.86377 12.7481 6.45578 12.6331 7.0261C12.5182 7.59642 12.2275 8.11642 11.8019 8.51314L10.2548 9.95572C10.2363 9.9741 10.2207 9.9952 10.2085 10.0183C10.0465 10.3491 10.2925 11.2329 11.0631 12.5683C11.9322 14.0734 12.6034 14.6683 12.9145 14.5766L14.9451 13.9551C15.5012 13.7853 16.0965 13.7938 16.6475 13.9793C17.1986 14.1648 17.6778 14.5181 18.0179 14.9897L19.2762 16.7323C19.6713 17.2794 19.8543 17.9514 19.7912 18.6233C19.7281 19.2952 19.4233 19.9213 18.9334 20.3854L17.8508 21.4097C17.4743 21.7663 17.0172 22.0265 16.5184 22.1682C16.0196 22.3098 15.4939 22.3287 14.9862 22.2231C11.9717 21.5957 9.2708 19.1683 6.86051 14.994C4.44937 10.8171 3.69766 7.26 4.66623 4.33457C4.82836 3.84481 5.106 3.40126 5.4757 3.04142C5.84539 2.68157 6.29541 2.416 6.78937 2.26714ZM7.16223 3.498C6.86584 3.58727 6.59529 3.74658 6.37344 3.96246C6.1516 4.17833 5.98498 4.44444 5.88766 4.73829C5.0528 7.25914 5.72909 10.4614 7.9748 14.3511C10.2188 18.2383 12.6514 20.424 15.2494 20.964C15.554 21.0272 15.8694 21.0158 16.1686 20.9307C16.4679 20.8457 16.7421 20.6894 16.9679 20.4754L18.0497 19.452C18.3136 19.2022 18.4778 18.865 18.5119 18.5032C18.5459 18.1414 18.4475 17.7795 18.2348 17.4849L16.9765 15.7414C16.7934 15.4876 16.5354 15.2973 16.2388 15.1974C15.9421 15.0975 15.6216 15.0929 15.3222 15.1843L13.2865 15.8074C12.1602 16.1426 11.1008 15.204 9.95051 13.2103C8.97594 11.5234 8.63823 10.3046 9.0548 9.45343C9.13594 9.28772 9.24394 9.14172 9.3788 9.01543L10.9259 7.57286C11.1552 7.35924 11.3118 7.0792 11.3737 6.77205C11.4357 6.4649 11.3999 6.14606 11.2714 5.86029L10.3851 3.89143C10.2357 3.55908 9.97052 3.29246 9.63896 3.14135C9.30741 2.99024 8.93219 2.96498 8.58337 3.07029L7.16223 3.498Z" fill="black"/></svg><?=$billing['phone']?></span>

											<span class="d-flex align-items-center gap-2 mt-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 9L12 12.5L17 9" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 17V7C2 6.46957 2.21071 5.96086 2.58579 5.58579C2.96086 5.21071 3.46957 5 4 5H20C20.5304 5 21.0391 5.21071 21.4142 5.58579C21.7893 5.96086 22 6.46957 22 7V17C22 17.5304 21.7893 18.0391 21.4142 18.4142C21.0391 18.7893 20.5304 19 20 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17Z" stroke="black" stroke-width="1.2"/></svg><?=$billing['email']?></span>

										</div>

									</div>

								</div>

								<div class="col-lg-6 d-none">

									<div class="wrap shipping-address mt-4 mt-lg-0">

										<div class="address-head">

											<h5 class="mb-0">Shipping Address</h5>

										</div>

										<div class="address-detail">

											<address class="m-0">

												<?php 



												$shipping = unserialize($result['shipping_data']);



												echo $shipping['address']?>



												<?=isset($shipping['addresstwo']) && $shipping['addresstwo'] != '' ? '<br>'.$shipping['addresstwo'] : ''?>



												<br><?=isset($shipping['emirate']) && $shipping['emirate'] != '' ? $shipping['emirate'] : ''?>



												<br><?=$shipping['country']?>





											</address>



											<span class="d-flex align-items-center gap-2 mt-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.78937 2.26714L8.21223 1.83857C8.85993 1.64316 9.55661 1.69014 10.1722 1.97074C10.7878 2.25133 11.2803 2.74637 11.5577 3.36343L12.4431 5.33314C12.6817 5.86377 12.7481 6.45578 12.6331 7.0261C12.5182 7.59642 12.2275 8.11642 11.8019 8.51314L10.2548 9.95572C10.2363 9.9741 10.2207 9.9952 10.2085 10.0183C10.0465 10.3491 10.2925 11.2329 11.0631 12.5683C11.9322 14.0734 12.6034 14.6683 12.9145 14.5766L14.9451 13.9551C15.5012 13.7853 16.0965 13.7938 16.6475 13.9793C17.1986 14.1648 17.6778 14.5181 18.0179 14.9897L19.2762 16.7323C19.6713 17.2794 19.8543 17.9514 19.7912 18.6233C19.7281 19.2952 19.4233 19.9213 18.9334 20.3854L17.8508 21.4097C17.4743 21.7663 17.0172 22.0265 16.5184 22.1682C16.0196 22.3098 15.4939 22.3287 14.9862 22.2231C11.9717 21.5957 9.2708 19.1683 6.86051 14.994C4.44937 10.8171 3.69766 7.26 4.66623 4.33457C4.82836 3.84481 5.106 3.40126 5.4757 3.04142C5.84539 2.68157 6.29541 2.416 6.78937 2.26714ZM7.16223 3.498C6.86584 3.58727 6.59529 3.74658 6.37344 3.96246C6.1516 4.17833 5.98498 4.44444 5.88766 4.73829C5.0528 7.25914 5.72909 10.4614 7.9748 14.3511C10.2188 18.2383 12.6514 20.424 15.2494 20.964C15.554 21.0272 15.8694 21.0158 16.1686 20.9307C16.4679 20.8457 16.7421 20.6894 16.9679 20.4754L18.0497 19.452C18.3136 19.2022 18.4778 18.865 18.5119 18.5032C18.5459 18.1414 18.4475 17.7795 18.2348 17.4849L16.9765 15.7414C16.7934 15.4876 16.5354 15.2973 16.2388 15.1974C15.9421 15.0975 15.6216 15.0929 15.3222 15.1843L13.2865 15.8074C12.1602 16.1426 11.1008 15.204 9.95051 13.2103C8.97594 11.5234 8.63823 10.3046 9.0548 9.45343C9.13594 9.28772 9.24394 9.14172 9.3788 9.01543L10.9259 7.57286C11.1552 7.35924 11.3118 7.0792 11.3737 6.77205C11.4357 6.4649 11.3999 6.14606 11.2714 5.86029L10.3851 3.89143C10.2357 3.55908 9.97052 3.29246 9.63896 3.14135C9.30741 2.99024 8.93219 2.96498 8.58337 3.07029L7.16223 3.498Z" fill="black"/></svg><?=$shipping['phone']?></span>

											<span class="d-flex align-items-center gap-2 mt-2"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 9L12 12.5L17 9" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 17V7C2 6.46957 2.21071 5.96086 2.58579 5.58579C2.96086 5.21071 3.46957 5 4 5H20C20.5304 5 21.0391 5.21071 21.4142 5.58579C21.7893 5.96086 22 6.46957 22 7V17C22 17.5304 21.7893 18.0391 21.4142 18.4142C21.0391 18.7893 20.5304 19 20 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17Z" stroke="black" stroke-width="1.2"/></svg><?=$shipping['email']?></span>

										</div>

									</div>

								</div>

							</div>

							<div class="row mt-3 wrap">

								<div class="col-md-12">

									<h5>Order Note:</h5>

									<p><?=$result['order_information']?></p>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</section>



	@endsection