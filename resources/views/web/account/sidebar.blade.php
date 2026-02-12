<?php



use App\Models\Web\Users;



$user = Users::getUserData();



?>



<div class="acc-sidebar">

	<div class="my-accounts">

		<h6 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('My Account')?></h6>

		<ul class="mb-4">

			<?php Route::current()->uri == 'account/{username}' ? $c = 'active' : $c = '';?>

			<li><a href="<?=asset('account/'.Auth()->user()->user_name)?>" class="<?=$c?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('My Profile')?></a></li>

			<?php Route::current()->uri == 'account/wallet-history' ? $c = 'active' : $c = '';?>

			<!--  if( $user['role_id'] == 3 ) : ?> -->

				<li><a href="<?=asset('account/wallet-history')?>" class="<?=$c?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Wallet')?></a></li>

			<!--  endif;?> -->
@php
    $c = Route::current()->uri == 'account/become-a-vendor' ? 'active' : '';
@endphp

@if (Auth::user()->role_id != 1)
    <li>
        <a href="{{ asset('account/become-a-vendor') }}" class="{{ $c }}">
            {{ isset($user['metadata']['approved']) && $user['metadata']['approved'] == 1 
                ? 'Vendor Details' 
                : 'Become A Vendor' }}
        </a>
    </li>
@endif
	<?php if( $user['role_id'] == 4) :

					if( isset( $user['metadata']['approved'] ) && $user['metadata']['approved'] == 1 ) : ?>

						<li>

							<a href="<?=asset('admin/product/list')?>">My Products</a>

						</li>

					<?php endif;

				endif;?>
			<?php Route::current()->uri == 'account/addresses' ? $c = 'active' : $c = '';?>

			<li><a href="<?=asset('account/addresses')?>" class="<?=$c?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('My Addresses')?></a></li>

			<!-- <li><a href="<?=asset('account/payment-option')?>">Payment Options</a></li> -->

		</ul>

	</div>

	<div class="my-orders">

		<h6 class="mb-3"><?=App\Http\Controllers\Web\IndexController::trans_labels('My Orders')?></h6>

		<ul class="mb-3">
			<?php Request::getRequestUri() === '/account/orders' ? $c = 'active' : $c = '';?>

			<li><a href="<?=asset('account/orders')?>" class="<?=$c?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Status')?></a></li>

			<?php Request::getRequestUri() === '/account/track-order' ? $c = 'active' : $c = '';?>

			<li><a href="<?=asset('account/track-order')?>" class="<?=$c?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Track Your Order')?></a></li>

			<?php Request::getRequestUri() == '/account/orders?status=Refunded' ? $c = 'active' : $c = '';?>

			<li><a href="<?=asset('account/orders?status=Refunded')?>" class="<?=$c?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('My Returns')?></a></li>

		</ul>

	</div>

	<div class="sidebar-bottom">

		<ul>
			<li><a href="<?=asset('account/give-reviews')?>"><h6 class="mb-0"><?=App\Http\Controllers\Web\IndexController::trans_labels('Give Reviews')?></h6></a></li>
			<li><a href="<?=asset('wishlist')?>"><h6 class="mb-0"><?=App\Http\Controllers\Web\IndexController::trans_labels('My Wishlist')?></h6></a></li>
			<li><a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logout"><h6 class="mb-0"><?=App\Http\Controllers\Web\IndexController::trans_labels('Logout')?></h6></a></li>
		</ul>

	</div>
<!-- 
	<div class="followed-stores head-border">

		<h6><a href="<?=asset('account/followed-stores')?>">Followed Stores</a></h6>

	</div>
	-->
<!-- 	<div class="logout head-border">

		<h6><a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logout">Logout</a></h6>

	</div> -->

</div>