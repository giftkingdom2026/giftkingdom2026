@extends('web.layout')

@section('content')


<div class="breadcrumb mt-4">

	<div class="container">

		<ul class="d-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

			<li>></li>

			<li><a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Forgot Password')?></a></li>

		</ul>

	</div>

</div>



<section class="main-section account-section">

	<div class="container">

		<div class="row">

			<div class="col-md-12 col-lg-12">

				<div class="acc-right">

					<div class="main-heading text-center mb-4">

						<h2><?=App\Http\Controllers\Web\IndexController::trans_labels('Forgot Password')?></h2>

					</div>

					<form class="js-form has-response" action="<?=asset('/auth/reset-email')?>" method="POST">

						@csrf

						<div class="row justify-content-center">

							<div class="col-sm-8 col-lg-8">

								<div class="form-group mb-3">
									<label class="mb-2 d-flex align-items-center justify-content-between"><?=App\Http\Controllers\Web\IndexController::trans_labels('Email')?></label>
									<input type="email" name="email" value="" required placeholder="example@gmail.com" class="form-control">
								</div>

								<button href="javascript:;" type="submit" class="btn mt-3">Request <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path></svg></button>

								<div class="response"></div>

							</div>

						</div>

					</form>

				</div>

			</div>

		</div>

	</div>

</section>







@endsection







