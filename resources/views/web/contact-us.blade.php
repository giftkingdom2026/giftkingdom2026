@extends('web.layout')



@section('content')

<?php
use App\Models\Core\Setting;

$setting = Setting::getWebSettings();

?>

<section class="main-section contact-section-one">

	<div class="container">

		<div class="main-heading text-center mb-3 mb-lg-5">
			
			<h2><?=$data['content']['pagetitle']?></h2>

			<div class="breadcrumb justify-content-center mt-2 mt-lg-4">

				<ul class="d-inline-flex align-items-center bg-transparent rounded-0 border-0 gap-2">

					<li><a href="<?=asset('')?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

					<li>></li>

					<li><a href="javascript:;" class="active"><?=$data['content']['pagetitle']?></a></li>

				</ul>

			</div>
		</div>

		<div class="row">

			<div class="col-md-6">

				<div class="contactWrap">

					<div class="main-heading mb-4">

						<h4 class="m-0 text-capitalize"><?=$data['content']['s1_head']?></h4>

					</div>

					<form class="js-form has-response careerFilter" action="<?=asset('inquiry')?>">

						<div class="row">

							<div class="col-lg-6">

								<div class="form-group mb-3">

									<label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Name')?> *</label>

									<input type="text" id="name" required name="name" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter your Name')?>" class="form-control bg-white">

								</div>

							</div>

							<div class="col-lg-6">

								<div class="form-group mb-3">

									<label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Email Address')?> *</label>

									<input type="email" id="email" required name="email" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter your Email Address')?>" class="form-control bg-white">

								</div>

							</div>

							<div class="col-lg-12">

								<div class="form-group mb-3">

									<label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Subject')?> *</label>

									<input type="text" id="subject" required name="subject" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter Subject')?>" class="form-control bg-white">

								</div>

							</div>

							<div class="col-lg-12">
								
								<div class="form-group ct-slct mb-3">

									<label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Support Category')?>*</label>

									<div class="child_option position-relative">

										<button id="hotel" class="form-control open-menu2 text-start d-flex align-items-center justify-content-between" type="button"><?=App\Http\Controllers\Web\IndexController::trans_labels('Select')?><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round"/></svg></button> 

										<div class="dropdown-menu2 dropdown-menu-right">   

											<ul class="careerFilterInr">

												<li><a href="javascript:;" class="dropdown_select" value="Order Inquiry (Existing & New Orders)"><?=App\Http\Controllers\Web\IndexController::trans_labels('Order Inquiry (Existing & New Orders)')?></a></li>
												<li><a href="javascript:;" class="dropdown_select" value="Personalization Requests"><?=App\Http\Controllers\Web\IndexController::trans_labels('Personalization Requests')?></a></li>
												<li><a href="javascript:;" class="dropdown_select" value="Corporate & Event Solutions"><?=App\Http\Controllers\Web\IndexController::trans_labels('Corporate & Event Solutions')?></a></li>
												<li><a href="javascript:;" class="dropdown_select" value="Delivery & Shipping Questions"><?=App\Http\Controllers\Web\IndexController::trans_labels('Delivery & Shipping Questions')?></a></li>
												<li><a href="javascript:;" class="dropdown_select" value="Account & Payments"><?=App\Http\Controllers\Web\IndexController::trans_labels('Account & Payments')?></a></li>
												<li><a href="javascript:;" class="dropdown_select" value="Collaborations & Partnerships"><?=App\Http\Controllers\Web\IndexController::trans_labels('Collaborations & Partnerships')?></a></li>
												<li><a href="javascript:;" class="dropdown_select" value="General Inquiry"><?=App\Http\Controllers\Web\IndexController::trans_labels('General Inquiry')?></a></li>

											</ul>

										</div>

										<input type="hidden" class="inputhide" required name="support_category" value="">

									</div>

								</div>

							</div>

							<div class="col-lg-12">

								<div class="form-group mb-3">

									<label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Message')?> *</label>

									<textarea class="form-control bg-white" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter Message')?>" required name="message"></textarea>

								</div>

							</div>

						</div>

						<button class="btn mt-2 mt-lg-4"><?=App\Http\Controllers\Web\IndexController::trans_labels('Submit')?><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.500001 5.57692L10.8814 5.57692L6.4322 1.13462L6.99153 0.5L12.5 6L6.99153 11.5L6.4322 10.8654L10.8814 6.42308L0.500001 6.42308L0.500001 5.57692Z" fill="#6D7D36"/></svg>
						</button>

						<div class="response"></div>
					</form>

				</div>	

			</div>

			<div class="col-md-6">

				<figure class="h-100">

					<?=$setting['map_iframe']?>

				</figure>

			</div>

		</div>

	</div>

