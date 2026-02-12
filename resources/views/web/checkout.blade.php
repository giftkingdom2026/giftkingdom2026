@extends('web.layout')
@section('content')

@php

$meta = isset($data['user']['metadata']) ? $data['user']['metadata'] : [];

$addresses = isset($meta['address']) ? unserialize($meta['address']) : [];

$default = [];

$key = 0;

@endphp

<div class="modal fade checkout-section contact-section-one order-detail-section" id="addresses" tabindex="-1" aria-labelledby="addresses" aria-hidden="true">
    <div class="modal-xl modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22" />
                        <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22" />
                    </svg></button>

                @if(count($addresses) > 0)
                <div class="addressess-select d-flex flex-column gap-3 add_form_address addressWrap mt-5">

                    <?php

                    foreach ($addresses as $index => $addr) :

                        isset($addr['default']) ? $default = $addr : '';

                        isset($addr['default']) ? $key = $index : ''; ?>

                        @include('web.account.address-form',['data' => $addr, 'key' => $index ,'popup' => true])

                    <?php endforeach; ?>

                </div>
                @endif
            </div>
            <div class="modal-footer border-0 p-0">
                <div class="d-flex justify-content-between w-100 align-items-center gap-3 flex-wrap">
                    <a href="javascript:;" class="link add-address" data-bs-toggle="modal" data-bs-target="#addressModal">+ <?=App\Http\Controllers\Web\IndexController::trans_labels('Add Address')?></a>
                    @if(count($addresses) > 0)
                    <button type="button" class="btn" id="confirm-address" disabled><?=App\Http\Controllers\Web\IndexController::trans_labels('Confirm')?></button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade checkout-section contact-section-one" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22" />
                        <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22" />
                    </svg></button>
                <div class="col-md-12 mt-5">
                    <div class="mb-3 form-group">
                        <input type="text" id="pac-input" class="form-control" placeholder="Enter your address">
                    </div>
                    <div id="map" style="height: 300px; width: 100%;"></div>


                    <button id="showStep2Btn" class="btn mt-5" disabled><?=App\Http\Controllers\Web\IndexController::trans_labels('Confirm Location')?></button>


                </div>
            </div>
        </div>
    </div>
</div>




<section class="main-section contact-section-one order-detail-section checkout-section">
    <div class="breadcrumb mb-4">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ul class="d-inline-flex align-items-center gap-2">

                        <li><a href="<?= asset('/') ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

                        <li>&gt;</li>

                        <li><a href="{{url('/cart')}}"><?=App\Http\Controllers\Web\IndexController::trans_labels('Cart')?></a></li>

                        <li>&gt;</li>

                        <li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="wizard">
            <div class="wizard-inner position-relative text-center">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs custom-overlay position-relative row justify-content-between border-0" role="tablist">
                    <li role="presentation" class="col active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab"><?=App\Http\Controllers\Web\IndexController::trans_labels('Cart')?></span></a>
                    </li>
                    <li role="presentation" class="col active">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Summary')?></span></a>
                    </li>
                    <li role="presentation" class="col">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" aria-expanded="false"><span class="round-tab"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Placed')?></span></a>
                    </li>
                </ul>
            </div>
        </div>

        <form method="POST" id="checkout_form" action="<?= asset('place-order') ?>">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-xl-7">
                    <div class="main-heading">
                        <h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Checkout Details')?></h2>
                    </div>
                    <div class="checkout-forms ">
                        <div class="billing-form addressWrap careerFilter">
                            <div id="address-form-wrapper">
                                <div id="current-address" class="mb-3">
                                    @include('web.account.address-form',['data' => $default, 'key' => $key ,'checkout' => true])
                                </div>
                            </div>
                            <h5 class="mb-4"><?=App\Http\Controllers\Web\IndexController::trans_labels('Select the Date and Time for Delivery')?></h5>
                            <div class="time-slots pb-5" style="display:none;">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 mb-md-0">

                                            <input name="delivery-date" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Delivery Date')?>" value="<?= date('d M, Y') ?>" placeholder="" class="flatpickr delivery-date form-control" type="text">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="slots" id="validate-slots">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-body">

                                <?php

                                $total = $productsdiscount = 0;

                                $sub = $data['cart']->order_subtotal * session('currency_value');

                                $total = $data['cart']->order_total * session('currency_value');

                                $symbol = Session::get('symbol_right') . '' . Session::get('symbol_left');
                                foreach ($data['cart']->items as $item) :

