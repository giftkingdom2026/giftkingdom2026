@extends('admin.layout')



@section('content')







<?php //dd($data); ?>



<div class="content-wrapper">



    <section class="content-header">



        <h1>Inventory</h1>



    </section>





    <section class="content">



        <div class="row">



            <div class="col-md-12">



                <div class="box">



                    @if(session()->has('success'))



                    <div class="box-info">



                        <div class="alert alert-success">



                            {{ session()->get('success') }}



                        </div>



                    </div>



                    @endif



                    <div class="box-header">



                        <h3 class="box-title">Listing</h3>



                        <div class="box-tools pull-right">



                        </div>



                    </div>







                    <div class="box-body">



                        <div class="row">



                            <div class="col-xs-12">



                                <table id="inventoryTable" class="table table-bordered table-striped">



                                    <thead>



                                        <tr>



                                            <th>ID</th>



                                            <th>Image</th>



                                            <th>Title</th>



                                            <th>Stock</th>



                                            <th>Purcase Price</th>



                                            <th>Sell Price</th>



                                            <th>Author</th>



                                            <th>Actions</th>



                                        </tr>



                                    </thead>



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