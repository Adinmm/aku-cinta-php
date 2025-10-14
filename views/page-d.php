<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $_dir, $obj_dosen, $_is_dosen, $_is_dekan;

$_dir = Helpers::dir_dosen;
Sessions::_gi()->_auth($_dir);

if (!$page_title = Routes::_gi()->_depth(1, true))
    Helpers::_redirect();

$obj_dosen = Sessions::_gi()->_get($_dir, 1);
$_is_dosen = Sessions::_gi()->_has($_dir);
$_is_dekan = $obj_dosen->getDosenKode() == CPengaturan::_gi()->_get('dekan_nip');

switch (Routes::_gi()->_depth(1)) {
    case Helpers::page_aksi:
    case Helpers::action_print:
        Routes::_gi()->_render(1, $_dir . DS);
        break;
}

Helpers::_header();
Helpers::_sidebar($_dir); ?>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <?php include_once 'header-nav.php'; ?>
        </div>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-md-6">
                <h2><?php echo $page_title; ?></h2>
            </div>
            <div class="col-md-6">
                <div class="pmb-breadcrumb">
                    <?php echo Helpers::_breadcrumb($page_title); ?>
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <?php Routes::_gi()->_render(1, $_dir . DS); ?>

        </div>
    </div>

<?php Helpers::_footer();