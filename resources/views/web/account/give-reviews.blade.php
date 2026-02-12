@extends('web.layout')



@section('content')

<section class="main-section account-section cart-section purchase-section">
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

									<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>

								</ul>

							</div>

						</div>
					</div>

					<div class="d-flex flex-column gap-3">

						<?php
						if (!empty($items)) :

							foreach ($items as $item) : ?>
								<div class="cart-item">
									<div class="cart-item-select">
										<ul class="d-flex justify-content-between align-items-center flex-wrap gap-2 gap-md-0">
											<li class="cart-item-thumb">
												<div class="d-flex align-items-center gap-4">
													<figure>
														<img src="<?= asset($item['product']['prod_image']) ?>" class="w-100 wow">
													</figure>
													<div class="cart-item-meta">
														<h5 class="text-capitalize">
															<a href="<?= asset('product/' . $item['product']['prod_slug']) ?>"><?= $item['product']['prod_title'] ?></a>
														</h5>
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
															<p class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Personalized Message')?>: <?= $item['item_meta']['personal-message'] ?></p>
															@endif

														<?php endif; ?>

													</div>
												</div>
											</li>
											<li class="cart-item-totals">
												<span class="d-block"><?=App\Http\Controllers\Web\IndexController::trans_labels('Total')?></span>
												<?php
												$has_sale = $item['item_sale_price'] != 0 && $item['item_sale_price'] != null && $item['item_sale_price'] != $item['item_price'];
												$price = $has_sale ? $item['item_sale_price'] : $item['item_price'];
												?>

												<strong class="d-block fw-normal">
													<?= $item['order_currency'] ?> <?= number_format(($price * $item['product_quantity'] * $item['order_currency_value']), 2) ?>
												</strong>
											</li>
											<li class="reviews">
												<?php

												if ($item['is_reviewed'] == 0) : ?>

													<a href="<?= asset('/account/add-review/' . $item['ID']) ?>" class="btn" id="give_reviews"><?=App\Http\Controllers\Web\IndexController::trans_labels('Give Reviews')?></a>

												<?php else : ?>

													<a href="javascript:;" class="btn"><?=App\Http\Controllers\Web\IndexController::trans_labels('Review Submitted')?>!</a>

												<?php endif; ?>

											</li>
										</ul>
									</div>
								</div>

							<?php

							endforeach;

						else :  ?>

							<div class="main-heading mb-4">
								<h3>{{$data['content']['empty_reviews_text']}}</h3>
							</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection