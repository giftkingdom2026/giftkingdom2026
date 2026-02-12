<div class="row">

    <input type="hidden" name="fields" value="gallery_images,banner_image">    

    <?php isset($data['post_data']) ? $metadata = $data['post_data']['metadata'] : $metadata = ''; ?>

    <div class="col-md-12">

        <div class="form-group  mt-3">

            <label for="banner_image" class="control-label mb-1">

                Banner

            </label>

            <?php 

            ( isset( $metadata['banner_image'] ) ) ? $c1 = 'featured' : $c1 = '';
            ( isset( $metadata['banner_image'] ) ) ? $c2 = '' : $c2 = 'd-none';
            ( isset( $metadata['banner_image'] ) ) ? $img = $metadata['banner_image']['path'] : $img = '';

            ?>

            <div class="featuredWrap <?=$c1?>">

                <button class="btn  uploader featured_image btn-primary" 

                data-type="multiple">+

            </button>

            <input type="hidden" id="banner_image" 

            name="banner_image" value="

            <?php if( isset( $metadata['banner_image'] ) ){ 

                echo $metadata['banner_image']['id'];

            }?>">

            <img src="{{asset($img)}}" class="w-100 <?=$c2?> h-auto">

        </div>

    </div>

</div>      

<div class="col-md-12">

    <div class="form-group  mt-3">

        <label for="gallery_images" class="control-label mb-1">

            Gallery

        </label>

        <?php 

        ( isset( $metadata['gallery_images'] ) ) ? 

        $c1 = 'featured' : $c1 = ''; ?>

        <div class="featuredWrap <?=$c1?>">

            <button class="btn  uploader featured_image btn-primary" 

            data-type="multiple">+

        </button>

        <input type="hidden" id="gallery_images" 

        name="gallery_images" value="

        <?php if( isset( $metadata['gallery_images'] ) ){ 

            echo $metadata['gallery_images']['id'];

        }?>">

        <?php 

        if( isset( $metadata['gallery_images'] ) ) : ?>

            <div class="row" id="images">

                <?php foreach( $metadata['gallery_images']['path'] as $path ) : ?>

                    <div class="col-md-4">

                        <img src="{{asset($path)}}" class="w-100">

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</div>      

</div>

</div>



