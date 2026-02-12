<?php
$prod_price = $product['prod_price'] * session('currency_value');
$sale_price = $product['sale_price'] * session('currency_value'); ?>

<div class="product-card overflow-hidden">

	<figure class="d-flex justify-content-center align-items-center position-relative overflow-hidden">

		<?php isset($ajax) ? $class = '' : $class = 'wow';

		$img = is_array($product['prod_image']) ? $product['prod_image']['path'] : $product['prod_image'];

		$img = $img == null ? asset('images/media/2024/11/660x900&text=660x900.png') : asset($img); ?>

		<?php

		if (isset($product['discount']) && $product['discount'] != 0) : ?>

			<span class="badge position-absolute bg-danger start-0 ms-2"><?= $product['discount'] ?>% <?= App\Http\Controllers\Web\IndexController::trans_labels('off') ?></span>

		<?php endif; ?>

		<a href="<?= asset('product/' . $product['prod_slug']) ?>">

			<img src="<?= $img ?>" alt="*" class="<?= $class ?>">
		</a>
<div class="position-absolute bottom-0 left-0 right-0 w-100 shop-now px-3 py-2">
    @if($product['prod_type'] == 'variable')
        <a href="<?= asset('product/' . $product['prod_slug']) ?>" class="d-flex align-items-center gap-3 justify-content-between text-white">
            <?= App\Http\Controllers\Web\IndexController::trans_labels('View Options') ?>
        </a>
    @else
        <?php $addID = $product['ID']; ?>

        <?php if ($product['prod_quantity'] != 0): ?>
            <a href="javascript:;" class="add-to-cart d-flex align-items-center gap-3 justify-content-between text-white" data-product="<?= $addID ?>">
                <?= App\Http\Controllers\Web\IndexController::trans_labels('Add to Cart') ?> 
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 1V13M13 7H1" stroke="#F1F6D3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        <?php else: ?>
            <span class="text-white d-block text-center">
                <?= App\Http\Controllers\Web\IndexController::trans_labels('Out of Stock') ?>
            </span>
        <?php endif; ?>
    @endif
</div>

	</figure>

	<article class="text-center pt-3 wow fadeInUp">

		<?php

		$title = explode(' ', $product['prod_title']);

		$title = array_slice($title, 0, 7);

		$title = implode(' ', $title); ?>

		<h5 title="<?= $product['prod_title'] ?>"><?= $title ?></h5>
		<?php

		if ($product['prod_type'] == 'variable') :

			if ($sale_price != null && $sale_price != $prod_price) : ?>

				<i class="d-block">

					From <?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($sale_price, 2) ?>

					<del><?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?></del>

				</i>

			<?php else : ?>

				<i class="d-block">

					From <?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?>

				</i>

			<?php endif; ?>

			<?php else:

			if ($product['sale_price'] != null) : ?>

				<i class="d-block">

					<?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($sale_price, 2) ?>

					<del><?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?></del>

				</i>

			<?php else : ?>

				<i class="d-block"><?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?></i>


			<?php endif; ?>

		<?php endif; ?>

	</article>

</div>