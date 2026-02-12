@extends('admin.layout')

@section('content')


<?php

$condition = str_contains(Route::current()->uri(), 'deals') ? true : false;

$uri = str_contains(Route::current()->uri(), 'deals') ? 'deals' : 'category';

?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit <?=$data['category_title']?><small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?=asset('admin/'.$uri.'/list')?>">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            <?= session()->get('success') ?>
                        </div>
                        @endif

                        <h2 class="box-title">
                            Edit <?=$data['category_title']?>
                        </h2>
                    </div>


                    <div class="box-body">

                        <form action="<?=asset('admin/category/update')?>" method="post">

                            @csrf
                            
                            <input type="hidden" name="category_ID" class="form-data" value="<?=$data['category_ID']?>">

                            <div class="row">
                                <div class="col-md-6">

                                    <div id="languageWrap">

                                        <div class="form-group">
                                            <label for="name" class="control-label mb-1">Title</label>
                                            <input type="text" name="category_title" value="<?=$data['category_title']?>" class="pagetitle form-control form-data" required>
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="term_slug" class="control-label mb-1">Slug</label>
                                            <input type="text" name="categories_slug" value="<?=$data['categories_slug']?>" class="form-control slug form-data">
                                        </div>


                                        <?php $metatitle = isset($data['meta']['metatitle']) ? $data['meta']['metatitle'] : '';?>

                                        <div class="form-group my-3">

                                            <label for="metatitle" class="control-label mb-3">Meta Title</label>

                                            <input type="text" name="meta[metatitle]" id="metatitle" value="<?=$metatitle?>" class="form-control form-data">

                                        </div>

                                        <?php $metakeywords = isset($data['meta']['metakeywords']) ? $data['meta']['metakeywords'] : '';?>

                                        <div class="form-group my-3">

                                            <label for="metakeywords" class="control-label mb-3">Meta Keywords</label>

                                            <input type="text" name="meta[metakeywords]" id="metakeywords" value="<?=$metakeywords?>" class="form-control form-data">

                                        </div>

                                        <?php $metadesc = isset($data['meta']['metadesc']) ? $data['meta']['metadesc'] : '';?>

                                        <div class="form-group my-3">

                                            <label for="metadesc" class="control-label mb-3">Meta Description</label>

                                            <input type="text" name="meta[metadesc]" id="metadesc" value="<?=$metadesc?>" class="form-control form-data">

                                        </div>
                                        <?php $status = isset($data['status']) ? $data['status'] : 'active'; ?>

<div class="form-group mt-3">
    <label for="status" class="control-label mb-1">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
</div>

                                    </div>

                                    <?php

                                    if( !$condition ) : ?>

                                        <div class="form-group mt-2">
                                            <label for="parent_ID" class="control-label mb-1">Parent</label>
                                            <select id="parent_ID" name="parent_ID" class="form-control">

                                                <option value="<?=$data['parent_ID'] == null ? 0 : $data['parent_ID']['category_ID']?>" selected>

                                                    <?=$data['parent_ID'] == null ? 'None' : $data['parent_ID']['category_title']?>

                                                </option>

                                            </select>
                                        </div>

                                    <?php endif;?>
                                    
                                    <div class="form-group my-2">
                                        <label for="lang" class="control-label mb-1">Language</label>
                                        <select id="change_lang" name="lang" data-url="<?=asset('admin/category/change_lang')?>" data-id="<?=$data['category_ID']?>" class="form-control">
                                            <option value="1">English</option>
                                            <option value="2">Arabic</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php   

                                        $img = $data['category_image']['path'] == '' ? '' : $data['category_image']['path'];
                                        $imgid = $data['category_image']['id'] == '' ? '' : $data['category_image']['id'] ; 
                                        ($data['category_image']['path'] == '') ? $c = 'd-none' : $c = ''; 
                                        ($data['category_image']['path'] == '') ? $c2 = '' : $c2 = 'featured';  ?>

                                        <label for="category_image" class="control-label mb-1">Image</label>

                                        <div class="featuredWrap <?=$c2?>">

                                            <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                            <input type="hidden" id="category_image" 

                                            name="category_image" class="form-data" value="<?=$imgid?>">

                                            <img src="<?=asset($img)?>" alt="category_image" class="w-100 <?=$c?>">
                                        </div>
                                    </div>

                                </div>
                                <?php $isHidden = isset($data['is_hidden']) && $data['is_hidden'] == 1 ? true : false; ?>
<div class="form-group my-3 form-check">
    <input type="hidden" name="is_hidden" value="0">
    <input type="checkbox" class="form-check-input" id="is_hidden" name="is_hidden" value="1" <?= $isHidden ? 'checked' : '' ?>>
    <label class="form-check-label" for="is_hidden">Hidden From The Filters?</label>
</div>
                                <div class="col-md-12 mt-2">    
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>


@endsection

