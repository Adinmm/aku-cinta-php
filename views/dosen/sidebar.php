<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $_is_dekan;

if ($_is_dekan)
    $_menus = array(
        array(Helpers::d_biodata, 'fa-user'),
        array(Helpers::d_pengantar, 'fa-code-fork'),
        array(Helpers::d_pengajuan, 'fa-list-alt'),
    );
else $_menus = array(
    array(Helpers::d_biodata, 'fa-user'),
    array(Helpers::d_bimbingan, 'fa-comments'),
    array(Helpers::d_persetujuan, 'fa-check-square-o'),
    array(Helpers::d_pengajuan, 'fa-list-alt'),
    array(Helpers::d_seminar, 'fa-slideshare'),
    array(Helpers::d_tempat, 'fa-map-marker'),
);

/** @var MDosen $obj_dosen */
$obj_dosen = Sessions::_gi()->_get(Helpers::dir_dosen, 1); ?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element text-center">
                    <a href="<?php echo Helpers::_a(Helpers::page_beranda); ?>">
                        <img alt="image" class="img-rounded" src="<?php echo $obj_dosen->getDosenFoto2(100, 100); ?>"
                             style="max-width: 75px"/>
                        <span class="clear">
                            <br/>
                            <span class="block m-t-xs">
                                <strong class="font-bold">
                                    <?php echo $obj_dosen->getDosenNama(); ?>
                                </strong>
                            </span>
                            <br/>
                            <span class="text-muted text-xs block">
                                <?php echo $obj_dosen->getDosenKode(); ?>
                            </span>
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
                    <a href="<?php echo Helpers::_a_d($_page); ?>">
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
