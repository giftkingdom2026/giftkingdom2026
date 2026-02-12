@extends('admin.layout')

@section('content')

    <div class="content-wrapper content-wrapper1">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1> Edit Contact <small>Edit Contact...</small> </h1>

            <ol class="breadcrumb">

                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>

               <!--  <li><a href="{{ URL::to('admin/services/display_services')}}"><i class="fa fa-dashboard"></i> Listing All The Contact </a></li> -->

                <li class="active"> Edit Contact </li>

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

                            <h3 class="box-title">Edit Services Content</h3>

                        </div> -->



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



                                            {!! Form::open(array('url' =>'admin/contactUpdate', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                            <hr>

                                            <div class="form-group">
                                                <label for="name" class="col-md-12 control-label">Heading one</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="heading_1" class="form-control field-validate" value="{{$result['contact'][0]->heading_1}}">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Heading one</span>
                                                    <span class="help-block hidden">Heading one</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-md-12 control-label">Description one</label>
                                                <div class="col-md-12">
                                                    <textarea id="editor" name="description_1" class="form-control field-validate" rows="10" cols="80">{{$result['contact'][0]->description_1}}</textarea>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-top: 0;">Description one</span>
                                                    <span class="help-block hidden">Description one</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-md-12 control-label">Visit Our Showroom Heading</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="heading_2" class="form-control field-validate" value="{{$result['contact'][0]->heading_2}}">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-Mid: 0;">Visit Our Showroom Heading</span>
                                                    <span class="help-block hidden">Visit Our Showroom Heading</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-md-12 control-label">Showroom Address</label>
                                                <div class="col-md-12">
                                                    <textarea id="editor" name="description_2" class="form-control field-validate" rows="10" cols="80">{{$result['contact'][0]->description_2}}</textarea>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-Mid: 0;">Description two</span>
                                                    <span class="help-block hidden">Description two</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name" class="col-md-12 control-label">Map Location</label>
                                                <div class="col-md-12">
                                                    <textarea id="editor" name="map" class="form-control field-validate" rows="10" cols="80">{{$result['contact'][0]->map}}</textarea>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;margin-Bottom: 0;">Map Location</span>
                                                    <span class="help-block hidden">Map Location</span>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="name" class="col-md-12 control-label">{{ trans('labels.Image') }}</label>
                                                <div class="col-md-12">
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
                                                                    <select class="image-picker show-html " name="image" id="select_img">
                                                                        <option value=""></option>
                                                                        @foreach($allimage as $key=>$image)
                                                                        <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}} {{$image->path}}"> {{$image->id}} </option>
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

                                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Upload Image</span>



                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label for="name" class="col-md-12 control-label"></label>

                                                <div class="col-md-12">

                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>

                                                    {!! Form::hidden('oldImage',  $result['contact'][0]->image , array('id'=>'oldImage')) !!}

                                                    {!! Form::hidden('oldImagePath',  $result['contact'][0]->contact_image_path , array('id'=>'oldImagePath')) !!}

                                                    <img src="{{asset($result['contact'][0]->contact_image_path)}}" alt="" width=" 100px">

                                                </div>

                                            </div>
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                <a href="{{ URL::to('admin/dashboard/this_month') }}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                            </div>
                                            {!! Form::close() !!}

                                        </div>

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



            



        });

    </script>

@endsection

