@extends('web.layout')



@section('content')


<div class="breadcrumb mb-3 mb-lg-0">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

			<li>></li>

			<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>

		</ul>

	</div>

</div>

<section class="main-section account-section">

	<div class="container">

		<div class="row">

			<div class="col-md-4 col-lg-3">

				@include('web.account.sidebar')

			</div>

			<div class="col-md-8 col-lg-9">

				<div class="acc-right">

					



					<section class="main-section contact-section-one p-0">

						<div class="container">

							<div class="main-heading mb-3 mb-lg-0">

								<h2>{{$data['content']['header_text']}}</h2>

							</div>

							<div class="row">

								<div class="col-lg-12">

									<div class="contactWrap">

										<form  enctype="multipart/form-data"   action="{{ URL::to('/account/track-order')}}" method="post">

											{{csrf_field()}}

											<div class="row">



												@if(Session::has('error'))



												<div class="response">						



													<p>{!! session('error') !!}</p>



												</div>

												@endif



												<div class="col-lg-6">

													<div class="form-group mb-3">

														<label class="mb-1 mb-xxl-2 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order number')?>*</label>

														<input type="text" name="order_id" required="" id="order_id" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Found in your order confirmation email')?>" class="form-control">

													</div>

												</div>

												<div class="col-lg-6">

													<div class="form-group mb-3">

														<label class="mb-1 mb-xxl-2 ms-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('Email')?>*</label>

														<input type="text" name="email" required="" id="email" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Billing Email')?>" class="form-control">

													</div>

												</div>

											</div>

											<button class="btn mt-lg-4"><?=App\Http\Controllers\Web\IndexController::trans_labels('Submit')?></button>

										</form>

									</div>

								</div>

							</div>

						</div>

					</section>



				</div>

			</div>

		</div>

	</div>

</section>





@endsection



