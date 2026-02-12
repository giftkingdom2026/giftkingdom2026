@extends('web.layout')

@section('content')


<?php
if( empty($data['items']) ): ?>

    <div class="breadcrumb mb-4">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <ul class="d-inline-flex align-items-center gap-2">

                        <li><a href="<?=asset('/')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

                        <li>&gt;</li>


                        <li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>
                    </ul>
                </div>
                <!-- <div class="col-sm-6 text-end">
                    <a href="<?=$_SERVER['HTTP_REFERER']?>" class="back mt-2 mt-sm-0 justify-content-sm-end"><svg class="me-3" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6562 7.5H2.34375" stroke="#333333" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.5625 3.28125L2.34375 7.5L6.5625 11.7188" stroke="#333333" stroke-linecap="round" stroke-linejoin="round"></path></svg>Previous Page</a>
                </div> -->
            </div>
        </div>
    </div>
    
    <section class="main-section home-section-cta cart home-section-nine first-cta">
        <div class="container">

            <figure class="overflow-hidden d-flex align-items-center">
                <img src="<?=asset('assets/images/breadCrumbPattern.png')?>" class="w-100">
                <figcaption class="position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center px-3 px-md-5 wow fadeInLeft">
                    <div class="row justify-content-between align-items-center w-100">
                        <div class="col-sm-8 col-lg-6">
                            <div class="offer-one cta">
                                <h2 class="mb-3">{{$data['content']['cart_empty_text']}}</h2>
                                <p>{{$data['content']['cart_empty_text_two']}}</p>
                                <a href="{{$data['content']['cart_btn_link']}}" class="btn w-50 btn2">{{$data['content']['cart_btn_text']}} <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#fff"></path></svg></a>
                            </div>
                        </div>
                        <div class="col-sm-4 pt-3">
                            <img src="{{$data['content']['banner_image']['path']}}" class="w-100">
                        </div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </section>

    <style>
        .cart .cta h2:before,.cart .cta h2:after{content: none}    
    </style>

