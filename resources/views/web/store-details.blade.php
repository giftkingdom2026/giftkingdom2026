@extends('web.layout')

@section('content')
    <?php $store = $data['user']['metadata']; ?>
    <div class="main-section">

        <div class="breadcrumb">

            <div class="container">

                <ul class="d-inline-flex align-items-center flex-wrap">

                    <li><a href="<?= asset('/') ?>"><?= App\Http\Controllers\Web\IndexController::trans_labels('Home') ?></a>
                    </li>

                    <li>></li>

                    <li><a
                            href="<?= asset('shop') ?>"><?= App\Http\Controllers\Web\IndexController::trans_labels('Store') ?></a>
                    </li>

                    <li>></li>
                    @if (isset($store))
                        <li><a href="javascript:;"><?= $store['store_name'] ?></a></li>
                    @endif

                </ul>

            </div>

        </div>

    </div>
    <div class="position-relative">
        <section class="main-section storedetail-section-one pt-3">
            <div class="container">
                <div class="row flex-column-reverse flex-lg-row">
                    <div class="col-lg-4 col-xl-3 mt-0 section-slider account-section section-slider-pro">
                        <div class="main-heading wow">
			<h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Best Selling')?></h2>
		</div>

		<?php

				foreach( $data['rand-products'] as $product ) : ?>


						<?php
$prod_price = $product['prod_price'] * session('currency_value');
$sale_price = $product['sale_price'] * session('currency_value'); ?>

<div class="product-card overflow-hidden mb-5">

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


				<?php endforeach;?>
                        <div class="store-wrap contact contact-section-one">
                            <h5 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Contact Vendor')?></h5>
                            <form class="js-form has-response" action="<?= asset('inquiry') ?>">
                                <input type="hidden" name="vendor_email" value="<?= $store['vendor_email'] ?>">
                                <input type="hidden" name="vendor_id" value="<?= $data['user']['id'] ?>">
                                  <div class="form-group mb-3">
                                    <input type="text" name="name" required class="form-control"
                                        placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Name')?>">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" name="subject" required class="form-control"
                                        placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Subject')?>">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" required name="email" class="form-control"
                                        placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Email Address')?>">
                                </div>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" required name="message" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Message')?>"></textarea>
                                </div>
                                <button class="btn w-100"><?=App\Http\Controllers\Web\IndexController::trans_labels('Send Message')?> <svg width="13" height="12"
                                        viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.500001 5.57692L10.8814 5.57692L6.4322 1.13462L6.99153 0.5L12.5 6L6.99153 11.5L6.4322 10.8654L10.8814 6.42308L0.500001 6.42308L0.500001 5.57692Z"
                                            fill="#6D7D36"></path>
                                    </svg>
                                </button>
                                <div class="response"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        <div class="storedetail-inner-one">
                            <div class="inner-banner">

                                <div class="container">

                                    <article class="py-5">

                                        <div class="row justify-content-between align-items-center">

                                            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-6">

                                                <h2 class="mb-3 wow fadeInUp"><?= $store['store_name'] ?></h2>
                                                <div class="d-flex flex-column gap-2">
                                                <?php
								if( isset( $store['vendor_address'] ) ): ?>

                                                <span><?= $store['vendor_address'] ?></span>

                                                <?php endif;?>

                                                <?php

								if( isset($store['vendor_phone']) ) : ?>

                                                <a
                                                    href="tel:<?= str_replace(['+', '-', ')', '('], '', $store['vendor_phone']) ?>"><?= $store['vendor_phone'] ?></a>

                                                <?php endif;?>
                                                <?php
								if( isset( $store['vendor_email'] ) ): ?>

                                                <a href="mailto:<?= $store['vendor_email'] ?>"><?= $store['vendor_email'] ?></a>
                                            </div>
                                                <?php endif;?>
                                            </div>

                                            <div class="col-sm-4 col-md-3">

                                                <figure class="overflow-hidden">

                                                    <img src="<?= asset($store['store_logo_image']) ?>" alt="*"
                                                        class="wow">

                                                </figure>

                                            </div>

                                        </div>

                                    </article>

                                </div>

                            </div>
                        </div>
                        <div class="gy-lg-5 section-slider account-section section-slider-pro">

		<div class="mb-3 ms-2 wow">
			<h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Store Products')?></h2>
		</div>
        <div class="row">

		<?php

foreach( $data['rand-products'] as $product ) : ?>

<div class="col-sm-6 mb-3 wrap col-xl-4 mt-0">

						@include('web.product.content',['product' => $product])


                    </div>
				<?php endforeach;?>
        </div>

                        </div>



                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

<style type="text/css">
    #storeshare .modal-body::before {
        background: #fff !important
    }

    .socialIcons.social-share {
        margin: 0 !important
    }

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
