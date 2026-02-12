<?php
use App\Models\Core\Setting;
$sett = Setting::getWebSettings();
?>

<html>
<head>
    <title><?= isset($title) ? $title : '' ?></title>
</head>

<body>

<!-- Main Wrapper -->
<table style="font-size:13px; width:720px; margin:40px auto; background:#fff; border-spacing:0; font-family:'Arial', sans-serif;">
    <tbody>

        <!-- Logo -->
        <tr>
            <td style="text-align:center; padding-bottom:25px;">
                <img style="width:32%; margin:auto; display:block;"
                     src="<?= asset('https://v5.digitalsetgo.com/gift-kingdom/public/images/media/2025/02/logo.svg') ?>">
            </td>
        </tr>

        <!-- Title Section -->
        <tr style="background-color:#6c7d36;">
            <td style="padding:25px 20px;">
                <h2 style="text-align:center; font-weight:500; font-size:22px; color:#fff; margin:0 0 10px 0;">
                    Dear <?= $data->first_name ?> <?= $data->last_name ?>
                </h2>

                <p style="text-align:center; line-height:1.5; color:#fff; margin:0;">
                    Thank you for choosing Gift Kingdom, your Trusted Online Shopping Partner!
                </p>
            </td>
        </tr>

        <!-- Body Text -->
        <tr>
            <td style="padding:25px 20px;">

                <p style="text-align:center; line-height:1.5; color:#000; margin:0 0 15px 0;">
                    A password reset request has been made for your <?= $sett['site-name'] ?> account
                    <b style="color:#101010">(<?= $data->email ?>)</b>.
                </p>

                <p style="text-align:center; line-height:1.5; color:#000; margin:0 0 15px 0;">
                    Here is your reset password link:
                    <a style="color:#fff; border-radius:4px; font-size:16px; padding:0.25rem 0.5rem; background:#6c7d36; border:none;"
                       href="<?= asset('reset-password/' . $data->user_name) ?>">
                        Reset Password
                    </a>
                </p>

                <p style="text-align:center; line-height:1.5; color:#000; margin:0;">
                    If you did not request a password reset, kindly ignore this email.
                </p>

            </td>
        </tr>

        <!-- Footer -->
        <tr style="background-color:#6c7d36;">
            <td style="text-align:center; padding:25px 20px;">
                <p style="margin:0; color:#fff;"><?= $sett['site-name'] ?></p>
                <p style="margin:5px 0; color:#fff;"><?= $sett['address'] ?></p>
                <p style="margin:0; color:#fff;"><?= $sett['phone'] ?></p>
            </td>
        </tr>

    </tbody>
</table>

</body>
</html>
