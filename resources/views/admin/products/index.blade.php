@extends('admin.layout')

@section('content')



<?php //dd($data); ?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>Products</h1>

        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/product/add/') }}" type="button" class="btn-block"><i class="fa fa-plus"></i>Add Product</a></li>
        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    @if(session()->has('success'))

                    <div class="box-info">

                        <div class="alert alert-success">

                            {{ session()->get('success') }}

                        </div>

                    </div>

                    @endif

                    <div class="box-header">

                        <h3 class="box-title">Listing</h3>

                        <div class="box-tools pull-right">

                            <a href="<?=asset('admin/product/import/')?>" class="btn d-none btn-primary"><i class="fa fa-plus"></i>Import Products</a>

                        </div>

                    </div>

                    <div class="box-body">

                        <div class="row">

                            <div class="col-xs-12">

                                <form method="GET" class="mb-3">
  <div class="row align-items-center">

    <div class="col-auto">
      <div class="form-group mb-0">
        <select name="cat" id="cate" class="form-control">
          <option value="All">All</option>
          <?php foreach($cats as $cat):
            $attr = isset($_GET['cat']) && $_GET['cat'] == $cat['category_ID'] ? 'selected' : ''; ?>
            <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

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


                                <div class="table-wrap">

                                    <table class="table table-bordered table-striped">

                                        <thead>

                                            <tr>

                                                <th>
                                                    <input type="checkbox" name="select" class="select-all">
                                                </th>

                                                <th>Image</th>

                                                <th>Title</th>

                                                <th>Data</th>

                                                <th style="
    width: 35%;
">Category</th>

                                                <!-- <th>Brand</th> -->

                                                <th>Status</th>

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody class="draggable-container">

                                            @if( !empty($data['data']) )

                                            <?php

                                            $first = reset($data['data']); ?>

                                            @foreach ( $data['data'] as  $key=> $prod )

                                            <!-- <tr class="shallow-draggable" draggable="true" start="<?=$first['sort_order']?>" sort-order="<?=$prod['sort_order']?>" id=<?=$prod['ID']?> type="posts"> -->
                                                <tr>

                                                    <td>
                                                        <input type="checkbox" name="select" class="row-select" data-id="<?=$prod['ID']?>">
                                                    </td>


                                                    <td>
                                                        <img src="<?=asset($prod['prod_image']['path'])?>" width="50" height="50" style="object-fit: cover;">
                                                    </td>

                                                    <td>

                                                        <?php $title = explode(' ', $prod['prod_title']);?>

                                                        <p><strong>#<?=$prod['prod_sku']?> | </strong><?=implode(" ",array_splice( $title , 0 , 5 ) )?></p>

                                                    </td>
                                                    <td>

                                                        <span><strong>Price:</strong>AED <?=$prod['price']?></span><br>
                                                        <span><strong>Type:</strong> <?=$prod['prod_type']?></span><br>
                                                    </td>

                                                    <td>
                                                        <?php

                                                        $str = '';
                                                        foreach($prod['cat'] as $cat) :

                                                            $str.=$cat.' | ';

                                                        endforeach; 

                                                        echo rtrim($str,' | ')?>

                                                    </td>
                                                   <!--  <td>
                                                        <?php

                                                        foreach($prod['brands'] as $brand) :

                                                            echo $brand.'<br>';

                                                        endforeach; ?>

                                                    </td>
 -->
                                                    <td><?=$prod['prod_status']?></td>

                                                    <td class="careerFilter">

                                                        <div class="child_option position-relative">

                                                            <button class="dots open-menu2 bg-transparent border-0 p-0" type="button"><svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path></svg></button> 

                                                            <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">   

                                                                <ul class="careerFilterInr">

                                                                    <li>
                                                                        <a href="<?=asset('admin/product/edit/'.$prod['ID'] )?>" class="w-100 border-0 d-flex justify-content-between">
                                                                            Edit
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="<?=asset( 'product/'.$prod['prod_slug'] )?>" class="w-100 border-0 d-flex justify-content-between">
                                                                            View
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 576 512"><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:delete_popup('<?=asset('admin/product/delete')?>',<?=$prod['ID']?>);" class="w-100 border-0 d-flex justify-content-between">
                                                                            Delete
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                                        </a>
                                                                    </li>

                                                                </ul>

                                                            </div>

                                                        </div>                                        

                                                    </td>

                                                </tr>

                                            <?php endforeach;

                                        else : ?>

                                            <tr>
                                                <td colspan="8">No Products Found</td>                                        
                                            </tr>

                                        <?php endif;?>

                                    </tbody>

                                </table>
                            </div>
                            <div class="multi-delete" style="display: none;">
                                <input type="hidden" name="selected_rows" value="" id="selected_rows">
                                <a href="javascript:delete_popup('<?=asset('admin/product/delete')?>','');" class="badge delete-multiple-popup bg-red">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div>

                        </div>
                     <div class="row align-items-center justify-content-between mt-3">

    <div class="col-sm-12 col-md-6">
        <?php if (!empty($data)) : ?>
            <?php
            $from = ($data['current_page'] - 1) * $data['per_page'] + 1;
            $to = min($data['current_page'] * $data['per_page'], $data['total']);
            $total = $data['total'];
            ?>
            Showing <?= $from ?> to <?= $to ?> of <?= $total ?> entries
        <?php endif; ?>
    </div>

    <div class="col-sm-12 col-md-6">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-md-end justify-content-center">

                <?php
                // Grab current GET parameters except 'page'
                $queryParams = $_GET;
                if (isset($queryParams['page'])) {
                    unset($queryParams['page']);
                }

                foreach ($data['links'] as $item) :
                    // Prepare base URL or fallback for disabled links
                    $link = $item['url'] ?? 'javascript:;';
                    $disabledClass = $item['url'] === null ? 'disabled' : '';
                    $activeClass = $item['active'] ? 'active' : '';

                    // Append existing GET parameters to the link, except if url is null
                    if ($item['url'] !== null && !empty($queryParams)) {
                        // Check if URL already has parameters
                        $separator = strpos($link, '?') === false ? '?' : '&';
                        $link .= $separator . http_build_query($queryParams);
                    }
                ?>
                    <li class="page-item <?= $disabledClass . ' ' . $activeClass ?>">
                        <a class="page-link" href="<?= htmlspecialchars($link) ?>">
                            <?= $item['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        </nav>
    </div>

</div>


                </div>

            </div>

        </div>

    </div>

</div>

</section>

</div>

@endsection

<script>

    function delete_popup(action,id){

        id = id == '' ? jQuery('#selected_rows').val() : id

        jQuery('.delete-modal').find('form').attr('action',action)

        jQuery('.delete-modal').find('#id').val(id)

        jQuery('.delete-modal').addClass('show')

        jQuery('.delete-modal').show()


    }



</script>