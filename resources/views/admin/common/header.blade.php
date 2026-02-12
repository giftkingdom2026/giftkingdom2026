

<?php 



use App\Models\Core\Setting;



$setting = new Setting();



$result['commonContent'] = $setting->commonContent(); ?>



<header class="main-header">



  <a href="{{ URL::to('admin/dashboard')}}" class="logo">       

    <img src="<?=asset($result['commonContent']['setting']['header-logo']['path'])?>" class="logo1 w-100">
    <img src="<?=asset($result['commonContent']['setting']['favicon-image']['path'])?>" class="logo2 w-100" style="display: none;">

  </a>


  <nav class="navbar navbar-static-top">

    <a href="#" class="sidebar-toggle" id="linkid" data-toggle="offcanvas" role="button">

      <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>

    </a>

    
    <div class="navbar-custom-menu">

      <ul class="nav navbar-nav">

        <li>  

          <a target="_blank" href="{{ url('/') }}"><i class="fa fa-globe"></i> View Site</a></li>

          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">



              <span class="hidden-xs">Gift Kingdom </span>

            </a>

            <ul class="dropdown-menu">

              <!-- User image -->

              <li class="user-header">



                <p>

                 Gift Kingdom 

                 <small><?=Auth::user()->first_name?> <?=Auth::user()->last_name?></small>

               </p>

             </li>

             



             <li class="user-footer">

              <div class="pull-right d-flex justify-content-between">

    @if(in_array(Auth::user()->role_id, [1,2]))

                  <a href="<?=URL::to('admin/editadmin/'.Auth()->user()->id)?>" class="btn btn-primary btn-flat">Profile</a>
@endif
                
                <a href="{{ URL::to('admin/logout')}}" class="btn btn-primary btn-flat">Sign out</a>

              </div>



            </li>

          </ul>

        </li>

        <li>

          <a href="#" data-toggle="control-sidebar" style="display: none;"><i class="fa fa-gears"></i></a>

        </li>

      </ul>

    </div>

  </nav>

</header>