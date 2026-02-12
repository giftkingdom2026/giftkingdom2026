<div class="row">

    <input type="hidden" name="fields" value="slogan,range,passengers,gallery_images">    

    <?php isset($data['post_data']) ? $metadata = $data['post_data']['metadata'] : $metadata = ''; ?>

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

<div class="col-md-4">

    <div class="form-group mt-3">

        <div class="form-group">

            <label for="slogan" class="control-label mb-1">Slogan</label>

            <?php ( isset( $metadata['slogan'] ) ) ? $slogan = $metadata['slogan']  : $slogan = '' ;?>

            <input type="text" name="slogan" id="slogan" class="form-control" value="{{$slogan}}"/>

        </div>

    </div>

</div>


<div class="col-md-4">

    <div class="form-group mt-3">

        <div class="form-group">

            <label for="range" class="control-label mb-1">Max range</label>

            <?php ( isset( $metadata['range'] ) ) ? $range = $metadata['range']  : $range = '' ;?>

            <input type="text" name="range" id="range" class="form-control" value="{{$range}}"/>

        </div>

    </div>

</div>

<div class="col-md-4">

    <div class="form-group mt-3">

        <div class="form-group">

            <label for="passengers" class="control-label mb-1">Passengers</label>

            <?php ( isset( $metadata['passengers'] ) ) ? $passengers = $metadata['passengers']  : $passengers = '' ;?>

            <input type="text" name="passengers" id="passengers" class="form-control" value="{{$passengers}}"/>

        </div>

    </div>

</div>

</div>