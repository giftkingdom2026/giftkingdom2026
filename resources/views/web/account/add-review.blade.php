@extends('web.layout')



@section('content')


<section class="main-section account-section cart-section contact-section-one review-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-3">
				@include('web.account.sidebar')
			</div>
			<div class="col-md-8 col-lg-9">
				<div class="acc-right">
					<div class="main-heading">
						<h2>{{$data['content']['banner_text']}}</h2>
						<div class="breadcrumb mt-3 mb-3 mb-lg-0">

							<div class="container">

								<ul class="d-inline-flex align-items-center gap-2">

									<li><a href="<?= asset('') ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

									<li>></li>

									<li><a href="<?= asset('account/' . Auth()->user()->user_name) ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Account')?></a></li>

									<li>></li>

									<li><a href="<?= asset('account/give-reviews') ?>">{{$data['content']['pagetitle']}}</a></li>

									<li>></li>

									<li><a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Review Form')?></a></li>

								</ul>

							</div>

						</div>
					</div>
					<form action="<?= asset('submit-review') ?>" method="POST" enctype="multipart/form-data" id="reviewForm">
						@csrf
						<input type="hidden" name="object_ID" value="<?= $item['product_ID'] ?>">
						@if($item['product']['prod_type'] == 'variation')
												<input type="hidden" name="variation_ID" value="<?= $item['variation']['ID'] ?>">

						@endif
						<input type="hidden" name="object_type" value="product">
						<input type="hidden" name="customer_ID" value="<?= Auth()->user()->id ?>">

						<div class="cart-item">
							<div class="cart-item-select">
								<ul class="d-flex justify-content-between align-items-center flex-wrap gap-2 gap-md-0">
									<li class="cart-item-thumb">
										<div class="d-flex align-items-center gap-3 gap-md-4 flex-column flex-md-row text-center text-md-start">
											<figure>
												<img src="<?= asset($item['product']['prod_image']) ?>" class="w-100 wow">
											</figure>
											<div class="cart-item-meta">
												<h5 class="text-capitalize"><?= $item['product']['prod_title'] ?></h5>

												<?php if (!empty($item['item_meta'])) : ?>

													<?php foreach ($item['item_meta'] as $meta) : ?>
														@if(isset($meta['attribute']))
														<p class="mb-0">
															<?= $meta['attribute']['attribute_title'] ?> :
															<strong><?= $meta['value']['value_title'] ?></strong>
														</p>
														@endif
													<?php endforeach; ?>

													@if(isset($item['item_meta']['personal-message']))
													<p class="mb-2"<?=App\Http\Controllers\Web\IndexController::trans_labels('Personalized Message')?>>: <?= $item['item_meta']['personal-message'] ?></p>
													@endif

												<?php endif; ?>

											</div>
										</div>
									</li>
									<li class="cart-item-totals">
										<span class="d-block"><?=App\Http\Controllers\Web\IndexController::trans_labels('Qty')?>:{{($item['product_quantity'])}}</span>
									</li>
									<li class="cart-item-totals">
										<?php

										$price = $item['item_sale_price'] != '' ? $item['item_sale_price'] * $item['order']['currency_value'] : $item['item_price'] * $item['order']['currency_value']; ?>

										<b class="d-block mb-1"><?= $item['order']['currency'] ?> <?= number_format($price, 2) ?> </b>
										<span class="d-block"><?=App\Http\Controllers\Web\IndexController::trans_labels('Total')?></span>
										<strong class="d-block fw-normal"><?= $item['order']['currency'] ?> <?= number_format(($price * $item['product_quantity']), 2) ?></strong>
									</li>

								</ul>
							</div>
						</div>
						<div class="rating">
							<div class="row">
								<div class="col-sm-6">
									<div class="wrap d-flex align-items-center justify-content-between">
										<div>
											<h6><?=App\Http\Controllers\Web\IndexController::trans_labels('Select Product Rating')?></h6>
											<span class="d-block rating-span fw-normal"></span>
										</div>
										<div class="d-flex rating-block align-items-center gap-3">
											<div class="rating-box d-flex">
												<div class="rating-container">
													<input type="radio" name="object_rating" value="5" id="objstar-5"> <label for="objstar-5">★</label>
													<input type="radio" name="object_rating" value="4" id="objstar-4"> <label for="objstar-4">★</label>
													<input type="radio" name="object_rating" value="3" id="objstar-3"> <label for="objstar-3">★</label>
													<input type="radio" name="object_rating" value="2" id="objstar-2"> <label for="objstar-2">★</label>
													<input type="radio" name="object_rating" value="1" id="objstar-1"> <label for="objstar-1">★</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="wrap wrap-two d-flex align-items-center justify-content-between">
										<div>
											<h6><?=App\Http\Controllers\Web\IndexController::trans_labels('Delivery Service')?></h6>
											<span class="d-block rating-span fw-normal"></span>
										</div>
										<div class="d-flex rating-block align-items-center gap-3">
											<div class="rating-box d-flex">
												<div class="rating-container">
													<input type="radio" name="delivery_rating" value="5" id="delstar-5"> <label for="delstar-5">★</label>
													<input type="radio" name="delivery_rating" value="4" id="delstar-4"> <label for="delstar-4">★</label>
													<input type="radio" name="delivery_rating" value="3" id="delstar-3"> <label for="delstar-3">★</label>
													<input type="radio" name="delivery_rating" value="2" id="delstar-2"> <label for="delstar-2">★</label>
													<input type="radio" name="delivery_rating" value="1" id="delstar-1"> <label for="delstar-1">★</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="file-upload">
							<h5 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Add Photos and Video')?></h5>
							<p><?=App\Http\Controllers\Web\IndexController::trans_labels('Please upload images and video according to the')?> <a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Community Guidelines')?></a></p>
							<div class="form-group position-relative mb-0">
								<input class="form-control form-data" required="" id="upresume" multiple accept=".png,.jpg,.jpeg,.webp,.webm,.mp4" type="file" name="upload[]">
								<span class="overlay">
									<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M26 7H22.535L20.8312 4.445C20.74 4.30819 20.6164 4.196 20.4714 4.11838C20.3264 4.04076 20.1645 4.0001 20 4H12C11.8355 4.0001 11.6736 4.04076 11.5286 4.11838C11.3836 4.196 11.26 4.30819 11.1687 4.445L9.46375 7H6C5.20435 7 4.44129 7.31607 3.87868 7.87868C3.31607 8.44129 3 9.20435 3 10V24C3 24.7956 3.31607 25.5587 3.87868 26.1213C4.44129 26.6839 5.20435 27 6 27H26C26.7956 27 27.5587 26.6839 28.1213 26.1213C28.6839 25.5587 29 24.7956 29 24V10C29 9.20435 28.6839 8.44129 28.1213 7.87868C27.5587 7.31607 26.7956 7 26 7ZM27 24C27 24.2652 26.8946 24.5196 26.7071 24.7071C26.5196 24.8946 26.2652 25 26 25H6C5.73478 25 5.48043 24.8946 5.29289 24.7071C5.10536 24.5196 5 24.2652 5 24V10C5 9.73478 5.10536 9.48043 5.29289 9.29289C5.48043 9.10536 5.73478 9 6 9H10C10.1647 9.00011 10.3268 8.95954 10.4721 8.88191C10.6173 8.80428 10.7411 8.69199 10.8325 8.555L12.535 6H19.4638L21.1675 8.555C21.2589 8.69199 21.3827 8.80428 21.5279 8.88191C21.6732 8.95954 21.8353 9.00011 22 9H26C26.2652 9 26.5196 9.10536 26.7071 9.29289C26.8946 9.48043 27 9.73478 27 10V24ZM16 11C14.9122 11 13.8488 11.3226 12.9444 11.9269C12.0399 12.5313 11.3349 13.3902 10.9187 14.3952C10.5024 15.4002 10.3935 16.5061 10.6057 17.573C10.8179 18.6399 11.3417 19.6199 12.1109 20.3891C12.8801 21.1583 13.8601 21.6821 14.927 21.8943C15.9939 22.1065 17.0998 21.9976 18.1048 21.5813C19.1098 21.1651 19.9687 20.4601 20.5731 19.5556C21.1774 18.6512 21.5 17.5878 21.5 16.5C21.4983 15.0418 20.9184 13.6438 19.8873 12.6127C18.8562 11.5816 17.4582 11.0017 16 11ZM16 20C15.3078 20 14.6311 19.7947 14.0555 19.4101C13.4799 19.0256 13.0313 18.4789 12.7664 17.8394C12.5015 17.1999 12.4322 16.4961 12.5673 15.8172C12.7023 15.1383 13.0356 14.5146 13.5251 14.0251C14.0146 13.5356 14.6383 13.2023 15.3172 13.0673C15.9961 12.9322 16.6999 13.0015 17.3394 13.2664C17.9789 13.5313 18.5256 13.9799 18.9101 14.5555C19.2947 15.1311 19.5 15.8078 19.5 16.5C19.5 17.4283 19.1313 18.3185 18.4749 18.9749C17.8185 19.6313 16.9283 20 16 20Z" fill="#6D7D36" />
									</svg>
									<filename><?=App\Http\Controllers\Web\IndexController::trans_labels('Add Photo')?></filename>
								</span>
							</div>
						</div>
						<div class="review mt-4 pt-2">
							<h5 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Write Review')?></h5>
							<!-- <div class="form-group mb-4">
							<label class="mb-2">Product Name*</label>
							<input type="text" name="add_pro_name" class="form-control" placeholder="Add Product Name">
						</div> -->
							<!-- <div class="form-group mb-4">
							<label class="mb-2">Add Descriptions*</label>
							<input type="text" name="add_pro_des" class="form-control" placeholder="Add Description about product?" required>
						</div> -->
							<div class="form-group mb-0">
								<label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Add Written Review')?>*</label>
								<textarea class="form-control" name="review" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('How’s the quality of product?')?>" required></textarea>
							</div>

						</div>
						<div class="wrap show">
							<div class="form-check gap-2 gap-md-4 p-0 m-0">
								<input class="form-check-input" type="checkbox" name="showusername" id="show">
								<label class="form-check-label" for="show">
									<h6 class="m-0"><?=App\Http\Controllers\Web\IndexController::trans_labels('Show username on the review')?></h6>
								</label>
							</div>
						</div>
						<button type="submit" id="reviewSubmitBtn" class="btn mt-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Submit Review')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path>
							</svg></button>

					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection