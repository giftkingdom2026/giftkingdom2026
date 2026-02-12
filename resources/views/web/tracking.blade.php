@extends('web.layout')
@section('content')
<?php dd($data);?>
<div class="breadcrumb">
	<div class="container">
		<ul class="d-inline-flex align-items-center gap-2">
			<li><a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>
			<li>></li>
			<li><a href="javascript:;">Tracking</a></li>
		</ul>
	</div>
</div>
<section class="inner-banner">
	<div class="container">
		<article>
			<div class="row justify-content-between align-items-center">
				<div class="col-md-6">
					<h1 class="mb-0">Order Tracking</h1>
				</div>
				<div class="col-md-6 col-lg-5">
					<figure class="overflow-hidden">
						<img src="<?=$data['content']['banner_image']['path']?>" alt="*" class="wow">
					</figure>
				</div>
			</div>
		</article>
	</div>
</section>
<section class="main-section contact-section-one">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="contactWrap">
					<form  enctype="multipart/form-data"   action="{{ URL::to('/tracking/order')}}" method="post">
						{{csrf_field()}}
						<div class="row">
							
							@if(Session::has('error'))
							
							<div class="response">						

								<p>{!! session('error') !!}</p>

							</div>
							@endif

							<div class="col-lg-12">
								<div class="form-group mb-3">
									<label class="mb-1 mb-xxl-2 ms-3">Order number*</label>
									<input type="text" name="order_id" required="" id="order_id" placeholder="Found in your order confirmation email" class="form-control">
								</div>
							</div>
							<div class="col-lg-6 d-none">
								<div class="form-group mb-3">
									<label class="mb-1 mb-xxl-2 ms-3">Billing email*</label>
									<!-- <input type="email" name="email" required="" id="email" placeholder="Email you used for order" class="form-control"> -->
								</div>
							</div>
						</div>
						<button class="btn mt-lg-4">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

