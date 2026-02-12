@extends('web.layout')



@section('content')

<div class="breadcrumb mb-4">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

			<li>></li>

			<li><a href="<?=asset('dashboard/'.Auth()->user()->user_name)?>">Account</a></li>

			<li>></li>

			<li><a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Status')?></a></li>

		</ul>

	</div>

</div>


<section class="main-section account-section cart-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-3">
				@include('web.account.sidebar')
			</div>
			<div class="col-md-8 col-lg-9">
				<div class="acc-right">
					<div class="main-heading mb-4">
						<h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Wishlist')?></h2>
					</div>
					
					<?php


					if( !$data['wishlist'] || empty( $data['wishlist']['items'] ) ): ?>


						<div class="home-section-cta cart home-section-nine first-cta">
							<div class="container">
								<figure class="overflow-hidden d-flex align-items-center">
									<img src="<?=asset('images/media/2024/11/Group 1000006062.png')?>" class="w-100">
									<figcaption class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center px-3 px-md-5 wow fadeInLeft">
										<div class="row justify-content-between align-items-center">
											<div class="col-sm-8 col-lg-6">
												<div class="offer-one cta">
													<h2 class="mb-3">Ready To Make A Wish</h2>
													<p>Start adding items you love to your Wishlist by tapping on the heart icon.</p>
													<a href="<?=asset('shop')?>" class="btn">Shop Now</a>
												</div>
											</div>
											<div class="col-sm-4 text-end">
												<img src="<?=asset('images/media/2024/11/Mask group (2)45.png')?>" class="w-100">
											</div>
										</div>
									</figcaption>
								</figure>
							</div>
						</div>

						<style>
							.cart .cta h2:before,.cart .cta h2:after{content: none}    
						</style>

					<?php else : ?>

						<div class="cart wishlist-list careerFilter">

							<!-- Cart Head -->

							<div class="cart-head d-flex account-section justify-content-between mb-4 mt-0 ms-1">

								<?php $id = Auth::check() ? 'AddToCartAll' : 'AddToCartAll';?>
								<?php $ic = Auth::check() ? 'add-to-cart-multi' : 'add-to-cart-multi';?>

								<a href="javascript:;" class="select-all btn" id="<?=$id?>">Add all to Cart</a>					

								<div class="d-flex gap-4">

									<button href="javascript:;" class="<?=$ic?> btn trans-btn" style="display: none">Add selected to Cart</button>

									<div class="child_option position-relative">

										<button class="form-control open-menu2 gap-4 text-dark fw-normal text-start d-flex align-items-center justify-content-between" type="button">Actions <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L6 6L11 1" stroke="#6D7D36" stroke-width="2" stroke-linecap="round"></path></svg></button> 

										<div class="dropdown-menu2 dropdown-menu-right">   

											<ul class="careerFilterInr">

												<li><a href="javascript:;" class="empty-wishlist">Delete All</a></li>

											</ul>

										</div>

										<input type="hidden" class="inputhide" name="gender" value="Male">

									</div>

								</div>

							</div>

							<!-- Cart Body -->

							<div class="cart-body d-flex flex-column">


								<?php

								foreach( $data['wishlist']['items']  as $item ) : ?>

									<div class="cart-item">

										<div class="cart-item-select">

											<div class="form-check ps-0 m-0 gap-4">

												<input class="form-check-input check-to-add" type="checkbox" value="<?=$item['item_ID']?>" id="<?=$item['item_ID']?>">

												<label class="form-check-label w-100">

													<ul class="d-flex justify-content-between align-items-center flex-wrap">

														<li class="cart-item-thumb">

															<div class="d-flex gap-4 align-items-center">

																<a href="{{url('product'.'/'.$item['product']['prod_slug'])}}">
																
																	<figure class="prod_image" 
																		prod-id="<?=$item['product']['ID']?>">

																		<img src="<?=asset($item['product']['prod_image'])?>" class="w-100 wow">

																	</figure>

																</a>


																<div class="cart-item-meta">

																	<a href="{{url('product'.'/'.$item['product']['prod_slug'])}}">
																		<h5 class="text-capitalize"><?=$item['product']['prod_title']?></h5>
																	</a>

																	@if($item['product']['review']['rating'] > 0)

																	<div class="d-flex align-items-center justify-content-between">

																		<div class="d-flex align-items-center gap-2">

																			<div class="rating-box d-flex">

																				<div class="rating-container">

																					<?php

																					$stars = range(1, 5);

																					krsort($stars);

																					foreach($stars as $star) : 

																						($star <= $item['product']['review']['rating']) ? $css='style="color:#FFBC11"' : $css =''; ?>

																						<input type="radio" name="rating" value="<?=$star?>" id="star-<?=$star?>"> <label <?=$css?> for="star-<?=$star?>">&#9733;</label>

																					<?php endforeach;?>

																				</div>

																			</div>

																			<aside><?=number_format($item['product']['review']['rating'],1)?>/5 <?=App\Http\Controllers\Web\IndexController::trans_labels('Ratings')?></aside>

																		</div>

																		<!-- <aside>(<?=$item['product']['review']['count']?> <?=App\Http\Controllers\Web\IndexController::trans_labels('Reviews')?>)</aside> -->

																	</div>

																	@endif
																	
																	<?php

																$serial = '';

							                                    if( !empty($item['item_meta']) ) : $meta = ''; 

							                                    	$serial = $item['serial_meta'];
							                                    
							                                        foreach($item['item_meta'] as $key => $attr ) : 

							                                            if( $attr['attribute'] != null ) :

							                                                $meta.='<strong>'.$attr['attribute']['attribute_title'].':</strong> '.$attr['value']['value_title'].', ';

							                                            else :

							                                                if( $attr['value'] != '' ):

							                                                    $meta.='<br><strong>Personalized Message:</strong> '.$attr['value'];

							                                                endif;

							                                            endif;

							                                        endforeach;?>

							                                        <p class="text-capitalize mb-1"><?=rtrim($meta,', ')?></p>

							                                    <?php endif;?>

																	<p>Added On: <?=$item['product']['created_at']?></p>


																</div>

																

															</div>

															<input type="hidden" class="prod_id" value="<?=$item['product']['ID']?>">

														</li>

														<li class="cart-item-totals">

															<span class="d-block">Total</span>

															<?php $price = $item['product']['price'] * session('currency_value');?>

															<strong class="d-block fw-normal mb-0 new_price" prod-id="<?=$item['product']['ID']?>">AED <?=number_format($price)?></strong>

														</li>

														<li class="cart-item-delete">

															<div class="d-flex flex-column gap-3 align-items-center h-100 cart-item-actions">

																<?php $cd = Auth::check() ? 'add-to-cart-wishlist' : '';?>

																<a href="javascript:;" data-id="<?=$item['item_ID']?>" class="<?=$cd?>" serial="{{$serial}}">

																	<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 15.1875C7 15.3946 6.83211 15.5625 6.625 15.5625C6.41789 15.5625 6.25 15.3946 6.25 15.1875C6.25 14.9804 6.41789 14.8125 6.625 14.8125C6.83211 14.8125 7 14.9804 7 15.1875Z" fill="#6D7D36" stroke="#6D7D36" stroke-width="1.5"></path><path d="M14.3125 15.1875C14.3125 15.3946 14.1446 15.5625 13.9375 15.5625C13.7304 15.5625 13.5625 15.3946 13.5625 15.1875C13.5625 14.9804 13.7304 14.8125 13.9375 14.8125C14.1446 14.8125 14.3125 14.9804 14.3125 15.1875Z" fill="#6D7D36" stroke="#6D7D36" stroke-width="1.5"></path><path d="M3.97422 5.0625H16.5883L14.732 11.5594C14.6658 11.7952 14.524 12.0027 14.3284 12.15C14.1327 12.2974 13.8941 12.3764 13.6492 12.375H6.91328C6.66837 12.3764 6.42977 12.2974 6.23415 12.15C6.03852 12.0027 5.8967 11.7952 5.83047 11.5594L3.28516 2.65781C3.25152 2.54022 3.18047 2.43679 3.08278 2.3632C2.98508 2.28961 2.86606 2.24987 2.74375 2.25H1.5625" stroke="#6D7D36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>

																</a>

																<div class="child_option position-relative">

																	<button class="dots open-menu2 bg-transparent border-0 p-0" type="button"><svg height="20" style="fill:#6D7D36" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/></svg></button> 

																	<div class="dropdown-menu2 dropdown-menu-right">   

																		<ul class="careerFilterInr">

																			<li><a href="<?=asset('wishlist/delete/'.$item['item_ID'])?>" class="delete w-100 border-0 delete-wishlist-item">Delete</a></li>

																		</ul>

																	</div>

																	<input type="hidden" class="inputhide" name="gender" value="Male">

																</div>


															</div>

														</li>

													</ul>

												</label>

											</div>

										</div>

									</div>

								<?php endforeach;?>

							</div>

						</div>

					<?php endif;?>

				</div>
			</div>
		</div>
	</div>
</section>

@endsection