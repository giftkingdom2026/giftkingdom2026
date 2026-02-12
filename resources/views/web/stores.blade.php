@extends('web.layout')


@section('content')
    <style type="text/css">
        /*.loader-main{}*/
        .products-section .home-section-five .loader-main {
            /* position: absolute;
            inset: 0;
            z-index: 999;
            background: #fff;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: center;
            align-items: center;*/
            position: absolute;
            inset: 0;
            z-index: 999;
            background: rgb(255 255 255 / 85%);
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: flex-start;
            align-items: center;
            padding-top: 5rem;
        }

        .products-section .home-section-five .loader {
            width: 3rem;
            height: 3rem;

            padding: 8px;
            aspect-ratio: 1;
            border-radius: 50%;
            background: #feb100;
            --_m:
                conic-gradient(#0000 10%, #000),
                linear-gradient(#000 0 0) content-box;
            -webkit-mask: var(--_m);
            mask: var(--_m);
            -webkit-mask-composite: source-out;
            mask-composite: subtract;
            animation: l3 1s infinite linear;
        }

        @keyframes l3 {
            to {
                transform: rotate(1turn)
            }
        }
    </style>
    <section class="shop-head">


        <div class="container">

            <div class="shop-headInnr d-flex flex-row justify-content-center align-items-center flex-wrap text-center">

                <div class="shop-head-left">

                    <div class="main-heading mb-0">

                        <h2 class="text-capitalize">
                            <?= $data['content']['banner_text'] ?>
                        </h2>

                        <div class="breadcrumb mt-3 pb-lg-0">

                            <ul class="d-inline-flex flex-row gap-3">

                                <li><a href="{{ asset('/') }}"
                                        class="breadcrumb-link"><?= App\Http\Controllers\Web\IndexController::trans_labels('Home') ?></a>
                                </li>

                                <li>&gt;</li>

                                <li><a href="#"
                                        class="breadcrumb-link"><?= $data['content']['pagetitle'] ?></a>
                                </li>


                            </ul>
                        </div>
                    </div>


                </div>

            </div>

        </div>


    </section>

    <section class="main-section products-section">

        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <div class="header mb-5">

                        <div
                            class="search-bar d-flex overflow-hidden pe-3 ps-4 py-1 justify-content-between align-items-center">
                            <input type="text" id="search-input" class="search-input form-control w-100 pb-0" placeholder="<?= App\Http\Controllers\Web\IndexController::trans_labels('Search') ?>">
                            <button type="button" class="bg-transparent search-btn ps-3 d-flex align-items-center">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.3965 12.3965L15.584 15.584" stroke="#2D3C0A" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M14.168 7.79199C14.168 4.27118 11.3138 1.41699 7.79297 1.41699C4.27215 1.41699 1.41797 4.27118 1.41797 7.79199C1.41797 11.3128 4.27215 14.167 7.79297 14.167C11.3138 14.167 14.168 11.3128 14.168 7.79199Z"
                                        stroke="#2D3C0A" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


<div class="col-lg-12">
    <div class="section-slider account-section section-slider-pro position-relative m-0 careerFilter">
        <div class="row gy-lg-5" id="results">

            <?php if (!empty($data['stores'])) : ?>

                <?php foreach ($data['stores'] as $store) : ?>
                    <div class="col-sm-6 wrap col-lg-3">
                        <div class="product-card overflow-hidden">
                            <figure class="d-flex justify-content-center align-items-center position-relative overflow-hidden">
                                <a href="<?= asset('store/' . $store['metadata']['store_name']) ?>">
                                    @if(isset($store['metadata']['featured_image']))
                                    <img src="<?= asset($store['metadata']['featured_image']) ?>" alt="*">
                                    @endif
                                </a>
                                <div class="position-absolute bottom-0 left-0 right-0 w-100 shop-now px-3 py-2">
                                    <a href="<?= asset('store/' . $store['metadata']['store_name']) ?>"
                                       class="d-flex align-items-center gap-3 justify-content-between text-white">
                                        <?= App\Http\Controllers\Web\IndexController::trans_labels('Visit Now') ?>
                                    </a>
                                </div>
                            </figure>
@if(isset($store['metadata']['store_name']))
                            <article class="text-center pt-3 wow fadeInUp">
                                <h4 title="<?= $store['metadata']['store_name'] ?>"><?= $store['metadata']['store_name'] ?></h4>
                                
                            </article>
                            @endif
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($result['total'] > $result['per_page']) : ?>
                    <div class="col-md-12">
                        <div class="new_links">
                            <div class="pagination d-flex justify-content-center align-items-center gap-4 mt-5">
                                <ul class="d-flex justify-content-center align-items-center gap-4">
                                    <?php foreach ($result['links'] as $link) :
                                        $url = $link['url'] ? $link['url'] : 'javascript:;';
                                        $class = $link['active'] ? 'active' : '';
                                        $title = $link['label'];

                                        str_contains($link['label'], 'Previous') ?
                                            $title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5.57692L1.61864 5.57692L6.0678 1.13462L5.50847 0.5L2.40413e-07 6L5.50847 11.5L6.0678 10.8654L1.61864 6.42308L12 6.42308L12 5.57692Z" fill="#6D7D36"/></svg>' : '';
                                        str_contains($link['label'], 'Next') ?
                                            $title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.31755e-07 5.57692L10.3814 5.57692L5.9322 1.13462L6.49153 0.5L12 6L6.49153 11.5L5.9322 10.8654L10.3814 6.42308L6.94768e-07 6.42308L7.31755e-07 5.57692Z" fill="#6D7D36"/></svg>' : '';
                                        ?>
                                        <li>
                                            <a href="<?= $url ?>" class="<?= $class ?> page-link-products"><?= $title ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else : ?>
                <div class="col-12">
                    <h3 class="text-center py-5"><?= App\Http\Controllers\Web\IndexController::trans_labels('No Stores Found') ?></h3>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>


            </div>

        </div>

    </section>
@endsection
