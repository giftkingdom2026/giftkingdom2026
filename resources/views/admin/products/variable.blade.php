<div class="border p-3">

    <h2>Variable Product Data</h2>

    <div class="row align-items-center ">

        <div class="col-md-2">

            <ul class="nav flex-column gap-1 nav-tabs" style="border:none;" id="myTab" role="tablist">

                <li class="nav-item" role="presentation">

                    <a class="nav-link btn-primary btn active w-100 text-white" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane">

                        Attributes

                    </a>

                </li>

                <li class="nav-item" role="presentation">

                    <a class="nav-link btn-primary text-white w-100 btn" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane">

                        Variations

                    </a>

                </li>

            </ul>

        </div>

        <div class="col-md-10">

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="home-tab-pane" tabindex="0">

                    <div class="form">

                        <div class="row justify-content-between align-items-center">

                            <div class="col-md-4">

                                <input type="hidden" value="<?=$id?>" name="product_ID">

                                <div class="form-group my-3">

                                    <select id="attributes" name="attribute_ID" class="form-control">

                                        <?php

                                        foreach( $allattrs as $item ) : ?>

                                            <option value="<?=$item['attribute_ID']?>"><?=$item['attribute_title']?></option>

                                        <?php endforeach;?>

                                    </select>



                                </div>



                            </div>



                            <div class="col-md-4 text-end">



                                <button type="button" id="attr-add" class="btn btn-primary">Assign</button>



                            </div>



                        </div>         



                        <div class="assigned-attributes" data-id="<?=$id?>">



                        </div>



                    </div>



                </div>



                <div class="tab-pane fade" id="profile-tab-pane" tabindex="0">



                    <div class="variation-form">



                        <div class="text-end mb-3">



                            <button type="submit" id="add-variation" class="btn btn-primary">+ Add Variation</button>



                        </div>



                        <div class="variations-append myAccordions" style="width:100%">



                            <?php

                            foreach( $variations as $var ) :  ?>

                                <div class="accordion variation"  id="var-{{$var['ID']}}">

                                    <div class="heading">

                                        Variation #<?=$var['ID']?>

                                    </div>

                                    <input type="hidden" name="var_ID" value="<?=$var['ID']?>">

                                    <div class="contents">

                                        <div class="var-head text-end">

                                            <a href="javascript:;" class="remove-var btn-primary btn-sm text-white">Remove</a>

                                        </div>

                                        <div class="row my-3">

                                            <?php

                                            $str = '';

                                            foreach($attrs as $key => $attr ) :

                                               $str.= $attr['attribute_ID'].',';  ?>

                                               <div class="col-md-3">

                                                <div class="form-group">

                                                    <select name="<?=$attr['attribute_ID']?>" id="attr<?=$attr['attribute_ID']?><?=$var['ID']?>" class="form-control var-attrs select2">

                                                        <?php

                                                        foreach( $attr['selected_values'] as $val ) :

                                                            if( isset( $var['variation'][$key] ) ) :

                                                                $var['variation'][$key]['value_ID'] == $val['value_ID'] &&

                                                                $var['variation'][$key]['attribute_ID'] == $attr['attribute_ID'] ?

                                                                $attribute = 'selected' : $attribute = '';  

                                                            else :

                                                                $attribute = '';

                                                            endif;

                                                            ?>

                                                            <option <?=$attribute?> value="<?=$val['value_ID']?>">

                                                                <?=$val['value_title']?>

                                                            </option>

                                                            <?php 

                                                        endforeach;?>

                                                    </select>

                                                </div>

                                            </div>

                                        <?php endforeach;?>

                                        <input type="hidden" name="attrs" value="<?=rtrim($str,',')?>">

                                    </div>

                                    <div class="row align-items-center">

                                        <div class="col-md-12">

                                            <div class="row pdata">
 <div class="col-md-4">



                                                        <div class="form-group">



                                                            <label for="name" class="control-label mb-1">Title</label>


                                                            <input type="text" name="var_prod_title" value="<?= $var['prod_title'] ?>" class="form-control var_prod_title_en">
                                                            <input type="text" style="display: none" name="var_prod_title_ar" value="<?= $var['prod_title_ar'] ?>" class="form-control var_prod_title_ar">



                                                        </div>



                                                    </div>
                                                <div class="col-md-4">

                                                    <div class="form-group">

                                                        <label for="name" class="control-label mb-1">SKU</label>

                                                        <input type="text" name="var_prod_sku" value="<?=$var['prod_sku']?>" class="form-control">

                                                    </div>

                                                </div>

                                                <div class="col-md-4">

                                                    <div class="form-group">

                                                        <label for="name" class="control-label mb-1">Regular Price</label>

                                                        <input type="number" name="var_prod_price" value="<?=$var['prod_price']?>" class="form-control regular" required>

                                                    </div>

                                                </div>

                                                <div class="col-md-4 mt-3">

                                                    <div class="form-group">

                                                        <label for="name" class="control-label mb-1">Sale Price</label>

                                                        <input type="number" value="<?=$var['sale_price']?>" name="var_sale_price" class="form-control sale">

                                                    </div>

                                                </div>

                                                <div class="col-md-4 mt-3">

                                                    <div class="form-group">

                                                        <label for="name" class="control-label mb-1">Stock</label>

                                                        <input type="text" name="var_prod_quantity" value="<?=$var['prod_quantity']?>" class="form-control">

                                                    </div>

                                                </div>

                                            </div>

                                        </div>    

                                        <div class="col-md-4">

                                            <?php

                                            $img = $var['prod_image']['path'] == '' ? '' : $var['prod_image']['path'];

                                            $imgid = $var['prod_image']['id'] == '' ? '' : $var['prod_image']['id'] ; 

                                            ($var['prod_image']['path'] == '') ? $c = 'd-none' : $c = ''; 

                                            ($var['prod_image']['path'] == '') ? $c2 = '' : $c2 = 'featured'; 

                                            ?>

                                            <div class="form-group mt-3">

                                                <label for="featured_image" class="control-label mb-1">Product Image</label>

                                                <div class="featuredWrap <?=$c2?>">

                                                    <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                                                    <input type="hidden" id="featured_image" 

                                                    name="var_prod_image" value="<?=$imgid?>">

                                                    <img src="<?=asset($img)?>" class="w-100 <?=$c?>">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-8">

                                            <div class="form-group mt-3">

                                                <?php   

                                                $imgid = $var['prod_images']['id'] == '' ? '' : $var['prod_images']['id'] ; 

                                                ($var['prod_images']['path'] == '') ? $c2 = '' : $c2 = 'featured'; 

                                                ?>

                                                <label for="featured_image" class="control-label mb-1">Product Gallery</label>

                                                <div class="featuredWrap <?=$c2?>">

                                                    <button class="btn uploader featured_image btn-primary" data-type="multiple">+</button>

                                                    <input type="hidden" id="featured_image" name="var_prod_images" value="<?=$imgid?>">

                                                    <div class="row p-0 g-0" id="images">

                                                        <?php 

