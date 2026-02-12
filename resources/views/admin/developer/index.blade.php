@extends('admin.layout')



@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Templates</h1>

        <ol class="breadcrumb">

            <li><a href="{{ asset('admin/developer/create') }}">Create Template</a></li>

        </ol>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">Listing</h3>

                    </div>



                    <div class="box-body">

                        <div class="row">

                            <div class="col-xs-12">



                                @if(session()->has('success'))

                                <div class="alert alert-success">

                                    {{ session()->get('success') }}

                                </div>

                                @endif

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-xs-12">

                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>

                                        <tr>

                                            <th>ID</th>

                                            <th>Template Name</th>

                                            <th>Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @if( !empty($templates) )



                                        @foreach ( $templates as  $key=> $data )



                                        <tr>

                                            <td>{{ $data['id'] }}</td>

                                            <td>

                                                {{ $data['name'] }}

                                            </td>

                                            <td>

                                                <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ asset('admin/developer/template/edit/'.$data['id'] ) }}" class="badge bg-light-blue">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="javascript:delete_popup('{{asset('admin/developer/delete')}}',{{ $data['id'] }});" 

                                                    class="badge delete-popup bg-red">

                                                    <i class="fa fa-trash" aria-hidden="true"></i>

                                                </a>



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

                            </div>



                        </div>

                    </div>



                </div>



            </div>



        </div>



    </section>



</div>

@endsection



<script>



    function delete_popup(action,id){



        jQuery('.delete-modal').find('form').attr('action',action)



        jQuery('.delete-modal').find('#id').val(id)



        jQuery('.delete-modal').addClass('show')



        jQuery('.delete-modal').show()



    }

</script>