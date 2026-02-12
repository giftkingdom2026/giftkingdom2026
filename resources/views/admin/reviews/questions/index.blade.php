@extends('admin.layout')

@section('content')


<div class="content-wrapper">

    <section class="content-header">

        <h1>Questions</h1>

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

                                    <?=session()->get('success') ?>

                                </div>

                                @endif

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-xs-12">

                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>

                                        <tr>

                                            <th>

                                                <input type="checkbox" name="select" class="select-all">

                                            </th>

                                            <th>ID</th>

                                            <th>Product</th>

                                            <th>Customer</th>

                                            <th>Question</th>

                                            <th>Status</th>

                                            <th>Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody class="draggable-container">

                                        <?php

                                        foreach ( $result['data'] as  $key=> $question ) : ?>

                                            <tr>

                                               <td>

                                                <input type="checkbox" name="select" class="row-select" data-id="<?=$question['comment_ID'] ?>">

                                            </td>

                                            <td><?=$question['comment_ID'] ?></td>

                                            <td>
                                                <?=$question['product']['prod_title']?>
                                            </td>

                                            <td><?=$question['customer']['email']?></td>

                                            <td><?=$question['comment']?></td>

                                            <td><?=$question['attended'] == 0 ? 'Unanswered' : 'Answered'?></td>

                                            <td>

                                                <a title="Edit" href="<?=asset('admin/questions/edit/'.$question['comment_ID'] ) ?>" class="badge bg-light-blue"><i class="fas fa-edit"></i></a>

                                                <a href="javascript:delete_popup('<?=asset('admin/questions/delete')?>',<?=$question['comment_ID'] ?>);" 

                                                    class="badge delete-popup bg-red" title="Delete">

                                                    <i class="fa fa-trash" aria-hidden="true"></i>

                                                </a>

                                            </td>

                                        </tr>

                                        <?php

                                    endforeach;?>

                                </tbody>

                            </table>

                            <div class="multi-delete" style="display: none;">

                                <input type="hidden" name="selected_rows" value="" id="selected_rows">

                                <a href="javascript:delete_popup('{{asset('admin/deletepost')?>','');" 

                                    class="badge delete-multiple-popup bg-red">

                                    <i class="fa fa-trash" aria-hidden="true"></i>

                                </a>

                            </div>

                        </div>


                        <nav aria-label="Page navigation example">

                            <ul class="pagination">

                                <?php

                                foreach( $result['links'] as $item ) :

                                    $item['url'] == null ? $link = 'javascript:;' : $link = $item['url']; 

                                    $item['url'] == null ? $c = 'disabled:;' : $c = '';

                                    $item['active'] ? $c2 = 'active' : $c2 = ''; 

                                    ?>

                                    <li class="page-item <?=$c.' '.$c2?>"><a class="page-link" href="<?=$link?>"><?=$item['label']?></a></li>

                                    <?php

                                endforeach;

                                ?>

                            </ul>

                        </nav>

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