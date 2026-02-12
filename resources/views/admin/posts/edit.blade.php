@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>Edit <?= ucfirst($data['post_data']['post_type']) ?><small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?= asset('admin/list/' . $data['post_data']['post_type']) ?>">Back</a></li>

        </ol>

    </section>



    <section class="content">



        <div class="box">

            @if(session()->has('success'))

            <div class="box-info">

                <div class="alert alert-success">

                    <?= session()->get('success') ?>

                </div>

            </div>

            @endif

            <div class="box-header">

                <h3 class="box-title">Edit <?= $data['post_data']['post_title'] ?></h3>

                <div class="box-tools pull-right">

                    <a href="<?= asset('admin/add/' . $data['post_data']['post_type']) ?>" type="button" class="btn btn-block btn-primary">Add New <?= substr($data['post_data']['post_type'], 0, -1) ?></a>


                    <?php if ($data['post_data']['post_type'] == 'press') : ?>

                        <a href="<?= asset('blog/' . $data['post_data']['post_name']) ?>" type="button" class="btn btn-block btn-primary">View <?= substr($data['post_data']['post_type'], 0, -1) ?></a>

                    <?php endif; ?>

                </div>

            </div>

            {!! Form::open(array('url' =>'admin/update/'.$data['post_data']['ID'], 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">

                <input type="hidden" name="ID" value="<?= $data['post_data']['ID'] ?>">

                <input type="hidden" name="post_type" value="<?= $data['post_data']['post_type'] ?>">

                <div class="row justify-content-end">

                    <div class="col-md-3">

                        <div class="form-group my-2">
                            <label for="lang" class="control-label mb-1">Language</label>
                            <select id="change_lang" name="lang" data-url="<?= asset('admin/posts/change_lang') ?>" data-id="<?= $data['post_data']['ID'] ?>" class="form-control">
                                <option value="1">English</option>
                                <option value="2">Arabic</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div id="languageWrap">

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Title</label>

                                <input type="text" name="pagetitle" class="pagetitle form-control required" value="<?= $data['post_data']['post_title'] ?>">

                            </div>

                            <?php

                            $meta_title = isset($data['post_data']['metadata']['meta_title']) ?

                                $data['post_data']['metadata']['meta_title'] : ''; ?>

                            <div class="form-group mt-3">
                                <label for="meta_title" class="control-label mb-1">Meta Title</label>
                                <input type="text" name="meta_title" value="<?= $meta_title ?>" class="form-control" />
                            </div>

                            <?php

                            isset($data['post_data']['metadata']['meta_desc']) ? $metadesc = $data['post_data']['metadata']['meta_desc'] : $metadesc = ''; ?>

                            <div class="form-group mt-3">

                                <label for="meta_desc" class="control-label mb-1">Meta Description</label>

                                <input type="text" name="meta_desc" value="<?= $metadesc ?>" class="form-control">

                            </div>

                            <?php

                            isset($data['post_data']['metadata']['meta_keywords']) ? $metakey = $data['post_data']['metadata']['meta_keywords'] : $metakey = ''; ?>

                            <div class="form-group mt-3">

                                <label for="meta_keywords" class="control-label mb-1">Meta Keywords</label>

                                <input type="text" name="meta_keywords" value="<?= $metakey ?>" class="form-control">

                            </div>

                            <div class="form-group mt-3">

                                <label for="name" class="control-label mb-1">Slug</label>

                                <input type="text" name="slug" value="<?= $data['post_data']['post_name'] ?>" class="form-control required">

                            </div>

                            <div class="d-none form-group mt-3">

                                <label for="name" class="control-label mb-1">Date</label>

                                <input type="text" name="created_at" value="<?= date('Y-m-d', strtotime($data['post_data']['created_at'])) ?>" class="flatpickr form-control" required>

                            </div>

                            <div class="form-group mt-3">

                                <label for="post_status" class="control-label mb-1">Status</label>
                                <select name="post_status" class="form-control">
                                    <option <?= $data['post_data']['post_status'] == 'publish' ? 'selected' : '' ?> value="publish">Publish</option>
                                    <option <?= $data['post_data']['post_status'] == 'draft' ? 'selected' : '' ?> value="draft">Draft</option>
                                </select>

                            </div>

                            @php $termslug = '' @endphp

                            @foreach($data['taxonomy'] as $key => $terms)

                            @php $termslug.=$key.',' @endphp

                            <div class="form-group mt-3">

                                <label for="<?= $key ?>" class="control-label mb-1">

                                    <?= ucfirst($key) ?>

                                </label>

                                <select class="form-control select2" multiple name="<?= $key ?>[]" id="<?= $key ?>">

                                    <option value="">

                                        Choose <?= ucfirst($key) ?>

                                    </option>


                                    @foreach($terms as $term)

                                    <?php

                                    if (!empty($data['post_data']['termdata'])) :

                                        in_array($term['terms_id'], $data['post_data']['termdata']) ?

                                            $attr = 'selected' :

                                            $attr = '';

                                    else :

                                        $attr = '';

                                    endif; ?>

                                    <option <?= $attr ?> value="<?= $term['terms_id'] ?>">

                                        <?= $term['term_title'] ?>

                                    </option>


                                    @endforeach

                                </select>

                            </div>

                            @endforeach


                            <input type="hidden" name="terms" value="<?= $termslug ?>">

@if($data['post_data']['post_type'] != 'faqs' && $data['post_data']['post_type'] != 'reasons')

                            <?php

                            ($data['post_data']['featured_image']['path'] == '') ? $c = 'd-none' : $c = '';
                            ($data['post_data']['featured_image']['path'] == '') ? $c2 = '' : $c2 = 'featured';

                            ?>

                            <div class="form-group mt-3">

                                <label for="featured_image" class="control-label mb-3">Featured Image</label>

                                <div class="featuredWrap <?= $c2 ?>">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" id="featured_image"

                                        name="featured_image" value="<?= $data['post_data']['featured_image']['id'] ?>">

                                    <img src="<?= asset($data['post_data']['featured_image']['path']) ?>" alt="featured_image" class="w-100 <?= $c ?>">

                                </div>

                            </div>
@endif
                            <div class="form-group mt-3">

                                <div class="form-group">

                                    <label for="excerpt" class="control-label mb-1">Excerpt</label>

                                    <textarea class="quilleditor" name="post_excerpt" height="150">{!!$data['post_data']['post_excerpt']!!}</textarea>

                                </div>

                            </div>
                            @if($data['post_data']['post_type'] == 'reasons')
                            <div class="form-group mt-3">
                                <label for="reason_type" class="control-label mb-1">Select Reason Type</label>
                                <select name="reason_type" class="form-control select2" id="reason_type">
                                    <option value="refund" {{ $data['post_data']['reason_type'] == 'refund' ? 'selected' : '' }}>Refund</option>
                                    <option value="cancel" {{ $data['post_data']['reason_type'] == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                </select>
                            </div>
                            @endif
                        </div>


                        <div class="col-md-8">

                            <div class="content-insert">


                                <div class="form-group">

                                    <label for="name" class="control-label mb-1">Content</label>

                                    <textarea class="quilleditor @if(!empty($data['post_type']) && $data['post_data']['post_type'] === 'blogs' || $data['post_data']['post_type'] === 'faqs')required @endif" name="post_content" height="678">

                                        <?php

                                        if (isset($data['post_data']['post_content'])) :

                                            echo ($data['post_data']['post_content']);

                                        endif; ?>

                                    </textarea>

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

                                <input type="hidden" name="fields" value="meta_desc,meta_keywords,meta_title,<?= substr($str, 1) ?>">

                                @include('admin.templates.fields',['fields' => $fields , 'result' => [ 'content' => $data['post_data']['metadata'] ] ])

                                @else

                                <?php $data['post_data']['post_type'] == 'offers' ? $extrafields = ',product_ID,slogan,price_flash' : $extrafields = ''; ?>

                                <input type="hidden" name="fields" value="meta_desc,meta_keywords,meta_title<?= $extrafields ?>">

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="box-footer text-center">

                <button type="submit" class="btn btn-primary">Submit</button>

                <a href="<?= URL::to('admin/list/' . $data['post_data']['post_type']) ?>" type="button" class="btn btn-default">Back</a>

            </div>

            {!! Form::close() !!}

        </div>

    </section>

</div>

@endsection