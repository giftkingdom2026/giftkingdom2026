<?php 

use App\Models\Web\Menus;

Route::current() == '' ? $hide = 'd-none' : $hide = '';?>

<footer class="footer <?=$hide?>">
    <div class="container">
        <div class="top-footer overflow-hidden">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-2">
                    <a href="<?=asset('')?>" class="d-inline-block logo"><img src="<?=asset($result['footer-image'])?>" alt="*" class="wow w-100"></a>
                </div>
                <div class="col-md-10 col-lg-7">
                    <div class="top-footer-info ps-md-5 ps-xxl-4 wow fadeInUp">
                        <!-- <h5>Our Info</h5> -->
                        <ul class="d-flex gap-4 flex-wrap justify-content-between">
                            <li><h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Phone')?></h5><a href="tel:<?=$result['phone']?>" class="link"><?=$result['phone']?></a></li>
                            <li><h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Email')?></h5><a href="mailto:<?=$result['email']?>" class="link"><?=$result['email']?></a></li>
                            <li><h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Location')?></h5><a href="<?=$result['map_url']?>" target="_blank" class="link"><?=$result['address']?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="social-icons wow fadeInUp">
                        <h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Follow Us')?></h5>
                        <ul class="d-flex gap-3 align-items-center">

                            <li>
                                <a target="_blank" href="<?=$result['facebook']?>">
                                    <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.1683 17.1431C3.1683 17.0774 3.15421 17.0117 3.15421 16.9329C3.15421 14.607 3.15421 12.268 3.15421 9.94215C3.15421 9.87644 3.15421 9.81074 3.15421 9.71876C2.25226 9.71876 1.37851 9.71876 0.476562 9.71876C0.476562 8.74636 0.476562 7.80025 0.476562 6.82785C1.36441 6.82785 2.23817 6.82785 3.15421 6.82785C3.15421 6.74901 3.15421 6.68331 3.15421 6.6176C3.15421 5.85545 3.14011 5.10645 3.1683 4.3443C3.21058 3.4376 3.49244 2.59661 4.18299 1.91331C4.70442 1.40083 5.36678 1.0986 6.09961 0.954051C6.70561 0.835787 7.3116 0.848927 7.9176 0.875208C8.41085 0.888349 8.9041 0.92777 9.39735 0.967192C9.43962 0.967192 9.46781 0.980332 9.52418 0.993473C9.52418 1.8476 9.52418 2.70174 9.52418 3.56901C9.46781 3.56901 9.41144 3.56901 9.34097 3.56901C8.73498 3.58215 8.12899 3.56901 7.52299 3.59529C6.80426 3.63471 6.39557 4.00265 6.36738 4.67281C6.3392 5.36926 6.35329 6.0657 6.35329 6.77529C6.35329 6.78843 6.36738 6.78843 6.36738 6.82785C7.36797 6.82785 8.38266 6.82785 9.41144 6.82785C9.27051 7.80025 9.14367 8.7595 9.01684 9.71876C8.12899 9.71876 7.25523 9.71876 6.36738 9.71876C6.36738 9.78446 6.35329 9.82388 6.35329 9.87644C6.35329 12.268 6.35329 14.6596 6.35329 17.038C6.35329 17.0774 6.35329 17.1169 6.36738 17.1431C5.29632 17.1431 4.23936 17.1431 3.1683 17.1431Z" fill="#6D7D36"/></svg>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?=$result['instagram']?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.1641 17.1431C9.5413 17.1431 7.91853 17.1431 6.30001 17.1431C6.22779 17.1346 6.15558 17.1261 6.07911 17.1176C5.59058 17.0623 5.09355 17.0453 4.61352 16.9433C2.85906 16.5819 1.70358 15.5443 1.22779 13.801C0.9899 12.925 0.96866 12.0193 0.960163 11.1179C0.951667 9.70189 0.951667 8.28593 0.955915 6.86996C0.960163 6.07906 0.9899 5.28817 1.14283 4.51002C1.36798 3.38321 1.90749 2.45199 2.85056 1.77164C3.6577 1.1891 4.57954 0.942477 5.55235 0.916964C7.26433 0.874443 8.97631 0.857434 10.6883 0.857434C11.6016 0.857434 12.5192 0.853182 13.4326 1.00201C15.3272 1.31667 16.5974 2.51152 17.0222 4.37821C17.1709 5.03304 17.1964 5.70062 17.2091 6.36821C17.2134 6.57231 17.2261 6.78067 17.2388 6.98477C17.2388 8.3412 17.2388 9.70189 17.2388 11.0583C17.2303 11.2497 17.2134 11.4368 17.2091 11.6281C17.1964 12.2957 17.1751 12.9633 17.0137 13.6181C16.5889 15.3572 15.5311 16.4713 13.7809 16.905C13.1182 17.0666 12.4427 17.0964 11.7631 17.1134C11.5676 17.1176 11.3637 17.1304 11.1641 17.1431ZM15.7435 8.74516C15.752 8.74516 15.7563 8.74516 15.7648 8.74516C15.7648 8.14561 15.7817 7.54605 15.7605 6.9465C15.7308 6.22789 15.718 5.50077 15.6076 4.79067C15.4292 3.63833 14.7537 2.86445 13.611 2.5668C13.1479 2.44774 12.6636 2.36269 12.1879 2.34143C11.0664 2.29466 9.94487 2.29466 8.81913 2.28615C8.00774 2.2819 7.19636 2.29041 6.38497 2.30741C5.79024 2.31592 5.19976 2.34568 4.61777 2.49451C3.6662 2.74539 3.00774 3.30667 2.69338 4.25915C2.45549 4.97776 2.40027 5.72614 2.39177 6.47451C2.37903 8.19238 2.37478 9.9145 2.39177 11.6324C2.39602 12.1511 2.44699 12.6741 2.54895 13.1801C2.80383 14.4515 3.56849 15.2552 4.85991 15.4848C5.39092 15.5783 5.93043 15.6336 6.46993 15.6421C8.01199 15.6676 9.55405 15.6804 11.0961 15.6634C11.8055 15.6549 12.5192 15.6166 13.2159 15.5103C14.4606 15.3275 15.2975 14.5366 15.5566 13.3332C15.6586 12.857 15.718 12.368 15.7265 11.8832C15.7605 10.8372 15.7435 9.79118 15.7435 8.74516Z" fill="#6D7D36"/><path d="M9.09545 4.8086C11.4022 4.80435 13.2628 6.66253 13.2756 8.97995C13.2883 11.2846 11.4234 13.1598 9.11244 13.1683C6.80148 13.1768 4.92383 11.3101 4.92383 8.99271C4.92808 6.67954 6.78449 4.81711 9.09545 4.8086ZM9.11244 6.27984C7.61287 6.27559 6.39792 7.47895 6.39367 8.9757C6.38942 10.481 7.58738 11.6928 9.08696 11.7013C10.595 11.7098 11.81 10.5022 11.8142 8.99271C11.81 7.4917 10.612 6.28409 9.11244 6.27984Z" fill="#6D7D36"/><path d="M13.4354 3.668C13.9749 3.66375 14.4082 4.08896 14.4125 4.62898C14.4167 5.17751 13.9876 5.61548 13.4481 5.61973C12.9129 5.62398 12.4711 5.19027 12.4668 4.65875C12.4626 4.11022 12.8916 3.67225 13.4354 3.668Z" fill="#6D7D36"/></svg>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?=$result['twitter']?>">
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.0488281 12.7108C1.8734 12.8781 3.48683 12.4294 4.95287 11.3035C3.42708 11.1607 2.41121 10.3734 1.83755 8.91714C2.34349 8.97833 2.81756 8.98649 3.32748 8.8478C2.52276 8.64384 1.88934 8.24407 1.40331 7.61587C0.917293 6.99175 0.678266 6.27381 0.678266 5.4702C0.921277 5.56402 1.14835 5.67008 1.3834 5.73943C1.62242 5.80878 1.86942 5.83325 2.11641 5.86588C0.666316 4.59317 0.327694 3.08793 1.14039 1.28084C2.96496 3.47954 5.24767 4.68291 8.02437 4.87463C8.01241 4.53606 7.98453 4.20972 7.9925 3.88746C8.03233 2.48013 9.08405 1.14214 10.4186 0.79541C11.6536 0.473152 12.7412 0.762777 13.6694 1.65613C13.7371 1.72139 13.7969 1.74995 13.8925 1.71731C14.2271 1.61126 14.5697 1.52967 14.8964 1.40321C15.2231 1.27676 15.5338 1.10951 15.8684 0.950421C15.7609 1.33387 15.5856 1.67652 15.3386 1.97023C15.0916 2.25985 14.8048 2.52092 14.5379 2.78607C15.1314 2.71672 15.721 2.52908 16.3345 2.27617C15.9083 2.92069 15.4302 3.45914 14.8526 3.89562C14.7052 4.00576 14.6693 4.12406 14.6733 4.30354C14.7052 5.87404 14.3665 7.36704 13.7013 8.77845C12.9005 10.4754 11.7412 11.846 10.1716 12.8414C9.05218 13.5511 7.83713 13.9713 6.53443 14.1467C5.39108 14.3017 4.2557 14.265 3.12829 14.0162C2.05267 13.7796 1.05274 13.3594 0.120536 12.7639C0.108584 12.7598 0.0966335 12.7475 0.0488281 12.7108Z" fill="#6D7D36" /></svg>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?=$result['youtube']?>">
                                    <svg width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.24607 0.572266C9.91808 0.639298 11.5901 0.700297 13.2614 0.778055C13.6564 0.79925 14.0496 0.847396 14.4384 0.922174C15.3816 1.09713 15.986 1.75472 16.1651 2.77897C16.41 4.18263 16.4589 5.6017 16.4127 7.02145C16.3801 8.01353 16.2876 9.00493 16.1938 9.99366C16.1254 10.7183 15.8395 11.3343 15.2168 11.7466C14.8377 11.9979 14.4104 12.0703 13.9792 12.1179C12.3014 12.3002 10.6163 12.3418 8.93194 12.3331C7.22541 12.3244 5.51823 12.2714 3.81235 12.2151C3.26489 12.1895 2.71927 12.132 2.17813 12.0428C1.24865 11.9027 0.614895 11.2458 0.422748 10.2591C0.2306 9.27239 0.185657 8.27428 0.15765 7.2755C0.112917 5.96061 0.167797 4.64413 0.321789 3.33802C0.356498 3.04448 0.408924 2.75344 0.478763 2.4666C0.698919 1.58647 1.39521 0.99591 2.31817 0.876592C3.90941 0.671473 5.50976 0.654045 7.10882 0.626562C7.48725 0.619859 7.86634 0.626562 8.24477 0.626562L8.24607 0.572266ZM6.67567 3.97416V8.98415L10.9016 6.47916L6.67567 3.97416Z" fill="#6D7D36"/></svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mid-footer overflow-hidden">
            <div class="row wow fadeInUp gy-md-0 gy-4 justify-content-between">
                <div class="col col-sm-4 col-lg-2">
                    <div class="mid-footer-list">
                        <h5><?=App\Http\Controllers\Web\IndexController::trans_labels('About Us')?></h5>
                        <ul>

                            <?php

                            $menu = Menus::getMenu('get-to-know-us');

                            foreach($menu as $item) :

                                $url = $item['type'] == 1 ? $item['link'] : ''; 

                                $url == '' && $item['link'] != 'javascript:;' ? $url = asset($item['link']) : $url = $item['link'];  

                                $item['type'] == 2 ? $url =  asset('shop/category/'.$item['link']) : ''; ?>
