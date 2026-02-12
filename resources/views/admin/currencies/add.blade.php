@extends('admin.layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Add Currency') }} <small>{{ trans('labels.Add Currency') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i>
            {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li>
                <a href="{{ URL::to('admin/currencies/display')}}"><i class="fa fa-gears"></i>{{ trans('labels.Currency') }}</a>
            </li>
            <li class="active">{{ trans('labels.Add Currency') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">

            <div class="box-header">
                <h3 class="box-title">{{ trans('labels.Add Currency') }} </h3>
            </div>

            <div class="box box-info">
                <!-- form start -->
                <br>
                @if (count($errors) > 0)
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{$errors->first()}}
                </div>
                @endif
                @endif
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session()->get('success') }}
                </div>
                @endif

            </div>

            <div class="box-body">

                {!! Form::open(array('url' =>'admin/currencies/add', 'method'=>'post', 'class'=> 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Title</label>

                            <input type="text" required name="title" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Currency</label>

                            <select class="form-control" required name="code">

                                <?php 

                                foreach($currencies as $currency) : ?>

                                    <option value="<?=$currency->code?>"><?=$currency->currency_name?></option>

                                <?php endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Symbol</label>

                            <input type="text" required name="symbol" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Position</label>

                            <select class="form-control" required name="position">
                                <option value="left">Left</option>
                                <option value="right">Right</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Decimal Places</label>

                            <input type="hidden" name="decimal_point" class="form-control">
                            <input type="text" required name="decimal_places" class="form-control">
                            <input type="hidden" name="thousands_point" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Value</label>

                            <input type="text" required name="value" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-6 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Flag</label>

                            <textarea type="text" name="flag" class="form-control"></textarea>

                        </div>

                    </div>


                    <div class="col-md-6 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Status</label>

                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>

                        </div>

                    </div>

                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                    <a href="{{ URL::to('admin/currencies/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                </div>
                {!! Form::close() !!}
            </div>                                        



        </div>

    </section>

</div>

@endsection
