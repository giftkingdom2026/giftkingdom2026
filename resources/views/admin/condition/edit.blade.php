@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit Condition <small>Edit condition...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/condition/display')}}"><i class="fa fa-database"></i> Condition</a></li>
            <li class="active">Edit condition</li>
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
                        <h3 class="box-title">Edit Condition </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <br>
                                    @if (count($errors) > 0)
                                    @if($errors->any())
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$errors->first()}}
                                  </div>
                                  @endif
                                  @endif
                                  <!-- /.box-header -->
                                  <!-- form start -->
                                  <div class="box-body">
                                    {!! Form::open(array('url' =>'admin/condition/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                    {!! Form::hidden('id', $result['editSubcondition'][0]->id , array('class'=>'form-control', 'id'=>'id')) !!}
                                    {!! Form::hidden('oldImage', $result['editSubcondition'][0]->image , array('id'=>'oldImage')) !!}

                                    <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="name" class="control-label">Condition</label>

                                        <select class="form-control" name="parent_id">
                                            {{print_r($result['condition'])}}
                                        </select>
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Choose Main Condition</span>

                                    </div> 

                                    <div class="form-group">
                                        <label for="name" class="control-label">{{ trans('labels.slug') }} </label>

                                        <input type="hidden" name="old_slug" value="{{$result['editSubcondition'][0]->slug}}">
                                        <input type="text" name="slug" class="form-control field-validate" value="{{$result['editSubcondition'][0]->slug}}">
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.slugText') }}</span>
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                    </div>

                                   <!--  <div class="form-group">
                                      <label for="name" class="control-label">{{ trans('labels.Status') }} </label>

                                      <select class="form-control" name="condition_status">
                                          <option value="1" @if($result['editSubcondition'][0]->condition_status=='1') selected @endif>{{ trans('labels.Active') }}</option>
                                          <option value="0" @if($result['editSubcondition'][0]->condition_status=='0') selected @endif>{{ trans('labels.Inactive') }}</option>
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.GeneralStatusText') }}</span>

                                  </div> -->

                                  <input type="hidden" name="condition_status" value="1">
                              </div>

                              <div class="col-md-6">
                                @foreach($result['description'] as $description_data)
                                <div class="form-group">
                                    <label for="name" class="control-label">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }})</label>

                                    <input type="text" name="condition_name_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Condition name  ({{ $description_data['language_name'] }}).</span>
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                </div>
                                @endforeach
<!-- 
                                <div class="form-group">
                                    <label for="name" class="control-label">Sort Order<span style="color:red;">*</span> </label>

                                    <input name="sort_order" class="form-control " value="{{$result['editSubcondition'][0]->sort_order}}">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    Sort Order.</span>
                                    <span class="help-block hidden">Sort Order</span>

                                </div> -->
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
    </div>
</div>


</div>
<!-- /.box-body -->

<!-- /.box -->

<!-- /.col -->

<!-- /.row -->

<!-- Main row -->

<!-- /.row -->
</section>
<!-- /.content -->
</div>
@endsection