$prodPrice = $item['product']['prod_price'] * session('currency_value');
$salePrice = $item['product']['sale_price'] * session('currency_value');

// Determine if a sale is active
$hasSale = $item['product']['sale_price'] != 0 && $item['product']['sale_price'] != null;

// Final price based on sale
$price = $hasSale ? $salePrice : $prodPrice;
$defprice = $hasSale ? $prodPrice : false;

// Total (for cart row)
$total = $price * $item['product_quantity'];

// Discount (for calculation)
$productsdiscount += $defprice ? ($prodPrice - $salePrice) * $item['product_quantity'] : 0;

                                    if ($item['in_order'] == 1) : ?>

                                        <div class="cart-item cart-item-new justify-content-between align-items-center" data-product_id="<?= $item['product_ID'] ?>" data-cart_item_id="<?= $item['id'] ?>" data-title="<?= $item['product']['prod_title'] ?>" data-image="<?= asset($item['product']['prod_image']) ?>" data-price="<?= $price ?>" data-qty="<?= $item['product_quantity'] ?>" data-meta='<?= json_encode($item['item_meta']) ?>'>
                                            <div class="d-flex align-items-center justify-content-between">

                                                <div class="cart-item-thumb d-flex gap-3 align-items-center">
                                                    <figure>
                                                        <img src="<?= asset($item['product']['prod_image']) ?>" class="w-100 wow">
                                                    </figure>


                                                    <div class="cart-item-meta">
                                                        <h5 class="mb-0"><a href="<?= asset('product/' . $item['product']['prod_slug']) ?>"><?= $item['product']['prod_title'] ?></a></h5>
                                                        <p class="mb-0">(x <?= $item['product_quantity'] ?>)</p>
                                                        <?php

                                                        if (!empty($item['item_meta'])) : $meta = '';

                                                            foreach ($item['item_meta'] as $key => $attr) :

                                                                if ($attr['attribute'] != null) :

                                                                    $meta .= $attr['attribute']['attribute_title'] . ': ' . $attr['value']['value_title'] . ', ';

                                                                else :

                                                                    if ($attr['value'] != ''):

                                                                        $meta .= '<br>Personalized Message: ' . $attr['value'];

                                                                    endif;

                                                                endif;

                                                            endforeach; ?>

                                                            <p class="text-capitalize mb-1"><?= rtrim($meta, ', ') ?></p>

                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                                <div class="cart-item-totals">

                                                <strong><?= $symbol ?> <?= number_format(($price * $item['product_quantity']), 2) ?></strong>

                                                <?php

                                                if ($defprice) : ?>

                                                    <del class="d-block"><small><?= $symbol ?> <?= number_format(($defprice * $item['product_quantity']),2 ) ?></small></del>

                                                <?php endif; ?>

                                            </div>
                                            </div>

                                            
                                        </div>
                                        <?php
                                        $addressesJson = null;

                                        if (isset($item['addresses']) && $item['addresses'] !== null) {
                                            $addressesJson = json_encode($item['addresses']); // always turns array into a string
                                            if ($addressesJson === false) {
                                                $addressesJson = 'null'; // fallback if json_encode fails
                                            }
                                            $addressesJson = htmlspecialchars($addressesJson, ENT_QUOTES, 'UTF-8');
                                        }
                                        ?>



                                        <input type="hidden" value="<?= $addressesJson ?>" name="cart_item_addresses[]">

                                <?php

                                    endif;

                                endforeach; ?>

                            </div>
                            <div class="wrap delivery-wrap my-4">

                                <h4><?=App\Http\Controllers\Web\IndexController::trans_labels('Same-day Delivery Options')?></h4>
                                <h6 class="mb-4 small"><?=App\Http\Controllers\Web\IndexController::trans_labels('Additional Charges Applicable')?></h6>

                                <div class="payment-methods delivery-options">

                                    <?php

                                    foreach ($data['timeslots'] as $key => $slot) : ?>

                                        <div class="form-check gap-4 mb-3">
                                            <input class="form-check-input delivery_option" required type="radio" name="delivery_option" value="<?= $key ?>" id="<?= $key ?>">
                                            <label class="form-check-label" for="<?= $key ?>">
                                                <h5><?= $slot['duration'] ?></h5>
                                                <span class="d-block"><?= $slot['title'] ?></span>
                                            </label>
                                        </div>

                                    <?php endforeach; ?>

                                </div>



                            </div>

                            <div class="row">

                                <div class="col-md-12 d-none">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Area')?> *</label>
                                        <input type="text" required name="address[area]" value="Area" class="form-control area_change" placeholder="Area for delivery">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Email Address')?> *</label>

                                        <input type="email" required name="address[email]" value="<?= isset(Auth::user()->email) ? Auth::user()->email : '' ?>" class="form-control" placeholder="example@gmail.com">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order notes')?></label>
                                        <textarea class="form-control" name="order-notes" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Notes about your order etc')?>."></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="shipping-form" style="display:none;">
                            <div class="row careerFilter">
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('First Name')?> *</label>

                                        <?php $firstname = isset($shipping['firstname']) ? $shipping['firstname'] : ''; ?>

                                        <input type="text" name="shipping[firstname]" value="<?= $firstname ?>" class="required form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Last Name')?> *</label>

                                        <?php $lastname = isset($shipping['lastname']) ? $shipping['lastname'] : ''; ?>

                                        <input type="text" name="shipping[lastname]" class="required form-control" value="<?= $lastname ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Company Name')?> (optional)</label>

                                        <?php $companyname = isset($shipping['companyname']) ? $shipping['companyname'] : ''; ?>

                                        <input type="text" name="shipping[companyname]" value="<?= $companyname ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Company ID/EUID Number')?> (optional)</label>

                                        <?php $companynumber = isset($shipping['companynumber']) ? $shipping['companynumber'] : ''; ?>

                                        <input type="text" name="shipping[companynumber]" value="<?= $companynumber ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('VAT/TAX Number')?> (optional)</label>

                                        <?php $vatnumber = isset($shipping['vatnumber']) ? $shipping['vatnumber'] : ''; ?>

                                        <input type="text" name="shipping[vatnumber]" value="<?= $vatnumber ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group ct-slct mb-4">
                                        <label class="mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Country / Region')?> *</label>
                                        <div class="child_option position-relative">
                                            <button class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" disabled type="button">UAE<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L7 7L13 1" stroke="black" />
                                                </svg></button>
                                            <div class="dropdown-menu2 dropdown-menu-right">
                                                <ul class="careerFilterInr">
                                                    <li><a href="javascript:;" class="dropdown_select" value="">UAE</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input type="hidden" name="shipping[country]" class="inputhide" value="United Arab Emirates">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Street Address')?> *</label>

                                        <?php $address = isset($shipping['address']) ? $shipping['address'] : ''; ?>

                                        <input type="text" name="shipping[address]" value="<?= $address ?>" class="required form-control" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('House number and street name')?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">

                                        <?php $addresstwo = isset($shipping['addresstwo']) ? $shipping['addresstwo'] : ''; ?>

                                        <input type="text" name="shipping[addresstwo]" value="<?= $addresstwo ?>" class="form-control" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Apartment, suite, unit, etc. (optional)')?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group ct-slct mb-4">
                                        <label class="mb-1 ms-3">Emirates *</label>
                                        <?php $emirate = isset($shipping['emirate']) ? $shipping['emirate'] : ''; ?>
                                        <div class="child_option position-relative">
                                            <button class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" type="button"><?= $emirate != '' ? $emirate : 'Select Emirate' ?><svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L7 7L13 1" stroke="black" />
                                                </svg></button>
                                            <div class="dropdown-menu2 dropdown-menu-right">
                                                <ul class="careerFilterInr">
                                                    <li><a href="javascript:;" class="dropdown_select" value="Abu Dhabi">Abu Dhabi</a></li>
                                                    <li><a href="javascript:;" class="dropdown_select" value="Dubai">Dubai</a></li>
                                                    <li><a href="javascript:;" class="dropdown_select" value="Sharjah">Sharjah</a></li>
                                                    <li><a href="javascript:;" class="dropdown_select" value="Ajman">Ajman</a></li>
                                                    <li><a href="javascript:;" class="dropdown_select" value="Umm Al Quwain">Umm Al Quwain</a></li>
                                                    <li><a href="javascript:;" class="dropdown_select" value="Ras Al Khaimah">Ras Al Khaimah</a></li>
                                                    <li><a href="javascript:;" class="dropdown_select" value="Fujairah">Fujairah</a></li>
                                                </ul>
                                            </div>
                                        </div>


                                        <input type="hidden" name="shipping[emirate]" required value="<?= $emirate ?>" class="required inputhide">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Phone')?> *</label>

                                        <?php $phone = isset($shipping['phone']) ? $shipping['phone'] : ''; ?>

                                        <input type="phone" name="shipping[phone]" value="<?= $phone ?>" class="required form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label mb-1 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Email Address')?> *</label>

                                        <?php $email = isset($shipping['email']) ? $shipping['email'] : ''; ?>

                                        <input type="text" name="shipping[email]" class="required form-control" value="<?= $email ?>" placeholder="example@gmail.com">
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <div class="cart-summary order-summary-wrap mb-2">
                        <h4 class="mb-4">Your Order</h4>
                        <div class="order-summary">
                            <div class="d-flex justify-content-between mb-4">
                                <span>Product</span>
                                <span>Subtotal</span>
                            </div>
                            <div class="cart-body">

                                <?php

                                $total = $productsdiscount = 0;

                                $sub = $data['cart']->order_subtotal * session('currency_value');

                                $total = $data['cart']->order_total * session('currency_value');

                                $symbol = Session::get('symbol_right') . '' . Session::get('symbol_left');
                                foreach ($data['cart']->items as $item) :

