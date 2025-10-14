<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title;

$_styles = array(
    'bootstrap.min.css',
    'font-awesome.css',
    'plugins/datapicker/datepicker3.css',
    'plugins/clockpicker/clockpicker.css',
    'plugins/jasny/jasny-bootstrap.min.css',
    'plugins/select2/select2.min.css',
    'plugins/iCheck/custom.css',
    'plugins/ladda/ladda-themeless.min.css',
    'animate.css',
    'style.css',
    'custom.css?v=20200508',
);

$_scripts = array(
    'jquery-2.1.1.js',
    'bootstrap.min.js',
    'plugins/metisMenu/jquery.metisMenu.js',
    'plugins/clockpicker/clockpicker.js',
    'plugins/slimscroll/jquery.slimscroll.min.js',
    'inspinia.js',
    'plugins/pace/pace.min.js',
    'plugins/jquery-ui/jquery-ui.min.js',
    'plugins/peity/jquery.peity.min.js',
    'plugins/sparkline/jquery.sparkline.min.js',
    'plugins/datapicker/bootstrap-datepicker.js',
    'plugins/jasny/jasny-bootstrap.min.js',
    'plugins/select2/select2.full.min.js',
    'plugins/iCheck/icheck.min.js',
    'plugins/ladda/spin.min.js',
    'plugins/ladda/ladda.min.js',
    'plugins/ladda/ladda.jquery.min.js',
    'script.js?v=20200508'
);

echo Helpers::_banner2();

//ob_start('minify_HTML'); ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $page_title ? $page_title . ' | ' . APP_NAME : APP_NAME . ' | ' . APP_AUTHOR; ?></title>

    <?php foreach ($_styles as $_style) : ?>
        <link href="<?php echo URI_CSS_PATH . DS . $_style; ?>" rel="stylesheet">
    <?php endforeach; ?>

    <link rel="shortcut icon" type="image/png" href="<?php echo URI_IMG_PATH; ?>/fav.png" sizes="16x16"/>

    <?php foreach ($_scripts as $_script) : ?>
        <script src="<?php echo URI_JS_PATH . DS . $_script; ?>"></script>
    <?php endforeach; ?>

</head>

<body>
<div id="wrapper">