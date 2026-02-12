@extends('admin.layout')
@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1> Add Menu Item</h1>

        <ol class="breadcrumb">
            <li><a href="{{ asset('admin/menus') }}">Back</a></li>
        </ol>
    </section>


    <section class="content">
        <div class="box">

@if(session()->has('success'))

                    <div class="alert alert-success">

                        {{ session()->get('success') }}

                    </div>

                    @endif


            {!! Form::open(array('url' =>'admin/addnewmenu', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label">Item Name</label>

                            <input type="text" name="menuName_1" class="form-control" required value="" >

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group type">

                            <label for="name" class="control-label">Url Type</label>

                            <select name="type" id="url-type" class="form-control">

                                <option value="1" selected>Page</option>

                                <option value="0">Link</option>

                                <option value="2">Category</option>
                                
                            </select>

                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="status" class="control-label">Status</label>

                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                
                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 link url mt-3">

                        <div class="form-group external_link">

                            <label for="name" class="control-label">Url</label>

                            <input name="external_link" class="form-control menu">

                        </div>

                    </div>

                    <div class="col-md-4 link page mt-3" style="display: block;">

                        <div class="form-group external_link">

                            <label for="name" class="control-label">Page</label>

                            <select name="link" class="form-control">

                                <?php

                                foreach( $result['pages'] as $page ) : ?>

                                    <option value="<?=asset($page['slug'])?>"><?=$page['page_title']?></option>

                                    <?php

                                endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 link category mt-3">

                        <div class="form-group external_link">

                            <label for="name" class="control-label">Category</label>

                            <select name="category" class="form-control">

                                <?php

                                foreach( $result['categories'] as $cat ) : ?>

                                    <option value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                                    <?php

                                endforeach;?>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-4 mt-3">

                        <div class="form-group">

                            <label for="type" class="control-label">Menu</label>

                            <select name="menu" class="form-control">

                                <option value="main">Main</option>
                                <option value="get-to-know-us">About Us</option>
                                <option value="quick-links">Help & Support</option>
                                <option value="our-legal">Legal & Policies</option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

            <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {!! Form::close() !!}

        </div>

    </div>

</section>


</div>
<style>.link{display: none;}</style>

@endsection
