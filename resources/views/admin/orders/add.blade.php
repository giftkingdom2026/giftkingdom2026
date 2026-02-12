@extends('admin.layout')



@section('content')


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

                        <h3>Add Order</h3>

                    </div>

                    <div class="box-body">

                        <form action="<?=asset('admin/orders/create')?>" method="post">

                            @csrf

                            <div class="row">

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label for="created_at" class="control-label mb-3">Date Created</label>

                                        <input type="text" name="created_at" class="flatpickr form-control">

                                    </div>

                                    <div class="form-group my-3">

                                        <label for="order_status" class="control-label mb-3">Status</label>

                                        <?php

                                        $arr = ['Completed', 'In Process', 'Refund Requested', 'Cancel Requested', 'Delivered', 'Shipped', 'On Hold', 'Cancelled', 'Refunded', 'Pending Payment', 'Failed', 'Return', 'Payment Recieved']; ?>

                                        <select name="order_status" class="form-control select2">

                                            <?php

                                            foreach($arr as $item) :?>

                                                <option><?=$item?></option>

                                            <?php endforeach;?>

                                        </select>

                                    </div>

                                    <div class="form-group my-3">

                                        <label for="customer" class="control-label mb-3">Customer</label>

                                        <select name="customer" class="form-control select2 get_customer">

                                            <?php

                                            foreach( $order['customers'] as $customer ) : ?>

                                                <option value="<?=$customer->id?>"><?=$customer->email?></option>

                                            <?php endforeach;?>

                                        </select>

                                    </div>

                                    <div class="form-group my-3">

                                        <label for="coupon_code" class="control-label mb-3">Coupon</label>

                                        <select name="coupon_code" class="form-control select2">

                                            <option value="">None</option>

                                            <?php

                                            foreach( $order['coupons'] as $code ) : ?>

                                                <option value="<?=$code->coupon_code?>"><?=$code->coupon_code?></option>

                                            <?php endforeach;?>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-md-9">

                                    <div class="row">

                                        <div class="col-md-6 border p-3">

                                            <h3>Billing Address</h3>

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="firstname" class="control-label my-3">Recipient Name *</label>

                                                        <input type="text" id="firstname" name="billing[firstname]" value="" class="form-control">

                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="country" class="control-label my-3">Country</label>

                                                        <input type="text" id="country" name="billing[country]" value="" class="form-control">

                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="emirate" class="control-label my-3">Emirate</label>

                                                        <input type="text" id="city" name="billing[emirate]" value="" class="form-control">

                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="address" class="control-label my-3">Address</label>

                                                        <input type="text" id="address" name="billing[address]" value="" class="form-control">

                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="address-details" class="control-label my-3">Address details</label>

                                                        <input type="text" id="address-details" name="billing[address-details]" value="" class="form-control">

                                                    </div>
                                                </div>


                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="phone" class="control-label my-3">Phone</label>

                                                        <input type="text" id="phone" maxlength="9" name="billing[phone]" value="" class="form-control">

                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="email" class="control-label my-3">Email</label>

                                                        <input type="text" id="email" name="billing[email]" value="" class="form-control">

                                                    </div>
                                                </div>

                                                
                                            </div>


                                        </div>

                                        <div class="col-md-6 border p-3">

                                            <h3>Delivery Details</h3>

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="delivery_option" class="control-label my-3">Delivery Option</label>

                                                        <input type="text" name="delivery_option" id="delivery_option" class="form-control">

                                                    </div>

                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="delivery_date" class="control-label my-3">Delivery Date</label>

                                                        <input type="text" name="delivery_date" id="delivery_date" class="form-control">

                                                    </div>
                                                    
                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="time_slot" class="control-label my-3">Time Slot</label>

                                                        <input type="text" name="time_slot" id="time_slot" class="form-control">

                                                    </div>
                                                    
                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label for="shipping_cost" class="control-label my-3">Shipping Cost</label>

                                                        <input type="text" name="shipping_cost" id="shipping_cost" class="form-control">

                                                    </div>
                                                    
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12  border p-3">

                                            <div class="form-group">

                                                <label for="created_at" class="control-label mb-3">Order Note :</label>

                                                <textarea name="order_information" class="form-control"></textarea>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div id="product-item-html" class="d-none">

                                <div class="product-item mb-2">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label for="items" class="control-label mb-1">Select Product</label>

                                                <select name=""  class="form-control product">

                                                    <?php

                                                    foreach( $order['products'] as $product ) : ?>

                                                        <option value="<?=$product->ID?>" data-stock="{{$product->prod_quantity}}"><?=$product->prod_title?></option>

                                                    <?php endforeach;?>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-md-5">

                                            <div class="form-group">

                                                <label for="items" class="control-label mb-1">Select Variation</label>

                                                <select name=""  class="form-control variation">

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-md-2">

                                            <div class="form-group">

                                                <label for="items" class="control-label mb-1">Quantity</label>

                                                <input type="number" name="" class="form-control">

                                            </div>

                                        </div>
<div class="col-lg-1 d-flex align-items-center mt-3">
                                            <button type="button" class="btn btn-danger btn-sm remove-product-item">
                                                ×
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="product-items my-5 box p-3">

                                <div class="text-end">
                                    <a href="javascript:;" class="btn btn-primary repeat-product-item">+</a>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>

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

    function refund(){
        jQuery('#refund').addClass('show')

        jQuery('#refund').show()

    }

</script>

@endsection



