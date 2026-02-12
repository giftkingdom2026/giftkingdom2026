
<?php 

use App\Models\Core\Posttypes;

use App\Models\Core\Taxonomy;

$posttypes = Posttypes::all(); ?>

<aside class="main-sidebar">

  <section class="sidebar">

    <ul class="sidebar-menu">


      <li class="treeview <?= Request::is('admin/dashboard') ? 'active' : '' ?>">

        <a href="<?= URL::to('admin/dashboard')?>">

          <i class="fa fa-dashboard"></i> <span><?= trans('labels.header_dashboard') ?></span>

        </a>

      </li>

      
      <?php if( Auth()->user()->role_id == 1 ) : ?>
      
      <li class="treeview d-none">
        <a href="javascript:;">
          <i class="fa-solid fa-mobile"></i>
          <span>Mobile Application</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="treeview ">
            <a href="<?=asset('admin/mobile-slider/display')?>">

              <i class="fa-regular fa-circle-dot fa-sm"></i><span> Slider </span>
            </a>
          </li>

         <!--  <li class="treeview ">
            <a href="javascript:;">

              <i class="fa-regular fa-circle-dot fa-sm"></i> <span> Notification </span>
            </a>
          </li>
          <li class="treeview ">
            <a href="<?=asset('/admin/app-config')?>">

              <i class="fa-regular fa-circle-dot fa-sm"></i> <span> Configuration </span>
            </a>
          </li> -->
        </ul>
      </li>


      <li class="treeview d-none <?= Request::is('admin/mega-menu') ? 'active' : '' ?>">

        <a href="<?= URL::to('admin/mega-menu')?>">
          <i class="fa fa-list"></i>
          <span>
            Mega Menu
          </span>
        </a>

      </li>

      <li class="treeview <?= Request::is('admin/menus/*') ? 'active' : '' ?>">

        <a href="<?= URL::to('admin/menus')?>">
          <i class="fa fa-list"></i>
          <span>
            Menus
          </span>
        </a>

      </li>


      <li class="<?=Request::is('admin/page/*') ? 'active' : '' ?>">

        <a href="<?=asset('admin/page/list')?>">
          <i class="fa fa-file"></i>
          <span>Pages</span>
        </a>

      </li>

      <li class="<?= Request::is('admin/home-content') ? 'active' : '' ?>">
        <a href="<?= URL::to('admin/home-content')?>">
          <i class="fa fa-file"></i>
          <span>Home Page</span>
        </a>
      </li>

      <?php foreach($posttypes as $postype): ?>

        @if($postype->post_type !== 'jobs')

        <li class="{{ Request::is('admin/list/' . $postype->post_type) ? 'active' : '' }}">

          <a href="{{ URL::to('admin/list/' . $postype->post_type) }}">

            <i class="{{ $postype->dashboard_icon }}"></i>
            <span>{{ $postype->post_type_title }}</span>

          </a>

        </li>

        @endif

      <?php endforeach; ?>


    <?php endif; ?>

    <?php if( Auth()->user()->role_id == 1 ) : ?>

    <li class="<?= Request::is('admin/coupons/display') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/coupons/display')?>">
        <i class="fa-solid fa-ticket"></i> Coupons
      </a>
    </li>

    <li class="<?= Request::is('admin/abandonedcart/') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/abandonedcart/')?>">
        <i class="fa-solid fa-ticket"></i> Abandoned Cart
      </a>
    </li>

  <?php endif;?>

  <?php

  $active = '';

  $arr = ['category','deals','brands','attribute','product'];

  foreach($arr as $uri) : str_contains(Route::current()->uri(), $uri) ? $active = 'active' : '';  endforeach; ?>


  <li class="treeview <?=$active?>">
    <a href="#">
      <i class="fa fa-database"></i>
      <span>Catalog</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

      <?php if( Auth()->user()->role_id == 1 ) : ?>

      <li class="">
        <a href="<?= URL::to('admin/category/list')?>">
          <i class="fa-regular fa-circle-dot fa-sm"></i>Categories
        </a>
      </li>
      <!-- <li class="">
        <a href="<?= URL::to('admin/deals/list')?>">
          <i class="fa-regular fa-circle-dot fa-sm"></i>Deals
        </a>
      </li> -->
      <li class="<?=Request::is('admin/brands/*') ? 'active' : '' ?>">
        <a href="<?=URL::to('admin/brand/list')?>">
          <i class="fa-regular fa-circle-dot fa-sm"></i>Brands
        </a>
      </li>

      <li class="<?= Request::is('admin/attribute/list') ? 'active' : '' ?>">
        <a href="<?= URL::to('admin/attribute/list')?>">
          <i class="fa-regular fa-circle-dot fa-sm"></i>Attributes
        </a>
      </li>

    <?php endif;?>

    <li class="<?=Request::is('admin/product/*') ? 'active' : ''?>">
      <a href="<?= URL::to('admin/product/list')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> Products
      </a>
    </li>

    <li class="<?= Request::is('admin/product/inventory/') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/product/inventory/')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> Inventory
      </a>
    </li>
  </ul>

</li>


