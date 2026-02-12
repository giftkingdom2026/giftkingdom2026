@extends('web.layout')

@section('content')
    <?php
    // dd($data);
    
    $content = $data['content'];
    
    if (isset($_GET['print'])):
        // 	echo mail('team.digitalsetgo@gmail.com', 'test', 'message')?'yes':'no';
        dd($data);
    endif; ?>

    <!-- HERO SECTION -->


    <section class="main-section hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-slider">

                        <?php
                      foreach($data['banners'] as $banner ) :?>

                        <div>
                            <figure>
                                @if (isset($banner['featured_image']))
                                    <img src="<?= asset($banner['featured_image']) ?>" alt="*"
                                        class="w-100 d-none d-md-block">
                                @endif
                                <?php
                                
                                $mobileimage = isset($banner['metadata']['mobile_image']) ? $banner['metadata']['mobile_image'] : $banner['featured_image']; ?>
                                @if (isset($mobileimage))
                                    <img src="<?= asset($mobileimage) ?>" alt="*" class="w-100 d-md-none">
                                @endif
                                <figcaption
                                    class="position-absolute d-flex align-items-md-center top-0 bottom-0 start-0 end-0">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-8">
                                                @if (isset($banner['post_title']))
                                                    <h2 class="mb-3"><?= $banner['post_title'] ?></h2>
                                                @endif
                                                @if (isset($banner['post_content']))
                                                    <?= $banner['post_content'] ?>
                                                @endif
                                                @if (isset($banner['metadata']['button_text']))
                                                    <a href="<?= $banner['metadata']['button_link'] ?? '#' ?>"
                                                        class="btn"><?= $banner['metadata']['button_text'] ?> <svg
                                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z"
                                                                fill="#6D7D36" />
                                                        </svg></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>

                        <?php endforeach;?>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HERO SECTION ONE  -->

    <section class="home-section-one main-section">
        <div class="container">
            <div class="main-heading text-center wow">
                <h2><?= $data['content']['home_s1_h'] ?></h2>
            </div>
            <div class="row g-4">
                <?php
            foreach($data['categories'] as $cat) : ?>

                <div class="col-sm-6 col-lg-4">
                    <a href="<?= asset('shop/category/' . $cat['categories_slug']) ?>"
                        class="wow product-card fadeInUp d-flex gap-4 align-items-center justify-content-between py-3 px-4">
                        @if (isset($cat['category_title']))
                            <h5 class="mb-0"><?= $cat['category_title'] ?></h5>
                        @endif
                        @if (isset($cat['category_image']))
                            <figure>
                                <img src="<?= asset($cat['category_image']) ?>" alt="*" class="w-100">
                            </figure>
                        @endif
                    </a>
                </div>

                <?php endforeach;?>

            </div>
        </div>
    </section>

    <section class="home-section-one home-section-two main-section">
        <div class="container">
            <div class="main-heading text-center wow">
                <h2><?= $data['content']['home_s2_h'] ?></h2>
            </div>

            <div class="sec2Slider section-slider">

                <?php
            foreach($data['category1']['children'] as $key => $cat) :  ?>

                <div class="">
                    <a href="<?= asset('shop/category/' . $cat['categories_slug']) ?>"
                        class="wow product-card fadeInUp d-flex gap-4 align-items-center justify-content-between py-3 px-4">
                        @if(isset($cat['category_title']))
                        <h5 class="mb-0"><?= $cat['category_title'] ?></h5>
@endif
                        @if(isset($cat['category_image']))
                        <figure>
                            <img src="<?= asset($cat['category_image']) ?>" alt="*" class="w-100">
                        </figure>
@endif
                    </a>
                </div>

                <?php 

            endforeach;?>

            </div>
        </div>
    </section>

    <section class="home-section-one home-section-two main-section">
        <div class="container">
            <div class="main-heading text-center wow">
                <h2><?= $data['content']['home_s5_h'] ?></h2>
            </div>

            <div class="sec2Slider section-slider section-three-slider section-slidercategory">

                <?php
            foreach($data['category2']['children'] as $key => $cat) :  ?>

                <div class="">
                    <a href="<?= asset('shop/category/' . $cat['categories_slug']) ?>"
                        class="wow product-card fadeInUp d-flex gap-4 align-items-center justify-content-between py-3 px-4">
