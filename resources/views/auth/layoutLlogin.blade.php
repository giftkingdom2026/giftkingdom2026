<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>The Gift Kingdom</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="<?=asset('assets/images/fav-icon.png')?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" type="text/css" href="<?=asset('assets/css/slick.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=asset('assets/css/slick-theme.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=asset('assets/css/default.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=asset('assets/css/style.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=asset('assets/css/responsive.css')?>">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<?php
use App\Models\Core\Setting;

$setting = new Setting();

$result['commonContent'] = $setting->commonContent(); ?>

<div class="wrapper">

    @yield('content');

</div>

</body>
</html>
