<!DOCTYPE html>
<html lang="{{session('lang') ?? 'en'}}" dir="{{ session('lang') == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php

    use App\Models\Core\Setting;

    $lang = session()->has('lang_id') ? session('lang_id') : 1;

    $result = Setting::getWebSettings($lang); ?>
    <meta name="robots" content="index, follow">
        <?php 

    $main_title = '';

    if( isset( $data['post_title'] ) ) :

        $main_title = $data['post_title'] ;

    elseif( isset( $data['content']['pagetitle'] ) ) :

        $main_title = $data['content']['pagetitle'] ;

    elseif( isset( $data['post_data']['post_title'] ) ) :

        $main_title = $data['post_data']['post_title'];
            elseif( isset( $data['content']['home_title'] ) ) :

        $main_title = $data['content']['home_title'];
                    elseif( isset( $catdata['category_title'] ) ) :

        $main_title = $catdata['category_title'];
                elseif( isset( $meta['title'] ) ) : 

            $main_title = $meta['title'];
else:
$main_title = 'Gift Kingdom';
    endif; ?>
    <title> <?=$main_title?>    </title>
    <?php 

    $keywords = '';

    if( isset( $data['content']['home_meta_keywords'] ) ) :

        $keywords = $data['content']['home_meta_keywords'] ;

    elseif( isset( $data['post_data']['metadata']['meta_keywords'] ) ) :

        $keywords = $data['post_data']['metadata']['meta_keywords'] ;

    elseif( isset( $data['content']['meta_keywords'] ) ) :

        $keywords = $data['content']['meta_keywords'];

    elseif( isset( $meta['meta_keywords'] ) ) :

        $keywords = $meta['meta_keywords'];

    elseif( isset( $meta['metakeywords'] ) ) :

        $keywords = $meta['metakeywords'];

    endif; ?>
        <?php 

        if( isset( $data['post_data']['metadata']['meta_title'] ) ) :

            $title = $data['post_data']['metadata']['meta_title'];

        elseif( isset( $data['content']['home_meta_title'] ) ) :

            $title = $data['content']['home_meta_title'];

        elseif( isset( $data['content']['meta_title'] ) ) :

            $title = $data['content']['meta_title'];

        elseif( isset( $meta['metatitle'] ) ) : 

            $title = $meta['metatitle'];

        elseif( isset( $meta['meta_title'] ) ) : 

            $title = $meta['meta_title'];

        else:

            $title = 'Gift Kingdom';

        endif; ?>
    <meta name="keywords" content="<?=$keywords?>" />
        <meta name="title" content="<?=$title?>" />

    <?php

    $desc = '';

    if( isset(  $data['content']['home_meta_desc']  ) ) :

        $desc = $data['content']['home_meta_desc'] ;
        elseif( isset( $data['post_data']['metadata']['meta_desc'] ) ) :
    
            $desc = $data['post_data']['metadata']['meta_desc'];

    elseif( isset( $data['content']['meta_desc'] ) ) :

        $desc = $data['content']['meta_desc'] ;


    elseif( isset( $meta['metadesc'] ) ) :

        $desc = $meta['metadesc'];

    elseif( isset( $meta['meta_desc'] ) ) :

        $desc = $meta['meta_desc'];

    endif; ?>

    <meta name="description" content="<?=$desc?>" />

    <?php 
    $title_meta = "";
    if( isset( $data['post_data']['metadata']['meta_title'] ) ) :

        $title_meta = $data['post_data']['metadata']['meta_title'];

    elseif( isset( $data['content']['home_meta_title'] ) ) :

        $title_meta = $data['content']['home_meta_title'];

    elseif( isset( $data['content']['meta_title'] ) ) :

        $title_meta = $data['content']['meta_title'];

    elseif( isset( $meta['metatitle'] ) ) : 

        $title_meta = $meta['metatitle'];

    elseif( isset( $meta['meta_title'] ) ) : 

        $title_meta = $meta['meta_title'];

    else:

        $title_meta = 'Gift Kingdom';

    endif; ?>

    <meta property="og:title" content="<?= $title_meta?>">
    <meta property="og:description" content="<?=$desc?>">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Gift Kingdom">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?=asset('assets/images/favicon.png')?>">

    <meta name="twitter:title" content="<?= $title_meta?>">
    <meta name="twitter:description" content="<?=$desc?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@giftkingdom">
    <meta name="twitter:image" content="<?=asset('assets/images/favicon.png')?>">

    <link rel="icon" type="image/x-icon" href="<?=asset('images/media/2024/10/Fav Icon-64x64.png')?>">
    <link rel="canonical" href="<?=Request::fullUrl()?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?=asset('assets/images/favicon.png')?>">
    <link rel="stylesheet" href="<?=asset('assets/css/default.css')?>" />
    <link rel="stylesheet" href="<?=asset('assets/css/style.css')?>" />
    <link rel="stylesheet" href="<?=asset('assets/css/responsive.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?=asset('assets/css/IntelInput.css')?>">
    @if (!request()->is('/'))

    <link rel="stylesheet" type="text/css" href="<?=asset('admin/css/select2.min.css')?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

    @endif

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('head')

