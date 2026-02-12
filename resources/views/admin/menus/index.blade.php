@extends('admin.layout')
@section('content')

<link href="{!! asset('admin/css/menu.css') !!} " media="all" rel="stylesheet" type="text/css" />
<script>
    var _BASE_URL = "{{url('/admin')}}";
    var current_group_id = 1;
</script>

<div class="content-wrapper">

    <section class="content-header">
        <h1> Menus </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ URL::to('admin/addmenus') }}" type="button" class="d-block "><i class="fa fa-plus"></i>Add Menu</a>
            </li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row align-items-center   justify-content-between">

                            <div class="col-md-6">
                                
                            <h3 class="box-title">

                                <?= isset( $_GET['type'] ) ? ucwords( str_replace('-', ' ', $_GET['type']) ) : 'About Us' ?> Listing

                            </h3>
                            </div>
                            <div class="col-md-6">
                                
                            <div class="buttons text-end">
                                <a href="{{ URL::to('admin/menus?type=main') }}" class="btn btn-primary ">Main</a>
                                <a href="{{ URL::to('admin/menus?type=get-to-know-us') }}" class="btn btn-primary ">About Us</a>
                                <a href="{{ URL::to('admin/menus?type=quick-links') }}" class="btn btn-primary ">Help & Support</a>
                                <a href="{{ URL::to('admin/menus?type=our-legal') }}" class="btn btn-primary ">Legal & Policies</a>
                                
                            </div>
                            </div>
                        </div>

                    </div>

                    <form method="post" id="form-menu" action="{{url('/admin/menuposition')}}">
                        <div class="box-body">
                            @if (count($errors) > 0)
                            @if($errors->any())
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{$errors->first()}}
                            </div>
                            @endif
                            @endif

                            @if(!empty($result["menus"]))
                            {!! $result["menus"] !!}
                            @endif

                        </div>
                        <div class="box-footer">
                            <div class="col-lg-6 form-inline" id="contact-form">
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="alert alert-success alert-dismissible" id="sorted" role="alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                @lang('labels.Menussortedsuccessfully')
                            </div>
                            <div class=" pull-right">

                                <button type="submit" id="btn-save-menu" class="btn btn-block btn-primary">{{ trans('labels.SaveMenu') }}</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {!! Form::open(array('url' =>'admin/deletemenu', 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                    {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                    {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'products_id')) !!}
                    <div class="modal-body">
                        <p>{{ trans('labels.DeleteText') }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-close" data-bs-dismiss="modal" aria-label="Close">{{ trans('labels.Close') }}</button>
                        <button type="submit" class="btn btn-primary" id="deleteProduct">{{ trans('labels.Delete') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>



        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<style type="text/css">
    .ns-class .label-success{display: none !important;}
    button.btn.btn-default.btn-close {background: #f4f4f4;width: auto;opacity: 1;height: auto;padding: 0.5rem;border-radius: 10px;}
    .fas.fa-edit{color: #fff}
</style>
<script src="{!! asset('admin/plugins/sort/jquery-1.9.1.min.js') !!}"></script>
<script src="{!! asset('admin/plugins/sort/jquery-ui-1.10.3.custom.min.js') !!}"></script>
<script src="{!! asset('admin/plugins/sort/jquery.ui.touch-punch.min.js') !!}"></script>
<script src="{!! asset('admin/plugins/sort/jquery.mjs.nestedSortable.js') !!}"></script>
<script src="{!! asset('admin/plugins/sort/menu.js') !!}"></script>
@endsection
