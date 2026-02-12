@extends('admin.layout')

@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Edit Coupon</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/coupons/display/') }}">

                    Back

                </a>

            </li>

        </ol>

    </section>  

    <section class="content">

        <div class="box">

            @if(session()->has('success'))
            
            <div class="box-info">

                <div class="alert alert-success">

                    {{ session()->get('success') }}

                </div>

            </div>
            @endif

            {!! Form::open(array('url' =>'admin/coupons/update/','autocomplete' => 'false' , 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">
                        <input type="hidden" name="id" value="<?=$result->coupon_ID?>">
                        <div class="row">
                            <div class="d-flex justify-content-between align-items-center mt-3">

                                <h2>Coupon Data</h2>

                                <strong>Used (<?=$result->usage_count?>) Times</strong> 

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Code</label>

                                    <input type="text" name="coupon_code" value="<?=$result->coupon_code?>" class="form-control" required> 

                                </div>

                            </div>
                            
                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="usage_limit" class="control-label mb-1">Usage Limit</label>

                                    <input type="number" name="usage_limit" value="<?=$result->usage_limit?>" class="form-control" required> 

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="minimum_amount" class="control-label mb-1">Minimum Order Amount</label>

                                    <input type="number" name="minimum_amount" value="<?=$result->minimum_amount?>" class="form-control" required> 

                                </div>

                            </div>

                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Type</label>

                                    <select name="discount_type" class="form-control discount_type" required>
                                        <option <?=$result->discount_type == 'percent' ? 'selected' : ''?> value="percent">Percent</option>
                                        <option <?=$result->discount_type == 'fixed_cart' ? 'selected' : ''?> value="fixed_cart">Fixed Cart</option>
                                        <option <?=$result->discount_type == 'product' ? 'selected' : ''?> value="product">Product</option>
                                        <option <?=$result->discount_type == 'product_percent' ? 'selected' : ''?> value="product_percent">Product Percent</option>
                                    </select> 

                                </div>

                            </div>
                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Status</label>

                                    <select name="status" class="form-control discount_type" required>
                                        <option <?=$result->status == '1' ? 'selected' : ''?> value="1">Active</option>
                                        <option <?=$result->status == '0' ? 'selected' : ''?> value="0">Inactive</option>
                                    </select> 

                                </div>

                            </div>

                            <div class="col-md-8 mt-3 products_div">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Products</label>

        @php
            $selectedIds = json_decode($result->product_ids ?? '[]', true);
            $selectedIds = is_array($selectedIds) ? array_map('intval', $selectedIds) : [];
        @endphp

        <select name="product_ids[]" class="form-control select2" multiple>
            @foreach($result['products'] as $pro)
                @php
                    $attribute_links = \App\Models\Core\VariationsToAttributeValues::where('variation_ID', $pro->ID)->get();
                    $attribute_titles = [];
                    foreach ($attribute_links as $link) {
                        $attribute = \App\Models\Core\Values::where('value_ID', $link->value_ID)->first();
                        if ($attribute) {
                            $attribute_titles[] = $attribute->value_title;
                        }
                    }
                    $attribute_string = !empty($attribute_titles) ? ' | ' . implode(' | ', $attribute_titles) : '';
                    $title = $pro->prod_title . ' | #' . $pro->ID . $attribute_string;
                @endphp

                <option value="{{ $pro->ID }}" {{ in_array((int) $pro->ID, $selectedIds, true) ? 'selected' : '' }}>
                    {{ $title }}
                </option>
            @endforeach
        </select>

                                </div>

                            </div>

                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Amount</label>

                                    <input type="text" autocomplete="false" value="<?=$result->discount_amount?>" name="discount_amount" class="form-control" required> 

                                </div>

                            </div>
                            
                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Expiry Date</label>

                                    <input type="text" name="expiry_date" value="<?=date('Y-m-d',strtotime($result->expiry_date))?>" class="coupon form-control" required> 

                                </div>

                            </div>

                        </div>


                    </div>


                </div>


            </div>

            <div class="box-footer text-center">

                <button type="submit" class="btn btn-primary">Submit</button>

            </div>

        </div>


        {!! Form::close() !!}

    </div>

</section>

</div>


@endsection

