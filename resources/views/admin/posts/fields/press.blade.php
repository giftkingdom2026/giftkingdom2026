<div class="row">

    <input type="hidden" name="fields" value="banner_image,s1_head,s2_head,s2_text,s2_image">    

    <?php isset($data['post_data']) ? $metadata = $data['post_data']['metadata'] : $metadata = ''; ?>



<div class="col-md-12 mt-3">

        <?php   

        isset($metadata['banner_image'] ) ? $c = '' : $c = 'd-none'; 
        isset($metadata['banner_image']) ? $c2 = 'featured' : $c2 = ''; 
        isset($metadata['banner_image']) ? $imgid = $metadata['banner_image']['id'] : $imgid = ''; 
        isset($metadata['banner_image']) ? $imgpath = $metadata['banner_image']['path'] : $imgpath = ''; 

        ?>

        <div class="form-group mt-3">

            <label for="banner_image" class="control-label mb-3">Banner Image</label>

            <div class="featuredWrap <?=$c2?>">

                <button class="btn uploader banner_image btn-primary" data-type="single">+</button>

                <input type="hidden" id="banner_image" 

                name="banner_image" value="{{$imgid}}">

                <img src="{{asset($imgpath)}}" alt="banner_image" class="w-100 h-auto <?=$c?>">

            </div>

        </div>

    </div>
    
    
    <div class="col-md-12 my-5">
        <div class="main-heading text-center">
            <h2>Section Two</h2>
        </div>
    </div>
    
    <div class="col-md-6">

        <div class="form-group mt-3">

            <div class="form-group">

                <label for="s1_head" class="control-label mb-1">Small Heading</label>

                <?php ( isset( $metadata['s1_head'] ) ) ? $s1_head = $metadata['s1_head']  : $s1_head = '' ;?>

                <input type="text" name="s1_head" id="s1_head" class="form-control" value="{{$s1_head}}"/>

            </div>

        </div>

        <div class="form-group mt-3">

            <div class="form-group">

                <label for="s2_head" class="control-label mb-1">Heading</label>

                <?php ( isset( $metadata['s2_head'] ) ) ? $s2_head = $metadata['s2_head']  : $s2_head = '' ;?>

                <input type="text" name="s2_head" id="s2_head" class="form-control" value="{{$s2_head}}"/>

            </div>

        </div>


        <div class="form-group mt-3">

            <div class="form-group">

                <label for="s2_text" class="control-label mb-1">Text</label>

                <?php ( isset( $metadata['s2_text'] ) ) ? $s2_text = $metadata['s2_text']  : $s2_text = '' ;?>

                <div class="quilleditor" id="s2_text" height="200">

                    {!!$s2_text!!}

                </div>

            </div>
        </div>

    </div>

    <div class="col-md-6">

        <?php   

        isset($metadata['s2_image']) ? $c = '' : $c = 'd-none'; 
        isset($metadata['s2_image']) ? $c2 = 'featured' : $c2 = ''; 
        isset($metadata['s2_image']) ? $imgid = $metadata['s2_image']['id'] : $imgid = ''; 
        isset($metadata['s2_image']) ? $imgpath = $metadata['s2_image']['path'] : $imgpath = ''; 
        ?>

        <div class="form-group mt-3">

            <label for="s2_image" class="control-label mb-3">Image</label>

            <div class="featuredWrap <?=$c2?>">

                <button class="btn uploader s2_image btn-primary" data-type="single">+</button>

                <input type="hidden" id="s2_image" 

                name="s2_image" value="{{$imgid}}">

                <img src="{{asset($imgpath)}}" alt="s2_image" class="w-100 h-auto <?=$c?>">

            </div>

        </div>

    </div>

</div>