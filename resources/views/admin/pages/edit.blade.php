@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit</h1>
        <ol class="breadcrumb">
            <li><a href="<?= asset('admin/page/list') ?>">Back</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            @if(session()->has('success'))
            <div class="box box-info">

                <div class="alert alert-success">
                    <?= session()->get('success') ?>
                </div>
            </div>
            @endif

            {!! Form::open(array('url' =>'admin/page/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <input type="hidden" name="page_id" value="<?= $result['page_data']->page_id ?>">

                <div class="row justify-content-end">

                    <div class="col-md-3">

                        <div class="form-group my-2">
                            <label for="lang" class="control-label mb-1">Language</label>
                            <select id="change_lang" name="lang" data-url="<?= asset('admin/page/change_lang') ?>" data-id="<?= $result['page_data']->page_id ?>" class="form-control">
                                <option value="1">English</option>
                                <option value="2">Arabic</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div id="languageWrap">

                    <div class="row">

<div class="{{ ($result['page_data']->page_id == 58 || $result['page_data']->page_id == 57 || $result['page_data']->page_id == 61) ? 'col-md-12' : 'col-md-4' }}">


                            <?php isset($result['content']['pagetitle']) ?

                                $title = $result['content']['pagetitle'] : $title = ''; ?>

                            <div class="form-group">
                                <label for="name" class="control-label mb-1">Title</label>


                                <input type="text" name="pagetitle" class="form-control" value="<?= $title ?>" required>
                            </div>

                            <?php isset($result['content']['meta_title']) ?

                                $meta_title = $result['content']['meta_title'] : $meta_title = ''; ?>

                            <div class="form-group mt-3">
                                <label for="meta_title" class="control-label mb-1">Meta Title</label>
                                <input type="text" name="meta_title" value="<?= $meta_title ?>" class="form-control" />
                            </div>

                            <?php isset($result['content']['meta_desc']) ?

                                $metad = $result['content']['meta_desc'] : $metad = ''; ?>

                            <div class="form-group mt-3">
                                <label for="meta_desc" class="control-label mb-1">Meta Description</label>
                                <input type="text" name="meta_desc" class="form-control" value="<?= $metad ?>">
                            </div>

                            <?php isset($result['content']['meta_keywords']) ?

                                $metak = $result['content']['meta_keywords'] : $metak = ''; ?>

                            <div class="form-group mt-3">
                                <label for="meta_keywords" class="control-label mb-1">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="<?= $metak ?>">
                            </div>

                            <?php isset($result['content']['banner_text']) ?

                                $banner_text = $result['content']['banner_text'] : $banner_text = ''; ?>

                            <div class="form-group mt-3">
                                <label for="banner_text" class="control-label mb-1">Banner Text</label>
                                <input type="text" name="banner_text" class="form-control" value="<?= $banner_text ?>">
                            </div>
                            @if($result['page_data']->page_id == 96)
                            <?php isset($result['content']['refund_page_heading']) ?

                                $refund_page_heading = $result['content']['refund_page_heading'] : $refund_page_heading = ''; ?>
                            <div class="form-group mt-3">
                                <label for="refund_page_heading" class="control-label mb-1">Refund Page Heading</label>
                                <input type="text" name="refund_page_heading" class="form-control" value="<?= $refund_page_heading ?>">
                            </div>

                            <?php isset($result['content']['refund_page_button']) ?

                                $refund_page_button = $result['content']['refund_page_button'] : $refund_page_button = ''; ?>
                            <div class="form-group mt-3">
                                <label for="refund_page_button" class="control-label mb-1">Refund Page Button</label>
                                <input type="text" name="refund_page_button" class="form-control" value="<?= $refund_page_button ?>">
                            </div>

                            <?php isset($result['content']['refund_page_button_url']) ?

                                $refund_page_button_url = $result['content']['refund_page_button_url'] : $refund_page_button_url = ''; ?>
                            <div class="form-group mt-3">
                                <label for="refund_page_button_url" class="control-label mb-1">Refund Page Button URL</label>
                                <input type="text" name="refund_page_button_url" class="form-control" value="<?= $refund_page_button_url ?>">
                            </div>
                            @endif
                            @if($result['page_data']->page_id == 77)
                            <?php isset($result['content']['header_text']) ?

                                $header_text = $result['content']['header_text'] : $header_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="header_text" class="control-label mb-1">Header Text</label>
                                <input type="text" name="header_text" class="form-control" value="<?= $header_text ?>">
                            </div>
                            @endif
                            @if($result['page_data']->page_id == 119)
                            <?php isset($result['content']['empty_reviews_text']) ?

                                $empty_reviews_text = $result['content']['empty_reviews_text'] : $empty_reviews_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="empty_reviews_text" class="control-label mb-1">Empty Reviews Text</label>
                                <input type="text" name="empty_reviews_text" class="form-control" value="<?= $empty_reviews_text ?>">
                            </div>
                            @endif
                            @if($result['page_data']->page_id == 91)
                            <?php isset($result['content']['wishlist_head_text']) ?

                                $wishlist_head_text = $result['content']['wishlist_head_text'] : $wishlist_head_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="wishlist_head_text" class="control-label mb-1">Wishlist Main Text</label>
                                <input type="text" name="wishlist_head_text" class="form-control" value="<?= $wishlist_head_text ?>">
                            </div>
                            <?php isset($result['content']['wishlist_empty_text']) ?

                                $wishlist_empty_text = $result['content']['wishlist_empty_text'] : $wishlist_empty_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="wishlist_empty_text" class="control-label mb-1">Wishlist Empty Text</label>
                                <input type="text" name="wishlist_empty_text" class="form-control" value="<?= $wishlist_empty_text ?>">
                            </div>

                            <?php isset($result['content']['wishlist_empty_text_two']) ?

                                $wishlist_empty_text_two = $result['content']['wishlist_empty_text_two'] : $wishlist_empty_text_two = ''; ?>
                            <div class="form-group mt-3">
                                <label for="wishlist_empty_text_two" class="control-label mb-1">Wishlist Empty Text Two</label>
                                <input type="text" name="wishlist_empty_text_two" class="form-control" value="<?= $wishlist_empty_text_two ?>">
                            </div>

                            <?php isset($result['content']['wishlist_btn_text']) ?

                                $wishlist_btn_text = $result['content']['wishlist_btn_text'] : $wishlist_btn_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="wishlist_btn_text" class="control-label mb-1">Wishlist Empty Text</label>
                                <input type="text" name="wishlist_btn_text" class="form-control" value="<?= $wishlist_btn_text ?>">
                            </div>

                            <?php isset($result['content']['wishlist_btn_link']) ?

                                $wishlist_btn_link = $result['content']['wishlist_btn_link'] : $wishlist_btn_link = ''; ?>
                            <div class="form-group mt-3">
                                <label for="wishlist_btn_link" class="control-label mb-1">Wishlist Empty Link</label>
                                <input type="text" name="wishlist_btn_link" class="form-control" value="<?= $wishlist_btn_link ?>">
                            </div>
                            @endif
                            @if($result['page_data']->page_id == 90)
                            <?php isset($result['content']['cart_head_text']) ?

                                $cart_head_text = $result['content']['cart_head_text'] : $cart_head_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="cart_head_text" class="control-label mb-1">Cart Main Text</label>
                                <input type="text" name="cart_head_text" class="form-control" value="<?= $cart_head_text ?>">
                            </div>
                            <?php isset($result['content']['cart_empty_text']) ?

                                $cart_empty_text = $result['content']['cart_empty_text'] : $cart_empty_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="cart_empty_text" class="control-label mb-1">Cart Empty Text</label>
                                <input type="text" name="cart_empty_text" class="form-control" value="<?= $cart_empty_text ?>">
                            </div>

                            <?php isset($result['content']['cart_empty_text_two']) ?

                                $cart_empty_text_two = $result['content']['cart_empty_text_two'] : $cart_empty_text_two = ''; ?>
                            <div class="form-group mt-3">
                                <label for="cart_empty_text_two" class="control-label mb-1">Cart Empty Text Two</label>
                                <input type="text" name="cart_empty_text_two" class="form-control" value="<?= $cart_empty_text_two ?>">
                            </div>

                            <?php isset($result['content']['cart_btn_text']) ?

                                $cart_btn_text = $result['content']['cart_btn_text'] : $cart_btn_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="cart_btn_text" class="control-label mb-1">Cart Empty Text</label>
                                <input type="text" name="cart_btn_text" class="form-control" value="<?= $cart_btn_text ?>">
                            </div>

                            <?php isset($result['content']['cart_btn_link']) ?

                                $cart_btn_link = $result['content']['cart_btn_link'] : $cart_btn_link = ''; ?>
                            <div class="form-group mt-3">
                                <label for="cart_btn_link" class="control-label mb-1">Cart Empty Link</label>
                                <input type="text" name="cart_btn_link" class="form-control" value="<?= $cart_btn_link ?>">
                            </div>
                            @endif
                            @if($result['page_data']->page_id == 117)

                            <?php isset($result['content']['desc_banner']) ?

                                $desc_banner = $result['content']['desc_banner'] : $desc_banner = ''; ?>
                            <div class="form-group mt-3">
                                <label for="desc_banner" class="control-label mb-1">Banner Description</label>
                                <input type="text" name="desc_banner" class="form-control" value="<?= $desc_banner ?>">
                            </div>
                            <?php isset($result['content']['btn_text']) ?

                                $btn_text = $result['content']['btn_text'] : $btn_text = ''; ?>
                            <div class="form-group mt-3">
                                <label for="btn_text" class="control-label mb-1">Button Text</label>
                                <input type="text" name="btn_text" class="form-control" value="<?= $btn_text ?>">
                            </div>

                            <?php isset($result['content']['btn_link']) ?

                                $btn_link = $result['content']['btn_link'] : $btn_link = ''; ?>
                            <div class="form-group mt-3">
                                <label for="btn_link" class="control-label mb-1">Button Link</label>
                                <input type="text" name="btn_link" class="form-control" value="<?= $btn_link ?>">
                            </div>
                            @endif
                            <div class="form-group d-none mt-3">
                                <label for="name" class="control-label mb-1">Slug</label>
                                <input type="text" name="slug" class="form-control" value="<?= $result['page_data']->slug ?>" required>
                            </div>

                            <div class="form-group d-none mt-3">
                                <label for="page_type" name="type" class="control-label mb-1">
                                    Template
                                </label>
                                <select id="page_type" name="template" class="form-control">
                                    <option value="<?= $result['page_data']->template ?>"><?= ucfirst($result['page_data']->template) ?></option>
                                </select>
                            </div>

                            <div class="form-group mt-3">

                                <label for="header-logo" class="control-label mb-1">
                                    Banner Image
                                </label>

                                <?php

                                isset($result['content']['banner_image']['path']) && !empty($result['content']['banner_image']['path']) ?

                                    $condition = true : $condition = false;

                                $condition ? $c1 = 'featured' : $c1 = '';

                                $condition ? $c2 = '' : $c2 = 'd-none';

                                $condition ? $img = $result['content']['banner_image']['path'] : $img = '';

                                $condition ? $id = $result['content']['banner_image']['id'] : $id = ''; ?>

                                <div class="featuredWrap <?= $c1 ?>">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" name="banner_image" value="<?= $id ?>"
                                        id="banner_image">

                                    <img src="<?= asset($img) ?>" class="w-100 <?= $c2 ?>">

                                </div>

                            </div>

                        </div>
                        <div class="col-md-8">

                            @include('admin.templates.default',['content' => $result['content']])

                        </div>

                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="form-group">

                                <div class="content-insert">

                                    @if(isset($result['template']))

                                    @include('admin.templates.fields',['fields' => $result['template'] , 'result' => $result])

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary"><?= trans('labels.Submit') ?></button>
                <a href="<?= URL::to('admin/page/list') ?>" type="button" class="btn btn-default"><?= trans('labels.back') ?></a>
            </div>

            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection