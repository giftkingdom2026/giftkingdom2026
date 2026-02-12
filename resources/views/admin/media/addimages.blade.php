@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Media </h1>
       <!--  <ol class="breadcrumb">
            <li><a href="{{url('admin/media/display')}}"><i class="fa fa-gear"></i> Settings</a></li>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete these images?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">

                        <div class="d-flex justify-content-between">

                            <h3 class="box-title">{{ trans('labels.ListingAllImage') }} </h3>

                            <div class="d-flex gap-3">

                                <div class="box-tools pull-left">
                                    <button id="delete-images" type="button" class="btn btn-block btn-primary">Delete</button>

                                </div>
                                <div class="box-tools pull-left">
                                    <button type="button" class="btn select-unselect-images select btn-block btn-primary" >Select All</button>

                                </div>
                                <div class="box-tools pull-left">
                                    <button type="button" class="btn select-unselect-images btn-block btn-primary" >UnSelect All</button>

                                </div>
                                <div class="box-tools pull-left">
                                    <button type="button" class="btn btn-block uploader listing btn-primary" data-toggle="modal"
                                    data-target="#myModal">{{ trans('labels.AddNew') }}</button>

                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if (count($errors) > 0)
                                @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>

                        </head>



                        <form class="hidden" action="" method="" id="images_form">
                            <input id="images" type="hidden" name="images" value=""/>
                        </form>
                        <div class="row" id="media-gallery">

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

                                        <video controls class="w-100" image_id="{{$image['image_id']}}">
                                            <source class="w-100" src="{{asset($image['path'])}}" class="w-100"/>
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
                                                    <source image_id="{{$image['image_id']}}" src="<?=$image['path']?>" class="w-100"/>
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
                                                        <li><span>Alt</span><div class="alt-form"><input type="text" name="alt"></div></li>
                                                    </ul>

                                                <?php endif; ?>

                                            </figcaption>
                                        </imageinfo>
                                    </div>
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                                        <button class="btn btn-primary load_more w-auto m-auto">Load More</button>

                    <p id="demo"></p>

                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <script>

                </script>
                <!-- Main row -->

                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        @endsection


        <style>

            #media-gallery img{
                object-fit: contain;
                width: 100%;
                height: 150px;
                cursor: pointer;
            }

            svg.tick {width: 15px;position: absolute;right: 6px;top: 6px;}

            #media-gallery .selected:before{
                content: '+';
                position: absolute;
                top: 0;
                right: 0;
                color: #ffffff;
                font-weight: 700;
                width: 30px;
                height: 30px;
                background: #8585d5;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 25px;
            }

            #media-gallery .selected:after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border: solid 3px #8585d5a1;
            }

            #media-gallery figure{
                margin: 0;
                position: relative;
            }

        </style>