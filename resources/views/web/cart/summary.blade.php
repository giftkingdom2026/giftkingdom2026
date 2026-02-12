<h6 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Summary')?></h6>

<?php

$count = 0;

$symbol = Session::get('symbol_right').''.Session::get('symbol_left');

$sub = $data->order_subtotal * session('currency_value'); 
if( $data->cart_coupon != '' ) {
$total = ($data->order_subtotal * session('currency_value')) - number_format($data->cart_discount,2) + number_format($data->cart_tax * session('currency_value'),2); 
}else {
$total = ($data->order_subtotal * session('currency_value')) + number_format($data->cart_tax * session('currency_value'),2); 
    # code...
}
$itemstotal = $data->cart_itemstotal * session('currency_value');

$productsdiscount = 0;

foreach($data['items'] as $item ) :

    $item['in_order'] != 0 ? $count++ : '';

$quantity = $item['product_quantity'];

$regular_price = $item['product']['prod_price'] * session('currency_value');
$sale_price = $item['product']['sale_price'] * session('currency_value');
$cond = $item['product']['sale_price'] != 0 && $item['product']['sale_price'] != null && $item['product']['sale_price'] != $item['product']['prod_price'];

$price = $cond ? $sale_price : $regular_price;

if ($cond) {
    $productsdiscount += ($regular_price - $sale_price) * $quantity;
}

endforeach;?>

<ul class="summary-items">

    <li class="d-flex justify-content-between align-items-center">
        <span><?=App\Http\Controllers\Web\IndexController::trans_labels('Items Total')?> (<?=$count?> items)</span> <strong class="text-uppercase"><?=$symbol?> <?= number_format($itemstotal,2)?></strong>
    </li>
    
    <?php

    if( $productsdiscount != 0 ) :  ?>

        <li class="d-flex justify-content-between align-items-center">
            <span><?=App\Http\Controllers\Web\IndexController::trans_labels('Products Discount')?> </span> <strong class="text-uppercase">-<?=$symbol?> <?=number_format(abs($productsdiscount),2)?></strong>
        </li>

        <li class="d-flex justify-content-between align-items-center">
            <span><?=App\Http\Controllers\Web\IndexController::trans_labels('Subtotal')?> </span> <strong class="text-uppercase"><?=$symbol?> <?=number_format($sub,2)?></strong>
        </li>

    <?php endif;?>

</ul>

<?php $couponclass = $data->cart_coupon != '' ? 'has-coupon' : '';?>

<div class="form-group position-relative my-4">
    <input type="text" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter Voucher Code')?>" class="form-control" id="voucher-code-input">
    <button class="position-absolute p-0 <?=$couponclass?>" id="applycoupon" type="button"><svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L7 7L1 13" stroke="white" stroke-width="1.6" stroke-linecap="round"></path></svg></button>
<div class="text-end mt-2">
    <a class="btn btn-sm p-2 small" data-bs-toggle="modal" data-bs-target="#view-vouchers-modal">
        <?=App\Http\Controllers\Web\IndexController::trans_labels('View Vouchers')?>
    </a>
</div>


</div>

<?php 

if( $data->cart_coupon != '' ) : ?>

    <div class="cart-summary-total d-flex justify-content-between align-items-center">
        <div>
            <small>Coupon (<?=$data->cart_coupon?>)</small>
            <a href="<?=asset('/cart/removecoupon')?>" title="Remove Coupon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" viewBox="0 0 512 512"><path fill="#6D7D36" d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
            </a>
        </div>

        <small><?=$symbol?> -<?= number_format($data->cart_discount,2) ?></small>
    </div>
    
<?php endif;?>

<div class="cart-summary-total d-flex justify-content-between align-items-center">
    <small><?=App\Http\Controllers\Web\IndexController::trans_labels('VAT')?></small>
    <small><?=$symbol?> <?= number_format($data->cart_tax * session('currency_value'),2) ?></small>
</div>

<div class="cart-summary-total d-flex justify-content-between align-items-center">
    <span><?=App\Http\Controllers\Web\IndexController::trans_labels('Total')?></span><strong class="text-uppercase"><?=$symbol?> <?= number_format($total,2) ?></strong>
</div>