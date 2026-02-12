@extends('admin.layout')
@section('content')
<style type="text/css">
  .checkbox-label .ball {
    background-color: #CCCCCC;
    width: 24px;
    height: 24px;
    position: absolute;
    z-index: 1;
    left: 1px;
    top: 1px;
    border-radius: 50%;
    transition: transform 0.2s linear;
}
span.ball.active {
    transform: translateX(22px);
    background-color: #058ACA;
}label.checkbox-label {
    border: 1px solid #C5C1C1;
    position: relative;
    padding: 0.8rem 1.5rem;
    border-radius: 1rem;
    float: right;
}.checkbox-label + input {
    position: absolute;
    opacity: 0;
    z-index: -1;
}
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Store <small>Listin Store...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">Store</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->

    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <!-- <div class="box-header" style="margin-bottom: 20px;">
            <div class="box-tools pull-right">
              <a href="{{asset('/admin/addstoreimage')}}" class="btn btn-primary">Add New</a>
            </div>
          </div> -->

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th>Name</th>
                      <th>{{ trans('labels.Image') }}</th>
                      <th>status</th>
                      <th>{{trans('labels.Action')}}</th>
                                          
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($result['store'])>0)
                    @foreach ($result['store'] as $key=>$store)
                    <tr>
                      <td>{{ $store->id }}</td>
                      <td>{{ $store->name }}</td>
                      <td><img src="{{asset('').$store->banner_image}}" alt="" width="100px"></td>
                      <td>
                          <label for="dashboardcheck" class="checkbox-label change_status">
                        <a href="{{asset('admin/stores/status/update'.'/'.$store->id)}}">
                            <span class="ball {{ $store->status == 1 ? 'active' : '' }}" ></span>
                        </a>
                          </label>
                        <input type="checkbox" name="dashboardcheck" id="dashboardcheck" style="display: none;">
                      </td>
                      <td>
                       <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteSliderId" sliders_id ="{{ $store->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                     </td>
                   </tr>
                    @endforeach
                    @else
                       <tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                    @endif
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$result['store']->links('vendor.pagination.default')}}
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

    <!-- deleteSliderModal -->
	<div class="modal fade" id="deleteSliderModal" tabindex="-1" role="dialog" aria-labelledby="deleteSliderModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteSliderModalLabel">{{ trans('labels.DeleteSlider') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deletestore', 'name'=>'deleteSlider', 'id'=>'deleteSlider', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('mob_banner_id',  '', array('class'=>'form-control', 'id'=>'sliders_id')) !!}
		  <div class="modal-body">
			  <p>{{ trans('labels.DeleteSliderText') }}</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary" id="deleteSlider">{{ trans('labels.Delete') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
