<div class="pro-reviews productdetail-section-three my-4 my-lg-5 pt-lg-3">

	<div class="row justify-content-between align-items-center mb-4">

		<div class="col-lg-12">

			<div class="main-heading m-0">

				<h2><?= App\Http\Controllers\Web\IndexController::trans_labels('Ratings & Reviews') ?></h2>

			</div>

		</div>

		<!-- <div class="col-sm-5 col-md-4 col-xl-3">

								<div class="text-end">

									<a href="javascript:;" class="btn mb-4">View All <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 8H13.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 3.5L13.5 8L9 12.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>

								</div>

							</div> -->

	</div>

	<div class="d-flex align-items-center justify-content-between mb-2">

		<div class="d-flex align-items-center gap-3">

			<div class="rating-box d-flex">

				<div class="rating-container">

					<?php

					$stars = range(1, 5);

					krsort($stars);

					foreach ($stars as $star) : ($star <= $result['review']['rating']) ? $css = 'style="color:#FFBC11"' : $css = ''; ?>

						<input type="radio" name="rating" class="rating_star" value="<?= $star ?>" id="star-<?= $star ?>"> <label <?= $css ?> for="star-<?= $star ?>">&#9733;</label>

					<?php endforeach; ?>

				</div>

			</div>
			<aside><span class="rating_count"><?= number_format($result['review']['rating'], 1) ?>/5</span> <?= App\Http\Controllers\Web\IndexController::trans_labels('Ratings') ?></aside>

		</div>

		<aside>(<span class="review_count"><?= $result['review']['count'] ?></span> <?= App\Http\Controllers\Web\IndexController::trans_labels('Reviews') ?>)</aside>

	</div>

	<div class="review_comments">

		<?php

		foreach ($result['reviews'] as $review) : ?>

			<div class="productdetail-three mb-4">

				<div class="d-flex align-items-center justify-content-between mb-2">

					<div class="d-flex align-items-center gap-3">

						<div class="rating-box d-flex">

							<div class="rating-container">

								<?php

								foreach ($stars as $star) : ($star <= $review['average_rating']) ? $css = 'style="color:#FFBC11"' : $css = ''; ?>

									<input type="radio" name="rating" value="<?= $star ?>" id="star-<?= $star ?>"> <label <?= $css ?> for="star-<?= $star ?>">&#9733;</label>

								<?php endforeach; ?>


							</div>

						</div>

						<h5 class="mb-0"><?= $review['showusername'] == 'on' ? $review['user']['first_name'] : 'Anonymous' ?></h5>

					</div>

					<aside>
						<?php
						$createdDate = new DateTime($review['created_at']);
						$now = new DateTime();
						$diffInSeconds = $now->getTimestamp() - $createdDate->getTimestamp();
						if ($diffInSeconds < 60) {
							echo $diffInSeconds . ' seconds ago';
						} elseif ($diffInSeconds < 3600) {
							echo floor($diffInSeconds / 60) . ' minutes ago';
						} elseif ($diffInSeconds < 86400) {
							echo floor($diffInSeconds / 3600) . ' hours ago';
						} elseif ($diffInSeconds < 2592000) {
							echo floor($diffInSeconds / 86400) . ' days ago';
						} elseif ($diffInSeconds < 31536000) {
							echo floor($diffInSeconds / 2592000) . ' months ago';
						} else {
							echo floor($diffInSeconds / 31536000) . ' years ago';
						}
						?>
					</aside>



					<!-- %R%y years %m months -->

				</div>

				<p><?= $review['review'] ?></p>

				<div class="mt-3 d-flex flex-wrap gap-2">
					<?php foreach ($review['media'] as $file): ?>
						<?php
						$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
						$videoTypes = ['mp4', 'webm', 'ogg'];
						?>

						<?php if (in_array($ext, $videoTypes)): ?>
							<video width="150" controls>
								<source src="<?= asset($file) ?>" type="video/<?= $ext ?>">
								Your browser does not support the video tag.
							</video>
						<?php else: ?>
							<img src="<?= asset($file) ?>" width="150" alt="*" />
						<?php endif; ?>
					<?php endforeach; ?>
				</div>


			</div>

		<?php endforeach; ?>

	</div>

</div>

<div class="que-ans-section d-none productdetail-section-four pt-3">

	<div class="row justify-content-between align-items-center mb-4 pb-lg-3">

		<div class="col-xl-12">

			<div class="main-heading mb-0">

				<h2>Questions & Answers</h2>

			</div>

		</div>

		<div class="col-sm-4 col-xl-3 d-none">

			<div class="text-sm-end mt-3 mt-sm-0 mt-md-3 mt-lg-0">

				<a href="javascript:;" class="btn">View All <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.5 8H13.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M9 3.5L13.5 8L9 12.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg></a>

			</div>

		</div>

	</div>

	<div class="productdetail-three d-flex flex-column justify-content-between">

		<?php

		if (count($result['comments']) != 0) :

			foreach ($result['comments'] as $comment) : ?>

				<div class="d-flex justify-content-between mb-3">

					<ul class="d-flex flex-column gap-3">

						<li>

							<h4 style="background: #080F22;" class="text-white">Q</h4>

							<div>

								<p class="m-0"><?= $comment['comment'] ?></p>

								<small><?= $comment['user_ID']['first_name'] ?> <?= $comment['user_ID']['last_name'] ?> - <?= date('d M Y', strtotime($comment['created_at'])) ?></small>

							</div>

						</li>

						<?php

						if ($comment['answer']) : ?>

							<li class="answers">

								<h4>A</h4>

								<div>

									<p class="m-0"><?= $comment['answer']['comment'] ?></p>

									<small><?= $result['vendor']['metadata']['store_name'] ?> - <?= date('d M Y', strtotime($comment['answer']['created_at'])) ?></small>

								</div>

							</li>

						<?php endif; ?>

					</ul>

					<aside><?php $interval = date_diff(date_create($comment['created_at']), date_create(date('Y-m-d')));

							echo $interval->m != 0 ? $interval->format('%m months') : $interval->d . ' days'; ?> ago</aside>

				</div>
			<?php endforeach;

		else : ?>

			<h5>No Questions asked yet</h5>

		<?php endif; ?>
	</div>

	<?php

	if (Auth::check()) : ?>

		<a href="javascript:;" class="btn ask-question w-100 mt-4">Ask Questions </a>

		<div class="account-section mt-5">


			<form class="careerFilter comment-form" action="<?= asset('product/comment') ?>" style="display: none;" method="POST" enctype="multipart/form-data">

				@csrf

				<h5>Ask A Question</h5>

				<div class="row">

					<div class="col-md-12">


						<div class="form-group mb-3 clear-text">

							<textarea type="text" name="comment" placeholder="Your Question" class="form-control"></textarea>

							<input type="hidden" name="comment_type" value="question">
							<input type="hidden" name="parent_ID" value="0">
							<input type="hidden" name="user_ID" value="<?= Auth()->user()->id ?>">
							<input type="hidden" name="product_ID" value="<?= $result['ID'] ?>">

						</div>

						<button href="javascript:;" type="submit" class="btn">Submit</button>
					</div>

				</div>

			</form>

		</div>

	<?php endif; ?>

</div>