@extends('web.layout')

@section('content')

<?php

$page = $data['content'] ;?>


<section class="inner-banner mt-4">

	<div class="container">

		<article class="pt-2">

			<div class="row justify-content-between align-items-center">

				<div class="col-sm-6 col-md-5">

					<h1 class="mb-0 wow fadeInUp">@if(isset($page['banner_text'])) {{$page['banner_text']}} @else <?=$page['pagetitle']?> @endif
					</h1>

					<div class="breadcrumb mt-4 wow fadeInUp">

						<ul class="d-inline-flex align-items-center">

							<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

							<li>></li>

							<li><a href="javascript:;"><?=$page['pagetitle']?></a></li>

						</ul>

					</div>

				</div>

				<div class="col-sm-6 col-md-5">

					<figure class="overflow-hidden">

						<img src="<?=asset($page['banner_image']['path'])?>" alt="*" class="wow">

					</figure>

				</div>

			</div>

		</article>

	</div>

</section>





<section class="main-section about-section-one mt-xl-5 pb-3 abt-secs">

	<div class="container">

		<div class="main-heading wow">

			<h2><?=$page['s2_head']?></h2>

		</div>

		<?=$page['about_text']?>

	</div>

</section>



<section class="main-section about-section-two abt-secs">

	<div class="container">

		<div class="row align-items-center">
			<div class="col-md-6">
				<div class="wrap">
					<div class="main-heading wow">
						<h2><?=$page['s2_head']?></h2>
					</div>
					<?=$page['s2_text']?>
				</div>
			</div>
			<div class="col-md-6">
				<figure class="overflow-hidden"><img src="<?=asset($page['s2_image']['path'])?>" alt="*" class="wow w-100"></figure>
			</div>
		</div>

	</div>

</section>

<section class="main-section about-section-three mb-xl-5 abt-secs">

	<div class="container">

		<div class="row align-items-center flex-column-reverse flex-md-row">
			<div class="col-md-6">
				<figure class="overflow-hidden"><img src="<?=asset($page['s3_image']['path'])?>" alt="*" class="wow w-100"></figure>
			</div>
			<div class="col-md-6">
				<div class="wrap">
					<div class="main-heading wow">
						<h2><?=$page['s3_head']?></h2>
					</div>
					<?=$page['s3_text']?>
				</div>
			</div>
		</div>

	</div>

</section>



@endsection
