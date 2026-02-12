@extends('web.layout')



@section('content')



<div class="breadcrumb">

	<div class="container">

		<ul class="d-inline-flex align-items-center gap-2">

			<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

			<li>></li>

			<li><a href="javascript:;"><?=App\Http\Controllers\Web\IndexController::trans_labels('Wallet')?></a></li>

		</ul>

	</div>

</div>



<section class="main-section account-section wallet-section">

	<div class="container">

		<div class="row">

			<div class="col-md-4 col-lg-3">

				@include('web.account.sidebar')

			</div>

			<div class="col-md-8 col-lg-9">

				<div class="acc-right">

					<div class="main-heading d-flex align-items-center justify-content-between flex-wrap gap-3">

						<h2>Wallet Info</h2>

						<a href="<?=asset('account/wallet-history')?>" class="btn trans-btn">View History</a>

					</div>





					<div class="row wallet-info">

						

						<div class="col-md-4 mb-3 mb-md-0">

							<div class="wrap text-center">

								<figure class="d-inline-flex align-items-center justify-content-center mx-auto rounded-circle overflow-hidden">

									<img height="50" src="<?=asset('images/media/2024/08/referral-2-svgrepo-com.svg')?>" alt="*" class="wow">

								</figure>

								<h5 class="pt-lg-1 text-white">Referrals</h5>

								<p class="m-0 text-white"><?=count($referrals)?></p>

							</div>

						</div>

						<div class="col-md-4 mb-3 mb-md-0">

							<div class="wrap text-center">

								<figure class="d-inline-flex align-items-center justify-content-center mx-auto rounded-circle overflow-hidden">

									<img height="50" src="<?=asset('')?>/images/media/2024/08/share-social-3106.svg" alt="*" class="wow">

								</figure>

								<h5 class="pt-lg-1 text-white">Social Shares</h5>

								<?php

								$count = 0;

								foreach( $social as $item ) : $item['completed'] == 1 ? $count++ : ''; endforeach; ?>

								<p class="m-0 text-white">(<?=$count?> / 4)</p>

							</div>

						</div>

						<div class="col-md-4">

							<div class="wrap text-center">

								<figure class="d-inline-flex align-items-center justify-content-center mx-auto rounded-circle overflow-hidden">

									<img height="50" src="<?=asset('')?>/images/media/2024/06/sec11Img3.svg" alt="*" class="wow">

								</figure>

								<h5 class="pt-lg-1 text-white">Wallet</h5>

								<p class="m-0 text-white">AED <?=($result['metadata']['store_credit'] / 400)?> (<?=$result['metadata']['store_credit']?> Points)</p>

							</div>

						</div>

					</div>



					<div class="main-heading my-4">

						<h4>Referrals Info :</h4>

					</div>



					<div class="row align-items-center">

						<div class="col-sm-4">

							<strong>Share on Social Media :</strong>

						</div>

						<?php



						$checkarr = isset($result['metadata']['social_share']) ? unserialize($result['metadata']['social_share']) : [];


						if( empty($checkarr) ) : $facebook = $linkedin = $twitter = $whatsapp = 'Share!'; endif;


						$facebook = isset($checkarr['facebook']) && $checkarr['facebook']['completed'] == 1 ? 'Shared!' : 'Share!';
						$linkedin = isset($checkarr['linkedin']) && $checkarr['linkedin']['completed'] == 1 ? 'Shared!' : 'Share!';
						$twitter = isset($checkarr['twitter']) && $checkarr['twitter']['completed'] == 1 ? 'Shared!' : 'Share!';
						$whatsapp = isset($checkarr['whatsapp']) && $checkarr['whatsapp']['completed'] == 1 ? 'Shared!' : 'Share!';
						
						?>

						<div class="col-sm-8">

							<ul class="socialIcons social-share mt-2 mt-sm-0">



								<li>
									<a target="_blank" data-bs-toggle="tooltip" data-bs-title="<?=$facebook?>" type="facebook" href="https://www.facebook.com/dialog/feed?app_id=729741561887898&display=page&link=<?=asset('?register='.$result['user_name'])?>">

									<svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.97508 18C2.97508 17.9274 2.9595 17.8548 2.9595 17.7676C2.9595 15.1969 2.9595 12.6117 2.9595 10.041C2.9595 9.96839 2.9595 9.89577 2.9595 9.79411C1.96262 9.79411 0.996885 9.79411 0 9.79411C0 8.71935 0 7.67365 0 6.59889C0.981308 6.59889 1.94704 6.59889 2.9595 6.59889C2.9595 6.51175 2.9595 6.43913 2.9595 6.36652C2.9595 5.52414 2.94393 4.69629 2.97508 3.85392C3.02181 2.85178 3.33334 1.92226 4.09658 1.16703C4.6729 0.600607 5.40498 0.266562 6.21495 0.106801C6.88473 -0.0239124 7.55452 -0.00938874 8.2243 0.0196587C8.76947 0.0341824 9.31464 0.0777535 9.85981 0.121325C9.90654 0.121325 9.93769 0.135848 10 0.150372C10 1.09441 10 2.03845 10 2.99702C9.93769 2.99702 9.87539 2.99702 9.7975 2.99702C9.12772 3.01154 8.45794 2.99702 7.78816 3.02606C6.99377 3.06964 6.54206 3.4763 6.5109 4.21701C6.47975 4.98676 6.49533 5.75652 6.49533 6.5408C6.49533 6.55532 6.5109 6.55532 6.5109 6.59889C7.61682 6.59889 8.73831 6.59889 9.87539 6.59889C9.71962 7.67365 9.57944 8.73388 9.43925 9.79411C8.45794 9.79411 7.49221 9.79411 6.5109 9.79411C6.5109 9.86673 6.49533 9.9103 6.49533 9.96839C6.49533 12.6117 6.49533 15.255 6.49533 17.8838C6.49533 17.9274 6.49533 17.971 6.5109 18C5.3271 18 4.15888 18 2.97508 18Z" fill="#4A2C9D"></path>

									</svg>

								</a>

							</li>



							<li>

								<a target="_blank" type="linkedin" data-bs-toggle="tooltip" data-bs-title="<?=$linkedin?>" href="http://www.linkedin.com/shareArticle?mini=true&url=<?=asset('?register='.$result['user_name'])?>">

									<svg fill="#4A2C9D" width="18" height="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310 310" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_801_"> <path id="XMLID_802_" d="M72.16,99.73H9.927c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5H72.16c2.762,0,5-2.238,5-5V104.73 C77.16,101.969,74.922,99.73,72.16,99.73z"></path> <path id="XMLID_803_" d="M41.066,0.341C18.422,0.341,0,18.743,0,41.362C0,63.991,18.422,82.4,41.066,82.4 c22.626,0,41.033-18.41,41.033-41.038C82.1,18.743,63.692,0.341,41.066,0.341z"></path> <path id="XMLID_804_" d="M230.454,94.761c-24.995,0-43.472,10.745-54.679,22.954V104.73c0-2.761-2.238-5-5-5h-59.599 c-2.762,0-5,2.239-5,5v199.928c0,2.762,2.238,5,5,5h62.097c2.762,0,5-2.238,5-5v-98.918c0-33.333,9.054-46.319,32.29-46.319 c25.306,0,27.317,20.818,27.317,48.034v97.204c0,2.762,2.238,5,5,5H305c2.762,0,5-2.238,5-5V194.995 C310,145.43,300.549,94.761,230.454,94.761z"></path> </g> </g></svg>

								</a>

							</li>



							<li>

								<a target="_blank" data-bs-toggle="tooltip" data-bs-title="<?=$twitter?>" type="twitter" href="https://twitter.com/intent/tweet?url=<?=asset('?register='.$result['user_name'])?>">

									<svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 13.3105C2.01663 13.4954 3.7999 12.9994 5.42025 11.755C3.73385 11.5972 2.61106 10.7271 1.97701 9.11751C2.5362 9.18514 3.06018 9.19416 3.62378 9.04086C2.73434 8.81543 2.03425 8.37359 1.49706 7.67926C0.959882 6.98944 0.695694 6.19593 0.695694 5.30773C0.964285 5.41143 1.21526 5.52865 1.47505 5.6053C1.73924 5.68194 2.01223 5.709 2.28523 5.74506C0.682486 4.33838 0.30822 2.6747 1.20646 0.677382C3.22309 3.10753 5.74609 4.43757 8.81507 4.64947C8.80186 4.27526 8.77104 3.91457 8.77984 3.55839C8.82388 2.00291 9.9863 0.524089 11.4614 0.140856C12.8263 -0.215324 14.0284 0.104788 15.0543 1.09217C15.1292 1.16431 15.1952 1.19587 15.3009 1.1598C15.6707 1.04258 16.0494 0.952407 16.4105 0.81264C16.7715 0.672873 17.115 0.48802 17.4848 0.312184C17.3659 0.735994 17.1722 1.11472 16.8992 1.43934C16.6262 1.75945 16.3092 2.048 16.0142 2.34106C16.6702 2.26441 17.3219 2.05702 18 1.77748C17.5289 2.48984 17.0005 3.08498 16.362 3.5674C16.1991 3.68914 16.1595 3.81989 16.1639 4.01827C16.1991 5.75408 15.8249 7.40423 15.0895 8.96422C14.2045 10.8398 12.9232 12.3547 11.1884 13.4548C9.95107 14.2393 8.60812 14.7037 7.1683 14.8976C5.9046 15.0689 4.64971 15.0283 3.40362 14.7533C2.21477 14.4918 1.10959 14.0274 0.0792558 13.3691C0.0660464 13.3646 0.0528376 13.3511 0 13.3105Z" fill="#4A2C9D"></path></svg>

								</a>

							</li>



							<li>

								<a data-bs-toggle="tooltip" data-bs-title="<?=$whatsapp?>" type="whatsapp" href="https://api.whatsapp.com/send?text=<?=asset('?register='.$result['user_name'])?>" target="_blank">

									<svg fill="#4A2C9D" height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 308 308" xml:space="preserve" stroke="#4A2C9D"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="XMLID_468_"> <path id="XMLID_469_" d="M227.904,176.981c-0.6-0.288-23.054-11.345-27.044-12.781c-1.629-0.585-3.374-1.156-5.23-1.156 c-3.032,0-5.579,1.511-7.563,4.479c-2.243,3.334-9.033,11.271-11.131,13.642c-0.274,0.313-0.648,0.687-0.872,0.687 c-0.201,0-3.676-1.431-4.728-1.888c-24.087-10.463-42.37-35.624-44.877-39.867c-0.358-0.61-0.373-0.887-0.376-0.887 c0.088-0.323,0.898-1.135,1.316-1.554c1.223-1.21,2.548-2.805,3.83-4.348c0.607-0.731,1.215-1.463,1.812-2.153 c1.86-2.164,2.688-3.844,3.648-5.79l0.503-1.011c2.344-4.657,0.342-8.587-0.305-9.856c-0.531-1.062-10.012-23.944-11.02-26.348 c-2.424-5.801-5.627-8.502-10.078-8.502c-0.413,0,0,0-1.732,0.073c-2.109,0.089-13.594,1.601-18.672,4.802 c-5.385,3.395-14.495,14.217-14.495,33.249c0,17.129,10.87,33.302,15.537,39.453c0.116,0.155,0.329,0.47,0.638,0.922 c17.873,26.102,40.154,45.446,62.741,54.469c21.745,8.686,32.042,9.69,37.896,9.69c0.001,0,0.001,0,0.001,0 c2.46,0,4.429-0.193,6.166-0.364l1.102-0.105c7.512-0.666,24.02-9.22,27.775-19.655c2.958-8.219,3.738-17.199,1.77-20.458 C233.168,179.508,230.845,178.393,227.904,176.981z"></path> <path id="XMLID_470_" d="M156.734,0C73.318,0,5.454,67.354,5.454,150.143c0,26.777,7.166,52.988,20.741,75.928L0.212,302.716 c-0.484,1.429-0.124,3.009,0.933,4.085C1.908,307.58,2.943,308,4,308c0.405,0,0.813-0.061,1.211-0.188l79.92-25.396 c21.87,11.685,46.588,17.853,71.604,17.853C240.143,300.27,308,232.923,308,150.143C308,67.354,240.143,0,156.734,0z M156.734,268.994c-23.539,0-46.338-6.797-65.936-19.657c-0.659-0.433-1.424-0.655-2.194-0.655c-0.407,0-0.815,0.062-1.212,0.188 l-40.035,12.726l12.924-38.129c0.418-1.234,0.209-2.595-0.561-3.647c-14.924-20.392-22.813-44.485-22.813-69.677 c0-65.543,53.754-118.867,119.826-118.867c66.064,0,119.812,53.324,119.812,118.867 C276.546,215.678,222.799,268.994,156.734,268.994z"></path> </g> </g></svg>

								</a>

							</li>

						</ul>



						<input type="text" readonly class="form-control d-none" style="border-color: rgb(51 51 51);color: rgb(51 51 51);" value="<?=$result['referrer'] == 'none' ? '-' : $result['referrer']['email']?>">

					</div> 

				</div>

				<div class="row align-items-center mt-3">

					<div class="col-sm-4">

						<strong>Your Referral Link:</strong>

					</div>

					<div class="col-sm-8 position-relative refer-box mt-2 mt-sm-0">



						<input type="text" readonly class="form-control" style="border-color: rgb(51 51 51);color: rgb(51 51 51);" value="<?=asset('?register='.$result['user_name'])?>">



						<a class="copy-share" title="Copy">

							<svg fill="#fff" height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Text-files"> <path d="M53.9791489,9.1429005H50.010849c-0.0826988,0-0.1562004,0.0283995-0.2331009,0.0469999V5.0228 C49.7777481,2.253,47.4731483,0,44.6398468,0h-34.422596C7.3839517,0,5.0793519,2.253,5.0793519,5.0228v46.8432999 c0,2.7697983,2.3045998,5.0228004,5.1378999,5.0228004h6.0367002v2.2678986C16.253952,61.8274002,18.4702511,64,21.1954517,64 h32.783699c2.7252007,0,4.9414978-2.1725998,4.9414978-4.8432007V13.9861002 C58.9206467,11.3155003,56.7043495,9.1429005,53.9791489,9.1429005z M7.1110516,51.8661003V5.0228 c0-1.6487999,1.3938999-2.9909999,3.1062002-2.9909999h34.422596c1.7123032,0,3.1062012,1.3422,3.1062012,2.9909999v46.8432999 c0,1.6487999-1.393898,2.9911003-3.1062012,2.9911003h-34.422596C8.5049515,54.8572006,7.1110516,53.5149002,7.1110516,51.8661003z M56.8888474,59.1567993c0,1.550602-1.3055,2.8115005-2.9096985,2.8115005h-32.783699 c-1.6042004,0-2.9097996-1.2608986-2.9097996-2.8115005v-2.2678986h26.3541946 c2.8333015,0,5.1379013-2.2530022,5.1379013-5.0228004V11.1275997c0.0769005,0.0186005,0.1504021,0.0469999,0.2331009,0.0469999 h3.9682999c1.6041985,0,2.9096985,1.2609005,2.9096985,2.8115005V59.1567993z"></path> <path d="M38.6031494,13.2063999H16.253952c-0.5615005,0-1.0159006,0.4542999-1.0159006,1.0158005 c0,0.5615997,0.4544001,1.0158997,1.0159006,1.0158997h22.3491974c0.5615005,0,1.0158997-0.4542999,1.0158997-1.0158997 C39.6190491,13.6606998,39.16465,13.2063999,38.6031494,13.2063999z"></path> <path d="M38.6031494,21.3334007H16.253952c-0.5615005,0-1.0159006,0.4542999-1.0159006,1.0157986 c0,0.5615005,0.4544001,1.0159016,1.0159006,1.0159016h22.3491974c0.5615005,0,1.0158997-0.454401,1.0158997-1.0159016 C39.6190491,21.7877007,39.16465,21.3334007,38.6031494,21.3334007z"></path> <path d="M38.6031494,29.4603004H16.253952c-0.5615005,0-1.0159006,0.4543991-1.0159006,1.0158997 s0.4544001,1.0158997,1.0159006,1.0158997h22.3491974c0.5615005,0,1.0158997-0.4543991,1.0158997-1.0158997 S39.16465,29.4603004,38.6031494,29.4603004z"></path> <path d="M28.4444485,37.5872993H16.253952c-0.5615005,0-1.0159006,0.4543991-1.0159006,1.0158997 s0.4544001,1.0158997,1.0159006,1.0158997h12.1904964c0.5615025,0,1.0158005-0.4543991,1.0158005-1.0158997 S29.0059509,37.5872993,28.4444485,37.5872993z"></path> </g> </g></svg>

						</a>



					</div>

				</div> 

			</div>



			<div class="row align-items-center mt-3">

				<div class="col-sm-4">

					<strong>Your Referral Revenue:</strong>

				</div>

				<div class="col-sm-8 mt-2 mt-sm-0">

					<input type="text" readonly class="form-control" style="border-color: rgb(51 51 51);color: rgb(51 51 51);" value="AED <?=($result['referral_revenue'] / 400)?> (<?=$result['referral_revenue']?> Points)">

				</div> 

			</div>



			<div class="row align-items-center mt-3">

				<div class="col-sm-4">

					<strong>Your Social Share Revenue:</strong>

				</div>

				<div class="col-sm-8 mt-2 mt-sm-0">

					<input type="text" readonly class="form-control" style="border-color: rgb(51 51 51);color: rgb(51 51 51);" value="AED <?=(($count * 1000)/400)?> (<?=$count * 1000?> Points)">

				</div> 

			</div>



			<div class="main-heading my-4">

				<h4>Your Referrals :</h4>

			</div>



			<div class="row align-items-center mt-3">



				<?php 



				if( !empty( $referrals ) ) : ?>



					<div class="col-sm-4 border-bottom mb-3 pb-2">

						<strong>Name</strong>

					</div>



					<div class="col-sm-4 border-bottom mb-3 pb-2">

						<strong>Email</strong>

					</div>



					<div class="col-sm-4 border-bottom mb-3 pb-2">

						<strong>Registered Date</strong>

					</div>



					<?php foreach( $referrals as $ref ) : ?>



						<div class="col-sm-4">

							<p><?=$ref['referral_id']['first_name']?> <?=$ref['referral_id']['last_name']?></p>

						</div>



						<div class="col-sm-4">

							<p><?=$ref['referral_id']['email']?></p>

						</div>



						<div class="col-sm-4">

							<p><?=date('d M, Y', strtotime($ref['referral_id']['created_at']))?></p>

						</div>



					<?php endforeach;



				else :?>	



					<p>No Referrals Yet!</p>



				<?php endif;?>



			</div>



		</div>

	</div>

</div>

</div>

</section>



@endsection



