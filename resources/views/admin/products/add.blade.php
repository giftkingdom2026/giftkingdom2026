@extends('admin.layout')

@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <h1>Add Product</h1>
        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/product/list/') }}">

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


            <form action="<?= asset('admin/product/create/') ?>" id="product-form" method="post" class="form-horizontal form-validate" enctype="multipart/form-data">

                @csrf
                <div class="box-body">

                    <div class="row">

                        <div class="col-md-8">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Title</label>

                                <input type="text" name="prod_title" class="pagetitle form-control" required>

                            </div>

                            <h2 class="mt-3">Product Data</h2>

                            <div class="row pdata">

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">SKU</label>

                                        <input type="text" name="prod_sku" required class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Regular Price</label>

                                        <input type="number" name="prod_price" class="form-control regular" required>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Sale Price</label>

                                        <input type="number" name="sale_price" class="form-control sale">

                                    </div>

                                </div>

                                <div class="col-md-4 mt-3">

                                    <div class="form-group">

                                        <label for="name" class="control-label mb-1">Stock</label>

                                        <input type="text" name="prod_quantity" required class="form-control">

                                    </div>

                                </div>

                            </div>

                            <div class="form-group mt-3">

                                <label for="prod_description" class="control-label mb-1">Description</label>

                                <textarea class="quilleditor" name="prod_description" height="350"></textarea>

                            </div>

                            <div class="form-group mt-3">

                                <div class="form-group">

                                    <label for="prod_short_description" class="control-label mb-1">Short Description</label>

                                    <textarea class="quilleditor" name="prod_short_description" height="150"></textarea>

                                </div>

                            </div>

                            <div class="form-group mt-3">

                                <label for="prod_description" class="control-label mb-1">Features And Details</label>

                                <textarea class="quilleditor" name="prod_features" height="350">

                                </textarea>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="meta_desc" class="control-label mb-1">Meta Title</label>

                                <input type="text" name="meta[meta_title]" class="form-control">

                            </div>

                            <div class="form-group mt-3">

                                <label for="meta_desc" class="control-label mb-1">Meta Description</label>

                                <input type="text" name="meta[meta_desc]" class="form-control">

                            </div>



                            <div class="form-group mt-3">

                                <label for="meta_keywords" class="control-label mb-1">Meta Keywords</label>

                                <input type="text" name="meta[meta_keywords]" class="form-control">

                            </div>

                            <div class="form-group mt-3">

                                <label for="name" class="control-label mb-1">Slug</label>

                                <input type="text" name="prod_slug" class="slug form-control" required>

                            </div>

                            <div class="form-group mt-3">

                                <label for="featured_image" class="control-label mb-1">Featured Image</label>

                                <div class="featuredWrap">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" id="featured_image" name="prod_image" value="">

                                    <img src="" alt="featured_image" class="w-100 d-none">

                                </div>

                            </div>

                            <div class="form-group mt-3">

                                <label for="featured_image" class="control-label mb-1">Product Gallery</label>

                                <div class="featuredWrap">

                                    <button class="btn uploader featured_image btn-primary" data-type="multiple">+</button>

                                    <input type="hidden" id="featured_image" name="prod_images" value="">

                                    <img src="" alt="featured_image" class="w-100 d-none">

                                </div>

                            </div>
                                <div class="border p-3 mt-3">

                                    <div class="form-group">

                                        <label for="featured_product" for="featured_product" class="gap-2 mb-0 d-flex align-items-center">

                                            <input type="checkbox" id="is_featured" name="is_featured" class="form-checkbox"> Featured

                                        </label>

                                    </div>

                                </div>
                            <div class="form-group mt-3">

                                <label for="prod_status" class="control-label mb-1">Product Type</label>

                                <select name="prod_status" id="prod_status" class="form-control">
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>

                            </div>

                            <div class="form-group mt-3">

                                <label for="prod_type" class="control-label mb-1">Product Type</label>

                                <select name="prod_type" id="prod_type" class="form-control">
                                    <option value="simple">Simple</option>
                                    <option value="variable">Variable</option>
                                </select>

                            </div>


                            <div class="form-group categories mt-3 border p-2">
                                <h3>Categories</h3>
                                <div style="height: 200px;overflow-y: scroll;">

                                    <ul class="categories-list">

                                        <?php

                                        foreach ($data['categories'] as $cat) :
                                        ?>

                                            <li class="first-children">
                                                <label class="form-label">
                                                    <input type="checkbox" class="form-checkbox"
                                                        name="category[]"
                                                        value="<?= $cat['category_ID'] ?>">
                                                    <?= $cat['category_title'] ?>
                                                </label>

                                                <?php

                                                if (!empty($cat['children'])) : ?>

                                                    <ul class="sub-list">

                                                        <?php foreach ($cat['children'] as $child) :

                                                        ?>

                                                            <li class="second-children">

                                                                <label class="form-label">
                                                                    <input type="checkbox" class="form-checkbox"
                                                                        name="category[]"
                                                                        value="<?= $child['category_ID'] ?>">
                                                                    <?= $child['category_title'] ?>
                                                                </label>

                                                                <?php

                                                                if (!empty($child['children'])) : ?>

                                                                    <ul class="sub-child-list">

                                                                        <?php foreach ($child['children'] as $subchild) :

                                                                        ?>

                                                                            <li class="third-children">

                                                                                <label class="form-label">
                                                                                    <input type="checkbox" class="form-checkbox"
                                                                                        name="category[]"
                                                                                        value="<?= $subchild['category_ID'] ?>">
                                                                                    <?= $subchild['category_title'] ?>
                                                                                </label>

                                                                            </li>

                                                                        <?php endforeach; ?>

                                                                    </ul>

                                                                <?php endif; ?>

                                                            </li>

                                                        <?php endforeach; ?>

                                                    </ul>

                                                <?php endif; ?>

                                            </li>

                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>

                            <div class="categories mt-3 border p-2 d-none">
                                <h3>Deals</h3>
                                <div style="height: 200px;overflow-y: scroll;">

                                    <ul class="categories-list">

                                        <?php

                                        foreach ($data['deals'] as $cat) :

                                            $attr = $cat['checked'] ? 'checked' : ''; ?>

                                            <li class="first-children">
                                                <label class="form-label">
                                                    <input type="checkbox" <?= $attr ?> class="form-checkbox"
                                                        name="category[]"
                                                        value="<?= $cat['category_ID'] ?>">
                                                    <?= $cat['category_title'] ?>
                                                </label>

                                            </li>

                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>

                            <div class="form-group brands mt-3 border p-2">
                                <h3>Brand</h3>

                                <div style="height: 200px;overflow-y: scroll;margin-left: 1rem ;">

                                    <?php

                                    foreach ($data['brands'] as $brand) :

                                    ?>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <input type="checkbox" class="form-checkbox"
                                                    name="brand"
                                                    value="<?= $brand['brand_ID'] ?>">
                                                <?= $brand['brand_title'] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mt-5">

                        <div class="col-md-12">

                            <div class="content-insert">

                                @if($data['template'] != null)

                                <?php

                                $fields = $data['template']->data;

                                $post_fields = unserialize($fields);

                                $str = '';

                                foreach ($post_fields as $sec) :

                                    foreach ($sec['data'] as $key => $items):

                                        $str .= ',' . $items['key'];

                                    endforeach;

                                endforeach;  ?>

                                <!-- <input type="hidden" name="fields" value="meta_desc,meta_keywords,<?= substr($str, 1) ?>"> -->

                                @include('admin.templates.fields',['fields' => $fields , 'result' => [ 'content' => $data['post_type'] ] ] )

                                @else

                                <input type="hidden" name="fields" value="meta_desc,meta_keywords">

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                <div class="box-footer text-center">

                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>

            </form>


        </div>



    </section>

</div>

@endsection