</head>

<body>


    <div class="loade_html d-none position-relative">
        <div id="filter-loader" style="display: flex;">
            <img src="<?=asset($result['header-logo'])?>" width="121" height="54" alt="*"/>
            <div class="loading-area mt-2">
              <div class="loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</div>

<?php

$title = isset($title) ? $title : '404';?>

<h1 style="display:none"><?=isset($prodtitle) ? $prodtitle : $title?></h1>

<?php

if( !Auth::check() ) : ?>

    <div class="modal fade" id="signin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content pb-4">
                <div class="modal-body contact-section-one py-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"/><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"/></svg></button>

                    <div class="main-heading text-sm-center login-head">
                        <h2 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Log In')?></h2>
                        <span class="topLabel mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Sign in into your account')?></span>
                    </div>
                    <form class="js-form has-response signin" action="<?=asset('signin')?>">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="email" name="email_phone" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Email Address')?>*" required class="password form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group position-relative mb-0">
                                    <input type="password" name="password" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Password')?>*" required class="form-control password">
                                    <a href="javascript:;" class="eye-open"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#2d3c0a" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg></a>
                                    <a href="javascript:;" class="eye-close" style="display:none"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#2d3c0a" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg></a>
                                </div>
                            </div>
                            <div class="col-lg-12 text-sm-end mt-2">
                                <a href="<?=asset('forgot-password')?>" class="forgot"><?=App\Http\Controllers\Web\IndexController::trans_labels('Forgot Password')?>?</a>
                            </div>
                        </div>
                        <div class="text-sm-center sign-bot mt-4">
                            <button class="btn text-center mb-5"><?=App\Http\Controllers\Web\IndexController::trans_labels('Log In')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path></svg></button>
                            <p><?=App\Http\Controllers\Web\IndexController::trans_labels('Dont have an account?')?> <a href="javascript:;" class="link text-capitalize" data-bs-toggle="modal" data-bs-target="#signup"><?=App\Http\Controllers\Web\IndexController::trans_labels('Sign up now')?></a></p>
                        </div>
                        <div class="response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content pb-4">
                <div class="modal-body contact-section-one py-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"/><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"/></svg></button>
                    
                    <?php

                    if( Auth::check() ) : ?>

                        <div class="main-heading text-sm-center">
                            <h2><span class="topLabel mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Already Logged In!')?></span></h2>
                        </div>

                    <?php else : ?>


                        <div class="main-heading text-sm-center head">
                            <h2 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Sign Up')?></h2>
                            <span class="topLabel"><?=App\Http\Controllers\Web\IndexController::trans_labels('Or use your email for registration')?></span>
                        </div>
                        <form class="has-response signup validate" method="POST" action="<?=asset('signup')?>">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="firstname" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('First Name')?>*" required class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="lastname" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Last Name')?>*" required class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Email')?>*" required class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="phone-wrapper">
                                            <input type="text" name="phone" maxlength="9" required placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Phone')?>*" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group position-relative">
                                        <input type="password" name="password" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Password')?>*" required class="form-control password">
                                        <a href="javascript:;" class="eye-open"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#2d3c0a" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg></a>
                                        <a href="javascript:;" class="eye-close" style="display:none"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#2d3c0a" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg></a>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group position-relative mb-0">
                                        <input type="password" name="confirmpassword" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Confirm Password')?>*" required class="password form-control">
                                        <a href="javascript:;" class="eye-open"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#2d3c0a" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg></a>
                                        <a href="javascript:;" class="eye-close" style="display:none"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#2d3c0a" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg></a>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <div class="agree">
                                        <div class="form-check gap-2">
                                            <input class="form-check-input" type="checkbox" name="agree" id="agree">
                                            <label class="form-check-label" for="agree"><p class="m-0 text-capitalize"><?=App\Http\Controllers\Web\IndexController::trans_labels('remember me')?></p></label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="text-sm-center sign-bot mt-3">
                                <button type="submit" class="btn mb-5"><?=App\Http\Controllers\Web\IndexController::trans_labels('sign up')?> <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path></svg></button>
                                <p><?=App\Http\Controllers\Web\IndexController::trans_labels('Already have an account?')?> <a href="javascript:;" class="link" data-bs-toggle="modal" data-bs-target="#signin"><?=App\Http\Controllers\Web\IndexController::trans_labels('Sign In')?> </a></p>
                            </div>
                            <div class="response"></div>
                        </form>

                    <?php endif;?>
                    
                </div>

            </div>
        </div>
    </div>

