@extends('web.layout')


@section('content')

<div class="breadcrumb wow fadeInUp mt-5">

	<div class="container">

		<ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

			<li><a href="<?= asset('') ?>"><?= App\Http\Controllers\Web\IndexController::trans_labels('Home') ?></a></li>

			<li>></li>

			<li><a href="<?= asset('events') ?>"><?= App\Http\Controllers\Web\IndexController::trans_labels('Events') ?></a></li>

			<li>></li>

			<li><a href="javascript:;"><?= $data['post_data']['metadata']['pagetitle'] ?? $data['post_data']['post_title'] ?></a></li>

		</ul>

	</div>

</div>

<section class="main-section event-section inner-section">

	<div class="container">

		<div class="row">

			<div class="col-md-5">

				<figure class="overflow-hidden">

					<img src="<?= asset($data['post_data']['metadata']['featured_image']['path'] ?? $data['post_data']['featured_image']['path']) ?>" alt="*" class="wow w-100">

				</figure>

			</div>

			<div class="col-md-7">

				<div class="wrap ps-lg-2 ps-xl-5">

					<?= $data['post_data']['metadata']['post_excerpt'] ?? $data['post_data']['post_excerpt'] ?>

				</div>

			</div>
			<div class="col-md-12 mt-4">

				<?= $data['post_data']['metadata']['post_content'] ?? $data['post_data']['post_content'] ?>

			</div>

		</div>

		<div class="row">

			<div class="col-md-12">

				<div class="contactWrap">

					<div class="main-heading mb-4">

						<h4 class="m-0 text-capitalize"><?= App\Http\Controllers\Web\IndexController::trans_labels('Get A Custom Quote') ?></h4>

					</div>

					<form class="js-form has-response careerFilter" id="event_inquiry" action="<?= asset('event/' . $data['post_data']['post_name']) ?>">

						<div class="row">

							<div class="col-lg-6">

								<div class="form-group mb-3">

									<label class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Name') ?> *</label>

									<input type="text" id="name" required name="name" placeholder="<?= App\Http\Controllers\Web\IndexController::trans_labels('Enter your Name') ?>" class="form-control bg-white">

								</div>

							</div>

							<div class="col-lg-6">

								<div class="form-group mb-3">

									<label class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Email Address') ?> *</label>

									<input type="email" id="email" required name="email" placeholder="<?= App\Http\Controllers\Web\IndexController::trans_labels('Enter your Email Address') ?>" class="form-control bg-white">

								</div>

							</div>

							<div class="col-lg-12">

								<div class="form-group position-relative mb-4">

									<label class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Phone') ?> *</label>

									<input type="phone" minlength="9" maxlength="9" required name="phone" class="form-control">
									<div class="invalid"><svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
											<path fill="#ff0000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
										</svg></div>
									<div class="valid"><svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
											<path fill="#04ff00" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
										</svg></div>
								</div>

							</div>

							<div class="col-lg-12">

								<div class="form-group ct-slct mb-3">

									<label class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Select Event') ?>*</label>

									<div class="child_option position-relative">

										<button id="hotel" class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" type="button"><?= App\Http\Controllers\Web\IndexController::trans_labels('Select') ?><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round" />
											</svg></button>

										<div class="dropdown-menu2 dropdown-menu-right">

											<ul class="careerFilterInr">
												<li>
													<a href="javascript:;" class="dropdown_select selected" value="{{ $data['post_data']['post_title'] }}">
														{{ \App\Http\Controllers\Web\IndexController::trans_labels($data['post_data']['post_title']) }}
													</a>
												</li>

												@foreach($data['events'] as $item)
												@if($item['post_title'] !== $data['post_data']['post_title'])
												@if(isset($item['post_title']) || isset($item['metadata']))
												<li>
													<a href="javascript:;" class="dropdown_select" value="{{ $item['post_title'] }}">
														<?=$item['metadata']['pagetitle'] ?? $item['post_title']?>
													</a>
												</li>
												@endif
												@endif
												@endforeach
												<li>
  <a href="javascript:;" class="dropdown_select" value="Other">
    {{ \App\Http\Controllers\Web\IndexController::trans_labels('Other') }}
  </a>
</li>

											</ul>


										</div>

										<input type="hidden" class="inputhide" required name="event" value="">

									</div>

								</div>

							</div>
							<div class="col-lg-6">
								<div class="form-group mb-3">
									<label class="mb-2">{{ \App\Http\Controllers\Web\IndexController::trans_labels('How many guests do you expect?') }} *</label>
									<input type="number" name="guest_count" required min="1" class="form-control bg-white"
										placeholder="{{ \App\Http\Controllers\Web\IndexController::trans_labels('Enter number of guests') }}">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group mb-3">
									<label class="mb-2">{{ \App\Http\Controllers\Web\IndexController::trans_labels('Preferred Event Date') }}</label>
<input type="date" name="event_date" class="form-control bg-white" min="<?= date('Y-m-d') ?>">
								</div>
							</div>

							<div class="col-lg-12">

								<div class="form-group mb-3">

									<label class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Message') ?> *</label>

									<textarea class="form-control bg-white" placeholder="<?= App\Http\Controllers\Web\IndexController::trans_labels('Enter Message') ?>" required name="message"></textarea>

								</div>

							</div>

						</div>

						<button class="btn mt-2 mt-lg-4"><?= App\Http\Controllers\Web\IndexController::trans_labels('Submit') ?><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0.500001 5.57692L10.8814 5.57692L6.4322 1.13462L6.99153 0.5L12.5 6L6.99153 11.5L6.4322 10.8654L10.8814 6.42308L0.500001 6.42308L0.500001 5.57692Z" fill="#6D7D36" />
							</svg>
						</button>

						<div class="response"></div>
					</form>

				</div>

			</div>


		</div>
</section>

@endsection