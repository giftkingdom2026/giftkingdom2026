@extends('web.layout')

@section('content')

<?php 

$prod_price = $result['prod_price'] * session('currency_value');

$sale_price = $result['sale_price'] * session('currency_value'); ?>

<div class="modal storedetail-modal fade" id="storeshare" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-dialog-centered">
		<div class="modal-content p-0">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="45" height="45" rx="22.5" fill="white"/><path d="M15.3945 15.3947L29.6051 29.6053" stroke="#333333" stroke-width="2" stroke-linecap="round"/><path d="M29.6055 15.3947L15.3949 29.6053" stroke="#333333" stroke-width="2" stroke-linecap="round"/></svg></button>
			<div class="modal-body p-0">
				<article class="text-center">
					<ul class="social-icons d-flex flex-wrap justify-content-center align-items-center gap-3 social-share">
						<li>
							<a target="_blank" type="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?=asset('product/'.$result['prod_slug'])?>">
								<svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.97508 18C2.97508 17.9274 2.9595 17.8548 2.9595 17.7676C2.9595 15.1969 2.9595 12.6117 2.9595 10.041C2.9595 9.96839 2.9595 9.89577 2.9595 9.79411C1.96262 9.79411 0.996885 9.79411 0 9.79411C0 8.71935 0 7.67365 0 6.59889C0.981308 6.59889 1.94704 6.59889 2.9595 6.59889C2.9595 6.51175 2.9595 6.43913 2.9595 6.36652C2.9595 5.52414 2.94393 4.69629 2.97508 3.85392C3.02181 2.85178 3.33334 1.92226 4.09658 1.16703C4.6729 0.600607 5.40498 0.266562 6.21495 0.106801C6.88473 -0.0239124 7.55452 -0.00938874 8.2243 0.0196587C8.76947 0.0341824 9.31464 0.0777535 9.85981 0.121325C9.90654 0.121325 9.93769 0.135848 10 0.150372C10 1.09441 10 2.03845 10 2.99702C9.93769 2.99702 9.87539 2.99702 9.7975 2.99702C9.12772 3.01154 8.45794 2.99702 7.78816 3.02606C6.99377 3.06964 6.54206 3.4763 6.5109 4.21701C6.47975 4.98676 6.49533 5.75652 6.49533 6.5408C6.49533 6.55532 6.5109 6.55532 6.5109 6.59889C7.61682 6.59889 8.73831 6.59889 9.87539 6.59889C9.71962 7.67365 9.57944 8.73388 9.43925 9.79411C8.45794 9.79411 7.49221 9.79411 6.5109 9.79411C6.5109 9.86673 6.49533 9.9103 6.49533 9.96839C6.49533 12.6117 6.49533 15.255 6.49533 17.8838C6.49533 17.9274 6.49533 17.971 6.5109 18C5.3271 18 4.15888 18 2.97508 18Z" fill="#6D7D36"></path>
								</svg>
							</a>
						</li>

						<li>
							<a target="_blank" type="linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url=<?=asset('product/'.$result['prod_slug'])?>">
								<svg fill="#6D7D36" width="18" height="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310 310" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_801_"> <path id="XMLID_802_" d="M72.16,99.73H9.927c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5H72.16c2.762,0,5-2.238,5-5V104.73 C77.16,101.969,74.922,99.73,72.16,99.73z"></path> <path id="XMLID_803_" d="M41.066,0.341C18.422,0.341,0,18.743,0,41.362C0,63.991,18.422,82.4,41.066,82.4 c22.626,0,41.033-18.41,41.033-41.038C82.1,18.743,63.692,0.341,41.066,0.341z"></path> <path id="XMLID_804_" d="M230.454,94.761c-24.995,0-43.472,10.745-54.679,22.954V104.73c0-2.761-2.238-5-5-5h-59.599 c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5h62.097c2.762,0,5-2.238,5-5v-98.918c0-33.333,9.054-46.319,32.29-46.319 c25.306,0,27.317,20.818,27.317,48.034v97.204c0,2.762,2.238,5,5,5H305c2.762,0,5-2.238,5-5V194.995 C310,145.43,300.549,94.761,230.454,94.761z"></path> </g> </g></svg>
							</a>
						</li>

						<li>
							<a target="_blank" type="twitter" href="https://twitter.com/intent/tweet?url=<?=asset('product/'.$result['prod_slug'])?>">
								<svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 13.3105C2.01663 13.4954 3.7999 12.9994 5.42025 11.755C3.73385 11.5972 2.61106 10.7271 1.97701 9.11751C2.5362 9.18514 3.06018 9.19416 3.62378 9.04086C2.73434 8.81543 2.03425 8.37359 1.49706 7.67926C0.959882 6.98944 0.695694 6.19593 0.695694 5.30773C0.964285 5.41143 1.21526 5.52865 1.47505 5.6053C1.73924 5.68194 2.01223 5.709 2.28523 5.74506C0.682486 4.33838 0.30822 2.6747 1.20646 0.677382C3.22309 3.10753 5.74609 4.43757 8.81507 4.64947C8.80186 4.27526 8.77104 3.91457 8.77984 3.55839C8.82388 2.00291 9.9863 0.524089 11.4614 0.140856C12.8263 -0.215324 14.0284 0.104788 15.0543 1.09217C15.1292 1.16431 15.1952 1.19587 15.3009 1.1598C15.6707 1.04258 16.0494 0.952407 16.4105 0.81264C16.7715 0.672873 17.115 0.48802 17.4848 0.312184C17.3659 0.735994 17.1722 1.11472 16.8992 1.43934C16.6262 1.75945 16.3092 2.048 16.0142 2.34106C16.6702 2.26441 17.3219 2.05702 18 1.77748C17.5289 2.48984 17.0005 3.08498 16.362 3.5674C16.1991 3.68914 16.1595 3.81989 16.1639 4.01827C16.1991 5.75408 15.8249 7.40423 15.0895 8.96422C14.2045 10.8398 12.9232 12.3547 11.1884 13.4548C9.95107 14.2393 8.60812 14.7037 7.1683 14.8976C5.9046 15.0689 4.64971 15.0283 3.40362 14.7533C2.21477 14.4918 1.10959 14.0274 0.0792558 13.3691C0.0660464 13.3646 0.0528376 13.3511 0 13.3105Z" fill="#6D7D36"></path></svg>
							</a>
						</li>

						<li>
							<a type="whatsapp" href="https://api.whatsapp.com/send?text=<?=asset('product/'.$result['prod_slug'])?>" target="_blank">
								<svg fill="#6D7D36" height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 308 308" xml:space="preserve" stroke="#6D7D36"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_468_"> <path id="XMLID_469_" d="M227.904,176.981c-0.6-0.288-23.054-11.345-27.044-12.781c-1.629-0.585-3.374-1.156-5.23-1.156 c-3.032,0-5.579,1.511-7.563,4.479c-2.243,3.334-9.033,11.271-11.131,13.642c-0.274,0.313-0.648,0.687-0.872,0.687 c-0.201,0-3.676-1.431-4.728-1.888c-24.087-10.463-42.37-35.624-44.877-39.867c-0.358-0.61-0.373-0.887-0.376-0.887 c0.088-0.323,0.898-1.135,1.316-1.554c1.223-1.21,2.548-2.805,3.83-4.348c0.607-0.731,1.215-1.463,1.812-2.153 c1.86-2.164,2.688-3.844,3.648-5.79l0.503-1.011c2.344-4.657,0.342-8.587-0.305-9.856c-0.531-1.062-10.012-23.944-11.02-26.348 c-2.424-5.801-5.627-8.502-10.078-8.502c-0.413,0,0,0-1.732,0.073c-2.109,0.089-13.594,1.601-18.672,4.802 c-5.385,3.395-14.495,14.217-14.495,33.249c0,17.129,10.87,33.302,15.537,39.453c0.116,0.155,0.329,0.47,0.638,0.922 c17.873,26.102,40.154,45.446,62.741,54.469c21.745,8.686,32.042,9.69,37.896,9.69c0.001,0,0.001,0,0.001,0 c2.46,0,4.429-0.193,6.166-0.364l1.102-0.105c7.512-0.666,24.02-9.22,27.775-19.655c2.958-8.219,3.738-17.199,1.77-20.458 C233.168,179.508,230.845,178.393,227.904,176.981z"></path> <path id="XMLID_470_" d="M156.734,0C73.318,0,5.454,67.354,5.454,150.143c0,26.777,7.166,52.988,20.741,75.928L0.212,302.716 c-0.484,1.429-0.124,3.009,0.933,4.085C1.908,307.58,2.943,308,4,308c0.405,0,0.813-0.061,1.211-0.188l79.92-25.396 c21.87,11.685,46.588,17.853,71.604,17.853C240.143,300.27,308,232.923,308,150.143C308,67.354,240.143,0,156.734,0z M156.734,268.994c-23.539,0-46.338-6.797-65.936-19.657c-0.659-0.433-1.424-0.655-2.194-0.655c-0.407,0-0.815,0.062-1.212,0.188 l-40.035,12.726l12.924-38.129c0.418-1.234,0.209-2.595-0.561-3.647c-14.924-20.392-22.813-44.485-22.813-69.677 c0-65.543,53.754-118.867,119.826-118.867c66.064,0,119.812,53.324,119.812,118.867 C276.546,215.678,222.799,268.994,156.734,268.994z"></path> </g> </g></svg>
							</a>
						</li>
					</ul>
				</article>
			</div>
		</div>
	</div>
