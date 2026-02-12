@extends('admin.layout')



@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>Customer Referrals</h1>

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

                                <table id="example1" class="table table-bordered table-striped">

                                    <thead>

                                        <tr >

                                            <th>Customer Name</th>

                                            <th>Customer Email</th>

                                            <th>Customer Referrals</th>

                                            <th>Customer Points</th>

                                        </tr>

                                    </thead>

                                    <tbody class="draggable-container">

                                        <?php

                                        foreach ( $data['parsed'] as  $key=> $customer ) : ?>

                                            <tr>

                                                <td><?=$customer['referrer']['first_name'].' '. $customer['referrer']['last_name'] ?></td>


                                                <td><?=$customer['referrer']['email']?></td>

                                                <td><?=count($customer['referrals'])?></td>

                                                <td><?= isset( $customer['referrer']['metadata']['store_credit'] ) ? $customer['referrer']['metadata']['store_credit'] : '0' ?></td>

                                            </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                                <nav aria-label="Page navigation example">

                                  <ul class="pagination">

                                    <?php

                                    foreach( $data['data']['links'] as $item ) :

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
