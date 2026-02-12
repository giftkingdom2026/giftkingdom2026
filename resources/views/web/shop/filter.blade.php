<pre style="display:none">

	<?php print_r($filter); ?>

</pre>
<div class="shop-sidebar">

	<div class="mb-4 d-flex align-items-center justify-content-between">
		<h4 class="m-0"><?= App\Http\Controllers\Web\IndexController::trans_labels('Filters') ?></h4>

		<a href="javascript:;" class="btn btn2 clear-filter" style="min-width: inherit;"><?= App\Http\Controllers\Web\IndexController::trans_labels('Clear') ?></a>
		<a href="javascript:;" class="filter-item d-none" data-type="clear" data-value="clear" data-value-category-id="<?= isset($catdata['category_ID']) ? $catdata['category_ID'] : '' ?>"></a>

	</div>

	<div class="accordion" id="accordionExample">

		<div class="accordion-item">
			@php
			$ariaExpanded = 'false';
			$cond = 'collapse';

			foreach ($filter['categories'] as $cat) {
			if (request()->category == $cat['categories_slug']) {
			$ariaExpanded = 'true';
			$cond = 'show';
			break; // once found, no need to continue loop
			}
			}
			@endphp
			<h2 class="accordion-header" id="headingOne">
				<?php
				if (isset($filter['lastactive'])) :
					$filter['lastactive'] == 'category' ? $ac = '' : $ac = 'collapsed';

					$filter['lastactive'] == 'category' ? $ac2 = 'show' : $ac2 = '';
				else :
					isset(request()->category) ? $ac = '' : $ac = 'collapsed';

					isset(request()->category) ? $ac2 = 'show' : $ac2 = '';
				endif; ?>
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="{{ $ariaExpanded }}" aria-controls="collapseOne"><?= App\Http\Controllers\Web\IndexController::trans_labels('Categories') ?> <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L-2.97099e-08 11.3322L5.59794 6L-5.04193e-07 0.667759L0.701031 -3.01055e-08L7 6L0.701032 12Z" fill="#2D3C0A" />
					</svg></button>
			</h2>
			<div id="collapseOne" class="accordion-collapse {{ $cond }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample">

				<div class="accordion-body">

					<div class="accordion" id="sub-accordionExample">

						<?php

						$activecat = '';
						foreach ($filter['categories'] as $key => $cat):?>
