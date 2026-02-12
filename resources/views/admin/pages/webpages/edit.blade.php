@extends('admin.layout')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.EditPage') }} <small>{{ trans('labels.EditPage') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/webpages')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.ListingAllPages') }}</a></li>
                <li class="active">{{ trans('labels.EditPage') }}</li>
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
                            <h3 class="box-title">{{ trans('labels.EditPage') }} </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                    <!--<div class="box-header with-border">
                          <h3 class="box-title">{{ trans('labels.EditPage') }}</h3>
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

                                            {!! Form::open(array('url' =>'admin/updatewebpage', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                            {!! Form::hidden('id',  $result['editPage'][0]->page_id, array('class'=>'form-control', 'id'=>'id')) !!}
<div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name" class="control-label">{{ trans('labels.PageSlug') }}</label>
                                                
                                                    {!! Form::text('slug',  $result['editPage'][0]->slug, array('class'=>'form-control field-validate', 'id'=>'slug')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.pageSlugWithDashesText') }}</span>
                                              
                                            </div>

                                            @foreach($result['description'] as $description_data)

                                                <div class="form-group">
                                                    <label for="name" class="control-label">{{ trans('labels.PageName') }} ({{ $description_data['language_name'] }}) </label>
                                                   
                                                        <input type="text" name="name_<?=$description_data['languages_id']?>" class="form-control field-validate" value="{{$description_data['name']}}" >
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.PageName') }} ({{ $description_data['language_name'] }})</span>

                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                
                                                </div>
                             

                                               

                                            @endforeach

                                           <div class="form-group">
                                                <label for="name" class="control-label">Has Banner</label>
                                              
                                                    <select name="has_banner" id="has_banner" class="form-control">
                                                        <option value="1"  @if($result['editPage'][0]->has_banner=='1') selected @endif>{{ trans('labels.Active') }}</option>
                                                        <option value="0"  @if($result['editPage'][0]->has_banner=='0') selected @endif>{{ trans('labels.InActive') }}</option>
                                                    </select>
                                             
                                            </div>

                                            <input type="hidden" name="status" value="1">

                                            
                                             <div class="form-group show-image" @if($result['editPage'][0]->has_banner=='0') style="display:none" @else style="display:block"
                                                @endif>
                                                <label for="name" class="control-label">{{ trans('labels.BannerImage') }} </label>
                                              

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                    <h3 class="modal-title text-primary" id="myModalLabel">Choose Image </h3>
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
                                                                    <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left">{{ trans('labels.Add Image') }}</a>
                                                                    <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                                    <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="imageselected">
                                                        {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                                        <br>
                                                        <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                                        <div class="closimage">
                                                            <button type="button" class="close pull-left image-close " id="image-close"
                                                              style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"></span>
                                              
                                            </div>

                                            <div class="form-group show-image">
                                                <label for="name" class="control-label"></label>
                                                
                                                    {!! Form::hidden('oldImage', $result['editPage'][0]->banner_image , array('id'=>'oldImage')) !!}
                                                    <img src="{{asset($result['editPage'][0]->path)}}" alt="" class="w-100">
                                              
                                            </div>

                                            
                                        </div>
                                        <div class="col-md-8">
                                        @foreach($result['description'] as $description_data)

                             

                                                <div class="form-group">
                                                    <label for="name" class="control-label">{{ trans('labels.Description') }} ({{ $description_data['language_name'] }})</label>
                                               
                                                        <!-- <div class="quilleditor" id="description_<?=$description_data['languages_id']?>" height="400">{!!$description_data['description']!!}</div> -->
                                                         <textarea id="editor_<?=$description_data['languages_id']?>" name="description_<?=$description_data['languages_id']?>" class="form-control"  rows="10" cols="80">{{stripslashes($description_data['description'])}}</textarea> 
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} ({{ $description_data['language_name'] }})</span>
                                                        <br>
                                             
                                                </div>

                                            @endforeach
                                        </div>
                                        </div>
                                        <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/webpages')}}" type="button" class="btn btn-default play">{{ trans('labels.back') }}</a>
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
    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    <script type="text/javascript">
        $(function () {

            //for multiple languages
            @foreach($result['languages'] as $languages)
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor_{{$languages->languages_id}}');

            @endforeach

            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();

        });

    </script>

    <script>
        
        $("#has_banner").on("change", function() {
            // Get the selected option value
            const selectedOption = $(this).val();

            
            if (selectedOption === "1") {
                $(".show-image").show(); 
            } else {
                $(".show-image").hide(); 
            }
        });
    </script>
@endsection