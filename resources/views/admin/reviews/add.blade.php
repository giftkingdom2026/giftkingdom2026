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

                                    <label for="name" class="control-label mb-1">Type</label>

                                    <select name="discount_type" class="form-control" required>
                                        <option value="percent">Percent</option>
                                        <option value="fixed_cart">Fixed Cart</option>
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

