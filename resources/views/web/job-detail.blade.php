@extends('web.layout')



@section('content')



<!-- Modal -->

<div class="modal fade" id="apply" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">

			<div class="modal-body contact-section-one py-0">

				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="21.29" width="1.00362" height="30.1086" transform="rotate(45 21.29 0)" fill="#333333"/><rect x="21.9995" y="21.29" width="1.00362" height="30.1086" transform="rotate(135 21.9995 21.29)" fill="#333333"/></svg></button>

				<div class="main-heading">

					<span class="topLabel mb-3">Apply Now</span>

					<h2><?=$data['post_data']['post_title']?></h2>

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

						<input type="hidden" name="job-title" value="<?=$data['post_data']['post_title']?>">
						<div class="col-sm-6 col-lg-4">

							<label class="mb-1 ms-3">Upload Resume *</label>

							<div class="form-group position-relative">

								<input type="file" id="upresume" name="file" required class="form-control" id="upresume" accept=".pdf,.txt,.docx,.jpg,.png">

								<span class="overlay d-flex justify-content-between align-items-center">
									<filename></filename>
									<svg width="24" style="background: #fff;" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

										<path d="M6 20H18M12 16V4M12 4L15.5 7.5M12 4L8.5 7.5" stroke="#4A2C9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>

									</svg></span>

								</div>

							</div>

							<div class="col-sm-6 col-lg-4">

								<div class="form-group">

									<label class="mb-1 ms-3">LinkedIn URL *</label>

									<div class="position-relative">

										<input type="text" name="linkedin_url" required class="form-control">

										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">

											<path d="M8 12H16M9 8H6C4.93913 8 3.92172 8.42143 3.17157 9.17157C2.42143 9.92172 2 10.9391 2 12C2 13.0609 2.42143 14.0783 3.17157 14.8284C3.92172 15.5786 4.93913 16 6 16H9M15 8H18C19.0609 8 20.0783 8.42143 20.8284 9.17157C21.5786 9.92172 22 10.9391 22 12C22 13.0609 21.5786 14.0783 20.8284 14.8284C20.0783 15.5786 19.0609 16 18 16H15" stroke="#4A2C9D" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>

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



	<div class="breadcrumb">

		<div class="container">

			<ul class="d-inline-flex align-items-center gap-2 flex-wrap">

				<li><a href="<?=asset('')?>">Home</a></li>

				<li>></li>

				<li><a href="<?=asset('career')?>">Career</a></li>

				<li>></li>

				<li><a href="<?=asset('career/'.$data['taxonomy']['categories'][0]['term_slug'])?>"><?=$data['taxonomy']['categories'][0]['term_title']?></a></li>

				<li>></li>

				<li><a href="javascript:;"><?=$data['post_data']['post_title']?></a></li>

			</ul>

		</div>

	</div>



	<section class="main-section careerthree-section-one careertwo-section-one home-section-eight career-section-two pt-0 pb-4">

		<div class="container">

			<div class="sec8Wrap">

				<span class="topLabel mb-3">Job ID: <?=$data['post_data']['ID']?></span>

				<article class="d-flex align-items-center justify-content-between flex-wrap gap-3">

					<h3 class="mb-0"><?=$data['post_data']['post_title']?></h3>

					<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#apply">Apply Now

				</button>

			</article>

		</div>

	</div>

</section>

