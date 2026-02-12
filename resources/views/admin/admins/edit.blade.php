@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit User</h1>

        <ol class="breadcrumb">

            <li>

                <a href="<?= asset('admin/admins/') ?>">

                    Back

                </a>

            </li>

        </ol>

    </section>  

    <section class="content">

        <div class="box">

            @if(session()->has('success'))

            <div class="box-info">

                <div class="alert alert-success">

                    <?= session()->get('success') ?>

                </div>

            </div>

            @endif

            {!! Form::open(array('url' =>'admin/updateadmin/', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-12">

                        <input type="hidden" name="id" value="<?=$data['id']?>">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">First Name</label>

                                    <input type="text" name="first_name" class="form-control" value="<?=$data['first_name']?>" required> 

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="name" class="control-label  mb-1">Last Name</label>

                                    <input type="text" name="last_name" value="<?=$data['last_name']?>" class="form-control">

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Email</label>
@if($data['role_id'] != 1) 
                                    <input type="email" name="email" class="form-control" value="<?=$data['email']?>" required>
@else
                                    <input type="email" name="email" class="form-control" value="<?=$data['email']?>" required>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Phone</label>

                                    <input type="number" name="phone" class="form-control" value="<?=$data['phone']?>">

                                </div>

                            </div>
@if($data['role_id'] == 1) 

                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Password</label>

                                    <input type="password" name="password" class="form-control">

                                </div>

                            </div>

                            <div class="col-md-4 mt-3">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Confirm Password</label>

                                    <input type="password" name="confirmpassword" class="form-control">

                                </div>

                            </div>
@endif

                        </div>

                    </div>

                </div>

            </div>

            <div class="box-footer text-center">

                <button type="submit" class="btn btn-primary">Submit</button>

            </div>

            {!! Form::close() !!}

        </div>

    </section>

</div>











@endsection















<script>















    function delete_popup(action,id){















        jQuery('.delete-modal').find('form').attr('action',action)















        jQuery('.delete-modal').find('#id').val(jQuery('#selected_rows').val())















        jQuery('.delete-modal').addClass('show')















        jQuery('.delete-modal').show()















    }







</script>