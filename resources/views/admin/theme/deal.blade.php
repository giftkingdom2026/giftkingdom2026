@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Deal <small>Deal...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">Deal</li>
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
                        <h3 class="box-title">Deal </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                        <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit News</h3>
                                      </div>-->
                                      <!-- /.box-header -->
                                      <!-- form start -->
                                      <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-success" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                            {{ $error }}
                                        </div>
                                        @endforeach
                                        @endif

                                        {!! Form::open(array('url' =>'admin/deal/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        
                                    <div class="col-md-6">
                                            @foreach($result['offer']['description'] as $description_data)
                                        <div class="form-group">
                                            <label for="name" class="control-label">Deal Title ({{ $description_data['language_name'] }})</label>

                                            <input id="editor<?=$description_data['languages_id']?>" name="title_<?=$description_data['languages_id']?>" class="form-control field-validate"  value="{{stripslashes($description_data['title'])}}" />
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Top Offer Text') }} ({{ $description_data['language_name'] }})</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                        </div>
                                        @endforeach

                                         <div class="form-group">
                                            <label for="name" class="control-label">Old Price</label>

                                            <input name="old_price" class="form-control field-validate" rows="10" cols="80" value="{{$description_data['old_price']}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Button Url</span>
                                            <span class="help-block hidden">Old Price</span>

                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">New Price</label>

                                            <input name="new_price" class="form-control field-validate" rows="10" cols="80" value="{{$description_data['new_price']}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Button Url</span>
                                            <span class="help-block hidden">New Price</span>

                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="control-label">Deal Button Url</label>

                                            <input name="url" class="form-control field-validate" rows="10" cols="80" value="{{$description_data['url']}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Button Url</span>
                                            <span class="help-block hidden">Button Url</span>

                                        </div>

                                        @foreach($result['offer']['description'] as $description_data)
                                        <div class="form-group">
                                            <label for="name" class="control-label">Deal Outline ({{ $description_data['language_name'] }})</label>

                                            <textarea id="editor<?=$description_data['languages_id']?>" name="text_<?=$description_data['languages_id']?>" class="form-control field-validate" rows="10" cols="80">{{stripslashes($description_data['text'])}}</textarea>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Top Offer Text') }} ({{ $description_data['language_name'] }})</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                        </div>
                                        @endforeach

                                        <div class="form-group">
                                            <label for="name" class="control-label">Deal Expiry Date</label>

                                            <input name="expiry_date" class="form-control field-validate" type="date" value="{{$description_data['expiry_date']}}">
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Expiry Date</span>
                                            <span class="help-block hidden">Expiry Date</span>

                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        

                                        <div class="form-group">
                                              <label for="name" class=" control-label">Image First</label>
                                              {{--{!! Form::file('newImage', array('id'=>'newImage')) !!}--}}

                                              <!-- Modal -->
                                              <div class="modal fade embed-images" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content">
                                                          <div class="modal-header">
                                                              <button type="button" class="close" data-dismiss="modal" id ="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                              <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Constant Image') }} </h3>
                                                          </div>
                                                          <div class="modal-body manufacturer-image-embed">
                                                              @if(isset($allimage))
                                                              <select class="image-picker show-html " name="image_id" id="select_img">
                                                                  <option  value=""></option>
                                                                  @foreach($allimage as $key=>$image)
                                                                  <option data-img-src="{{asset($image->path)}}"  class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                  @endforeach
                                                              </select>
                                                              @endif
                                                          </div>
                                                          <div class="modal-footer">
                                                            <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Add Icon') }}</a>
                                                            <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                            <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div  id ="imageselected">
                                              {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                              <div id="selectedthumbnailIcon" style="display:none" class="selectedthumbnail col-md-12"> </div>
                                              <div class="closimage">
                                                  <button type="button" class="close pull-left image-close " id="image-Icone"
                                                  style="display:none; position: absolute;left: -3px !important;top: 15px !important;background-color: black;color: white;opacity: 2.2;" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          {!! Form::hidden('oldImage', $description_data['image_id'], array('id'=>'oldImage')) !!}
                                          @if(($description_data['path1'] !== null))
                                          <img src="{{asset('').$description_data['path1']}}" class="">
                                          @else
                                          <img src="{{asset('').$description_data['path1']}}" class="">
                                          @endif
                                      </div>
                                  </div>

                                  <div class="form-group" id="imageIcone4">
                                    <label for="name" class="control-label">Image Second</label>
                                    <!-- Modal -->
                                    <div class="modal fade embed-images" id="ModalmanufacturedICone4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal2" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h3 class="modal-title text-primary" id="myModalLabel3">{{ trans('labels.Choose Image') }} </h3>
                                                </div>
                                                <div class="modal-body manufacturer-image-embed">
                                                    @if(isset($allimage))
                                                    <select class="image-picker show-html " name="image_id3" id="select_img">
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
                                                    <button type="button" class="btn btn-success" id="selectedICONE4" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="imageselected">
                                      {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon4','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone4" )) !!}
                                      <br>
                                      <div id="selectedthumbnailIcon4" class="selectedthumbnail col-md-5"> </div>
                                      <div class="closimage">
                                          <button type="button" class="close pull-left image-close " id="image-Icone4"
                                          style="display: none; position: absolute;left: -3px !important; top: 15px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  {!! Form::hidden('oldImage3', $description_data['image_id3'], array('id'=>'oldImage')) !!}
                                  @if(($description_data['path3'] !== null))
                                  <img src="{{asset('').$description_data['path3']}}" class="">
                                  @else
                                  <img src="{{asset('').$description_data['path3']}}" class="">
                                  @endif
                              </div>
                              <br>
                          </div>

                                        
                        </div>
              </div>
          </div>
        
      </div> 
  </div>
</div>
<!-- /.box-body -->
<div class="box-footer text-center">
    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
    <a href="{{ URL::to('admin/news/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
