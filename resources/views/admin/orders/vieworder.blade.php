@extends('admin.layout')
@section('content')

<div class="content-wrapper content-wrapper1">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.ViewOrder') }} <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/orders/display')}}"><i class="fa fa-dashboard"></i>  {{ trans('labels.ListingAllOrders') }}</a></li>
      <li class="active"> {{ trans('labels.ViewOrder') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="invoice" style="margin: 15px;">
      <!-- title row -->
      @if(session()->has('message'))
       <div class="col-xs-12">
       <div class="row">
      	<div class="alert alert-success alert-dismissible">
           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
           <h4><i class="icon fa fa-check"></i> {{ trans('labels.Successlabel') }}</h4>
            {{ session()->get('message') }}
        </div>
        </div>
        </div>
        @endif
        @if(session()->has('error'))
        <div class="col-xs-12">
      	<div class="row">
        	<div class="alert alert-warning alert-dismissible">
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
               <h4><i class="icon fa fa-warning"></i> {{ trans('labels.WarningLabel') }}</h4>
                {{ session()->get('error') }}
            </div>
          </div>
         </div>
        @endif
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header" style="padding-bottom: 25px; margin-top:0;">
            <i class="fa fa-globe"></i> {{ trans('labels.OrderID') }}# {{ $data['orders_data'][0]->orders_id }}
            <small style="display: inline-block">{{ trans('labels.OrderedDate') }}: {{ date('d/m/Y', strtotime($data['orders_data'][0]->date_purchased)) }}</small>
            <a href="{{ URL::to('admin/orders/invoiceprint/'.$data['orders_data'][0]->orders_id)}}" target="_blank"  class="btn btn-default pull-right"><i class="fa fa-print"></i> Print Invoice</a>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <div class="orderWrp">
          <h3>{{ trans('labels.CustomerInfo') }}</h3>

          <address>
         
            <ul>
              @if(isset($data['orders_data'][0]->customer_data) && !empty($data['orders_data'][0]->customer_data))
               <li><strong>Name: </strong>{{ $data['orders_data'][0]->customer_data->first_name }}</li>
              @else
               <li><strong>Name: </strong>{{ $data['orders_data'][0]->billing_name }}</li>
              @endif
              @if(isset($data['orders_data'][0]->customer_data) && !empty($data['orders_data'][0]->customer_data))
              <li><strong>Address: </strong>{{ $data['orders_data'][0]->customer_data->address }}</li>

              <li><strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->customer_data->phone }}</li>

              @else

              <li><strong>Address: </strong>{{ $data['orders_data'][0]->billing_street_address }} @if(!empty($data['orders_data'][0]->billing_street_2)) ,{{$data['orders_data'][0]->billing_street_2}} @endif</li>

              <li><strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->billing_phone }}</li>

              @endif

              <li><strong>{{ trans('labels.Email') }}: </strong>{{ $data['orders_data'][0]->email }}</li>
              

              
            </ul>
          </address>
        </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <div class="orderWrp">
          <h3>{{ trans('labels.ShippingInfo') }}</h3>
          <address><ul>
              <li><strong>Name: </strong>{{ $data['orders_data'][0]->delivery_name }}</li>
              <li><strong>Address: </strong>{{ $data['orders_data'][0]->delivery_street_address }}@if(!empty($data['orders_data'][0]->delivery_city2)) , {{ $data['orders_data'][0]->delivery_city2 }} @endif @if(!empty($data['orders_data'][0]->delivery_country)) , {{ $data['orders_data'][0]->delivery_country }} @endif
                @if(!empty($data['orders_data'][0]->shipping_street_2)) ,{{$data['orders_data'][0]->shipping_street_2}} @endif</li>
              <li><strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->delivery_phone }}</li>
              
              <li><strong>{{ trans('labels.ShippingCost') }}: </strong>@if(!empty($data['orders_data'][0]->shipping_cost)) 
           @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->shipping_cost }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
            @else --- @endif </li>
            </ul>
          </address>
        </div>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <div class="orderWrp">
         <h3>{{ trans('labels.BillingInfo') }}</h3>
          <address>

            <ul>
              <li><strong>Name: </strong>{{ $data['orders_data'][0]->billing_name }}</li>
              <li><strong>Address: </strong>{{ $data['orders_data'][0]->billing_street_address }} @if(!empty($data['orders_data'][0]->billing_street_2)) ,{{$data['orders_data'][0]->billing_street_2}} @endif
              </li>
              <li><strong>{{ trans('labels.Phone') }}: </strong>{{ $data['orders_data'][0]->billing_phone }}</li>
              
            </ul>
          </address>
        </div>
        </div>
        

        
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>{{ trans('labels.Qty') }}</th>
              <th>{{ trans('labels.Image') }}</th>
              <th>{{ trans('labels.ProductName') }}</th>
              
              <th>{{ trans('labels.Price') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data['orders_data'][0]->data as $products)
            <tr>
                <td>{{  $products->products_quantity }}</td>
                <td >
                   <img src="{{ asset('').$products->image }}" width="60px"> <br>
                </td>
                <td  width="30%">
                    {{  $products->products_name }}<br>
                </td>

                <td>
                  
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $products->final_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif<br>
                  </td>
             </tr>
            @endforeach

            </tbody>
          </table>
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-7">
          <p class="lead" style="margin-bottom:10px">{{ trans('labels.PaymentMethods') }}:</p>
          <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize">
           	{{ str_replace('_',' ', $data['orders_data'][0]->payment_method) }}
          </p>
          @if($data['orders_data'][0]->payment_method != 'Cash on Delivery')
              <p class="lead" style="margin-bottom:10px">Transaction Id:</p>
              <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize">
                {{ str_replace('_',' ', $data['orders_data'][0]->transaction_id) }}
              </p>
                <p class="lead" style="margin-bottom:10px">Bank Ref No:</p>
              <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize">
                {{ str_replace('_',' ', $data['orders_data'][0]->bank_ref_no) }}
              </p>
          @endif
          <p class="lead" style="margin-bottom:10px">Way To Recived:</p>
          <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize">
            {{ $data['orders_data'][0]->way_to_recived }}
          </p>
          @if(!empty($data['orders_data'][0]->coupon_code))
              <p class="lead" style="margin-bottom:10px">{{ trans('labels.Coupons') }}:</p>
                <table class="text-muted well well-sm no-shadow stripe-border table table-striped" style="text-align: center; ">
                	<tr>
                        <th style="text-align: center; ">{{ trans('labels.Code') }}</th>
                        <th style="text-align: center; ">{{ trans('labels.Amount') }}</th>
                    </tr>
                	@foreach( json_decode($data['orders_data'][0]->coupon_code) as $couponData)
                    	<tr>
                        	<td>{{ $couponData->code}}</td>
                            <td>{{ $couponData->amount}}

                                @if($couponData->discount_type=='percent_product')
                                    ({{ trans('labels.Percent') }})
                                @elseif($couponData->discount_type=='percent')
                                    ({{ trans('labels.Percent') }})
                                @elseif($couponData->discount_type=='fixed_cart')
                                    ({{ trans('labels.Fixed') }})
                                @elseif($couponData->discount_type=='fixed_product')
                                    ({{ trans('labels.Fixed') }})
                                @endif
                            </td>
                        </tr>
                    @endforeach
				</table>
               <!-- {{ $data['orders_data'][0]->coupon_code }}-->

          @endif
       
          <!-- @if(!empty($data['orders_data'][0]->order_information))
		  <p class="lead" style="margin-bottom:10px">{{ trans('labels.Orderinformation') }}:</p>
          <p class="text-muted well well-sm no-shadow" style="text-transform:capitalize; word-break:break-all;">
           @if(trim($data['orders_data'][0]->order_information) != '[]' or !empty($data['orders_data'][0]->order_information))
           		{{ $data['orders_data'][0]->order_information }}
           @endif
          </p>
          @endif -->
        </div>
        <!-- /.col -->
        <div class="col-xs-5">
          <!--<p class="lead"></p>-->

          <div class="table-responsive ">
            <table class="table order-table">
              <tr>
                <th style="width:50%">{{ trans('labels.Subtotal') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif 
                  {{ number_format($data['subtotal'], 2) }}
                  @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                  </td>
              </tr>
              <!-- <tr>
                <th>{{ trans('labels.Tax') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->total_tax }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                  </td>
              </tr> -->
              <tr>
                <th>{{ trans('labels.ShippingCost') }}:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->shipping_cost }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}}@endif
                  </td>
              </tr>

              <tr>
                <th>VAT:</th>
                <td>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $data['orders_data'][0]->total_tax }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}}@endif
                  </td>
              </tr>

              
              <tr>
                <th>Coupon Discount:</th>
                <td>                  
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ number_format((float)($data['orders_data'][0]->coupon_amount), 2, '.', '') }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
              </tr>
            
              <tr>
                <th>Delivery Charges:</th>
                <td>                  
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ number_format((float)($data['orders_data'][0]->cash_on_delivery), 2, '.', '') }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif</td>
              </tr>

              <tr>
                <th>Grand Total:</th>
                <td>
                  <?php $total= $data['subtotal']+ $data['orders_data'][0]->shipping_cost + $data['orders_data'][0]->total_tax+$data['orders_data'][0]->cash_on_delivery - $data['orders_data'][0]->coupon_amount; ?>
                  @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif
                   {{ number_format((float)($total), 2, '.', '') }}
                    @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                  </td>
              </tr>
            </table>
          </div>

        </div>
        
    {!! Form::open(array('url' =>'admin/orders/updateOrder', 'method'=>'post', 'onSubmit'=>'return cancelOrder();', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
     {!! Form::hidden('orders_id', $data['orders_data'][0]->orders_id, array('class'=>'form-control', 'id'=>'orders_id'))!!}
     {!! Form::hidden('old_orders_status', $data['orders_data'][0]->orders_status_id, array('class'=>'form-control', 'id'=>'old_orders_status'))!!}
     {!! Form::hidden('customers_id', $data['orders_data'][0]->customers_id, array('class'=>'form-control', 'id'=>'device_id')) !!}
        <div class="col-xs-12">
        <hr>
          <p class="lead">{{ trans('labels.ChangeStatus') }}:</p>

            <div class="col-md-12">
              <div class="form-group">
                <label>{{ trans('labels.PaymentStatus') }}:</label>
                <select class="form-control select2" id="status_id" name="orders_status" style="width: 100%;">

               	 @foreach( $data['orders_status'] as $orders_status)
                  <option value="{{ $orders_status->orders_status_id }}" @if( $data['orders_data'][0]->orders_status_id == $orders_status->orders_status_id) selected="selected" @endif >{{ $orders_status->orders_status_name }}</option>
                 @endforeach
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseStatus') }}</span>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Shipping Status:</label>
                <select class="form-control select2" id="shipping_status" name="shipping_status" style="width: 100%;">
                  <option value="0" @if($data['orders_data'][0]->shipping_status=="0") selected @endif>Not Shipped</option>
                  <option value="1" @if($data['orders_data'][0]->shipping_status=="1") selected @endif>Shipped</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseStatus') }}</span>
              </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                <label>{{ trans('labels.Comments') }}:</label>
                {!! Form::textarea('comments',  '', array('class'=>'form-control', 'id'=>'comments', 'rows'=>'4'))!!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.CommentsOrderText') }}</span>
              </div>
            </div>
        </div>
         <!-- this row will not appear when printing -->
            <div class="col-xs-12">
              <a href="{{ URL::to('admin/orders/display')}}" class="btn btn-default"><i class="fa fa-angle-left"></i> {{ trans('labels.back') }}</a>
              <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> {{ trans('labels.Submit') }} </button>
              <!--<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-download"></i> Generate PDF
              </button>-->

         <br><br> <hr><br>

            </div>
          {!! Form::close() !!}

        <div class="col-xs-12">
          <p class="lead">{{ trans('labels.OrderHistory') }}</p>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ trans('labels.Date') }}</th>
                  <th>{{ trans('labels.Status') }}</th>
                  <th>{{ trans('labels.Comments') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $data['orders_status_history'] as $orders_status_history)
                    <tr>
                        <td>
							<?php
								$date = new DateTime($orders_status_history->date_added);
								$status_date = $date->format('d-m-Y');
								print $status_date;
							?>
                        </td>
                        <td>
                        	@if($orders_status_history->orders_status_id==1)
                            	<span class="label label-warning">
                            @elseif($orders_status_history->orders_status_id==2)
                                <span class="label label-success">
                            @elseif($orders_status_history->orders_status_id==3)
                                 <span class="label label-danger">
                            @else
                                 <span class="label label-primary">
                            @endif
                            {{ $orders_status_history->orders_status_name }}
                                 </span>
                        </td>
                        @if($orders_status_history->comments != '')
                          <td style="text-transform: initial;">{!! $orders_status_history->comments !!}</td>
                        @else
                          <td style="text-transform: initial;">No Comments</td>
                        @endif
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


    </section>
  <!-- /.content -->
</div>
@endsection
