@extends('web.layout')


@section('content')

<div class="breadcrumb p-0 mt-4">
	<div class="container">
		<div class="bread-inner d-flex align-items-center justify-content-between flex-wrap">
			
			<ul class="d-inline-flex align-items-center flex-wrap bg-transparent rounded-0 border-0 gap-2">
				<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>
				<li>&gt;</li>
				<li><a href="<?=asset('our-blogs')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Blog')?></a></li>
				<li>&gt;</li>
				<li><a href="javascript:;"><?=$meta['pagetitle'] ?? $data['post_title']?></a></li>
			</ul>

			<span class="d-flex gap-3"><?=$data['cat']?> | <?=date('M,d,y',strtotime($data['created_at']))?></span>

		</div>
	</div>
</div>

<section class="main-section blog-det-section-one inner-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="pe-lg-4">
				<div class="main-heading mb-lg-4">
					<h2 class="mb-4"><?=$meta['pagetitle'] ?? $data['post_title']?></h2>
					<div class="pb-lg-2"><?=$meta['post_excerpt'] ?? $data['post_excerpt'] ?></div>
					<hr class="my-4 pb-lg-2">
				</div>
				<?=$meta['post_content'] ?? $data['post_content'] ?>
			</div>
			</div>
			<div class="col-md-4">
				<figure class="overflow-hidden pb-lg-3">
					<img src="<?=asset($data['featured_image'])?>" class="wow w-100">
				</figure>
				<hr class="my-4 pb-lg-2">
				<h2 class="mb-4 pb-lg-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Related Blogs')?></h2>

				<?php

				foreach( $related as $blog ) : 

					$img = $blog['metadata']['featured_image']['path'] ?? $blog['featured_image']['path'];?>


					<a href="<?=asset('blog/'.$blog['post_name'])?>" class="d-block">
						<article>
@if(isset($img))
							<figure class="overflow-hidden">

								<img src="<?=asset($img)?>" alt="*" class="w-100 wow">

							</figure>
@endif
							<article class="mt-3">

								@if(isset($blog['cat']))
								<span class="d-flex gap-3"><?=$blog['cat']?> | <?=date('M,d,y',strtotime($blog['created_at']))?></span>
@endif
@if(isset($blog['metadata']['pagetitle']) || isset($post['post_title']))
								<h5 class="my-3"><?=$blog['metadata']['pagetitle'] ?? $blog['post_title']?></h5>
@endif
@if(isset($blog['metadata']['post_excerpt']) || isset($blog['post_excerpt']))
								<?=$blog['metadata']['post_excerpt'] ?? $blog['post_excerpt']?>
@endif

							</article>

						</article>

					</a>

					<?php

				endforeach;?>
			</div>
		</div>
	</section>

	@endsection