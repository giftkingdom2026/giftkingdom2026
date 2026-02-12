<!DOCTYPE html>
<html>

<?php
use App\Models\Core\Setting;

$setting = new Setting();

$result['commonContent'] = $setting->commonContent();
?>

@include('admin.common.meta')

<body class=" hold-transition skin-blue sidebar-mini">
    <!-- wrapper -->
    <div class="wrapper">

        <div class="se-pre-con" id="loader" style="/* display: none; */">
            <div class="pre-loader">
              <div class="la-line-scale">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p>@lang('labels.Loading')..</p>
        </div>

    </div>


    @include('admin.common.header')

    <?php if( Auth::user()->role_id == 2 ) : ?>

        @include('admin.common.sidebar-admin')

    <?php else  : ?>

        @include('admin.common.sidebar')

    <?php endif; ?>

    <div class="modal imguploader fade" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div class="getfiles text-center">
            <h2>+</h2>
            <h4>Drop Files To Upload</h4>
        </div>
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="tabs-nav">
                        <ul class="m-0">
                            <li class="active tab-nav">
                                <a href="javascript:;" class="tab-link modal-link" draggable="false" data-tab="#imgupload">Upload Images</a>
                            </li>
                            <li class=" tab-nav">
                                <a href="javascript:;" class="tab-link modal-link"  draggable="false" data-tab="#imgselect">Select Images</a>
                            </li>
                        </ul>
                    </div>

                    <!-- <input type="input" name="search_img" value="" class="search_img w-50 form-control" placeholder="Search by image name"> -->

                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div class="upload-tabwrap">
                        <div class="tabs-content">
                            <div class="tab active" id="imgupload">
                                <div class="uploaderWrap position-relative" title="Drag & Drop Or Click To Upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="300" height="253.378" viewBox="0 0 300 253.378">
                                        <g id="Group_1" data-name="Group 1" transform="translate(598 -164)">
                                            <rect id="Rectangle_1" data-name="Rectangle 1" width="300" height="253.378" transform="translate(-598 164)" fill="none"/>
                                            <image id="icons8-upload-32" width="32" height="32" transform="translate(-464 275)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAkElEQVR4nO2UbQqAIAxA3ykyumIdN/o4zUKYIJL9aka1B0NBZE83BefldBqP0AOLRpw3JQAzIBo7MDyVXFpK9MCqCdOYz1fLcoTs5JueNgl02ZrJTYST5GQCWEqESvJSwExiuqhvKVD2Sdx7C2Oluc4EkkTcY45UBJohLoCXAG9C/BnKrz+i7yM3xXsFnO9zAAsGbeXvq0QtAAAAAElFTkSuQmCC"/>
                                        </g>
                                    </svg>
                                    <input type="file" multiple name="uploaderfiles[]" class="image_selector" id="image_selector">
                                </div>
                            </div>
                            <div class="tab" id="imgselect">
                                <div class="imageSelectWrap position-relative">
                                    <div class="loader position-absolute top-0 left-0"></div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="imgesWrap" data-type="single">
                                            </div>
                                        </div>

                                        <div class="col-md-3 ps-0" id="imginfo">
                                            <div class="imageInfo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="left">
                        <button type="button" class="btn btn-primary" id="load-gallery" data-load="50">Load More</button>
                        <button type="button" class="btn btn-primary" id="refresh">Refresh</button>
                    </div>
                    <div class="right">
                        <button type="button" class="btn close-custom btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" disabled data-url="" data-images="" class="btn insert_image btn-primary">Insert Image</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal delete-modal fade show" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are You Sure You Want to Delete this?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn close-modal-global close-custom-delete btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" class="delete-modal-ids" value="">            
                    <button type="submit" data-images="" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="megaMenu ">
    <div id="megaMenuWrap">
        <a href="javascript:;" class="closeSubs">
            <svg xmlns="http://www.w3.org/2000/svg" width="22.274" height="22.274" viewBox="0 0 22.274 22.274">
                <g id="close" transform="translate(-682.535 -1043.866) rotate(45)">
                    <line id="Line_35" data-name="Line 35" y2="30" transform="translate(1236.5 240.5)" fill="none" stroke="#eb1c22" stroke-width="1.5"></line>
                    <line id="Line_36" data-name="Line 36" x1="30" transform="translate(1221.5 255.5)" fill="none" stroke="#eb1c22" stroke-width="1.5"></line>
                </g>
            </svg>
        </a>
    </div>
</div>

@yield('content')
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content shadow-sm border-0">
      <div class="modal-header bg-dark text-white py-2">
        <h6 class="modal-title text-white" id="eventDetailModalLabel">Inquiry Summary</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <div class="row g-2 small">
          <div class="col-6">
            <strong>Name:</strong><br>
            <span id="modalName" class="text-muted"></span>
          </div>
          <div class="col-6">
            <strong>Email:</strong><br>
            <span id="modalEmail" class="text-muted"></span>
          </div>
          <div class="col-6">
            <strong>Event:</strong><br>
            <span id="modalEvent" class="text-muted"></span>
          </div>
          <div class="col-6">
            <strong>Guests:</strong><br>
            <span id="modalGuests" class="text-muted"></span>
          </div>
          <div class="col-6">
            <strong>Phone:</strong><br>
            <span id="modalPhone" class="text-muted"></span>
          </div>
          <div class="col-6">
            <strong>Date:</strong><br>
            <span id="modalDate" class="text-muted"></span>
          </div>
        </div>

        <div class="mt-3">
          <strong>Message:</strong>
          <div id="modalMessage" class="border rounded p-2 bg-light small mt-1" style="min-height: 40px;"></div>
        </div>

        <div class="text-end text-muted small mt-2">
          <em>Received: <span id="modalCreated"></span></em>
        </div>
      </div>
    </div>
  </div>
</div>

@include('admin.common.controlsidebar')

@include('admin.common.footer')

</div>


@include('admin.common.scripts')


</body>
</html>


<style>
    .image_selector{position: absolute;width: 100%;height: 100%;opacity: 0;top: 0;left: 0;cursor: pointer;}

    .shallow-draggable {transition: opacity 200ms ease;cursor: move;}

    .dragging {transition: opacity 1s ease;background: #fff !important;position: relative;}

    .dragging:after {content: '';position: absolute;width: 100%;height: 100%;left: 0;top: 0;border: solid 2px #40004C;}
</style>