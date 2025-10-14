<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_seminar, $obj_dosen, $obj_mahasiswa, $_can_update, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

if ($obj_seminar) {
    $obj_mahasiswa = CMahasiswa::_gi()->_get($obj_seminar->getMahasiswaNim());
    $obj_mahasiswa || $obj_mahasiswa = new MMahasiswa();
} else $obj_seminar = CSeminar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');

$obj_seminar || $obj_seminar = new MSeminar();

$obj_pengajuan = CPengajuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');
$obj_pengajuan || $obj_pengajuan = new MPengajuan();

if ($obj_pengajuan->isPengajuanStatusDiterima() || $obj_pengajuan->isPengajuanStatusSelesai()) {

    if ($_is_operator_prodi) {
        $_base_url = Helpers::_a_op(Helpers::op_seminar);
        $_base_url_persetujuan = Helpers::_a_op(Helpers::op_persetujuan);
        $_base_url_pengantar = Helpers::_a_op(Helpers::op_pengantar);
        $_base_url_pengajuan = Helpers::_a_op(Helpers::op_pengajuan);
        $_base_url_print = Helpers::_a_op(Helpers::action_print);
        $_base_url_action = Helpers::_a_op(Helpers::op_seminar, true);
    } elseif ($_is_dosen) {
        $_base_url = Helpers::_a_d(Helpers::d_seminar);
        $_base_url_persetujuan = Helpers::_a_d(Helpers::d_persetujuan);
        $_base_url_pengantar = Helpers::_a_d(Helpers::d_pengantar);
        $_base_url_pengajuan = Helpers::_a_d(Helpers::d_pengajuan);
        $_base_url_print = Helpers::_a_d(Helpers::action_print);
        $_base_url_action = Helpers::_a_d(Helpers::d_seminar, true);
    } else {
        $_base_url = Helpers::_a_m(Helpers::m_seminar);
        $_base_url_persetujuan = Helpers::_a_m(Helpers::m_persetujuan);
        $_base_url_pengantar = Helpers::_a_m(Helpers::m_pengantar);
        $_base_url_pengajuan = Helpers::_a_m(Helpers::m_pengajuan);
        $_base_url_print = Helpers::_a_m(Helpers::action_print);
        $_base_url_action = Helpers::_a_m(Helpers::m_seminar, true);
    }

    $_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

    $obj_persetujuan = CPersetujuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
    $obj_persetujuan || $obj_persetujuan = new MPersetujuan();

    $__ttd_mahasiswa = $obj_seminar->getSeminarTtd('array', $obj_mahasiswa->getMahasiswaNim());
    $__ttd_mahasiswa = Helpers::_arr($__ttd_mahasiswa, 'foto');

    $__upload_laporan = $obj_seminar->getSeminarUpload('array', 'laporan');

    $_can_update = $_can_update && ($obj_seminar->isSeminarStatusMenunggu() || $obj_seminar->isSeminarStatusDitolak());
    $_can_update = $_can_update || $_is_operator_prodi;

    $_can_sign = $_is_mahasiswa && !$obj_seminar->_empty();

    $_can_submit = $obj_seminar->isSeminarStatusMenunggu() || $obj_seminar->isSeminarStatusDitolak();
    $_can_submit = $_can_submit && $obj_seminar->_passRequiredFields();
    $_can_submit = $_can_submit && $__ttd_mahasiswa && $__upload_laporan;
    $_can_submit = $_can_submit && $_is_mahasiswa;

    $_can_print_nilai_pembimbing_lapangan = !$obj_seminar->_empty();

    $_can_print_berita_acara = $obj_seminar->hasSeminarNomor();
    $_can_print_berita_acara = $_can_print_berita_acara && ($_is_operator_prodi || $_is_dosen);

    $_statuses = [CStatus::_jenis_seminar => $obj_seminar->_empty() ? [] : CStatus::_gi()->_gets(array(
        'status_jenis' => CStatus::_jenis_seminar,
        'status_jenis_id' => $obj_seminar->getSeminarId(),
        'join_dosen' => true,
        'join_mahasiswa' => true,
        'number' => -1
    ))];

    echo Helpers::_notif_crud('Perbarui', Routes::_gi()->_depth(2), '{{action}} ' . $page_title . ' {{status}}.'); ?>

    <form action="<?php echo $_can_update ? $_base_url_action : ''; ?>"
          enctype="multipart/form-data"
          method="post"
          class="form-horizontal">

        <div class="row">
            <div class="col-md-7">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        <h5>Seminar</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label">
                                Pembimbing
                            </label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <?php echo $obj_pengajuan->getDosenNama(); ?>
                                </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="seminar_judul">
                                Judul PKL *
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="seminar_judul"
                                          name="seminar_judul"
                                          required><?php echo $obj_seminar->getSeminarJudul(); ?></textarea>
                                <small class="text-muted">
                                    Realisasi judul PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="_seminar_upload[laporan]">
                                Laporan *
                            </label>
                            <div class="col-sm-8">
                                <input type="file" id="_seminar_upload[laporan]" name="_seminar_upload[laporan]"
                                       accept=".pdf,.doc,.docx"
                                       class="form-control"/>
                                <?php if ($__upload_laporan) : ?>
                                    <a href="<?php echo $__upload_laporan; ?>" class="">
                                        <i class="fa fa-download"></i>
                                        &nbsp;Download
                                    </a>
                                    &nbsp;&mdash;&nbsp;
                                <?php endif; ?>
                                <small class="text-muted">Dokumen laporan (<code>pdf</code>,
                                    <code>doc</code>)</small>
                                <input type="hidden" name="seminar_upload[laporan]"
                                       value="<?php echo $__upload_laporan; ?>"/>
                            </div>
                        </div>

                        <?php Modals::_status($_statuses, CStatus::_jenis_seminar, $_is_operator_prodi); ?>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label">
                                Referensi
                            </label>
                            <div class="col-sm-8">
                                <p>
                                    <a href="<?php echo $_base_url_persetujuan . DS . $obj_persetujuan->getPersetujuanId(); ?>"
                                       target="_blank" class="btn btn-sm btn-success btn-outline">
                                        Persetujuan
                                        &nbsp;<i class="fa fa-external-link"></i>
                                    </a>
                                </p>
                                <p>
                                    <a href="<?php echo $_base_url_pengantar . DS . $obj_pengajuan->getPengantarId(); ?>"
                                       target="_blank" class="btn btn-sm btn-success btn-outline">
                                        Pengantar
                                        &nbsp;<i class="fa fa-external-link"></i>
                                    </a>
                                </p>
                                <p>
                                    <a href="<?php echo $_base_url_pengajuan . DS . $obj_seminar->getPengajuanId(); ?>"
                                       target="_blank" class="btn btn-sm btn-success btn-outline">
                                        Pengajuan
                                        &nbsp;<i class="fa fa-external-link"></i>
                                    </a>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="ibox-footer">
                        <small class="text-muted">
                            <code>[Mahasiswa]</code> Diisi terlebih dahulu agar dapat diproses
                        </small>
                    </div>

                </div>

                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        <h5>Upload</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">

                        <div class="row">
                            <?php foreach (CSeminar::$_upload as $_upload_key => $_upload_desc) :
                                $_upload_value = $obj_seminar->getSeminarUpload('array', $_upload_key); ?>
                                <div class="col-md-6">
                                    <label class="control-label" for="_seminar_upload[<?php echo $_upload_key; ?>]">
                                        <?php echo $_upload_desc; ?> *
                                    </label>
                                    <br/>
                                    <br/>
                                    <input type="file" id="_seminar_upload[<?php echo $_upload_key; ?>]"
                                           name="_seminar_upload[<?php echo $_upload_key; ?>]"
                                           class="form-control"/>
                                    <small class="text-muted">Format dokumen scan JPG/PNG/JPEG.</small>
                                    <?php if ($_upload_value) : ?>
                                        <br/><br/>
                                        <a href="<?php echo $_upload_value; ?>" target="_blank">
                                            <img alt="image" class="m-t-xs img-responsive"
                                                 src="<?php echo $_upload_value; ?>">
                                        </a>
                                    <?php endif; ?>
                                    <input type="hidden" name="seminar_upload[<?php echo $_upload_key; ?>]"
                                           value="<?php echo $_upload_value; ?>"/>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <div class="ibox-footer">
                        <small class="text-muted">
                            <code>[Mahasiswa]</code> Diisi terlebih dahulu agar dapat diproses
                        </small>
                    </div>

                </div>

            </div>

            <div class="col-md-5">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        <h5>Jadwal</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="seminar_nomor">
                                Nomor
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-terminal"></i></span>
                                    <input type="text" id="seminar_nomor"
                                        <?php echo $_is_operator_prodi ? 'name="seminar_nomor"' : 'disabled'; ?>
                                           value="<?php echo $obj_seminar->getSeminarNomor(); ?>"
                                           class="form-control" autocomplete="off"/>
                                </div>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Disi oleh admin
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="seminar_jam">
                                Waktu
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    <input type="text" id="seminar_jam" name="seminar_jam"
                                           value="<?php echo $obj_seminar->getSeminarJam(); ?>"
                                           class="form-control __jam" autocomplete="off"/>
                                    <span class="input-group-addon">WITA</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="seminar_tanggal">
                                Tanggal
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="seminar_tanggal" name="seminar_tanggal"
                                           value="<?php echo $obj_seminar->_empty() ? '' : $obj_seminar->getSeminarTanggal(); ?>"
                                           class="form-control __tanggal" autocomplete="off"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="seminar_tempat">
                                Tempat
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="seminar_tempat" name="seminar_tempat"
                                       class="form-control"
                                       value="<?php echo $obj_seminar->getSeminarTempat(); ?>"/>
                                <small class="text-muted">
                                    Gedung, ruangan, atau platform seminar
                                </small>
                            </div>
                        </div>

                    </div>

                    <div class="ibox-footer">
                        <small class="text-muted">
                            Isian dengan keterangan <code>[Admin]</code> hanya dapat diisi oleh Prodi.
                        </small>
                    </div>

                </div>

                <div class="ibox float-e-margins">

                    <div class="ibox-title">
                        <h5>Hasil</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">

                        <?php
                        $__nilai_dosen_pembimbing = $obj_seminar->getSeminarNilai('array', 'dosen-pembimbing', []);
                        $__nilai_dosen_pembimbing_total = Helpers::_arr($__nilai_dosen_pembimbing, 'total', 0);
                        $__nilai_pembimbing_lapangan = $obj_seminar->getSeminarNilai('array', 'pembimbing-lapangan', []);
                        $__nilai_pembimbing_lapangan_total = Helpers::_arr($__nilai_pembimbing_lapangan, 'total', 0);
                        $__nilai_total = $obj_seminar->getSeminarNilai('array', 'total', 0);
                        $__nilai_huruf = $obj_seminar->getSeminarNilai('array', 'huruf', '&mdash;');
                        ?>

                        <table class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Nilai</th>
                                <th style="text-align: center">Bobot</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Pembimbing Lapangan</th>
                                <td><?php echo $__nilai_pembimbing_lapangan_total; ?></td>
                                <td style="text-align: center">60 %</td>
                                <td>
                                    <?php if ($_is_dosen) : ?>
                                        <span class="btn btn-xs btn-primary btn-outline"
                                              data-toggle="modal" data-target="#modalNilaiPembimbingLapangan">
                                            <i class="fa fa-pencil-square-o"></i>
                                            &nbsp;Edit
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Dosen Pembimbing</th>
                                <td><?php echo $__nilai_dosen_pembimbing_total; ?></td>
                                <td style="text-align: center">40 %</td>
                                <td>
                                    <?php if ($_is_dosen) : ?>
                                        <span class="btn btn-xs btn-primary btn-outline"
                                              data-toggle="modal" data-target="#modalNilaiDosenPembimbing">
                                            <i class="fa fa-pencil-square-o"></i>
                                            &nbsp;Edit
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if ($__nilai_pembimbing_lapangan_total && $__nilai_dosen_pembimbing_total) : ?>
                                <tr>
                                    <th style="vertical-align: middle">Total</th>
                                    <th style="font-size: 24px; vertical-align: middle"><?php echo $__nilai_total; ?></th>
                                    <th style="vertical-align: middle; text-align: center">
                                        <span class="btn btn-primary"
                                              style="font-size: 18px">
                                            <?php echo $__nilai_huruf; ?>
                                        </span>
                                    </th>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="ibox-footer">
                        <small class="text-muted">
                            Nilai Dosen Pembimbing <strong>diisi langsung oleh Dosen</strong>.<br/>
                            Nilai Pembimbing Lapangan <strong>diisi oleh Dosen</strong> dengan mengacu pada <strong>dokumen
                                upload form Nilai Pembimbing Lapangan</strong> yang telah disi oleh instansi/tempat PKL.
                        </small>
                    </div>

                </div>

            </div>

        </div>

        <br/>

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

            <?php if ($_can_submit) : ?>
                &nbsp;&nbsp;
                <a class="btn btn-danger btn-outline"
                   data-toggle="modal"
                   data-target="#modalAjukan">
                    <i class="fa fa-send-o"></i>
                    &nbsp;Ajukan
                </a>
            <?php endif; ?>

            <?php if ($_can_print_nilai_pembimbing_lapangan) : ?>
                &nbsp;&nbsp;
                <a href="<?php echo $_base_url_print . DS . 'form-nilai' . DS . $obj_seminar->getSeminarId(); ?>"
                   target="_blank"
                   class="btn btn-warning">
                    <i class="fa fa-print"></i>
                    &nbsp;Form Nilai (Pembimbing Lapangan)
                </a>
            <?php endif; ?>

            <?php if ($_can_print_berita_acara) : ?>
                &nbsp;&nbsp;
                <a href="<?php echo $_base_url_print . DS . 'seminar' . DS . $obj_seminar->getSeminarId(); ?>"
                   target="_blank"
                   class="btn btn-warning">
                    <i class="fa fa-print"></i>
                    Berita Acara
                </a>
            <?php endif; ?>

        </div>

        <input type="hidden" name="_seminar_id" value="<?php echo $obj_seminar->getSeminarId(); ?>"/>

    </form>

    <?php

    if ($_can_submit)
        Modals::_ajukan(Helpers::_a_m(Helpers::m_seminar . DS . Helpers::action_submit, true),
            CStatus::_jenis_seminar, $obj_seminar->getSeminarId(), $obj_mahasiswa->getMahasiswaNim());

    if ($_can_sign)
        Modals::_ttd(Helpers::_a_m(Helpers::m_seminar . DS . Helpers::action_sign, true),
            $obj_seminar->getSeminarTtd('array', $obj_mahasiswa->getMahasiswaNim()),
            CSeminar::_id, $obj_seminar->getSeminarId(), $obj_seminar->getTaKeteranganESign(), $obj_mahasiswa->getMahasiswaNim());

//    if ($_is_dosen)
//        Modals::_verifikasi(Helpers::_a_d(Helpers::d_seminar . DS . Helpers::action_verify, true),
//            $_statuses, CStatus::_jenis_seminar, $obj_seminar->getSeminarId(), $obj_dosen->getDosenKode());

    if ($_is_dosen):

        $__nilai_dosen_pembimbing = $obj_seminar->getSeminarNilai('array', 'dosen-pembimbing', []);
        $__nilai_dosen_pembimbing_aspek = Helpers::_arr($__nilai_dosen_pembimbing, 'aspek', []); ?>
        <div class="modal inmodal fade" id="modalNilaiDosenPembimbing" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form action="<?php echo Helpers::_a_d(Helpers::d_seminar . DS . Helpers::action_grade, true); ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Dosen Pembimbing</h4>
                        </div>
                        <div class="modal-body">

                            <?php foreach (CSeminar::$_nilai_aspek_dp as $_aspek => $_v) : ?>
                                <strong class="text-success"><?php echo $_aspek; ?></strong>
                                <hr style="margin: 8px 0"/>
                                <?php foreach ($_v as $_komponen => $_max) :
                                    $__i = sprintf('_seminar_nilai[dosen-pembimbing][aspek][%s]', $_komponen);
                                    $__v_i = Helpers::_arr($__nilai_dosen_pembimbing_aspek, $_komponen); ?>
                                    <div class="form-group row">
                                        <label class="col-sm-8 control-label"
                                               for="<?php echo $__i; ?>">
                                            <?php echo $_komponen; ?>
                                        </label>
                                        <div class="col-sm-4">
                                            <div class="input-group date">
                                                <input type="number"
                                                       id="<?php echo $__i; ?>"
                                                       name="<?php echo $__i; ?>"
                                                       value="<?php echo $__v_i; ?>" min="0" max="<?php echo $_max; ?>"
                                                       step="any"
                                                       placeholder="0 &mdash; <?php echo $_max; ?>" required
                                                       class="form-control"/>
                                                <span class="input-group-addon">
                                                    <code>0 &mdash; <?php echo $_max; ?></code>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                            endforeach; ?>

                            <input type="hidden" name="seminar_id" value="<?php echo $obj_seminar->getSeminarId(); ?>"/>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        $__nilai_pembimbing_lapangan = $obj_seminar->getSeminarNilai('array', 'pembimbing-lapangan', []);
        $__nilai_pembimbing_lapangan_aspek = Helpers::_arr($__nilai_pembimbing_lapangan, 'aspek', []); ?>
        <div class="modal inmodal fade" id="modalNilaiPembimbingLapangan" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form action="<?php echo Helpers::_a_d(Helpers::d_seminar . DS . Helpers::action_grade, true); ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Pembimbing Lapangan</h4>
                        </div>
                        <div class="modal-body">

                            <?php foreach (CSeminar::$_nilai_aspek_pl as $_aspek => $_v) :
                                $__i = sprintf('_seminar_nilai[pembimbing-lapangan][aspek][%s]', $_aspek);
                                $__v_i = Helpers::_arr($__nilai_pembimbing_lapangan_aspek, $_aspek);
                                $__v_desc = Helpers::_arr($_v, 0);
                                $__v_max = Helpers::_arr($_v, 2); ?>
                                <div class="form-group row">
                                    <label class="col-sm-8 control-label"
                                           for="<?php echo $__i; ?>">
                                        <?php echo $_aspek; ?><br/>
                                        <small class="text-muted">
                                            <?php echo $__v_desc; ?>
                                        </small>
                                    </label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="number"
                                                   id="<?php echo $__i; ?>"
                                                   name="<?php echo $__i; ?>"
                                                   value="<?php echo $__v_i; ?>"
                                                   min="0" max="<?php echo $__v_max; ?>"
                                                   step="any" required
                                                   class="form-control"/>
                                            <span class="input-group-addon">
                                                    <code>0 &mdash; <?php echo $__v_max; ?></code>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <input type="hidden" name="seminar_id" value="<?php echo $obj_seminar->getSeminarId(); ?>"/>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php endif;

    if ($_is_operator_prodi)
        Modals::_verifikasi(Helpers::_a_op(Helpers::op_seminar . DS . Helpers::action_verify, true),
            $_statuses, CStatus::_jenis_seminar, $obj_seminar->getSeminarId(),
            Sessions::_gi()->_get(Helpers::dir_operator_prodi));


} else { ?>

    <div class="alert alert-danger">
        Pendaftaran Seminar hanya dapat dilakukan saat Pengajuan PKL status sudah selesai.
    </div>

<?php }