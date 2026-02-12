@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Admins</h1>

        <ol class="breadcrumb">

            <li>

                <!-- <a href="<?=asset('admin/vendors/add')?>" type="button" class="btn-block">

                    <i class="fa fa-plus"></i>Add Vendor

                </a> -->

            </li>

            <li><a href="<?=asset('admin/addadmins/')?>" type="button" class="btn-block"><i class="fa fa-plus"></i>Add Admin</a></li>

        </ol>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-md-10">
                                <h3 class="box-title">Listing</h3>
                            </div>
                            

                        </div>

                    </div>
@if(session()->has('success'))

            <div class="box-info">

                <div class="alert alert-success">

                    <?= session()->get('success') ?>

                </div>

            </div>

            @endif
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

                                <table id="adminsTable" class="table table-bordered table-striped">

    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="select-all"></th>
                                            <th>ID</th>
                                            <th>Admin Name</th>
                                            <th>Admin Email</th>
                                            <th>Admin Phone</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                </table>

                                <div class="multi-delete" style="display: none;">

                                    <input type="hidden" name="selected_rows" value="" id="selected_rows">

                                    <a href="javascript:delete_popup('<?=asset('admin/admin/delete')?>','');" class="badge delete-multiple-popup bg-red">

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