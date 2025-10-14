<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_persetujuan, $obj_mahasiswa, $_can_update, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

if ($obj_persetujuan) {
    $obj_mahasiswa = CMahasiswa::_gi()->_get($obj_persetujuan->getMahasiswaNim());
    $obj_mahasiswa || $obj_mahasiswa = new MMahasiswa();
} else $obj_persetujuan = CPersetujuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');

$obj_persetujuan || $obj_persetujuan = new MPersetujuan();

$__transkrip = $obj_persetujuan->getPersetujuanUpload('array', 'transkrip_nilai');
$__krs_terakhir = $obj_persetujuan->getPersetujuanUpload('array', 'krs_terakhir');

$__ttd_mahasiswa = $obj_persetujuan->getPersetujuanTtd('array', $obj_mahasiswa->getMahasiswaNim());
$__ttd_mahasiswa = Helpers::_arr($__ttd_mahasiswa, 'foto');

$_can_update = $_can_update && ($obj_persetujuan->isPersetujuanStatusMenunggu() || $obj_persetujuan->isPersetujuanStatusDitolak());
$_can_update = $_can_update && $_is_mahasiswa;

$_can_sign = !$obj_persetujuan->_empty() && $_is_mahasiswa;
$_can_sign = $_can_sign && $__transkrip && $__krs_terakhir;

$_can_ajukan = !$obj_persetujuan->_empty() && !$obj_persetujuan->isPersetujuanStatusDiajukan() && !$obj_persetujuan->isPersetujuanStatusDiterima();
$_can_ajukan = $_can_ajukan && $_is_mahasiswa;
$_can_ajukan = $_can_ajukan && $__ttd_mahasiswa;

$_can_print = $obj_persetujuan->isPersetujuanStatusDiterima();
$_can_print = $_can_print && $_is_mahasiswa;

$_statuses = [CStatus::_jenis_persetujuan => $obj_persetujuan->_empty() ? [] : CStatus::_gi()->_gets(array(
    'status_jenis' => CStatus::_jenis_persetujuan,
    'status_jenis_id' => $obj_persetujuan->getPersetujuanId(),
    'join_dosen' => true,
    'join_mahasiswa' => true,
    'number' => -1
))];

