@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.EditMainCategories') }} <small>{{ trans('labels.Edit Currency') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/currencies/display')}}"><i class="fa fa-gears"></i> {{ trans('labels.Currency') }}</a></li>
            <li class="active">{{ trans('labels.Edit Currency') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('labels.Edit Currency') }} </h3>
            </div>

            <div class="box box-info">
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
                @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session()->get('error') }}
                </div>
                @endif
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">

                {!! Form::open(array('url' =>'admin/currencies/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                {!! Form::hidden('id', $result['currency']->id , array('class'=>'form-control', 'id'=>'id')) !!}

                <input type="hidden" name="warning" value="{{$result['warning']}}" />

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Title</label>

                            <input type="text" required name="title" value="<?=$result['currency']->title?>" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Currency</label>

                            <select class="form-control" required name="code">

                                <?php 

                                foreach($currencies as $currency) :

                                    $attr = $result['currency']->code == $currency->code ? 'selected' : ''; ?>

                                    <option <?=$attr?> value="<?=$currency->code?>"><?=$currency->currency_name?></option>

                                <?php endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Symbol</label>

                            <?php

                            if(!empty($result['currency']->symbol_left)) : ?>

                                {!! Form::text('symbol', $result['currency']->symbol_left, array('class'=>'form-control field-validate', 'id'=>'symbol'))!!}

                            <?php else :?>

                                {!! Form::text('symbol', $result['currency']->symbol_right, array('class'=>'form-control field-validate', 'id'=>'symbol'))!!}

                            <?php endif;?>

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Position</label>

                            <select class="form-control" required name="position">
                                <option <?=!empty($result['currency']->symbol_left) ? 'selected' : ''?> value="left">Left</option>
                                <option <?=!empty($result['currency']->symbol_right) ? 'selected' : ''?> value="right">Right</option>
                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Decimal Places</label>

                            <input type="hidden" name="decimal_point" value="<?=$result['currency']->decimal_point?>" class="form-control">
                            <input type="text" required name="decimal_places" value="<?=$result['currency']->decimal_places?>"  class="form-control">
                            <input type="hidden" name="thousands_point" value="<?=$result['currency']->thousands_point?>" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Value</label>

                            <input type="text" required name="value" value="<?=$result['currency']->value?>" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-6 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Flag</label>

                            <textarea type="text" name="flag" class="form-control"><?=$result['currency']->flag?></textarea>

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

                {!! Form::close() !!}
            </div>

            <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                <a href="{{ URL::to('admin/currencies/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
            </div>
        </div>

    </section>

</div>
@endsection
