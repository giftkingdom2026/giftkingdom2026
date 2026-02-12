
<h3 class="box-title">SEO</h3>

<div class="row">
    <div class="col-md-6">

        <?php

        $home_title = isset($result['commonContent']['setting']['home_title']) ?

        $result['commonContent']['setting']['home_title'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_title" class="control-label mb-1">Title</label>

            <input type="text" name="home_title" class="form-control" id="home_title" value="<?=$home_title?>">

        </div>

    </div>
    <div class="col-md-6">

        <?php

        $home_meta_title = isset($result['commonContent']['setting']['home_meta_title']) ?

        $result['commonContent']['setting']['home_meta_title'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_meta_title" class="control-label mb-1">Meta Title</label>

            <input type="text" name="home_meta_title" class="form-control" id="home_meta_title" value="<?=$home_meta_title?>">

        </div>

    </div>

    <div class="col-md-6">

        <?php

        $home_meta_keywords = isset($result['commonContent']['setting']['home_meta_keywords']) ?

        $result['commonContent']['setting']['home_meta_keywords'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_meta_keywords" class="control-label mb-1">Meta Keywords</label>

            <input type="text" name="home_meta_keywords" class="form-control" id="home_meta_keywords" value="<?=$home_meta_keywords?>">

        </div>

    </div>

    <div class="col-md-12">

        <?php

        $home_meta_desc = isset($result['commonContent']['setting']['home_meta_desc']) ?

        $result['commonContent']['setting']['home_meta_desc'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_meta_desc" class="control-label mb-1">Meta Description</label>

            <textarea name="home_meta_desc" class="form-control" rows="3"><?=$home_meta_desc?></textarea>

        </div>

    </div>

</div>

<h3 class="box-title mt-3">Section One</h3>

<div class="row mt-3">

    <div class="col-md-12">

        <?php

        $home_s1_h = isset($result['commonContent']['setting']['home_s1_h']) ?

        $result['commonContent']['setting']['home_s1_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s1_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s1_h" class="form-control" id="home_s1_h" value="<?=$home_s1_h?>">

        </div>

    </div>

    <div class="col-md-12">

        <div class="form-group mb-3">

            <label for="home_s1_categories" class="control-label mb-1">Categories</label>

            <select name="home_s1_categories[]" multiple class="form-control select2" id="home_s1_categories">

                <?php

                $home_s1_categories = isset($result['commonContent']['setting']['home_s1_categories']) ?

                $result['commonContent']['setting']['home_s1_categories'] : '';

                $home_s1_categories = $home_s1_categories != '' ? unserialize($home_s1_categories) : [];

                foreach($result['categories'] as $cat) : 

                    $attr = in_array($cat['category_ID'], $home_s1_categories) ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                <?php endforeach;?>

            </select>

        </div>

    </div>

</div>

<h3 class="box-title mt-3">Section Two</h3>

<div class="row">

    <div class="col-md-6">

        <?php

        $home_s2_h = isset($result['commonContent']['setting']['home_s2_h']) ?

        $result['commonContent']['setting']['home_s2_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s2_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s2_h" class="form-control" id="home_s2_h" value="<?=$home_s2_h?>">

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group mb-3">

            <label for="home_s2_cat" class="control-label mb-1">Category</label>

            <select name="home_s2_cat" class="form-control select2" id="home_s2_cat">

                <?php

                $home_s2_cat = isset($result['commonContent']['setting']['home_s2_cat']) ?

                $result['commonContent']['setting']['home_s2_cat'] : '';

                foreach($result['categories'] as $cat) : 

                    $attr = $cat['category_ID'] ==  $home_s2_cat ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                <?php endforeach;?>

            </select>

        </div>
    </div>

</div>

<h3 class="box-title mt-3">Section Three</h3>
<div class="row mt-3">

    <div class="col-md-6">

        <?php

        $home_s5_h = isset($result['commonContent']['setting']['home_s5_h']) ?

        $result['commonContent']['setting']['home_s5_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s5_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s5_h" class="form-control" id="home_s5_h" value="<?=$home_s5_h?>">

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group mb-3">

            <label for="home_s4_cat" class="control-label mb-1">Category</label>

            <select name="home_s4_cat" class="form-control select2" id="home_s4_cat">

                <?php

                $home_s4_cat = isset($result['commonContent']['setting']['home_s4_cat']) ?

                $result['commonContent']['setting']['home_s4_cat'] : '';

                foreach($result['categories'] as $cat) : 

                    $attr = $cat['category_ID'] == $home_s4_cat ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                <?php endforeach;?>

            </select>

        </div>

    </div>

</div>


<h3 class="box-title mt-3">Section Four</h3>

<div class="row mt-3">

    <div class="col-md-6">

        <?php

        $home_s3_h = isset($result['commonContent']['setting']['home_s3_h']) ?

        $result['commonContent']['setting']['home_s3_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s3_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s3_h" class="form-control" id="home_s3_h" value="<?=$home_s3_h?>">

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group mb-3">

            <label for="home_s3_categories" class="control-label mb-1">Categories</label>

            <select name="home_s3_categories[]" multiple class="form-control select2" id="home_s3_categories" required>

                <?php

                $home_s3_categories = isset($result['commonContent']['setting']['home_s3_categories']) ?

                $result['commonContent']['setting']['home_s3_categories'] : '';

                $home_s3_categories = $home_s3_categories != '' ? unserialize($home_s3_categories) : [];

                foreach($result['categories'] as $cat) : 

                    $attr = in_array($cat['category_ID'], $home_s3_categories) ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                <?php endforeach;?>

            </select>

        </div>

        <div class="form-group d-none mb-3">

            <label for="home_s3_products" class="control-label mb-1">Products</label>

            <select name="home_s3_products[]" multiple class="form-control select2" id="home_s3_products" required>

                <?php

                $home_s3_products = isset($result['commonContent']['setting']['home_s3_products']) ?

                $result['commonContent']['setting']['home_s3_products'] : '';

                $home_s3_products = $home_s3_products != '' ? unserialize($home_s3_products) : [];

                foreach($result['products'] as $prod) : 

                    $attr = in_array($prod['ID'], $home_s3_products) ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$prod['ID']?>"><?=$prod['prod_title']?></option>

                <?php endforeach;?>

            </select>

        </div>

    </div>

</div>


<h3 class="box-title mt-3">Section Five</h3>

<div class="row mt-3">

    <div class="col-md-6">

        <?php

        $home_s6_h = isset($result['commonContent']['setting']['home_s6_h']) ?

        $result['commonContent']['setting']['home_s6_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s6_h" class="form-control" id="home_s6_h" value="<?=$home_s6_h?>">

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group mb-3">

            <label for="home_s6_categories" class="control-label mb-1">Categories</label>

            <select name="home_s6_categories[]" multiple class="form-control select2" id="home_s6_categories" required>

                <?php

                $home_s6_categories = isset($result['commonContent']['setting']['home_s6_categories']) ?

                $result['commonContent']['setting']['home_s6_categories'] : '';

                $home_s6_categories = $home_s6_categories != '' ? unserialize($home_s6_categories) : [];

                foreach($result['categories'] as $cat) : 

                    $attr = in_array($cat['category_ID'], $home_s6_categories) ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                <?php endforeach;?>

            </select>

        </div>

    </div>

</div>

<h3 class="box-title mt-3">Section Six</h3>

<div class="row mt-3">

    <div class="col-md-6">

        <?php

        $home_s7_h = isset($result['commonContent']['setting']['home_s7_h']) ?

        $result['commonContent']['setting']['home_s7_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s7_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s7_h" class="form-control" id="home_s7_h" value="<?=$home_s7_h?>">

        </div>

    </div>

    <div class="col-md-6">

        <div class="form-group mb-3">

            <label for="home_s7_categories" class="control-label mb-1">Categories</label>

            <select name="home_s7_categories[]" multiple class="form-control select2" id="home_s7_categories" required>

                <?php

                $home_s7_categories = isset($result['commonContent']['setting']['home_s7_categories']) ?

                $result['commonContent']['setting']['home_s7_categories'] : '';

                $home_s7_categories = $home_s7_categories != '' ? unserialize($home_s7_categories) : [];

                foreach($result['categories'] as $cat) : 

                    $attr = in_array($cat['category_ID'], $home_s7_categories) ? 'selected' : '';?>

                    <option <?=$attr?> value="<?=$cat['category_ID']?>"><?=$cat['category_title']?></option>

                <?php endforeach;?>

            </select>

        </div>

    </div>

</div>

<h3 class="box-title mt-3">Section Seven</h3>

<div class="row mt-3">

    <div class="col-md-8">

        <?php

        $home_s4_h = isset($result['commonContent']['setting']['home_s4_h']) ?

        $result['commonContent']['setting']['home_s4_h'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s4_h" class="control-label mb-1">Heading</label>

            <input type="text" name="home_s4_h" class="form-control" id="home_s4_h" value="<?=$home_s4_h?>">

        </div>

    </div>

    <div class="col-md-4">

        <?php

        $home_s7_btn_text = isset($result['commonContent']['setting']['home_s7_btn_text']) ?

        $result['commonContent']['setting']['home_s7_btn_text'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s7_btn_text" class="control-label mb-1">Button Text</label>

            <input type="text" name="home_s7_btn_text" class="form-control" id="home_s7_btn_text" value="<?=$home_s7_btn_text?>">

        </div>


        <?php

        $home_s7_btn_link = isset($result['commonContent']['setting']['home_s7_btn_link']) ?

        $result['commonContent']['setting']['home_s7_btn_link'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s7_btn_link" class="control-label mb-1">Button Link</label>

            <input type="text" name="home_s7_btn_link" class="form-control" id="home_s7_btn_link" value="<?=$home_s7_btn_link?>">

        </div>

    </div>

</div>

<h3 class="box-title mt-3">Section Eight</h3>

<div class="row mt-3">

    <div class="col-md-3">

        <div class="form-group">

            <label for="home_s6_image1" class="control-label mb-1">

                Icon

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['home_s6_image1']) ?

                $homes11img1id = $result['commonContent']['setting']['home_s6_image1']['id'] : 

                $homes11img1id = '';

                isset($result['commonContent']['setting']['home_s6_image1']) ?

                $homes11img1path = $result['commonContent']['setting']['home_s6_image1']['path'] : 

                $homes11img1path = ''; ?>

                <input type="hidden" name="home_s6_image1" value="{{$homes11img1id}}"

                id="home_s6_image1">

                <img src="{{asset($homes11img1path)}}" class="w-100 h-auto">

            </div>

        </div>

        <?php

        $home_s6_title = isset($result['commonContent']['setting']['home_s6_title']) ?

        $result['commonContent']['setting']['home_s6_title'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_title" class="control-label mb-1">Title</label>

            <input type="text" name="home_s6_title" class="form-control" id="home_s6_title" value="<?=$home_s6_title?>">

        </div>

        <?php

        $home_s6_text = isset($result['commonContent']['setting']['home_s6_text']) ?

        $result['commonContent']['setting']['home_s6_text'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_text" class="control-label mb-1">Text</label>

            <input type="text" name="home_s6_text" class="form-control" id="home_s6_text" value="<?=$home_s6_text?>">

        </div>

    </div>

    <div class="col-md-3">

        <div class="form-group">

            <label for="home_s6_image2" class="control-label mb-1">

                Icon

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['home_s6_image2']) ?

                $homes11img2id = $result['commonContent']['setting']['home_s6_image2']['id'] : 

                $homes11img2id = '';

                isset($result['commonContent']['setting']['home_s6_image2']) ?

                $homes11img2path = $result['commonContent']['setting']['home_s6_image2']['path'] : 

                $homes11img2path = ''; ?>

                <input type="hidden" name="home_s6_image2" value="{{$homes11img2id}}"

                id="home_s6_image2">

                <img src="{{asset($homes11img2path)}}" class="w-100 h-auto">

            </div>

        </div>

        <?php

        $home_s6_title2 = isset($result['commonContent']['setting']['home_s6_title2']) ?

        $result['commonContent']['setting']['home_s6_title2'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_title2" class="control-label mb-1">Title</label>

            <input type="text" name="home_s6_title2" class="form-control" id="home_s6_title2" value="<?=$home_s6_title2?>">

        </div>

        <?php

        $home_s6_text2 = isset($result['commonContent']['setting']['home_s6_text2']) ?

        $result['commonContent']['setting']['home_s6_text2'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_text2" class="control-label mb-1">Text</label>

            <input type="text" name="home_s6_text2" class="form-control" id="home_s6_text2" value="<?=$home_s6_text2?>">

        </div>

    </div>

    <div class="col-md-3">

        <div class="form-group">

            <label for="home_s6_image3" class="control-label mb-1">

                Icon

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['home_s6_image3']) ?

                $homes11img3id = $result['commonContent']['setting']['home_s6_image3']['id'] : 

                $homes11img3id = '';

                isset($result['commonContent']['setting']['home_s6_image3']) ?

                $homes11img3path = $result['commonContent']['setting']['home_s6_image3']['path'] : 

                $homes11img3path = ''; ?>

                <input type="hidden" name="home_s6_image3" value="{{$homes11img3id}}"

                id="home_s6_image3">

                <img src="{{asset($homes11img3path)}}" class="w-100 h-auto">

            </div>

        </div>

        <?php

        $home_s6_title3 = isset($result['commonContent']['setting']['home_s6_title3']) ?

        $result['commonContent']['setting']['home_s6_title3'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_title3" class="control-label mb-1">Title</label>

            <input type="text" name="home_s6_title3" class="form-control" id="home_s6_title3" value="<?=$home_s6_title3?>">

        </div>

        <?php

        $home_s6_text3 = isset($result['commonContent']['setting']['home_s6_text3']) ?

        $result['commonContent']['setting']['home_s6_text3'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_text3" class="control-label mb-1">Text</label>

            <input type="text" name="home_s6_text3" class="form-control" id="home_s6_text3" value="<?=$home_s6_text3?>">

        </div>

    </div>

    <div class="col-md-3">

        <div class="form-group">

            <label for="home_s6_image4" class="control-label mb-1">

                Icon

            </label>

            <div class="featuredWrap featured">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <?php

                isset($result['commonContent']['setting']['home_s6_image4']) ?

                $homes11img4id = $result['commonContent']['setting']['home_s6_image4']['id'] : 

                $homes11img4id = '';

                isset($result['commonContent']['setting']['home_s6_image4']) ?

                $homes11img4path = $result['commonContent']['setting']['home_s6_image4']['path'] : 

                $homes11img4path = ''; ?>

                <input type="hidden" name="home_s6_image4" value="{{$homes11img4id}}"

                id="home_s6_image4">

                <img src="{{asset($homes11img4path)}}" class="w-100 h-auto">

            </div>

        </div>

        <?php

        $home_s6_title4 = isset($result['commonContent']['setting']['home_s6_title4']) ?

        $result['commonContent']['setting']['home_s6_title4'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_title4" class="control-label mb-1">Title</label>

            <input type="text" name="home_s6_title4" class="form-control" id="home_s6_title4" value="<?=$home_s6_title4?>">

        </div>

        <?php

        $home_s6_text4 = isset($result['commonContent']['setting']['home_s6_text4']) ?

        $result['commonContent']['setting']['home_s6_text4'] : ''; ?>

        <div class="form-group mb-3">

            <label for="home_s6_text4" class="control-label mb-1">Text</label>

            <input type="text" name="home_s6_text4" class="form-control" id="home_s6_text4" value="<?=$home_s6_text4?>">

        </div>

    </div>

</div> 

<div class="d-none">

    <h3 class="box-title mt-3">Section Seven</h3>

    @include('admin.settings.repeater',['data' => $result['commonContent']['setting']])

</div>