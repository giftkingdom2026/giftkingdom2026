@extends('admin.layout')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1>  Slider <small>Listing Slider...</small> </h1>

            <ol class="breadcrumb">
                <li><a href="{{url('admin/mobile-slider/add')}}" type="button" class="btn-block"><i class="fa fa-plus"></i>{{ trans('labels.AddNew') }}</a></li>
            </ol>

        </section>



        <!--  content -->

        <section class="content">

            <!-- Info boxes -->



            <!-- /.row -->

            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header">

                        <h3 class="box-title">Listing</h3>

                            

                        </div>



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

                                            <th>@sortablelink('mobile_slider_id', trans('labels.ID') )</th>

                                            <th>@sortablelink('mobile_slider_type', 'Slider Type' )</th>
                                            <th>Banner</th>

                                            <th>@sortablelink('start_date', 'Start Date' )</th>

                                            <th>@sortablelink('end_date', 'End Date' )</th>

                                            <th>{{ trans('labels.Action') }}</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                        @if(count($sliderData['slider'])>0)

                                            @foreach ($sliderData['slider'] as $key=>$slider)

                                                <tr>

                                                    <td>{{ $slider->mobile_slider_id }}</td>

                                                    <td>{{ $slider->mobile_slider_type }}</td>

                                                    <td><img src="{{asset('/').'/'.$slider->path}}" width="120" height="120"></td>
                                                    <td>{{ $slider->start_date }}</td>

                                                    <td>{{ $slider->end_date }}</td>

                                                    @php $id =$slider->mobile_slider_id;   @endphp

                                                    <td><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{url('admin/mobile-slider/edit',$id)}}" class="badge bg-light-blue"><i class="fa fa-regular fa-pen-to-square" aria-hidden="true"></i></a>

                                                        <a  data-toggle="tooltip" data-placement="bottom" title=" {{ trans('labels.Delete') }}" id="mobile_slider_id" mobile_slider_id ="{{ $slider->mobile_slider_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>

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

            <!-- deleteSliderModal -->

            <div class="modal fade" id="deleteSliderModal" tabindex="-1" role="dialog" aria-labelledby="deleteSliderModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            <h4 class="modal-title" id="deleteSliderModalLabel">Delete Slider</h4>

                        </div>

                        {!! Form::open(array('url' =>'admin/mobile-slider/delete', 'name'=>'deleteSlider', 'id'=>'deleteSlider', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}

                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'mobilesliderid')) !!}

                        <div class="modal-body">

                            <p>Are you sure you want to delete this Slider?</p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>

                            <button type="submit" class="btn btn-primary" id="deleteSlider">Delete</button>

                        </div>

                        {!! Form::close() !!}

                    </div>

                </div>

            </div>



            <!--  row -->



            <!-- /.row -->

        </section>

        <!-- /.content -->

    </div>

@endsection

