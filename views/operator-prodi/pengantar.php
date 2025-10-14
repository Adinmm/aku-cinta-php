<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_pengantar, $obj_operator, $obj_dosen, $_is_operator_prodi, $_is_dosen, $_is_dekan;

$_pengantar_id = Routes::_gi()->_depth(2);

if (is_numeric($_pengantar_id)) {

    $obj_pengantar = CPengantar::_gi()->_get($_pengantar_id);
    $obj_pengantar || $obj_pengantar = new MPengantar();

    Routes::_gi()->_render(1, Helpers::dir_mahasiswa . DS);

} else {

    $_max_item = 25;
    $_o_dekan_nip = CPengaturan::_gi()->_get('dekan_nip');

    if ($_is_dosen) {
        $_base_url = Helpers::_a_d(Helpers::d_pengantar);
        $_base_url_cetak = Helpers::_a_d(Helpers::action_print);
    } else {
        $_base_url = Helpers::_a_op(Helpers::op_pengantar);
        $_base_url_cetak = Helpers::_a_op(Helpers::action_print);
    }

    $_params = Helpers::_params(array(
        'pengantar_status' => -2,
        'mahasiswa_nim' => '',
        'mahasiswa_nama' => '',
        'tempat_id' => -1,
        'page' => 1,
        'number' => $_max_item
    ), $_REQUEST);

    $_lists = CPengantar::_gi()->_gets(array(
        'pengantar_status' => $_params['pengantar_status'],
        'mahasiswa_nim' => $_params['mahasiswa_nim'],
        'mahasiswa_nama' => $_params['mahasiswa_nama'],
        'tempat_id' => $_params['tempat_id'],
        'join_mahasiswa' => true,
        'join_tempat' => true,
        'order' => 'DESC',
        'order_by' => 'pengantar_waktu_update',
        'offset' => ($_params['page'] - 1) * $_max_item,
        'number' => $_max_item
    ));

    $_lists_count = CPengantar::_gi()->_count();

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
            <h5>Pengantar</h5>
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
                        <label for="pengantar_status">Status</label>
                        <select id="pengantar_status" name="pengantar_status" class="form-control f">
                            <option value="-1">&mdash; Semua &mdash;</option>
                            <option value="-2" <?php echo $_params['pengantar_status'] == -2 ? 'selected' : ''; ?> >
                                Umum
                            </option>
                            <?php foreach (CStatus::$_status_label as $_k => $_v) : ?>
                                <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['pengantar_status'] ? 'selected' : ''; ?>>
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
                        <th>Tempat</th>
                        <th class="text-center">Waktu</th>
                        <th nowrap>No. Surat</th>
                        <th style="width: 100px" class="text-right">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php /** @var MPengantar $_item */
                    foreach ($_lists as $_item):
                        $_item_ttd_dekan = $_item->getPengantarTtd('array', $_o_dekan_nip);
                        $_item_pengantar = $_item->getPengantarUpload('array', 'pengantar_pkl'); ?>
                        <tr>
                            <td><?php echo $_item->getPengantarId(); ?></td>
                            <td>
                                <?php echo $_item->getMahasiswaNama(); ?><br/>
                                <small class="text-muted">
                                    <?php echo $_item->getMahasiswaNim(); ?>
                                </small>
                            </td>
                            <td>
                                <?php echo $_item->getTempatNama(); ?><br/>
                                <small class="text-muted">
                                    <?php echo $_item->getTempatAlamat(); ?>
                                </small>
                            </td>
                            <td nowrap class="text-center">
                                <?php if ($_item->getPengantarTanggalMulai()) : ?>
                                    <?php echo $_item->getPengantarTanggalMulai(); ?>
                                    <br/><span class="text-info">s/d</span><br/>
                                    <?php echo $_item->getPengantarTanggalSelesai(); ?>
                                <?php endif; ?>
                            </td>
                            <td nowrap>
                                <?php if ($_item->hasPengantarNomor()) : ?>
                                    <p><?php echo $_item->getPengantarNomor(true); ?></p>
                                <?php endif;

                                if ($_is_dekan) : ?>
                                    <span class="btn btn-xs btn-<?php echo $_item_ttd_dekan ? 'primary' : 'danger'; ?> btn-outline"
                                          data-toggle="modal"
                                          data-target="#modalTtd<?php echo $_item->getPengantarId(); ?>">
                                        <i class="fa fa-<?php echo $_item_ttd_dekan ? 'check' : 'question'; ?>"></i>
                                        &nbsp;Ttd
                                    </span>
                                <?php endif; ?>

                                <?php if ($_item_ttd_dekan) : ?>
                                    <a href="<?php echo $_base_url_cetak . DS . Helpers::op_pengantar . DS . $_item->getPengantarId(); ?>"
                                       class="btn btn-xs btn-primary btn-outline" target="_blank">
                                        <i class="fa fa-print"></i>
                                        &nbsp;Pengantar
                                    </a>
                                <?php endif; ?>

                                <?php if ($_item_pengantar) : ?>
                                    <a href="<?php echo $_item_pengantar; ?>"
                                       class="btn btn-xs btn-primary btn-outline" target="_blank">
                                        <i class="fa fa-download"></i>
                                        &nbsp;Pengantar
                                    </a>
                                <?php endif; ?>

                            </td>
                            <td class="text-right">
                                <span class="btn btn-sm btn-<?php echo Helpers::_arr(CStatus::$_status_color, $_item->getPengantarStatus()); ?>"
                                      data-toggle="modal"
                                      data-target="#modalVerifikasi<?php echo $_item->getPengantarId(); ?>">
                                    <?php echo Helpers::_arr(CStatus::$_status_label, $_item->getPengantarStatus()); ?>
                                </span>
                                <br/>
                                <a href="<?php echo $_base_url . DS . $_item->getPengantarId(); ?>"
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

    /** @var MPengantar $_item */
    foreach ($_lists as $_item) {

        if ($_is_operator_prodi)
            Modals::_verifikasi_list(Helpers::_a_op(Helpers::op_pengantar . DS . Helpers::action_verify, true),
                CStatus::_jenis_pengantar, $_item->getPengantarId(), $_item->getPengantarStatus(), $obj_operator->getOperatorId());

        if ($_is_dekan) {
            Modals::_verifikasi_list(Helpers::_a_d(Helpers::d_pengantar . DS . Helpers::action_verify, true),
                CStatus::_jenis_pengantar, $_item->getPengantarId(), $_item->getPengantarStatus(), $obj_dosen->getDosenKode());

            Modals::_ttd_list(Helpers::_a_d(Helpers::d_pengantar . DS . Helpers::action_sign, true),
                $_item->getPengantarTtd('array', $obj_dosen->getDosenKode()),
                CPengantar::_id, $_item->getPengantarId(), $_item->getTaKeteranganESign(), $obj_dosen->getDosenKode());
        }

    }

}