$prodPrice = $item['product']['prod_price'] * session('currency_value');
$salePrice = $item['product']['sale_price'] * session('currency_value');

$hasSale = $item['product']['sale_price'] != 0 && $item['product']['sale_price'] != null;

$price = $hasSale ? $salePrice : $prodPrice;
$defprice = $hasSale ? $prodPrice : false;

$total = $price * $item['product_quantity'];

$productsdiscount += $defprice ? ($prodPrice - $salePrice) * $item['product_quantity'] : 0;

                                    if ($item['in_order'] == 1) : ?>

                                        <div class="cart-item d-flex justify-content-between align-items-center" data-product_id="<?= $item['product_ID'] ?>" data-cart_item_id="<?= $item['id'] ?>" data-title="<?= $item['product']['prod_title'] ?>" data-image="<?= asset($item['product']['prod_image']) ?>" data-price="<?= $price ?>" data-qty="<?= $item['product_quantity'] ?>" data-meta='<?= json_encode($item['item_meta']) ?>'>
                                            <div class="cart-item-thumb d-flex gap-3 align-items-center">
                                                <figure>
                                                    <img src="<?= asset($item['product']['prod_image']) ?>" class="w-100 wow">
                                                </figure>


                                                <div class="cart-item-meta">
                                                    <h5 class="mb-0"><a href="<?= asset('product/' . $item['product']['prod_slug']) ?>"><?= $item['product']['prod_title'] ?></a></h5>
                                                    <p class="mb-0">(x <?= $item['product_quantity'] ?>)</p>
                                                    <?php

                                                    if (!empty($item['item_meta'])) : $meta = '';

                                                        foreach ($item['item_meta'] as $key => $attr) :

                                                            if ($attr['attribute'] != null) :

                                                                $meta .= $attr['attribute']['attribute_title'] . ': ' . $attr['value']['value_title'] . ', ';

                                                            else :

                                                                if ($attr['value'] != ''):

                                                                    $meta .= '<br>Personalized Message: ' . $attr['value'];

                                                                endif;

                                                            endif;

                                                        endforeach; ?>

                                                        <p class="text-capitalize mb-1"><?= rtrim($meta, ', ') ?></p>

                                                    <?php endif; ?>

                                                </div>
                                            </div>
