@extends('web.layout')



@section('content')



<?php

$page = $data['term'] ;

$jobs = $data['jobs'] ;?>



<div class="breadcrumb">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2 flex-wrap">

			<li><a href="<?=asset('')?>">Home</a></li>

			<li>></li>

			<li><a href="<?=asset('career')?>">Career</a></li>

			<li>></li>

			<li><a href="javascript:;"><?=$page['term_title']?></a></li>

		</ul>

	</div>

</div>



<section class="main-section careertwo-section-one home-section-eight career-section-two pt-0">

	<div class="container">

		<div class="sec8Wrap">

			<span class="topLabel mb-3">We’re Hiring</span>

			<article class="d-flex align-items-center justify-content-between flex-wrap gap-2 gap-md-0">

				<h3 class="m-0"><?=$page['term_title']?></h3>

				<small><?=$data['job-count']?> Jobs Open</small>

			</article>

		</div>

	</div>

</section>



<section class="main-section careertwo-section-two pt-0 pb-lg-1">

	<div class="container">

	<?=str_replace(['<h2>','</h2>'], ['<div class="main-heading"><h2>','</h2></div>'], $page['meta']['description']);?>

	</div>

</section>


<section class="main-section careertwo-section-three">

	<div class="container">

		<div class="main-heading text-center">

			<h2>Roles in <?=$page['term_title']?></h2>

		</div>

		<div class="row">

			<?php 

			foreach($jobs as $job) : ?>

			<div class="col-md-6 col-lg-4 mb-4 mb-lg-0">

				<article>

					<h3 class="fs-4 text-uppercase mb-3 pb-lg-1"><?=$job['post_title']?></h3>

					<?=$job['post_excerpt']?>

					<a href="<?=asset('job/'.$job['post_name'])?>" class="btn">Learn More</a>

				</article>

			</div>

			<?php endforeach;?>

		</div>

	</div>

</section>



@endsection