</div>

<div class="main-section">
	
	<div class="breadcrumb">

		<div class="container">

			<ul class="d-inline-flex align-items-center flex-wrap">

				<li><a href="<?=asset('/')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

				<li>></li>

				<li><a href="<?=asset('shop')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Shop')?></a></li>

				<?php

				if( isset( $result['category']['parent_ID'] ) && $result['category']['parent_ID'] != null ) : ?>

					<li>></li>

					<li>
						<a href="<?=asset('shop/category/'.$result['category']['parent_ID']['categories_slug'])?>"><?=$result['category']['parent_ID']['category_title']?></a>
					</li>

				<?php endif;

				if( isset( $result['category'] ) && $result['category'] != null ) : ?>

					<li>></li>

					<li><a href="<?=asset('shop/category/'.$result['category']['categories_slug'])?>"><?=$result['category']['category_title']?></a></li>

				<?php endif;?>

				<li>></li>

				<li><a href="javascript:;"><?php

				$title = explode(' ', $result['prod_title']);

				foreach($title as $key => $word) : if( $key < 5 ) : echo $word.' '; endif; endforeach;?></a></li>

			</ul>

		</div>

	</div>

</div>
<div class="position-relative">

	<section class="main-section productdetail-section-one p-0">

		<div class="container">

			<div class="row">

				<div class="col-lg-5 p-lg-0">

					<div class="pro-slider mb-4">

						<div class="sliderInr">

							<a href="<?=asset($result['prod_image'])?>" data-src="<?=asset($result['prod_image'])?>" data-fancybox="gallery">

								<figure>

									<img class="prod_img" src="<?=asset($result['prod_image'])?>" alt="*" class="w-100 mx-auto">

								</figure>
							</a>

						</div>

						<?php

						if( isset($result['prod_images']) && is_array($result['prod_images']) ) :

							foreach( $result['prod_images']  as $img ) : ?>

								<div class="sliderInr">

									<a href="<?=asset($img)?>" data-touch="false" data-src="<?=asset($img)?>" data-fancybox="gallery">
										<figure>
											<img class="prod_imgs" src="<?=asset($img)?>"  alt="*" class="w-100 mx-auto">
										</figure>
									</a>

								</div>

							<?php endforeach;?>

							<?php

							foreach( $result['prod_images']  as $img ) : ?>

								<div class="sliderInr">

									<a href="<?=asset($img)?>" data-touch="false" data-src="<?=asset($img)?>" data-fancybox="gallery">

										<figure>

											<img class="prod_imgs" src="<?=asset($img)?>" alt="*" class="w-100 mx-auto">

										</figure>
									</a>

								</div>

							<?php endforeach;

						endif; ?>


					</div>

					<div class="pro-slider-thumb">

						<a href="javascript:;" class="gallery">

							<figure><img class="prod_img" src="<?=asset($result['prod_image'])?>" alt="*" style="height: 70px;"></figure>

						</a>
						<?php

						if( isset($result['prod_images']) && is_array($result['prod_images']) ) :

							foreach( $result['prod_images']  as $img ) : ?>

								<a href="javascript:;" class="gallery">

									<figure><img class="prod_imgs" src="<?=asset($img)?>" alt="*" style="height: 70px;"></figure>

								</a>

							<?php endforeach;

						endif; ?>


					</div>

				</div>

				<div class="col-lg-7 ps-lg-4 ps-xl-5">

					<div class="product-content mt-4 mt-lg-0">

						<form id="add-to-cart">

							<h2 class="prod_title"><?=$result['prod_title']?></h2>

							<div class="d-flex flex-wrap mb-3">

								<?php

								if( $result['prod_quantity'] == 0  ) : ?>

									<span class="btn-green stock" style="background-color: red !important;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Out Of Stock')?></span>

								<?php elseif( $result['prod_quantity'] < 10 ) : ?>

									<span class="btn-green stock"><?=App\Http\Controllers\Web\IndexController::trans_labels('In Stock')?> (<?=$result['prod_quantity']?> <?=App\Http\Controllers\Web\IndexController::trans_labels('LEFT')?>)</span>

								<?php elseif( $result['prod_quantity'] > 10) : ?>

									<span class="btn-green stock"><?=App\Http\Controllers\Web\IndexController::trans_labels('In Stock')?></span>

								<?php endif;?>

							</div>

							<div class="d-flex justify-content-between align-items-center pro-price">

								<?php

								if( $result['prod_type'] == 'variable' ) : ?>

									<h4>
										<i><i class="sale_price"></i></i>
										<del><i class="prod_price"></i></del>
									</h4>

								<?php elseif( $sale_price != null && $sale_price != $prod_price) : ?>
									<div class="d-flex gap-3 align-items-center">

										<h4>

											<i>
												<?=Session::get('symbol_right').' '.Session::get('symbol_left')?>
												<i class="sale_price"><?=number_format((int)($sale_price + 0),2)?></i>
											</i>

											<del>
												<?=Session::get('symbol_right').' '.Session::get('symbol_left')?>
												<i class="prod_price"><?=number_format((int)($prod_price + 0),2)?></i>
											</del>

										</h4>
										<h6>
											<span class="badge bg-danger text-white"><?=$result['discount']?>% <?=App\Http\Controllers\Web\IndexController::trans_labels('off')?></span>
										</h6>
									</div>
								<?php else : ?>

									<h4>
										<?=Session::get('symbol_right').' '.Session::get('symbol_left')?>
										<i class="prod_price"><?=number_format((int)($prod_price + 0),2)?></i>
									</h4>

								<?php endif; ?>

							</div>
							<ul class="category">
								<li class="d-flex align-items-center gap-3"><strong><?=App\Http\Controllers\Web\IndexController::trans_labels('Category')?>:</strong><span> <?=rtrim($result['categories'],', ')?></span></li>
							</ul>
