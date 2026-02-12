@extends('admin.layout')

@section('content')



<?php //dd($data); ?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>Import Products</h1>

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



                    <div class="box-body">

                        <div class="row justify-content-center">

                            <div class="col-md-8">

                                <form method="post" class="importform" enctype="multipart/form-data">

                                    <div class="form-group">
                                        @csrf
                                        <input type="file" name="file" accept="csv" class="w-100 form-control">

                                        <button type="submit" class="btn btn-large mt-3 btn-primary w-100">Import Data</button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection
