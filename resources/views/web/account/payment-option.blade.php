@extends('web.layout')



@section('content')


<div class="breadcrumb">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>">Home</a></li>

			<li>></li>

			<li><a href="<?=asset('dashboard/'.Auth()->user()->user_name)?>">Account</a></li>

			<li>></li>

			<li><a href="javascript:;">Payment Options</a></li>

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
					<div class="main-heading mb-4">
						<h2>My Payment Options</h2>
					</div>
					@if(session()->has('message'))
					<div class="alert alert-success msg_alert">
						{{ session()->get('message') }}
					</div>
					@endif
					<form action="<?=asset('auth/profile')?>" method="POST">
						@csrf
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="mb-2 ms-4">Bank Name</label>

									<?php $bankname = isset($result['metadata']['bank_name']) ? $result['metadata']['bank_name'] : '';  ?>

									<input type="text" name="meta[bank_name]" value="<?=$bankname?>" required placeholder="Enter your Bank Name" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="mb-2 ms-4">Account Holder Name</label>
									
									<?php $account_holder = isset($result['metadata']['account_holder']) ? $result['metadata']['account_holder'] : '';  ?>

									<input type="text" name="meta[account_holder]" value="<?=$account_holder?>" required placeholder="Enter your Account Holder Name" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="mb-2 ms-4">Account Number/IBAN</label>

									<?php $iban = isset($result['metadata']['iban']) ? $result['metadata']['iban'] : '';  ?>
									<input type="text" name="meta[iban]" value="<?=$iban?>" required placeholder="Enter your Account Number" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="mb-2 ms-4">CVV</label>
									<?php $cvv = isset($result['metadata']['cvv']) ? $result['metadata']['cvv'] : '';  ?>
									<input name="meta[cvv]" required placeholder="Enter your card CVV" value="<?=$cvv?>" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<button type="submit" class="btn w-100">Save Changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection