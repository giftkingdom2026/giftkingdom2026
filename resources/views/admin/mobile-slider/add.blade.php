@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add Slider </h1>
            <ol class="breadcrumb">

            <li>

                <a href="{{url('admin/mobile-slider/display')}}">Back</a>

            </li>

        </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                       

                        <!-- /.box-header -->
                     

                                        @if(session()->has('message'))
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{ session()->get('message') }}
                                            </div>
                                        @endif

                                        <!-- /.box-header -->
                                        <!-- form start -->
                                            {!! Form::open(array('url' =>'admin/mobile-slider/add', 'method'=>'post', 'class' => 'form-horizontal  form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="form-group col-6">
                                                            <label for="mobile_slider_type" class="control-label mb-1">Slider Type
                                                            </label>
                                                            <div class="col-sm-10 col-md-10">
                                                                <!-- {!! Form::text('countries_name',  '', array('class'=>'form-control  field-validate', 'id'=>'countries_name'))!!} -->
                                                                <select name="mobile_slider_type" class="form-control  field-validate">
                                                                    <!-- <option value="">Select Please</option> -->
                                                                    <option value="category">Category</option>
                                                                    <option value="product">Product</option>
                                                                </select>
                                                                <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> -->
                                                                  <!-- {{ trans('labels.CountryNameText') }}</span> -->
                                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-6">
                                                            <label for="name" class="control-label mb-1">Category
                                                            </label>
                                                            <div class="col-sm-10 col-md-10">
                                                                <!-- {!! Form::text('countries_name',  '', array('class'=>'form-control  field-validate', 'id'=>'countries_name'))!!} -->
                                                                <select name="mobile_slider_category" class="form-control select2  field-validate">
                                                                    <!-- <option value="">Select Please</option> -->
                                                                    @foreach($result['categories'] as $key => $val)
                                                                    <option value="{{$val['category_ID']}}">{{$val['category_title']}}</option>
                                                                    @endforeach
                                                                    <!-- <option value="product">Product</option> -->
                                                                </select>
                                                                <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> -->
                                                                  <!-- {{ trans('labels.CountryNameText') }}</span> -->
                                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label for="name" class="control-label mb-1">Products
                                                            </label>
                                                            <div class="col-sm-10 col-md-10">
                                                                <!-- {!! Form::text('countries_name',  '', array('class'=>'form-control  field-validate', 'id'=>'countries_name'))!!} -->
                                                                <select name="mobile_slider_products" class="form-control select2  field-validate">
                                                                    <!-- <option value="">Select Please</option> -->
                                                                    @foreach($result['products'] as $key => $val)
                                                                    <option value="{{$val['ID']}}">{{$val['prod_title']}}</option>
                                                                    @endforeach
                                                                    <!-- <option value="product">Product</option> -->
                                                                </select>
                                                                <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"> -->
                                                                  <!-- {{ trans('labels.CountryNameText') }}</span> -->
                                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mt-3 col-6">
                                                            <label for="name" class="control-label mb-1">Start Date
                                                            </label>
                                                            <div class="col-sm-10 col-md-10">
                                                                {!! Form::date('start_date',  '', array('class'=>'form-control field-validate', 'id'=>'start_date'))!!}
                                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mt-3 col-6">
                                                            <label for="name" class="control-label mb-1">Expire Date
                                                            </label>
                                                            <div class="col-sm-10 col-md-10">
                                                                {!! Form::date('end_date',  '', array('class'=>'form-control field-validate', 'id'=>'end_date'))!!}
                                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">

                                                        <label for="category_icon" class="control-label mb-1">Slider Image</label>

                                                        <div class="featuredWrap">

                                                            <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                                            <input type="hidden" id="mobile_slider_banner_id" name="mobile_slider_banner_id" value="">

                                                            <img src="" alt="mobile_slider_banner_id" class="w-100 d-none">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/countries/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                            </div>
                                            <!-- /.box-footer -->
                                            {!! Form::close() !!}
                                


                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection
