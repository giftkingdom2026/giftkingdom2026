<?php

use App\Models\Core\Setting;
use Carbon\Carbon;

Route::current() == '' ? ($hide = 'd-none') : ($hide = '');

$currencies = Setting::commonContent()['currencies']->toArray();
if (Auth::check()) {
    $order_history = Setting::commonContent()['common_order_history']->toArray();

    $wallet_notifications = \App\Models\Web\Wallet::where('user_id', auth()->id())
        ->where('transaction_comment', '!=', 'Order Purchase')
        ->orderByDesc('created_at')
        ->get()
        ->toArray();

    $order_notifications = array_map(function ($item) {
        $id = $item->ID;
        $status = $item->order_status;
        $comments = $item->comments ?? '';
        $date = date('d-M-Y', strtotime($item->created_at));

        $title = "$status";
        if (!empty($comments)) {
            $title .= " : $comments";
        }
        $title .= " - $date";

        return [
            'type' => 'order',
            'title' => $title,
            'id' => $id,
            'is_read' => $item->is_read ?? null,
        ];
    }, $order_history);

    $wallet_notifications = array_map(function ($wallet) {
        $id = $wallet['ID'];
        $comment = $wallet['transaction_comment'] ?? '';
        $date = date('d-M-Y', strtotime($wallet['created_at']));
        $title = !empty($comment) ? $comment : '';
        $title .= " - $date";

        return [
            'type' => 'wallet',
            'title' => $title,
            'id' => $id,
            'is_read' => $wallet['is_read'] ?? null,
        ];
    }, $wallet_notifications);

    $notifications = array_merge($order_notifications, $wallet_notifications);

    $unread_count = count(
        array_filter($notifications, function ($n) {
            return is_null($n['is_read']) || $n['is_read'] == 0;
        }),
    );
}
?>


<div class="offcanvas offcanvas-end top-0" id="mainMenu" aria-modal="true" role="dialog">
    <div class="offcanvas-header">
        <a href="javascript:;" class="logo"><img src="<?= asset($result['header-logo']) ?>" alt="header-logo"
                class="w-100"></a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body position-relative">
        <div class="menuRight">
            <ul class="d-flex justify-content-center flex-column mt-lg-3 gap-3">

                <?php

				use App\Models\Web\Menus;

				$menu = Menus::getMenu('main');

				foreach ($menu as $item) :

					$url = $item['type'] == 1 ? $item['link'] : '';

					$url == '' && $item['link'] != 'javascript:;' ? $url = asset($item['link']) : $url = $item['link'];

					$item['type'] == 2 ? $url =  asset('shop/category/' . $item['link']) : ''; ?>

                <li>

                    <a href="<?= $url ?>" class="link"><?= $item['menu_title'] ?></a>

                </li>

                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>

