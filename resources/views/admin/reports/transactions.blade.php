@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Sales Report <small>Sales Report...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">Sales Report</li>
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
           
              <div class="row">
                <div class="col-md-12 form-inline">
                  <form method="post" action="{{URL::to('admin/transactions-report')}}">
                      @csrf
                    <div class="input-group-form search-panel">
                        <label>Start Date:</label>
                        <input type="date" name="start" class="form-control input-group-form ">
                        <label>End Date:</label>
                        <input type="date" name="end" class="form-control input-group-form ">
                        <input type="hidden" name="parent_id" value="" id="parent_id">
                        <label>By Type:</label>
                        <select name="reportBase" class="btn btn-default form-control input-group-form">
                          <option value="no">Select</option>
                          <option value="last_year">Last year</option>
                          <option value="last_month">Last Month</option>
                          <option value="this_month">This Month</option>
                        </select>
                        <input type="submit" name="bydate" class="btn btn-primary">
                    </div>
                  </form>
              </div>
             
                </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          
            <div class="row">
              <div class="col-xs-12">
                <table id="example1_wrapper" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>Transaction Id</th>
                      <th>Amount</th>
                      <th>Customer Name</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $g_total=0;?>
                    @foreach($saleData as $sale)
                      @foreach($sale['totalSale'] as $sale2)
                      <tr>
                        <td>{{$sale2->orders_id}}</td>
                        <td>
                          @if($sale2->transaction_id != null)
                            {{$sale2->transaction_id}}
                          @else
                            {{'Cash on Delivery'}}
                          @endif
                        </td>
                        <td>{{$sale2->order_price}}</td>
                        <td>{{$sale2->customers_name}}</td>
                        <td> @php
                              $date = new DateTime($sale2->created_at2);
                              $myDate = $date->format('d-m-Y');
                              print $myDate;
                            @endphp
                        </td>
                      </tr>
                      @endforeach
                    @endforeach
                    
                  </tbody>
                </table>
              </div>

            </div>
          </div>
         
        </div>
  
      </div>

    </div>

 
  </section>

</div>
@endsection
