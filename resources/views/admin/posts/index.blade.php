@extends('admin.layout')

@section('content')



<?php //dd($data);
?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>{{ $data['post_type']['title'] }}</h1>

        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/add/'.$data['post_type']['type']) }}" type="button" class="btn-block"><i class="fa fa-plus"></i>Add {{ $data['post_type']['title'] }}</a></li>
        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">Listing</h3>

                        <div class="box-tools pull-right">

                            @if( !empty( $data['taxonomy'] ) )

                            @foreach($data['taxonomy'] as $tax)

                            <?php

                            if ($tax['taxonomy_title'] != 'Type') :  ?>

                                <a href="{{asset('admin/taxonomy/'.$tax['taxonomy_slug'])}}" type="button" class="btn btn-block btn-primary">{{$tax['taxonomy_title']}}</a>

                            <?php endif; ?>

                            @endforeach

                            @endif

                        </div>

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

                                <table id="Table{{$data['post_type']['type']}}" class="table table-bordered table-striped">

                                    <thead>

                                        <tr>

                                            <th>
                                                <input type="checkbox" name="select" class="select-all">
                                            </th>

                                            <th>ID</th>

                                            <th>Image</th>

                                            <th>Title</th>

                                           

                                            <th>Status</th>

                                            <th></th>

                                        </tr>

                                    </thead>

                                </table>

                                <div class="multi-delete" style="display: none;">
                                    <input type="hidden" name="selected_rows" value="" id="selected_rows">
                                    <a href="javascript:delete_popup('{{asset('admin/deletepost')}}','');" class="badge delete-multiple-popup bg-red">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>

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
    function delete_popup(action, id) {

        id = id == '' ? jQuery('#selected_rows').val() : id

        jQuery('.delete-modal').find('form').attr('action', action)

        jQuery('.delete-modal').find('#id').val(id)

        jQuery('.delete-modal').addClass('show')

        jQuery('.delete-modal').show()

    }
</script>