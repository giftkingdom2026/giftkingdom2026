<!DOCTYPE html>
<html>

<head>
    <title>Inovice</title>
</head>

<style>
    .wrapper.wrapper2 {
        display: block;
    }

    .wrapper {
        display: none;
    }
</style>
@php
$settings = \App\Models\Core\Setting::whereIn('name', ['site-name','phone','address'])->get();
    $setting = \App\Models\Core\Setting::getWebSettings();
@endphp
<?php

$billing = unserialize($order['billing_data']);
$shipping = unserialize($order['billing_data']); ?>

<?php $symbol = $order['currency'];  ?>

<body onload="window.print();">
    <table style="font-size: 13px; width: 720px; margin:0 auto; background:#fff;border-spacing: 0;font-family: 'Arial', sans-serif;">
        <thead>
            <tr>
                <th style="text-align: center; padding-bottom: 20px;">
                    <img style="width:32%;margin: auto;display: block;" src="<?= asset('https://v5.digitalsetgo.com/gift-kingdom/public/images/media/2025/02/logo.svg') ?>">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #6c7d36">
                <td>
                    @if(isset($order['customer']))
                    <h2 style="text-align: center; font-weight: 500;font-size: 22px;color: #fff;">Dear <?= $order['customer']['first_name'] ?></h2>
                    @else
                    <h2 style="text-align: center; font-weight: 500;font-size: 22px;color: #fff;">Dear <?= $billing['firstname'] ?></h2>
                    @endif

                    <p style="text-align: center;line-height: 1.4;color: #fff;">Thank you for choosing Gift Kingdom, your Trusted Online Shopping Partner!
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <h2 style="text-align:center;font-weight: 500;text-transform: uppercase;">Tax Invoice</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <ul style="list-style-type: none; padding: 0; margin: 10px 0 20px;text-align: center;">
                        <li style="margin-bottom: 10px;display: inline-block; margin-right: 20px;">Invoice Number: <span><?= $order['ID'] ?></span></li>
                        <li style="margin-bottom: 10px;display: inline-block;margin-right: 20px;">Order Number: <span><?= $order['ID'] ?></span></li>
                        <li style="margin-bottom: 0px;display: inline-block;margin-right: 20px;">Invoice Date: <span><?= date('d-m-Y', strtotime($order['created_at'])) ?></span></li>
                    </ul>

                    <div style="display: flex;margin-bottom: 20px;border: 1px solid #E4E4E4;border-radius: 20px;padding: 20px;">

                        <div style="flex: 1;">
                            <h3 style="-webkit-print-color-adjust: exact;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;border-bottom: 1px solid #E4E4E4;">Customer Details</h3>



                            @if(isset($order['customer']))
                            <ul style="padding: 12px; margin: 0; list-style: none;">
                                <li style="margin-bottom: 10px"><strong>Name:</strong> <?= $order['customer']['first_name'] ?></li>
                                <li style="margin-bottom: 10px"><strong>Email:</strong> <?= $order['customer']['email'] ?></li>
                                <li style="margin-bottom: 0px"><strong>Contact:</strong> <?= $order['customer']['phone'] ?></li>
                            </ul>
                            @else
                            <ul style="padding: 12px; margin: 0; list-style: none">
                                <li style="margin-bottom: 10px"><strong>Name:</strong> <?= $billing['firstname'] ?></li>
                                <li style="margin-bottom: 10px"><strong>Address:</strong> <?= $billing['address'] ?></li>
                                <li style="margin-bottom: 0px"><strong>Contact:</strong> <?= $billing['phone'] ?></li>
                            </ul>

                            @endif

                        </div>


                        <div style="flex: 1;">
                            <h3 style="-webkit-print-color-adjust: exact;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;border-bottom: 1px solid #E4E4E4;">Billing Details</h3>
                            <ul style="list-style-type: none; padding: 12px; margin: 0;">
                                <li style="margin-bottom: 10px"><strong>Emirate:</strong> <?= $billing['emirate'] ?></li>
                                <li style="margin-bottom: 0px"><strong>Address:</strong> <?= $billing['address'] ?></li>
                            </ul>
                        </div>
                    </div>

                    <div style="display: flex;margin-bottom: 20px;border: 1px solid #E4E4E4;border-radius: 20px;padding: 20px;">

                        <div style="flex: 1;">
                            <h3 style="-webkit-print-color-adjust: exact;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;border-bottom: 1px solid #E4E4E4;">Payement Method</h3>

                            <ul style="list-style-type: none; padding: 12px; margin: 0;">
                                <li style="margin-bottom: 10px"><?= $order['payment_method'] ?></li>

                        </div>


                        <div style="flex: 1;">
                            <h3 style="-webkit-print-color-adjust: exact;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;border-bottom: 1px solid #E4E4E4;">Shipping Method</h3>
                            <ul style="list-style-type: none; padding: 12px; margin: 0;">
                                <li style="margin-bottom: 10px"><?= $order['shipping_cost'] == 0 ? 'Free Shipping' : $symbol . ' ' . number_format($order['shipping_cost'], 2) ?></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="font-size: 13px;width: 720px;margin:auto;background:#fff;border-spacing: 0;font-family: 'Arial', sans-serif;border: 1px solid #E4E4E4;border-radius: 20px;padding: 20px;">
        <thead class="thead-light">
            <tr>
                <td style="-webkit-print-color-adjust: exact;border-bottom: 1px solid #E4E4E4;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;">Products</td>
                <td style="-webkit-print-color-adjust: exact;border-bottom: 1px solid #E4E4E4;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;">SKU</td>
                <td style="-webkit-print-color-adjust: exact;border-bottom: 1px solid #E4E4E4;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;">Price</td>
                <td style="-webkit-print-color-adjust: exact;border-bottom: 1px solid #E4E4E4;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;">Qty</td>
                <td style="-webkit-print-color-adjust: exact;border-bottom: 1px solid #E4E4E4;margin: 0;padding: 0 12px 12px;text-transform: uppercase;font-weight: 400;">Sub Total</td>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
            <?php

            $total = $productsdiscount = $itemtotal = 0;

            $subtotal = $order['order_subtotal'];

            $total = $order['order_total'];


            foreach ($order['items'] as $item) :

                $cond = $item['item_sale_price'] != 0 && $item['item_sale_price'] != null;

                $price = $cond ? $item['item_sale_price'] * $order['currency_value'] * $item['product_quantity'] : $item['item_price'] * $order['currency_value'] * $item['product_quantity'];

                if ($cond) :

                    $defprice = $item['item_price'] * $order['currency_value'] * $item['product_quantity'];

                else :

                    $defprice = false;

                endif;

                $itemtotal += $defprice ? $defprice : $price;

                $productsdiscount += $defprice ? $defprice - $price  : 0; ?>

                <tr>
                    <td style="padding: 12px">

                        <?= $item['product_ID']['prod_title'] ?>

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

                            <p class="mb-2"><?= rtrim($meta, ', ') ?></p>

                        <?php endif; ?>

                    </td>
                    <td style="padding: 12px"><?= $item['product_ID']['prod_sku'] ?></td>
                    <td style="padding: 12px">
                        <strong>

                            <?php if ($cond) : ?>

                                <?= $symbol ?> <?= number_format($item['item_sale_price'] * $order['currency_value'], 2) ?>

                            <?php else : ?>

                                <?= $symbol ?> <?= number_format($item['item_price'] * $order['currency_value'], 2) ?>

                            <?php endif; ?>
                        </strong>

                    </td>
                    <td style="padding: 12px"><strong><?= $item['product_quantity'] ?></strong></td>
                    <td style="padding: 12px">
                        <strong>

                            <?php if ($cond) : ?>

                                <?= $symbol ?> <?= number_format($item['item_sale_price'] * $item['product_quantity'] * $order['currency_value'], 2) ?>

                            <?php else : ?>

                                <?= $symbol ?> <?= number_format($item['item_price'] * $item['product_quantity'] * $order['currency_value'], 2) ?>

                            <?php endif; ?>

                        </strong>
                    </td>
                </tr>

            <?php

            endforeach;

            ?>
        </tbody>
    </table>