@php
						$c1 = isset($cat['active']) ? '' : 'collapsed';
						$c2 = isset($cat['active']) ? 'show' : 'collapse';
						$c4 = empty($cat['children']) ? 'removearrow' : '';
						@endphp
							<div class="accordion-item">

								<h2 class="accordion-header d-flex align-items-center" id="sub-heading<?= $key ?>">

									<span class="filter-item d-inline-block" data-type="category" data-value="<?= $cat['category_ID'] ?>"><?= $cat['category_title'] ?></span>
									@php
									$catSlug = 'category/' . $cat['categories_slug'];
									@endphp

									<button class="accordion-button {{ $c4 }} {{ $c1 }}" type="button" data-bs-toggle="collapse" data-bs-target="#sub-collapse{{ $key }}" aria-expanded="{{ Illuminate\Support\Str::contains(request()->url(), $catSlug) ? 'true' : 'false' }}" aria-controls="collapse{{ $key }}">
									@if ($c4 != 'removearrow')
									<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L0 11.3322L5.59794 6L0 0.667759L0.701031 0L7 6L0.701032 12Z" fill="#2D3C0A" />
									</svg>
									@endif
									</button>

								</h2>

								<div id="sub-collapse<?= $key ?>" class="accordion-collapse {{ $c4 != 'removearrow' ? $c2 : 'collapse' }}" aria-labelledby="sub-heading<?= $key ?>" data-bs-parent="#sub-accordionExample">

									<div class="accordion-body">

										<ul class="brands-list mb-2">

											<?php

											foreach ($cat['children'] as $child) :

												$attr = isset($child['active']) ? 'checked' : '';
												'';

												isset($child['active']) ? $activecat =  $child['category_ID'] : '';  ?>

												<li>

													<div class="form-check p-0 m-0">

														<input class="form-check-input filter-item" <?= $attr ?> type="checkbox" id="<?= $child['category_ID'] ?>" class="filter-item" data-type="category" data-value="<?= $child['category_ID'] ?>">

														<label class="form-check-label label-brand" for="<?= $child['category_ID'] ?>"><?= $child['category_title'] ?> <span class="filter-count">(<?= $child['count'] ?>)</span></label>

													</div>

												</li>

											<?php endforeach; ?>

										</ul>

									</div>

								</div>

							</div>

						<?php endforeach; ?>

					</div>

				</div>

			</div>

		</div>

		<div class="accordion-item">
			@php
			$ariaExpanded = 'false';
			$cond = 'collapse';

			foreach ($filter['recipients'] as $cat) {
			if (request()->category == $cat['categories_slug']) {
			$ariaExpanded = 'true';
			$cond = 'show';
			break; // once found, no need to continue loop
			}
			}
			@endphp
			<h2 class="accordion-header" id="headingOne1">

				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="{{ $ariaExpanded }}" aria-controls="collapseOne1"><?= App\Http\Controllers\Web\IndexController::trans_labels('Recipients') ?> <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L-2.97099e-08 11.3322L5.59794 6L-5.04193e-07 0.667759L0.701031 -3.01055e-08L7 6L0.701032 12Z" fill="#2D3C0A" />
					</svg></button>

			</h2>

			<div id="collapseOne1" class="accordion-collapse {{ $cond }}" aria-labelledby="headingOne1" data-bs-parent="#accordionExample">

				<div class="accordion-body">

					<div class="accordion" id="sub-accordionExample">

						<?php

						$activecat = '';

						foreach ($filter['recipients'] as $key => $cat):

							isset($cat['active']) ? $c1 = '' : $c1 = 'collapsed';

							isset($cat['active']) ? $c2 = 'show' : $c2 = '';

							isset($cat['active']) ? $activecat =  $cat['category_ID'] : '';

							empty($cat['children']) ? $c4 = 'removearrow' : $c4 = ''; ?>

							<div class="accordion-item">

								<h2 class="accordion-header d-flex align-items-center" id="sub-heading<?= $key ?>">

									<span class="filter-item d-inline-block" data-type="category" data-value="<?= $cat['category_ID'] ?>"><?= $cat['category_title'] ?></span>
									<button class="accordion-button <?= $c4 ?> <?= $c1 ?>" type="button" data-bs-toggle="collapse" data-bs-target="#sub-collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>">
									@if ($c4 != 'removearrow')
									<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L0 11.3322L5.59794 6L0 0.667759L0.701031 0L7 6L0.701032 12Z" fill="#2D3C0A" />
									</svg>
									@endif
									</button>

								</h2>

								<div id="sub-collapse<?= $key ?>" class="accordion-collapse {{ $c4 != 'removearrow' ? $c2 : 'collapse' }}" aria-labelledby="sub-heading<?= $key ?>" data-bs-parent="#sub-accordionExample">

									<div class="accordion-body">

										<ul class="brands-list mb-2">

											<?php

											foreach ($cat['children'] as $child) :

												$attr = isset($child['active']) ? 'checked' : '';
												'';

												isset($child['active']) ? $activecat =  $child['category_ID'] : '';  ?>

												<li>

													<div class="form-check p-0 m-0">

														<input class="form-check-input filter-item" <?= $attr ?> type="checkbox" id="<?= $child['category_ID'] ?>" class="filter-item" data-type="category" data-value="<?= $child['category_ID'] ?>">

														<label class="form-check-label label-brand" for="<?= $child['category_ID'] ?>"><?= $child['category_title'] ?> <span class="filter-count">(<?= $child['count'] ?>)</span></label>

													</div>

												</li>

											<?php endforeach; ?>

										</ul>

									</div>

								</div>

							</div>

						<?php endforeach; ?>

					</div>

				</div>

			</div>

		</div>

		<div class="accordion-item">
			@php
			$ariaExpanded = 'false';
			$cond = 'collapse';

			foreach ($filter['occassions'] as $cat) {
			if (request()->category == $cat['categories_slug']) {
			$ariaExpanded = 'true';
			$cond = 'show';
			break; // once found, no need to continue loop
			}
			}
			@endphp

			<h2 class="accordion-header" id="headingOne2">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="{{ $ariaExpanded }}" aria-controls="collapseOne2">
					{{ App\Http\Controllers\Web\IndexController::trans_labels('Occassions') }}
					<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L0 11.3322L5.59794 6L0 0.667759L0.701031 0L7 6L0.701032 12Z" fill="#2D3C0A" />
					</svg>
				</button>
			</h2>

			<div id="collapseOne2" class="accordion-collapse {{ $cond }}" aria-labelledby="headingOne2" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<div class="accordion" id="sub-accordionExample">

						@foreach ($filter['occassions'] as $key => $cat)
						@php
						$c1 = isset($cat['active']) ? '' : 'collapsed';
						$c2 = isset($cat['active']) ? 'show' : 'collapse';
						$c4 = empty($cat['children']) ? 'removearrow' : '';
						@endphp

						<div class="accordion-item">
							<h2 class="accordion-header d-flex align-items-center" id="sub-heading{{ $key }}">
								<span class="filter-item d-inline-block" data-type="category" data-value="{{ $cat['category_ID'] }}">
									{{ $cat['category_title'] }}
								</span>

								<button class="accordion-button {{ $c4 }} {{ $c1 }}" type="button" data-bs-toggle="collapse" data-bs-target="#sub-collapse{{ $key }}" aria-expanded="false" aria-controls="sub-collapse{{ $key }}">
									@if ($c4 != 'removearrow')
									<svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L0 11.3322L5.59794 6L0 0.667759L0.701031 0L7 6L0.701032 12Z" fill="#2D3C0A" />
									</svg>
									@endif
								</button>
							</h2>

							<div id="sub-collapse{{ $key }}" class="accordion-collapse {{ $c4 != 'removearrow' ? $c2 : 'collapse' }}" aria-labelledby="sub-heading{{ $key }}" data-bs-parent="#sub-accordionExample">
								<div class="accordion-body">
									<ul class="brands-list mb-2">
										@foreach ($cat['children'] as $child)
										@php
										$isChecked = isset($child['active']) ? 'checked' : '';
										@endphp
										<li>
											<div class="form-check p-0 m-0">
												<input class="form-check-input filter-item" {{ $isChecked }} type="checkbox" id="{{ $child['category_ID'] }}" data-type="category" data-value="{{ $child['category_ID'] }}">
												<label class="form-check-label label-brand" for="{{ $child['category_ID'] }}">
													{{ $child['category_title'] }}
													<span class="filter-count">({{ $child['count'] }})</span>
												</label>
											</div>
										</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>


		<!-- <div class="accordion-item">

			<h2 class="accordion-header" id="headingTwo">

				<?php

				isset($filter['lastactive']) && $filter['lastactive'] == 'sort' ?  '' : $ac = 'collapsed';

				isset($filter['lastactive']) && $filter['lastactive'] == 'sort' ? $ac2 = 'show' : $ac2 = '';

				?>

				<button class="accordion-button <?= $ac ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

					<?= App\Http\Controllers\Web\IndexController::trans_labels('Sort By') ?> <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L-2.97099e-08 11.3322L5.59794 6L-5.04193e-07 0.667759L0.701031 -3.01055e-08L7 6L0.701032 12Z" fill="#2D3C0A"/></svg>

				</button>

			</h2>

			<div id="collapseTwo" class="accordion-collapse collapse <?= $ac2 ?>" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">

				<div class="accordion-body">

					<ul class="brands-list mb-2">

						<?php

						// $arr = ['default' => 'Default','alpha-asc' => 'Name (A - Z)','alpha-desc' => 'Name (Z - A)','price-asc' => 'Price Low to High','price-desc' => 'Price High to Low'];
						$arr = ['default' => 'Default', 'Featured Products', 'featured' => 'Best Sellers', 'price-asc' => 'Price Low to High', 'price-desc' => 'Price High to Low'];

						foreach ($arr as $key => $item) :

							$attr = isset($filter['sort']) && $filter['sort'] == $key ? 'checked' : ''; ?>

							<li>

								<div class="form-check p-0 m-0">

									<input class="form-check-input filter-item" data-type="sort" <?= $attr ?> data-value="<?= $key ?>" type="checkbox" name="sort" id="<?= $key ?>" value="<?= $key ?>">

									<label class="form-check-label label-brand" for="<?= $key ?>"><?= $item ?></label>

								</div>

							</li>

						<?php endforeach; ?>



					</ul>

				</div>

			</div>

		</div> -->

		<?php

		$c1 = isset($filter['lastactive']) && $filter['lastactive'] == 'price' ? '' : 'collapsed';

		$c2 = isset($filter['lastactive']) && $filter['lastactive'] == 'price' ? 'show' : ''; ?>

		<div class="accordion-item">

			<h2 class="accordion-header" id="headingThree">

				<button class="accordion-button <?= $c1 ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

					<?= App\Http\Controllers\Web\IndexController::trans_labels('Price (AED)') ?> <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L-2.97099e-08 11.3322L5.59794 6L-5.04193e-07 0.667759L0.701031 -3.01055e-08L7 6L0.701032 12Z" fill="#2D3C0A" />
					</svg>

				</button>

			</h2>

			<div id="collapseThree" class="accordion-collapse collapse <?= $c2 ?>" aria-labelledby="headingThree" data-bs-parent="#accordionExample">

				<div class="accordion-body">
					<div class="range-slider">
						<?php

						$from = isset($filter['price']['from']) ? $filter['price']['from'] : 0;
						$to = isset($filter['price']['to']) ? $filter['price']['to'] : 99000; ?>

						<span class="rangeValues">
							<sign>AED</sign>
							<valo><?= $from ?></valo> - <sign>AED</sign>
							<valt><?= $to ?></valt>
						</span>
						<input value="<?= $from ?>" min="0" max="99000" step="100" class="range-slider-check" type="range">
						<input value="<?= $to ?>" min="0" max="99000" step="100" class="range-slider-check" type="range">
					</div>
					<a href="javascript:;" class="filter-item price-filter" data-type="price"></a>

				</div>

			</div>
		</div>

		<div class="accordion-item">

			<h2 class="accordion-header" id="headingFour">

				<?php


				isset(Route::current()->parameters['brand']) ? $ac = '' : $ac = 'collapsed';

				isset(Route::current()->parameters['brand']) ? $ac2 = 'show' : $ac2 = '';

				isset($filter['lastactive']) && $filter['lastactive'] == 'brand' ?  '' : $ac = 'collapsed';

				isset($filter['lastactive']) && $filter['lastactive'] == 'brand' ? $ac2 = 'show' : $ac2 = '';

				?>

				<button class="accordion-button <?= $ac ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">

					<?= App\Http\Controllers\Web\IndexController::trans_labels('Brands') ?> <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L-2.97099e-08 11.3322L5.59794 6L-5.04193e-07 0.667759L0.701031 -3.01055e-08L7 6L0.701032 12Z" fill="#2D3C0A" />
					</svg>

				</button>

			</h2>

			<div id="collapseFour" class="accordion-collapse collapse <?= $ac2 ?>" aria-labelledby="headingFour" data-bs-parent="#accordionExample">

				<div class="accordion-body">

					<ul class="brands-list mb-2">

						<li class="d-none">

							<div class="form-group position-relative mt-3 mb-4">

								<input type="text" name="Name" id="brand" placeholder="Search" class="form-control">

								<button class="position-absolute border-0 circle-hover p-0" id="brand_search"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M15.7499 15.75L12.4927 12.4927M12.4927 12.4927C13.0498 11.9356 13.4918 11.2741 13.7933 10.5461C14.0949 9.81816 14.2501 9.03792 14.2501 8.24997C14.2501 7.46202 14.0949 6.68178 13.7933 5.95381C13.4918 5.22584 13.0498 4.56439 12.4927 4.00722C11.9355 3.45006 11.274 3.00809 10.5461 2.70655C9.8181 2.40502 9.03786 2.24982 8.24991 2.24982C7.46196 2.24982 6.68172 2.40502 5.95375 2.70655C5.22578 3.00809 4.56433 3.45006 4.00716 4.00722C2.88191 5.13247 2.24976 6.65863 2.24976 8.24997C2.24976 9.84131 2.88191 11.3675 4.00716 12.4927C5.13241 13.618 6.65857 14.2501 8.24991 14.2501C9.84125 14.2501 11.3674 13.618 12.4927 12.4927Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
									</svg></button>

							</div>

						</li>

						<?php

						$activebrand = '';

						$t_products_count = 0;

						foreach ($filter['brands'] as $brand) :

							isset($brand['active']) ? $attr = 'checked' : $attr = '';

							isset($brand['active']) ? $activebrand = $brand['brand_ID'] : '';

						?>

							<li>

								<div class="form-check p-0 m-0">

									<input class="form-check-input filter-item" data-type="brand" data-value="<?= $brand['brand_ID'] ?>" type="checkbox" <?= $attr ?> name="brand" id="<?= $brand['brand_slug'] ?>" value="<?= $brand['brand_slug'] ?>" f_count="<?= $brand['count'] ?>">

									<label class="form-check-label label-brand" for="<?= $brand['brand_slug'] ?>"><?= $brand['brand_title'] ?> <span class="filter-count">(<?= $brand['count'] ?>)</span></label>

								</div>

							</li>

							<?php $t_products_count += $brand['count']; ?>

						<?php endforeach; ?>
						<input type="hidden" value="{{$t_products_count}}" class="t_products_count">


					</ul>

				</div>

			</div>

		</div>

		<div class="accordion-item d-none">

			<h2 class="accordion-header" id="headingFive">

				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">

					Product Rating

				</button>

			</h2>

			<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">

				<div class="accordion-body">

				</div>

			</div>

		</div>

		<?php

		if (isset($filter['attributes'])) :

			foreach ($filter['attributes'] as $attr) :

				isset($attr['active']) ? $ac = '' : $ac = 'collapsed';

				isset($attr['active']) ? $ac2 = 'show' : $ac2 = ''; ?>

				<div class="accordion-item">

					<h2 class="accordion-header" id="heading<?= $attr['attribute']['attribute_ID'] ?>">

						<button class="accordion-button <?= $ac ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $attr['attribute']['attribute_ID'] ?>" aria-expanded="false" aria-controls="collapse<?= $attr['attribute']['attribute_ID'] ?>">

							<?= $attr['attribute']['attribute_title'] ?> <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M0.701032 12L-2.97099e-08 11.3322L5.59794 6L-5.04193e-07 0.667759L0.701031 -3.01055e-08L7 6L0.701032 12Z" fill="#2D3C0A" />
							</svg>

						</button>

					</h2>

					<div id="collapse<?= $attr['attribute']['attribute_ID'] ?>" class="accordion-collapse collapse <?= $ac2 ?>" aria-labelledby="heading<?= $attr['attribute']['attribute_ID'] ?>" data-bs-parent="#accordionExample">

						<div class="accordion-body">

							<ul class="deals-list size-list d-flex flex-wrap gap-2 mt-2">

								<?php

								foreach ($attr['values'] as $val) :

									isset($val['active']) ? $c1 = 'active' : $c1 = '';

								?>

									<li>

										<a href="javascript:;" class="filter-item <?= $c1 ?>" data-type="attribute" data-attr="<?= $attr['attribute']['attribute_ID'] ?>" data-value="<?= $val['value_ID'] ?>">
											<?= $val['value_title'] ?>
										</a>

									</li>

								<?php endforeach; ?>


							</ul>

						</div>

					</div>

				</div>

		<?php endforeach;

		endif; ?>

	</div>

