@extends('admin.layout')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1> Edit Seo <small>Edit Seo...</small> </h1>

            <ol class="breadcrumb">

                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>

                <li><a href="{{ URL::to('admin/seo/display')}}"><i class="fa fa-dashboard"></i> All Seo</a></li>

                <li class="active">Edit Seo</li>

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

                            <h3 class="box-title">Edit Seo </h3>

                        </div>



                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="row">

                                <div class="col-xs-12">

                                    <div class="box box-info">

                                        <!--<div class="box-header with-border">

                                          <h3 class="box-title">Edit seo</h3>

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



                                            {!! Form::open(array('url' =>'admin/seo/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}



                                            {!! Form::hidden('id',  $result['seo'][0]->seo_id, array('class'=>'form-control', 'id'=>'id')) !!}

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                <label for="name" class="control-label">{{ trans('labels.slug') }} </label>

                                                    <input type="hidden" name="old_slug" value="{{$result['seo'][0]->page_slug}}">

                                                    <input type="text" name="slug" class="form-control field-validate" value="{{$result['seo'][0]->page_slug}}">

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">{{ trans('labels.slugText') }}</span>

                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                            </div>



                                                <div class="form-group">

                                                <label for="name" class="control-label">Page Name</label>

                                                    <input type="text" name="page_name" class="form-control field-validate" value="{{$result['seo'][0]->page_name}}">

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                   Page Name</span>



                                                    <span class="help-block hidden">Page Name</span>

                                            </div>

                                                <div class="form-group">

                                                    <label for="name" class="control-label">Meta Title</label>

                                                        <input type="text" name="meta_title" class="form-control field-validate" value="{{$result['seo'][0]->meta_title}}">

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                               {{ trans('labels.TitleNews') }} </span>

                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                                </div>

                                                <div class="form-group">

                                                    <label for="name" class="control-label">Meta Keywords</label>

                                                        <input type="text" name="meta_keywords" class="form-control" value="{{$result['seo'][0]->meta_keywords}}">

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                        Meta Keywords</span>

                                                        <span class="help-block hidden">Meta Keywords</span>

                                                </div>

                                                

                                                <div class="form-group">

                                                    <label for="name" class="control-label">OG:Title</label>

                                                        <input type="text" name="og_title" class="form-control field-validate" value="{{$result['seo'][0]->og_title}}">

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">

                                                        OG:Title </span>

                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>

                                                </div>


                                            <div class="form-group">

                                                <label for="name" class="control-label">{{ trans('labels.Image') }}</label>

                                                    <!-- Modal -->

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

                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadSubCategoryImage') }}</span>

                                            </div>



                                            <div class="form-group">

                                                <label for="name" class="control-label"></label>

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>

                                                    {!! Form::hidden('oldImage',  $result['seo'][0]->og_image , array('id'=>'oldImage')) !!}

                                                    <img src="{{asset($result['seo'][0]->path)}}" alt="" class="w-100">

                                            </div>


                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="name" class="control-label">Meta {{ trans('labels.Description') }} </label>

                                                      <textarea id="editor1" name="meta_description" class="form-control field-validate" rows="10" cols="80">{{$result['seo'][0]->meta_description}}

                                                      </textarea>

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} </span>

                                                        <br>

                                                </div>

                                                <div class="form-group">

                                                    <label for="name" class="control-label">OG: {{ trans('labels.Description') }} </label>

                                                        <textarea id="editor1" name="og_description" class="form-control field-validate" rows="10" cols="80">

                                                            {{$result['seo'][0]->og_description}}

                                                        </textarea>

                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Description') }} </span>

                                                        <br>

                                                </div>
                                            </div>

                                            

                                                

                                                 

                                                


                                            

                                            

                                          

                  

                                    

                                            

                                        </div>
                                        <!-- /.box-body -->

                                            <div class="box-footer text-center">

                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>

                                                <a href="{{ URL::to('admin/seo/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>

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