<header class="header <?= $hide ?>">
    <div class="headerWrap">
        <div class="top-header py-2 text-center">
            <div class="container">
                <p><?= $result['header_top'] ?></p>
            </div>
        </div>
        <div class="mid-header py-4 position-relative z-1">
            <div class="container">
                <div class="row justify-content-between align-items-center wow fadeInUp">
                    <div class="col-5 col-md-3">
                        <div class="d-flex align-items-center gap-4">
                            <a href="javascript:;" class="burgermenu d-none d-inline-block" data-bs-toggle="offcanvas"
                                data-bs-target="#mainMenu" aria-controls="mainMenu"><svg width="18" height="16"
                                    viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="closePath1" d="M1 1L17 1" stroke="#2D3C0A" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path class="closePath2" d="M1 8L17 8" stroke="#2D3C0A" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path class="closePath3" d="M1 15L17 15" stroke="#2D3C0A" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></a>

                            <a href="<?= asset('') ?>" class="logo">
                                <img src="<?= asset($result['header-logo']) ?>" alt="header-logo" class="w-100">
                            </a>
                        </div>
                    </div>
                    <div class="col-9 col-md-10 col-lg-6 order-3 order-lg-2">
                        <div
                            class="search-bar d-flex overflow-hidden pe-3 ps-4 py-1 justify-content-between align-items-center">
                            <input type="text" class="search-input form-control w-100 pb-0" id="search"
                                placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Search')?>">
                            <button type="button" class="bg-transparent search-btn ps-3 d-flex align-items-center">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.3965 12.3965L15.584 15.584" stroke="#2D3C0A" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M14.168 7.79199C14.168 4.27118 11.3138 1.41699 7.79297 1.41699C4.27215 1.41699 1.41797 4.27118 1.41797 7.79199C1.41797 11.3128 4.27215 14.167 7.79297 14.167C11.3138 14.167 14.168 11.3128 14.168 7.79199Z"
                                        stroke="#2D3C0A" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="position-relative py-lg-1">
                            <div class="position-absolute suggestions w-100"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 order-2 order-lg-3">
                        <div
                            class="d-flex align-items-center gap-2 gap-lg-4 justify-content-end action-btns careerFilter">
                            <div class="ct-slct">
                                <div class="child_option position-relative">
                                    <button
                                        class="bg-transparent p-0 border-0 open-menu2 fw-light d-flex align-items-center justify-content-between gap-1"
                                        type="button"><?= session('currency_title') ?><svg width="10"
                                            height="6" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M1 1L5 5L9 1" stroke="#414042"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></button>
                                    <div class="dropdown-menu2 dropdown-menu-right">
                                        <ul class="careerFilterInr">
                                            <?php

											// $currencies = [1 => 'AED',2 => 'USD', 3 => 'EUR']; 

											foreach ($currencies as $key => $currency) :
												if ($currency->title != session('currency_title')) : ?>
                                            <li>
                                                <a href="javascript:;" val="<?= $key + 1 ?>"
                                                    class="currency-change dropdown_select">
                                                    <?= $currency->title ?>
                                                </a>
                                            </li>
                                            <?php endif;
											endforeach;

											?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="ct-slct">
                                <div class="child_option position-relative">
                                    <button
                                        class="bg-transparent p-0 border-0 open-menu2 text-uppercase fw-light d-flex align-items-center justify-content-between gap-1"
                                        type="button">
                                        <?= session()->has('lang') ? session('lang') : 'EN' ?>
                                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.4" d="M1 1L5 5L9 1" stroke="#414042"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></button>
                                    <div class="dropdown-menu2 dropdown-menu-right">
                                        <ul class="careerFilterInr">
                                            <li><a href="javascript:;" class="dropdown_select change-lang"
                                                    data-lang="1">EN</a></li>
                                            <li><a href="javascript:;" class="dropdown_select change-lang"
                                                    data-lang="2">AR</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

<a href="<?= asset('cart') ?>" class="position-relative d-inline-block cart-icon">
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
            d="M3.42986 17.0091C4.52986 18.3337 6.57586 18.3337 10.6697 18.3337H11.3297C15.4235 18.3337 17.4704 18.3337 18.5704 17.0091M3.42986 17.0091C2.32986 15.6836 2.70753 13.6724 3.46195 9.64824C3.9982 6.78824 4.26586 5.35733 5.28428 4.51216M18.5704 17.0091C19.6704 15.6836 19.2928 13.6724 18.5384 9.64824C18.0021 6.78824 17.7335 5.35733 16.7151 4.51216M16.7151 4.51216C15.6976 3.66699 14.241 3.66699 11.3306 3.66699H10.6688C7.75836 3.66699 6.3027 3.66699 5.28428 4.51216"
            stroke="#2D3C0A" />
        <path
            d="M8.40625 7.33398C8.59564 7.87072 8.94684 8.3355 9.41147 8.66426C9.87609 8.99302 10.4312 9.16956 11.0004 9.16956C11.5696 9.16956 12.1247 8.99302 12.5894 8.66426C13.054 8.3355 13.4052 7.87072 13.5946 7.33398"
            stroke="#2D3C0A" stroke-linecap="round" />
    </svg>

    @php
        $cartItemCount = count(Setting::commonContent()['cartMenu']->cart_items ?? []);
    @endphp
        <span class="badge rounded-pill bg-danger text-white position-absolute top-0 start-100 translate-middle p-1 px-2 small">

                {{ $cartItemCount > 99 ? '99+' : $cartItemCount }}
        </span>
