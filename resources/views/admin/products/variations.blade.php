<div class="accordion variation">



    <div class="heading">

        Variation

    </div>

    <div class="contents">

        <div class="var-head text-end">

            <a href="javascript:;" class="remove-var btn-primary btn-sm text-white">Remove</a>

        </div>

        <div class="row my-3">

            <?php

            $str = '';

            foreach($attrs as $attr ) :

               $str.= $attr['attribute_ID'].',';  ?>

               <div class="col-md-3">

                <div class="form-group">

                    <select name="<?=$attr['attribute_ID']?>" class="form-control var-attrs select2">

                        <?php

                        foreach( $attr['selected_values'] as $val ) : ?>

                            <option value="<?=$val['value_ID']?>"><?=$val['value_title']?></option>

                        <?php endforeach;?>

                    </select>

                </div>

            </div>

        <?php endforeach;?>

        <input type="hidden" name="attrs" value="<?=rtrim($str,',')?>">

    </div>

    <div class="row align-items-center">

        <div class="col-md-12">

            <div class="row pdata">

                                                        <div class="form-group">



                                                            <label for="name" class="control-label mb-1">Title</label>


                                                            <input type="text" name="var_prod_title" class="form-control var_prod_title_en">
                                                            <input type="text" style="display: none" name="var_prod_title_ar" class="form-control var_prod_title_ar">



                                                        </div>
                <div class="col-md-4 mt-3">

                    <div class="form-group">

                        <label for="name" class="control-label mb-1">SKU</label>

                        <input type="text" name="var_prod_sku" class="form-control">

                    </div>

                </div>

                <div class="col-md-4 mt-3">

                    <div class="form-group">

                        <label for="name" class="control-label mb-1">Regular Price</label>

                        <input type="number" name="var_prod_price" class="form-control regular" required>

                    </div>

                </div>

                <div class="col-md-4 mt-3">

                    <div class="form-group">

                        <label for="name" class="control-label mb-1">Sale Price</label>

                        <input type="number" name="var_sale_price" class="sale form-control">

                    </div>

                </div>

                <div class="col-md-4 mt-3">

                    <div class="form-group">

                        <label for="name" class="control-label mb-1">Stock</label>

                        <input type="text" name="var_prod_quantity" class="form-control">

                    </div>

                </div>

            </div>

            <!-- <div class="form-group">

                <label class="form-label">Values</label>

                <select class="values-field" name="values[]" multiple class="form-control" style="width: 100%">

                </select>

            </div> -->

        </div>    

        <div class="col-md-4">

           <div class="form-group mt-3">

            <label for="featured_image" class="control-label mb-1">Product Image</label>

            <div class="featuredWrap">

                <button class="btn uploader featured_image btn-primary" data-type="single">+</button>

                <input type="hidden" id="featured_image" 

                name="var_prod_image" value="">

                <img src="" alt="featured_image" class="w-100 d-none">

            </div>

        </div>

    </div>

    <div class="col-md-8">

        <div class="form-group mt-3">

            <label for="featured_image" class="control-label mb-1">Product Gallery</label>

            <div class="featuredWrap">

                <button class="btn uploader featured_image btn-primary" data-type="multiple">+</button>

                <input type="hidden" id="featured_image" name="var_prod_images" value="">

            </div>

        </div>

    </div>
  <div class="col-md-12 mt-3">

                                                <div class="form-group">

                                                    <label for="name" class="control-label mb-1">Description</label>

                                                    <textarea name="var_prod_description" rows="7" class="form-control"></textarea>

                                                </div>

                                                <div class="form-group mt-3">

                                                    <label for="name" class="control-label mb-1">Short Description</label>

                                                    <textarea name="var_prod_short_description" rows="7" class="form-control"></textarea>

                                                </div>
 <div class="form-group mt-3">

                                                    <label for="prod_features" class="control-label mb-1">Product Features</label>

                                                    <textarea name="var_prod_features" rows="7" class="form-control"></textarea>

                                                </div>
                                            </div>
    <div class="col-md-12 mt-3">

        <button class="btn btn-primary update-variation" type="button">Save</button>

    </div>

</div>

</div>

</div>