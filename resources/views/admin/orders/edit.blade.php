@extends('admin.layout')

@section('content')
@php
    $settings = \App\Models\Core\Setting::getWebSettings();
@endphp
<div class="modal delete-modal fade show" id="refund" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= asset('admin/orders/returntowallet/') ?>" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>
                            <h3>Comment :</h3>
                        </label>
                        <input type="hidden" name="ID" value="<?= $order['ID'] ?>">
                        @if(isset($order['customer']['id']))
                        <input type="hidden" name="user_id" value="<?= $order['customer']['id'] ?>">
                        @else
                        <input type="hidden" name="user_id" value="">
                        @endif
                        <textarea name="transaction_comment" placeholder="Comments" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" data-images="" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal delete-modal fade show" id="detail" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="main-heading text-center">
                    <h2>Device Details</h2>
                </div>


                <div class="data">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit Order<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?= asset('admin/orders/display') ?>">Back</a></li>

        </ol>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    @endif

                    <div class="box-header">
                        <div class="row justify-content-between">
                            <div class="col-md-8">
                                <h2 class="box-title">Order #<?= $order['ID'] ?> Details</h2>
                                <p class="m-0">Payment via <?= $order['payment_method'] ?>. <?= $order['order_status'] ?> on <?= date('M d, Y', strtotime($order['created_at'])) ?> @ <?= date('h:i:a', strtotime($order['created_at'])) ?></p>
                                <!-- <p class="m-0">Payment Status: <?= $order['payment_status'] ?></p> -->
                                <p class="m-0">Order Status: <?= $order['order_status'] ?></p>


                            </div>

                            <div class="col-md-2 text-end">

                                <a target="_blank" href="<?= asset('admin/orders/invoice/' . $order['ID']) ?>" class="btn btn-primary">Print Invoice</a>

                            </div>

                            <?php

                            if ($order['order_status'] == 'Return' && $order['payment_method'] == 'Cash on Delivery') : ?>

                                <div class="col-md-2">

                                    <a href="javascript:refund();" class="btn btn-primary">Refund to Wallet</a>

                                </div>

                            <?php endif; ?>

                        </div>
                    </div>


                    <div class="box-body">

                        <form action="<?= asset('admin/orders/update') ?>" method="post">

                            @csrf

                            <input type="hidden" name="ID" class="form-data" value="<?= $order['ID'] ?>">

                            <div class="row">
                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label for="created_at" class="control-label mb-3">Date Created</label>

                                        <input type="text" name="created_at" value="<?= date('Y-m-d', strtotime($order['created_at'])) ?>" class="flatpickr form-control">

                                    </div>

                                    <div class="form-group my-3">

                                        <label for="order_status" class="control-label mb-3">Status</label>

                                        <?php

                                        $arr = ['Completed', 'In Process', 'Refund Requested', 'Cancel Requested', 'Delivered', 'Shipped', 'On Hold', 'Cancelled', 'Refunded', 'Pending Payment', 'Failed', 'Return', 'Payment Recieved']; ?>
                                        <select name="order_status" id="order_status" class="form-control select2">

                                            <?php

                                            if ($order['order_status'] == 'Refunded to Wallet') :

                                                echo '<option selected>Refunded to Wallet</option>';

                                            endif;

                                            foreach ($arr as $item) : $item == $order['order_status'] ? $attr = 'selected' : $attr = ''; ?>

                                                <option <?= $attr ?>><?= $item ?></option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>
                                    {{-- CANCEL Reasons --}}
                                    <div class="form-group my-3" id="cancel-reason-wrapper" style="display: none;">
                                        <label for="cancel_reason_id" class="control-label mb-3">Select Cancel Reason</label>
                                        <select id="cancel_reason_id" class="form-control select2">
                                            <option value="">-- Select a Reason --</option>
                                            @foreach ($reasons as $reason)
                                            @if ($reason['reason_type'] === 'cancel')
                                            <option value="{{ $reason['post_title'] }}">
                                                {{ $reason['post_title'] }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- REFUND Reasons --}}
                                    <div class="form-group my-3" id="refund-reason-wrapper" style="display: none;">
                                        <label for="refund_reason_id" class="control-label mb-3">Select Refund Reason</label>
                                        <select id="refund_reason_id" class="form-control select2">
                                            <option value="">-- Select a Reason --</option>
                                            @foreach ($reasons as $reason)
                                            @if ($reason['reason_type'] === 'refund')
                                            <option value="{{ $reason['post_title'] }}">
                                                {{ $reason['post_title'] }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group my-3">

                                        <label for="customer" class="control-label mb-3">Customer</label>

                                        <select name="customer" class="form-control select2">
                                            <?php if (isset($order['customer']['id'])): ?>
                                                <option value="<?= $order['customer']['id'] ?>" selected><?= $order['customer']['email'] ?></option>
                                            <?php endif; ?>

                                            <?php foreach ($order['customers'] as $customer): ?>
                                                <option value="<?= $customer->id ?>" <?= (isset($order['customer']['id']) && $order['customer']['id'] == $customer->id) ? 'selected' : '' ?>>
                                                    <?= $customer->email ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>

                                </div>

                                <div class="col-md-9">

                                    <div class="row">

                                        <div class="col-md-6 border p-3">

                                            <h3>Billing Address</h3>

                                            <div class="row">

                                                <?php

                                                $billing = unserialize($order['billing_data']);

                                                unset($billing['url']);
                                                unset($billing['default']);
                                                unset($billing['label']);
                                                unset($billing['key']);
                                                unset($billing['area']);


                                                foreach ($billing as $key => $field) : ?>

                                                    <div class="col-md-12">

                                                        <div class="form-group">
                                                            <?php
                                                            switch ($key) {
                                                                case 'firstname':
                                                                    $labelText = 'Recipient Name';
                                                                    break;
                                                                case 'phone':
                                                                    $labelText = 'Recipient Phone';
                                                                    break;
                                                                default:
                                                                    $labelText = str_replace(['-', '_'], ' ', ucwords($key));
                                                            }
                                                            ?>

                                                            <label for="<?= $key ?>" class="control-label my-3">
                                                                <?= $labelText ?>
                                                            </label>

                                                            <input type="text" name="billing[<?= $key ?>]" value="<?= $field ?>" class="form-control">

                                                        </div>
                                                    </div>

                                                <?php endforeach; ?>

                                            </div>

                                        </div>

                                        <div class="col-md-6 border p-3">

                                            <h3>Delivery Details</h3>

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="delivery_option" class="control-label my-3">Delivery Option</label>

                                                        <input type="text" name="delivery_option" id="delivery_option" value="<?= ucwords(str_replace('-', ' ', $order['delivery_option'])) ?>" class="form-control">

                                                    </div>

                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="delivery_date" class="control-label my-3">Delivery Date</label>

                                                        <input type="text" name="delivery_date" id="delivery_date" value="<?= $order['delivery_date'] ?>" class="form-control">

                                                    </div>

                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="time_slot" class="control-label my-3">Time Slot</label>

                                                        <input type="text" name="time_slot" id="time_slot" value="<?= $order['time_slot'] ?>" class="form-control">

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12 border p-3">

                                            <div class="form-group">

                                                <label for="created_at" class="control-label mb-3">Order Note :</label>

                                                <textarea name="order_information" class="form-control"><?= $order['order_information'] ?></textarea>

                                            </div>



                                        </div>

                              <?php $refcanc = false; ?>

@if (isset($order['refund']) && in_array($order['order_status'], ['Refund Requested', 'Refunded']))
    <?php $refcanc = true; ?>
    <div class="wrap mt-3">
        <h5>Reason of refund:</h5>
        <p>{{ $order['refund'] }}</p>
        @if($order['order_status'] == 'Refund Requested')
            <div class="d-flex gap-3">
                <a target="_blank" href="{{ asset('admin/orders/update-status/Refunded/' . $order['ID']) }}" class="btn btn-primary">Approve Refund</a>
                <a target="_blank" href="{{ asset('admin/orders/update-status/Refund Rejected/' . $order['ID']) }}" class="btn btn-primary">Reject Refund</a>
            </div>
        @endif
    </div>
@endif

@if (isset($order['cancel']) && in_array($order['order_status'], ['Cancel Requested', 'Cancelled']))
    <?php $refcanc = true; ?>
    <div class="wrap mt-3">
        <h5>Reason for cancellation:</h5>
        <p class="m-0">{{ $order['cancel'] }}</p>
    </div>
@endif


                                    </div>

                                </div>

                            </div>


                            <div class="row my-5 box p-3">

                                <div class="col-md-6">
                                    <h5>Item Details</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Cost</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Qty</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Total</h5>
                                </div>

                            </div>
                            <?php

$total = $productsdiscount = $itemtotal = 0;
$subtotal = $order['order_subtotal'];
$total = $order['order_total'];
$symbol = $order['currency'];

foreach ($order['items'] as $item) :
    $authorId = \App\Models\Web\Products::where('ID', $item['product_ID'])->value('author_id');
    if(isset($authorId) && $authorId != null){
        $storeName = \App\Models\Web\UserMeta::where('user_id', $authorId)->where('meta_key', 'store_name')->value('meta_value');
    }
    $cond = $item['item_sale_price'] != 0 && $item['item_sale_price'] != null;
    $price = $cond ? $item['item_sale_price'] * $order['currency_value'] * $item['product_quantity'] : $item['item_price'] * $order['currency_value'] * $item['product_quantity'];

    if ($cond) :
        $defprice = $item['item_price'] * $order['currency_value'] * $item['product_quantity'];
    else :
        $defprice = false;
    endif;

    $itemtotal += $defprice ? $defprice : $price;
    $productsdiscount += $defprice ? $defprice - $price  : 0; ?>

    <div class="row mb-3 p-3 border">

        <div class="col-md-6 mt-2">

            <div class="cart-item-meta">

                <h5 class="text-capitalize"><?= $item['product_ID']['prod_title'] ?></h5>
                @if(Auth::user()->role_id == 1 && isset($storeName))
                <h5 class="text-capitalize">By (<?= $storeName ?>)</h5>
@endif
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

            </div>

        </div>

        <div class="col-md-2 mt-2">
            <?php if ($cond) : ?>
                <h6><?= $symbol ?> <?= number_format($item['item_sale_price'] * $order['currency_value'],2) ?> <del><?= $symbol ?> <?= number_format(($item['item_price'] * $order['currency_value']),2) ?></del></h6>
            <?php else : ?>
                <h6><?= $symbol ?> <?= number_format($item['item_price'] * $order['currency_value'],2) ?></h6>
            <?php endif; ?>
        </div>

        <div class="col-md-2 mt-2">
            <h6><?= $item['product_quantity'] ?></h6>
        </div>

        <div class="col-md-2 mt-2">
            <?php if ($cond) : ?>
                <h6><?= $symbol ?> <?= number_format($item['item_sale_price'] * $item['product_quantity'] * $order['currency_value'],2) ?></h6>
            <?php else : ?>
                <h6><?= $symbol ?> <?= number_format($item['item_price'] * $item['product_quantity'] * $order['currency_value'],2) ?></h6>
            <?php endif; ?>
        </div>

        <?php if (!empty($item['delivery_items'])): ?>
            <?php foreach ($item['delivery_items'] as $delivery): ?>
                <div class="row mt-3 p-2 bg-light rounded border align-items-start" style="margin:0px;">
                    <div class="col-md-8">
                        <strong class="d-block mb-1">Address Details <?= $delivery['label'] ?>:</strong>
                        <div class="d-flex flex-wrap gap-2">
                            <span><strong>Name:</strong> <?= $delivery['name'] ?></span>
                            <span><strong>Phone:</strong> <?= $delivery['phone'] ?></span>
                            <span><strong>Address:</strong> <?= $delivery['address'] ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <strong class="d-block mb-1">Delivery Details:</strong>
                        <div class="d-flex flex-wrap gap-2">
                            <span><strong>Date:</strong> <?= $delivery['delivery_date'] ?></span>
                            <span><strong>Time:</strong> <?= $delivery['delivery_time'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

<?php endforeach; ?>

<?php
if (!in_array(Auth::user()->role_id, [1, 2])) {
    $subtotal = $itemtotal - $productsdiscount;
    $vat = $subtotal * 0.05;
    $total = $subtotal + $vat;
    if(isset($settings['admin_commission'])){
        $comission = ($settings['admin_commission'] / 100) * $subtotal;
    }
} else {
    $vat = $order['vat'];
}
?>

<?php if ($productsdiscount != 0) : ?>
<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Items Total:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3"><?= $symbol ?> <?= number_format($itemtotal, 2) ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Products Discount:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3"><?= $symbol ?> <?= number_format($productsdiscount, 2) ?></h6>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Item Subtotal:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3"><?= $symbol ?> <?= number_format($subtotal, 2) ?></h6>
    </div>
</div>

<?php if ($order['coupon_amount'] != 0) : ?>
<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Coupon (<?= $order['coupon_code'] ?>):</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3">- <?= $symbol ?> <?= number_format($order['coupon_amount'],2) ?></h6>
    </div>
</div>
<?php endif; ?>

<?php if ($order['credit_amount'] != 0 && $order['credit_amount'] != '' && $order['credit_amount'] != null) : ?>
<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Credit:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3">-<?= $symbol ?> <?= number_format($order['credit_amount'] * $order['currency_value'], 2) ?></h6>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Shipping:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3"><?= $order['shipping_cost'] == 0 ? 'Free Shipping' : $symbol . ' ' . number_format($order['shipping_cost'],2) ?></h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>VAT:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3"><?= $symbol ?> <?= number_format($vat, 2) ?></h6>
    </div>
</div>

<?php if (!in_array(Auth::user()->role_id, [1, 2]) && isset($comission)): ?>
<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Admin's Commission:</h5>
    </div>
    <div class="col-md-3 mt-3">
        <h6 class="text-end me-3"><?= $symbol ?> <?= number_format($comission, 2) ?></h6>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col-md-6 mt-3"></div>
    <div class="col-md-3 mt-3">
        <h5>Order Total:</h5>
    </div>
<div class="col-md-3 mt-3">
    <h6 class="text-end me-3">
        <?= $symbol ?> 
        <?php 
            if(isset($comission)){
                echo !in_array(Auth::user()->role_id, [1, 2]) ? number_format($total - $comission, 2) : number_format($total, 2);
            } else {
                echo number_format($total, 2);
            }
        ?>
    </h6>
</div>

</div>


                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </div>

            </form>

        </div>

</div>

</div>
</div>

</section>

</div>

<script type="text/javascript">
    function refund() {

        jQuery('#refund').addClass('show')

        jQuery('#refund').show()

    }

    function showdetail(id) {

        jQuery('#detail').addClass('show')

        jQuery('#detail').find('.data').html(jQuery('#data' + id).html())

        jQuery('#detail').show()


    }
</script>
@endsection