@if(isset($item['menu_title']))
                                <li>

                                    <a href="<?=$url?>" class="link"><?=$item['menu_title']?></a>

                                </li>
                           @endif     
                            <?php endforeach;?>

                        </ul>
                    </div>
                </div>

                <div class="col-sm-4 col-lg-2">
                    <div class="mid-footer-list ps-md-0 ps-xl-3">
                        <h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Help & Support')?></h5>
                        <ul>

                           <?php

                           $menu = Menus::getMenu('quick-links');

                           foreach($menu as $item) :

                            $url = $item['type'] == 1 ? $item['link'] : ''; 

                            $url == '' && $item['link'] != 'javascript:;' ? $url = asset($item['link']) : $url = $item['link'];  

                            $item['type'] == 2 ? $url =  asset('shop/category/'.$item['link']) : '';   ?>
@if($item['menu_title'])
                            <li>

                                <a href="<?=$url?>" class="link"><?=$item['menu_title']?></a>

                            </li>
                     @endif       
                        <?php endforeach;?>

                        <?php 

                        $attr = !Auth::check() ? 'data-bs-toggle="modal" data-bs-target="#signin"' : ''; 

                        $url = !Auth::check() ? 'javascript:;' : $url=asset('account/'.Auth::user()->user_name); ?>
