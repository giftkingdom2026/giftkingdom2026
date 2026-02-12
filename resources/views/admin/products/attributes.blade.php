<div class="myAccordions" style="width: 100%;">



    <?php



    foreach($attrs as $attr) : ?>



        <div class="accordion">

            <div class="heading"><?=$attr['attribute_title']?></div>

            <div class="contents">

                <div class="row valueform align-items-center">

                    <input type="hidden" name="attribute_ID" value="<?=$attr['attribute_ID']?>">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="form-label">Values</label>

                            <select class="values-field" attr="<?=$attr['attribute_ID']?>" name="values[]" multiple class="form-control" style="width: 100%">

                                <?php

                                foreach( $attr['values'] as $val ) :

                                    $attrib = in_array($val['value_ID'], $attr['selected_values_check']) ? 'selected' : ''; ?>

                                    <option <?=$attrib?> value="<?=$val['value_ID']?>"><?=$val['value_title']?></option>

                                <?php endforeach;?>

                            </select>



                        </div>



                    </div>    



                    <div class="col-md-12 mt-3">



                        <button class="btn btn-primary" id="savevalues" type="button">Save</button>



                    </div>



                </div>



            </div>



        </div>



    <?php endforeach;?>



</div>