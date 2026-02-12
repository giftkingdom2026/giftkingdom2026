@extends('admin.layout')

@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Add Brands<small></small> </h1>
<!-- 
        <ol class="breadcrumb">

            <li><a href="{{ asset('admin/category/list') }}">Back</a></li>

        </ol>
    -->
</section>


<section class="content">

    <div class="row">

        <div class="col-md-9">

            <div class="box">

                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif

                <div class="box-header">

                    <h3 class="box-title">Brands List</h3>

                </div>

                <div class="box-body">
<form method="GET" class="mb-3">
                            <div class="row align-items-center">


                                <div class="col-auto">
                                    <div class="form-group mb-0">
                                        <input type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Search" class="form-control">
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-group mb-0">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                    </div>
                                </div>

                                <div class="col d-flex justify-content-end">
                                    <div class="form-group mb-0">
                                        <label class="mb-0">
                                            Show
                                            <select name="length" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto mx-2">
                                                <option value="10" <?= (isset($_GET['length']) && $_GET['length'] == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="25" <?= (isset($_GET['length']) && $_GET['length'] == 25) ? 'selected' : '' ?>>25</option>
                                                <option value="50" <?= (isset($_GET['length']) && $_GET['length'] == 50) ? 'selected' : '' ?>>50</option>
                                                <option value="100" <?= (isset($_GET['length']) && $_GET['length'] == 100) ? 'selected' : '' ?>>100</option>
                                            </select>
                                            entries
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </form>
                    <div class="replace-table">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Title</th>

                                    <th>Image</th>

                                    <th>Slug</th>

                                    <th>Actions</th>

                                </tr>

                            </thead>

                            <tbody class="draggable-container">

                                @if( !empty($data['brands']['data']) )


                                @foreach ( $data['brands']['data'] as  $key=> $term )

                                <tr>

                                    <td>{{$term['brand_ID']}}</td>

                                    <td>{{$term['brand_title']}}</td>

                                    <td>
                                        <img src="<?=asset($term['brand_image'])?>" height="70" width="70">
                                    </td>

                                    <td>{{$term['brand_slug']}}</td>

                                    <td>

                                        <a href="{{asset('admin/brand/edit/'.$term['brand_ID'])}}" data-toggle="tooltip" data-placement="bottom" title="Edit" href="" class="badge bg-light-blue">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:delete_popup('{{asset('admin/brand/delete')}}',{{$term['brand_ID']}});"class="badge delete-popup bg-red">

                                            <i class="fa fa-trash" aria-hidden="true"></i>

                                        </a>

                                    </td>

                                </tr>

                                @endforeach

                                @else

                                @endif

                            </tbody>

                        </table>

                    </div>
<div class="row align-items-center justify-content-between mt-3">
    <div class="col-sm-12 col-md-6">
        @if (!empty($data['brands']['paginator']))
            @php
                $p = $data['brands']['paginator'];
                $from = ($p['current_page'] - 1) * $p['per_page'] + 1;
                $to = min($p['current_page'] * $p['per_page'], $p['total']);
            @endphp
            Showing {{ $from }} to {{ $to }} of {{ $p['total'] }} entries
        @endif
    </div>

    <div class="col-sm-12 col-md-6">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-md-end justify-content-center">
                @php
                    $queryParams = $_GET;
                    unset($queryParams['page']);
                @endphp

                @foreach ($data['brands']['paginator']['links'] as $item)
                    @php
                        $link = $item['url'] ?? 'javascript:;';
                        $disabledClass = $item['url'] === null ? 'disabled' : '';
                        $activeClass = $item['active'] ? 'active' : '';

                        if ($item['url'] !== null && !empty($queryParams)) {
                            $separator = strpos($link, '?') === false ? '?' : '&';
                            $link .= $separator . http_build_query($queryParams);
                        }
                    @endphp
                    <li class="page-item {{ $disabledClass }} {{ $activeClass }}">
                        <a class="page-link" href="{{ htmlspecialchars($link) }}">
                            {!! $item['label'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="box">

                <div class="box-header">
                    <h2 class="box-title">
                        Add Brand
                    </h2>
                </div>


                <div class="box-body">

                    <form class="js-form" action="{{asset('admin/brand/create')}}">

                        @csrf

                        <div class="form-group">

                            <label for="name" class="control-label mb-3">Title</label>

                            <input type="text" name="brand_title" class="pagetitle form-control form-data" required>

                        </div>

                        <input type="hidden" name="category_ID" value="<?=$data['cat']?>">

                        <div class="form-group my-3">

                            <label for="term_slug" class="control-label mb-3">Slug</label>

                            <input type="text" name="brand_slug" class="form-control slug form-data">

                        </div>

                        <?php 

                        if( $data['cat'] == null ) : ?>

                            <div class="form-group my-3">

                                <label for="parent_ID" class="control-label mb-3">Category</label>

                                <select id="parent_ID" name="category_ID" class="form-control">

                                    <option value="0" selected>None</option>
                                </select>

                            </div>


                        <?php else :?>

                            <input type="hidden" name="category_ID" value="<?=$data['cat']?>">

                        <?php endif;?>

                        <div class="form-group my-3">

                            <label for="brand_status" class="control-label">Status</label>

                            <select name="brand_status" id="brand_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                
                            </select>

                        </div>

                        <div class="form-group my-3">

                            <label for="featured_product" class="control-label mb-1">Featured Product</label>

                            <select class="product-select form-control" name="featured_product" id="featured_product">

                                <?php

                                foreach( $data['products'] as $product ) :  ?>

                                    <option value="<?=$product['ID']?>" >
                                        <?=$product['prod_title']?>
                                    </option>

                                <?php endforeach;?>

                            </select>

                        </div>

                        <div class="form-group mt-3">

                            <label for="brand_image" class="control-label mb-3">Image</label>

                            <div class="featuredWrap">

                                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                <input type="hidden" id="brand_image" 

                                name="brand_image" class="form-data" value="">

                                <img src="" alt="brand_image" class="w-100 d-none">

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Insert</button>

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

