<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_pengajuan, $obj_operator, $obj_dosen, $_is_operator_prodi, $_is_dosen, $_is_sekprodi, $_is_dekan;

$_pengajuan_id = Routes::_gi()->_depth(2);

if (is_numeric($_pengajuan_id)) {

    $obj_pengajuan = CPengajuan::_gi()->_get($_pengajuan_id);
    $obj_pengajuan || $obj_pengajuan = new MPengajuan();

    Routes::_gi()->_render(1, Helpers::dir_mahasiswa . DS);

} else {

    $_max_item = 25;
    $_o_sekprodi_nip = CPengaturan::_gi()->_get('sekprodi_nip');
    $_o_dekan_nip = CPengaturan::_gi()->_get('dekan_nip');

    if ($_is_dosen) {
        $_base_url = Helpers::_a_d(Helpers::d_pengajuan);
        $_base_url_cetak = Helpers::_a_d(Helpers::action_print);
    } else {
        $_base_url = Helpers::_a_op(Helpers::op_pengajuan);
        $_base_url_cetak = Helpers::_a_op(Helpers::action_print);
    }

    $_params = Helpers::_params(array(
        'pengajuan_status' => -2,
        'dosen_kode' => '',
        'mahasiswa_nim' => '',
        'mahasiswa_nama' => '',
        'tempat_id' => -1,
        'page' => 1,
        'number' => $_max_item
    ), $_REQUEST);

    $_lists = CPengajuan::_gi()->_gets(array(
        'pengajuan_status' => $_params['pengajuan_status'],
        'dosen_kode' => $_is_dosen && !$_is_dekan ? $obj_dosen->getDosenKode() : '',
        'mahasiswa_nim' => $_params['mahasiswa_nim'],
        'mahasiswa_nama' => $_params['mahasiswa_nama'],
        'tempat_id' => $_params['tempat_id'],
        'join_pengantar' => true,
        'join_mahasiswa' => true,
        'join_tempat' => true,
        'join_dosen' => true,
        'order' => 'DESC',
        'order_by' => 'pengajuan_waktu_update',
        'offset' => ($_params['page'] - 1) * $_max_item,
        'number' => $_max_item
    ));

    $_lists_count = CPengajuan::_gi()->_count();

    $_lists_tempat = CTempat::_gi()->_gets([
        'tempat_status' => CStatus::_status_diterima,
        'number' => -1,
    ]); ?>

    <div class="ibox float-e-margins">

        <?php echo Helpers::_notif_crud(
            Routes::_gi()->_depth(2, true),
            Routes::_gi()->_depth(3),
            '{{action}} data {{status}}.'); ?>

        <div class="ibox-title">
            <h5>Pengajuan</h5>
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

            <form role="form" method="get"
                  action="<?php echo $_base_url; ?>">
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="pengajuan_status">Status</label>
                        <select id="pengajuan_status" name="pengajuan_status" class="form-control f">
                            <option value="-1">&mdash; Semua &mdash;</option>
                            <option value="-2" <?php echo $_params['pengajuan_status'] == -2 ? 'selected' : ''; ?> >
                                Umum
                            </option>
                            <?php foreach (CStatus::$_status_label as $_k => $_v) : ?>
                                <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['pengajuan_status'] ? 'selected' : ''; ?>>
                                    <?php echo $_v; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label for="mahasiswa_nim">NIM</label>
                        <input id="mahasiswa_nim" name="mahasiswa_nim" type="text" class="form-control f"
                               placeholder="Cari NIM"
                               value="<?php echo $_params['mahasiswa_nim']; ?>"/>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label for="mahasiswa_nama">Mahasiswa</label>
                        <input id="mahasiswa_nama" name="mahasiswa_nama" type="text" class="form-control f"
                               placeholder="Cari mahasiswa"
                               value="<?php echo $_params['mahasiswa_nama']; ?>"/>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label for="tempat_id">Tempat</label>
                        <select id="tempat_id" name="tempat_id" class="form-control f __select2">
                            <option value="-1">&mdash; Semua &mdash;</option>
                            <?php /** @var MTempat $_item */
                            foreach ($_lists_tempat as $_item) : ?>
                                <option value="<?php echo $_item->getTempatId(); ?>" <?php echo $_item->getTempatId() == $_params['tempat_id'] ? 'selected' : ''; ?>>
                                    <?php echo $_item->getTempatNama(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <br/>
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </div>

            </form>

            <br/><br/>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 40px">ID</th>
                        <th>Mahasiswa</th>
                        <th>Pembimbing</th>
                        <th>Tempat</th>
                        <th class="text-center">Waktu</th>
                        <th nowrap>No. Surat</th>
                        <th style="width: 100px" class="text-right">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php /** @var MPengajuan $_item */
                    foreach ($_lists as $_item):
                        $_item_ttd_sekprodi = $_item->getPengajuanTtd('array', $_o_sekprodi_nip);
                        $_item_ttd_dekan = $_item->getPengajuanTtd('array', $_o_dekan_nip);
                        $_item_surat_tugas = $_item->getPengajuanUpload('array', 'surat_tugas'); ?>
                        <tr>
                            <td><?php echo $_item->getPengajuanId(); ?></td>
                            <td>
                                <?php echo $_item->getMahasiswaNama(); ?><br/>
                                <small class="text-muted">
                                    <?php echo $_item->getMahasiswaNim(); ?>
                                </small>
                            </td>
                            <td>
                                <?php echo $_item->getDosenNama(); ?><br/>
                                <small class="text-muted">
                                    <?php echo $_item->getDosenKode(); ?>
                                </small>
                                <br/><br/>
                                <?php if ($_is_sekprodi) : ?>
                                    <span class="btn btn-xs btn-<?php echo $_item_ttd_sekprodi ? 'primary' : 'danger'; ?> btn-outline"
                                          data-toggle="modal"
                                          data-target="#modalTtd<?php echo $_item->getPengajuanId(); ?>">
                                        <i class="fa fa-<?php echo $_item_ttd_sekprodi ? 'check' : 'question'; ?>"></i>
                                        &nbsp;Ttd
                                    </span>
                                <?php endif; ?>
                                <a href="<?php echo $_base_url_cetak . DS . 'penunjukan' . DS . $_item->getPengajuanId(); ?>"
                                   class="btn btn-xs btn-primary btn-outline" target="_blank">
                                    <i class="fa fa-print"></i>
                                    &nbsp;Penujukan
                                </a>
                            </td>
                            <td>
                                <?php echo $_item->getTempatNama(); ?><br/>
                                <small class="text-muted">
                                    <?php echo $_item->getTempatAlamat(); ?>
                                </small>
                            </td>
                            <td nowrap class="text-center">
                                <?php if ($_item->getPengajuanBimbinganTanggalMulai()) : ?>
                                    <?php echo $_item->getPengajuanBimbinganTanggalMulai(); ?>
                                    <br/><span class="text-info">s/d</span><br/>
                                    <?php echo $_item->getPengajuanBimbinganTanggalSelesai(); ?>
                                <?php endif; ?>
                            </td>
                            <td nowrap>
                                <?php if ($_item->hasPengajuanNomor()) { ?>
                                    <p><?php echo $_item->getPengajuanNomor(true); ?></p>

                                    <?php if ($_is_dekan) : ?>
                                        <span class="btn btn-xs btn-<?php echo $_item_ttd_dekan ? 'primary' : 'danger'; ?> btn-outline"
                                              data-toggle="modal"
                                              data-target="#modalTtd<?php echo $_item->getPengajuanId(); ?>">
                                            <i class="fa fa-<?php echo $_item_ttd_dekan ? 'check' : 'question'; ?>"></i>
                                            &nbsp;Ttd
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($_item_ttd_dekan) : ?>
                                        <a href="<?php echo $_base_url_cetak . DS . 'surat-tugas' . DS . $_item->getPengajuanId(); ?>"
                                           class="btn btn-xs btn-primary btn-outline" target="_blank">
                                            <i class="fa fa-print"></i>
                                            &nbsp;Surat Tugas
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($_item_surat_tugas) : ?>
                                        <a href="<?php echo $_item_surat_tugas; ?>"
                                           class="btn btn-xs btn-primary btn-outline" target="_blank">
                                            <i class="fa fa-download"></i>
                                            &nbsp;Surat Tugas
                                        </a>
                                    <?php endif; ?>

                                <?php } ?>
                            </td>
                            <td class="text-right">
                                <span class="btn btn-sm btn-<?php echo Helpers::_arr(CStatus::$_status_color, $_item->getPengajuanStatus()); ?>"
                                      data-toggle="modal"
                                      data-target="#modalVerifikasi<?php echo $_item->getPengajuanId(); ?>">
                                    <?php echo Helpers::_arr(CStatus::$_status_label, $_item->getPengajuanStatus()); ?>
                                </span>
                                <br/>
                                <a href="<?php echo $_base_url . DS . $_item->getPengajuanId(); ?>"
                                   target="_blank"
                                   class="btn btn-xs btn-primary btn-outline">
                                    Detail&nbsp;
                                    <i class="fa fa-external-link"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ibox-footer">
            <?php echo Helpers::_paging($_base_url . '?' . http_build_query($_params), $_lists_count, $_params['page'], $_max_item, 3); ?>
            <div class="clearfix"></div>
        </div>
    </div>

    <?php

    /** @var MPengajuan $_item */
    foreach ($_lists as $_item) {

        if ($_is_operator_prodi) {

            Modals::_verifikasi_list(Helpers::_a_op(Helpers::op_pengajuan . DS . Helpers::action_verify, true),
                CStatus::_jenis_pengajuan, $_item->getPengajuanId(), $_item->getPengajuanStatus(), $obj_operator->getOperatorId());

            if ($_is_sekprodi)
                Modals::_ttd_list(Helpers::_a_op(Helpers::op_pengajuan . DS . Helpers::action_sign, true),
                    $_item->getPengajuanTtd('array', $obj_operator->getOperatorId()),
                    CPengajuan::_id, $_item->getPengajuanId(), $_item->getTaKeteranganESign('Penunjukan Dosen Pembimbing'), $obj_operator->getOperatorId());

        }

        if ($_is_dekan) {

            Modals::_verifikasi_list(Helpers::_a_d(Helpers::d_pengajuan . DS . Helpers::action_verify, true),
                CStatus::_jenis_pengajuan, $_item->getPengajuanId(), $_item->getPengajuanStatus(), $obj_dosen->getDosenKode());

            Modals::_ttd_list(Helpers::_a_d(Helpers::d_pengajuan . DS . Helpers::action_sign, true),
                $_item->getPengajuanTtd('array', $obj_dosen->getDosenKode()),
                CPengajuan::_id, $_item->getPengajuanId(), $_item->getTaKeteranganESign('Surat Tugas'), $obj_dosen->getDosenKode());

        }
    }

}