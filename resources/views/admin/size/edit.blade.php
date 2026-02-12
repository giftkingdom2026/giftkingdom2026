@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Size <small>Edit Size...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/size/display')}}"><i class="fa fa-database"></i> size</a></li>
            <li class="active">Edit Size</li>
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
                        <h3 class="box-title">Edit size</h3>
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
                                    {!! Form::open(array('url' =>'admin/size/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                    {!! Form::hidden('id', $result['editSubsize'][0]->id , array('class'=>'form-control', 'id'=>'id')) !!}
                                    {!! Form::hidden('oldImage', $result['editSubsize'][0]->image , array('id'=>'oldImage')) !!}


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="control-label">size</label>
                                            <select class="form-control" name="parent_id">
                                                {{print_r($result['size'])}}
                                            </select>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Choose Main size</span>
                                        </div>

                                        @foreach($result['description'] as $description_data)
                                        <div class="form-group">
                                            <label for="name" class="control-label">{{ trans('labels.Name') }} ({{ $description_data['language_name'] }})</label>
                                            <input type="text" name="size_name_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.sizeName') }} ({{ $description_data['language_name'] }}).</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                        </div>
                                        @endforeach

                                        <div class="form-group">
                                            <label for="name" class="control-label">{{ trans('labels.slug') }} </label>
                                            <input type="hidden" name="old_slug" value="{{$result['editSubsize'][0]->slug}}">
                                            <input type="text" name="slug" class="form-control field-validate" value="{{$result['editSubsize'][0]->slug}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.slugText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                        </div>

                                       <!--  <div class="form-group">
                                            <label for="name" class="control-label">Sort Order<span style="color:red;">*</span> </label>
                                            <input name="sort_order" class="form-control " value="{{$result['editSubsize'][0]->sort_order}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            Sort Order.</span>
                                            <span class="help-block hidden">Sort Order</span>
                                        </div> -->

                                        <!-- <div class="form-group">
                                            <label for="name" class="control-label">{{ trans('labels.Image') }}</label>
                                            <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                            <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                        </div>
                                                        <div class="modal-body manufacturer-image-embed">
                                                            @if(isset($allimage))
                                                            <select class="image-picker show-html " name="image_id" id="select_img">
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
                                                          <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                          <br>
                                          <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                          <div class="closimage">
                                              <button type="button" class="close pull-left image-close " id="image-close"
                                              style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Upload size Image</span>
                                  </div> -->

                                  <!-- <div class="form-group">
                                    <label for="name" class="control-label"></label>
                                    <span class="help-block " style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>
                                    <br>
                                    <img src="{{asset($result['editSubsize'][0]->imgpath)}}" alt="" width=" 100px">
                                </div> -->


                                <!-- <div class="form-group" id="imageIcone2">
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
                                                    <select class="image-picker show-html " name="image_icone2" id="select_img">
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
                                                  <button type="button" class="btn btn-primary" id="selectedICONE2" data-dismiss="modal">Done</button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div id="imageselected">
                                    {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon2','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone2" )) !!}
                                    <br>
                                    <div id="selectedthumbnailIcon2" class="selectedthumbnail col-md-5"> </div>
                                    <div class="closimage">
                                        <button type="button" class="close pull-left image-close " id="image-Icone2"
                                        style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div> -->
                            <!-- <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Upload Banner Image</span> -->
                        <!-- </div> -->
                        <!-- <div class="form-group">
                            <label for="name" class="control-label"></label>
                            <span class="help-block " style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>
                            <br>
                            <img src="{{asset($result['editSubsize'][0]->size_banner_path)}}" alt="" width=" 100px">
                        </div> -->

                    </div>




                    <div class="col-md-6">

                        @foreach($result['languages'] as $languages)
                       <!--  <div class="form-group">
                            <label for="name" class="control-label">{{ trans('labels.Outline') }}({{ $languages->name }})</label>
                            <textarea name="outline<?=$languages->languages_id?>" class="form-control field-validate">{{$description_data['outline']}}</textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                               Outline ({{ $languages->name }}).</span>
                               <span class="help-block hidden">Outline</span>
                           </div>

                           <div class="form-group">
                            <label for="name" class="control-label">{{ trans('labels.Description') }}({{ $languages->name }})</label>
                            <textarea name="description<?=$languages->languages_id?>" class="form-control field-validate">{{$description_data['description']}}</textarea>
                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                               Sub size Description ({{ $languages->name }}).</span>
                               <span class="help-block hidden">Sub size Description</span>
                           </div> -->
                           @endforeach

                               {!! Form::hidden('oldIcon2', $result['editSubsize'][0]->size_banner, array('id'=>'oldIcon2')) !!}


                                      <!--   <div class="form-group">
                                            <label for="name" class="control-label">{{ trans('labels.Status') }} </label>
                                        
                                            <select class="form-control" name="size_status">
                                              <option value="1" @if($result['editSubsize'][0]->size_status=='1') selected @endif>{{ trans('labels.Active') }}</option>
                                              <option value="0" @if($result['editSubsize'][0]->size_status=='0') selected @endif>{{ trans('labels.Inactive') }}</option>
                                          </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.GeneralStatusText') }}</span>
                                     
                                  </div> -->
                                  <input type="hidden" name="size_status" value="1">

                       </div>






                                        <!-- <div class="form-group">
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
                                                                <select class="image-picker show-html " name="image_icone" id="select_img">
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
                                                                <button type="button" class="btn btn-primary" id="selectedICONE" data-dismiss="modal">Done</button>
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
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadSubsizeIcon') }}</span>
                                            </div>
                                        </div> -->




                                        
                                    
                              </div>
                          </div>
                      </div>

                      
                </div>
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
