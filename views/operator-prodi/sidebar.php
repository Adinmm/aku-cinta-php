<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $_dir;

$_menus = array(
    array(Helpers::op_bimbingan, 'fa-comments'),
    array(Helpers::op_persetujuan, 'fa-check-square-o'),
    array(Helpers::op_pengantar, 'fa-code-fork'),
    array(Helpers::op_pengajuan, 'fa-list-alt'),
    array(Helpers::op_seminar, 'fa-slideshare'),
    array(Helpers::op_tempat, 'fa-map-marker'),
    array(Helpers::op_statistik, 'fa-pie-chart'),
    array(Helpers::op_pengaturan, 'fa-cogs'),
);

/** @var MOperator $obj_operator */
$obj_operator = Sessions::_gi()->_get($_dir, 1); ?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element text-center">
                    <a href="<?php echo Helpers::_a(Helpers::page_beranda); ?>">
                        <img alt="image" class="img-circle" src="<?php echo URI_IMG_PATH; ?>/logo.png"
                             style="max-width: 75px"/>
                        <span class="clear">
                            <br/>
                            <span class="block m-t-xs">
                                <strong class="font-bold">
                                    <?php echo $obj_operator->getOperatorNama(); ?>
                                </strong>
                            </span>
                            <br/>
                            <span class="text-muted text-xs block">
                                <?php echo $obj_operator->getOperatorUsername(); ?>
                            </span>
                            <br/>
                            <a href="<?php echo Helpers::_a_op(Helpers::page_akun); ?>"
                               class="btn btn-sm btn-warning btn-outline">
                                <i class="fa fa-pencil"></i>&nbsp;&nbsp;Akun
                            </a>
                        </span>
                    </a>
                </div>
                <div class="logo-element">
                    <?php echo APP_INITIAL; ?>
                </div>
            </li>

            <?php foreach ($_menus as $_menu) :
                list($_page, $_icon) = $_menu;
                $_page2 = Helpers::_camel_case($_page); ?>
                <li class="<?php echo $_page2 == $page_title ? 'active' : ''; ?>">
                    <a href="<?php echo Helpers::_a_op($_page); ?>">
                        <i class="fa <?php echo $_icon; ?>"></i>
                        <span class="nav-label">
                            <?php echo $_page2; ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>

        </ul>

    </div>
</nav>
