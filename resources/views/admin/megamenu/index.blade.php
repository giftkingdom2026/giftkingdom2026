@extends('admin.layout')

@section('content')





<div class="content-wrapper">

    <section class="content-header">

        <h1>Mega Menu</h1>

        <ol class="breadcrumb">
            <li><a href="<?=asset('admin/megamenu/add')?>" type="button" class="btn-block"><i class="fa fa-plus"></i>Add Menu Item</a></li>
        </ol>

    </section>


    <section class="content">

        <div class="row">

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">

                        <h3 class="box-title">Listing</h3>

                    </div>



                    <div class="box-body">

                        <div class="row">

                            <div class="col-xs-12">



                                @if(session()->has('success'))

                                <div class="alert alert-success">

                                    {{ session()->get('success') }}

                                </div>

                                @endif

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-xs-12">

                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>

                                        <tr >

                                            <th>ID</th>

                                            <th>Image</th>

                                            <th>Title</th>

                                            <th>Status</th>

                                            <th>Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody class="draggable-container">

                                        <?php

                                        foreach ( $menus as  $key=> $menu ) : ?>

                                            <tr class="shallow-draggable" draggable="true" start="<?=$menus[0]['sort_order']?>" sort-order="<?=$menu['sort_order']?>" id=<?=$menu['ID']?> type="megamenu" id="row-<?= $menu['ID'] ?>">

                                                <td><?=$menu['ID']?></td>

                                                <td><img src="<?=asset($menu['category_icon'])?>" width="150" height="100" style="object-fit: cover;"></td>

                                                <td><?=$menu['menu_title']?></td>

                                                <td><?=$menu['category_ID'] != null ? $menu['category_ID']['category_title'] : ''?></td>

                                                <td>
                                                    <a title="Edit" href="<?=asset('admin/megamenu/edit/'.$menu['ID'] )?>" class="badge bg-light-blue">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="javascript:delete_popup('<?=asset('admin/megamenu/delete')?>',<?= $menu['ID'] ?>);"  class="badge delete-popup bg-red" title="Delete">

                                                        <i class="fa fa-trash" aria-hidden="true"></i>

                                                    </a>

                                                </td>

                                            </tr>

                                        <?php endforeach;?>


                                    </tbody>

                                </table>

                            </div>                        

                        </div>

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
