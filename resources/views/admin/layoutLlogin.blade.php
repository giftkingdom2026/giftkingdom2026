<!DOCTYPE html>

<html>

@include('admin.common.meta')

<body class="hold-transition login-page">
<?php
use App\Models\Core\Setting;

$setting = new Setting();

$result['commonContent'] = $setting->commonContent();
?>

    @yield('content');

@include('admin.common.scripts')


</body>

</html>

