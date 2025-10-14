<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_persetujuan, $obj_operator, $obj_dosen, $_is_operator_prodi, $_is_dosen;

$_persetujuan_id = Routes::_gi()->_depth(2);

if (is_numeric($_persetujuan_id)) {

    $obj_persetujuan = CPersetujuan::_gi()->_get($_persetujuan_id);
    $obj_persetujuan || $obj_persetujuan = new MPersetujuan();

    Routes::_gi()->_render(1, Helpers::dir_mahasiswa . DS);

} else {

    $_max_item = 25;
    if ($_is_operator_prodi) {
        $_base_url = Helpers::_a_op(Helpers::op_persetujuan);
        $_base_url_cetak = Helpers::_a_op(Helpers::action_print);
    } else {
        $_base_url = Helpers::_a_d(Helpers::d_persetujuan);
        $_base_url_cetak = Helpers::_a_d(Helpers::action_print);
    }

    $_params = Helpers::_params(array(
        'persetujuan_status' => -2,
        'mahasiswa_nim' => '',
        'mahasiswa_nama' => '',
        'dosen_pa_nama' => '',
        'page' => 1,
        'number' => $_max_item
    ), $_REQUEST);

    $_lists = CPersetujuan::_gi()->_gets(array(
        'persetujuan_status' => $_params['persetujuan_status'],
        'mahasiswa_nim' => $_params['mahasiswa_nim'],
        'mahasiswa_nama' => $_params['mahasiswa_nama'],
        'dosen_pa_kode' => $_is_dosen ? $obj_dosen->getDosenKode() : '',
        'dosen_pa_nama' => $_params['dosen_pa_nama'],
        'join_mahasiswa' => true,
        'join_dosen' => true,
        'order' => 'DESC',
        'order_by' => 'persetujuan_waktu_update',
        'offset' => ($_params['page'] - 1) * $_max_item,
        'number' => $_max_item
    ));

    $_lists_count = CPersetujuan::_gi()->_count(); ?>

    <div class="ibox float-e-margins">

        <?php echo Helpers::_notif_crud(
            Routes::_gi()->_depth(2, true),
            Routes::_gi()->_depth(3),
            '{{action}} data {{status}}.'); ?>

        <div class="ibox-title">
            <h5>Persetujuan</h5>
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
                        <label for="persetujuan_status">Status</label>
                        <select id="persetujuan_status" name="persetujuan_status" class="form-control f">
                            <option value="-1">&mdash; Semua &mdash;</option>
                            <option value="-2" <?php echo $_params['persetujuan_status'] == -2 ? 'selected' : ''; ?> >
                                Umum
                            </option>
                            <?php foreach (CStatus::$_status_label as $_k => $_v) : ?>
                                <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['persetujuan_status'] ? 'selected' : ''; ?>>
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
                    <?php if ($_is_operator_prodi) : ?>
                        <div class="col-md-3 col-lg-2">
                            <label for="dosen_pa_nama">Dosen</label>
                            <input id="dosen_pa_nama" name="dosen_pa_nama" type="text" class="form-control f"
                                   placeholder="Cari dosen"
                                   value="<?php echo $_params['dosen_pa_nama']; ?>"/>
                        </div>
                    <?php endif; ?>
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
                        <th>Dosen</th>
                        <th style="width: 60px">SKS</th>
                        <th style="width: 60px">IPK</th>
                        <th style="width: 60px">Ke</th>
                        <th style="width: 120px">Semester</th>
                        <th style="width: 120px">Berkas</th>
                        <th style="width: 100px" class="text-right">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php /** @var MPersetujuan $_item */
                    foreach ($_lists as $_item): ?>
                        <tr>
                            <td><?php echo $_item->getPersetujuanId(); ?></td>
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
                                <?php if ($_is_dosen) : ?>
                                    <?php $_item_ttd_dosen = $_item->getPersetujuanTtd('array', $_item->getDosenKode()); ?>
                                    <span class="btn btn-xs btn-<?php echo $_item_ttd_dosen ? 'primary' : 'danger'; ?> btn-outline"
                                          data-toggle="modal"
                                          data-target="#modalTtd<?php echo $_item->getPersetujuanId(); ?>">
                                        <i class="fa fa-<?php echo $_item_ttd_dosen ? 'check' : 'question'; ?>"></i>
                                        &nbsp;Ttd
                                    </span>
                                <?php endif; ?>
                                <a href="<?php echo $_base_url_cetak . DS . Helpers::op_persetujuan . DS . $_item->getPersetujuanId(); ?>"
                                   class="btn btn-xs btn-primary btn-outline" target="_blank">
                                    <i class="fa fa-print"></i>
                                    &nbsp;Persetujuan
                                </a>
                            </td>
                            <td>
                                <?php echo $_item->getPersetujuanData('array', 'jumlah_sks'); ?>
                            </td>
                            <td>
                                <?php echo $_item->getPersetujuanData('array', 'ipk_terakhir'); ?>
                            </td>
                            <td>
                                <?php echo $_item->getPersetujuanData('array', 'pkl_ke'); ?>
                            </td>
                            <td>
                                <?php echo $_item->getPersetujuanTahunAkademik(true); ?>
                            </td>
                            <td>
                                <?php if ($_upload_krs_terakhir = $_item->getPersetujuanUpload('array', 'krs_terakhir')): ?>
                                    <a href="<?php echo $_upload_krs_terakhir; ?>"
                                       class="btn btn-xs btn-info" target="_blank">
                                        <i class="fa fa-download"></i>
                                        &nbsp;KRS Terakhir
                                    </a>
                                <?php endif; ?>
                                <?php if ($_upload_transkrip_nilai = $_item->getPersetujuanUpload('array', 'transkrip_nilai')): ?>
                                    <a href="<?php echo $_upload_transkrip_nilai; ?>"
                                       class="btn btn-xs btn-info" target="_blank">
                                        <i class="fa fa-download"></i>
                                        &nbsp;Transkrip
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <span class="btn btn-sm btn-<?php echo Helpers::_arr(CStatus::$_status_color, $_item->getPersetujuanStatus()); ?>"
                                      data-toggle="modal"
                                      data-target="#modalVerifikasi<?php echo $_item->getPersetujuanId(); ?>">
                                    <?php echo Helpers::_arr(CStatus::$_status_label, $_item->getPersetujuanStatus()); ?>
                                </span>
                                <br/>
                                <a href="<?php echo $_base_url . DS . $_item->getPersetujuanId(); ?>"
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

    <?php if ($_is_dosen):

        /** @var MPersetujuan $_item */
        foreach ($_lists as $_item) :

            Modals::_verifikasi_list(Helpers::_a_d(Helpers::d_persetujuan . DS . Helpers::action_verify, true),
                CStatus::_jenis_persetujuan, $_item->getPersetujuanId(), $_item->getPersetujuanStatus(), $obj_dosen->getDosenKode());

            Modals::_ttd_list(Helpers::_a_d(Helpers::d_persetujuan . DS . Helpers::action_sign, true),
                $_item->getPersetujuanTtd('array', $_item->getDosenKode()),
                CPersetujuan::_id, $_item->getPersetujuanId(), $_item->getTaKeteranganESign(), $_item->getDosenKode()); ?>

        <?php endforeach;
    endif;

}