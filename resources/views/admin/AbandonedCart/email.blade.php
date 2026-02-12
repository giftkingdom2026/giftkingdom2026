@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Abandoned Cart <small>Abandoned Cart Email...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/abandoned/cart/list')}}"><i class="fa fa-language"></i>Abandoned Cart Listing</a></li>
                <li class="active">Abandoned Cart Email</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                      <div class="box-header">
                          <h3 class="box-title">Abandoned Cart Email</h3>
                      </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            @if( count($errors) > 0)
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">Error:</span>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!-- form start -->
                                        <div class="box-body">

                                            {!! Form::open(array('url' =>'admin/abandoned/cart/send/mail', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">From<span style="color:red;">*</span>

                                                </label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('from',  '', array('class'=>'form-control field-validate', 'id'=>'from'))!!}
                                                    <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.exampleLanguageName') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">To<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('To',  $result['Abandoned_data'][0]->email, array('class'=>'form-control field-validate', 'id'=>'to', 'readonly'=>""))!!}
                                                   <!--  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.exampleLanguageCode') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span> -->
                                                </div>
                                            </div>
                                            <input type="hidden" name="customer_id" value="{{$result['Abandoned_data'][0]->customers_id}}">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Subject<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::text('subject',  '', array('class'=>'form-control field-validate', 'id'=>'subject'))!!}
                                                    <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.exampleLanguageCode') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span> -->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">Message<span style="color:red;">*</span></label>
                                                <div class="col-sm-10 col-md-4">
                                                    <textarea type="textarea" 4-col 4-rows name="message" class="form-control field-validate"></textarea>
                                                    
                                                </div>
                                            </div>

                                            
                                             <div class="box-body">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <table id="example1" class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>@sortablelink('banners_id', trans('labels.ID') )</th>
                                                                <th>@sortablelink('banners_title', trans('labels.Title') )</th>
                                                                <th>Qty</th>
                                                                <th>Price</th>
                                                                <th>Image</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($result['Abandoned_data'] as $row)
                                                                    <tr>
                                                                        <td>{{ $row->customers_basket_id }}</td>
                                                                        <td>{{ $row->products_name }}</td>
                                                                        <td>{{ $row->customers_basket_quantity}}</td>
                                                                        <td>{{ $row->price }}</td>
                                                                        <td><img src="{{ asset($row->image) }}" style="width: 100px;height: 100px;" /></td>
                                                                        <td><a  href="javascript:;" class="badge bg-red "><i class="fa fa-trash abandoned_cart" abandoned_cart_id="{{ $row->customers_basket_id }}" aria-hidden="true"></i></a></td>
                                                                    </tr>
                                                                    @endforeach
                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <!-- /.box-body -->
                                            <div class="box-footer text-right">
                                                <div class="col-sm-offset-2 col-md-offset-3 col-sm-10 col-md-4">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/languages/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                                </div>
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
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
