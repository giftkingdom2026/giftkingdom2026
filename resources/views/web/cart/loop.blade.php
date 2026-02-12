<?php

$symbol = Session::get('symbol_right').''.Session::get('symbol_left');

foreach( $data['items'] as $item ) : ?>
<div class="cart-item " data-item-id="<?= $item['id'] ?>">
    <div class="cart-item-select">
        <div class="form-check d-block ps-0 m-0 gap-4">
            <?php $item['in_order'] == 1 ? ($attr = 'checked') : ($attr = ''); ?>
            <input class="form-check-input d-none cart-select" name="order[]" <?= $attr ?> type="checkbox"
                id="<?= $item['id'] ?>" value="<?= $item['id'] ?>">
            <ul class="d-flex justify-content-between cart-selectInnr flex-wrap">
                <li class="cart-item-thumb">
                    <div class="d-flex">
                        <figure>
                            <img src="<?= asset($item['product']['prod_image']) ?>" class="w-100 wow">
                        </figure>

                        <div class="d-flex flex-column">

                            <div class="cart-item-meta">

                                <h5 class="text-capitalize mb-2">

                                    <a
                                        href="<?= asset('product/' . $item['product']['prod_slug']) ?>"><?= $item['product']['prod_title'] ?></a>
                                </h5>

                                <?php

                                    $serial = '';

                                    if( !empty($item['item_meta']) ) : $meta = ''; 

                                        $serial = $item['serial_meta'];

                                        foreach($item['item_meta'] as $key => $attr ) : 

                                            if( $attr['attribute'] != null ) :

                                                $meta.=$attr['attribute']['attribute_title'].':'.' <strong> '.$attr['value']['value_title'].'</strong> ';

                                            else :

                                                if( $attr['value'] != '' ):

                                                    $meta.='<br>Personalized Message: '.' <strong>'.$attr['value'].'</strong>';

                                                endif;

                                            endif;

                                        endforeach;

                                        ?>

                                <p class="text-capitalize mb-1"><?= rtrim($meta, ', ') ?></p>

                                <?php endif;?>

                                <?php 

                                    if( $item['product']['sale_price'] != 0 && $item['product']['sale_price'] != null ) :

                                        $sale = $item['product']['sale_price'] * session('currency_value'); 
                                        
                                        $price = $item['product']['prod_price'] * session('currency_value');  ?>

                                <span class="d-block text-uppercase price"><b class="fw-normal"><?= $symbol ?>
                                        <?= number_format($sale, 2) ?></b> <del><small><?= $symbol ?>
                                            <?= number_format($price, 2) ?></small></del></span>

                                <?php else :

                                        $price = $item['product']['prod_price'] * session('currency_value');  ?>

                                <span class="d-block text-uppercase price"><b class="fw-normal"><?= $symbol ?>
                                        <?= number_format($price, 2) ?></b></span>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>
                </li>
                <li class="cart-item-totals">

                    <!-- <b class="d-block mb-1 fw-normal"><?= $symbol ?> <?= number_format($item['product']['prod_price']) ?></b> -->

                    <h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Unit Price')?></h5>

                    <span><?=App\Http\Controllers\Web\IndexController::trans_labels('Total')?><strong class="d-block fw-normal mb-3 text-uppercase"><?= $symbol ?>
                           <?= number_format(
    (
        ($item['product']['sale_price'] != 0 && $item['product']['sale_price'] != null)
        ? $item['product']['sale_price']
        : $item['product']['prod_price']
    ) * session('currency_value') * $item['product_quantity'], 
    2
) ?>
</strong></span>
                    <div class="d-flex gap-3 cart-item-actions">
                        <?php
                        $values = [];
                        
                        if (!empty($item['item_meta'])) {
                            foreach ($item['item_meta'] as $attr) {
                                if (!empty($attr['attribute']) && !empty($attr['value'])) {
                                    $slug = $attr['attribute']['attribute_slug']; // use slug as key
                                    $value_id = $attr['value']['value_ID'] ?? null;
                                    $values[$slug] = $value_id;
                                } elseif (!empty($attr['value'])) {
                                    // For custom input / personal message fields without an attribute
                                    $values['personal-message'] = $attr['value'];
                                }
                            }
                        }
                        
                        // Wrap as expected
                        $attributes = ['values' => $values];
                        
                        // JSON encode safely for HTML output
                        $attributes_json = htmlspecialchars(json_encode($attributes), ENT_QUOTES, 'UTF-8');
                        ?>

                        <?php $c = $item['product']['wishlist'] ? 'exists' : ''; ?>
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#delete-item"
                            variation-id="<?= $item['variable_ID'] ?>" product-id="<?= $item['product_ID'] ?>"
                            delete-url="<?= asset('cart/delete/' . $item['id']) ?>" class="delete-cart"
                            whishlist="<?= $c ?>" data-attributes="<?= $attributes_json ?>">
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2.25 13.75C1.8375 13.75 1.4845 13.6033 1.191 13.3097C0.8975 13.0162 0.7505 12.663 0.75 12.25V2.5H0V1H3.75V0.25H8.25V1H12V2.5H11.25V12.25C11.25 12.6625 11.1033 13.0157 10.8097 13.3097C10.5162 13.6038 10.163 13.7505 9.75 13.75H2.25ZM9.75 2.5H2.25V12.25H9.75V2.5ZM3.75 10.75H5.25V4H3.75V10.75ZM6.75 10.75H8.25V4H6.75V10.75Z"
                                    fill="#6D7D36"></path>
                            </svg>
                        </a>


                        <a href="javascript:;" class="whishlist-btn {{ $c }}"
                            data-id="<?= $item['product_ID'] ?>" serial="{{ $serial }}">
                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 17C10 17 1 11.9091 1 5.72728C1 4.63445 1.37484 3.57537 2.06076 2.73024C2.74667 1.88511 3.70128 1.30613 4.76218 1.09181C5.82307 0.877486 6.92471 1.04106 7.87966 1.55471C8.83461 2.06835 9.58388 2.90033 10 3.9091C10.4161 2.90033 11.1654 2.06835 12.1203 1.55471C13.0753 1.04106 14.1769 0.877486 15.2378 1.09181C16.2987 1.30613 17.2533 1.88511 17.9392 2.73024C18.6252 3.57537 19 4.63445 19 5.72728C19 11.9091 10 17 10 17Z"
                                    stroke="#2D3C0A" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </li>
                <li class="cart-item-qty">
                    <h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Qty')?></h5>
                    <div class="qty-wrap cart d-flex gap-2 align-items-center">
                        <button class="cart-minus qty-btn" type="button"><svg width="16" height="2"
                                viewBox="0 0 16 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="16" width="2" height="16" rx="1" transform="rotate(90 16 0)"
                                    fill="#6D7D36"></rect>
                            </svg></button>
                        <input type="number" class="form-control qty border-0" name="qty" id="qty"
                            max="<?= $item['product']['prod_quantity'] ?>" readonly
                            value="<?= $item['product_quantity'] ?>">
                        <button class="cart-plus qty-btn" type="button"><svg width="16" height="16"
                                viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="7" width="2" height="16" rx="1" fill="#6D7D36"></rect>
                                <rect x="16" y="7" width="2" height="16" rx="1"
                                    transform="rotate(90 16 7)" fill="#6D7D36"></rect>
                            </svg></button>
                    </div>
                </li>
            </ul>


        </div>
    </div>
</div>

<?php endforeach;?>
