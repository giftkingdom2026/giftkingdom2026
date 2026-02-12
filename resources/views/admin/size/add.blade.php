@extends('admin.layout')
@section('content')
<div class="content-wrapper content-wrapper1">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Sizes<small>Add Size...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/size/display')}}"><i class="fa fa-database"></i>Size</a></li>
            <li class="active">Add Size</li>
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
                        <h3 class="box-title">{{ trans('labels.Addsize') }} </h3>
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
                                        <div class="col-md-6">
                                            {!! Form::open(array('url' =>'admin/size/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            <div class="form-group">
                                                <label for="name" class="control-label">size</label>
                                                <select class="form-control" name="parent_id">
                                                    {{print_r($result['size'])}}
                                                </select>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                Choose Main size</span>
                                            </div>

                                            @foreach($result['languages'] as $languages)
                                            <div class="form-group">
                                                <label for="name" class="control-label">{{ trans('labels.Name') }}<span style="color:red;">*</span> ({{ $languages->name }})</label>
                                                <input name="sizeName_<?=$languages->languages_id?>" class="form-control field-validate">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.SubsizeName') }} ({{ $languages->name }}).</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                                @endforeach

                                                <!-- <div class="form-group">
                                                    <label for="name" class="control-label">Sort Order<span style="color:red;">*</span> </label>
                                                    <input name="sort_order" class="form-control ">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    Sort Order.</span>
                                                    <span class="help-block hidden">Sort Order</span>
                                                </div> -->

                                                <!-- <div class="form-group" id="imageselected">
                                                    <label for="name" class="control-label">{{ trans('labels.Image') }}<span style="color:red;">*</span></label>
                                                    {{--{!! Form::file('newImage', array('id'=>'newImage')) !!}--}}
                                                   
                                                    <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                                </div>
                                                                <div class="modal-body manufacturer-image-embed">
                                                                    @if(isset($allimage))
                                                                    <select class="image-picker show-html field-validate" name="image_id" id="select_img">
                                                                        <option value=""></option>
                                                                        @foreach($allimage as $key=>$image)
                                                                        <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer">
                                                                 <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                                 <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                 <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div id="imageselected">
                                                    {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                                    <br>
                                                    <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                    <div class="closimage">
                                                        <button type="button" class="close pull-left image-close " id="image-close"
                                                        style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">size Image</span>
                                        </div> -->

                                       <!--  <div class="form-group" id="imageIcone2">
                                            <label for="name" class="control-label">Banner Image</label>
                                            <div class="modal fade" id="ModalmanufacturedICone2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                        </div>
                                                        <div class="modal-body manufacturer-image-embed">
                                                            @if(isset($allimage))
                                                            <select class="image-picker show-html" name="image_icone2" id="select_img">
                                                                <option value=""></option>
                                                                @foreach($allimage as $key=>$image)
                                                                <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                @endforeach
                                                            </select>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                          <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                          <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                          <button type="button" class="btn btn-primary" id="selectedICONE2" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div id="imageselected">
                                              {!! Form::button(trans('labels.Add Image'), array('id'=>'newIco2n','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone2" )) !!}
                                              <br>
                                              <div id="selectedthumbnailIcon2" class="selectedthumbnail col-md-5"> </div>
                                              <div class="closimage">
                                                  <button type="button" class="close pull-left image-close " id="image-Icone2"
                                                  style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                      </div> -->
                                      <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Banner Image</span> -->
                                  <!-- </div> -->


                              </div>



                              <div class="col-md-6">
                                @foreach($result['languages'] as $languages)

                                <!-- <div class="form-group">
                                    <label for="name" class="control-label">{{ trans('labels.Outline') }}({{ $languages->name }})</label>
                                    <textarea name="outline<?=$languages->languages_id?>" class="form-control field-validate"></textarea>
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        Outline  ({{ $languages->name }}).</span>
                                        <span class="help-block hidden">Outline </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="control-label">{{ trans('labels.Description') }}({{ $languages->name }})</label>
                                        <textarea name="description<?=$languages->languages_id?>" class="form-control field-validate"></textarea>
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            Sub size Description  ({{ $languages->name }}).</span>
                                            <span class="help-block hidden">Sub size Description </span>
                                        </div> -->
                                        @endforeach

                                        <!-- <div class="form-group">
                                          <label for="name" class="control-label">{{ trans('labels.Status') }} </label>
                                          <select class="form-control" name="size_status">
                                              <option value="1">{{ trans('labels.Active') }}</option>
                                              <option value="0">{{ trans('labels.Inactive') }}</option>
                                          </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.GeneralStatusText') }}</span>
                                      </div> -->

                                      <input type="hidden" name="size_status" value="1">

                                  </div>






                                        <!-- <div class="form-group" id="imageIcone">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Icon') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                <div class="modal fade" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                              </div>
                                                            <div class="modal-body manufacturer-image-embed">
                                                                @if(isset($allimage))
                                                                <select class="image-picker show-html" name="image_icone" id="select_img">
                                                                    <option value=""></option>
                                                                    @foreach($allimage as $key=>$image)
                                                                      <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                    @endforeach
                                                                </select>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                              <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Image') }}</a>
                                                              <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                              <button type="button" class="btn btn-primary" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="imageselected">
                                                  {!! Form::button(trans('labels.Add Icon'), array('id'=>'newIcon','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )) !!}
                                                  <br>
                                                  <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5"> </div>
                                                  <div class="closimage">
                                                      <button type="button" class="close pull-left image-close " id="image-Icone"
                                                        style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                </div>
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.sizeIconText') }}</span>

                                            </div>
                                        </div> -->


                                        


                                        




                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                        <a href="{{ URL::to('admin/size/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                    </div>
                                    <!-- /.box-footer -->
                                    {!! Form::close() !!}
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
