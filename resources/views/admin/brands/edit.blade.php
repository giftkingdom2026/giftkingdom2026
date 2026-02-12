@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit Brand<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?= asset('admin/brand/list') ?>">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        @endif
                        
                        <h2 class="box-title">
                            Edit Brand
                        </h2>
                    </div>


                    <div class="box-body">

                        <form action="<?=asset('admin/brand/update')?>" method="post">

                            @csrf

                            <input type="hidden" name="brand_ID" class="form-data" value="<?=$data['brand']['brand_ID']?>">

                            <div class="form-group">

                                <label for="name" class="control-label mb-3">Title</label>

                                <input type="text" name="brand_title" value="<?=$data['brand']['brand_title']?>" class="pagetitle form-control form-data" required>

                            </div>



                            <div class="form-group my-3">

                                <label for="brand_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="brand_slug" value="<?=$data['brand']['brand_slug']?>" class="form-control form-data">

                            </div>


                            <div class="form-group mt-3">

                                <label for="brand_image" class="control-label mb-3">Image</label>

                                <div class="featuredWrap featured">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" id="brand_image" 

                                    name="brand_image" class="form-data" value="<?=$data['brand']['brand_image']['id']?>">

                                    <img src="<?=asset($data['brand']['brand_image']['path'])?>" alt="brand_image" class="w-100"/>

                                </div>

                            </div>


                            <div class="form-group my-3">

                                <label for="parent_ID" class="control-label mb-3">Category</label>

                                <select id="parent_ID" name="category_ID" class="form-control">

                                    <?php

                                    if( empty($data['brand']['cat'] ) ) : ?>

                                        <option value="0" selected>None</option>

                                    <?php else : ?>

                                        <option value="<?=$data['brand']['cat']['category_ID']?>" selected><?=$data['brand']['cat']['title']?></option>

                                    <?php endif; ?>

                                </select>

                            </div>
<div class="col-md-12">
    <div class="form-group">
        <label for="status" class="control-label">Status</label>
        <select name="brand_status" id="brand_status" class="form-control">
            <option value="1" <?= $data['brand']['brand_status'] == '1' ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= $data['brand']['brand_status'] == '0' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
</div>
                            <?php

                            $featuredproduct = isset($data['brand']['featured_product']) ?

                            $data['brand']['featured_product'] : ''; ?>

                            <div class="form-group my-3">

                                <label for="featured_product" class="control-label mb-1">Featured Product</label>

                                <select class="product-select form-control" name="featured_product" id="featured_product">

                                    <?php

                                    foreach( $data['products'] as $product ) : 

                                        $attr = $product['ID'] == $featuredproduct ? 'selected' : ''; ?>

                                        <option value="<?=$product['ID']?>" <?=$attr?>>
                                            <?=$product['prod_title']?>
                                        </option>

                                    <?php endforeach;?>

                                </select>

                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>


@endsection

