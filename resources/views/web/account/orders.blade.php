@extends('web.layout')



@section('content')




<section class="main-section account-section return-section">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-3">
				@include('web.account.sidebar')
			</div>
			<div class="col-md-8 col-lg-9 ps-md-4">
				<div class="acc-right">

					<?php 

					if( empty( $orders['data'] ) ) : 

						if( isset( $_GET['status'] ) && $_GET['status'] == 'Refunded' ) : ?>

							<div class="inner-banner">
								<div class="container">
									<article class="p-5">
										<div class="row justify-content-between align-items-center">
											<div class="col-md-8 col-xl-8">
												<h4 class="mb-5">{{$data['content']['refund_page_heading']}}</h4>
												<a href="{{$data['content']['refund_page_button_url']}}" class="btn">{{$data['content']['refund_page_button']}}</a>
											</div>
											<div class="col-md-4 col-lg-4">
												<figure class="overflow-hidden">
													<img src="{{asset($data['content']['banner_image']['path'])}}" alt="*" class="wow animated" style="visibility: visible;">
												</figure>
											</div>
										</div>
									</article>
								</div>
							</div>

						<?php else : ?>

							<div class="inner-banner">
								<div class="container">
									<article class="p-5">
										<div class="row justify-content-between align-items-center">
											<div class="col-md-8 col-xl-8">
												<h4 class="mb-5">There are no orders yet</h4>
												<p>Start your shopping experience now!</p>
												<a href="<?=asset('shop')?>" class="btn">Shop Now</a>
											</div>
											<div class="col-md-4 col-lg-4">
												<figure class="overflow-hidden">
													<img src="<?=asset('images/media/2024/12/No Order Status 1.png')?>" alt="*" class="wow animated" style="visibility: visible;">
												</figure>
											</div>
										</div>
									</article>
								</div>
							</div>

						<?php endif;?>

					<?php else: ?>

						<div class="main-heading">
							<h2>{{$data['content']['pagetitle']}}</h2>
							<div class="breadcrumb orderStatus mt-3 mb-3 mb-lg-0">

							<div class="container">

								<ul class="d-inline-flex align-items-center gap-2">

									<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

									<li>></li>

									<li><a href="<?=asset('account/'.Auth()->user()->user_name)?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Account')?></a></li>

									<li>></li>

									<li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>

								</ul>

							</div>

						</div>
						</div>

						<div class="table-responsive">
							<table class="w-100">
								<tr>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Order')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Date')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Status')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Total')?></th>
									<th><?=App\Http\Controllers\Web\IndexController::trans_labels('Actions')?></th>
								</tr>

								<?php 
					
								foreach ($orders['data'] as $key => $order)  :

									$date=date('M d, Y', strtotime($order['created_at'])); ?>


									<tr>
										<td class="order-id"><span>#<?=$order['ID'];?></span></td>
										<td class="order-date"><?=$date?></td>
										<td class="order-status processing"><i><?=App\Http\Controllers\Web\IndexController::trans_labels($order['order_status']);?></i></td>
										<?php

										$total = $order['order_total']?>

										<td class="order-total"><span class="price"><?=$order['currency'];?> <?=number_format($total,2);?></span> for <?=$order['items'];?> item</td>
										<td class="order-action"><a href="<?=asset('account/order/'.$order['ID'])?>" class="btn"><?=App\Http\Controllers\Web\IndexController::trans_labels('View')?></a></td>
									</tr>
								<?php endforeach ?>

							</table>
						</div>

						
					</div>

				<?php endif; ?>

			</div>
		</div>
	</div>
</section>

@endsection