<?php if( Auth()->user()->role_id == 1 ) : ?>


<li class="treeview <?= Request::is('admin/reviews/') ? 'active' : '' ?> <?= Request::is('admin/reviews/*') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/reviews/')?>">

    <i class="fa-regular fa-star"></i> <span>Reviews</span>

  </a>

</li>

<!-- <li class="treeview <?= Request::is('admin/questions/') ? 'active' : '' ?> <?= Request::is('admin/questions/*') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/questions/')?>">

    <i class="fa-solid fa-question"></i> <span>Product Questions</span>

  </a>

</li> -->

<?php endif;?>

<!-- Orders -->
<li class="treeview <?= Request::is('admin/orderstatus') ? 'active' : '' ?> <?= Request::is('admin/addorderstatus') ? 'active' : '' ?> <?= Request::is('admin/editorderstatus/*') ? 'active' : '' ?> <?= Request::is('admin/orders/display') ? 'active' : '' ?> <?= Request::is('admin/orders/vieworder/*') ? 'active' : '' ?>">

  <a href="#" >
    <i class="fa fa-list-ul" aria-hidden="true"></i> 
    <span> <?= trans('labels.link_orders') ?></span> 
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li class="d-none <?= Request::is('admin/orderstatus') ? 'active' : '' ?> <?= Request::is('admin/addorderstatus') ? 'active' : '' ?> <?= Request::is('admin/editorderstatus/*') ? 'active' : '' ?> ">
      <a href="<?= URL::to('admin/orderstatus')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> <?= trans('labels.link_order_status') ?>
      </a>
    </li>
    <li class="<?= Request::is('admin/orders/display') ? 'active' : '' ?> <?= Request::is('admin/orders/vieworder/*') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/orders/display')?>" >
        <i class="fa-regular fa-circle-dot fa-sm"></i> <span> <?= trans('labels.link_orders') ?></span>
      </a>
    </li>
  </ul>
</li>


<!-- Reports -->

<li class="treeview <?= str_contains(Route::current()->uri, 'reports') ? 'active' : '' ?>">
  <a href="#">
    <i class="fa-solid fa-scroll"></i>
    <span>Reports</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li class="<?= str_contains(Route::current()->uri, 'reports') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/reports/low-stock')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> Low Stock Products
      </a>
    </li>
    <li class="<?= str_contains(Route::current()->uri, 'reports') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/reports/out-stock')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> Out of Stock Products
      </a>
    </li>
    <?php if( Auth()->user()->role_id == 1 ) : ?>

    <li class="<?= str_contains(Route::current()->uri, 'reports') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/reports/customers')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> Customers Order Total
      </a>
    </li>
    <li class="<?= str_contains(Route::current()->uri, 'reports') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/reports/sales-report')?>">
        <i class="fa-regular fa-circle-dot fa-sm"></i> Sales Report
      </a>
    </li>

  <?php endif;?>

</ul>
</li>

<!-- Customers -->

<?php if( Auth()->user()->role_id == 1 ) : ?>

<li class="treeview <?= Request::is('admin/vendors/display') ? 'active' : '' ?> <?= Request::is('admin/vendors/edit/*') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/vendors/display')?>">

    <i class="fa fa-users"></i> <span>Vendors</span>

  </a>

</li>
<li class="treeview d-none <?= Request::is('admin/stores/display') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/stores/display')?>">

    <i class="fa fa-users"></i> <span>Stores</span>

  </a>

</li>
<li class="treeview <?= Request::is('admin/customers/display') ? 'active' : '' ?> <?= Request::is('admin/customers/edit/*') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/customers/display')?>">

    <i class="fa fa-users"></i> <span>Customers</span>

  </a>

</li>


 <li class="treeview <?= Request::is('admin/customer-wallet-history/*') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/customer-wallet-history')?>">

    <i class="fa-solid fa-wallet"></i> <span>Customer Wallet History</span>

  </a>

</li>

<li class="treeview <?= Request::is('admin/admins') ? 'active' : '' ?>">

  <a href="<?= URL::to('admin/admins')?>">

    <i class="fa fa-users"></i> <span>Admins</span>

  </a>

</li>

<?php endif;?>


<!-- Currency -->
@if(in_array(Auth::user()->role_id, [1,2]))
<li class="treeview <?= Request::is('admin/currencies/display') ? 'active' : '' ?> <?= Request::is('admin/currencies/add') ? 'active' : '' ?> <?= Request::is('admin/currencies/edit/*') ? 'active' : '' ?> <?= Request::is('admin/currencies/filter') ? 'active' : '' ?>">
  <a href="<?= URL::to('admin/currencies/display')?>">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 352c-53 0-96-43-96-96s43-96 96-96s96 43 96 96s-43 96-96 96z"/></svg><span> <?= trans('labels.currency') ?></span> 
  </a>
