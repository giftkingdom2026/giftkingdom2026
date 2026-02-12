@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Add Customer</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/customers/display/') }}">

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

                    {{ session()->get('success') }}

                </div>

            </div>
            @endif


            <form action="<?=asset('admin/customers/add/')?>" autocomplete="false" method="POST" class="form-horizontal form-validate" enctype="multipart/form-data">
                @csrf
                <div class="box-body">

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Customer First Name</label>

                                <input type="text" name="first_name" class="form-control" required=""> 

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="name" class="control-label  mb-1">Customer Last Name</label>

                                <input type="text" name="last_name" class="form-control">

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Email</label>

                                <input type="email" name="email" class="form-control" required="">

                            </div>

                        </div>

                        <div class="col-md-4 mt-3">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Phone (Enter Minimum 9 digits)</label>

                                <input type="text" name="phone" maxlength="9" class="form-control" required="" pattern="\d{9,}">

                            </div>

                        </div>

                        <div class="col-md-4 mt-3">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Date of Birth</label>

                                <input type="text" name="dob" class="dob form-control" required="">

                            </div>

                        </div>


                        <div class="col-md-4 mt-3">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Gender</label>

                                <select name="gender" class="form-control" required="" >
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 mt-3">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Password</label>

                                <input type="password" required name="password" autocomplete="new-password" class="form-control">

                            </div>

                        </div>

                        <div class="col-md-4 mt-3">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Confirm Password</label>

                                <input type="password" required name="confirmpassword" class="form-control">

                            </div>

                        </div>
 <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Emirate Of Residence</label>

                                        <input type="text" name="emirate_of_residence" class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="nationality" class="control-label mb-1">Nationality</label>

                                        <input type="text" name="nationality" class="form-control">

                                    </div>

                                </div>
                    </div>

                    <div class="box-footer text-center">

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </div>

                </div>

            </form>
        </div>


    </div>

</section>

</div>


@endsection

