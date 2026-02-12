<?php

$total = $productsdiscount = 0;

$sub = $data['cart']->order_subtotal * session('currency_value'); 

$total = $data['cart']->order_total * session('currency_value');
$itemstotal = $data['cart']->cart_itemstotal * session('currency_value');
$symbol = Session::get('symbol_right').''.Session::get('symbol_left');
if( $data['cart']->cart_coupon != '' ) {
$total = ($data['cart']->order_subtotal * session('currency_value')) - number_format($data['cart']->cart_discount,2) + number_format($data['cart']->cart_tax * session('currency_value'),2); 
}else {
$total = ($data['cart']->order_subtotal * session('currency_value')) + number_format($data['cart']->cart_tax * session('currency_value'),2); 
    # code...
}
foreach ($data['cart']->items as $item) :
    $hasSale = $item['product']['sale_price'] != 0 && $item['product']['sale_price'] != null;
    $prodPrice  = $item['product']['prod_price'] * session('currency_value');
    $salePrice  = $item['product']['sale_price'] * session('currency_value');
    $unitPrice  = $hasSale ? $salePrice : $prodPrice;
    $price      = $unitPrice * $item['product_quantity'];
    $defprice   = $hasSale ? $prodPrice * $item['product_quantity'] : false;
    $productsdiscount += $defprice ? ($defprice - $price) : 0;

endforeach;

?>


<div class="d-none">

    <input type="hidden" name="order-subtotal" value="<?=$sub?>">
    
    <input type="hidden" name="vat" value="<?=number_format($data['cart']->cart_tax * session('currency_value'),2)?>">
    <?php

    if( $data['cart']->cart_coupon != '' ) : ?>

        <input type="hidden" name="discount" value="<?=$data['cart']->cart_discount?>">
        <input type="hidden" name="coupon" value="<?=$data['cart']->cart_coupon?>">

    <?php endif;?>

    <input type="hidden" name="shipping_method" value="Default">

    <?php 

    if( !isset($data['shipping']) ) :

        $shippingval = 'Free Shipping';

        $total = ($total);

        $shipcost = 0;

    elseif( isset($data['shipping']) && $data['shipping'] == 0 ) :

        $shippingval = 'Free Shipping';

        $total = ($total);

        $shipcost = 0;

    else :

        $shipprice = $data['shipping'];

        $shippingval = $symbol.' '.(number_format($shipprice  * session('currency_value'),2));

        $total = ($total + $shipprice  * session('currency_value'));
        $shipcost = $shipprice * session('currency_value');

    endif; 


    ?>

    <input type="hidden" name="shipping_cost" value="<?=number_format($shipcost, 2)?>">

</div>

<ul class="cart-totals">
    <li class="d-flex align-items-center justify-content-between mb-3">
        <span>Items Total</span><strong class="fw-normal"><?=$symbol?> <?=number_format($itemstotal,2)?></strong>
    </li>

    <?php 

    if( $productsdiscount != 0 ) : ?>

        <li class="d-flex align-items-center justify-content-between mb-3">
            <span>Products Discount</span><b class="fw-normal">-<?=$symbol?> <?=number_format(abs($productsdiscount),2)?></b>
        </li>

    <?php endif;?>

</ul>

<div class="d-flex justify-content-between align-items-center cart-total">
    <span>Subtotal</span>
    <strong class="fw-normal"><?=$symbol?> <?=number_format($sub,2)?></strong>
</div>

<?php

if( $data['cart']->cart_coupon != '' ) : ?>

    <div class="d-flex justify-content-between align-items-center cart-total">
        <span>Coupon (<?=$data['cart']->cart_coupon?>)</span>
        <strong class="fw-normal">-<?=$symbol?> <?=number_format($data['cart']->cart_discount,2)?></strong>
    </div>

<?php endif;?>

<div class="d-flex justify-content-between align-items-center cart-total">
    <span>Shipping</span>
    <strong class="fw-normal"><?=$shippingval?></strong>
</div>

<div class="d-flex justify-content-between align-items-center cart-total">
    <span>VAT</span>
    <strong class="fw-normal"><?=$symbol?> <?=number_format($data['cart']->cart_tax * session('currency_value'),2)?></strong>
</div>

@php
    // dd($total, $credit);
@endphp

@if($data['cart']->use_credit == 1 && $data['cart']->credit_points != 0)

    @php
        if($total != 0 && $data['cart']->order_total !=0) {
            $creditPoints = $data['cart']->credit_points * session('currency_value');
            $total -= $creditPoints;
        }
    @endphp

    <input type="hidden" name="credit_amount" value="{{ number_format($data['cart']->credit_points, 2) }}">

    <div class="d-flex justify-content-between align-items-center cart-total">
        <span>Credit Points</span>
        <strong class="fw-normal">
          {{ $symbol }}  -{{ number_format($data['cart']->credit_points * session('currency_value'), 2) }}
        </strong>
    </div>

@endif
<input type="hidden" name="order-total" value="<?=$total?>">

<div class="d-flex justify-content-between align-items-center cart-total">
    <span>Total</span>
    <strong class="fw-normal"><?=$symbol?> <?=number_format($total,2)?></strong>
</div>

<?php

if( $credit != 0 && $data['cart']->use_credit != 1 ) : ?>

    <div class="d-flex justify-content-between align-items-center cart-total">
        <span><?=App\Http\Controllers\Web\IndexController::trans_labels('Available Wallet Balance')?> (<?=$symbol?> <?=number_format($credit  * session('currency_value'),2)?>)</span>
        <strong class="fw-normal"><a href="javascript:;" class="btn" id="store_credit"><?=App\Http\Controllers\Web\IndexController::trans_labels('Use Wallet Balance')?></a></strong>
    </div>


<?php endif; ?>

