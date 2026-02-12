@extends('web.layout')



@section('content')


<section class="main-section home-section-six faq-section mb-lg-5">
	<div class="container">

		<div class="main-heading text-center wow">
			
			<h2><?=$data['content']['pagetitle']?></h2>

			<div class="breadcrumb justify-content-center mt-3 wow fadeInUp">

				<ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

					<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

					<li>></li>

					<li><a href="javascript:;" class="active"><?=$data['content']['pagetitle']?></a></li>

				</ul>

			</div>
		</div>

		<div class="row justify-content-center wow fadeInUp">
			<div class="col-lg-12 col-xl-8">
				<div class="accordion" id="home-section-five-accordion">

					<?php

					foreach( $data['faq'] as $key => $faq ) : 

						$c1 = $key == 9999 ? '' : 'collapsed';

						$c2 = $key == 9999 ? 'show' : '';

						$c3 = $key == 0 ? '' : 'false';?>

						<div class="accordion-item border-0">
							@if(isset($faq['metadata']['pagetitle']) || isset($faq['post_title']))
							<h2 class="accordion-header">
								<button class="accordion-button justify-content-between align-items-center px-2 <?=$c1?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$key?>" aria-expanded="<?=$c3?>" aria-controls="collapse<?=$key?>">

									<?=$faq['metadata']['pagetitle'] ?? $faq['post_title']?> 
								
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.99976 8.9998L11.9998 14.9998L17.9998 8.99976" stroke="#6D7D36" stroke-miterlimit="16"/></svg>
								</button>
							</h2>
@endif
@if(isset($faq['metadata']['post_content']) || isset($faq['post_content']))
							<div id="collapse<?=$key?>" class="accordion-collapse collapse <?=$c2?>"
								data-bs-parent="#home-section-five-accordion">
								<div class="accordion-body px-2">
									<div>
								
{!! preg_replace('/<p>(\s|&nbsp;)*<\/p>/i', '', $faq['metadata']['post_content'] ?? $faq['post_content']) !!}
								
									</div>
								</div>
							</div>
							@endif
						</div>

					<?php endforeach;?>

				</div>
			</div>
		</div>
		<div class="text-center d-none mt-4 wow fadeInUp">
			<a href="javascript:;" class="btn">load more</a>
		</div>
	</div>
</section>

@endsection

