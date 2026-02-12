@extends('web.layout')

@section('content')


<div class="breadcrumb">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>">Home</a></li>

			<li>></li>

			<li><a href="<?=asset('career')?>">Career</a></li>

			<li>></li>

			<li><a href="javascript:;">Search</a></li>

		</ul>

	</div>

</div>


<section class="main-section careertwo-section-three">

	<div class="container">

		<div class="main-heading text-center">

			<h2>Search: Jobs Found(<?=count($data)?>)</h2>

		</div>

		<div class="row">

			<?php 

			foreach($data as $job) : ?>

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