if (!empty($var['prod_images']['path'])) :

    if (is_array($var['prod_images']['path'])) :

        foreach($var['prod_images']['path'] as $path) : ?>

            <div class="col-md-2">
                <img src="<?= asset($path) ?>" class="w-100 p-0">
            </div>

        <?php endforeach;

    else : ?>

        <div class="col-md-2">
            <img src="<?= asset($var['prod_images']['path']) ?>" class="w-100 p-0">
        </div>

    <?php endif;

endif; ?>


                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                           <!-- English Fields -->
<div class="col-md-12 mt-3 lang-fields lang-en">
    <div class="form-group">
        <label class="control-label mb-1">Description</label>
        <textarea name="var_prod_description" rows="7" class="form-control"><?= $var['prod_description'] ?></textarea>
    </div>

    <div class="form-group mt-3">
        <label class="control-label mb-1">Short Description</label>
        <textarea name="var_prod_short_description" rows="7" class="form-control"><?= $var['prod_short_description'] ?></textarea>
    </div>

    <div class="form-group mt-3">
        <label class="control-label mb-1">Product Features</label>
        <textarea name="var_prod_features" rows="7" class="form-control"><?= $var['prod_features'] ?? '' ?></textarea>
    </div>
</div>

<!-- Arabic Fields -->
<div class="col-md-12 mt-3 lang-fields lang-ar" style="display: none;">
    <div class="form-group">
        <label class="control-label mb-1">Description</label>
        <textarea name="var_prod_description_ar" rows="7" class="form-control"><?= $var['prod_description_ar'] ?? '' ?></textarea>
    </div>

    <div class="form-group mt-3">
        <label class="control-label mb-1">Short Description</label>
        <textarea name="var_prod_short_description_ar" rows="7" class="form-control"><?= $var['prod_short_description_ar'] ?? '' ?></textarea>
    </div>

    <div class="form-group mt-3">
        <label class="control-label mb-1">Product Features</label>
        <textarea name="var_prod_features_ar" rows="7" class="form-control"><?= $var['prod_features_ar'] ?? '' ?></textarea>
    </div>
</div>

                                        <div class="col-md-12 mt-3">

                                            <button class="btn btn-primary update-variation" type="button">Save</button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach;?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>