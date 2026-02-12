@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Edit Product<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="{{ asset('admin/product/list') }}">Back</a></li>

        </ol>

    </section>
    <?php //dd($data);?>


    <section class="content">



        <div class="box">

            @if(session()->has('success'))

            <div class="box-info">

                <div class="alert alert-success">

                    {{ session()->get('success') }}

                </div>

            </div>

            @endif

            <div class="box-header">

                <h3 class="box-title">Edit {{$data['product']['prod_title']}}</h3>

                <div class="box-tools pull-right">

                    <a href="{{asset('admin/product/add/')}}"  type="button" class="btn btn-block btn-primary">Add New Product</a>


                    <!-- <a href="{{asset('blog/')}}"  type="button" class="btn btn-block btn-primary">View</a> -->

                </div>

            </div>

            {!! Form::open(array('url' =>'admin/product/update/', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <input type="hidden" name="ID" value="<?=$data['product']['ID']?>">

                <div class="row justify-content-end mb-3">

                    <div class="col-md-4">

                        <label for="change_lang" class="control-label mb-1">Langugage</label>

                        <select name="lang" class="form-control" id="change_lang" data-url="<?=asset('admin/product/change_lang')?>" data-id="<?=$data['product']['ID']?>">
                            <option value="1">English</option>
                            <option value="2">Arabic</option>
                        </select>

                    </div>

                </div>

                <div id="languageWrap">

                    <div class="row">

                        <div class="col-md-8">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Title</label>

                                <input type="text" name="prod_title" class="pagetitle form-control" value="<?=$data['product']['prod_title']?>" required>

                            </div>
                            <?php

                            $c =  $data['product']['prod_type'] == 'variable' ? 'd-none' : '';

                            $attr =  $data['product']['prod_type'] == 'variable' ? '' : 'required';?>

                            <div class="product-data <?=$c?> border mt-3 p-3">

                                <h2 class="mt-3">Product Data</h2>

                                <div class="row pdata">

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label for="name" class="control-label mb-1">SKU</label>

                                            <input type="text" name="prod_sku" <?=$attr?> value="<?=$data['product']['prod_sku']?>" class="form-control">

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label for="name" class="control-label mb-1">Regular Price</label>
                                            <input type="number" name="prod_price" <?=$attr?> value="<?=$data['product']['prod_price']?>" class="form-control regular">
                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label for="name" class="control-label mb-1">Sale Price</label>

                                            <input type="number" name="sale_price" value="<?=$data['product']['sale_price']?>" class="form-control sale">

                                        </div>

                                    </div>

                                    <div class="col-md-4 mt-3">

                                        <div class="form-group">

                                            <label for="name" class="control-label mb-1">Stock</label>

                                            <input type="text" name="prod_quantity" <?=$attr?> value="<?=$data['product']['prod_quantity']?>" class="form-control">

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="form-group mt-3">

                                <label for="prod_description" class="control-label mb-1">Description</label>

                                <textarea class="quilleditor" name="prod_description" height="350">
                                    <?=$data['product']['prod_description']?>
                                </textarea>

                            </div>

                            <div class="form-group mt-3">

                                <div class="form-group">

                                    <label for="prod_short_description" class="control-label mb-1">Short Description</label>

                                    <textarea class="quilleditor" name="prod_short_description" height="150">
                                        <?=$data['product']['prod_short_description']?>
                                    </textarea>

                                </div>

                            </div>

                            <div class="form-group mt-3">

                                <label for="prod_description" class="control-label mb-1">Features And Details</label>

                                <?php

                                $prod_features = isset($data['product']['prod_features']) ? $data['product']['prod_features'] : ''; ?>

                                <textarea class="quilleditor" name="prod_features" height="350"><?=$prod_features?></textarea>

                            </div>



                            <div id="variations" class="my-3 d-none">

                                <!-- Gets Loaded From scripts.blade onload -->
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="position-sticky top-0">

                                <?php $metatitle = isset( $data['meta']['meta_title']) ? $data['meta']['meta_title'] : '';?>

                                <div class="form-group ">

                                    <label for="meta_desc" class="control-label mb-1">Meta Title</label>

                                    <input type="text" name="meta[meta_title]" value="<?=$metatitle?>" class="form-control">

                                </div>

                                <?php $metadesc = isset( $data['meta']['meta_desc']) ? $data['meta']['meta_desc'] : '';?>

                                <div class="form-group mt-3">

                                    <label for="meta_desc" class="control-label mb-1">Meta Description</label>

                                    <input type="text" name="meta[meta_desc]" value="<?=$metadesc?>" class="form-control">

                                </div>

                                <?php $metakeywords = isset( $data['meta']['meta_keywords']) ? $data['meta']['meta_keywords'] : '';?>

                                <div class="form-group mt-3">

                                    <label for="meta_keywords" class="control-label mb-1">Meta Keywords</label>

                                    <input type="text" name="meta[meta_keywords]" value="<?=$metakeywords?>" class="form-control">

                                </div>

                                <div class="form-group mt-3">

                                    <label for="name" class="control-label mb-1">Slug</label>

                                    <input type="text" name="prod_slug" value="<?=$data['product']['prod_slug']?>" class="slug form-control" required>

                                </div>

                                <?php   

                                $img = $data['product']['prod_image']['path'] == '' ? '' : $data['product']['prod_image']['path'];
                                $imgid = $data['product']['prod_image']['id'] == '' ? '' : $data['product']['prod_image']['id'] ; 
                                ($data['product']['prod_image']['path'] == '') ? $c = 'd-none' : $c = ''; 
                                ($data['product']['prod_image']['path'] == '') ? $c2 = '' : $c2 = 'featured'; 

                                ?>

                                <div class="form-group mt-3">

                                    <label for="featured_image" class="control-label mb-1">Product Image</label>

                                    <div class="featuredWrap <?=$c2?>">

                                        <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                        <input type="hidden" id="featured_image" 

                                        name="prod_image" value="<?=$imgid?>">

                                        <img src="{{asset($img)}}" alt="featured_image" class="w-100 <?=$c?>">

                                    </div>

                                </div>

                                <?php 


                                !empty($data['product']['prod_images']['path']) ?  $c1 = 'featured' : $c1 = ''; 

                                $imgid = $data['product']['prod_images']['id'] != null ? $data['product']['prod_images']['id']: '';

                                ?>

                                <div class="form-group mt-3">

                                    <label for="featured_image" class="control-label mb-1">Product Gallery</label>

                                    <div class="featuredWrap <?=$c1?>">

                                        <button class="btn uploader featured_image btn-primary" data-type="multiple">+</button>

                                        <input type="hidden" id="featured_image" name="prod_images" value="<?=$imgid?>">

                                        <?php 

                                        if( !empty( $data['product']['prod_images']['path'] ) ) : ?>

                                            <div class="row" id="images">

                                                <?php foreach( $data['product']['prod_images']['path'] as $path ) : ?>

                                                    <div class="col">

                                                        <img src="{{asset($path)}}" class="w-100">

                                                    </div>

                                                <?php endforeach; ?>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                </div>

                                <div class="border p-3 mt-3">

                                    <div class="form-group">

                                        <label for="featured_product" for="featured_product" class="gap-2 mb-0 d-flex align-items-center">
                                            <?php

                                            $attr = $data['product']['is_featured'] ? 'checked' : '';?>

                                            <input type="checkbox" <?=$attr?> id="featured_product" name="is_featured" class="form-checkbox"> Featured

                                        </label>

                                    </div>

                                </div>

                                <div class="form-group mt-3">

                                    <?php

                                    $data['product']['prod_status'] == 'active' ? $a1 = 'selected' : $a1 = '';

                                    $data['product']['prod_status'] == 'inactive' ? $a2 = 'selected' : $a2 = '';

                                    $data['product']['prod_status'] == 'draft' ? $a3 = 'selected' : $a3 = '';

                                    ?>

                                    <label for="prod_status" class="control-label mb-1">Product Type</label>

                                    <select name="prod_status" id="prod_status" class="form-control">
                                        <option value="active" <?=$a1?>>Active</option>
                                        <option value="inactive" <?=$a2?>>Inactive</option>
                                        <option value="draft" <?=$a3?>>Draft</option>
                                    </select>

                                </div>

                                <div class="form-group mt-3">

                                    <?php

                                    $data['product']['prod_type'] == 'simple' ? $a1 = 'selected' : $a1 = '';

                                    $data['product']['prod_type'] == 'variable' ? $a2 = 'selected' : $a2 = '';

                                    ?>

                                    <label for="prod_type" class="control-label mb-1">Product Type</label>

                                    <select name="prod_type" id="prod_type" class="form-control">
                                        <option value="simple" <?=$a1?>>Simple</option>
                                        <option value="variable" <?=$a2?>>Variable</option>
                                    </select>

                                </div>


                                <div class="categories mt-3 border p-2">
                                    <h3>Categories</h3>
                                    <div style="height: 200px;overflow-y: scroll;">

                                        <ul class="categories-list" style="list-style:none;">

                                            <?php

                                            foreach( $data['categories'] as $cat ) :

                                                $attr = $cat['checked'] ? 'checked' : ''; ?>

                                                <li class="first-children">
                                                    <label class="form-label">
                                                        <input type="checkbox" <?=$attr?> class="form-checkbox" 
                                                        name="category[]" 
                                                        value="<?=$cat['category_ID']?>"> 
                                                        <?=$cat['category_title']?>
                                                    </label>

                                                    <?php

                                                    if( !empty( $cat['children'] ) ) : ?>

                                                        <ul class="sub-list" style="list-style:none;">

                                                            <?php foreach( $cat['children'] as $child ) : 

                                                                $attr = $child['checked'] ? 'checked' : '';?>

                                                                <li class="second-children">

                                                                    <label class="form-label">
                                                                        <input type="checkbox" <?=$attr?> class="form-checkbox" 
                                                                        name="category[]" 
                                                                        value="<?=$child['category_ID']?>"> 
                                                                        <?=$child['category_title']?>
                                                                    </label>

                                                                    <?php

                                                                    if( !empty( $child['children'] ) ) : ?>

                                                                        <ul class="sub-child-list">

                                                                            <?php foreach( $child['children'] as $subchild ) : 

                                                                                $attr = $subchild['checked'] ? 'checked' : '';?>

                                                                                <li class="third-children">

                                                                                    <label class="form-label">
                                                                                        <input type="checkbox" <?=$attr?> class="form-checkbox" 
                                                                                        name="category[]" 
                                                                                        value="<?=$subchild['category_ID']?>"> 
                                                                                        <?=$subchild['category_title']?>
                                                                                    </label>

                                                                                </li>

                                                                            <?php endforeach;?>

                                                                        </ul>

                                                                    <?php endif;?>

                                                                </li>

                                                            <?php endforeach;?>

                                                        </ul>

                                                    <?php endif;?>

                                                </li>

                                            <?php endforeach;?>

                                        </ul>
                                    </div>
                                </div>

                                <?php

                                if( isset($data['brands']) ) : ?>

                                    <div class="brands mt-3 border p-2">
                                        <h3>Brand</h3>

                                        <div style="height: 200px;overflow-y: scroll;margin-left: 1rem ;">

                                            <?php

                                            foreach( $data['brands'] as $brand ) :

                                                $attr = $brand['checked'] ? 'checked' : ''; ?>
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <input type="checkbox" <?=$attr?> class="form-checkbox" 
                                                        name="brand" 
                                                        value="<?=$brand['brand_ID']?>"> 
                                                        <?=$brand['brand_title']?>
                                                    </label>
                                                </div>
                                            <?php endforeach;?>

                                        </div>
                                    </div>

                                <?php endif;?>


                            </div>

                        </div>

                    </div>

                    <div class="row mt-5">

                        <div class="col-md-12">

                            <div class="content-insert">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="box-footer text-center">

                <button type="submit" class="btn btn-primary">Submit</button>

                <a href="{{ URL::to('admin/product/list')}}" type="button" class="btn btn-default">Back</a>

            </div>

            {!! Form::close() !!}

        </div>

    </section>

</div>

@endsection

