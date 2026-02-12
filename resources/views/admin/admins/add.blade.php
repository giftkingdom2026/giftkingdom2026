@extends('admin.layout')



@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Add Admin</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/admins/') }}">

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


            {!! Form::open(array('url' =>'admin/addnewadmin/','autocomplete' => 'false' , 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">First Name</label>

                            <input type="text" name="first_name" class="form-control" required=""> 

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label  mb-1">Last Name</label>

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

                            <label for="name" class="control-label mb-1">Phone</label>

                            <input type="number" name="phone" class="form-control">

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="password" class="control-label mb-1">Password</label>

                            <input type="password" name="password" autocomplete="new-password" class="form-control" required="">

                        </div>


                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Confirm Password</label>

                            <input type="password" required name="confirmpassword" class="form-control">

                        </div>

                    </div>
                </div>

            </div>

            <div class="box-footer text-center">

            <button type="submit" class="btn btn-primary">Submit</button>

        </div>

        </div>

        {!! Form::close() !!}

    </div>

</section>

</div>


@endsection

