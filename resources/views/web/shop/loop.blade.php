<div class="col-md-12">
	<p class="m-0"><?= App\Http\Controllers\Web\IndexController::trans_labels('Showing') ?> <strong><?=count($result['data'])?></strong> <?= App\Http\Controllers\Web\IndexController::trans_labels('of') ?> <strong><?=$result['total']?></strong> <?= App\Http\Controllers\Web\IndexController::trans_labels('Products') ?>!</p>
</div>

<?php

if( empty( $result['data'] ) ) : ?>

	<div class="main-heading text-center mt-5">

		<h3>No Products Found Related to Query!</h3>

	</div>

<?php else :

	foreach($result['data'] as $product ) : ?>

		<div class="col-sm-6 mt-0 mb-3 wrap col-xl-4">

			@include('web.product.content',['product' => $product , 'ajax' => true])

		</div>

	<?php endforeach; ?>

	<?php

	if( $result['total'] > $result['per_page'] ) : ?>

		<div class="col-md-12">

			<div class="new_links">

				<div class="pagination d-flex justify-content-center align-items-center gap-4 mt-5">


					<ul class="d-flex justify-content-center align-items-center gap-4">

						<?php
						foreach($result['links'] as $link) : 

							$url = $link['url'] ? $link['url'] : 'javascript:;';

							$url = str_replace('filter', '', $url);

							$class = $link['active'] ? 'active' : '';

							$title = $link['label'];

							str_contains($link['label'], 'Previous') ? 

							$title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5.57692L1.61864 5.57692L6.0678 1.13462L5.50847 0.5L2.40413e-07 6L5.50847 11.5L6.0678 10.8654L1.61864 6.42308L12 6.42308L12 5.57692Z" fill="#6D7D36"/></svg>' : '';

							str_contains($link['label'], 'Next') ? 

							$title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.31755e-07 5.57692L10.3814 5.57692L5.9322 1.13462L6.49153 0.5L12 6L6.49153 11.5L5.9322 10.8654L10.3814 6.42308L6.94768e-07 6.42308L7.31755e-07 5.57692Z" fill="#6D7D36"/></svg>' : '';

							?>

							<li>
								<a href="<?=$url?>" class="<?=$class?> page-link-products"><?=$title?></a>

							</li>

						<?php endforeach;?>

					</ul>

				</div>

			</div>

		</div>

	<?php endif;?>

<?php endif;?>	
