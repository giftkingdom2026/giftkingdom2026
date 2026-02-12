@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
 <!--    <section class="content-header">
        <h1> {{ trans('labels.AddProduct') }} <small>{{ trans('labels.AddProduct') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/products/display')}}"><i class="fa fa-database"></i>Add Discount Product</a></li>
            <li class="active">Add Discount Product</li>
        </ol>
    </section> -->

    <!-- Main content -->
    <section class="content addDiscountPg">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Add Discount Product</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                            {{ $error }}
                                        </div>
                                        @endforeach
                                        @endif
                                        
                                        {!! Form::open(array('url' =>'admin/products/bulk/products/discount/insert', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-md-9 col-md-offset-2">
                                                        <input type="text" id="mySearch" class="form-control"  placeholder="Search.." title="Type in a category">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Category') }}<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-9">
                                                        <?php print_r($result['categories']); ?>
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                            {{ trans('labels.ChooseCatgoryText') }}.</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row show_products">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Products') }}<span style="color:red;">*</span></label>
                                                    <div class="col-sm-10 col-md-9">
                                                        <ul class="list-group list-group-root well productsTbl">

                                                        </ul>
                                                    </div>
                                                </div>
                                            <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Type') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" name="discount_type">
                                                                <option value="0">Amount</option>
                                                                <option value="1">Percent</option>
                                                            </select>
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.ActiveSpecialProductText') }}.</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Value') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <input class="form-control" type="text" name="specials_new_products_price" value="">
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.SpecialPriceTxt') }}.</span>
                                                            <span class="help-block hidden">{{ trans('labels.SpecialPriceNote') }}.</span>
                                                        </div>
                                                    </div>
                                          
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.ExpiryDate') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <input class="form-control "  type="date" name="expires_date" >
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.SpecialExpiryDateTxt') }}
                                                            </span>
                                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('labels.Status') }}<span style="color:red;">*</span></label>
                                                        <div class="col-sm-10 col-md-9">
                                                            <select class="form-control" name="status">
                                                                <option value="1">{{ trans('labels.Active') }}</option>
                                                                <option value="0">{{ trans('labels.Inactive') }}</option>
                                                            </select>
                                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                {{ trans('labels.ActiveSpecialProductText') }}.</span>
                                                        </div>
                                                    </div>
                                                    
                                            </div>
                                       </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <div class="row">
                                            <div class="col-sm-10 col-md-9 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <span>Apply Discount</span>
                                                <!-- <i class="fa fa-angle-right 2x"></i> -->
                                            </button>
                                        </div>
                                    </div>
                                        </div>
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
        </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
<script type="text/javascript">
    $(function() {

        //for multiple languages
        @foreach($result['languages'] as $languages)
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor{{$languages->languages_id}}');

        @endforeach

        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();

    });
</script>
@endsection
