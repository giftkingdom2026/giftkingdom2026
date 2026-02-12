@extends('admin.layout')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Discount Products<small>Listing All Discount Products...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.Products') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- <div class="box-header"> -->

                            <!-- <div CLASS="col-lg-12"> <h7 style="font-weight: bold; padding:0px 16px; float: left;">{{ trans('labels.FilterByCategory/Products') }}:</h7>

                                <br> -->
                           <!-- <div class="col-lg-10 form-inline">

                                <form  name='registration' id="registration" class="registration" method="get">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <div class="input-group-form search-panel ">
                                        <select id="FilterBy" type="button" class="btn btn-default dropdown-toggle form-control input-group-form " data-toggle="dropdown" name="categories_id">

                                            <option value="" selected disabled hidden>{{trans('labels.ChooseCategory')}}</option>
                                            @foreach ($results['subCategories'] as  $key=>$subCategories)
                                                <option value="{{ $subCategories->id }}"
                                                        @if(isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id']))
                                                          @if( $subCategories->id == $_REQUEST['categories_id'])
                                                            selected
                                                          @endif
                                                        @endif
                                                >{{ $subCategories->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="product" placeholder="Search term..." id="parameter"  @if(isset($product)) value="{{$product}}" @endif />
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(isset($product,$categories_id))  <a class="btn btn-danger " href="{{url('admin/products/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/products/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                            </div> -->

                            
                        
                        <!-- </div> -->

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-tools pull-right">
                                        <a href="{{ URL::to('admin/products/bulk/products/discount') }}" style="margin-bottom:10px" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ trans('labels.AddNew') }}</a>
                                    </div>
                                     <div class="box-tools pull-left">
                                        <a style="margin-bottom:10px" type="button" class="btn btn-block btn-primary " id="deleteDiscountProductId2"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="display table table-bordered table-striped " style="width:100%">
                                        <!-- <thead>
                                            <tr>
                                                <th>@sortablelink('products_id', trans('labels.ID') )</th>
                                                <th>{{ trans('labels.Image') }}</th>
                                                <th>@sortablelink('categories_name', trans('labels.Category') )</th>
                                                <th>@sortablelink('products_name', trans('labels.Name') )</th>
                                                <th>Product Price</th>
                                                <th>After Discount</th>
                                                <th>{{ trans('labels.Additional info') }}</th>
                                                <th>@sortablelink('created_at', trans('labels.ModifiedDate') )</th>
                                                <th></th>
                                            </tr>
                                        </thead> -->
                                        <thead>
                                            <tr>
                                                <th>{{ trans('labels.ID') }}</th>
                                                <!-- <th>{{ trans('labels.Image') }}</th> -->
                                                <th>{{ trans('labels.Name') }}</th>
                                                <th>{{ trans('labels.Category') }}</th>
                                                <th>Actual Price</th>
                                                <th>Discount Amount</th>
                                                <th>Discounted Price</th>
                                                <!-- <th>{{ trans('labels.Additional info') }}</th> -->
                                                <th>Expire Date</th>
                                                <th>Action</th>
                                                <!-- <th></th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php  $resultsProduct = $results['products']->unique('products_id')->keyBy('products_id');  @endphp
                                            @foreach ($resultsProduct as  $key=>$product)
                                                <tr>
                                                    <td><input type="checkbox" name="delete_special_product" value="{{ $product->specials_id }}" class="delete_special_product">{{ $product->products_id }}</td>
                                                    <td>{{ $product->products_name }}</td>
                                                    <td>{{ $product->categories_name }}</td>
                                                    <td>{{$product->products_price}}</td>
                                                    <td>@if($product->discount_type == 1 ){{$product->discount}}{{'%'}}@else{{'AED'}}{{$product->discount}}@endif</td>
                                                    <td>{{ $product->specials_products_price}}</td>
                                                    <td>{{  date('d-m-Y', $product->expires_date) }}</td>
                                                      <td><a data-toggle="tooltip" data-placement="bottom" title="" id="deleteDiscountProductId" products_id="{{ $product->specials_id }}" class="badge bg-red" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                      <!-- <td></td> -->
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>{{ trans('labels.ID') }}</th>
                                                <th>{{ trans('labels.Image') }}</th>
                                                <th>{{ trans('labels.Category') }}</th>
                                                <th>{{ trans('labels.Name') }}</th>
                                                <th>Discount Type</th>
                                                <th>Product Price</th>
                                                <th>After Discount</th>
                                                <th>{{ trans('labels.Additional info') }}</th>
                                                <th>{{ trans('labels.ModifiedDate') }}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot> -->
                                    </table>
                                </div>
                            </div>
                                <!-- <div class="col-xs-12" style="background: #eee;">


                                  @php
                                    if($results['products']->total()>0){
                                      $fromrecord = ($results['products']->currentpage()-1)*$results['products']->perpage()+1;
                                    }else{
                                      $fromrecord = 0;
                                    }
                                    if($results['products']->total() < $results['products']->currentpage()*$results['products']->perpage()){
                                      $torecord = $results['products']->total();
                                    }else{
                                      $torecord = $results['products']->currentpage()*$results['products']->perpage();
                                    }

                                  @endphp
                                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                                    <div>Showing {{$fromrecord}} to {{$torecord}}
                                        of  {{$results['products']->total()}} entries
                                    </div>
                                  </div>
                                <div class="col-xs-12 col-md-6 text-right">
                                    {{$results['products']->links()}}
                                </div>
                              </div> -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>

            <!-- deleteDiscountProductModal -->
            <div class="modal fade" id="deleteDiscountProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteDiscountProductModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteDiscountProductModalLabel">{{ trans('labels.DeleteProduct') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/products/bulk/products/discount/delete', 'name'=>'deleteDisProduct', 'id'=>'deleteDisProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('products_id',  '', array('class'=>'form-control', 'id'=>'products_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteThisProductDiloge') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteDiscountProduct">{{ trans('labels.DeleteProduct') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteDiscountProductModal2" tabindex="-1" role="dialog" aria-labelledby="deleteDiscountProductModalLabel2">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteDiscountProductModalLabel2">{{ trans('labels.DeleteProduct') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/products/bulk/products/discount/delete', 'name'=>'deleteDisProduct', 'id'=>'deleteDisProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        <div class="delete_special_product_div">
                            
                        </div>
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteThisProductDiloge') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteDiscountProduct2">{{ trans('labels.DeleteProduct') }}</button>
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
@endsection
