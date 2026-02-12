@extends('admin.layout')



@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>Edit User</h1>
            <ol class="breadcrumb">

                <li>

                    <a href="<?= asset('admin/customers/display/') ?>">

                        Back

                    </a>

                </li>

            </ol>

        </section>

        <section class="content">

            <div class="box">

                @if (session()->has('success'))
                    <div class="box-info">

                        <div class="alert alert-success">

                            <?= session()->get('success') ?>

                        </div>

                    </div>
                @endif


                {!! Form::open([
                    'url' => 'admin/customers/update/',
                    'method' => 'post',
                    'class' => 'form-horizontal form-validate',
                    'enctype' => 'multipart/form-data',
                ]) !!}

                <div class="box-body">

                    <div class="row">

                        <div class="col-md-12">

                            <input type="hidden" name="id" value="<?= $data['id'] ?>">

                            <h2 class="mt-3">Customer Data</h2>

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Customer First Name</label>

                                        <input type="text" name="first_name" class="form-control"
                                            value="<?= $data['first_name'] ?>" required>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="name" class="control-label  mb-1">Customer Last Name</label>

                                        <input type="text" name="last_name" value="<?= $data['last_name'] ?>"
                                            class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Email</label>

                                        <input type="email" name="email" class="form-control"
                                            value="<?= $data['email'] ?>" required>

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Phone (Enter Minimum 9
                                            digits)</label>

                                        <input type="text" name="phone" class="form-control" maxlength="9"
                                            value="<?= $data['phone'] ?>" required pattern="\d{9,}">

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Date of Birth</label>

                                        <input type="text" name="dob" class="dob form-control"
                                            value="<?= $data['dob'] ?>" required>

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Gender</label>

                                        <select name="gender" class="form-control" required="">
                                            <option <?= $data['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                            <option <?= $data['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="row mb-3">

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Password</label>

                                        <input type="password" autocomplete="new-password" name="password"
                                            class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Confirm Password</label>

                                        <input type="password" autocomplete="new-password" name="confirmpassword"
                                            class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Emirate Of Residence</label>

                                        <input type="text" name="emirate_of_residence" class="form-control" value="<?= $data['emirate_of_residence'] ?>">

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="nationality" class="control-label mb-1">Nationality</label>

                                        <input type="text" name="nationality" class="form-control" value="<?= $data['nationality'] ?>">

                                    </div>

                                </div>

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
    function delete_popup(action, id) {







        jQuery('.delete-modal').find('form').attr('action', action)







        jQuery('.delete-modal').find('#id').val(jQuery('#selected_rows').val())







        jQuery('.delete-modal').addClass('show')







        jQuery('.delete-modal').show()







    }
</script>
