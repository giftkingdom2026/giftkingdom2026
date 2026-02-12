@extends('web.layout')



@section('content')
<section class="main-section account-section">

    <div class="container">

        <div class="row gy-4 gy-md-0">

            <div class="col-md-4 col-lg-3">

                @include('web.account.sidebar')

            </div>

            <div class="col-md-8 col-lg-9">

                <div class="acc-right profile-main">

                    <div class="row">

                        <div class="col-md-9">

                            <div class="main-heading">

                                <h2 class="mb-4">{{$data['content']['pagetitle']}}</h2>

                                <div class="breadcrumb">

                                    <ul class="d-inline-flex align-items-center gap-2">

                                        <li><a href="<?= asset('') ?>"><?=App\Http\Controllers\Web\IndexController::trans_labels('Home')?></a></li>

                                        <li>></li>

                                        <li><a href="javascript:;">{{$data['content']['pagetitle']}}</a></li>

                                    </ul>

                                </div>

                            </div>

                        </div>



                    </div>
                    <div class="wallet mb-4">
@php
    $symbol = Session::get('symbol_right').''.Session::get('symbol_left');

@endphp
                        <strong><?=App\Http\Controllers\Web\IndexController::trans_labels('Wallet Balance')?>: </strong><strong class="fw-normal"> {{ $symbol }} <?= number_format($credit * session('currency_value'), 2) ?></strong>

                    </div>

                    @if (session()->has('message'))
                    <?php $c = str_contains(session()->get('message'), 'Donot') ? 'alert-danger' : 'alert-success'; ?>

                    <div class="alert <?= $c ?> msg_alert">

                        {{ session()->get('message') }}

                    </div>
                    @endif



                    <form class="careerFilter validate profile" action="<?= asset('/auth/profile') ?>"
                        method="POST" id="form">

                        @csrf
                        <div class="formWrap">

                            <div class="row gy-4">

                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group clear-text">

                                        <label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('First Name')?>*</label>

                                        <input type="text" name="first_name" required
                                            value="<?= $result['first_name'] ?>" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('First Name')?>"
                                            class="form-control">

                                        <span class="clear d-none"><img src="<?= asset('') ?>/assets/images/cross.svg"
                                                alt="*"></span>

                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group clear-text">

                                        <label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Last Name')?>*</label>

                                        <input type="text" name="last_name" required value="<?= $result['last_name'] ?>"
                                            placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Last Name')?>" class="form-control">

                                        <span class="clear d-none"><img src="<?= asset('') ?>/assets/images/cross.svg"
                                                alt="*"></span>

                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group">

                                        <label class="mb-2 d-flex align-items-center justify-content-between"><?=App\Http\Controllers\Web\IndexController::trans_labels('Email Address')?>*</label>

                                        <input type="email" readonly required name="email"
                                            value="<?= $result['email'] ?>" placeholder="example@gmail.com"
                                            class="form-control">

                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group">

                                        <label class="mb-2 d-flex align-items-center justify-content-between"><?=App\Http\Controllers\Web\IndexController::trans_labels('Mobile')?>*

                                            <!-- <a href="javascript:;" class="addphone">Add</a> -->

                                        </label>

                                        <div class="phone-wrapper">
                                            <input type="phone" maxlength="9" name="phone" required
                                                value="<?= $result['phone'] ?>" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter your number')?>"
                                                class="form-control">
                                            <div class="invalid"><svg width="20" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#ff0000"
                                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                                </svg></div>
                                            <div class="valid"><svg width="20" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#04ff00"
                                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                                </svg></div>
                                        </div>


                                    </div>

                                </div>
                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group">

                                        <label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Birthday')?></label>

                                        <input name="dob" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter your birthday')?>"
    value="{{ $result['dob'] }}" class="bday form-control" type="text" required>

                                    </div>

                                </div>

                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group ct-slct">

                                        <label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Gender')?></label>

                                        <div class="child_option position-relative">

                                            <button id="hotel"
                                                class="form-control open-menu2 text-start d-flex align-items-center justify-content-between"
                                                type="button"><?= $result['gender'] != '' ? $result['gender'] : 'Select' ?><svg
                                                    width="12" height="8" viewBox="0 0 12 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2"
                                                        stroke-linecap="round" />
                                                </svg></button>

                                            <div class="dropdown-menu2 dropdown-menu-right">

                                                <ul class="careerFilterInr">

                                                    <li><a href="javascript:;" class="dropdown_select"
                                                            value="Male"><?=App\Http\Controllers\Web\IndexController::trans_labels('Male')?></a></li>

                                                    <li><a href="javascript:;" class="dropdown_select"
                                                            value="Female"><?=App\Http\Controllers\Web\IndexController::trans_labels('Female')?></a></li>

                                                </ul>

                                            </div>

                                            <input type="hidden" class="inputhide" name="gender"
                                                value="<?= $result['gender'] ?>" required>

                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group clear-text">

                                        <label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Emirate of Residence')?></label>

                                        <input type="text" name="emirate_of_residence"
                                            value="<?= $result['emirate_of_residence'] ?>"
                                            placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Emirate of Residence')?>" class="form-control">

                                        <span class="clear d-none"><img src="<?= asset('') ?>/assets/images/cross.svg"
                                                alt="*"></span>

                                    </div>

                                </div>
                                <div class="col-sm-6 col-lg-4">

                                    <div class="form-group clear-text">

                                        <label class="mb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Nationality')?></label>

                                        <input type="text" name="nationality"
                                            value="<?= $result['nationality'] ?>" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Nationality')?>"
                                            class="form-control">

                                        <span class="clear d-none"><img src="<?= asset('') ?>/assets/images/cross.svg"
                                                alt="*"></span>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6 col-lg-4">

                                <button href="javascript:;" type="submit" class="btn w-100"><?=App\Http\Controllers\Web\IndexController::trans_labels('Save Changes')?>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z"
                                            fill="#6D7D36"></path>
                                    </svg>
                                </button>

                            </div>
                        </div>

                    </form>

                    <!-- <div class="row mt-4 mt-lg-5">

                               

                                	<div class="col-sm-6 col-lg-4">

            <button href="javascript:;" type="button" id="changepass" class="btn w-100 mt-4 mt-sm-0">Change Password <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path></svg>
            </button>

           </div>

                            </div> -->



                    <!--  $attr = session()->has('password') ? '' : 'style="display:none;"';?> -->
                    <h3 class="mt-5 mb-4 pb-2"><?=App\Http\Controllers\Web\IndexController::trans_labels('Security Information')?></h3>
                    <form class="password-el change-pass-form" action="<?= asset('/update/password') ?>"
                        method="POST">

                        @csrf
                        <div class="formWrap">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group clear-text position-relative mb-4 mt-4 mt-lg-0">

                                        <label class="mb-2 text-capitalize"><?=App\Http\Controllers\Web\IndexController::trans_labels('current Password')?>*</label>

                                        <input type="password" required name="old_pass" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('current Password')?>"
                                            class="password form-control">
                                    <a href="javascript:;" class="eye-open"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#2d3c0a" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg></a>
                                    <a href="javascript:;" class="eye-close" style="display:none"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#2d3c0a" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg></a>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group clear-text position-relative">

                                        <label class="mb-2 text-capitalize"><?=App\Http\Controllers\Web\IndexController::trans_labels('new Password')?>*</label>

                                        <input type="password" required name="password" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('new Password')?>"
                                            class="password form-control">
                                    <a href="javascript:;" class="eye-open"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#2d3c0a" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg></a>
                                    <a href="javascript:;" class="eye-close" style="display:none"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#2d3c0a" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg></a>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group clear-text position-relative">
                                        <label class="mt-3 mt-lg-0 mb-2 text-capitalize"><?=App\Http\Controllers\Web\IndexController::trans_labels('re-enter Password')?>*</label>

                                        <input type="password" required name="confirmpassword"
                                            placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('re-enter Password')?>" class="password form-control">
                                                                                <a href="javascript:;" class="eye-open"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#2d3c0a" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg></a>
                                    <a href="javascript:;" class="eye-close" style="display:none"><svg width="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#2d3c0a" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path></svg></a>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6 col-lg-4">

                                <button href="javascript:;" type="submit" class="btn w-100"><?=App\Http\Controllers\Web\IndexController::trans_labels('Save Password')?>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z"
                                            fill="#6D7D36"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </form>


                    <!-- <div class="row mt-3 mt-lg-4">

                                

                                	<div class="col-sm-6 col-md-6">

            <button href="javascript:;" type="button" id="editprofile" class="btn trans-btn w-100 mt-3 mt-sm-0">Cancel Changes
             <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z" fill="#6D7D36"></path></svg>
            </button>

           </div>

                            </div> -->


                </div>

            </div>

        </div>

    </div>

</section>

@endsection