@extends('admin.layout')

@section('content')

    <div class="content-wrapper content-wrapper1">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1> Add Seo<small>Adding Seo ...</small> </h1>

            <ol class="breadcrumb">

                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>

                <li><a href="{{ URL::to('admin/seo/display')}}"><i class="fa fa-dashboard"></i> Listing All Seo</a></li>

                <li class="active">Add Seo</li>

            </ol>

        </section>



        <!-- Main content -->

        <section class="content">

            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header">

                            <h3 class="box-title">Add Seo </h3>

                        </div>

                        <div class="box-body">

                            <div class="row">

                                <div class="col-xs-12">

                                    <div class="box box-info">



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



                                            {!! Form::open(array('url' =>'admin/seo/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                <label for="name" class="control-label text-start mb-2">Page Name</label>

                                                    <input type="text" name="page_name" class="form-control field-validate">

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                   Page Name</span>



                                                    <span class="help-block hidden">Page Name</span>

                                            </div>

                                                <div class="form-group">

                                                    <label for="name" class="control-label text-start mb-2">Meta Title</label>

                                                        <input type="text" name="meta_title" class="form-control field-validate">

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                               Title </span>

                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                                </div>

                                                

                                                <div class="form-group">

                                                    <label for="name" class="control-label text-start mb-2">Meta Keywords</label>

                                                        <input type="text" name="meta_keywords" class="form-control field-validate">

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                        Meta Keywords</span>

                                                        <span class="help-block hidden">Meta Keywords</span>

                                                </div>

                                                <div class="form-group">

                                                    <label for="name" class="control-label text-start mb-2">OG:Title</label>

                                                        <input type="text" name="og_title" class="form-control field-validate">

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                        OG:Title </span>

                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                                </div>

                                                <div class="form-group" id="imageIcone">

                                                <label for="name" class="control-label text-start mb-2">OG {{ trans('labels.Image') }}</label>

                                                    <!-- Modal -->

                                                    <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

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

                                                                    <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div id="imageselected">

                                                      {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )) !!}

                                                      <br>

                                                      <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5"> </div>

                                                      <div class="closimage">

                                                          <button type="button" class="close pull-left image-close " id="image-Icone"

                                                            style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">

                                                              <span aria-hidden="true">&times;</span>

                                                          </button>

                                                      </div>

                                                    </div>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ImageText') }}</span>



                                                    <br>

                                            </div>


                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="name" class="control-label text-start mb-2">Meta {{ trans('labels.Description') }} </label>

                                                      <textarea id="editor1" name="meta_description" class="form-control field-validate" rows="10" cols="80">

                                                      </textarea>

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} </span>

                                                        <br>

                                                </div>

                                                 <div class="form-group">

                                                    <label for="name" class="col-md-12 control-label text-start mb-2">OG: {{ trans('labels.Description') }} </label>

                                                        <textarea id="editor1" name="og_description" class="form-control field-validate" rows="10" cols="80">

                                                        </textarea>

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} </span>

                                                        <br>

                                                </div>

                                                <input type="hidden" name="post_type" value="page">
                                            </div>

                                        </div>
                                        <!-- /.box-body -->

                                            <div class="box-footer text-center">

                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>

                                                <a href="{{ URL::to('admin/news/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>

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

            CKEDITOR.replace('editor{{$languages->languages_id}}');



            @endforeach



            //bootstrap WYSIHTML5 - text editor

            $(".textarea").wysihtml5();



        });

    </script>

@endsection

