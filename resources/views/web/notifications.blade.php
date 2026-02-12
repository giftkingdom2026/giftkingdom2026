@extends('web.layout')



@section('content')
<section class="main-section home-section-six faq-section mb-lg-5 account-section">
	<div class="container careerFilter">
		<div class="main-heading text-center wow">

			<h2><?= $data['content']['pagetitle'] ?></h2>

			<div class="breadcrumb justify-content-center mt-3 wow fadeInUp">

				<ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

					<li><a href="<?= asset('') ?>"><?= App\Http\Controllers\Web\IndexController::trans_labels('Home') ?></a></li>

					<li>></li>

					<li><a href="javascript:;" class="active"><?= $data['content']['pagetitle'] ?></a></li>

				</ul>

			</div>
		</div>
		<div class="row d-flex justify-content-end mb-4">
			
		<div class="col-sm-6 col-lg-2">
			<div class="form-group ct-slct">
				<label class="mb-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('Per Page') ?>:</label>
				<div class="child_option position-relative">
					<button id="perPageBtn"
						class="form-control open-menu2 text-start d-flex align-items-center justify-content-between"
						type="button">
						{{ request('per_page', App\Http\Controllers\Web\IndexController::trans_labels('Select')) }}
						<svg width="12" height="8" viewBox="0 0 12 8" fill="none"
							xmlns="http://www.w3.org/2000/svg">
							<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round" />
						</svg>
					</button>

					<div class="dropdown-menu2 dropdown-menu-right">
						<ul class="careerFilterInr">
							@foreach ([10, 25, 50, 100] as $count)
							<li>
								<a href="{{ request()->fullUrlWithQuery(['per_page' => $count]) }}"
									class="dropdown_select">{{ $count }}</a>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
		</div>

		<ul class="list-unstyled mb-0">
			@if(count($all_notifications) > 0)
			@foreach ($all_notifications as $item)
			<li class="mb-2">
				<div class="notification-item d-flex p-4 bg-light rounded-2 justify-content-between gap-2">
@php
    $title = $item['title'];

    $phrases = [
        'Order Status Changed To',
        'Cashback for order',
        'In Process',
        'Completed',
        'Delivered',
		'Order Placed',
		'Used wallet credit for order'
    ];

    foreach ($phrases as $phrase) {
        if (str_contains($title, $phrase)) {
            $title = str_replace(
                $phrase,
                App\Http\Controllers\Web\IndexController::trans_labels($phrase),
                $title
            );
        }
    }
@endphp

<p class="mb-0 text-dark">
    <strong>{{ $title }}</strong>
</p>

					<div class="d-flex justify-content-between align-items-center mb-1">
						@if($item['type'] === 'order')
						<a href="<?= asset('account/order/' . $item['id']) ?>">
							<span class="badge bg-{{ $item['type'] === 'order' ? 'secondary' : 'success' }} text-capitalize fs-6">
								<?= App\Http\Controllers\Web\IndexController::trans_labels('View Order') ?>
							</span></a>
						@else
						<span class="badge bg-{{ $item['type'] === 'order' ? 'secondary' : 'success' }} text-capitalize fs-6">
							 {{ App\Http\Controllers\Web\IndexController::trans_labels(ucfirst($item['type'])) }}
						</span>
						@endif


					</div>

				</div>

			</li>
			@endforeach
			@else
			<li>
				<div class="text-center text-muted"><?= App\Http\Controllers\Web\IndexController::trans_labels('No notifications') ?></div>
			</li>
			@endif
			<div class="col-md-12">
				<div class="new_links">

					{{-- Show how many records are being displayed --}}
					<div class="text-center mt-5">
						<strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Showing') ?> {{ $result['from'] ?? 0 }} to {{ $result['to'] ?? 0 }} of {{ $result['total'] ?? 0 }} <?= App\Http\Controllers\Web\IndexController::trans_labels('notifications') ?></strong>
					</div>

					<div class="pagination d-flex justify-content-center align-items-center gap-4 mt-5">
						<ul class="d-flex justify-content-center align-items-center gap-4">
							@foreach ($result['links'] as $link)
							@php
							$url = $link['url'] ?? 'javascript:;';
							$class = $link['active'] ? 'active' : '';
							$title = $link['label'];

							if (str_contains($title, 'Previous')) {
							$title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 5.57692L1.61864 5.57692L6.0678 1.13462L5.50847 0.5L2.40413e-07 6L5.50847 11.5L6.0678 10.8654L1.61864 6.42308L12 6.42308L12 5.57692Z" fill="#6D7D36" />
							</svg>';
							} elseif (str_contains($title, 'Next')) {
							$title = '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M7.31755e-07 5.57692L10.3814 5.57692L5.9322 1.13462L6.49153 0.5L12 6L6.49153 11.5L5.9322 10.8654L10.3814 6.42308L6.94768e-07 6.42308L7.31755e-07 5.57692Z" fill="#6D7D36" />
							</svg>';
							}
							@endphp

							<li>
								<a href="{{ $url }}" class="{!! $class !!}">{!! $title !!}</a>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

		</ul>
	</div>
</section>

@endsection