<!-- 
                            <li>
                                <a href="<?=$url?>" <?=$attr?> class="link">My Account</a>
                            </li>
                            
                            <li><a href="<?=asset('cart')?>" class="link">My Cart</a></li>
                            <li><a href="<?=asset('wishlist')?>" class="link">My Wishlist</a></li> -->

                            <?php

                            $url = !Auth::check() ? 'javascript:;' : $url=asset('account/orders'); ?>
                            <!-- <li>
                                <a href="javascript:;" <?=$attr?> class="link">Order History</a>
                            </li> -->

                        </ul>
                    </div>
                </div>

                <div class="col col-sm-4 col-lg-2">
                    <div class="mid-footer-list">
                        <h5><?=App\Http\Controllers\Web\IndexController::trans_labels('Legal & Policies')?></h5>
                        <ul>

                            <?php

                            $menu = Menus::getMenu('our-legal');

                            foreach($menu as $item) :

                                $url = $item['type'] == 1 ? $item['link'] : ''; 

                                $url == '' && $item['link'] != 'javascript:;' ? $url = asset($item['link']) : $url = $item['link'];  

                                $item['type'] == 2 ? $url =  asset('shop/category/'.$item['link']) : '';  ?>
@if(isset($item['menu_title']))
                                <li>

                                    <a href="<?=$url?>" class="link"><?=$item['menu_title']?></a>

                                </li>
                           @endif     
                            <?php endforeach;?>

                        </ul>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div class="ps-xxl-5 ms-lg-3 d-flex flex-column h-100">
                        <div class="mid-footer-list-form">
                            <h5><?=App\Http\Controllers\Web\IndexController::trans_labels($result['newsletter_heading'])?></h5>
                            <form class="footer-form d-flex align-items-end gap-3 flex-wrap">
                                <input type="email" class="form-control" placeholder="<?=App\Http\Controllers\Web\IndexController::trans_labels('Enter your email')?>">
                                <button type="submit" class="btn"><?=App\Http\Controllers\Web\IndexController::trans_labels($result['newsletter_button'])?></button>
                            </form>

                            <div class="d-flex align-items-center gap-2 mt-3">
                                <input type="radio" id="footer-form-term">
                                <label for="footer-form-term" class="footer-form-term-label fw-normal"><?=App\Http\Controllers\Web\IndexController::trans_labels($result['newsletter_text_two'])?></label>
                            </div>
                        </div>

                     <div class="mid-footer-logos d-flex align-items-center justify-content-between">
    <img src="{{ asset($result['footer_brand_image_one']) }}" alt="Footer Image 1">
    <img src="{{ asset($result['footer_brand_image_two']) }}" alt="Footer Image 2">
    <img src="{{ asset($result['footer_brand_image_three']) }}" alt="Footer Image 3">
    <img src="{{ asset($result['footer_brand_image_four']) }}" alt="Footer Image 4">
    <img src="{{ asset($result['footer_brand_image_five']) }}" alt="Footer Image 5">
    <img src="{{ asset($result['footer_brand_image_six']) }}" alt="Footer Image 6">