@if(isset($cat['category_title']))
                        <h5 class="mb-0"><?= $cat['category_title'] ?></h5>
@endif
                        @if(isset($cat['category_image']))
                        <figure>
                            <img src="<?= asset($cat['category_image']) ?>" alt="*" class="w-100">
                        </figure>
@endif
                    </a>
                </div>

                <?php 

            endforeach;?>

            </div>

        </div>
    </section>


    <section class="home-section-three home-section-one home-section-two main-section">
        <div class="container">
            <div class="main-heading text-center wow">
                <h2><?= $data['content']['home_s3_h'] ?></h2>
            </div>
            <div class="sec2Slider section-slider section-four-slider">

                <?php
            foreach($data['categories2'] as $key => $cat) :  ?>

                <div class="">
                    <a href="<?= asset('shop/category/' . $cat['categories_slug']) ?>"
                        class="wow product-card fadeInUp d-flex gap-4 align-items-center justify-content-between py-3 px-4">
                        @if(isset($cat['category_title']))
                        <h5 class="mb-0"><?= $cat['category_title'] ?></h5>
                        @endif
@if(isset($cat['category_image']))
                        <figure>
                            <img src="<?= asset($cat['category_image']) ?>" alt="*" class="w-100">
                        </figure>
@endif
                    </a>
                </div>

                <?php 

            endforeach;?>

            </div>
        </div>
    </section>


    <section class="home-section-three home-section-one home-section-two main-section">
        <div class="container">
            <div class="main-heading text-center wow">
                <h2><?= $data['content']['home_s6_h'] ?></h2>
            </div>
            <div class="sec2Slider section-slider">

                <?php
            foreach($data['categories3'] as $key => $cat) :  ?>

                <div class="">
                    <a href="<?= asset('shop/category/' . $cat['categories_slug']) ?>"
                        class="wow product-card fadeInUp d-flex gap-4 align-items-center justify-content-between py-3 px-4">
                        @if(isset($cat['category_title']))
                        <h5 class="mb-0"><?= $cat['category_title'] ?></h5>
                        @endif
@if(isset($cat['category_image']))
                        <figure>
                            <img src="<?= asset($cat['category_image']) ?>" alt="*" class="w-100">
                        </figure>
@endif
                    </a>
                </div>

                <?php 

            endforeach;?>

            </div>
        </div>
    </section>


    <section class="home-section-three home-section-one home-section-two personal-sec main-section">
        <div class="container">
            <div class="main-heading text-center wow">
                <h2><?= $data['content']['home_s7_h'] ?></h2>
            </div>
            <div class="sec2Slider section-slider">

                <?php
            foreach($data['categories4'] as $key => $cat) :  
            if($cat['category_title'] === 'Events'){
$slug = asset($cat['categories_slug']);
            }else{
                $slug = asset('shop/category/'.$cat['categories_slug']);
            }
            ?>


                <div class="">
                    <a href="<?= $slug ?>"
                        class="wow product-card fadeInUp d-flex gap-4 align-items-center justify-content-between py-3 px-4">
                        @if(isset($cat['category_title']))
                        <h5 class="mb-0"><?= $cat['category_title'] ?></h5>
@endif
@if($cat['category_image'])
                        <figure>
                            <img src="<?= asset($cat['category_image']) ?>" alt="*" class="w-100">
                        </figure>
@endif
                    </a>
                </div>

                <?php 

            endforeach;?>

            </div>
        </div>
    </section>


    <section class="main-section cta-bar py-0 py-lg-4 home-sec-bar">
        <div class="container">
            <aside class="d-flex justify-content-between align-items-center overflow-hidden flex-wrap">
                <h4 class="mb-md-0 wow fadeInUp"><?= $data['content']['home_s4_h'] ?></h4>
                <a href="{{ $data['content']['home_s7_btn_link'] }}"
                    class="btn wow fadeInUp"><?= $data['content']['home_s7_btn_text'] ?> <svg width="16" height="16"
                        viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z"
                            fill="#6D7D36" />
                    </svg></a>
            </aside>

        </div>

    </section>

    @include('web.common.sectionfive')
@endsection
