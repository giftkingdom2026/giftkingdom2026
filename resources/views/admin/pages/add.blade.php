@extends('admin.layout')
@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <h1> Add Page</h1>
        <ol class="breadcrumb">
            <li><a href="{{ asset('admin/page/list') }}">Back</a></li>
        </ol>
    </section>


    <section class="content">
        <div class="box">

         @if ( isset($success) )
         <div class="box box-info">
             @foreach($success->all() as $success)
             <div class="alert alert-success" role="alert">
                {{ $success }}
            </div>
            @endforeach
        </div>
        @endif


        {!! Form::open(array('url' =>'admin/page/create', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

        <div class="box-body">

            <div class="row">
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="name" class="control-label mb-1">Title</label>

                        <input type="text" name="pagetitle" class="pagetitle form-control" required/>
                    </div>

                    <div class="form-group mt-3">
                        <label for="meta_title" class="control-label mb-1">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control"/>
                    </div>

                    <div class="form-group mt-3">
                        <label for="meta_desc" class="control-label mb-1">Meta Description</label>
                        <input type="text" name="meta_desc" class="form-control"/>
                    </div>

                    <div class="form-group mt-3">
                        <label for="meta_keywords" class="control-label mb-1">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control"/>
                    </div>

                    <div class="form-group mt-3">
                        <label for="banner_text" class="control-label mb-1">Banner Text</label>
                        <input type="text" name="banner_text" class="form-control"/>
                    </div>


                    <div class="form-group mt-3">
                        <label for="name" class="control-label mb-1">Slug</label>
                        <input type="text" name="slug" class="form-control" required/>
                    </div>

                    <div class="form-group mt-3 d-none">
                        <label for="page_type" name="type" class="control-label mb-1">
                            Template
                        </label>
                        <select id="page_type" name="template" class="form-control">

                            <option value="default" default selected>Default</option>
<!-- 
                            @foreach( $result['templates'] as $template ) :

                                        <option value="{{$template->id}}">{{$template->name}}</option>

                            @endforeach; -->

                        </select>
                    </div>

                    <div class="form-group mt-3">

                        <label for="banner_image" class="control-label mb-1">
                            Banner Image
                        </label>

                        <div class="featuredWrap">

                            <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                            <input type="hidden" name="banner_image" value=""
                            id="banner_image"/>

                            <img src="" class="d-none w-100"/>

                        </div>

                    </div>
                </div>


                <div class="col-md-8">

                    <div class="form-group">

                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Content</label>
                            <textarea class="quilleditor" name="content"  id="content" height="530"></textarea>
                        </div>
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
        <div class="box-footer text-center">
            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
            <a href="{{ URL::to('admin/page/list')}}" type="button" class="btn btn-primary">{{ trans('labels.back') }}</a>
        </div>
        {!! Form::close() !!}
    </div>
</section>
</div>

@endsection
