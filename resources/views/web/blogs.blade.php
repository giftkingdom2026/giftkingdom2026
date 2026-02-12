@extends('web.layout')

@section('content')


<?php

$page = $data['content'] ;

$blogs = $data['blogs'] ; ?>


<section class="inner-banner mt-4">

	<div class="container">

		<article class="pt-2">

			<div class="row justify-content-between align-items-center">

				<div class="col-sm-8 col-md-6 col-xl-5">
@if(isset($page['banner_text']) || isset($page['pagetitle']))
					<h1 class="mb-0 wow fadeInUp"><?=isset($page['banner_text']) ? $page['banner_text'] : $page['pagetitle'] ?></h1>
@endif
					<div class="breadcrumb mt-2 mt-lg-4 mb-3 wow fadeInUp">

						<ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

							<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

							<li>></li>
@if(isset($page['pagetitle']))
							<li><a href="javascript:;"><?=$page['pagetitle'] ?></a></li>
@endif
						</ul>

					</div>

				</div>

				<div class="col-sm-4 col-md-3">
@if(isset($page['banner_image']['path']))
					<figure class="overflow-hidden">

						<img src="<?=asset($page['banner_image']['path'])?>" alt="*" class="w-100 wow">

					</figure>
@endif
				</div>

			</div>

		</article>

	</div>

</section>





<section class="main-section blog-section-one">

	<div class="container">

<div class="row gy-3">

    <?php if (!empty($blogs['data'])) : ?>

        <?php foreach ($blogs['data'] as $blog) :

            $img = $blog['metadata']['featured_image']['path'] ?? $blog['featured_image']['path']; ?>

            <div class="col-sm-6 col-md-6 col-xl-4">
                <a href="<?= asset('blog/' . $blog['post_name']) ?>">
                    <article>
                        @if(isset($img))
                        <figure class="overflow-hidden">
                            <img src="<?= asset($img) ?>" alt="*" class="w-100 rounded-0 wow">
                        </figure>
@endif
                        <article class="mt-3">
                            <span class="d-flex gap-3">
                                <?= $blog['cat'] ?> | <?= date('M,d,y', strtotime($blog['created_at'])) ?>
                            </span>
@if(isset($blog['metadata']['pagetitle']) || isset($blog['post_title']))
                            <h5 class="my-3">
                                <?= $blog['metadata']['pagetitle'] ?? $blog['post_title'] ?>
                            </h5>
@endif
@if(isset($blog['metadata']['post_excerpt']) || isset($blog['post_excerpt']))
                            <?php
                            $para = explode(' ', $blog['metadata']['post_excerpt'] ?? $blog['post_excerpt']);
                            $excerpt = '';
                            foreach ($para as $index => $word) :
                                $index < 27 ? $excerpt .= $word . ' ' : '';
                            endforeach;
                            echo (str_word_count($excerpt) < 27) ? $excerpt : rtrim($excerpt, ' ') . '...';
                            ?>
                            @endif
                        </article>
                    </article>
                </a>
            </div>

        <?php endforeach; ?>

        <?php if ($blogs['total'] > $blogs['per_page']) : ?>
            <div class="new_links">
                <div class="pagination d-flex justify-content-center align-items-center gap-4 mt-5">
                    <ul class="d-flex justify-content-center align-items-center gap-4">
                        <?php foreach ($blogs['links'] as $link) :
                            $url = $link['url'] ? $link['url'] : 'javascript:;';
                            $class = $link['active'] ? 'active' : '';
                            $title = $link['label'];

                            if (str_contains($link['label'], 'Previous')) {
                                $title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5.57692L1.61864 5.57692L6.0678 1.13462L5.50847 0.5L2.40413e-07 6L5.50847 11.5L6.0678 10.8654L1.61864 6.42308L12 6.42308L12 5.57692Z" fill="#6D7D36"/></svg>';
                            }

                            if (str_contains($link['label'], 'Next')) {
                                $title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.31755e-07 5.57692L10.3814 5.57692L5.9322 1.13462L6.49153 0.5L12 6L6.49153 11.5L5.9322 10.8654L10.3814 6.42308L6.94768e-07 6.42308L7.31755e-07 5.57692Z" fill="#6D7D36"/></svg>';
                            }
                        ?>
                            <li>
                                <a href="<?= $url ?>" class="<?= $class ?>"><?= $title ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>

        <div class="col-12 text-center">
            <p>No Blogs Found</p>
        </div>

    <?php endif; ?>

</div>


	</div>

</section>



@endsection

