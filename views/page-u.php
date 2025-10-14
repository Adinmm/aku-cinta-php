<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

echo Helpers::_banner2();

ob_start('minify_HTML'); ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo APP_NAME; ?> | <?php echo APP_AUTHOR; ?></title>

    <link href="<?php echo URI_CSS_PATH; ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/font-awesome.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/animate.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/style.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="<?php echo URI_IMG_PATH; ?>/fav.png" sizes="16x16"/>

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <img alt="<?php echo APP_NAME; ?>" src="<?php echo URI_IMG_PATH; ?>/logo.png"/>
        </div>
        <br/>
        <h3><?php echo APP_NAME; ?></h3>
        <p><?php echo APP_AUTHOR; ?></p>
        <hr/>
        <?php Routes::_gi()->_render(1, Helpers::dir_umum . DS); ?>
        <br/>
        <p class="text-left">
            <a href="<?php echo URI_PATH; ?>">
                <i class="fa fa-angle-double-left"></i>
                &nbsp;Kembali
            </a>
        </p>
    </div>
</div>

<script src="<?php echo URI_JS_PATH; ?>/jquery-2.1.1.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/bootstrap.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/jasny/jasny-bootstrap.min.js"></script>

</body>

</html>
