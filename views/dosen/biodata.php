<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title;

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

/** @var MDosen $obj_dosen */
$obj_dosen = Sessions::_gi()->_get(Helpers::dir_dosen, 1); ?>

<div class="ibox float-e-margins">

    <div class="ibox-title">
        <h5>Dosen</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="ibox-content">

        <form action="<?php echo Helpers::_a_m(Helpers::m_biodata, true); ?>"
              enctype="multipart/form-data"
              method="post"
              class="form-horizontal">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Kode
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenKode(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Nama
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenNama(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            NIP
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenNip(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            NIDN
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenNidn(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            No. HP
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenNomorHp(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Email
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenEmail(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Status
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_dosen->getDosenStatus(true); ?>
                            </p>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Foto
                        </label>
                        <div class="col-sm-8">
                            <?php if ($obj_dosen->hasDosenFoto()) : ?>
                                <img alt="image" class="m-t-xs img-responsive"
                                     src="<?php echo SIA_URI . '/index.php/foto/dosen/' . $obj_dosen->getDosenKode() . '/300/300/' . md5(time()); ?>">
                                <br/>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>

            <div class="text-center">
                <a class="btn btn-success" href="<?php echo SIA_URI . '/index.php/dosen'; ?>"
                   target="_blank">
                    Perbarui Data di SIA&nbsp;
                    <i class="fa fa-external-link"></i>
                </a>
            </div>

        </form>

    </div>

</div>
