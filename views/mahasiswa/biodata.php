<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title;

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

/** @var MMahasiswa $obj_mahasiswa */
$obj_mahasiswa = Sessions::_gi()->_get(Helpers::dir_mahasiswa, 1); ?>

<div class="ibox float-e-margins">

    <div class="ibox-title">
        <h5>Mahasiswa</h5>
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
                            NIM
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->getMahasiswaNim(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Nama
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->getMahasiswaNama(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            No. HP
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->getMahasiswaNomorHp(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Email
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->getMahasiswaEmail(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Kuliah
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->hasMahasiswaKuliah() ? $obj_mahasiswa->getMahasiswaKuliah() : '&nbsp;&mdash;&nbsp;'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            Dosen PA
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->getDosenPaNama(); ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">
                            NIP Dosen PA
                        </label>
                        <div class="col-sm-8">
                            <p class="form-control-static">
                                <?php echo $obj_mahasiswa->getDosenPaNip(); ?>
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
                            <?php if ($obj_mahasiswa->hasMahasiswaFoto()) : ?>
                                <img alt="image" class="m-t-xs img-responsive"
                                     src="<?php echo SIA_URI . '/index.php/foto/mahasiswa/' . $obj_mahasiswa->getMahasiswaNim() . '/300/300/' . md5(time()); ?>">
                                <br/>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>

            <div class="text-center">
                <a class="btn btn-success" href="<?php echo SIA_URI . '/index.php/mahasiswa'; ?>"
                   target="_blank">
                    Perbarui Data di SIA&nbsp;
                    <i class="fa fa-external-link"></i>
                </a>
            </div>

        </form>

    </div>

</div>