<div style="text-align: right; font-size: 13px; width: 720px; margin:0 auto; font-family: 'Arial', sans-serif; background: #F6F6F6; -webkit-print-color-adjust: exact; border-radius: 20px;">
    <ul style="list-style-type: none; padding:12px">

        <?php
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            $subtotal = $itemtotal - $productsdiscount;
            $vat = $subtotal * 0.05;
            $total = $subtotal + $vat;

            if (isset($setting['admin_commission'])) {
                $commission = ($setting['admin_commission'] / 100) * $subtotal;
            }
        } else {
            $vat = $order['vat'];
        }
        ?>

        <?php if ($productsdiscount != 0): ?>
            <li style="padding:5px 0">
                <strong>Items Total:</strong>
                <span style="margin-left:10px;">
                    <strong><?= $symbol ?> <?= number_format($itemtotal, 2) ?></strong>
                </span>
            </li>
            <li style="padding:5px 0">
                <strong>Products Discount:</strong>
                <span style="margin-left:10px;">
                    <strong><?= $symbol ?> <?= number_format($productsdiscount, 2) ?></strong>
                </span>
            </li>
        <?php endif; ?>

        <li style="padding:5px 0">
            <strong>Subtotal:</strong>
            <span style="margin-left:10px;">
                <strong><?= $symbol ?> <?= number_format($subtotal, 2) ?></strong>
            </span>
        </li>

        <?php if ($order['coupon_amount'] != 0): 
            $total -= $order['coupon_amount']; ?>
            <li style="padding:5px 0">
                <strong>Coupon (<?= $order['coupon_code'] ?>):</strong>
                <span style="margin-left:10px;">
                    <strong>-<?= $symbol ?> <?= number_format($order['coupon_amount'], 2) ?></strong>
                </span>
            </li>
        <?php endif; ?>

        <?php if ($order['credit_amount'] != 0 && $order['credit_amount'] != '' && $order['credit_amount'] != null): 
            $total -= $order['credit_amount'] * $order['currency_value']; ?>
            <li style="padding:5px 0">
                <strong>Credit:</strong>
                <span style="margin-left:10px;">
                    <strong>-<?= $symbol ?> <?= number_format($order['credit_amount'] * $order['currency_value'], 2) ?></strong>
                </span>
            </li>
        <?php endif; ?>

        <li style="padding:5px 0">
            <strong>Shipping:</strong>
            <span style="margin-left:10px;">
                <strong>
                    <?= $order['shipping_cost'] == 0 ? 'Free Shipping' : $symbol . ' ' . number_format($order['shipping_cost'], 2) ?>
                </strong>
            </span>
        </li>

        <li style="padding:5px 0">
            <strong>VAT:</strong>
            <span style="margin-left:10px;">
                <strong><?= $symbol ?> <?= number_format($vat, 2) ?></strong>
            </span>
        </li>

        <?php if (!in_array(Auth::user()->role_id, [1, 2]) && isset($commission)): ?>
            <li style="padding:5px 0">
                <strong>Admin's Commission:</strong>
                <span style="margin-left:10px;">
                    <strong><?= $symbol ?> <?= number_format($commission, 2) ?></strong>
                </span>
            </li>
        <?php endif; ?>

        <li style="padding:5px 0">
            <strong>Order Total:</strong>
            <span style="margin-left:10px;">
                <strong>
                    <?= $symbol ?>
                    <?= number_format(
                        isset($commission) && !in_array(Auth::user()->role_id, [1, 2])
                            ? $total - $commission
                            : $total,
                        2
                    ) ?>
                </strong>
            </span>
        </li>
    </ul>
</div>


    <table style="font-size: 13px; width: 720px; margin:0 auto; background:#fff;border-spacing: 0;font-family: 'Arial', sans-serif;">
        <tfoot>
            <tr style="background-color: #6c7d36">
                <td style="text-align:center;padding-top: 20px;">
                    <p style="margin-top: 0;color: #fff;">{{$settings[0]->value}}</p>
                    <p style="color:#fff">{{$settings[2]->value}}</p>
                    <p style="color:#fff">{{$settings[1]->value}}</p>
                </td>
            </tr>
        </tfoot>
    </table>

</body>

</html>