</a>

                            <a href="<?= asset('wishlist') ?>">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11 18.5625C11 18.5625 2.40625 13.75 2.40625 7.90625C2.40625 6.87318 2.76417 5.87203 3.41913 5.07311C4.07408 4.2742 4.9856 3.72688 5.99861 3.52428C7.01161 3.32168 8.06352 3.47631 8.97537 3.96186C9.88721 4.44742 10.6027 5.2339 11 6.1875C11.3973 5.2339 12.1128 4.44742 13.0246 3.96186C13.9365 3.47631 14.9884 3.32168 16.0014 3.52428C17.0144 3.72688 17.9259 4.2742 18.5809 5.07311C19.2358 5.87203 19.5938 6.87318 19.5938 7.90625C19.5938 13.75 11 18.5625 11 18.5625Z"
                                        stroke="#2D3C0A" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            @if (Auth::check())
                                <div class="ct-slct">
                                    <div class="child_option position-relative bell_icon">
                                        <button id="notification-dropdown"
                                            class="bg-transparent p-0 border-0 open-menu2 text-uppercase fw-light d-flex align-items-center justify-content-between gap-1 position-relative"
                                            type="button">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22C13.1 22 14 21.1 14 20H10C10 21.1 10.9 22 12 22Z"
                                                    fill="#2D3C0A" />
                                                <path
                                                    d="M6 16V11C6 7.686 8.686 5 12 5C15.314 5 18 7.686 18 11V16L20 18V19H4V18L6 16Z"
                                                    stroke="#2D3C0A" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            @if ($unread_count > 0)
                                                <span
                                                    class="notification-count badge rounded-pill bg-danger text-white position-absolute top-0 start-100 translate-middle p-1 px-2 small">
                                                    {{ $unread_count > 99 ? '99+' : $unread_count }}
                                                </span>
                                            @endif

                                        </button>

                                        <div class="dropdown-menu2 dropdown-menu-right p-3 shadow rounded-3">
                                            <ul class="list-unstyled mb-0">
                                                @if (count($notifications) > 0)
                                                    @foreach ($notifications as $index => $item)
                                                        <li
                                                            class="mb-2 notification-wrapper {{ $index >= 10 ? 'd-none extra-notification' : '' }}">
                                                            <div class="notification-item d-flex p-2 bg-light rounded-2 justify-content-between gap-4"
                                                                data-id="{{ $item['id'] }}"
                                                                data-type="{{ $item['type'] }}">
                                                                <span class="small">
                                                                    {{ ucfirst($item['type']) }}
                                                                    @if ($item['type'] == 'order')
                                                                        <b>#{{ $item['id'] }}</b>
                                                                    @endif
                                                                </span>

                                                                <span class="text-dark fw-medium small text-end">
                                                                    {{ $item['title'] }}
                                                                </span>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                    <div class="text-center">
                                                        <a href="{{ route('notifications') }}" class="btn p-2">
                                                            <?= App\Http\Controllers\Web\IndexController::trans_labels('View All Notifications') ?>
                                                        </a>
                                                    </div>
                                                @else
                                                    <li>
                                                        <div class="text-center text-muted small"><?= App\Http\Controllers\Web\IndexController::trans_labels('No notifications') ?></div>
                                                    </li>
                                                @endif
                                            </ul>



                                        </div>
                                    </div>
                                </div>


                            @endif

                            <?php
                            
                            !Auth::check() ? ($c = 'data-bs-toggle="modal" data-bs-target="#signin" class="d-flex flex-row gap-2 align-items-center"') : ($c = 'class="account-dropdown d-flex flex-row gap-2 align-items-center"');
                            
                            !Auth::check() ? ($url = 'javascript:;') : ($url = asset('account/' . Auth::user()->user_name));
                            
                            $text = !Auth::check() ? 'Login' : ucwords(Auth::user()->first_name);
                            
                            ?>
                            <a href="<?= $url ?>" <?= $c ?>>
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.3346 10.3333C13.3597 10.3333 15.0013 8.69171 15.0013 6.66667C15.0013 4.64162 13.3597 3 11.3346 3C9.30959 3 7.66797 4.64162 7.66797 6.66667C7.66797 8.69171 9.30959 10.3333 11.3346 10.3333Z"
                                        stroke="#2D3C0A" />
                                    <path
                                        d="M18.6667 15.458C18.6667 17.7359 18.6667 19.583 11.3333 19.583C4 19.583 4 17.7359 4 15.458C4 13.1801 7.2835 11.333 11.3333 11.333C15.3832 11.333 18.6667 13.1801 18.6667 15.458Z"
                                        stroke="#2D3C0A" />
                                </svg>
                            </a>


                        </div>
                    </div>

                    <div class="col-3 col-md-2 order-3 order-lg-3 d-block d-lg-none">
                        <div class="canva-btn text-end">
                            <a href="javascript:;" class="menu wow fadeIn" id="menuToggle"
                                data-bs-toggle="offcanvas" data-bs-target="#mainMenu" style="visibility: visible;">
                                <svg width="60" height="24" viewBox="0 0 60 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect class="closePath1" x="26" y="8" width="34" height="1"
                                        fill="#6D7D36" />
                                    <rect class="closePath2" x="44" y="15" width="16" height="1"
                                        fill="#6D7D36" />
                                </svg></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="navigation-bar wow fadeInUp mb-0 mb-xl-3 d-none d-lg-block">
        <div class="container">
            <ul class="d-flex justify-content-center flex-wrap mt-lg-3">

                <?php

				// use App\Models\Web\Menus;x

				$menu = Menus::getMenu('main');

				foreach ($menu as $item) :

					$url = $item['type'] == 1 ? $item['link'] : '';

					$url == '' && $item['link'] != 'javascript:;' ? $url = asset($item['link']) : $url = $item['link'];

					$item['type'] == 2 ? $url =  asset('shop/category/' . $item['link']) : '';

					$active = str_contains(request()->fullUrl(), $url) ? 'active' : ''
				?>

                <li>
                    <a href="<?= $url ?>" class="link <?= $active ?>"><?= $item['menu_title'] ?></a>

                </li>

                <?php endforeach; ?>

            </ul>
        </div>

    </div>