<div class="cart-item-totals">
    <strong><?= $symbol ?> <?= number_format($total, 2) ?></strong>

    <?php if ($defprice): ?>
        <del class="d-block">
            <small><?= $symbol ?> <?= number_format($defprice * $item['product_quantity'], 2) ?></small>
        </del>
    <?php endif; ?>
</div>

                                        </div>
                                        <?php if (!empty($item['addresses'])): ?>
                                            <?php
                                            $addressesJson = htmlspecialchars(json_encode($item['addresses']), ENT_QUOTES, 'UTF-8');
                                            ?>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-secondary mb-3 view-addresses-btn"
                                                data-addresses="<?= $addressesJson ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewAddressesModal">
                                                View Delivery Addresses
                                            </button>
                                            <input type="hidden" value="<?= $addressesJson ?>" name="cart_item_addresses[]">
                                        <?php endif; ?>
                                <?php

                                    endif;

                                endforeach; ?>

                            </div>
                            <div class="checkout-summary">

                                @include('web.checkout-summary')

                            </div>

                        </div>

                        <?php

                        if ($data['cart']->order_total == 0) :  ?>


                            <div class="form-check d-none justify-content-between align-items-center gap-4 mb-3">
                                <div class="d-flex align-items-center gap-4">
                                    <input class="form-check-input" required type="radio" name="payment_method" value="Wallet" id="wallet">
                                    <label class="form-check-label" for="wallet">
                                        <h5>Wallet</h5>
                                        <span class="d-block">Available Credit (<?= $credit ?>)</span>
                                    </label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="#a0a2a7" viewBox="0 0 512 512">
                                    <path d="M512 80c0 18-14.3 34.6-38.4 48c-29.1 16.1-72.5 27.5-122.3 30.9c-3.7-1.8-7.4-3.5-11.3-5C300.6 137.4 248.2 128 192 128c-8.3 0-16.4 .2-24.5 .6l-1.1-.6C142.3 114.6 128 98 128 80c0-44.2 86-80 192-80S512 35.8 512 80zM160.7 161.1c10.2-.7 20.7-1.1 31.3-1.1c62.2 0 117.4 12.3 152.5 31.4C369.3 204.9 384 221.7 384 240c0 4-.7 7.9-2.1 11.7c-4.6 13.2-17 25.3-35 35.5c0 0 0 0 0 0c-.1 .1-.3 .1-.4 .2c0 0 0 0 0 0s0 0 0 0c-.3 .2-.6 .3-.9 .5c-35 19.4-90.8 32-153.6 32c-59.6 0-112.9-11.3-148.2-29.1c-1.9-.9-3.7-1.9-5.5-2.9C14.3 274.6 0 258 0 240c0-34.8 53.4-64.5 128-75.4c10.5-1.5 21.4-2.7 32.7-3.5zM416 240c0-21.9-10.6-39.9-24.1-53.4c28.3-4.4 54.2-11.4 76.2-20.5c16.3-6.8 31.5-15.2 43.9-25.5l0 35.4c0 19.3-16.5 37.1-43.8 50.9c-14.6 7.4-32.4 13.7-52.4 18.5c.1-1.8 .2-3.5 .2-5.3zm-32 96c0 18-14.3 34.6-38.4 48c-1.8 1-3.6 1.9-5.5 2.9C304.9 404.7 251.6 416 192 416c-62.8 0-118.6-12.6-153.6-32C14.3 370.6 0 354 0 336l0-35.4c12.5 10.3 27.6 18.7 43.9 25.5C83.4 342.6 135.8 352 192 352s108.6-9.4 148.1-25.9c7.8-3.2 15.3-6.9 22.4-10.9c6.1-3.4 11.8-7.2 17.2-11.2c1.5-1.1 2.9-2.3 4.3-3.4l0 3.4 0 5.7 0 26.3zm32 0l0-32 0-25.9c19-4.2 36.5-9.5 52.1-16c16.3-6.8 31.5-15.2 43.9-25.5l0 35.4c0 10.5-5 21-14.9 30.9c-16.3 16.3-45 29.7-81.3 38.4c.1-1.7 .2-3.5 .2-5.3zM192 448c56.2 0 108.6-9.4 148.1-25.9c16.3-6.8 31.5-15.2 43.9-25.5l0 35.4c0 44.2-86 80-192 80S0 476.2 0 432l0-35.4c12.5 10.3 27.6 18.7 43.9 25.5C83.4 438.6 135.8 448 192 448z" />
                                </svg>
                            </div>

                        <?php else : ?>

                            <h4 class="my-4"><?=App\Http\Controllers\Web\IndexController::trans_labels('Payment Methods')?></h4>

                            <div class="payment-methods">

                                <div class="form-check justify-content-between align-items-center gap-4 mb-3">
                                    <div class="d-flex align-items-center gap-4">
                                        <input class="form-check-input" required type="radio" checked name="payment_method" value="Cash on Delivery" id="cash">
                                        <label class="form-check-label" for="cash">
                                            <h5>Cash on delivery</h5>
                                            <span class="d-block">Pay with cash upon delivery</span>
                                        </label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="#a0a2a7" viewBox="0 0 512 512">
                                        <path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L80 128c-8.8 0-16-7.2-16-16s7.2-16 16-16l368 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L64 32zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                </div>

                                <div class="form-check justify-content-between align-items-center gap-4 mb-3">
                                    <div class="d-flex align-items-center gap-4">
                                        <input class="form-check-input" required type="radio" name="payment_method" value="Apple Pay" id="apple_pay">
                                        <label class="form-check-label" for="apple_pay">
                                            <h5>Apple Pay</h5>
                                            <span class="d-block">Pay with online account</span>
                                        </label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="#a0a2a7" viewBox="0 0 640 512">
                                        <path d="M116.9 158.5c-7.5 8.9-19.5 15.9-31.5 14.9-1.5-12 4.4-24.8 11.3-32.6 7.5-9.1 20.6-15.6 31.3-16.1 1.2 12.4-3.7 24.7-11.1 33.8m10.9 17.2c-17.4-1-32.3 9.9-40.5 9.9-8.4 0-21-9.4-34.8-9.1-17.9 .3-34.5 10.4-43.6 26.5-18.8 32.3-4.9 80 13.3 106.3 8.9 13 19.5 27.3 33.5 26.8 13.3-.5 18.5-8.6 34.5-8.6 16.1 0 20.8 8.6 34.8 8.4 14.5-.3 23.6-13 32.5-26 10.1-14.8 14.3-29.1 14.5-29.9-.3-.3-28-10.9-28.3-42.9-.3-26.8 21.9-39.5 22.9-40.3-12.5-18.6-32-20.6-38.8-21.1m100.4-36.2v194.9h30.3v-66.6h41.9c38.3 0 65.1-26.3 65.1-64.3s-26.4-64-64.1-64h-73.2zm30.3 25.5h34.9c26.3 0 41.3 14 41.3 38.6s-15 38.8-41.4 38.8h-34.8V165zm162.2 170.9c19 0 36.6-9.6 44.6-24.9h.6v23.4h28v-97c0-28.1-22.5-46.3-57.1-46.3-32.1 0-55.9 18.4-56.8 43.6h27.3c2.3-12 13.4-19.9 28.6-19.9 18.5 0 28.9 8.6 28.9 24.5v10.8l-37.8 2.3c-35.1 2.1-54.1 16.5-54.1 41.5 .1 25.2 19.7 42 47.8 42zm8.2-23.1c-16.1 0-26.4-7.8-26.4-19.6 0-12.3 9.9-19.4 28.8-20.5l33.6-2.1v11c0 18.2-15.5 31.2-36 31.2zm102.5 74.6c29.5 0 43.4-11.3 55.5-45.4L640 193h-30.8l-35.6 115.1h-.6L537.4 193h-31.6L557 334.9l-2.8 8.6c-4.6 14.6-12.1 20.3-25.5 20.3-2.4 0-7-.3-8.9-.5v23.4c1.8 .4 9.3 .7 11.6 .7z" />
                                    </svg>
                                </div>

                                <div class="form-check justify-content-between align-items-center gap-4 mb-3">
                                    <div class="d-flex align-items-center gap-4">
                                        <input class="form-check-input" required type="radio" name="payment_method" value="Google Pay" id="google_pay">
                                        <label class="form-check-label" for="google_pay">
                                            <h5>Google Pay</h5>
                                            <span class="d-block">Pay with online account</span>
                                        </label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="30" fill="#a0a2a7">
                                        <path d="M105.7 215v41.3h57.1a49.7 49.7 0 0 1 -21.1 32.6c-9.5 6.6-21.7 10.3-36 10.3-27.6 0-50.9-18.9-59.3-44.2a65.6 65.6 0 0 1 0-41l0 0c8.4-25.5 31.7-44.4 59.3-44.4a56.4 56.4 0 0 1 40.5 16.1L176.5 155a101.2 101.2 0 0 0 -70.8-27.8 105.6 105.6 0 0 0 -94.4 59.1 107.6 107.6 0 0 0 0 96.2v.2a105.4 105.4 0 0 0 94.4 59c28.5 0 52.6-9.5 70-25.9 20-18.6 31.4-46.2 31.4-78.9A133.8 133.8 0 0 0 205.4 215zm389.4-4c-10.1-9.4-23.9-14.1-41.4-14.1-22.5 0-39.3 8.3-50.5 24.9l20.9 13.3q11.5-17 31.3-17a34.1 34.1 0 0 1 22.8 8.8A28.1 28.1 0 0 1 487.8 248v5.5c-9.1-5.1-20.6-7.8-34.6-7.8-16.4 0-29.7 3.9-39.5 11.8s-14.8 18.3-14.8 31.6a39.7 39.7 0 0 0 13.9 31.3c9.3 8.3 21 12.5 34.8 12.5 16.3 0 29.2-7.3 39-21.9h1v17.7h22.6V250C510.3 233.5 505.3 220.3 495.1 211zM475.9 300.3a37.3 37.3 0 0 1 -26.6 11.2A28.6 28.6 0 0 1 431 305.2a19.4 19.4 0 0 1 -7.8-15.6c0-7 3.2-12.8 9.5-17.4s14.5-7 24.1-7C470 265 480.3 268 487.6 273.9 487.6 284.1 483.7 292.9 475.9 300.3zm-93.7-142A55.7 55.7 0 0 0 341.7 142H279.1V328.7H302.7V253.1h39c16 0 29.5-5.4 40.5-15.9 .9-.9 1.8-1.8 2.7-2.7A54.5 54.5 0 0 0 382.3 158.3zm-16.6 62.2a30.7 30.7 0 0 1 -23.3 9.7H302.7V165h39.6a32 32 0 0 1 22.6 9.2A33.2 33.2 0 0 1 365.7 220.5zM614.3 201 577.8 292.7h-.5L539.9 201H514.2L566 320.6l-29.4 64.3H561L640 201z" />
                                    </svg>
                                </div>

                                <div class="form-check justify-content-between align-items-center gap-4 mb-3">
                                    <div class="d-flex align-items-center gap-4">
                                        <input class="form-check-input" required type="radio" name="payment_method" value="Stripe" id="stripe">
                                        <label class="form-check-label" for="stripe">
                                            <h5>Stripe</h5>
                                            <span class="d-block">Pay with credit card</span>
                                        </label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="#a0a2a7" viewBox="0 0 640 512">
                                        <path d="M165 144.7l-43.3 9.2-.2 142.4c0 26.3 19.8 43.3 46.1 43.3 14.6 0 25.3-2.7 31.2-5.9v-33.8c-5.7 2.3-33.7 10.5-33.7-15.7V221h33.7v-37.8h-33.7zm89.1 51.6l-2.7-13.1H213v153.2h44.3V233.3c10.5-13.8 28.2-11.1 33.9-9.3v-40.8c-6-2.1-26.7-6-37.1 13.1zm92.3-72.3l-44.6 9.5v36.2l44.6-9.5zM44.9 228.3c0-6.9 5.8-9.6 15.1-9.7 13.5 0 30.7 4.1 44.2 11.4v-41.8c-14.7-5.8-29.4-8.1-44.1-8.1-36 0-60 18.8-60 50.2 0 49.2 67.5 41.2 67.5 62.4 0 8.2-7.1 10.9-17 10.9-14.7 0-33.7-6.1-48.6-14.2v40c16.5 7.1 33.2 10.1 48.5 10.1 36.9 0 62.3-15.8 62.3-47.8 0-52.9-67.9-43.4-67.9-63.4zM640 261.6c0-45.5-22-81.4-64.2-81.4s-67.9 35.9-67.9 81.1c0 53.5 30.3 78.2 73.5 78.2 21.2 0 37.1-4.8 49.2-11.5v-33.4c-12.1 6.1-26 9.8-43.6 9.8-17.3 0-32.5-6.1-34.5-26.9h86.9c.2-2.3 .6-11.6 .6-15.9zm-87.9-16.8c0-20 12.3-28.4 23.4-28.4 10.9 0 22.5 8.4 22.5 28.4zm-112.9-64.6c-17.4 0-28.6 8.2-34.8 13.9l-2.3-11H363v204.8l44.4-9.4 .1-50.2c6.4 4.7 15.9 11.2 31.4 11.2 31.8 0 60.8-23.2 60.8-79.6 .1-51.6-29.3-79.7-60.5-79.7zm-10.6 122.5c-10.4 0-16.6-3.8-20.9-8.4l-.3-66c4.6-5.1 11-8.8 21.2-8.8 16.2 0 27.4 18.2 27.4 41.4 .1 23.9-10.9 41.8-27.4 41.8zm-126.7 33.7h44.6V183.2h-44.6z" />
                                    </svg>
                                </div>

                            </div>

                        <?php endif; ?>

                        <p class="mt-4 mb-0 my-md-4">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="<?= asset('privacy-policy') ?>">privacy policy.</a></p>
                    </div>
                    <button type="submit" class="btn w-100 mt-4 btn2" id="place_order"><?=App\Http\Controllers\Web\IndexController::trans_labels('Place Order')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#fff"></path>
                        </svg></button>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')

<script src="<?= asset('assets/js/map.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjacv_lH_wEwBBWJmewcMXhwTmK4tg2y8&callback=initAutocomplete&libraries=places&v=weekly">
</script>
<script type="text/javascript">
    setTimeout(function() {

        jQuery('.delivery_option').first().trigger('click')

    }, 1000)
</script>
@endpush

@endsection