<section class="main-section careerthree-section-two">

	<div class="container">

		<div class="row">

			<div class="col-md-8 col-lg-9">

				<div class="description">
					<div class="main-heading">
						<h2>DESCRIPTION</h2>
					</div>
					<?=$data['post_data']['post_content']?>
				</div>
				<div class="qualifications mt-4 mt-lg-5">
					<div class="main-heading">
						<h2>QUALIFICATIONS</h2>
					</div>
					<?=$data['post_data']['metadata']['qualifications']?>
				</div>

			</div>

			<div class="col-md-4 col-lg-3 mt-3 mt-md-0">

				<div class="main-heading">

					<h3 class="text-uppercase fs-5 m-0 text-uppercase">Job details</h3>

				</div>

				<ul>

					<li>

						<span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0002 1.92871C14.2167 1.92871 16.3423 2.80919 17.9096 4.37646C19.4769 5.94373 20.3574 8.0694 20.3574 10.2859C20.3574 13.8173 17.8759 17.6659 12.9774 21.8727C12.705 22.1067 12.3577 22.2352 11.9986 22.2349C11.6395 22.2346 11.2925 22.1055 11.0205 21.871L10.6965 21.5899C6.01478 17.4927 3.64307 13.7384 3.64307 10.2859C3.64307 8.0694 4.52355 5.94373 6.09082 4.37646C7.65808 2.80919 9.78376 1.92871 12.0002 1.92871ZM12.0002 3.21443C10.1247 3.21443 8.3261 3.95945 6.99995 5.2856C5.6738 6.61175 4.92878 8.41039 4.92878 10.2859C4.92878 13.2876 7.11278 16.7461 11.5408 20.6204L11.8605 20.8973C11.8994 20.9307 11.9489 20.9491 12.0002 20.9491C12.0515 20.9491 12.101 20.9307 12.1399 20.8973C16.7822 16.9099 19.0716 13.3587 19.0716 10.2859C19.0716 9.35722 18.8887 8.43768 18.5334 7.57974C18.178 6.72179 17.6571 5.94224 17.0005 5.2856C16.3438 4.62896 15.5643 4.10808 14.7063 3.75271C13.8484 3.39733 12.9288 3.21443 12.0002 3.21443ZM12.0002 7.07157C12.8527 7.07157 13.6703 7.41021 14.2731 8.01301C14.8758 8.61581 15.2145 9.43337 15.2145 10.2859C15.2145 11.1383 14.8758 11.9559 14.2731 12.5587C13.6703 13.1615 12.8527 13.5001 12.0002 13.5001C11.1477 13.5001 10.3302 13.1615 9.72737 12.5587C9.12457 11.9559 8.78592 11.1383 8.78592 10.2859C8.78592 9.43337 9.12457 8.61581 9.72737 8.01301C10.3302 7.41021 11.1477 7.07157 12.0002 7.07157ZM12.0002 8.35728C11.4887 8.35728 10.9982 8.56047 10.6365 8.92215C10.2748 9.28383 10.0716 9.77436 10.0716 10.2859C10.0716 10.7973 10.2748 11.2879 10.6365 11.6496C10.9982 12.0112 11.4887 12.2144 12.0002 12.2144C12.5117 12.2144 13.0022 12.0112 13.3639 11.6496C13.7256 11.2879 13.9288 10.7973 13.9288 10.2859C13.9288 9.77436 13.7256 9.28383 13.3639 8.92215C13.0022 8.56047 12.5117 8.35728 12.0002 8.35728Z" fill="#4A2C9D"/></svg></span>

						<a href="javascript:;"><?=$data['post_data']['metadata']['location']?></a>

					</li>

					<li>

						<span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.9999 14.1814C14.4098 14.1814 16.3635 12.2277 16.3635 9.81774C16.3635 7.40777 14.4098 5.4541 11.9999 5.4541C9.5899 5.4541 7.63623 7.40777 7.63623 9.81774C7.63623 12.2277 9.5899 14.1814 11.9999 14.1814Z" stroke="#4A2C9D" stroke-width="1.5" stroke-miterlimit="10"/><path d="M5.45459 17.4544C6.11786 16.4594 7.07195 15.6331 8.22092 15.0586C9.3699 14.4841 10.6733 14.1816 12 14.1816C13.3268 14.1816 14.6302 14.4841 15.7792 15.0586C16.9281 15.6331 17.8822 16.4594 18.5455 17.4544" stroke="#4A2C9D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>

						</svg></span>

						<a href="javascript:;"><?=$data['post_data']['metadata']['job_type']?></a>

					</li>

					<li>

						<span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.25015 6.63068V5.46068C7.25029 5.0417 7.40074 4.63668 7.67416 4.31922C7.94758 4.00176 8.32582 3.79293 8.74015 3.73068L9.96015 3.54768C11.3126 3.34478 12.6877 3.34478 14.0402 3.54768L15.2602 3.73068C15.6745 3.79293 16.0527 4.00176 16.3261 4.31922C16.5996 4.63668 16.75 5.0417 16.7502 5.46068V6.63068L18.4642 6.76868C19.1019 6.8202 19.7039 7.08405 20.1739 7.51804C20.644 7.95204 20.955 8.53111 21.0571 9.16268C21.5224 12.0353 21.5224 14.9641 21.0571 17.8367C20.955 18.4682 20.644 19.0473 20.1739 19.4813C19.7039 19.9153 19.1019 20.1792 18.4642 20.2307L16.5921 20.3807C13.5358 20.6274 10.4645 20.6274 7.40815 20.3807L5.53615 20.2307C4.89845 20.1792 4.29644 19.9153 3.82637 19.4813C3.3563 19.0473 3.04532 18.4682 2.94315 17.8367C2.47793 14.9641 2.47793 12.0353 2.94315 9.16268C3.04552 8.53129 3.35659 7.95245 3.82664 7.51865C4.29669 7.08485 4.89859 6.82115 5.53615 6.76968L7.25015 6.63068ZM10.1832 5.03068C11.3877 4.85001 12.6126 4.85001 13.8172 5.03068L15.0372 5.21368C15.0963 5.22254 15.1504 5.25234 15.1895 5.29766C15.2286 5.34299 15.2501 5.40083 15.2502 5.46068V6.52568C13.0852 6.40221 10.9151 6.40221 8.75015 6.52568V5.45968C8.75021 5.39983 8.77174 5.34199 8.81082 5.29666C8.84991 5.25134 8.90396 5.22154 8.96315 5.21268L10.1832 5.03068ZM7.52915 8.11268C10.5052 7.87268 13.4952 7.87268 16.4712 8.11268L18.3432 8.26468C18.6465 8.28895 18.933 8.41427 19.1567 8.62058C19.3804 8.82689 19.5284 9.10228 19.5772 9.40268C19.6392 9.78768 19.6922 10.1727 19.7372 10.5607C17.3301 11.7457 14.6831 12.362 12.0002 12.362C9.31724 12.362 6.67018 11.7457 4.26315 10.5607C4.30715 10.1737 4.36115 9.78768 4.42315 9.40268C4.47186 9.10228 4.61991 8.82689 4.84363 8.62058C5.06735 8.41427 5.3538 8.28895 5.65715 8.26468L7.52915 8.11268ZM4.12915 12.1567C6.601 13.2805 9.28483 13.8619 12.0002 13.8619C14.7155 13.8619 17.3993 13.2805 19.8712 12.1567C19.9667 13.9753 19.8682 15.7989 19.5772 17.5967C19.5286 17.8973 19.3807 18.1729 19.1569 18.3794C18.9332 18.5859 18.6467 18.7114 18.3432 18.7357L16.4712 18.8857C13.4952 19.1257 10.5052 19.1257 7.52915 18.8857L5.65715 18.7357C5.35365 18.7114 5.06709 18.5859 4.84336 18.3794C4.61962 18.1729 4.47165 17.8973 4.42315 17.5967C4.13215 15.7967 4.03315 13.9727 4.12915 12.1567Z" fill="#4A2C9D"/>

						</svg></span>

						<a href="javascript:;"><?=$data['taxonomy']['categories'][0]['term_title']?></a>

					</li>

				</ul>

			</div>

		</div>

	</div>

</section>

@endsection

