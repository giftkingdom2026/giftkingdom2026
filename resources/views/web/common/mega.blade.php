<?php
use App\Models\Core\Megamenu;
$result['megamenu'] = Megamenu::getMenu(); ?>

<div class="offcanvas w-100" tabindex="-1" id="mainMenu" data-bs-backdrop="false" aria-labelledby="mainMenuLabel">

	<div class="offcanvas-body d-flex align-items-center justify-content-center">

		<div class="container">

			<div class="dropdown-wrap">

				<ul class="dropdownMenu d-flex flex-column gap-3">

					<?php

					foreach($result['megamenu'] as $key => $menu) : ?>

						<li class="menu-item active">

							<a href="<?=asset('shop/category/'.$menu['category_ID']['categories_slug'])?>">
								<?=$menu['category_ID']['category_title']?> 
								<svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 9L5 5L1 1" stroke="#6D7D36" stroke-linecap="round"/></svg>
							</a>

							<div class="subMenu">

								<div class="row">

									<div class="col-md-3">

										<ul class="subMenuLeft d-flex flex-column gap-3">

											<?php

											foreach($menu['category_ID']['children'] as $child ) :   ?>

												<li>
													<a href="<?=asset('shop/category/'.$child['categories_slug'])?>">
														<?=$child['category_title']?> 
														<svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 9L5 5L1 1" stroke="#2D3C0A" stroke-linecap="round"/></svg>
													</a>
												</li>

												<?php 

											endforeach;?>

										</ul>
									</div>

									<div class="col-md-9">

										<div class="subMenuRight ps-lg-5">
											<div class="row gy-4">

												<?php

												if( isset( $menu['menu_offers'][0] ) ) : ?>

													<div class="col-md-6">
														<article class="menuImg1">
															<div class="p-4">
																<h2><?=$menu['menu_offers'][0]['post_title']?></h2>
															</div>
															<figure class="pb-2 pe-2">
																<img src="<?=asset($menu['menu_offers'][0]['featured_image']['path'])?>" alt="*" class="w-100">
															</figure>
														</article>
													</div>

												<?php endif;

												if( isset( $menu['menu_offers'][1] ) ) : ?>

													<div class="col-md-6">
														<article class="menuImg2">
															<div class="p-4">
																<h2><?=$menu['menu_offers'][1]['post_title']?></h2>
															</div>
															<figure class="pb-2 pe-2">
																<img src="<?=asset($menu['menu_offers'][1]['featured_image']['path'])?>" alt="*" class="w-100">
															</figure>
														</article>
													</div>

												<?php endif;

												if( isset( $menu['menu_offers'][2] ) ) : ?>

													<div class="col-md-12">
														<article class="menuImg3">
															<div class="p-4">
																<h2 class="mb-4"><?=$menu['menu_offers'][2]['post_title']?></h2>
																<a href="<?=asset('shop')?>" class="btn">Shop Now <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"/></svg></a>
															</div>
															<figure class="pe-2">
																<img src="<?=asset($menu['menu_offers'][2]['featured_image']['path'])?>" alt="*" class="w-100">
															</figure>
														</article>
													</div>

												<?php endif;?>

											</div>
										</div>
									</div>
								</div>
							</div>
						</li>

						<?php 

					endforeach; ?>

				</ul>
			</div>

		</div>

	</div>
</div>