</div>



<form id="filterform" class="d-none">

	<input type="hidden" name="filter[keywords]" class="keywords" value="<?= isset($filter['keywords']) ? $filter['keywords'] : '' ?>">

	<input type="hidden" name="filter[category]" class="category" value="<?= $activecat ?>">

	<input type="hidden" name="filter[brand]" value="">

	<input type="hidden" name="filter[price-from]" class="price-from" value="">

	<input type="hidden" name="filter[price-to]" class="price-to" value="">

	<input type="hidden" name="filter[rating]" class="filterrating" value="">

	<input type="hidden" name="filter[sort]" class="sort" value="default">

	<?php

	if (isset($filter['attributes'])) :

		if (!empty($filter['attributes'])) :

			foreach ($filter['attributes'] as $attr): ?>

				<input type="hidden" name="filter[attrtibutes][<?= $attr['attribute']['attribute_ID'] ?>]" id="attr_<?= $attr['attribute']['attribute_ID'] ?>" value="">

			<?php endforeach;

		else : ?>

			<input type="hidden" name="filter[attrtibutes][]" id="" value="">

		<?php endif;

	else : ?>

		<input type="hidden" name="filter[attrtibutes][]" id="" value="">

	<?php endif; ?>

	<input type="hidden" name="filter[lastactive]" class="lastactive" value="">