</div>

                    </div>
                </div>

            </div>
        </div>
        <div class="bottom-footer py-2 wow fadeInDown">
            <div class="row justify-content-between align-items-center gy-lg-0 gy-2">
                <div class="col-sm-6 col-lg-4">
                    <p><?=App\Http\Controllers\Web\IndexController::trans_labels('Designed by DigitalsetGo')?></p>
                </div>
                <div class="col-sm-6 col-lg-4 text-center">
                    {!! $result['copyright_footer_text'] !!}
                </div>
                <div class="ft-payment-cards col-md-12 col-lg-4 gap-3 d-flex align-items-center justify-content-end">
                    <img src="{{ asset($result['payment_image_one']) }}" alt="*">
                    <img src="{{ asset($result['payment_image_two']) }}" alt="*">
                    <img src="{{ asset($result['payment_image_three']) }}" alt="*">
                    <img src="{{ asset($result['payment_image_four']) }}" alt="*">
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript"  src="<?=asset('')?>/assets/js/xJquery.js"></script>
<script>
    const authUser = {
        isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
        user: {!! Auth::check() ? json_encode(Auth::user()) : 'null' !!}
    };
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/643e42904247f20fefec40c3/1gu9j81t9';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php

$check = !request()->is('/');

if($check) : ?>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<?php endif; ?>

<style type="text/css">
    .select2-container{z-index:99999;width: 100% !important}
    .device-details ul li {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    a.link.active {}

.header .link.active::before {width: 100%;background: #6D7D36;}

a.link.active {
  color: #6D7D36;
}
    address{text-transform: capitalize;}
</style>
@include('web.common.scripts')
