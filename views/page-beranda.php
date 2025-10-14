<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

echo Helpers::_banner2();

$_pengumuman = CPengaturan::_gi()->_get('pengumuman');

ob_start('minify_HTML'); ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo APP_NAME; ?> | <?php echo APP_AUTHOR; ?></title>

    <link href="<?php echo URI_CSS_PATH; ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/font-awesome.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/animate.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/style.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/custom.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="<?php echo URI_IMG_PATH; ?>/fav.png" sizes="16x16"/>

</head>
<body id="page-top" class="landing-page">
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo URI_PATH; ?>">
                    <?php __(APP_INITIAL); ?>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="page-scroll" href="<?php echo URI_PATH; ?>"><?php __('Beranda'); ?></a></li>
                    <?php Helpers::_li_lang(); ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1 class="wow zoomIn animated">
                        <?php __(APP_NAME); ?>
                    </h1>
                    <p class="wow zoomIn animated">
                        <?php __(APP_DESCRIPTION); ?>
                    </p>
                    <br/>
                    <?php if ($_pengumuman) : ?>
                        <div class="alert alert-info" style="text-shadow: none">
                            <?php echo $_pengumuman; ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <br/>
                        <a class="btn btn-lg btn-success"
                           href="<?php echo Helpers::_sso(); ?>">
                            <i class="fa fa-lock"></i>
                            &nbsp;<?php __('Masuk'); ?>
                        </a>
                        &nbsp;&nbsp;
                        <a class="btn btn-lg btn-warning" target="_blank"
                           href="https://cloud.unram.ac.id/index.php/s/sAHEKpoYo9yQLje">
                            <i class="fa fa-file-pdf-o"></i>
                            &nbsp;<?php __('SOP'); ?>
                        </a>
                    </div>
                </div>
                <div class="carousel-image wow zoomIn animated">
                    <img src="<?php echo URI_IMG_PATH; ?>/pkl.png"
                         alt="<?php echo APP_NAME; ?>">
                </div>
            </div>
            <div class="header-back"></div>
        </div>
    </div>
</div>

<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>
                    <?php __('Hubungi Kami'); ?>
                </h1>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-3 col-lg-offset-3">
                <address>
                    <?php __('Gedung A Lantai 2 Fakultas Teknik'); ?><br/>
                    <?php __('Jl. Majapahit No. 62, Mataram'); ?><br/>
                    NTB (Nusa Tenggara Barat)
                    <br/><br/>
                    <abbr title="Telephone"><i class="fa fa-phone"></i></abbr>&nbsp;&nbsp;<?php __('Telp'); ?>: <a
                            href="tel:+62370631712">(0370) 631712</a><br/>
                    <abbr title="Email"><i class="fa fa-envelope"></i></abbr>&nbsp;&nbsp;Email: <a
                            href="mailto:if@unram.ac.id">if@unram.ac.id</a><br/>
                </address>
            </div>
            <div class="col-lg-4">
                <p class="text-color">
                    <?php __('Jika memiliki pertanyaan atau mengalami kendala selama proses pengisian silakan menghubungi kami melalui beberapa jalur yang tertera.'); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p><strong>&copy; 2023 &mdash; <?php __(APP_AUTHOR); ?></strong></p>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo URI_JS_PATH; ?>/jquery-2.1.1.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/bootstrap.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/inspinia.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/pace/pace.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/wow/wow.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/beranda.js"></script>


</body>
</html>