</header>


<div id="cart-notification" class="">

    <button type="button" class="btn-close btn-close position-absolute" data-bs-dismiss="modal"
        aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="#2D3C0A"
            xmlns="http://www.w3.org/2000/svg">
            <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)"
                fill="#2D3C0A" />
            <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)"
                fill="#2D3C0A" />
        </svg></button>

    <div
        class="notification d-flex align-items-center justify-content-between text-start w-100 flex-column gap-3 text-center">
        <style>
            #cart-notification figure {
                display: flex;
                gap: 8px;
                /* spacing between images */
                justify-content: center;
                /* optional: center images horizontally */
                align-items: center;
                /* vertically center if images differ in height */
                margin: 0;
                /* remove default figure margin */
            }
        </style>

        <figure>

            <img src="">

        </figure>


        <p>Product Added To Cart</p>
        <div class="text-center my-3">
            <h6>How would you like to add delivery details?</h6>

            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="#" class="btn" data-bs-toggle="modal" data-image="" data-product_id=""
                    data-cart_item_id="" data-title="" data-price="" data-meta="" data-qty=""
                    data-max_qty="" data-bs-target="#product-delivery-modal">
                     Add Now
                </a>

                <a href="<?= asset('cart') ?>" class="btn btn-outline-secondary">
                    Add Later at Checkout
                </a>
            </div>
        </div>


    </div>

</div>