<?php endif;?>


<?php

if( Auth::check() ) : ?>

    <div class="modal fade" id="changeaddr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body contact-section-one py-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"/><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"/></svg></button>

                    <div class="main-heading text-sm-center">
                        <h3><?=App\Http\Controllers\Web\IndexController::trans_labels('Saved Addresses')?></h3>
                    </div>

                    <div id="addresses-wrap">

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif;?>


<?php

if( Route::current() != null && Route::current()->uri != '/'  ) : ?>

    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-5">
                <div class="modal-body contact-section-one py-0">
                    <div class="d-flex align-items-center justify-content-md-between justify-content-center flex-wrap gap-2 gap-md-0">
                        <h6 class="m-0"><?=App\Http\Controllers\Web\IndexController::trans_labels('Click here to safely log out of your account')?>.</h6>
                        <div class="d-flex gap-3">
                            <a href="javascript:;" class="btn trans-btn" data-bs-dismiss="modal" aria-label="Close"><?=App\Http\Controllers\Web\IndexController::trans_labels('Cancel')?></a>
                            <a href="<?=asset('/logout')?>" class="btn" id="loguserout"><?=App\Http\Controllers\Web\IndexController::trans_labels('Logout')?></a>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="complain" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body contact-section-one py-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"/><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"/></svg></button>
                    <div class="main-heading">
                        <h2>Register a Complain</h2>
                    </div>
                    <form class="js-form has-response" action="<?=asset('inquiry')?>">

                        <div class="row">

                            <div class="col-sm-6">

                                <div class="form-group mb-3">

                                    <label class="mb-1 mb-xxl-2 ms-3">Name *</label>

                                    <input type="text" id="name" required name="name" class="form-control">

                                </div>

                            </div>

                            <div class="col-sm-6">

                                <div class="form-group mb-3">

                                    <label class="mb-1 mb-xxl-2 ms-3">Email Address *</label>

                                    <input type="emial" id="email" required name="email" class="form-control">

                                </div>

                            </div>

                            <div class="col-lg-12">

                                <div class="form-group mb-3">

                                    <label class="mb-1 mb-xxl-2 ms-3">Subject *</label>

                                    <input type="text" id="subject" required name="subject" class="form-control">

                                </div>

                            </div>

                            <div class="col-lg-12">

                                <div class="form-group mb-3">

                                    <label class="mb-1 mb-xxl-2 ms-3">Complain *</label>

                                    <textarea class="form-control" required name="complain"></textarea>

                                </div>

                            </div>

                        </div>

                        <button id="signup-btn" class="btn mt-4">Submit</button>

                        <div class="response"></div>
                    </form>

                </div>

            </div>
        </div>
    </div>

<?php endif;?>

<div class="modal fade" id="otp" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog w-25 modal-dialog-centered">
        <div class="gap-5 modal-content pb-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="2.44531" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(-45 0 2.44531)" fill="#080F22"></rect><rect x="19.5557" width="3.45696" height="27.6557" rx="1.72848" transform="rotate(45 19.5557 0)" fill="#080F22"></rect></svg></button>
            <div class="modal-body contact-section-one pt-0">
                <h6 class="text-center mb-2">OTP</h6>
                <p class="mb-2">Kindly check your email for OTP</p>
                
                <form class="otp" action="<?=asset('verify')?>">
                    <div class="d-flex gap-1 align-items-center justify-content-center">

                        <div class="form-group">
                            <input type="text" class="otp-input rounded form-control px-2 text-center" data-index="1" required="">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="otp-input rounded form-control px-2 text-center" data-index="2" required="">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="otp-input rounded form-control px-2 text-center" data-index="3" required="">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="otp-input rounded form-control px-2 text-center" data-index="4" required="">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" class="otp-input rounded form-control px-2 text-center" data-index="5" required="">
                        </div>

                        <input type="hidden" name="otp" id="otp-inp">
                    </div>
                    <div class="text-sm-center position-relative sign-bot">
                        <button id="resend-otp" type="button" style="pointer-events:all;" class="btn mt-3">Resend OTP</button>
                        <div class="position-absolute otp-loader" style="display: none;">
                            <div class="circle_wrapper">
                                <div class="circle_red"></div>
                                <div class="mask_left"></div>
                                <div class="mask_right"></div>
                            </div>
                        </div>
                    </div>
                    <div class="response"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('web.header')

@yield('content')

@include('web.footer')

</body>

<style type="text/css">
    .wrap.h-100.selected {border: solid 1px #6d7d36;border-radius: 5px;}
    .badge.bg-danger{background: red !important}
    #cart-notification .btn-close, #wishlist-notification .btn-close{top:10px;right: 20px;background: none;}
    .img-btn.not-available{opacity: 0.5}
</style>

</html>