<?php else : ?>

    <div class="modal fade" id="delete-item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 p-lg-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="15" height="15" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"/><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"/></svg></button>
                <div class="modal-body contact-section-one py-0">
                    <div class="d-flex align-items-center justify-content-md-between flex-wrap gap-3">
                        <h6 class="m-0">Are you sure you want to delete this item?</h6>
                        <div class="d-flex justify-content-end gap-1 btns">
                            <a href="javascript:;" class="btn bg-olive delete-item">Delete</a>
                            <a href="javascript:;" class="btn wishlist-cart" data-id="" data-var_id="">Move To Wishlist</a>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>

    <section class="main-section cart-section">
        <div class="container">
            <div class="breadcrumb mb-4">

                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <ul class="d-inline-flex align-items-center gap-2">

                                <li><a href="<?=asset('/')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

                                <li>&gt;</li>


                        <li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>
                            </ul>
                        </div>
                        <!-- <div class="col-sm-6 text-end">
                            <a href="<?=URL::previous()?>" class="back mt-2 mt-sm-0 justify-content-sm-end"><svg class="me-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6562 7.5H2.34375" stroke="#6D7D36" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.5625 3.28125L2.34375 7.5L6.5625 11.7188" stroke="#6D7D36" stroke-linecap="round" stroke-linejoin="round"/></svg>Previous Page</a>
                        </div> -->
                    </div>
                </div>
            </div>
            
            @if(session()->has('success'))

            <?php $c = str_contains(session()->get('success'), 'Donot') ? 'alert-danger' : 'alert-success';?>

            <div class="alert <?=$c?> msg_alert">

                <?= session()->get('success') ?>

            </div>

            @endif

            <div class="wizard">
                <div class="wizard-inner position-relative text-center">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs custom-overlay position-relative row justify-content-between border-0" role="tablist">
                        <li role="presentation" class="col active">
                            <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab"><?=App\Http\Controllers\Web\IndexController::trans_labels('Cart')?></span></a>
                        </li>
                        <li role="presentation" class="col">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Summary')?></span></a>
                        </li>
                        <li role="presentation" class="col">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" aria-expanded="false"><span class="round-tab"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Placed')?></span></a>
                        </li>
                    </ul>
                </div> 
            </div>

            <form action="<?=asset('createcheckout')?>" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-9 pe-lg-5">
                        <div class="free-shipping d-flex justify-content-center align-items-center gap-3">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.81689 16.7983C2.81689 17.098 3.05685 17.3503 3.35872 17.3503H7.46111V8.31229H2.81689V16.7983Z" fill="#6C7D36"/>
                                <path d="M10.6201 17.3425H14.7225C15.0166 17.3425 15.2643 17.098 15.2643 16.7904V8.31229H10.6201V17.3425Z" fill="#6C7D36"/>
                                <path d="M9.94657 8.30469H8.14307V17.3585H9.94657V8.30469Z" fill="#6C7D36"/>
                                <path d="M17.1526 1.55366C16.6572 1.55366 16.2547 1.96377 16.2547 2.46851C16.2547 2.76031 16.3941 3.02057 16.6031 3.18619C16.2702 3.61207 15.7516 3.8881 15.1711 3.8881C14.1958 3.8881 13.4063 3.11521 13.3444 2.14516C13.8088 2.10572 14.1726 1.71928 14.1726 1.2382C14.1726 0.733455 13.7701 0.323351 13.2747 0.323351C12.7793 0.323351 12.3768 0.733455 12.3768 1.2382C12.3768 1.56944 12.5549 1.86124 12.818 2.01897C12.5394 2.68933 11.8892 3.15464 11.1306 3.15464C10.2792 3.15464 9.56708 2.56315 9.35809 1.75871C9.68318 1.62464 9.91539 1.2934 9.91539 0.914847C9.91539 0.410104 9.52064 0.00788661 9.02525 0C8.52987 0 8.13511 0.410104 8.13511 0.914847C8.13511 1.2934 8.36732 1.62464 8.69242 1.75871C8.48343 2.56315 7.77131 3.15464 6.91988 3.15464C6.16132 3.15464 5.51887 2.68145 5.23248 2.01897C5.49565 1.86124 5.67368 1.56944 5.67368 1.2382C5.67368 0.733455 5.27118 0.323351 4.7758 0.323351C4.28041 0.323351 3.87792 0.733455 3.87792 1.2382C3.87792 1.71928 4.24171 2.10572 4.70613 2.14516C4.64421 3.1231 3.85469 3.8881 2.87941 3.8881C2.29888 3.8881 1.78028 3.61207 1.44744 3.18619C1.65643 3.02057 1.79576 2.76031 1.79576 2.46851C1.79576 1.96377 1.39326 1.55366 0.897882 1.55366C0.402499 1.55366 0 1.96377 0 2.46851C0 2.97325 0.402499 3.38336 0.897882 3.38336C0.928843 3.38336 0.959803 3.37547 0.990764 3.37547L2.11312 7.91027C2.11312 7.91027 4.23397 7.24779 9.00203 7.24779C13.7701 7.24779 15.8909 7.91027 15.8909 7.91027L17.0133 3.37547C17.0443 3.37547 17.0752 3.38336 17.1062 3.38336C17.6016 3.38336 18.0041 2.97325 18.0041 2.46851C18.0041 1.96377 17.648 1.55366 17.1526 1.55366Z" fill="#6C7D36"/>
                            </svg>
                            <h5 class="m-0">{{$data['content']['cart_head_text']}}</h5>
                        </div>
                    </div>
                </div>
                <div class="row mt-0 mt-lg-4">
                    <div class="col-lg-8 pe-xl-5">


                        <div class="cart">
                            <div class="cart-head d-none justify-content-between align-items-center my-4 ms-1">
                                <div class="form-check">

                                    <?php count( $data['items'] ) == $inorder ? $selectall = 'checked' : $selectall = '';?> 
                                    
                                    <!-- <input class="form-check-input" type="checkbox" class="cart-select selectall" <?=$selectall?> id="selectAll">
                                    <label class="form-check-label" for="selectAll">Select All Items</label> -->
                                </div>
                                <!-- <button type="button" class="btn grey-btn empty-cart">
                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.25 13.75C1.8375 13.75 1.4845 13.6033 1.191 13.3097C0.8975 13.0162 0.7505 12.663 0.75 12.25V2.5H0V1H3.75V0.25H8.25V1H12V2.5H11.25V12.25C11.25 12.6625 11.1033 13.0157 10.8097 13.3097C10.5162 13.6038 10.163 13.7505 9.75 13.75H2.25ZM9.75 2.5H2.25V12.25H9.75V2.5ZM3.75 10.75H5.25V4H3.75V10.75ZM6.75 10.75H8.25V4H6.75V10.75Z" fill="#333333"></path></svg>
                                    Delete All
                                </button> -->
                            </div>

                            <div class="cart-body position-relative">
                                <div class="cart-loader" style="display:none">
                                    <div class="loader"></div>
                                </div>
                                <div class="cart-items d-flex flex-column">

                                    <?php $count = 0; ?>
                                    
                                    @include('web.cart.loop',['data',$data])

                                </div>
                            </div>

                        </div>

                        <a href="<?=asset('shop')?>" class="btn mt-3 btn2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Continue Shopping')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#fff"></path></svg></a>
                    </div>

                    <div class="col-lg-4 col-xl-3">
                        <div class="cart-summary mb-lg-2 mt-4 mt-lg-0">
                            @include('web.cart.summary',['data',$data])

                            
                        </div>
                        <?php

                        $attr = $count == 0 ? 'disabled' : '';?>

                        <button type="submit" class="btn w-100 mt-4 btn2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Proceed to checkout')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#fff"></path></svg></button>
                    </div>

                </div>
            </form>
        </div>
    </section>

<?php endif;?>


<section class="main-section productdetail-section-three pt-0 related-section">

    <div class="container">

        <div class="main-heading text-center"><h2><?= App\Http\Controllers\Web\IndexController::trans_labels('Frequently Bought Together') ?></h2></div>

        <div class="section-slider section-slider-pro related-pro-slider">

            <?php

            foreach( $related as $product ) : ?>

                <div class="gallery">

                    @include('web.product.content',['product' => $product])

                </div>

            <?php endforeach;?>

        </div>

    </div>
    
</section>

@endsection