<div id="wishlist-notification" class="text-center ">

    <button type="button" class="btn-close btn-close position-absolute" data-bs-dismiss="modal"
        aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="#2D3C0A"
            xmlns="http://www.w3.org/2000/svg">
            <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)"
                fill="#2D3C0A" />
            <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)"
                fill="#2D3C0A" />
        </svg></button>

    <div class="notification w-100">

        <p></p>

    </div>

</div>
<div class="modal fade product-delivery contact-section-one order-detail-section" id="product-delivery-modal"
    tabindex="-1" aria-labelledby="productDeliveryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content p-5">
            <div class="modal-body position-relative p-3" style="max-height: 80vh; overflow-y: auto;">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848"
                            transform="rotate(-45 0 2.44531)" fill="#080F22" />
                        <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848"
                            transform="rotate(45 19.5557 0)" fill="#080F22" />
                    </svg>
                </button>

                <div id="product-detail-repeat-wrapper"></div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewAddressesModal" tabindex="-1" aria-labelledby="viewAddressesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content pb-5 px-5">

            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848"
                        transform="rotate(-45 0 2.44531)" fill="#080F22" />
                    <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848"
                        transform="rotate(45 19.5557 0)" fill="#080F22" />
                </svg>
            </button>

            <div class="modal-body p-0">
                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-3" id="viewAddressesModalLabel">Delivery Address(es)</h5>
                    {{-- <button type="button" class="btn top-0 end-0 m-3" data-bs-toggle="modal" data-image="" data-product_id=""
                    data-cart_item_id="" data-title="" data-price="" data-meta="" data-qty=""
                    data-max_qty="" data-addresses="" data-bs-target="#product-delivery-modal">Add New Address
                        </button> --}}
                    </div>
                <div class="table-responsive cart-item">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Item #</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Delivery Date</th>
                                <th>Time Slot</th>
                            </tr>
                        </thead>
                        <tbody id="addressTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade view-vouchers contact-section-one order-detail-section" id="view-vouchers-modal"
    tabindex="-1" aria-labelledby="viewVouchersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content p-5">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848"
                        transform="rotate(-45 0 2.44531)" fill="#080F22" />
                    <rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848"
                        transform="rotate(45 19.5557 0)" fill="#080F22" />
                </svg>
            </button>
            <div class="modal-body position-relative p-0">

                <!-- Static Voucher List -->
<div id="voucher-list">
    <div class="main-heading text-center">
        <h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Available Coupons')?></h2>
    </div>

    @if (!empty($result['coupons']) && count($result['coupons']))
        <div class="voucher-wrap p-2">
            <div class="row g-3">
                @foreach ($result['coupons'] as $coupon)
                    <div class="col-md-6">
                        <div class="border p-3 bg-white rounded d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $coupon['coupon_code'] }}</h6>

                                @if (!empty($coupon['coupon_description']))
                                    <p class="mb-0 text-muted">{{ $coupon['coupon_description'] }}</p>
                                @endif

                                @if (!empty($coupon['discount_amount']) && !empty($coupon['discount_type']))
                                    <p class="mb-0 text-muted">
                                        @if ($coupon['discount_type'] === 'percentage')
                                            {{ $coupon['discount_amount'] }}% off
                                        @elseif($coupon['discount_type'] === 'fixed_cart')
                                            AED {{ number_format($coupon['discount_amount'], 2) }} Off
                                        @endif
                                    </p>
                                @endif

                                @if (!empty($coupon['expiry_date']))
                                    <p class="mb-0 text-muted">
                                       <?=App\Http\Controllers\Web\IndexController::trans_labels('Expires on')?> {{ \Carbon\Carbon::parse($coupon['expiry_date'])->format('d M, Y') }}
                                    </p>
                                @endif
                            </div>

                            <button class="btn btn-sm" onclick="selectVoucher('{{ $coupon->coupon_code }}')"><?=App\Http\Controllers\Web\IndexController::trans_labels('Use')?></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center"><?=App\Http\Controllers\Web\IndexController::trans_labels('No Vouchers Found.')?></p>
    @endif
</div>


            </div>
        </div>
    </div>
</div>
