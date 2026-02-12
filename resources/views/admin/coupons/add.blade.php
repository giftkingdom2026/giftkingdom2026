@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Add Coupon</h1>
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


            {!! Form::open(array('url' =>'admin/coupons/add/','autocomplete' => 'false' , 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">


                        <div class="row">

                            <h2 class="mt-3">Coupon Data</h2>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Code</label>

                                    <input type="text" name="coupon_code" class="form-control" required> 

                                </div>

                            </div>
                            
                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="usage_limit" class="control-label mb-1">Usage Limit</label>

                                    <input type="number" name="usage_limit" value="" class="form-control" required> 

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="minimum_amount" class="control-label mb-1">Minimum Order Amount</label>

                                    <input type="number" name="minimum_amount" value="" class="form-control" required> 

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group mt-3">

                                    <label for="name" class="control-label mb-1">Type</label>

                                    <select name="discount_type" class="form-control discount_type" required>
                                        <option value="percent">Percent</option>
                                        <option value="fixed_cart">Fixed Cart</option>
                                        <option value="product">Product</option>
                                        <option value="product_percent">Product Percent</option>
                                    </select> 

                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="form-group mt-3">

                                    <label for="status" class="control-label mb-1">Status</label>

                                    <select name="status" class="form-control" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select> 

                                </div>

                            </div>

                            <div class="col-md-8 mt-3 products_div">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Products</label>

                                   <select name="product_ids[]" class="form-control select2" multiple>
                                        @foreach($result['products'] as $pro)
                                        @php
                                        $attribute_links = \App\Models\Core\VariationsToAttributeValues::where('variation_ID', $pro['ID'])->get();
                                        $attribute_titles = [];

                                        foreach ($attribute_links as $link) {
                                        $attribute = \App\Models\Core\Values::where('value_ID', $link->value_ID)->first();
                                        if ($attribute) {
                                        $attribute_titles[] = $attribute->value_title;
                                        }
                                        }

                                        $attribute_string = !empty($attribute_titles) ? ' | ' . implode(' | ', $attribute_titles) : '';
                                        $title = $pro['prod_title'] . ' | #' . $pro['ID'] . $attribute_string;
                                        @endphp
                                        <option value="{{ $pro['ID'] }}">
                                            {{ $title }}
                                        </option>
                                        @endforeach
                                    </select>



                                </div>

                            </div>

                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Amount</label>

                                    <input type="text" autocomplete="false" name="discount_amount" class="form-control" required> 

                                </div>

                            </div>
                            
                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Expiry Date</label>

                                    <input type="date" name="expiry_date" class="coupon form-control" required> 

                                </div>

                            </div>

                        </div>


                    </div>


                </div>


            </div>

        </div>

        <div class="box-footer text-center">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

        {!! Form::close() !!}

    </div>

</section>

</div>


@endsection

