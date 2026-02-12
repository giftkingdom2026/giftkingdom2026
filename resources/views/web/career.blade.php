@extends('web.layout')



@section('content')


<!-- Modal -->

<div class="modal fade" id="apply" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">

			<div class="modal-body contact-section-one py-0">

				<button type="button" class="btn-close" data-bs-dimdiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="21.29" width="1.00362" height="30.1086" transform="rotate(45 21.29 0)" fill="#333333"/><rect x="21.9995" y="21.29" width="1.00362" height="30.1086" transform="rotate(135 21.9995 21.29)" fill="#333333"/></svg></button>

				<div class="main-heading">

					<span class="topLabel mb-3">Apply Now</span>
					<h2>Join Us</h2>

				</div>

				<form class="js-form has-response" method="POST" action="<?=asset('apply/career')?>">

					<div class="row">

						<div class="col-sm-6 col-lg-4">

							<label class="mb-1 ms-3">First Name *</label>

							<div class="form-group">

								<input type="text" name="first_name" required class="form-control">

							</div>

						</div>

						<div class="col-sm-6 col-lg-4">

							<label class="mb-1 ms-3">Last Name *</label>

							<div class="form-group">

								<input type="text" name="last_name" required class="form-control">

							</div>

						</div>

						<div class="col-sm-6 col-lg-4">

							<label class="mb-1 ms-3">Email Address *</label>

							<div class="form-group">

								<input type="email" name="email" required class="form-control">

							</div>

						</div>

						<div class="col-sm-6 col-lg-4">

							<label class="mb-1 ms-3">Phone Number *</label>

							<div class="form-group">

								<input type="tel" name="phone" required class="form-control">

							</div>

						</div>

						<div class="col-sm-6 col-lg-4">

							<label class="mb-1 ms-3">Upload Resume *</label>

							<div class="form-group position-relative">

								<input type="file" id="upresume" name="file" required class="form-control" id="upresume" accept=".pdf,.txt,.docx,.jpg,.png">

								<span class="overlay d-flex justify-content-between align-items-center">
									<filename></filename>
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

										<path d="M6 20H18M12 16V4M12 4L15.5 7.5M12 4L8.5 7.5" stroke="#274FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>

									</svg></span>

								</div>

							</div>

							<div class="col-sm-6 col-lg-4">

								<div class="form-group">

									<label class="mb-1 ms-3">LinkedIn URL</label>

									<div class="position-relative">

										<input type="text" name="linkedin_url" class="form-control">

										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

											<path d="M8 12H16M9 8H6C4.93913 8 3.92172 8.42143 3.17157 9.17157C2.42143 9.92172 2 10.9391 2 12C2 13.0609 2.42143 14.0783 3.17157 14.8284C3.92172 15.5786 4.93913 16 6 16H9M15 8H18C19.0609 8 20.0783 8.42143 20.8284 9.17157C21.5786 9.92172 22 10.9391 22 12C22 13.0609 21.5786 14.0783 20.8284 14.8284C20.0783 15.5786 19.0609 16 18 16H15" stroke="#274FFF" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>

										</svg>

									</div>

								</div>

							</div>

							<div class="col-lg-12">

								<div class="form-group">

									<label class="mb-1 ms-3">Message</label>

									<textarea name="message" class="form-control"></textarea>

								</div>

							</div>

						</div>

						<p>By applying, you accept that the information entered will be processed according to Wayn Real Estate privacy policy to enable us to contact you.</p>

						<button class="btn mt-4">Apply Now</button>
						<div class="response"></div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php

	$page = $data['content'] ;

	$categories = $data['categories'] ;?>



	<div class="breadcrumb">

		<div class="container">

			<ul class="d-inline-flex align-items-center gap-2">

				<li><a href="<?=asset('')?>">Home</a></li>

				<li>></li>

				<li><a href="javascript:;">Career</a></li>

			</ul>

		</div>

	</div>

	<section class="career-section-one help-section-two">

		<div class="container">

			<div class="main-heading">

				<h4 class="mb-3 pb-2 text-uppercase">Find jobs</h4>

				<form class="mb-lg-5 pb-lg-4 pb-xxl-5" action="<?=asset('search-job')?>" method="POST">
					@csrf
					<div class="row justify-content-between">

						<div class="col-sm-6 col-md-4 col-xl-6">

							<div class="form-group d-flex align-items-center mb-0">

								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.0002 21.0002L16.6572 16.6572M16.6572 16.6572C17.4001 15.9143 17.9894 15.0324 18.3914 14.0618C18.7935 13.0911 19.0004 12.0508 19.0004 11.0002C19.0004 9.9496 18.7935 8.90929 18.3914 7.93866C17.9894 6.96803 17.4001 6.08609 16.6572 5.34321C15.9143 4.60032 15.0324 4.01103 14.0618 3.60898C13.0911 3.20693 12.0508 3 11.0002 3C9.9496 3 8.90929 3.20693 7.93866 3.60898C6.96803 4.01103 6.08609 4.60032 5.34321 5.34321C3.84288 6.84354 3 8.87842 3 11.0002C3 13.122 3.84288 15.1569 5.34321 16.6572C6.84354 18.1575 8.87842 19.0004 11.0002 19.0004C13.122 19.0004 15.1569 18.1575 16.6572 16.6572Z" stroke="#274FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>

								<input type="text" name="keywords" required class="form-control" placeholder="Search">

							</div>

						</div>

						<div class="col-sm-6 col-md-4">

							<div class="form-group d-flex align-items-center my-3 mt-sm-0 my-md-0">

								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0002 1.92871C14.2167 1.92871 16.3423 2.80919 17.9096 4.37646C19.4769 5.94373 20.3574 8.0694 20.3574 10.2859C20.3574 13.8173 17.8759 17.6659 12.9774 21.8727C12.705 22.1067 12.3577 22.2352 11.9986 22.2349C11.6395 22.2346 11.2925 22.1055 11.0205 21.871L10.6965 21.5899C6.01478 17.4927 3.64307 13.7384 3.64307 10.2859C3.64307 8.0694 4.52355 5.94373 6.09082 4.37646C7.65808 2.80919 9.78376 1.92871 12.0002 1.92871ZM12.0002 3.21443C10.1247 3.21443 8.3261 3.95945 6.99995 5.2856C5.6738 6.61175 4.92878 8.41039 4.92878 10.2859C4.92878 13.2876 7.11278 16.7461 11.5408 20.6204L11.8605 20.8973C11.8994 20.9307 11.9489 20.9491 12.0002 20.9491C12.0515 20.9491 12.101 20.9307 12.1399 20.8973C16.7822 16.9099 19.0716 13.3587 19.0716 10.2859C19.0716 9.35722 18.8887 8.43768 18.5334 7.57974C18.178 6.72179 17.6571 5.94224 17.0005 5.2856C16.3438 4.62896 15.5643 4.10808 14.7063 3.75271C13.8484 3.39733 12.9288 3.21443 12.0002 3.21443ZM12.0002 7.07157C12.8527 7.07157 13.6703 7.41021 14.2731 8.01301C14.8758 8.61581 15.2145 9.43337 15.2145 10.2859C15.2145 11.1383 14.8758 11.9559 14.2731 12.5587C13.6703 13.1615 12.8527 13.5001 12.0002 13.5001C11.1477 13.5001 10.3302 13.1615 9.72737 12.5587C9.12457 11.9559 8.78592 11.1383 8.78592 10.2859C8.78592 9.43337 9.12457 8.61581 9.72737 8.01301C10.3302 7.41021 11.1477 7.07157 12.0002 7.07157ZM12.0002 8.35728C11.4887 8.35728 10.9982 8.56047 10.6365 8.92215C10.2748 9.28383 10.0716 9.77436 10.0716 10.2859C10.0716 10.7973 10.2748 11.2879 10.6365 11.6496C10.9982 12.0112 11.4887 12.2144 12.0002 12.2144C12.5117 12.2144 13.0022 12.0112 13.3639 11.6496C13.7256 11.2879 13.9288 10.7973 13.9288 10.2859C13.9288 9.77436 13.7256 9.28383 13.3639 8.92215C13.0022 8.56047 12.5117 8.35728 12.0002 8.35728Z" fill="#274FFF" /></svg>

								<input type="text" name="location" required class="form-control" placeholder="Location">

							</div>

						</div>

						<div class="col-md-4 col-xl-2">

							<div class="text-md-end">

								<button class="btn w-100">Search Job

								</button>

							</div>

						</div>

					</div>

				</form>

			</div>

		</div>

	</section>

	<section class="main-section home-section-eight career-section-two pb-4 pt-lg-0">

		<div class="container">

			<div class="sec8Wrap">

				<div class="row align-items-center">

					<div class="col-md-6">

							<article class="text-center text-md-start">

								<span class="topLabel mb-3"><?=$page['heading_small']?></span>

								<h3 class="mb-4"><?=$page['heading']?></h3>

								<a href="javascript:;" class="btn" data-bs-toggle="modal" data-bs-target="#apply">Join Us</a>

							</article>

					</div>

					<div class="col-md-6 text-center">

						<figure class="overflow-hidden d-inline-block">

							<img src="<?=asset($page['image']['path'])?>" alt="*" class="wow">

						</figure>

					</div>

				</div>

			</div>

		</div>

	</section>

	<section class="main-section career-section-three">

		<div class="container">

			<div class="main-heading text-center">

				<h2>Find jobs by job category</h2>

			</div>

			<div class="row">

				<?php

				foreach($categories as $cat) : 

					$arr = explode(' ',$cat['term_title']); 

					$heading = ''; 

					foreach($arr as $key => $item) : 

						$item != '&' ? $heading.= $item.' ' : $heading.= $item.' ';

					endforeach; ?>

					<div class="col-md-6 col-lg-4">

						<article>

							<h5 class="m-0"><?=$cat['term_title']?></h5>

							<div class="career-threebox">

								<span class="d-block"><?=$cat['job-count']?></span>
								<!-- <?=asset('career/'.$cat['term_slug'])?> -->
								<a href="javascript:;">Open Jobs <svg class="ms-2" width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L7 7L1 13" stroke="white" stroke-width="2" stroke-linecap="round"stroke-linejoin="round" /></svg></a>

							</div>

						</article>

					</div>



				<?php endforeach;?>



			</div>

		</div>

	</section>



	@endsection