<div class="store">

	<div class="store-item d-flex align-items-center gap-3 mt-4">
		@if(isset($result['store_meta']['store_name']))

									<strong><?=App\Http\Controllers\Web\IndexController::trans_labels('By')?>:</strong>
									@endif
@if(isset($result['store_meta']['store_logo_image']))
									<figure>

										<img src="{{ asset($result['store_meta']['store_logo_image']) }}" alt="*">

									</figure>
@endif
@if(isset($result['store_meta']['store_name']))
									<figcaption>

										<h5 class="mt-0">
											<a href="<?=asset('store/'.$result['store_meta']['store_name'])?>">
												{{ $result['store_meta']['vendor_name'] }}											
											</a>
										</h5>

										<span>({{ \App\Models\Web\Products::where('author_id', $result['author_id'])->where('prod_status','active')->whereIn('prod_type', ['simple','variable'])->count() }} <?=App\Http\Controllers\Web\IndexController::trans_labels('Products')?>)</span>

									</figcaption>
@endif
								</div>

							</div>
							<div class="quantity w-auto flex-row position-relative d-flex justify-content-start align-items-center shop cart-item-qty my-4">

								<span><?=App\Http\Controllers\Web\IndexController::trans_labels('Quantity')?></span>

								<div class="qty-wrap d-flex ms-4 pb-2">

									<input type="number" class="form-control qty" name="qty" id="qty" value="1" max="<?=$result['prod_quantity']?>">
									<div class="qty-btn-wrap qty-btn-wrap">

										<button class="cart-plus border-0 bg-transparent qty-btn" type="button">
											<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.29897L11.3322 7L6 1.40206L0.667759 7L-6.12862e-08 6.29897L6 5.24537e-07L12 6.29897Z" fill="#414042"/>
											</svg>
										</button>
										<button class="cart-minus border-0 bg-transparent qty-btn" type="button">
											<svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.701032L0.667759 0L6 5.59794L11.3322 0L12 0.701032L6 7L0 0.701032Z" fill="#414042"/>
											</svg>
										</button>

									</div>
								</div>

							</div>

							<input type="hidden" name="ID" id="productID" value="<?=$result['ID']?>">

							<?php

							if( $result['prod_type'] == 'variable' ) : ?>

								<input type="hidden" name="variation" id="variationID" value="<?=$result['default_variation']?>">

								<?php 

								$attrs = '';

								foreach( $result['variations'] as $var ) : 


