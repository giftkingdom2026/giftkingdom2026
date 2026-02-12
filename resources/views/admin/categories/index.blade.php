@extends('admin.layout')

@section('content')
<?php

$condition = str_contains(Route::current()->uri(), 'deals') ? true : false; ?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>Add <?= $condition ? 'Deal' : 'Category' ?><small></small> </h1>
        <!-- 
        <ol class="breadcrumb">

            <li><a href="{{ asset('admin/categories/display') }}">Back</a></li>

        </ol> -->

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-9">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title"><?= $condition ? 'Deal' : 'Category' ?> List</h3>

                    </div>

                    <div class="box-body">

                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        @endif

                        <div class="replace-table">
<div class="row mb-3 align-items-center justify-content-between">
    <!-- Entries dropdown -->
    <div class="col-sm-12 col-md-6">
        <form method="GET" id="perPageForm" class="d-inline">
            <label>
                Show
                <select name="length" onchange="document.getElementById('perPageForm').submit()" class="form-select form-select-sm d-inline w-auto mx-2">
                    <option value="10" {{ request('length') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('length') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('length') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('length') == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </form>
    </div>

    <!-- Search -->
    <div class="col-sm-12 col-md-6">
        <form method="GET" class="d-flex justify-content-md-end">
            <label class="d-flex align-items-center gap-2 mb-0">
                Search:
                <input type="search"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control form-control-sm"
                    placeholder=""
                    onchange="this.form.submit()"
                >
            </label>
        </form>
    </div>
</div>

<div class="new-replace-table">

                            <table id="example1" class="table table-bordered table-striped">

                                <thead>

                                    <tr>
<th>
                                                <input type="checkbox" name="select" class="select-all">
                                            </th>
                                        <th>ID</th>

                                        <th>Image</th>

                                        <th>Title</th>

                                        <th>Slug</th>

                                        <th></th>

                                    </tr>

                                </thead>

                                <tbody class="draggable-container">

                                    @php
                                    $url = str_contains(Route::current()->uri(), 'deals') ? 'deals' : 'category';
                                    @endphp

                                    @if(!empty($data['list']['categories']))
                                    @php $first = reset($data['list']['categories'])['sort_order']; @endphp

                                    @foreach($data['list']['categories'] as $term)
                                    <tr class="shallow-draggable"
                                        draggable="true"
                                        start="{{ $first }}"
                                        sort-order="{{ $term['sort_order'] }}"
                                        id="{{ $term['category_ID'] }}"
                                        type="category">
                    <td><input type="checkbox" class="row-select" data-id="{{ $term['category_ID'] }}"></td>

                                        <td>{{ $term['category_ID'] }}</td>

                                        <td>
                                            <img height="50" width="50" src="{{ asset($term['category_image']['path']) }}" alt="Image">
                                        </td>

                                        <td>{{ $term['category_title'] }}</td>

                                        <td>{{ $term['categories_slug'] }}</td>

                                        <td class="careerFilter">
                                            <div class="child_option position-relative">
                                                <button class="dots open-menu2 bg-transparent border-0 p-0" type="button">
                                                    <svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                                        <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                                                    </svg>
                                                </button>

                                                <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">
                                                    <ul class="careerFilterInr">
                                                        <li>
                                                            <a href="{{ asset('admin/' . $url . '/edit/' . $term['category_ID']) }}"
                                                                class="w-100 border-0 d-flex justify-content-between">
                                                                Edit
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 512 512">
                                                                    <path d="M441 58.9L453.1 71c9.4 9.4..." />
                                                                </svg>
                                                            </a>
                                                        </li>

                                                        @if (!empty($term['children']))
                                                        <li>
                                                            <a href="javascript:;" data-parent="{{ $term['parent_ID'] }}"
                                                                data-id="{{ $term['category_ID'] }}"
                                                                class="show-children w-100 border-0 d-flex justify-content-between">
                                                                View
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                                    viewBox="0 0 320 512">
                                                                    <path d="M310.6 233.4c12.5..." />
                                                                </svg>
                                                            </a>
                                                        </li>
                                                        @endif

                                                        <li>
                                                            <a href="javascript:delete_popup('{{ asset('admin/' . $url . '/delete') }}', {{ $term['category_ID'] }});"
                                                                class="w-100 border-0 d-flex justify-content-between">
                                                                Delete
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512">
                                                                    <path d="M135.2 17.7L128 32..." />
                                                                </svg>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6">{{ trans('labels.NoRecordFound') }}</td>
                                    </tr>
                                    @endif

                                </tbody>


                            </table>
</div>

 <div class="multi-delete" style="display: none; z-index:9999">
                                    <input type="hidden" name="selected_rows" value="" id="selected_rows">
                                    <a href="javascript:delete_popup('{{asset('admin/category/delete')}}','');" 
                                    class="badge delete-multiple-popup bg-red">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="row align-items-center justify-content-between mt-3">

                                <!-- Entries info -->
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_info" role="status" aria-live="polite">
                                        Showing {{ $data['cat']['from'] ?? 0 }} to {{ $data['cat']['to'] ?? 0 }} of {{ $data['cat']['total'] ?? 0 }} entries
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_paginate paging_simple_numbers d-flex justify-content-end">
                                        <ul class="pagination mb-0">

                                            @foreach ($data['cat']['links'] as $item)
                                            @php
                                            $link = $item['url'] ? str_replace('create', 'list', $item['url']) : 'javascript:;';
                                            $disabled = $item['url'] ? '' : 'disabled';
                                            $active = $item['active'] ? 'active' : '';
                                            @endphp

                                            <li class="page-item {{ $disabled }} {{ $active }}">
                                                <a class="page-link" href="{{ $link }}">{!! $item['label'] !!}</a>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="box">

                    <div class="box-header">
                        <h2 class="box-title">
                            Add Category
                        </h2>
                    </div>


                    <div class="box-body">

                        <form class="js-form" action="{{asset('admin/'.$url.'/create')}}">

                            @csrf

                            <div class="form-group">

                                <label for="name" class="control-label mb-3">Title</label>

                                <input type="text" name="category_title" class="pagetitle form-control form-data" required>

                            </div>

                            <div class="form-group my-3">

                                <label for="term_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="categories_slug" class="form-control slug form-data">

                            </div>

                            <div class="form-group my-3">

                                <label for="metatitle" class="control-label mb-3">Meta Title</label>

                                <input type="text" name="meta[metatitle]" id="metatitle" class="form-control form-data">

                            </div>

                            <div class="form-group my-3">

                                <label for="metakeywords" class="control-label mb-3">Meta Keywords</label>

                                <input type="text" name="meta[metakeywords]" id="metakeywords" class="form-control form-data">

                            </div>

                            <div class="form-group my-3">

                                <label for="metadesc" class="control-label mb-3">Meta Description</label>

                                <input type="text" name="meta[metadesc]" id="metadesc" class="form-control form-data">

                            </div>

 <div class="form-group mt-3">

                                <label for="status" class="control-label mb-1">Status</label>

                                <select name="status" id="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>

                            </div>
                            <?php

                            if (!$condition) : ?>

                                <div class="form-group my-3">

                                    <label for="parent_ID" class="control-label mb-3">Parent</label>

                                    <select id="parent_ID" name="parent_ID" class="form-control">
                                        <option value="0" selected>None</option>
                                    </select>

                                </div>

                            <?php endif; ?>

                            <div class="form-group mt-3">

                                <label for="category_image" class="control-label mb-3">Image</label>

                                <div class="featuredWrap">

                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                    <input type="hidden" id="category_image"

                                        name="category_image" class="form-data" value="">

                                    <img src="" alt="category_image" class="w-100 d-none">

                                </div>



                            </div>


                            <div class="form-group d-none my-3">

                                <div class="form-group">

                                    <label for="description" class="control-label mb-1">Description</label>

                                    <div class="quilleditor form-data" name="description" id="description" height="150" menu="false"></div>

                                </div>

                            </div>
                            <div class="form-group my-3 form-check">
                                <input type="hidden" name="is_hidden" value="0">
                                <input type="checkbox" class="form-check-input" id="is_hidden" name="is_hidden" value="1">
                                <label class="form-check-label" for="is_hidden">Hidden From The Filters?</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Insert</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>

<script type="text/javascript">
    function delete_popup(action, id) {

        id = id == '' ? jQuery('#selected_rows').val() : id

        jQuery('.delete-modal').find('form').attr('action', action)

        jQuery('.delete-modal').find('#id').val(id)

        jQuery('.delete-modal').addClass('show')

        jQuery('.delete-modal').show()

    }
</script>
@endsection