@extends('admin.layout')



@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Customers</h1>

        <ol class="breadcrumb">

            <li>

                <!-- <a href="<?=asset('admin/vendors/add')?>" type="button" class="btn-block">

                    <i class="fa fa-plus"></i>Add Vendor

                </a> -->

            </li>

            <li><a href="<?=asset('admin/customers/add')?>" type="button" class="btn-block"><i class="fa fa-plus"></i>Add Customer</a></li>

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

                                @if(session()->has('message'))

                                <div class="alert alert-success">

                                    <?=session()->get('message') ?>

                                </div>

                                @endif

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-xs-12">

                                <table id="customersTable" class="table table-bordered table-striped">

                                    <thead>

                                        <tr >

                                            <th>

                                                <input type="checkbox" name="select" class="select-all">

                                            </th>

                                            <th>ID</th>

                                            <th>Customer Name</th>

                                            <th>Customer Email</th>

                                            <th>Customer Phone</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                            </table>

                            <div class="multi-delete" style="display: none;">

                                <input type="hidden" name="selected_rows" value="" id="selected_rows">

                                <a href="javascript:delete_popup('<?=asset('admin/customers/delete')?>','');" class="badge delete-multiple-popup bg-red">

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

    function delete_popup(action,id){

        id = id == '' ? jQuery('#selected_rows').val() : id
        
        jQuery('.delete-modal').find('form').attr('action',action)

        jQuery('.delete-modal').find('#id').val(id)

        jQuery('.delete-modal').addClass('show')

        jQuery('.delete-modal').show()

    }

</script>