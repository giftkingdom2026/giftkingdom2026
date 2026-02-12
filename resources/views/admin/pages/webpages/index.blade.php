@extends('admin.layout')

@section('content')
    <div class="content-wrapper content-wrapper1">

        <!-- Content Header (Page header) -->

        <section class="content-header">

            <h1> {{ trans('labels.Pages') }} <small>{{ trans('labels.ListingAllPages') }}...</small> </h1>

            <ol class="breadcrumb">

                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>

                <li class="active">{{ trans('labels.Pages') }} </li>

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

                            <div class="box-tools pull-right">

                                <a href="{{ URL::to('admin/addwebpage') }}" type="button" class="btn btn-block btn-primary">+</a>

                            </div><br>

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

                                    @if(count($result["pages"])>0)

                                    <table id="example1" class="table table-bordered table-striped">

                                        <thead>

                                        <tr>





                                            <th>@sortablelink('page_id', trans('labels.ID') )</th>

                                            <th>@sortablelink('Name', trans('labels.Name') )</th>

                                            <th>@sortablelink('slug', trans('labels.Slug') )</th>

                                            <!-- <th>{{ trans('labels.Status') }}</th> -->

                                            <th>{{ trans('labels.Action') }}</th>



                                        </tr>

                                        </thead>

                                        <tbody>

                                        @if(count($result["pages"])>0)

                                            @foreach ($result["pages"] as  $key=>$data)



                                                <tr>

                                                    <td>{{ $data->page_id }}</td>

                                                    <td>

                                                        {{ $data->name }}

                                                    </td>

                                                    <td>

                                                        {{ $data->slug }}

                                                    </td>

                                               <!--      <td>

                                                        @if($data->status==0)

                                                            <span class="label label-warning">

										{{ trans('labels.InActive') }}

									</span>

                                                        @else

                                                            <a href="{{ URL::to("admin/pageStatus")}}?id={{ $data->page_id}}&active=no" class="method-status">

                                                                {{ trans('labels.InActive') }}

                                                            </a>

                                                        @endif

                                                        &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;

                                                        @if($data->status==1)

                                                            <span class="label label-success">

										{{ trans('labels.Active') }}

									</span>

                                                        @else

                                                            <a href="{{ URL::to("admin/pageStatus")}}?id={{ $data->page_id}}&active=yes" class="method-status">

                                                                {{ trans('labels.Active') }}

                                                            </a>

                                                        @endif



                                                    </td>
 -->
                                                    <td>

                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editwebpage/{{ $data->page_id }}" class="badge bg-light-blue"><i class="fa fa-regular fa-pen-to-square"></i></a>



                                                        <!-- <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deletewebpage" page_id="{{ $data->page_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a> -->



                                                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" id="deleteNewsId" news_id="{{ $data->page_id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>



                                                        <a data-toggle="tooltip" data-placement="bottom" title="Seo" href="{{ URL::to('admin/page/seo/'.$data->slug.'/webpage')}}" class="badge bg-light-blue"><i class="fa fa-share-alt" aria-hidden="true"></i></a>



                                                    </td>

                                                </tr>

                                            @endforeach

                                        @else

                                            <tr>

                                                <td colspan="6">{{ trans('labels.NoRecordFound') }}</td>

                                            </tr>

                                        @endif

                                        </tbody>

                                    </table>

                                    @else

                                        <p>{{ trans('labels.NoRecordFound') }}</p>

                                    @endif



                                    <div class="col-xs-12 text-right">





                                        {!! $result["pages"]->links() !!}

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



            <!-- deletePageModal -->

            <!-- <div class="modal fade" id="deletePageModal" tabindex="-1" role="dialog" aria-labelledby="deletePageModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            <h4 class="modal-title" id="deletePageModalLabel">{{ trans('labels.DeletePage') }}</h4>

                        </div>

                        {!! Form::open(array('url' =>'admin/deletepage', 'name'=>'deletePage', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}

                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'id')) !!}

                        <div class="modal-body">

                            <p>{{ trans('labels.DeletePageDilogue') }}</p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>

                            <button type="submit" class="btn btn-primary" id="deletePage">{{ trans('labels.Delete') }}</button>

                        </div>

                        {!! Form::close() !!}

                    </div>

                </div>

            </div> -->

















   <div class="modal fade" id="deleteNewsModal" tabindex="-1" role="dialog" aria-labelledby="deleteNewsModalLabel">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            <h4 class="modal-title" id="deleteNewsModalLabel">{{ trans('labels.DeletePage') }}</h4>

                        </div>

                        {!! Form::open(array('url' =>'admin/deletepage', 'name'=>'deletePage', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}

                        {!! Form::hidden('id',  '', array('class'=>'form-control', 'id'=>'id')) !!}

                        <div class="modal-body">

                            <p>{{ trans('labels.DeletePageDilogue') }}</p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>

                            <button type="submit" class="btn btn-primary" id="deletePage">{{ trans('labels.Delete') }}</button>

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

