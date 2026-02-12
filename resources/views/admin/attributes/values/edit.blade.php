@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit {{$data['value_title']}}<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?=asset('admin/attribute/values/'.$data['attribute_ID'])?>">Back</a></li>

        </ol>

    </section>

    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">
                        <h2 class="box-title">
                            Edit {{$data['value_title']}}
                        </h2>
                    </div>


                    <div class="box-body">

                        <form action="{{asset('admin/attribute/value/update')}}" method="post">


                            @csrf

                            <input type="hidden" name="value_ID" class="form-data" value="{{$data['value_ID']}}">

                            <div id="languageWrap">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-3">Title</label>

                                    <input type="text" name="value_title" value="{{$data['value_title']}}" class="pagetitle form-control form-data" required>

                                </div>
                            
                            </div>

                            <div class="form-group my-3">

                                <label for="term_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="value_slug" value="{{$data['value_slug']}}" class="form-control form-data">

                            </div>

                            <?php $attr = $data['value_type'] != 'image' ? 'style="display:none"' : '';?>

                            <div class="form-group my-3 image_div" <?=$attr?>>

                                <label for="value_image" class="control-label mb-3">Image</label>

                                <div class="featuredWrap">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" id="value_image" 

                                    name="value_image" class="form-data" value="<?=$data['value_image']['id']?>">

                                    <img src="<?=$data['value_image']['path']?>" alt="value_image" class="w-100 d-none">

                                </div>

                            </div>

                            <div class="form-group my-2">
                                <label for="lang" class="control-label mb-1">Language</label>
                                <select id="change_lang" name="lang" data-url="<?=asset('admin/attribute/value/change_lang')?>" data-id="<?=$data['value_ID']?>" class="form-control">
                                    <option value="1">English</option>
                                    <option value="2">Arabic</option>
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