</section>



<section class="main-section home-section-eleven contact-section-two">

	<div class="container">

		<div class="row justify-content-center">

			<div class="col-xl-11">

				<div class="row gy-3 gy-md-0">

					<div class="col-md-4">

						<div class="wrap d-flex align-items-center gap-4">

							<figure class="d-inline-flex align-items-center justify-content-center p-4 rounded-circle overflow-hidden">

								<svg width="26" height="26" viewBox="0 0 20 26" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1.96347 7.8587C1.60535 5.49995 3.26847 3.3812 5.8091 2.60495C6.25996 2.46804 6.74602 2.50771 7.16872 2.71592C7.59141 2.92414 7.9191 3.28531 8.08535 3.7262L8.90097 5.9012C9.03227 6.2511 9.05602 6.63226 8.96915 6.99574C8.88229 7.35923 8.68878 7.68847 8.41347 7.9412L5.98722 10.1631C5.86748 10.2727 5.77826 10.4116 5.7283 10.5661C5.67834 10.7205 5.66935 10.8853 5.70222 11.0443L5.72472 11.1418L5.78285 11.3856C6.08534 12.5697 6.54505 13.7079 7.14972 14.77C7.80995 15.8976 8.62826 16.9249 9.57972 17.8206L9.65472 17.8881C9.77585 17.9956 9.92276 18.0699 10.0811 18.1037C10.2395 18.1376 10.404 18.1298 10.5585 18.0812L13.6953 17.0931C14.0518 16.9811 14.4337 16.9783 14.7918 17.0849C15.1499 17.1914 15.468 17.4026 15.7053 17.6912L17.1903 19.4931C17.8091 20.2431 17.7341 21.3456 17.0235 22.0075C15.0791 23.8206 12.4053 24.1918 10.5453 22.6975C8.26444 20.8594 6.34226 18.6162 4.87535 16.0806C3.39408 13.5483 2.40731 10.7586 1.96347 7.8587ZM7.66722 11.1681L9.67722 9.32308C10.2282 8.81783 10.6155 8.15946 10.7896 7.43247C10.9637 6.70548 10.9165 5.94306 10.6541 5.24308L9.84035 3.06808C9.50651 2.18077 8.84743 1.45382 7.997 1.03487C7.14656 0.61592 6.16854 0.536397 5.2616 0.812452C2.10597 1.77808 -0.427152 4.60745 0.109098 8.14183C0.484098 10.6093 1.34847 13.7481 3.25535 17.0256C4.83806 19.7596 6.9115 22.1781 9.3716 24.16C12.1616 26.4006 15.8853 25.6356 18.3041 23.3818C18.9962 22.7374 19.4163 21.8532 19.4787 20.9096C19.541 19.966 19.241 19.0342 18.6397 18.3043L17.1547 16.5006C16.6797 15.924 16.0432 15.5024 15.327 15.29C14.6107 15.0775 13.8474 15.0838 13.1347 15.3081L10.5303 16.1275C9.85787 15.4342 9.26886 14.6646 8.77535 13.8343C8.29912 12.9947 7.9276 12.0999 7.6691 11.17" fill="#6D7D36"/>
								</svg>

							</figure>

							<div>
								
								<h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Call Us')?></h5>

								<a href="tel:<?=$setting['phone']?>" class="link d-inline-block"><?=$setting['phone']?></a>

							</div>

						</div>

					</div>

					<div class="col-md-4">

						<div class="wrap d-flex align-items-center gap-4">

							<figure class="d-inline-flex align-items-center justify-content-center p-4  rounded-circle overflow-hidden">

								<svg width="28" height="28" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M7.75 6.25L14 10.625L20.25 6.25" stroke="#6D7D36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M1.5 16.25V3.75C1.5 3.08696 1.76339 2.45107 2.23223 1.98223C2.70107 1.51339 3.33696 1.25 4 1.25H24C24.663 1.25 25.2989 1.51339 25.7678 1.98223C26.2366 2.45107 26.5 3.08696 26.5 3.75V16.25C26.5 16.913 26.2366 17.5489 25.7678 18.0178C25.2989 18.4866 24.663 18.75 24 18.75H4C3.33696 18.75 2.70107 18.4866 2.23223 18.0178C1.76339 17.5489 1.5 16.913 1.5 16.25Z" stroke="#6D7D36" stroke-width="1.5"/>
								</svg>

							</figure>

							<div>
								
								<h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Email Us')?></h5>

								<a href="mailto:<?=$setting['email']?>" class="link d-inline-block"><?=$setting['email']?></a>
							</div>

						</div>

					</div>

					<div class="col-md-4">

						<div class="wrap d-flex align-items-center gap-4">

							<figure class="d-inline-flex align-items-center justify-content-center p-4  rounded-circle overflow-hidden">

								<svg width="28" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.0003 0.571411C14.9555 0.571411 17.7898 1.74539 19.8795 3.83508C21.9692 5.92477 23.1431 8.759 23.1431 11.7143C23.1431 16.4228 19.8346 21.5543 13.3031 27.1634C12.94 27.4754 12.4769 27.6467 11.9981 27.6463C11.5194 27.6459 11.0566 27.4737 10.694 27.1611L10.262 26.7863C4.01971 21.3234 0.857422 16.3177 0.857422 11.7143C0.857422 8.759 2.0314 5.92477 4.12109 3.83508C6.21078 1.74539 9.04501 0.571411 12.0003 0.571411ZM12.0003 2.2857C9.49967 2.2857 7.10147 3.27906 5.33327 5.04726C3.56507 6.81546 2.57171 9.21366 2.57171 11.7143C2.57171 15.7166 5.48371 20.328 11.3877 25.4937L11.814 25.8628C11.8658 25.9074 11.9319 25.9319 12.0003 25.9319C12.0686 25.9319 12.1347 25.9074 12.1866 25.8628C18.3763 20.5463 21.4288 15.8114 21.4288 11.7143C21.4288 10.4761 21.185 9.25004 20.7111 8.10611C20.2373 6.96218 19.5428 5.92279 18.6673 5.04726C17.7918 4.17174 16.7524 3.47723 15.6084 3.0034C14.4645 2.52957 13.2385 2.2857 12.0003 2.2857ZM12.0003 7.42855C13.1369 7.42855 14.227 7.88008 15.0307 8.68381C15.8345 9.48754 16.286 10.5776 16.286 11.7143C16.286 12.8509 15.8345 13.941 15.0307 14.7447C14.227 15.5485 13.1369 16 12.0003 16C10.8636 16 9.77355 15.5485 8.96982 14.7447C8.16609 13.941 7.71456 12.8509 7.71456 11.7143C7.71456 10.5776 8.16609 9.48754 8.96982 8.68381C9.77355 7.88008 10.8636 7.42855 12.0003 7.42855ZM12.0003 9.14284C11.3183 9.14284 10.6642 9.41376 10.182 9.89599C9.69977 10.3782 9.42885 11.0323 9.42885 11.7143C9.42885 12.3963 9.69977 13.0503 10.182 13.5325C10.6642 14.0148 11.3183 14.2857 12.0003 14.2857C12.6823 14.2857 13.3363 14.0148 13.8186 13.5325C14.3008 13.0503 14.5717 12.3963 14.5717 11.7143C14.5717 11.0323 14.3008 10.3782 13.8186 9.89599C13.3363 9.41376 12.6823 9.14284 12.0003 9.14284Z" fill="#6D7D36"/>
								</svg>

							</figure>

							<div>
								
								<h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Visit Us')?></h5>

								<a href="<?=$setting['map_url']?>" target="_blank" class="link d-inline-block"><?=$setting['address']?></a>

							</div>
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>



@endsection