?>

    <div class="ibox float-e-margins">

        <?php echo Helpers::_notif_crud('Perbarui', Routes::_gi()->_depth(2), '{{action}} ' . $page_title . ' {{status}}.'); ?>

        <div class="ibox-title">
            <h5><?php echo $page_title; ?></h5>
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

            <form action="<?php echo $_can_update ? Helpers::_a_m(Helpers::m_persetujuan, true) : ''; ?>"
                  enctype="multipart/form-data"
                  method="post"
                  class="form-horizontal">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="persetujuan_tahun_akademik">
                                Tahun
                            </label>
                            <div class="col-sm-4">
                                <?php if ($_is_operator_prodi) : ?>
                                    <input type="text" id="persetujuan_tahun_akademik" name="persetujuan_tahun_akademik"
                                           class="form-control" data-mask="99999"
                                           value="<?php echo $obj_persetujuan->getPersetujuanTahunAkademik(); ?>"/>
                                <?php elseif ($obj_persetujuan->_empty()) : ?>
                                    <p class="form-control-static">
                                        <?php echo $_o_tahun_akademik_aktif; ?>
                                    </p>
                                    <input type="hidden" name="persetujuan_tahun_akademik"
                                           value="<?php echo $_o_tahun_akademik_aktif; ?>"/>
                                <?php else : ?>
                                    <p class="form-control-static">
                                        <?php echo $obj_persetujuan->getPersetujuanTahunAkademik(); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="dosen_kode">
                                Dosen PA
                            </label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <?php echo $obj_mahasiswa->getDosenPaNama(); ?>
                                </p>
                                <small class="text-muted">
                                    <?php echo $obj_mahasiswa->getDosenPaNip(); ?>
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="persetujuan_data[jumlah_sks]">
                                Jumlah SKS
                            </label>
                            <div class="col-sm-8 col-lg-4">
                                <input type="text" id="persetujuan_data[jumlah_sks]" name="persetujuan_data[jumlah_sks]"
                                       class="form-control"
                                       value="<?php echo $obj_persetujuan->getPersetujuanData('array', 'jumlah_sks'); ?>"/>
                                <small class="text-muted">
                                    Sesuai transkrip
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="persetujuan_data[ipk_terakhir]">
                                IPK Terakhir
                            </label>
                            <div class="col-sm-8 col-lg-4">
                                <input type="text" id="persetujuan_data[ipk_terakhir]"
                                       name="persetujuan_data[ipk_terakhir]"
                                       class="form-control"
                                       value="<?php echo $obj_persetujuan->getPersetujuanData('array', 'ipk_terakhir'); ?>"/>
                                <small class="text-muted">
                                    Sesuai transkrip
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="persetujuan_data[pkl_ke]">
                                PKL ke-
                            </label>
                            <div class="col-sm-4">
                                <input type="text" id="persetujuan_data[pkl_ke]" name="persetujuan_data[pkl_ke]"
                                       class="form-control"
                                       value="<?php echo $obj_persetujuan->getPersetujuanData('array', 'pkl_ke', 1); ?>"/>
                            </div>
                        </div>

                        <?php Modals::_status($_statuses, CStatus::_jenis_persetujuan, ($_is_dosen || $_is_operator_prodi)); ?>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="_persetujuan_upload[transkrip_nilai]">
                                Transkrip Nilai *
                            </label>
                            <div class="col-sm-8">
                                <input type="file" id="_persetujuan_upload[transkrip_nilai]"
                                       name="_persetujuan_upload[transkrip_nilai]"
                                       class="form-control"/>
                                <small class="text-muted">Format dokumen scan JPG/PNG/JPEG.</small>
                                <?php if ($__transkrip) : ?>
                                    <br/><br/>
                                    <a href="<?php echo $__transkrip; ?>" target="_blank">
                                        <img alt="image" class="m-t-xs img-responsive"
                                             src="<?php echo $__transkrip; ?>">
                                    </a>
                                <?php endif; ?>
                                <input type="hidden" name="persetujuan_upload[transkrip_nilai]"
                                       value="<?php echo $__transkrip; ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="_persetujuan_upload[krs_terakhir]">
                                KRS Terakhir *
                            </label>
                            <div class="col-sm-8">
                                <input type="file" id="_persetujuan_upload[krs_terakhir]"
                                       name="_persetujuan_upload[krs_terakhir]"
                                       class="form-control"/>
                                <small class="text-muted">Format dokumen scan JPG/PNG/JPEG.</small>
                                <?php if ($__krs_terakhir) : ?>
                                    <br/><br/>
                                    <a href="<?php echo $__krs_terakhir; ?>" target="_blank">
                                        <img alt="image" class="m-t-xs img-responsive"
                                             src="<?php echo $__krs_terakhir; ?>">
                                    </a>
                                <?php endif; ?>
                                <input type="hidden" name="persetujuan_upload[krs_terakhir]"
                                       value="<?php echo $__krs_terakhir; ?>"/>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="text-center">
                    <br/><br/>

                    <?php if ($_can_update) : ?>
                        <button class="btn btn-success btn-outline">
                            <i class="fa fa-cloud-upload"></i>
                            &nbsp;Simpan
                        </button>
                    <?php endif; ?>

                    <?php if ($_can_sign) : ?>
                        &nbsp;&nbsp;
                        <a class="btn btn-<?php echo $__ttd_mahasiswa ? 'success' : 'danger'; ?> btn-outline"
                           data-toggle="modal"
                           data-target="#modalTandaTangan">
                            <i class="fa fa-<?php echo $__ttd_mahasiswa ? 'check' : 'xing'; ?>"></i>
                            &nbsp;Tanda Tangan
                        </a>
                    <?php endif; ?>

                    <?php if ($_can_ajukan) : ?>
                        &nbsp;&nbsp;
                        <a class="btn btn-danger btn-outline"
                           data-toggle="modal"
                           data-target="#modalAjukan">
                            <i class="fa fa-send-o"></i>
                            &nbsp;Ajukan
                        </a>
                    <?php endif; ?>

                    <?php if ($_can_print) : ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo Helpers::_a_m(Helpers::action_print . DS . 'persetujuan' . DS . $obj_persetujuan->getPersetujuanId()); ?>"
                           target="_blank"
                           class="btn btn-info">
                            <i class="fa fa-print"></i>
                            &nbsp;Persetujuan Dosen
                        </a>
                    <?php endif; ?>

                </div>

                <input type="hidden" name="persetujuan_id" value="<?php echo $obj_persetujuan->getPersetujuanId(); ?>"/>

            </form>

        </div>

        <div class="ibox-footer">
            <ul>
                <li>
                    Isian wajib (*) harus diisi, jika belum melengkapi semua isian wajib maka permohonan tidak dapat
                    diproses
                </li>
                <li>
                    Form persetujuan dosen PA dapat dicetak setelah ditandatangani.
                </li>
                <li>
                    Setiap upload scan dokumen pendukung mahasiswa wajib menekan tombol ajukan.
                </li>
            </ul>
        </div>

    </div>

<?php

if ($_can_sign)
    Modals::_ttd(Helpers::_a_m(Helpers::m_persetujuan . DS . Helpers::action_sign, true),
        $obj_persetujuan->getPersetujuanTtd('array', $obj_mahasiswa->getMahasiswaNim()),
        CPersetujuan::_id, $obj_persetujuan->getPersetujuanId(), $obj_persetujuan->getTaKeteranganESign(), $obj_mahasiswa->getMahasiswaNim());

if ($_can_ajukan)
    Modals::_ajukan(Helpers::_a_m(Helpers::m_persetujuan . DS . Helpers::action_submit, true),
        CStatus::_jenis_persetujuan, $obj_persetujuan->getPersetujuanId(), $obj_mahasiswa->getMahasiswaNim());

if ($_is_dosen)
    Modals::_verifikasi(Helpers::_a_d(Helpers::d_persetujuan . DS . Helpers::action_verify, true),
        $_statuses, CStatus::_jenis_persetujuan, $obj_persetujuan->getPersetujuanId(),
        Sessions::_gi()->_get(Helpers::dir_dosen));

if ($_is_operator_prodi)
    Modals::_verifikasi(Helpers::_a_op(Helpers::op_persetujuan . DS . Helpers::action_verify, true),
        $_statuses, CStatus::_jenis_persetujuan, $obj_persetujuan->getPersetujuanId(),
        Sessions::_gi()->_get(Helpers::dir_operator_prodi));