<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title;

$_menus = array(
    array(Helpers::m_biodata, 'fa-user'),
    array(Helpers::m_bimbingan, 'fa-comments'),
    array(Helpers::m_persetujuan, 'fa-check-square-o'),
    array(Helpers::m_pengantar, 'fa-code-fork'),
    array(Helpers::m_pengajuan, 'fa-list-alt'),
    array(Helpers::m_seminar, 'fa-slideshare'),
    array(Helpers::m_tempat, 'fa-map-marker'),
    array('logbook', 'fa-book'), // Tambahkan menu Logbook setelah Tempat
);

/** @var MMahasiswa $obj_mahasiswa */
$obj_mahasiswa = Sessions::_gi()->_get(Helpers::dir_mahasiswa, 1); ?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element text-center">
                    <a href="<?php echo Helpers::_a(Helpers::page_beranda); ?>">
                        <img alt="image" class="img-rounded"
                             src="<?php echo $obj_mahasiswa->getMahasiswaFoto2(100, 100); ?>"
                             style="max-width: 75px"/>
                        <span class="clear">
                            <br/>
                            <span class="block m-t-xs">
                                <strong class="font-bold">
                                    <?php echo $obj_mahasiswa->getMahasiswaNama(); ?>
                                </strong>
                            </span>
                            <br/>
                            <span class="text-muted text-xs block">
                                <?php echo $obj_mahasiswa->getMahasiswaNim(); ?>
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
                    <a href="<?php echo Helpers::_a_m($_page); ?>">
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
