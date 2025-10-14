<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

?>

<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">

        <?php Helpers::_li_lang(); ?>

        <li>
            <a href="<?php echo Helpers::_a(Helpers::page_keluar); ?>">
                <i class="fa fa-sign-out"></i> <?php __('Keluar'); ?>
            </a>
        </li>

    </ul>

</nav>
