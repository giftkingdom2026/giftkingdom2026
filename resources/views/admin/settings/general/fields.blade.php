<div class="row">
    <div class="col-md-2">
        <div class="form-group">

            <label for="header-logo" class="control-label mb-1">

                Header Logo

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['header-logo']) ?

                    $headerimgid = $result['commonContent']['setting']['header-logo']['id'] :

                    $headerimgid = '';

                isset($result['commonContent']['setting']['header-logo']) ?

                    $headerimgpath = $result['commonContent']['setting']['header-logo']['path'] :

                    $headerimgpath = ''; ?>

                <input type="hidden" name="header-logo" value="{{$headerimgid}}"

                    id="header-logo">

                <img src="{{asset($headerimgpath)}}" class="w-100">

            </div>

        </div>

        <div class="form-group mt-3">

            <label for="footer-image" class="control-label mb-1">

                Footer Logo

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['footer-image']) ?

                    $footerimgid = $result['commonContent']['setting']['footer-image']['id'] :

                    $footerimgid = '';

                isset($result['commonContent']['setting']['footer-image']) ?

                    $footerimgpath = $result['commonContent']['setting']['footer-image']['path'] :

                    $footerimgpath = ''; ?>

                <input type="hidden" name="footer-image" value="{{$footerimgid}}"

                    id="footer-image">

                <img src="{{asset($footerimgpath)}}" class="w-100">

            </div>

        </div>

        <div class="form-group mt-3">

            <label for="favicon-image" class="control-label mb-1">

                Favicon

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['favicon-image']) ?

                    $faviconimgid = $result['commonContent']['setting']['favicon-image']['id'] :

                    $faviconimgid = '';

                isset($result['commonContent']['setting']['favicon-image']) ?

                    $faviconimgpath = $result['commonContent']['setting']['favicon-image']['path'] :

                    $faviconimgpath = ''; ?>

                <input type="hidden" name="favicon-image" value="{{$faviconimgid}}"

                    id="favicon-image">

                <img src="{{asset($faviconimgpath)}}" class="w-100">

            </div>

        </div>

        <div class="form-group mt-3">

            <label for="email-logo-image" class="control-label mb-1">

                Email Logo

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['email-logo-image']) ?

                    $emlogoimgid = $result['commonContent']['setting']['email-logo-image']['id'] :

                    $emlogoimgid = '';

                isset($result['commonContent']['setting']['email-logo-image']) ?

                    $emlogoimgpath = $result['commonContent']['setting']['email-logo-image']['path'] :

                    $emlogoimgpath = ''; ?>

                <input type="hidden" name="email-logo-image" value="{{$emlogoimgid}}"

                    id="email-logo-image">

                <img src="{{asset($emlogoimgpath)}}" class="w-100">

            </div>

        </div>

    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="site-name" class="control-label mb-1">Site Name </label>

                    <?php $sitename = isset($result['commonContent']['setting']['site-name']) ? $result['commonContent']['setting']['site-name'] : ''; ?>

                    <input type="text" name="site-name" class="form-control" id="site-name" value="<?= $sitename ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="phone" class="control-label mb-1">

                        Phone Numbers

                    </label>

                    <?php $phone = isset($result['commonContent']['setting']['phone']) ? $result['commonContent']['setting']['phone'] : ''; ?>

                    <input type="text" name="phone" class="form-control" id="phone" value="<?= $phone ?>">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="email" class="control-label mb-1">

                        Email

                    </label>

                    <?php $email = isset($result['commonContent']['setting']['email']) ? $result['commonContent']['setting']['email'] : ''; ?>

                    <input type="email" name="email" class="form-control" id="email" value="<?= $email ?>">

                </div>
            </div>
            <div class="col-md-6 d-none">
                <div class="form-group mb-3">

                    <label for="general_queries" class="control-label mb-1">

                        General Queries

                    </label>
                    <?php

                    isset($result['commonContent']['setting']['general_queries']) ?

                        $general_queries = $result['commonContent']['setting']['general_queries'] :

                        $general_queries = ''; ?>

                    <input type="email" name="general_queries" class="form-control"

                        id="general_queries"

                        value="<?= $general_queries ?>">

                </div>
            </div>

            <!-- <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="sellers_request" class="control-label mb-1">

                        Sellers Request

                    </label>
                    <?php

                    isset($result['commonContent']['setting']['sellers_request']) ?

                        $sellers_request = $result['commonContent']['setting']['sellers_request'] :

                        $sellers_request = ''; ?>

                    <input type="email" name="sellers_request" class="form-control" 

                    id="sellers_request"

                    value="<?= $sellers_request ?>">

                </div>
            </div> -->

            <div class="col-md-6 d-none">
                <div class="form-group mb-3">

                    <label for="customer_care" class="control-label mb-1">

                        Customer Care

                    </label>
                    <?php

                    isset($result['commonContent']['setting']['customer_care']) ?

                        $customer_care = $result['commonContent']['setting']['customer_care'] :

                        $customer_care = ''; ?>

                    <input type="email" name="customer_care" class="form-control"

                        id="customer_care"

                        value="<?= $customer_care ?>">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="address" class="control-label mb-1">

                        Address

                    </label>

                    <?php $address = isset($result['commonContent']['setting']['address']) ? $result['commonContent']['setting']['address'] : ''; ?>

                    <input type="address" name="address" class="form-control" id="address" value="<?= $address ?>">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="map_url" class="control-label mb-1">

                        Map Url (Google Maps Link For Address)

                    </label>

                    <?php $map_url = isset($result['commonContent']['setting']['map_url']) ? $result['commonContent']['setting']['map_url'] : ''; ?>

                    <input type="map_url" name="map_url" class="form-control" id="map_url" value="<?= $map_url ?>">

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="map_iframe" class="control-label mb-1">

                        Map Iframe

                    </label>

                    <?php

                    isset($result['commonContent']['setting']['map_iframe']) ?

                        $map_iframe = $result['commonContent']['setting']['map_iframe'] :

                        $map_iframe = ''; ?>


                    <input type="map_iframe" name="map_iframe" class="form-control"

                        id="map_iframe" value="{{$map_iframe}}">

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="footer_text" class="control-label mb-1">
                        LinkedIn
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['LinkedIn']) ?

                        $LinkedIn = $result['commonContent']['setting']['LinkedIn'] :

                        $LinkedIn = ''; ?>

                    <input type="text" name="LinkedIn" class="form-control"
                        id="LinkedIn" value="{{$LinkedIn}}">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="facebook" class="control-label mb-1">
                        Facebook
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['facebook']) ?

                        $facebook = $result['commonContent']['setting']['facebook'] :

                        $facebook = ''; ?>

                    <input type="facebook" name="facebook" class="form-control"
                        id="facebook"

                        value="<?= $facebook ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="instagram" class="control-label mb-1">
                        Instagram
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['instagram']) ?

                        $instagram = $result['commonContent']['setting']['instagram'] :

                        $instagram = ''; ?>

                    <input type="instagram" name="instagram" class="form-control"
                        id="instagram"

                        value="<?= $instagram ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="whatsapp" class="control-label mb-1">
                        Youtube
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['youtube']) ?

                        $youtube = $result['commonContent']['setting']['youtube'] :

                        $youtube = ''; ?>

                    <input type="text" name="youtube" class="form-control"
                        id="youtube" value="{{$youtube}}">

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="whatsapp" class="control-label mb-1">
                        Twitter
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['twitter']) ?

                        $twitter = $result['commonContent']['setting']['twitter'] :

                        $twitter = ''; ?>

                    <input type="text" name="twitter" class="form-control"
                        id="twitter" value="{{$twitter}}">

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="copyright_footer_text" class="control-label mb-1 ">
                        Footer Copy Right Text
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['copyright_footer_text']) ?

                        $copyright_footer_text = $result['commonContent']['setting']['copyright_footer_text'] :

                        $copyright_footer_text = ''; ?>

                    <textarea type="text" class="form-control quilleditor" name="copyright_footer_text"><?= $copyright_footer_text ?></textarea>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="whatsapp" class="control-label mb-1">
                        Header Top Text
                    </label>

                    <?php

                    isset($result['commonContent']['setting']['header_top']) ?

                        $header_top = $result['commonContent']['setting']['header_top'] :

                        $header_top = ''; ?>

                    <input type="text" class="form-control" name="header_top" value="<?= $header_top ?>">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="newsletter_heading" class="control-label mb-1">

                        Newsletter Heading

                    </label>

                    <?php

                    isset($result['commonContent']['setting']['newsletter_heading']) ?

                        $newsletter_heading = $result['commonContent']['setting']['newsletter_heading'] :

                        $newsletter_heading = ''; ?>


                    <input type="newsletter_heading" name="newsletter_heading" class="form-control"

                        id="newsletter_heading" value="{{$newsletter_heading}}">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="newsletter_button" class="control-label mb-1">

                        Newsletter Button

                    </label>

                    <?php

                    isset($result['commonContent']['setting']['newsletter_button']) ?

                        $newsletter_button = $result['commonContent']['setting']['newsletter_button'] :

                        $newsletter_button = ''; ?>


                    <input type="newsletter_button" name="newsletter_button" class="form-control"

                        id="newsletter_button" value="{{$newsletter_button}}">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <label for="newsletter_text_two" class="control-label mb-1">

                        Newsletter Text Two

                    </label>

                    <?php

                    isset($result['commonContent']['setting']['newsletter_text_two']) ?

                        $newsletter_text_two = $result['commonContent']['setting']['newsletter_text_two'] :

                        $newsletter_text_two = ''; ?>


                    <input type="newsletter_text_two" name="newsletter_text_two" class="form-control"

                        id="newsletter_text_two" value="{{$newsletter_text_two}}">

                </div>
            </div>
                      <div class="col-md-12">
                <div class="form-group mb-3">

                    <label for="admin_commission" class="control-label mb-1">

                        Set Your Comission Rate

                    </label>

                    <?php

                    isset($result['commonContent']['setting']['admin_commission']) ?

                        $admin_commission = $result['commonContent']['setting']['admin_commission'] :

                        $admin_commission = ''; ?>


                    <input type="number" name="admin_commission" class="form-control"

                        id="admin_commission" value="{{$admin_commission}}">

                </div>
            </div>
  <div class="col-md-2">
    <div class="form-group mt-3">
        <label for="footer_brand_image_one" class="control-label mb-1">
            Image One
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="footer_brand_image_one">+</button>
            <?php
            isset($result['commonContent']['setting']['footer_brand_image_one']) ?
                $footer_brand_image_oneid = $result['commonContent']['setting']['footer_brand_image_one']['id'] :
                $footer_brand_image_oneid = '';
            isset($result['commonContent']['setting']['footer_brand_image_one']) ?
                $footer_brand_image_onepath = $result['commonContent']['setting']['footer_brand_image_one']['path'] :
                $footer_brand_image_onepath = '';
            ?>
            <input type="hidden" name="footer_brand_image_one" value="{{$footer_brand_image_oneid}}" id="footer_brand_image_one">
            <img src="{{asset($footer_brand_image_onepath)}}" class="w-100">
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group mt-3">
        <label for="footer_brand_image_two" class="control-label mb-1">
            Image Two
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="footer_brand_image_two">+</button>
            <?php
            isset($result['commonContent']['setting']['footer_brand_image_two']) ?
                $footer_brand_image_twoid = $result['commonContent']['setting']['footer_brand_image_two']['id'] :
                $footer_brand_image_twoid = '';
            isset($result['commonContent']['setting']['footer_brand_image_two']) ?
                $footer_brand_image_twopath = $result['commonContent']['setting']['footer_brand_image_two']['path'] :
                $footer_brand_image_twopath = '';
            ?>
            <input type="hidden" name="footer_brand_image_two" value="{{$footer_brand_image_twoid}}" id="footer_brand_image_two">
            <img src="{{asset($footer_brand_image_twopath)}}" class="w-100">
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group mt-3">
        <label for="footer_brand_image_three" class="control-label mb-1">
            Image Three
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="footer_brand_image_three">+</button>
            <?php
            isset($result['commonContent']['setting']['footer_brand_image_three']) ?
                $footer_brand_image_threeid = $result['commonContent']['setting']['footer_brand_image_three']['id'] :
                $footer_brand_image_threeid = '';
            isset($result['commonContent']['setting']['footer_brand_image_three']) ?
                $footer_brand_image_threepath = $result['commonContent']['setting']['footer_brand_image_three']['path'] :
                $footer_brand_image_threepath = '';
            ?>
            <input type="hidden" name="footer_brand_image_three" value="{{$footer_brand_image_threeid}}" id="footer_brand_image_three">
            <img src="{{asset($footer_brand_image_threepath)}}" class="w-100">
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group mt-3">
        <label for="footer_brand_image_four" class="control-label mb-1">
            Image Four
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="footer_brand_image_four">+</button>
            <?php
            isset($result['commonContent']['setting']['footer_brand_image_four']) ?
                $footer_brand_image_fourid = $result['commonContent']['setting']['footer_brand_image_four']['id'] :
                $footer_brand_image_fourid = '';
            isset($result['commonContent']['setting']['footer_brand_image_four']) ?
                $footer_brand_image_fourpath = $result['commonContent']['setting']['footer_brand_image_four']['path'] :
                $footer_brand_image_fourpath = '';
            ?>
            <input type="hidden" name="footer_brand_image_four" value="{{$footer_brand_image_fourid}}" id="footer_brand_image_four">
            <img src="{{asset($footer_brand_image_fourpath)}}" class="w-100">
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group mt-3">
        <label for="footer_brand_image_five" class="control-label mb-1">
            Image Five
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="footer_brand_image_five">+</button>
            <?php
            isset($result['commonContent']['setting']['footer_brand_image_five']) ?
                $footer_brand_image_fiveid = $result['commonContent']['setting']['footer_brand_image_five']['id'] :
                $footer_brand_image_fiveid = '';
            isset($result['commonContent']['setting']['footer_brand_image_five']) ?
                $footer_brand_image_fivepath = $result['commonContent']['setting']['footer_brand_image_five']['path'] :
                $footer_brand_image_fivepath = '';
            ?>
            <input type="hidden" name="footer_brand_image_five" value="{{$footer_brand_image_fiveid}}" id="footer_brand_image_five">
            <img src="{{asset($footer_brand_image_fivepath)}}" class="w-100">
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group mt-3">
        <label for="footer_brand_image_six" class="control-label mb-1">
            Image Six
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="footer_brand_image_six">+</button>
            <?php
            isset($result['commonContent']['setting']['footer_brand_image_six']) ?
                $footer_brand_image_sixid = $result['commonContent']['setting']['footer_brand_image_six']['id'] :
                $footer_brand_image_sixid = '';
            isset($result['commonContent']['setting']['footer_brand_image_six']) ?
                $footer_brand_image_sixpath = $result['commonContent']['setting']['footer_brand_image_six']['path'] :
                $footer_brand_image_sixpath = '';
            ?>
            <input type="hidden" name="footer_brand_image_six" value="{{$footer_brand_image_sixid}}" id="footer_brand_image_six">
            <img src="{{asset($footer_brand_image_sixpath)}}" class="w-100">
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group mt-3">
        <label for="payment_image_one" class="control-label mb-1">
            Payment Image One
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="payment_image_one">+</button>
            <?php
            isset($result['commonContent']['setting']['payment_image_one']) ?
                $payment_image_oneid = $result['commonContent']['setting']['payment_image_one']['id'] :
                $payment_image_oneid = '';
            isset($result['commonContent']['setting']['payment_image_one']) ?
                $payment_image_onepath = $result['commonContent']['setting']['payment_image_one']['path'] :
                $payment_image_onepath = '';
            ?>
            <input type="hidden" name="payment_image_one" value="{{$payment_image_oneid}}" id="payment_image_one">
            <img src="{{asset($payment_image_onepath)}}" class="w-100">
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group mt-3">
        <label for="payment_image_two" class="control-label mb-1">
            Payment Image Two
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="payment_image_two">+</button>
            <?php
            isset($result['commonContent']['setting']['payment_image_two']) ?
                $payment_image_twoid = $result['commonContent']['setting']['payment_image_two']['id'] :
                $payment_image_twoid = '';
            isset($result['commonContent']['setting']['payment_image_two']) ?
                $payment_image_twopath = $result['commonContent']['setting']['payment_image_two']['path'] :
                $payment_image_twopath = '';
            ?>
            <input type="hidden" name="payment_image_two" value="{{$payment_image_twoid}}" id="payment_image_two">
            <img src="{{asset($payment_image_twopath)}}" class="w-100">
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group mt-3">
        <label for="payment_image_three" class="control-label mb-1">
            Payment Image Three
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="payment_image_three">+</button>
            <?php
            isset($result['commonContent']['setting']['payment_image_three']) ?
                $payment_image_threeid = $result['commonContent']['setting']['payment_image_three']['id'] :
                $payment_image_threeid = '';
            isset($result['commonContent']['setting']['payment_image_three']) ?
                $payment_image_threepath = $result['commonContent']['setting']['payment_image_three']['path'] :
                $payment_image_threepath = '';
            ?>
            <input type="hidden" name="payment_image_three" value="{{$payment_image_threeid}}" id="payment_image_three">
            <img src="{{asset($payment_image_threepath)}}" class="w-100">
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group mt-3">
        <label for="payment_image_four" class="control-label mb-1">
            Payment Image Four
        </label>
        <div class="featuredWrap featured">
            <button class="btn uploader featured_image btn-primary" data-type="single" data-target="payment_image_four">+</button>
            <?php
            isset($result['commonContent']['setting']['payment_image_four']) ?
                $payment_image_fourid = $result['commonContent']['setting']['payment_image_four']['id'] :
                $payment_image_fourid = '';
            isset($result['commonContent']['setting']['payment_image_four']) ?
                $payment_image_fourpath = $result['commonContent']['setting']['payment_image_four']['path'] :
                $payment_image_fourpath = '';
            ?>
            <input type="hidden" name="payment_image_four" value="{{$payment_image_fourid}}" id="payment_image_four">
            <img src="{{asset($payment_image_fourpath)}}" class="w-100">
        </div>
    </div>
</div>
            </div>

        </div>

    </div>