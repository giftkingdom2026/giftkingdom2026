@extends('admin.layout')
@section('content')
<div class="content-wrapper content-wrapper1">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Conditions<small>Add Condition...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/condition/display')}}"><i class="fa fa-database"></i>Conditions</a></li>
            <li class="active">Add Condition</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.Addcondition') }} </h3>
                    </div> -->

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <br>
                                    @if (count($errors) > 0)
                                    @if($errors->any())
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                    @endif
                                    @endif
                                    <div class="box-body">

                                        {!! Form::open(array('url' =>'admin/condition/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Condition</label>

                                                <select class="form-control" name="parent_id">
                                                    {{print_r($result['condition'])}}
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                Choose Main Condition</span>

                                            </div>

                                            <!-- <div class="form-group">
                                                <label for="name" class="control-label">Sort Order<span style="color:red;">*</span> </label>

                                                <input name="sort_order" class="form-control ">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                Sort Order.</span>
                                                <span class="help-block hidden">Sort Order</span>

                                            </div> -->
                                        </div>

                                        <div class="col-md-6">
                                         @foreach($result['languages'] as $languages)
                                         <div class="form-group">
                                            <label for="name" class="control-label">{{ trans('labels.Name') }}<span style="color:red;">*</span> ({{ $languages->name }})</label>
                                            
                                            <input name="conditionName_<?=$languages->languages_id?>" class="form-control field-validate">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                Sub condition name ({{ $languages->name }}).</span>
                                                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                            </div>
                                            @endforeach 

                                            <!-- <div class="form-group">
                                              <label for="name" class="control-label">{{ trans('labels.Status') }} </label>

                                              <select class="form-control" name="condition_status">
                                                  <option value="1">{{ trans('labels.Active') }}</option>
                                                  <option value="0">{{ trans('labels.Inactive') }}</option>
                                              </select>
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                              {{ trans('labels.GeneralStatusText') }}</span>

                                          </div> -->
                                          <input type="hidden" name="condition_status" value="1">
                                      </div>

                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer text-center">
                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                    <a href="{{ URL::to('admin/condition/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                </div>
                <!-- /.box-footer -->
                {!! Form::close() !!}
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
