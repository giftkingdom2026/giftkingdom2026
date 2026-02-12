 @if(isset($images))
                            @foreach($images as $image)

                            <?php

                            $name = pathinfo( $image['path'], PATHINFO_FILENAME ).'.'.$image['extension'];

                            $imageformats = ['gif', 'jpg', 'jpeg', 'png','webp','svg'];

                            $videoformats = ['webm','mpeg','mp4'];

                            if( in_array($image['extension'], $imageformats)  ) :

                                $img = asset( $image['path'] );

                                $type = 'image';

                            elseif( in_array( $image['extension'], $videoformats ) ) :

                                $img = asset( 'images/video.png' );

                                $type = 'video';

                            else:

                                $img = asset( 'images/document.png' );

                                $type = 'document';

                            endif;?>

                            <div class="col-md-2 mb-3">
                                <figure>
                                    <?php if( $type == 'video' ) : ?>

                                        <video controls class="w-100">
                                            <source src="<?=$image['path']?>" class="w-100"/>
                                            </video>

                                        <?php else :?>

                                            <img image_id="{{$image['image_id']}}" src="{{asset($img)}}" alt="..."/>


                                        <?php endif; ?>

                                    </figure>

                                    <a class="btn d-block btn-primary uploader detail" href="javascript:;">Image Info</a>

                                    <imageinfo style="display: none;">

                                        <figure>

                                            <?php if( $type == 'video' ) : ?>

                                                <video controls>
                                                    <source src="<?=$image['path']?>" class="w-100"/>
                                                    </video>

                                                <?php else :?>

                                                    <img src="{{asset($img)}}" class="w-100" style="height: 300px;object-fit: contain;"/>

                                                <?php endif; ?>
                                            </figure>

                                            <figcaption>


                                                <?php if( $type == 'video' ) : ?>

                                                    <ul>
                                                        <li><span>File Name</span> {{$name}}</li>
                                                        <li><span>Type</span> <?=$type?></li>
                                                        <li><span>File Type</span> {{$image['extension']}}</li>
                                                        <li><span>Url</span> <input type="text" value="{{asset($image['path'])}}" readonly></li>
                                                    </ul>

                                                <?php elseif( $type == 'image' ) : ?>

                                                    <a href="{{asset($image['path'])}}" data-fancybox>View Full Size</a>
                                                    <ul>
                                                        <li><span>File Name</span> {{$name}}</li>
                                                        <li><span>Dimensions</span> {{$image['width']}}x{{$image['height']}}</li>
                                                        <li><span>Type</span> <?=$type?></li>
                                                        <li><span>File Type</span> {{$image['extension']}}</li>
                                                        <li><span>Url</span> <input type="text" value="{{asset($image['path'])}}" readonly></li>
                                                    </ul>

                                                <?php else : ?>

                                                    <a href="{{asset($image['path'])}}" target="_blank">View File</a>
                                                    <ul>
                                                        <li><span>File Name</span> {{$name}}</li>
                                                        <li><span>Type</span> <?=$type?></li>
                                                        <li><span>File Type</span> {{$image['extension']}}</li>
                                                        <li><span>Url</span> <input type="text" value="{{asset($image['path'])}}" readonly></li>
                                                    </ul>

                                                <?php endif; ?>

                                            </figcaption>
                                        </imageinfo>
                                    </div>
                                    @endforeach
                                    @endif