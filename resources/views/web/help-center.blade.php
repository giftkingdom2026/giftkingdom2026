@extends('web.layout')

@section('content')

<div class="breadcrumb">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

			<li>></li>

			<li><a href="javascript:;">Help Center</a></li>

		</ul>

	</div>

</div>



<section class="help-section-one">

	<div class="container">

		<div class="main-heading mb-0">

			<h2>Help Center</h2>

		</div>

		<?=isset($data['content']['content']) ? $data['content']['content'] : ''?>

	</div>

</section>

<section class="main-section help-section-two">

	<div class="container">

		<h4 class="mb-3 pb-1 text-uppercase">Ask Question</h4>

		<form action="<?=asset('help-center')?>" method="POST">
			@csrf
			<div class="row justify-content-between">

				<div class="col-sm-8 col-lg-9 col-xl-10">	
					<div class="form-group d-flex align-items-center mb-0">

						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

							<path d="M21.0002 21.0002L16.6572 16.6572M16.6572 16.6572C17.4001 15.9143 17.9894 15.0324 18.3914 14.0618C18.7935 13.0911 19.0004 12.0508 19.0004 11.0002C19.0004 9.9496 18.7935 8.90929 18.3914 7.93866C17.9894 6.96803 17.4001 6.08609 16.6572 5.34321C15.9143 4.60032 15.0324 4.01103 14.0618 3.60898C13.0911 3.20693 12.0508 3 11.0002 3C9.9496 3 8.90929 3.20693 7.93866 3.60898C6.96803 4.01103 6.08609 4.60032 5.34321 5.34321C3.84288 6.84354 3 8.87842 3 11.0002C3 13.122 3.84288 15.1569 5.34321 16.6572C6.84354 18.1575 8.87842 19.0004 11.0002 19.0004C13.122 19.0004 15.1569 18.1575 16.6572 16.6572Z" stroke="#274fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>

							<input type="text" id="Name" name="keywords" class="form-control" placeholder="Search">

						</div>
					</div>

					<div class="col-sm-4 col-lg-3 col-xl-2">

						<div class="text-end mt-3 mt-sm-0">

							<button class="btn w-100">Search</button>

						</div>

					</div>

				</div>

			</form>

		</div>

	</section>

	<section class="main-section help-section-three faq-section-two pt-3 pt-xxl-5">

		<div class="container">

			<div class="row">

				<div class="col-lg-8">

					<h4 class="text-uppercase mb-4 pb-lg-1">Other Quires</h4>

					<?php

					if( !empty($data['help-center']) ) : ?>

						<div class="accordion" id="accordionExample">

							<?php
							foreach( $data['help-center'] as $key => $item ) :?>

								<div class="accordion-item">

									<h5 class="accordion-header" id="heading<?=$key?>">

										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$key?>" aria-expanded="true" aria-controls="collapse<?=$key?>">

											<?=$item['post_title']?>

										</button>

									</h5>

									<div id="collapse<?=$key?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">

										<div class="accordion-body">

											<?=$item['post_content']?>


										</div>

									</div>

								</div>

							<?php endforeach; ?>

						</div>

					<?php else :?>

						<div class="main-heading text-center">
							<h3>No Queries Found!</h3>
						</div>
						
					<?php endif;?>

				</div>

				<div class="col-lg-4">

					<h4 class="text-uppercase mt-4 mt-lg-0 mb-4 pb-lg-1">Most Asked Questions</h4>

					<ul>

						<?php

						foreach( $data['most-asked'] as $key => $item ) : ?>

							<li><?=$item['post_title']?></li>

							<?php 

						endforeach;?>

					</ul>
					<button class="btn w-100" data-bs-toggle="modal" data-bs-target="#complain">Register a Complain</button>
				</div>

			</div>


		</div>

	</section>

	@endsection

	<?php

	if( isset( $_POST ) ) : ?>

		<script type="text/javascript">
			if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );
			}
		</script>
	<?php endif;?>
