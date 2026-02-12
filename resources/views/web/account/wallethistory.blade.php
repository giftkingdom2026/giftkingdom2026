@extends('web.layout')

@section('content')



<section class="main-section account-section wallet-history-section return-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-3">
				@include('web.account.sidebar')
			</div>
			<div class="col-md-8 col-lg-9">
				<div class="acc-right profile-main">
					<div class="row">
						<div class="col-md-9">
							<div class="main-heading">
								<h2 class="mb-4">{{$data['content']['banner_text']}}</h2>
								<div class="breadcrumb mb-4">
									<ul class="d-inline-flex align-items-center gap-2">
										<li><a href="<?= asset('') ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>
										<li>></li>
										<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-between align-items-center mb-4">
						<div class="wallet">
							@php
								$symbol = Session::get('symbol_right').''.Session::get('symbol_left');

							@endphp
							<strong><?=App\Http\Controllers\Web\IndexController::trans_labels('Wallet Balance')?>:</strong>
							<strong class="fw-normal">{{ $symbol }} <?= number_format($result['credit']  * session('currency_value'), 2) ?></strong>
						</div>
						<div class="wallet-total d-flex gap-3">
							<div class="d-flex align-items-center">
								<span style="width: 10px; height: 10px; background-color: green; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
								<strong class="fw-normal"><?=App\Http\Controllers\Web\IndexController::trans_labels('Total Earned')?> {{ $symbol }} <?= number_format($result['total_earned']  * session('currency_value'), 2) ?></strong>
							</div>
							<div class="d-flex align-items-center">
								<span style="width: 10px; height: 10px; background-color: red; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
								<strong class="fw-normal"><?=App\Http\Controllers\Web\IndexController::trans_labels('Total Redeemed')?> {{ $symbol }} <?= number_format($result['total_redeemed']  * session('currency_value'), 2) ?></strong>
							</div>
						</div>
					</div>


					<div class="table-responsive">
						

						<?php

						if (!empty($result['history'])) : ?>
												<div class="col-sm-6 col-lg-3">
							<form id="sort_wallet" class="mb-3 gap-2 careerFilter">

								<div class="form-group ct-slct">

									<div class="child_option position-relative">

										<button 
											class="form-control open-menu2 text-start d-flex align-items-center justify-content-between"
											type="button"><?=App\Http\Controllers\Web\IndexController::trans_labels('Filter by Type')?><svg
												width="12" height="8" viewBox="0 0 12 8" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2"
													stroke-linecap="round" />
											</svg></button>

										<div class="dropdown-menu2 dropdown-menu-right">

											<ul class="careerFilterInr" id="WalletType">

												<li><a href="javascript:;" class="dropdown_select"
														value="All"><?=App\Http\Controllers\Web\IndexController::trans_labels('All')?></a></li>

												<li><a href="javascript:;" class="dropdown_select"
														value="credit"><?=App\Http\Controllers\Web\IndexController::trans_labels('Credit')?></a></li>
												<li><a href="javascript:;" class="dropdown_select"
														value="debit"><?=App\Http\Controllers\Web\IndexController::trans_labels('Debit')?></a></li>

											</ul>

										</div>



									</div>

								</div>

							</form>
						</div>
							<table class="w-100" id="wallet-history-table">
								<thead>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Id')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Type')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Amount')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Amount')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Date')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Expiry Date')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Status')?></th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($result['history'] as $item) :

										$c = $item['transaction_type'] == 'debit' ? 'alert-danger' : 'alert-success';
										$order = !empty($item['transaction_order']) ? App\Models\Web\Order::find($item['transaction_order']) : null;
									?>

										<tr class="<?= $c ?>">
											<td>
												<p class="m-0"><?= $item['transaction_order'] ?></p>
											</td>
											<td>
												<p class="m-0 <?= strtolower($item['transaction_type']) === 'debit' ? 'debit' : 'credit' ?>"><?= App\Http\Controllers\Web\IndexController::trans_labels(ucwords($item['transaction_type'])) ?></p>
											</td>
											<td>
												<p class="m-0"><?= $order ? $order->currency . ' ' . number_format($order->order_total, 2) : '-' ?></p>
											</td>

											<td>
												<p class="m-0">
													<?= strtolower($item['transaction_type']) === 'debit' ? '-' : '+' ?>
													{{ session('currency_title') }} <?= number_format($item['transaction_points'] * session('currency_value'), 2) ?>
												</p>
											</td>
											<td>
												<p class="m-0"><?= date('d M, Y', strtotime($item['created_at'])) ?></p>
											</td>
											<td>
												@if($item['transaction_type'] === 'debit')
												<p class="m-0">
													(No Expiry)
												</p>
												@else
												<p class="m-0">
													<?= date('d M, Y', strtotime($item['expiry_date'])) ?>
													<?= strtotime($item['expiry_date']) <= time() ? '(Expired)' : '' ?>
												</p>
												@endif
											</td>
											<td>
												<p class="m-0">
													@if($item['transaction_status'] === 'pending_payment')
													<?=App\Http\Controllers\Web\IndexController::trans_labels('Pending')?>
													@elseif($item['transaction_status'] === 'completed')
													<?=App\Http\Controllers\Web\IndexController::trans_labels('Available')?>
													@endif
												</p>

											</td>
										</tr>

									<?php
										$i++;
									endforeach; ?>

								</tbody>

							</table>

						<?php endif; ?>
					</div>

				</div>

			</div>
		</div>
	</div>
	</div>
</section>

@endsection