$cond = str_contains($var['attribute']['attribute_title'], 'Color') || 
        str_contains($var['attribute']['attribute_title'], 'لون');

									$c = $cond ? 'color-family' : '';

									$attrs.=$var['attribute']['attribute_slug'].','; ?>

									<div class="size <?=$c?> var-attribute my-4" data-attr="<?=$var['attribute']['attribute_ID']?>">

										<h5>

											<?=$var['attribute']['attribute_title']?>

										</h5>

										<?php

										foreach( $var['values'] as $key => $val ) :

											$attr = $key == 0 ? 'checked' : ''; 

											$class = $key == 0 ? 'active' : ''; 

											?>

											<label class="img-btn" title="<?=$val['value_title']?>">

												<input type="radio" name="attributes[values][<?=$var['attribute']['attribute_slug']?>]" class="<?=$class?>" <?=$attr?> value="<?=$val['value_ID']?>">

												<?php

												if( isset( $val['image'] ) ) : ?> 

													<img src="<?=asset($val['image'])?>" alt="*" style="height: 70px;">

												<?php endif;?>

												<?php 

												$style = $cond ? 'style="background:'.$val['value_slug'].'"' : '';

												$cond ? $val['value_slug'] = '' : '';

												?>

												<p <?=$style?> >


													<?php

													if($cond) : ?>

														<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" id="checkIcon"><path d="M9 16.2l-4.2-4.2-1.4 1.4 5.6 5.6 12-12-1.4-1.4z"></path>
														</svg>

													<?php  else : ?>

														<?=$val['value_title']?>

													<?php  endif; ?>

												</p>

											</label>

										<?php endforeach;?>

									</div>

								<?php endforeach; ?>
								<div class="my-3">

									<div class="form-group w-50">
										<textarea placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Personalized Message')?>" name="attributes[values][personal-message]" id="personal-message" class="p-0 form-control"></textarea>
									</div>
								</div>
							<?php endif;?>

							<div class="d-flex flex-wrap gap-2 gap-md-3">

								<?php

								$attr = $result['prod_quantity'] == 0 ? 'disabled' : '';?>

								<button type="submit" class="btn btn2" <?=$attr?>>
									<?=App\Http\Controllers\Web\IndexController::trans_labels('Add To cart')?>
									<svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.42986 14.0091C2.52986 15.3337 4.57586 15.3337 8.6697 15.3337H9.3297C13.4235 15.3337 15.4704 15.3337 16.5704 14.0091M1.42986 14.0091C0.329863 12.6836 0.70753 10.6724 1.46195 6.64824C1.9982 3.78824 2.26586 2.35733 3.28428 1.51216M16.5704 14.0091C17.6704 12.6836 17.2928 10.6724 16.5384 6.64824C16.0021 3.78824 15.7335 2.35733 14.7151 1.51216M14.7151 1.51216C13.6976 0.666992 12.241 0.666992 9.33061 0.666992H8.66878C5.75836 0.666992 4.3027 0.666992 3.28428 1.51216" stroke="#2D3C0A"/>
										<path d="M6.40625 4.33398C6.59564 4.87072 6.94684 5.3355 7.41147 5.66426C7.87609 5.99302 8.43125 6.16956 9.00042 6.16956C9.56959 6.16956 10.1247 5.99302 10.5894 5.66426C11.054 5.3355 11.4052 4.87072 11.5946 4.33398" stroke="#2D3C0A" stroke-linecap="round"/>
									</svg>
								</button>

								<?php $c = $result['wishlist'] ? 'exists' : ''; ?>

								<a href="javascript:;" class="whishlist-btn border-0 " data-var_id="" data-id="<?=$result['ID']?>">

									<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M10 17C10 17 1 11.9091 1 5.72728C1 4.63445 1.37484 3.57537 2.06076 2.73024C2.74667 1.88511 3.70128 1.30613 4.76218 1.09181C5.82307 0.877486 6.92471 1.04106 7.87966 1.55471C8.83461 2.06835 9.58388 2.90033 10 3.9091C10.4161 2.90033 11.1654 2.06835 12.1203 1.55471C13.0753 1.04106 14.1769 0.877486 15.2378 1.09181C16.2987 1.30613 17.2533 1.88511 17.9392 2.73024C18.6252 3.57537 19 4.63445 19 5.72728C19 11.9091 10 17 10 17Z" stroke="#2D3C0A" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

								</a>

								<a href="javascript:;" id="storeshare" data-id="storeshare" class="btn rounded-circle btn2" style="min-width:initial;width: 3rem;" data-bs-toggle="modal" data-bs-target="#storeshare">
									<svg width="20" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.525 8.025L11.475 5.475M6.525 9.975L11.475 12.525M2.25 9C2.25 9.59674 2.48705 10.169 2.90901 10.591C3.33097 11.0129 3.90326 11.25 4.5 11.25C5.09674 11.25 5.66903 11.0129 6.09099 10.591C6.51295 10.169 6.75 9.59674 6.75 9C6.75 8.40326 6.51295 7.83097 6.09099 7.40901C5.66903 6.98705 5.09674 6.75 4.5 6.75C3.90326 6.75 3.33097 6.98705 2.90901 7.40901C2.48705 7.83097 2.25 8.40326 2.25 9ZM11.25 4.5C11.25 5.09674 11.4871 5.66903 11.909 6.09099C12.331 6.51295 12.9033 6.75 13.5 6.75C14.0967 6.75 14.669 6.51295 15.091 6.09099C15.5129 5.66903 15.75 5.09674 15.75 4.5C15.75 3.90326 15.5129 3.33097 15.091 2.90901C14.669 2.48705 14.0967 2.25 13.5 2.25C12.9033 2.25 12.331 2.48705 11.909 2.90901C11.4871 3.33097 11.25 3.90326 11.25 4.5ZM11.25 13.5C11.25 14.0967 11.4871 14.669 11.909 15.091C12.331 15.5129 12.9033 15.75 13.5 15.75C14.0967 15.75 14.669 15.5129 15.091 15.091C15.5129 14.669 15.75 14.0967 15.75 13.5C15.75 12.9033 15.5129 12.331 15.091 11.909C14.669 11.4871 14.0967 11.25 13.5 11.25C12.9033 11.25 12.331 11.4871 11.909 11.909C11.4871 12.331 11.25 12.9033 11.25 13.5Z" stroke="#6D7D36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>

									</svg></a>

								</div>

								<div class="position-absolute top-0 bottom-0 end-0 m-3 z-2 d-md-none">
									<div class="position-sticky" style="top:1rem">
										<button type="submit" class="btn bg-olive btn2" <?=$attr?> style="min-width:auto">
											<svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1.42986 14.0091C2.52986 15.3337 4.57586 15.3337 8.6697 15.3337H9.3297C13.4235 15.3337 15.4704 15.3337 16.5704 14.0091M1.42986 14.0091C0.329863 12.6836 0.70753 10.6724 1.46195 6.64824C1.9982 3.78824 2.26586 2.35733 3.28428 1.51216M16.5704 14.0091C17.6704 12.6836 17.2928 10.6724 16.5384 6.64824C16.0021 3.78824 15.7335 2.35733 14.7151 1.51216M14.7151 1.51216C13.6976 0.666992 12.241 0.666992 9.33061 0.666992H8.66878C5.75836 0.666992 4.3027 0.666992 3.28428 1.51216" stroke="#f9fbed"></path>
												<path d="M6.40625 4.33398C6.59564 4.87072 6.94684 5.3355 7.41147 5.66426C7.87609 5.99302 8.43125 6.16956 9.00042 6.16956C9.56959 6.16956 10.1247 5.99302 10.5894 5.66426C11.054 5.3355 11.4052 4.87072 11.5946 4.33398" stroke="#f9fbed" stroke-linecap="round"></path>
											</svg>
										</button>
									</div>
								</div>

							</form>
<?php 
$isEmptyDesc = empty($result['prod_description']);
?>

<h5 class="js-prod-description-heading <?= $isEmptyDesc ? 'd-none' : '' ?>">
    <?= App\Http\Controllers\Web\IndexController::trans_labels('Description') ?>
</h5>

<div class="js-prod-description-content <?= $isEmptyDesc ? 'd-none' : '' ?>">
    <?php
    if ($isEmptyDesc) {
        $result['prod_description'] = '';
    }
    echo '<p class="desc mb-0">'.str_replace("\n", '<br>', $result['prod_description']).'</p>';
    ?>
</div>


<?php 
$prod_features = $result['prod_features'] ?? null;
?>
<h5 class="js-prod-features-heading <?= empty($prod_features) ? 'd-none' : '' ?>">
    <?= App\Http\Controllers\Web\IndexController::trans_labels('Product Features') ?>
</h5>

<div class="js-prod-features-content <?= empty($prod_features) ? 'd-none' : '' ?>">
    <?php
    $default = '';
    
    echo $prod_features ?: $default;
    ?>
</div>



						</div>

					</div>

				</div>

			</div>

		</section>

		<section class="main-section productdetail-section-two">

			<div class="container">

				<div class="row">

					<div class="col-md-12">

<?php 
$isEmpty = empty($result['prod_short_description']);
?>