</form>

<style type="text/css">
	.range-slider {
		width: 100%;
		text-align: center;
		position: relative;
	}

	.range-slider .rangeValues {
		display: block;
	}

	input[type=range] {
		-webkit-appearance: none;
		border: 1px solid #274fff;
		width: 100%;
		position: absolute;
		left: 0;
		border-radius: 50px
	}

	input[type=range]::-webkit-slider-runnable-track {
		width: 100%;
		height: 5px;
		background: #fff;
		border: none;
		border-radius: 3px;
	}

	input[type=range]::-webkit-slider-thumb {
		-webkit-appearance: none;
		border: none;
		height: 16px;
		width: 16px;
		border-radius: 50%;
		background: #feb100;
		margin-top: -2%;
		cursor: pointer;
		position: relative;
		z-index: 1;
	}

	input[type=range]:focus {
		outline: none;
	}

	input[type=range]:focus::-webkit-slider-runnable-track {
		background: #fff;
	}

	input[type=range]::-moz-range-track {
		width: 100%;
		height: 5px;
		background: #fff;
		border: none;
		border-radius: 3px;
	}

	input[type=range]::-moz-range-thumb {
		border: none;
		height: 16px;
		width: 16px;
		border-radius: 50%;
		background: #feb100;
	}

	input[type=range]:-moz-focusring {
		outline: 1px solid white;
		outline-offset: 0px;
	}

	input[type=range]::-ms-track {
		width: 100%;
		height: 5px;
		transparent;
		border-color: transparent;
		border-width: 6px 0;
		color: transparent;
		z-index: -4;
	}

	input[type=range]::-ms-fill-lower {
		background: #fff;
		border-radius: 10px;
	}

	input[type=range]::-ms-fill-upper {
		background: #fff;
		border-radius: 10px;
	}

	input[type=range]::-ms-thumb {
		border: none;
		height: 16px;
		width: 16px;
		border-radius: 50%;
		background: #feb100;
	}

	input[type=range]:focus::-ms-fill-lower {
		background: #fff;
	}

	input[type=range]:focus::-ms-fill-upper {
		background: #fff;
	}
</style>