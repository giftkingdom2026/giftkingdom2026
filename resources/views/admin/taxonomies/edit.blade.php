@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Edit {{$data['term_title']}}<small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?=asset('admin/taxonomy/'.$data['taxonomy']['taxonomy_slug'])?>">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">
                        <h2 class="box-title">
                            Edit {{$data['term_title']}}
                        </h2>
                    </div>


                    <div class="box-body">

                        <form action="{{asset('admin/taxonomy/update')}}" method="post">


                            @csrf

                            <input type="hidden" name="term_id" class="form-data" value="{{$data['terms_id']}}">
                            <input type="hidden" name="taxonomy_id" class="form-data" value="{{$data['taxonomy']['id']}}">

                            <div id="languageWrap">

                                <div class="form-group">

                                    <label for="name" class="control-label mb-3">Title</label>

                                    <input type="text" name="term_title" value="{{$data['term_title']}}" class="pagetitle form-control form-data" required>

                                </div>

                            </div>

                            <div class="form-group my-3">

                                <label for="term_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="term_slug" value="{{$data['term_slug']}}" class="form-control form-data">

                            </div>
                                        <?php $status = isset($data['status']) ? $data['status'] : 'active'; ?>

<div class="form-group mt-3">
    <label for="status" class="control-label mb-1">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
</div>
                            <div class="form-group my-2">
                                <label for="lang" class="control-label mb-1">Language</label>
                                <select id="change_lang" name="lang" data-url="<?=asset('admin/taxonomy/change_lang')?>" data-id="<?=$data['terms_id']?>" class="form-control">
                                    <option value="1">English</option>
                                    <option value="2">Arabic</option>
                                </select>
                            </div>

                            @includeIf('admin.taxonomies.fields.'.$data["taxonomy"]["taxonomy_slug"])



                            <button type="submit" class="btn btn-primary">Update</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>


@endsection