<h5 class="js-additional-info-heading <?= $isEmpty ? 'd-none' : '' ?>">
    <?= App\Http\Controllers\Web\IndexController::trans_labels('Additional Information') ?>
</h5>

<div class="js-additional-info-content <?= $isEmpty ? 'd-none' : '' ?>" data-class="mb-2">
    <?php
    if (!$isEmpty) {
        $check = false;

        echo '<div class="data-all"><p>';

        $spec = str_split($result['prod_short_description']);
        $string = '';

        foreach ($spec as $key => $text) {
            if ($key < 500) {
                $string .= $text;
            } else {
                $check = true;
            }
        }

        echo $string;
        echo $check ? '...' : '';
        echo '</p></div>';

        if ($check) {
            echo '<div class="data-more" style="display:none"><p>' . str_replace("\n", '<br>', $result['prod_short_description']) . '</p></div>';
            echo '<a href="javascript:;" class="link read-more">Read More</a>';
        }
    }
    ?>
</div>



						@include('web.shop.review-section',['result' => $result])

					</div>
				</div>

			</div>

		</section>
	</div>
	@if(count($related) > 0 )
	<section class="main-section productdetail-section-three pt-0 related-section">

		<div class="container">



			<div class="main-heading text-center"><h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Related Products')?></h2></div>

			<div class="section-slider section-slider-pro related-pro-slider">

				<?php

				foreach( $related as $product ) : ?>

					<div class="gallery">

						@include('web.product.content',['product' => $product])

					</div>

				<?php endforeach;?>

			</div>

		</div>


	</section>
@endif

	@endsection

	<style type="text/css">
		#storeshare .modal-body::before{background:#fff !important}
		.socialIcons.social-share{margin: 0 !important} 

		:root {
			--icon-color: #000000;
		}


		.color-family p {
			background-color: var(--background-color);
			display: inline-block;
			padding: 20px;
			border-radius: 5px;
			margin-bottom: 20px;
		}

		.color-family p svg {
			fill: var(--icon-color);
		}


	</style>