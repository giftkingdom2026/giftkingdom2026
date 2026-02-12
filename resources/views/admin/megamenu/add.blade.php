@extends('admin.layout')

@section('content')



<div class="content-wrapper">

    <section class="content-header">



        <h1>Add Mega Menu</h1>



        <ol class="breadcrumb">

            <li>

                <a href="<?=asset('admin/mega-menu/')?>">Back</a>

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


            {!! Form::open(array('url' =>'admin/megamenu/create/', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <div class="row">

                    <div class="col-md-8">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Title</label>

                            <input type="text" name="menu_title" class="pagetitle form-control" required>

                        </div>

                        <div class="form-group mt-3 ">

                            <label for="category_ID" class="control-label mb-1">Menu Category</label>

                            <select name="category_ID" class="form-control select2" id="category_ID">

                                <?php

                                foreach($result['categories'] as $cat) : ?>

                                    <option value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                                <?php endforeach;?>

                            </select>

                        </div>

                        <div class="form-group mt-3">

                            <label for="offers" class="control-label mb-1">Offers</label>

                            <select name="offers[]" multiple class="form-control select2" id="offers">

                                <?php

                                foreach($result['offers'] as $offer) : ?>

                                    <option value="<?=$offer['ID']?>"><?=$offer['post_title']?></option>

                                <?php endforeach;?>

                            </select>

                        </div>
                   


                </div>

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="category_icon" class="control-label mb-1">Category Icon</label>

                        <div class="featuredWrap">

                            <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                            <input type="hidden" id="category_icon" name="category_icon" value="">

                            <img src="" alt="category_icon" class="w-100 d-none">

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

