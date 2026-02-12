@extends('web.layout')



@section('content')

<?php


if( !$data['wishlist'] || empty( $data['wishlist']['items'] ) ): ?>

	<div class="breadcrumb mb-0 mb-lg-4 mt-5 mt-lg-0">
		<div class="container">
			
			<div class="row align-items-center justify-content-between w-100">
				<div class="col-sm-6">
					<ul class="d-inline-flex align-items-center gap-2">

						<li><a href="{{asset('/')}}"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

						<li>&gt;</li>


						<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>
					</ul>
				</div>
				<!-- <div class="col-sm-6 text-end">
					<a href="<?=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : URL::previous()?>" class="back mt-2 mt-sm-0 justify-content-sm-end"><svg class="me-3" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6562 7.5H2.34375" stroke="#6D7D36" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.5625 3.28125L2.34375 7.5L6.5625 11.7188" stroke="#6D7D36" stroke-linecap="round" stroke-linejoin="round"></path></svg>Previous Page</a>
				</div> -->
			</div>
		</div>
	</div>

	<section class="main-section home-section-cta cart home-section-nine first-cta wishlist-bnnr">
		<div class="container">
			<figure class="overflow-hidden d-flex align-items-center">
				<img src="<?=asset('assets/images/breadCrumbPattern.png')?>" class="w-100">
				<figcaption class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center px-3 px-md-5 wow fadeInLeft">
					<div class="row justify-content-between align-items-center w-100">
						<div class="col-sm-8 col-lg-6">
							<div class="offer-one cta">
								<h2 class="mb-3">{{$data['content']['wishlist_empty_text']}}</h2>
								<p>{{$data['content']['wishlist_empty_text_two']}}</p>
								<a href="{{$data['content']['wishlist_btn_link']}}" class="btn">{{$data['content']['wishlist_btn_text']}}</a>
							</div>
						</div>
						<div class="col-sm-4 pt-3">
							<img src="{{$data['content']['banner_image']['path']}}" class="w-100">
						</div>
					</div>
				</figcaption>
			</div>
		</section>

		<style>
			.cart .cta h2:before,.cart .cta h2:after{content: none}    
		</style>

	<?php else : ?>

		<section class="main-section cart-section">

			<div class="container">
				<div class="breadcrumb mb-4">

					<div class="container">
						<div class="row align-items-center">
							<div class="col-sm-6">
								<ul class="d-inline-flex align-items-center gap-2">

									<li><a href="{{asset('/')}}"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

									<li>&gt;</li>


						<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				
				<div class="row">

					<div class="col-xl-9">
						<div class="wish-left pe-lg-5 me-lg-3">
                       <div class="free-shipping d-flex justify-content-center align-items-center gap-3">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2.81689 16.7983C2.81689 17.098 3.05685 17.3503 3.35872 17.3503H7.46111V8.31229H2.81689V16.7983Z" fill="#6C7D36"></path>
								<path d="M10.6201 17.3425H14.7225C15.0166 17.3425 15.2643 17.098 15.2643 16.7904V8.31229H10.6201V17.3425Z" fill="#6C7D36"></path>
								<path d="M9.94657 8.30469H8.14307V17.3585H9.94657V8.30469Z" fill="#6C7D36"></path>
								<path d="M17.1526 1.55366C16.6572 1.55366 16.2547 1.96377 16.2547 2.46851C16.2547 2.76031 16.3941 3.02057 16.6031 3.18619C16.2702 3.61207 15.7516 3.8881 15.1711 3.8881C14.1958 3.8881 13.4063 3.11521 13.3444 2.14516C13.8088 2.10572 14.1726 1.71928 14.1726 1.2382C14.1726 0.733455 13.7701 0.323351 13.2747 0.323351C12.7793 0.323351 12.3768 0.733455 12.3768 1.2382C12.3768 1.56944 12.5549 1.86124 12.818 2.01897C12.5394 2.68933 11.8892 3.15464 11.1306 3.15464C10.2792 3.15464 9.56708 2.56315 9.35809 1.75871C9.68318 1.62464 9.91539 1.2934 9.91539 0.914847C9.91539 0.410104 9.52064 0.00788661 9.02525 0C8.52987 0 8.13511 0.410104 8.13511 0.914847C8.13511 1.2934 8.36732 1.62464 8.69242 1.75871C8.48343 2.56315 7.77131 3.15464 6.91988 3.15464C6.16132 3.15464 5.51887 2.68145 5.23248 2.01897C5.49565 1.86124 5.67368 1.56944 5.67368 1.2382C5.67368 0.733455 5.27118 0.323351 4.7758 0.323351C4.28041 0.323351 3.87792 0.733455 3.87792 1.2382C3.87792 1.71928 4.24171 2.10572 4.70613 2.14516C4.64421 3.1231 3.85469 3.8881 2.87941 3.8881C2.29888 3.8881 1.78028 3.61207 1.44744 3.18619C1.65643 3.02057 1.79576 2.76031 1.79576 2.46851C1.79576 1.96377 1.39326 1.55366 0.897882 1.55366C0.402499 1.55366 0 1.96377 0 2.46851C0 2.97325 0.402499 3.38336 0.897882 3.38336C0.928843 3.38336 0.959803 3.37547 0.990764 3.37547L2.11312 7.91027C2.11312 7.91027 4.23397 7.24779 9.00203 7.24779C13.7701 7.24779 15.8909 7.91027 15.8909 7.91027L17.0133 3.37547C17.0443 3.37547 17.0752 3.38336 17.1062 3.38336C17.6016 3.38336 18.0041 2.97325 18.0041 2.46851C18.0041 1.96377 17.648 1.55366 17.1526 1.55366Z" fill="#6C7D36"></path>
							</svg>
							<h5 class="m-0">{{ $data['content']['wishlist_head_text'] }}</h5>
						</div>

						<div class="cart wishlist-list careerFilter">

							<!-- Cart Head -->

							<div class="cart-head d-flex account-section justify-content-between mb-4 mt-0 ms-1">

								<?php $id = Auth::check() ? 'AddToCartAll' : 'AddToCartAll';?>
								<?php $ic = Auth::check() ? 'add-to-cart-multi' : 'add-to-cart-multi';?>

								<a href="javascript:;" class="select-all btn" id="<?=$id?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Add all to Cart')?></a>					

								<div class="d-flex gap-4">

									<button href="javascript:;" class="<?=$ic?> btn trans-btn" style="display: none"><?=App\Http\Controllers\Web\IndexController::trans_labels('Add selected to Cart')?></button>

									<div class="child_option position-relative">

										<button class="form-control open-menu2 gap-4 text-dark fw-normal text-start d-flex align-items-center justify-content-between" type="button">Actions <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L6 6L11 1" stroke="#6D7D36" stroke-width="2" stroke-linecap="round"></path></svg></button> 

										<div class="dropdown-menu2 dropdown-menu-right">   

											<ul class="careerFilterInr">

												<li><a href="javascript:;" class="empty-wishlist"><?=App\Http\Controllers\Web\IndexController::trans_labels('Delete All')?></a></li>

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

                                                $meta.=$attr['attribute']['attribute_title'].':'.' <strong> '.$attr['value']['value_title'].'</strong> ';

							                                            else :

							                                                if( $attr['value'] != '' ):

							                                                    $meta.='<br>Personalized Message: '.' <strong>'.$attr['value'].'</strong>';

							                                                endif;

							                                            endif;

							                                        endforeach;?>

							                                        <p class="text-capitalize mb-1"><?=rtrim($meta,', ')?></p>

							                                    <?php endif;?>

																	<p><?=App\Http\Controllers\Web\IndexController::trans_labels('Added On')?>: <?=$item['product']['created_at']?></p>


																</div>

																

															</div>

															<input type="hidden" class="prod_id" value="<?=$item['product']['ID']?>">

														</li>

														<li class="cart-item-totals">

															<span class="d-block"><?=App\Http\Controllers\Web\IndexController::trans_labels('Total')?></span>

															<?php $price = $item['product']['price'] * session('currency_value');?>

															<strong class="d-block fw-normal mb-0 new_price" prod-id="<?=$item['product']['ID']?>">AED <?=number_format($price,2)?></strong>

														</li>

														<li class="cart-item-delete">

															<div class="d-flex flex-column gap-3 align-items-center h-100 cart-item-actions">

																<?php $cd = Auth::check() ? 'add-to-cart-wishlist' : '';?>

																<a href="<?= $cd === 'add-to-cart-wishlist' ? 'javascript:;' : asset('/?login') ?>"  data-id="<?=$item['item_ID']?>" class="<?=$cd?>" serial="{{$serial}}">

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

					</div>
					</div>

					<div class="col-lg-3 section-slider account-section section-slider-pro">

						<h4> <?=App\Http\Controllers\Web\IndexController::trans_labels('Related Products')?></h4>
<?php

				foreach( $data['products'] as $product ) : ?>


						@include('web.product.content',['product' => $product])

				<?php endforeach;?>

				</div>

			</div>

		</section>

	<?php endif;?>


	@endsection

