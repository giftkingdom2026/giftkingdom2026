@extends('admin.layout')
@section('content')


<div class="content-wrapper">

    <section class="content-header">
        <h1> {{ trans('labels.title_dashboard') }}
        </h1>

    </section>

    <?php
    use App\Models\Web\Usermeta;

    $condition = Auth::user()->role_id == 1;

$arr = Usermeta::where('user_id', Auth::user()->id)->where('meta_key','access')->pluck('meta_value')->first();
    $sidebar = unserialize($arr);

    if (Auth::user()->role_id == 4) {
        $dcond = '';
    } else {
        if ($condition) {
            $dcond = '';
        } else {
            $dcond = isset($sidebar['dashboard']) && $sidebar['dashboard'] == 'on' ? '' : 'd-none';
        }
    }

    ?>
    <section class="content <?= $dcond ?>">




        <div class="row mt-3">

            <?php $col = $condition ? '12' : '12'; ?>
            <div class="col-md-<?= $col ?>">
                <?php
                if (Auth::user()->role_id == 4) {
                    $col = '6';
                } else {
                    $col = $condition ? '3' : '4';
                }
                ?>

                <div>
                    <div class="row">

                        <div class="col-lg-<?= $col ?> col-xs-6">

                            <div class="card mb-4">

                                <div class="card-body card-inner">
                                    <h5 class="text-muted text-uppercase text-center" title="Number of Orders">Total Orders</h5>

                                    <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1 flex-column">
                                        <div class="user-img fs-42 flex-shrink-0">
                                            <span class="avatar-title text-bg-white rounded-circle fs-22">
                                                <i class="fa-solid fa-boxes-stacked"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0"><?= $result['orders_count'] ?></h3>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <div class="col-lg-<?= $col ?> col-xs-6">

                            <div class="card mb-4">

                                <div class="card-body card-inner">
                                    <h5 class="text-muted text-uppercase text-center" title="Number of Orders">Total Sales</h5>

                                    <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1 flex-column">
                                        <div class="user-img fs-42 flex-shrink-0">
                                            <span class="avatar-title text-bg-white rounded-circle fs-22">
                                                <i class="fa-solid fa-wallet"></i>
                                            </span>
                                        </div>
                                        <h3 class="mb-0">AED <?= number_format($result['gross_sales'], 2) ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (Auth::user()->role_id != 4): ?>
                            <div class="col-lg-<?= $col ?> col-xs-6">
                                <div class="card mb-4">
                                    <div class="card-body card-inner">
                                        <h5 class="text-muted text-uppercase text-center" title="Number of Orders">Customers</h5>
                                        <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1 flex-column">
                                            <div class="user-img fs-42 flex-shrink-0">
                                                <span class="avatar-title text-bg-white rounded-circle fs-22">
                                                    <i class="fa-solid fa-receipt"></i>
                                                </span>
                                            </div>
                                            <h3 class="mb-0"><?= $result['customer_count'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-<?= $col ?> col-xs-6">
                                <div class="card mb-4">
                                    <div class="card-body card-inner">
                                        <h5 class="text-muted text-uppercase text-center" title="Number of Orders">Number of Visits</h5>
                                        <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1 flex-column">
                                            <div class="user-img fs-42 flex-shrink-0">
                                                <span class="avatar-title text-bg-white rounded-circle fs-22">
                                                    <i class="fa-solid fa-eye"></i>
                                                </span>
                                            </div>
                                            <h3 class="mb-0"><?= $result['analytics']['user']['pagevisitsz'] ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>






                    </div>
                </div>
                <div class="row">
                    <div class="col-md-{{ Auth::user()->role_id == 4 ? '12' : '8' }}">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="header-title mb-0">Overview</h4>
                            </div>
                            <div class="bg-light bg-opacity-50">
                                <div class="row text-center">
                                    <div class="col-md-3 ms-3 col-6">
                                        <p class="text-muted mt-3 text-start mb-1">Revenue</p>
                                        <h4 class="mb-3">
                                            <span>AED <?= number_format($result['gross_sales'], 2) ?></span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <select id="chartType" style="margin-bottom: 15px;">
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly" selected>Monthly</option>
                                    <option value="daily">Daily</option>
                                </select>
                                @php
                                foreach ($result['analytics']['month']['keys'] as &$val) {
                                $val = str_replace(', 2025', '', $val);
                                }

                                foreach ($result['analytics']['daily']['keys'] as &$val) {
                                $val = str_replace(', 2025', '', $val);
                                }
                                @endphp

                                <div id="revenue-chart"
                                    class="apex-charts"
                                    data-mos-daily='@json($result["analytics"]["daily"])'
                                    data-mos-month='@json($result["analytics"]["month"])'
                                    data-mos-monthly='@json($result["analytics"]["monthly"])'
                                    data-mos-yearly='@json($result["analytics"]["yearly"])'
                                    data-colors="#783bff,#6ac75a,#465dff,#f7577e"
                                    style="min-height: 315px;">
                                </div>



                            </div>
                        </div>
                    </div>
                    <?php $class = $condition ? '' : 'd-none'; ?>

                    <div class="col-md-4 <?= $class ?>">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-3 justify-content-between align-items-center">
                                    <h4 class="header-title">Recent Orders:</h4>

                                </div>
                                <?php

                                foreach ($result['orders'] as $order) :

                                    foreach ($order['items'] as $item) :

                                        if (!empty($item['product'])) :

                                            $str = '';

                                            $title = explode(' ', $item['product']['prod_title']);

                                            foreach ($title as $key => $word) : $key < 6 ? $str .= $word . ' ' : '';
                                            endforeach;
                                            $str = rtrim($str, ' '); ?>

                                            <div class="d-flex align-items-center gap-2 position-relative mb-3">

                                                <div class="avatar-md flex-shrink-0">
                                                    <img src="<?= asset($item['product']['prod_image']) ?>" alt="product-pic" height="36">
                                                </div>
                                                <div>
                                                    <h5 class="fs-14 my-1"><a href="javascript:;" class="stretched-link link-reset"><?= $str ?></a></h5>
                                                    <span class="text-muted fs-12">AED <?= $item['item_price'] ?> x <?= $item['product_quantity'] ?> = AED <?= ($item['item_price'] * $item['product_quantity']) ?></span>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="text-success px-2 py-1"><?= $order['order_status'] ?></span>
                                                </div>
                                            </div>

                                    <?php

                                        endif;

                                    endforeach; ?>

                                <?php endforeach; ?>

                                <div class="mt-3 text-center">
                                    <a href="<?= asset('admin/orders/display') ?>" class="text-decoration-underline fw-semibold ms-auto link-offset-2 link-dark">View All</a>
                                </div>
                            </div>

                            <div class="card-body p-0 border-top border-dashed d-none">
                                <h4 class="header-title px-3 mb-2 mt-3">Recent Activity:</h4>
                                <div class="my-3 px-3 simplebar-scrollable-y" data-simplebar="init" style="max-height: 370px;">
                                    <div class="simplebar-wrapper" style="margin: 0 -16px 0 -24px">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 370px; overflow: hidden scroll;">
                                                    <div class="simplebar-content" style="padding: 0px 24px;">
                                                        <div class="timeline-alt py-0">
                                                            <div class="timeline-item">
                                                                <i class="ti ti-basket bg-info-subtle text-info timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">You sold an item</a>
                                                                    <span class="mb-1">Paul Burgess just purchased “My - Admin Dashboard”!</span>
                                                                    <p class="mb-0 pb-3">
                                                                        <small class="text-muted">5 minutes ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item">
                                                                <i class="ti ti-rocket bg-primary-subtle text-primary timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">Product on the Theme Market</a>
                                                                    <span class="mb-1">Reviewer added
                                                                        <span class="fw-medium">Admin Dashboard</span>
                                                                    </span>
                                                                    <p class="mb-0 pb-3">
                                                                        <small class="text-muted">30 minutes ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item">
                                                                <i class="ti ti-message bg-info-subtle text-info timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">Robert Delaney</a>
                                                                    <span class="mb-1">Send you message
                                                                        <span class="fw-medium">"Are you there?"</span>
                                                                    </span>
                                                                    <p class="mb-0 pb-3">
                                                                        <small class="text-muted">2 hours ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item">
                                                                <i class="ti ti-photo bg-primary-subtle text-primary timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">Audrey Tobey</a>
                                                                    <span class="mb-1">Uploaded a photo
                                                                        <span class="fw-medium">"Error.jpg"</span>
                                                                    </span>
                                                                    <p class="mb-0 pb-3">
                                                                        <small class="text-muted">14 hours ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item">
                                                                <i class="ti ti-basket bg-info-subtle text-info timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">You sold an item</a>
                                                                    <span class="mb-1">Paul Burgess just purchased “My - Admin Dashboard”!</span>
                                                                    <p class="mb-0 pb-3">
                                                                        <small class="text-muted">16 hours ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item">
                                                                <i class="ti ti-rocket bg-primary-subtle text-primary timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">Product on the Bootstrap Market</a>
                                                                    <span class="mb-1">Reviewer added
                                                                        <span class="fw-medium">Admin Dashboard</span>
                                                                    </span>
                                                                    <p class="mb-0 pb-3">
                                                                        <small class="text-muted">22 hours ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <div class="timeline-item">
                                                                <i class="ti ti-message bg-info-subtle text-info timeline-icon"></i>
                                                                <div class="timeline-item-info">
                                                                    <a href="javascript:void(0);" class="link-reset fw-semibold mb-1 d-block">Robert Delaney</a>
                                                                    <span class="mb-1">Send you message
                                                                        <span class="fw-medium">"Are you there?"</span>
                                                                    </span>
                                                                    <p class="mb-0 pb-2">
                                                                        <small class="text-muted">2 days ago</small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end timeline -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 296px; height: 725px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar" style="height: 188px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                    </div>
                                </div> <!-- end slimscroll -->
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-{{ Auth::user()->role_id == 4 ? '12' : '8' }}">
                    <div class="card mt-4 card-h-100" style="max-height: 335px;overflow: auto;">
                        <div class="card-header d-flex flex-wrap align-items-center gap-2 border-bottom border-dashed">
                            <h4 class="header-title m-0">Top Selling Products</h4>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom align-middle table-nowrap table-hover mb-0">
                                    <tbody>
                                        @foreach ($result['products'] as $product)
                                        @php
                                        $title = explode(' ', $product['prod_title']);
                                        $str = '';
                                        foreach ($title as $key => $word) {
                                        if ($key < 4) $str .=$word . ' ' ;
                                            }
                                            @endphp
                                            <tr>
                                            <td style="width: 150px;">
                                                <div class="avatar-lg col-md-4">
                                                    <img src="{{ asset($product['prod_image']) }}" alt="Product-1" class="img-fluid rounded-2">
                                                </div>
                                            </td>
                                            <td class="ps-0" style="width: 150px;">
                                                <h5 class="fs-14 my-1">
                                                    <a href="{{ asset('admin/product/edit/' . $product['ID']) }}" class="link-reset">{{ rtrim($str) }}</a>
                                                </h5>
                                                <span class="text-muted fs-12">{{ date('d M, Y', strtotime($product['created_at'])) }}</span>
                                            </td>
                                            <td style="width: 150px;">
                                                <h5 class="fs-14 my-1">AED {{ number_format($product['price'],2) }}</h5>
                                                <span class="text-muted fs-12">Price</span>
                                            </td>
                                            <td style="width: 150px;">
                                                <h5 class="fs-14 my-1">{{ $product['prod_quantity'] }}</h5>
                                                <span class="text-muted fs-12">Stock</span>
                                            </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-none">
                    <!-- <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="header-title mb-0 Overview">Top Traffic by Month</h4>

                        </div>
                        <div class="card-body">
                         <div id="multiple-radialbar" class="apex-charts" data-users='<?= json_encode($result['analytics']['user']['users_by_month']) ?>' data-colors="#465dff,#6ac75a,#783bff,#f7577e"></div>
                         <div class="row mt-2">

                            <?php

                            foreach ($result['analytics']['user']['users_by_month'] as $month => $totals) : ?>

                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-center p-1">
                                        <div>
                                            <span class="align-middle fw-semibold"><?= $month ?></span>
                                        </div>
                                        <span class="fw-semibold text-muted float-end"><i class="ti ti-arrow-badge-down text-danger"></i> <?= $totals['total'] ?></span>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div> -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="header-title mb-0 Overview">Top Traffic by Month</h4>

                        </div>
                        <div class="card-body">
                            <div id="multiple-radialbar" class="apex-charts" data-users='<?= json_encode($result['analytics']['user']['users_by_month']) ?>' data-colors="#465dff,#6ac75a,#783bff,#f7577e"></div>
                            <div class="row mt-2">

                                <?php

                                foreach ($result['analytics']['user']['users_by_month'] as $month => $totals) : ?>

                                    <div class="col">
                                        <div class="d-flex justify-content-between align-items-center p-1">
                                            <div>
                                                <span class="align-middle fw-semibold"><?= $month ?></span>
                                            </div>
                                            <span class="fw-semibold text-muted float-end"><i class="ti ti-arrow-badge-down text-danger"></i> <?= $totals['total'] ?></span>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role_id != 4)
                <div class="col-md-4">
                    <div class="card mt-4">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <h4 class="header-title mb-0">New Customers</h4>
                        </div>
                        <div class="card-body p-0" style="max-height: 294px;overflow: auto;">
                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                    <tbody>
                                        @foreach ($result['customers'] as $customer)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="text-muted fs-12">Name</span> <br>
                                                        <h5 class="fs-14 mt-1">{{ $customer['first_name'] }} {{ $customer['last_name'] }}</h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Email</span>
                                                <h5 class="fs-14 mt-1 fw-normal">{{ $customer['email'] }}</h5>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div> <!-- end card-body-->
                    </div>
                </div>
                @endif

            </div>

        </div>



    </section>

</div>

<style>
    .avatar {
        width: 50px;
        border-radius: 50%;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        margin: auto;
        box-shadow: 3px 5px 10px #000;
    }

    .users-list-name {
        padding: 20px;
    }

    .users-list-item {
        border-bottom: solid 1px black;
    }

    .paw-box {
        padding: 1rem 0.7rem;
        background: #fff;
        text-align: center;
        border: solid 0.2rem #5f88b7;
        border-radius: 10px;
        position: relative;
    }

    .paw-box:after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: -10px;
        right: -10px;
        background-image: url('<?= asset('assets/images/sec5Shape.png') ?>');
        z-index: 999999999999999999999;
        background-size: cover;

    }
</style>

@endsection