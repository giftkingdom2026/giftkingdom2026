<?php

use App\Models\Web\Index;

$arr = Index::getSectionFive(); ?>
<section class="main-section home-section-five">
    <div class="container">
        <div class="row gy-lg-0 gy-3">
            <div class="col-md-6 col-lg-3">
                <div class=" d-flex gap-4 align-items-center">
                    <figure>
                        <img src="<?=asset(Index::get_image_path($arr['home_s6_image1']))?>" alt="*" class="w-100 wow">
                    </figure>
                    <article class="wow fadeInUp">
                        <h5 class="mb-0" class=""><?=$arr['home_s6_title']?></h5>
                        <span class="text-capitalize"><?=$arr['home_s6_text']?></span>
                    </article>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class=" d-flex gap-4 align-items-center justify-content-start">
                    <figure>
                        <img src="<?=asset(Index::get_image_path($arr['home_s6_image2']))?>" alt="*" class="w-100 wow">
                    </figure>
                    <article class="wow fadeInUp">
                        <h5 class="mb-0"><?=$arr['home_s6_title2']?></h5>
                        <span class="text-capitalize"><?=$arr['home_s6_text2']?></span>
                    </article>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class=" d-flex gap-4 align-items-center justify-content-start">
                    <figure>
                        <img src="<?=asset(Index::get_image_path($arr['home_s6_image3']))?>" alt="*" class="w-100 wow">
                    </figure>
                    <article class="wow fadeInUp">
                        <h5 class="mb-0"><?=$arr['home_s6_title3']?></h5>
                        <span class="text-capitalize"><?=$arr['home_s6_text3']?></span>
                    </article>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class=" d-flex gap-4 align-items-center justify-content-start">
                    <figure>
                        <img src="<?=asset(Index::get_image_path($arr['home_s6_image4']))?>" alt="*" class="w-100 wow">
                    </figure>
                    <article class="wow fadeInUp">
                        <h5 class="mb-0"><?=$arr['home_s6_title4']?></h5>
                        <span class="text-capitalize"><?=$arr['home_s6_text4']?></span>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>