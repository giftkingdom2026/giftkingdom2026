
@extends('web.layout')

@section('content')


<?php

$page = $data['content'] ;

$events = $data['events'] ; ?>


<section class="inner-banner mt-4">

    <div class="container">

        <article class="pt-2">

            <div class="row justify-content-between align-items-center">

                <div class="col-sm-8 col-md-2">

                    <h1 class="mb-0 wow fadeInUp">@if(isset($page['banner_text'])) {{$page['banner_text']}} @else <?=$page['pagetitle']?> @endif</h1>

                    <div class="breadcrumb mt-4 wow fadeInUp">

                        <ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

                            <li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

                            <li>></li>

                            <li><a href="javascript:;"><?=$page['pagetitle']?></a></li>

                        </ul>

                    </div>

                </div>

                <div class="col-sm-4">

                    <figure class="overflow-hidden">

                        <img src="<?=asset($page['banner_image']['path'])?>" alt="*" class="w-100 wow">

                    </figure>

                </div>

            </div>

        </article>

    </div>

</section>


<section class="main-section home-section-two events-section section-slider my-xl-5 mx-0">

    <div class="container">

            <div class="row gy-lg-5">
                <?php

                foreach($events as $event) : ?>

                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <figure class="d-flex justify-content-center align-items-center overflow-hidden bg-transparent h-auto">
                                @if($event['featured_image']['path'])
                                <a href="<?=asset('event/'.$event['post_name'])?>">
                                    <img src="<?=asset($event['featured_image']['path'])?>" alt="*" class="wow">
                                </a>
                                @endif
                                <div class="position-absolute bottom-0 left-0 right-0 w-100 shop-now px-3 py-2">
                                    <a href="<?=asset('event/'.$event['post_name'])?>" class="d-flex align-items-center text-white gap-3 justify-content-between"><?=App\Http\Controllers\Web\IndexController::trans_labels('Learn More')?> <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 1V13M13 7H1" stroke="#F1F6D3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </a>
                                </div>
                            </figure>
@if(isset($event['metadata']['pagetitle']) || isset($event['post_title']))
                            <article class="text-center pt-3 wow fadeInUp">
                                <h5 class="mb-0"><?=$event['metadata']['pagetitle'] ?? $event['post_title']?></h5>
                            </article>
                            @endif
                        </div>
                    </div>

                <?php endforeach;?>

            </div>

    </div>

</section>

@endsection