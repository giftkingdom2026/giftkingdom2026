@extends('admin.layout')



@section('content')



    <div class="content-wrapper content-wrapper1">



        <!-- Content Header (Page header) -->



        <section class="content-header">



            <h1> Seo <small>Listing All Seo...</small> </h1>



            <ol class="breadcrumb">



                <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>



                <li class="active">Seo</li>



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









                            



                            <div class="pull-right">



                                <a href="{{ URL::to('admin/seo/add')}}" type="button" class="btn btn-block btn-primary">+</a>



                            </div>



                        </div>



                        <!-- /.box-header -->



                        <div class="box-body">







                            <div class="row">



                                <div class="col-xs-12">







                                    @if ($errors != null)



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



                                    <table id="example" class="table table-bordered table-striped seo-table">



                                        <thead>



                                        <tr>



                                            <th>ID</th>

                                            <!-- <th>Post Type</th> -->

                                            <th>Og Image</th>

                                            <th>Page Name</th>



                                            <th>Meta Title</th>



                                            <th>Meta Description</th>



                                            <th>Added Date</th>



                                            <th>{{ trans('labels.Action') }}</th>



                                        </tr>



                                        </thead>



                                        <tbody>

                                        @if($seo != null)







                                            @php $seolist = $seo->unique('seo_id') @endphp



                                            @foreach ($seolist as  $key=>$new)







                                                <tr>



                                                    <td>{{ $new->seo_id }}</td>

                                                    <!-- <td>{{ $new->post_type }}</td> -->



                                                    <td>
                                                        <a href="{{asset($new->path)}}" class="listing-thumbnail" data-fancybox="">
                                                            <img src="{{asset($new->path)}}" width=" 100px" height="100px">
                                                        </a></td>



                                                    <td>



                                                        <strong>{{ $new->page_name }}</strong>



                                                    </td>



                                                    <td>

                                                       {{ $new->meta_title }}

                                                    </td>

                                                     <td>

                                                       {!! $new->meta_description !!}

                                                    </td>

                                                    <td>{{date('Y-m-d', strtotime($new->created_at))}}


                                                    </td>







                                                    <td>



                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="{{ URL::to('admin/seo/edit/'.$new->seo_id)}}" class="badge bg-light-blue"><i class="fa fa-regular fa-pen-to-square" aria-hidden="true"></i></a>







                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteSeoId" seo_id="{{ $new->seo_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>



                                                    </td>



                                                </tr>



                                            @endforeach



                                        @else



                                            <tr>



                                                <td colspan="6">{{ trans('labels.NoRecordFound') }}.</td>



                                            </tr>



                                        @endif



                                        </tbody>



                                    </table>



                                    @if($seo != null)



                                    <div class="col-xs-12 text-right">



                                       



                                    </div>



                                    @endif



                                </div>







                            </div>



                        </div>



                        <!-- /.box-body -->



                    </div>



                    <!-- /.box -->



                </div>



                <!-- /.col -->



            </div>







            <!-- deleteSeoModal -->



            <div class="modal fade" id="deleteSeoModal" tabindex="-1" role="dialog" aria-labelledby="deleteSeoModalLabel">



                <div class="modal-dialog" role="document">



                    <div class="modal-content">



                        <div class="modal-header">



                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>



                            <h4 class="modal-title" id="deleteSeoModalLabel">Delete Page Seo</h4>



                        </div>



                        {!! Form::open(array('url' =>'admin/seo/delete', 'name'=>'deleteSeo', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}



                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}



                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'seo_id')) !!}



                        <div class="modal-body">



                            <p>Are you sure you want to delete this page seo?</p>



                        </div>



                        <div class="modal-footer">



                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>



                            <button type="submit" class="btn btn-primary" id="deleteSeo">{{ trans('labels.Delete') }}</button>



                        </div>



                        {!! Form::close() !!}



                    </div>



                </div>



            </div>



            <!-- /.row -->







            <!-- Main row -->







            <!-- /.row -->



        </section>



        <!-- /.content -->



    </div>



@endsection



