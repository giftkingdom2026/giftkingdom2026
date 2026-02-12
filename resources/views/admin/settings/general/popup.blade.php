@extends('admin.layout')
@section('content')
<div class="content-wrapper content-wrapper1">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Popup <small>Popup Setting</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">Popup</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="">

                    <div class="box box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-info">

                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-success" role="alert">
                                            <span class="icon fa fa-check" aria-hidden="true"></span>
                                            <span class="sr-only">{{ trans('labels.Setting') }}Error:</span>
                                            {{ $error }}
                                        </div>
                                        @endforeach
                                        @endif

                                        {!! Form::open(array('url' =>'admin/updateSetting', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                        <br>




                                        <div class="form-group">
                                            <label for="name" class="col-md-12 control-label">Visiblility</label>
                                            <div class="col-md-12">
                                                <select class="form-control" id="popup_visibility" name="popup_visibility">
                                                    <option value="1" @if(isset($result['commonContent']['setting']['popup_visibility']) && $result['commonContent']['setting']['popup_visibility']==1) selected @endif>Show</option>
                                                    <option value="0" @if(isset($result['commonContent']['setting']['popup_visibility']) && $result['commonContent']['setting']['popup_visibility']==0) selected @endif>Hide</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-md-12 control-label mb-2 mt-2">Heading</label>
                                            <div class="col-md-12">
                                                {!! Form::text('popup_heading', $result['commonContent']['setting']['popup_heading'] ?? '', ['class' => 'form-control', 'id' => 'popup_heading']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group" id="imageIcone">
                                            <label for="name" class="col-md-12 control-label mt-2 mb-2">Image (403px X 338px)</label>
                                            <div class="col-md-12 ">
               <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['popup_image']) ?

                $popup_imgid = $result['commonContent']['setting']['popup_image']['id'] : 

                $popup_imgid = '';

                isset($result['commonContent']['setting']['popup_image']) ?

                $popupimgpath = $result['commonContent']['setting']['popup_image']['path'] : 

                $popupimgpath = ''; ?>

                <input type="hidden" name="popup_image" value="{{$popup_imgid}}"

                id="popup_image">

                <img src="{{asset($popupimgpath)}}" class="w-100">

            </div>
                                                <br>
                                            </div>
                                        </div>
                                       @php
    $popupDesc = $result['commonContent']['setting']['popup_desc'] ?? '';
@endphp

<div class="form-group">
    <label for="popup_desc" class="col-md-12 control-label">Description</label>
    <div class="col-md-12">
        <textarea class="form-control" name="popup_desc" id="popup_desc" rows="4">{{ $popupDesc }}</textarea>
    </div>
</div>






                                    </div>


                                    <input type="hidden" name="hidden_url" value="admin/newsletter">
                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                        <a href="{{ URL::to('admin/dashboard')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                    </div>

                                    <!-- /.box-footer -->
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection