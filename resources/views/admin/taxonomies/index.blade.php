@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Add <?=$data['taxonomy_data']['taxonomy_title']?><small></small> </h1>

        <ol class="breadcrumb">

            <li><a href="<?=asset('admin/list/'.$data['taxonomy_data']['post_type'])?>">Back</a></li>

        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-8">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">Add <?=$data['taxonomy_data']['taxonomy_title']?></h3>

                    </div>

                    <div class="box-body">

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
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="draggable-container">
                                    @foreach ( $data['terms']['data'] as  $key=> $term )

                                    <tr class="shallow-draggable" draggable="true" sort-order="<?=$term['sort_order']?>" id=<?=$term['terms_id']?> type="terms">

                                        <td>{{$term['terms_id']}}</td>

                                        <div class="actions"></div>

                                        <td>{{$term['term_title']}}</td>

                                        <td>{{$term['term_slug']}}</td>
                                        <td class="careerFilter">

                                            <div class="child_option position-relative">

                                                <button class="dots open-menu2 bg-transparent border-0 p-0" type="button"><svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path></svg></button> 

                                                <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">   

                                                    <ul class="careerFilterInr">

                                                        <li>
                                                            <a href="<?=asset('admin/taxonomy/edit/'.$term['terms_id'] )?>" class="w-100 border-0 d-flex justify-content-between">
                                                                Edit
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:delete_popup('<?=asset('admin/taxonomy/delete')?>',<?=$term['terms_id']?>);" class="w-100 border-0 d-flex justify-content-between">
                                                                Delete
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                            </a>
                                                        </li>

                                                    </ul>

                                                </div>

                                            </div>                                        

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>
<div class="row align-items-center justify-content-between mt-3">
    <div class="col-sm-12 col-md-6">
        <div class="dataTables_info" role="status" aria-live="polite">
                                        Showing {{ $data['terms']['from'] ?? 0 }} to {{ $data['terms']['to'] ?? 0 }} of {{ $data['terms']['total'] ?? 0 }} entries
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
<div class="dataTables_paginate paging_simple_numbers d-flex justify-content-end">
    <ul class="pagination mb-0">

        @foreach ($data['terms']['links'] as $item)
            @php
                $link = $item['url'] ? $item['url'] : 'javascript:;';
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

            <div class="col-md-4">

                <div class="box">

                    <div class="box-header">
                        <h2 class="box-title">
                            Add {{$data['taxonomy_data']['taxonomy_title']}}
                        </h2>
                    </div>


                    <div class="box-body">

                        <form action="{{asset('admin/taxonomy/create')}}" class="js-form">

                            @csrf

                            <input type="hidden" name="taxonomy_id" class="form-data" value="{{$data['taxonomy_data']['id']}}">



                            <div class="form-group">

                                <label for="name" class="control-label mb-3">Title</label>

                                <input type="text" name="term_title" class="pagetitle form-control form-data required">

                            </div>



                            <div class="form-group my-3">

                                <label for="term_slug" class="control-label mb-3">Slug</label>

                                <input type="text" name="slug" class="form-control form-data required">

                            </div>

 <div class="form-group mt-3">

                                <label for="status" class="control-label">Status</label>

                                <select name="status" id="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>

                            </div>

                            @includeIf('admin.taxonomies.fields.'.$data["taxonomy_data"]["taxonomy_slug"])



                            <button type="submit" class="btn btn-primary form-submit mt-3">Insert</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>


<script>

   function delete_popup(action,id){



    jQuery('.delete-modal').find('form').attr('action',action)



    jQuery('.delete-modal').find('#id').val(id)



    jQuery('.delete-modal').addClass('show')



    jQuery('.delete-modal').show()



}

</script>
@endsection

