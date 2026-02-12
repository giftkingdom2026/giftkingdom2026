@extends('admin.layout')

@section('content')



<div class="content-wrapper">

    <section class="content-header">



        <h1>Add {{$data['post_type']['title']}}</h1>



        <ol class="breadcrumb">

            <li>

                <a href="{{ asset('admin/list/'.$data['post_type']['type']) }}">

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


            {!! Form::open(array('url' =>'admin/create/'.$data["post_type"]["type"], 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

            <div class="box-body">


                <input type="hidden" name="post_type" value="{{$data['post_type']['type']}}">

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="name" class="control-label mb-1">Title</label>

                            <input type="text" name="pagetitle" class="pagetitle form-control required @if(!empty($data['post_type']) && $data['post_type']['type'] === 'blogs' || $data['post_type']['type'] === 'faqs')required @endif">

                        </div>

                        <div class="form-group mt-3">
                            <label for="meta_title" class="control-label mb-1">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"/>
                        </div>

                        <div class="form-group mt-3 ">

                            <label for="meta_desc" class="control-label mb-1">Meta Description</label>

                            <input type="text" name="meta_desc" class="form-control">

                        </div>



                        <div class="form-group mt-3">

                            <label for="meta_keywords" class="control-label mb-1">Meta Keywords</label>

                            <input type="text" name="meta_keywords" class="form-control">

                        </div>

                        <div class="form-group mt-3">

                            <label for="name" class="control-label mb-1">Slug</label>

                            <input type="text" name="slug" class="form-control required">

                        </div>

                        <div class="form-group mt-3">

                            <label for="post_status" class="control-label mb-1">Status</label>
                            <select name="post_status" class="form-control">
                                <option value="publish">Publish</option>
                                <option value="draft">Draft</option>
                            </select>

                        </div>

                        @php $termslug = '' @endphp

                        @foreach($data['taxonomy'] as $key => $terms)
                        
                        @php $termslug.=$key.',' @endphp

                        <div class="form-group mt-3">

                            <label for="{{$key}}" class="control-label mb-1">

                                {{ucfirst($key)}}

                            </label>
                            <select class="form-control select2 @if(!empty($data['post_type']) && $data['post_type']['type'] === 'blogs')required @endif" multiple placeholder="Choose {{ucfirst($key)}}" name="{{$key}}[]" id="{{$key}}" >

                                @foreach($terms as $term)

                                <option value="{{$term['terms_id']}}">

                                    {{$term['term_title']}}

                                </option>


                                @endforeach

                            </select>

                        </div>

                        @endforeach


                        <input type="hidden" name="terms" value="{{$termslug}}">
@if($data['post_type']['type'] != 'faqs' && $data['post_type']['type'] != 'reasons')

                        <div class="form-group mt-3">

                            <label for="featured_image" class="control-label mb-1">Featured Image</label>

                            <div class="featuredWrap">

                                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                <input type="hidden" id="featured_image" name="featured_image" class="required" value="">

                                <img src="" alt="featured_image" class="w-100 d-none">

                            </div>

                        </div>
@endif
                        <div class="form-group mt-3">

                            <div class="form-group">

                                <label for="excerpt" class="control-label mb-1">Excerpt</label>

                                <textarea class="quilleditor" name="post_excerpt" height="150" id="post_excerpt" height="150"></textarea>

                            </div>

                        </div>
@if($data['post_type']['type'] == 'reasons')
 <div class="form-group mt-3">

                                <label for="reason_type" class="control-label mb-1">Select Reason Type</label>

                                <select name="reason_type" class="form-control select2" id="reason_type">


                                        <option value="refund">Refund</option>
                                        <option value="cancel">Cancel</option>

                                </select>

                            </div>
@endif
                    </div>

                    <div class="col-md-8">

                        <?php 

                        if( $data['post_type']['type'] == 'offers' ) : ?>

                            <div class="form-group">

                                <label for="slogan" class="control-label mb-1">Slogan</label>

                                <input type="text" name="slogan" class="form-control" required>

                            </div>

                            <div class="form-group mt-3">

                                <label for="product_ID" class="control-label mb-1">Offer Product</label>

                                <select name="product_ID" class="form-control select2" id="product_ID">

                                    <?php

                                    foreach($data['products'] as $product) : ?>

                                        <option value="<?=$product['ID']?>"><?=$product['prod_title']?></option>

                                    <?php endforeach;?>

                                </select>

                            </div>

                            <div class="form-group d-none mt-3">

                                <label for="price_flash" class="control-label mb-1">Price Flash</label>

                                <select name="price_flash" class="form-control select2" id="price_flash">
                                    <option>Hide</option>
                                    <option>Show</option>
                                </select>

                            </div>

                            <input type="hidden" name="post_content" value="">
                            
                        <?php else :?>

                            <div class="form-group">

                                <label for="name" class="control-label mb-1">Content</label>

<textarea 
    class="quilleditor @if(!empty($data['post_type']) && $data['post_type']['type'] === 'blogs' || $data['post_type']['type'] === 'faqs')required @endif" 
    name="post_content"
    style="height: 650px;"
></textarea>

                            </div>

                        <?php endif;?>


                    </div>

                </div>

                <div class="row mt-5">

                    <div class="col-md-12">

                        <div class="content-insert">

                          @if($data['template'] != null)

                          <?php 

                          $fields = $data['template']->data;

                          $post_fields = unserialize($fields) ;

                          $str = '';

                          foreach($post_fields as $sec) :

                            foreach($sec['data'] as $key => $items ):

                                $str.=','.$items['key'];

                            endforeach;

                        endforeach;  ?>

                        <input type="hidden" name="fields" value="meta_desc,meta_keywords,meta_title,<?=substr($str, 1)?>">

                        @include('admin.templates.fields',['fields' => $fields , 'result' => [ 'content' => $data['post_type'] ] ] )

                        @else

                        <?php $data['post_type']['type'] == 'offers' ? $extrafields = ',product_ID,slogan,price_flash' : $extrafields = '';?>

                        <input type="hidden" name="fields" value="meta_desc,meta_keywords,meta_title<?=$extrafields?>">

                        @endif


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