</li>
@endif
<!-- Tax -->
<li class="treeview d-none <?= Request::is('admin/tax/taxclass/display') ? 'active' : '' ?> <?= Request::is('admin/tax/taxclass/add') ? 'active' : '' ?> <?= Request::is('admin/tax/taxclass/edit/*') ? 'active' : '' ?> <?= Request::is('admin/tax/taxrates/display') ? 'active' : '' ?> <?= Request::is('admin/tax/taxrates/add') ? 'active' : '' ?> <?= Request::is('admin/tax/taxrates/edit/*') ? 'active' : '' ?>">
  <a href="#">
    <i class="fa-solid fa-money-bills"></i>
    <span><?= trans('labels.link_tax_location') ?></span> <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li style="display: none;" class="<?= Request::is('admin/countries/display') ? 'active' : '' ?> <?= Request::is('admin/countries/add') ? 'active' : '' ?> <?= Request::is('admin/countries/edit/*') ? 'active' : '' ?> "><a href="<?= URL::to('admin/countries/display')?>"><i class="fa-regular fa-circle-dot fa-sm"></i> <?= trans('labels.link_countries') ?></a></li>
    <li style="display: none;" class="<?= Request::is('admin/zones/display') ? 'active' : '' ?> <?= Request::is('admin/zones/add') ? 'active' : '' ?> <?= Request::is('admin/zones/edit/*') ? 'active' : '' ?>"><a href="<?= URL::to('admin/zones/display')?>"><i class="fa-regular fa-circle-dot fa-sm"></i> <?= trans('labels.link_zones') ?></a></li>
    <li class="<?= Request::is('admin/tax/taxclass/display') ? 'active' : '' ?> <?= Request::is('admin/tax/taxclass/add') ? 'active' : '' ?> <?= Request::is('admin/tax/taxclass/edit/*') ? 'active' : '' ?> "><a href="<?= URL::to('admin/tax/taxclass/display')?>"><i class="fa-regular fa-circle-dot fa-sm"></i> <?= trans('labels.link_tax_class') ?></a></li>
    <li class="<?= Request::is('admin/tax/taxrates/display') ? 'active' : '' ?> <?= Request::is('admin/tax/taxrates/add') ? 'active' : '' ?> <?= Request::is('admin/tax/taxrates/edit/*') ? 'active' : '' ?> "><a href="<?= URL::to('admin/tax/taxrates/display')?>"><i class="fa-regular fa-circle-dot fa-sm"></i> <?= trans('labels.link_tax_rates') ?></a></li>
  </ul>
</li>

<li class="treeview d-none <?= Request::is('admin/coupons/display') ? 'active' : '' ?> <?= Request::is('admin/editcoupons/*') ? 'active' : '' ?>">
  <a href="<?= URL::to('admin/coupons/display')?>" ><i class="fa fa-tablet" aria-hidden="true"></i> <span><?= trans('labels.link_coupons') ?></span></a>
</li>

<?php if( Auth()->user()->role_id == 1 ) : ?>

<li class="treeview d-none <?= Request::is('admin/inquiry/display') ? 'active' : '' ?>">

  <a href="<?=url('admin/inquiry/display')?>">
    <i class="fas fa-question"></i> <span>Inquiries</span>
  </a>
</li>


<li class="treeview <?= Request::is('admin/media/add') ? 'active' : '' ?>">

  <a href="<?=url('admin/media/add')?>">
    <i class="fa-solid fa-photo-film"></i> <span>Media</span>
  </a>
</li>

<li class="treeview {{ Request::is('admin/listingAppLabels') ? 'active' : '' }} {{ Request::is('admin/editAppLabel/*') ? 'active' : '' }}" >
    <a href="{{ URL::to('admin/listingAppLabels')}}">
      <i class="fas fa-tag" aria-hidden="true"></i>
      <span>App Labels</span>
  </a>
</li>

<li class="treeview <?= Request::is('admin/setting') ? 'active' : '' ?>" >
  <a href="javascript:;">
    <i class="fa fa-gears" aria-hidden="true"></i>
    <span>Tools</span> <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li class="<?= Request::is('admin/setting') ? 'active' : '' ?>">
      <a href="<?= URL::to('admin/setting')?>">
        <span>Settings</span>
      </a>
    </li>
  </ul>
</li>

<?php endif;?>
<li class="treeview {{ Request::is('admin/contact-form') ? 'active' : '' }} {{ Request::is('admin/design-form') ? 'active' : '' }}">
  <a href="#"><i class="fas fa-paper-plane" aria-hidden="true"></i> <span> Form Requests </span> <i class="fa fa-angle-right pull-right"></i></a>
  <ul class="treeview-menu">
    <li class="treeview {{ Request::is('admin/contact-form') ? 'active' : '' }}">
      <a href="{{ url('admin/contact-form') }}">
        <i class="fas fa-circle"></i> 
        <span>
          @if(Auth::user()->role_id == 4)
            Your Inquiries
          @else
            Contact Form
          @endif
        </span>
      </a>
    </li>
    @if(in_array(Auth::user()->role_id, [1,2]))

    <li class="treeview {{ Request::is('admin/event-inquiries') ? 'active' : '' }}">
      <a href="{{ url('admin/event-inquiries') }}">
        <i class="fas fa-circle"></i> <span>Event Inquiries</span>
      </a>
    </li>
@endif

  </ul>
</li>

</ul>
</section>
</aside>