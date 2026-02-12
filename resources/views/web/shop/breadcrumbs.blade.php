
<div class="breadcrumb mt-3 pb-lg-0">

	<ul class="d-inline-flex flex-row gap-3">

		<li><a href="<?=asset('')?>" class="breadcrumb-link"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

		<li>></li>

		<li><a href="<?=asset('shop')?>" class="breadcrumb-link"><?=App\Http\Controllers\Web\IndexController::trans_labels($result['content']['pagetitle'])?></a></li>

		<?php

		if( isset(request()->category) ) : ?>

			<li>></li>

			<li>

				<a href="javascript:;" class="active breadcrumb-link">

					<?=$category['category_title']?>

				</a>

			</li>

		<?php endif; ?>

	</ul>
</div>