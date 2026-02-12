@extends('web.layout')


@section('content')
<style type="text/css">
	/*.loader-main{}*/
	.products-section .home-section-five .loader-main {
		/* position: absolute;
    inset: 0;
    z-index: 999;
    background: #fff;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;
    align-items: center;*/
		position: absolute;
		inset: 0;
		z-index: 999;
		background: rgb(255 255 255 / 85%);
		display: flex;
		flex-direction: column;
		flex-wrap: nowrap;
		align-content: center;
		justify-content: flex-start;
		align-items: center;
		padding-top: 5rem;
	}

	.products-section .home-section-five .loader {
		width: 3rem;
		height: 3rem;

		padding: 8px;
		aspect-ratio: 1;
		border-radius: 50%;
		background: #feb100;
		--_m:
			conic-gradient(#0000 10%, #000),
			linear-gradient(#000 0 0) content-box;
		-webkit-mask: var(--_m);
		mask: var(--_m);
		-webkit-mask-composite: source-out;
		mask-composite: subtract;
		animation: l3 1s infinite linear;
	}

	@keyframes l3 {
		to {
			transform: rotate(1turn)
		}
	}
</style>

<div class="offcanvas offcanvas-end d-lg-none" id="filterSideBar">
	<div class="offcanvas-header pb-0">
		<button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas"></button>
	</div>
	<div class="offcanvas-body p-0">
		@include('web.shop.filter',['filter'=>$filter])
	</div>
</div>

<section class="shop-head">

	<?php

	if (!empty($catdata)) : ?>

		<div class="inner-banner mt-4">

			<div class="container">

				<article class="py-4 py-lg-2">

					<div class="row justify-content-between align-items-center">

						<div class="col-sm-8 col-md-6 col-lg-6 col-xl-4">

							<h1 class="mb-0 wow fadeInUp"><?= $catdata['category_title'] ?></h1>

							@include('web.shop.breadcrumbs',['category'=>$catdata])

						</div>

						<div class="col-sm-4 col-md-3">

							<figure class="overflow-hidden">

								<img src="<?= asset($catdata['category_image']['path']) ?>" alt="*" class="wow">

							</figure>

						</div>

					</div>

				</article>

			</div>

		</div>

	<?php

	else : ?>

		<div class="container">

			<div class="shop-headInnr d-flex flex-row justify-content-center align-items-center flex-wrap text-center">

				<div class="shop-head-left">

					<div class="main-heading mb-0">

<h2 class="text-capitalize">
    {{ request()->has('category') ? str_replace('-', ' ', request()->category) : $result['content']['banner_text'] }}
</h2>

						@include('web.shop.breadcrumbs',['breadcrumb'=>$breadcrumb])

					</div>


				</div>

				<div class="shop-head-right d-flex gap-3 gap-lg-5 flex-row justify-content-between align-items-center flex-wrap">

					<div class="filterBtn d-lg-none mt-3 mt-lg-0 mb-3 mb-lg-0">
						<a href="javascript:;" class="btn" data-bs-toggle="offcanvas" data-bs-target="#filterSideBar">Filter</a>
					</div>

				</div>

			</div>

		</div>

	<?php endif; ?>

</section>


<section class="main-section products-section">

	<div class="container">

		<div class="shop-top mb-4 pb-1 d-none">

			<ul class="select-category d-flex gap-2 flex-wrap">

				<?php foreach ($activefilter as $key => $item) :   ?>

					<li>

						<?php

						$id = '';

						if ($key == 'deal' || $key == 'category') :

							$title = $item['category_title'];

							$id = $item['category_ID'];

						elseif ($key == 'brand') :

							$title = $item['brand_title'];

							$id = $item['brand_ID'];

						else :

							$title = $item;

						endif; ?>

						<a href="javascript:;" data-remove="<?= $key ?>" data-id="<?= $id ?>" class="active remove-filter">
							<?= $title ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 512 512">
								<path fill="#fff" d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"></path>
							</svg>
						</a>

					</li>

				<?php endforeach; ?>

			</ul>

		</div>

		<div class="row">

			<div class="col-lg-4 col-xl-3 d-none d-lg-block" id="filter">

				@include('web.shop.filter',['filter'=>$filter])

			</div>

			<div class="col-lg-8 col-xl-9">

				<div class="section-slider account-section section-slider-pro position-relative m-0 careerFilter">
					<div class="loader-main">

						<div class="loader"></div>
					</div>
					<div class="row justify-content-end">
						<div class="col-md-3">

							<div class="dropdown child_option">
								<button class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" type="button" id="sortDropdown">
									<?= \App\Http\Controllers\Web\IndexController::trans_labels('Sort By'); ?>
									<svg
										width="12" height="8" viewBox="0 0 12 8" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2"
											stroke-linecap="round" />
									</svg>
								</button>

								<div class="dropdown-menu2 sortDropdownMenu dropdown-menu-right">
									<ul class="careerFilterInr">
										<?php
									$arr = [
    'default'       => \App\Http\Controllers\Web\IndexController::trans_labels('Default'),
    'featured'      => \App\Http\Controllers\Web\IndexController::trans_labels('Featured Products'),
    'best-sellers'  => \App\Http\Controllers\Web\IndexController::trans_labels('Best Sellers'),
    'price-asc'     => \App\Http\Controllers\Web\IndexController::trans_labels('Price Low to High'),
    'price-desc'    => \App\Http\Controllers\Web\IndexController::trans_labels('Price High to Low'),
];


										foreach ($arr as $key => $item) :
											$attr = isset($filter['sort']) && $filter['sort'] == $key ? 'checked' : '';
										?>
											<li class="dropdown_select">
												<div class="form-check p-0 m-0">
													<input class="form-check-input filter-item d-none" data-type="sort" <?= $attr ?> data-value="<?= $key ?>" type="radio" name="sort" id="<?= $key ?>" value="<?= $key ?>">
													<label class="form-check-label label-brand dropdown-option" for="<?= $key ?>" data-label="<?= $item ?>" data-value="<?= $key ?>"><?= $item ?></label>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row gy-lg-5" id="results">

						<?php if (!empty($result['data'])): ?>
							<div class="col-md-12">
								<p>
									<?= App\Http\Controllers\Web\IndexController::trans_labels('Showing') ?>
									<strong><?= count($result['data']) ?></strong>
									<?= App\Http\Controllers\Web\IndexController::trans_labels('of') ?>
									<strong><?= $result['total'] ?></strong>
									<?= App\Http\Controllers\Web\IndexController::trans_labels('Products') ?>!
								</p>
							</div>
						<?php endif; ?>

						<?php

						$c = '';

						if (empty($result['data'])) :

							$c = 'style="display:none"' ?>

							<div class="main-heading text-center mt-5">

								<h3><?= App\Http\Controllers\Web\IndexController::trans_labels('No Products Found Related to Query') ?>!</h3>

							</div>

							<?php else :

							foreach ($result['data'] as $product) : ?>

								<div class="col-sm-6 mb-3 wrap col-xl-4 mt-0">

									@include('web.product.content',['product' => $product])

								</div>

							<?php endforeach; ?>


						<?php endif; ?>

						<?php if (!empty($result['data'])): ?>

							<?php

							if ($result['total'] > $result['per_page']) : ?>

								<div class="col-md-12">

									<div class="new_links">

										<div class="pagination d-flex justify-content-center align-items-center gap-4 mt-5">


											<ul class="d-flex justify-content-center align-items-center gap-4">

												<?php
												foreach ($result['links'] as $link) :

													$url = $link['url'] ? $link['url'] : 'javascript:;';

													$class = $link['active'] ? 'active' : '';

													$title = $link['label'];

													str_contains($link['label'], 'Previous') ?

														$title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5.57692L1.61864 5.57692L6.0678 1.13462L5.50847 0.5L2.40413e-07 6L5.50847 11.5L6.0678 10.8654L1.61864 6.42308L12 6.42308L12 5.57692Z" fill="#6D7D36"/></svg>' : '';

													str_contains($link['label'], 'Next') ?

														$title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.31755e-07 5.57692L10.3814 5.57692L5.9322 1.13462L6.49153 0.5L12 6L6.49153 11.5L5.9322 10.8654L10.3814 6.42308L6.94768e-07 6.42308L7.31755e-07 5.57692Z" fill="#6D7D36"/></svg>' : '';

												?>

													<li>
														<a href="<?= $url ?>" class="<?= $class ?> page-link-products"><?= $title ?></a>


													</li>

												<?php endforeach; ?>

											</ul>

										</div>

									</div>

								</div>

							<?php endif; ?>

						<?php endif; ?>

					</div>



				</div>

			</div>

		</div>

	</div>

</section>

@endsection