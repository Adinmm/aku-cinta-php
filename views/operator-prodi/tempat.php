<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_mahasiswa, $obj_operator, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

if ($_is_mahasiswa) {
    $_base_url = Helpers::_a_m(Helpers::m_tempat);
    $_base_url_action = Helpers::_a_m(Helpers::m_tempat, true);
} elseif ($_is_dosen) {
    $_base_url = Helpers::_a_d(Helpers::d_tempat);
    $_base_url_action = Helpers::_a_d(Helpers::d_tempat, true);
} else {
    $_base_url = Helpers::_a_op(Helpers::op_tempat);
    $_base_url_action = Helpers::_a_op(Helpers::op_tempat, true);
}

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

$_tempat_id = Routes::_gi()->_depth(2);

if (is_numeric($_tempat_id)) {

    $obj_tempat = CTempat::_gi()->_get($_tempat_id);
    $obj_tempat || $obj_tempat = new MTempat();

    $_can_update = $obj_tempat->_empty() || $_is_operator_prodi;

    $_statuses = [CStatus::_jenis_tempat => $obj_tempat->_empty() ? [] : CStatus::_gi()->_gets(array(
        'status_jenis' => CStatus::_jenis_tempat,
        'status_jenis_id' => $obj_tempat->getTempatId(),
        'join_dosen' => true,
        'join_mahasiswa' => true,
        'number' => -1
    ))]; ?>

    <div class="ibox float-e-margins">

        <?php echo Helpers::_notif_crud('Perbarui', Routes::_gi()->_depth(3), '{{action}} ' . $page_title . ' {{status}}.'); ?>

        <div class="ibox-title">
            <h5>Tambah Tempat PKL</h5>
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

            <form action="<?php echo $_can_update ? $_base_url_action : ''; ?>"
                  onSubmit="return confirm('Apakah anda yakin?');"
                  enctype="multipart/form-data"
                  method="post"
                  class="form-horizontal">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_nama">
                                Nama Tempat *
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="tempat_nama" name="tempat_nama"
                                       class="form-control"
                                       value="<?php echo $obj_tempat->getTempatNama(); ?>" required/>
                                <small class="text-muted">
                                    Kantor/Perusahaan/Dinas
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_alamat">
                                Alamat Kantor *
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="tempat_alamat"
                                          name="tempat_alamat"
                                          rows="4"
                                          required><?php echo $obj_tempat->getTempatAlamat(); ?></textarea>
                                <small class="text-muted">
                                    Isikan dengan lengkap, mulai dari Kelurahan/Desa, Kecamatan, Kabupaten, dan
                                    Provinsi
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_telpon">
                                Telpon
                            </label>
                            <div class="col-sm-8 col-lg-4">
                                <input type="text" id="tempat_telpon" name="tempat_telpon"
                                       class="form-control"
                                       value="<?php echo $obj_tempat->getTempatTelpon(); ?>"/>
                                <small class="text-muted">
                                    Nomor Kantor
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_pic">
                                Penanggung Jawab *
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="tempat_pic" name="tempat_pic"
                                       class="form-control"
                                       value="<?php echo $obj_tempat->getTempatPic(); ?>" required/>
                                <small class="text-muted">
                                    Nama PIC (person in charge) atau bagian terkait dengan PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_pic_jabatan">
                                Jabatan *
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="tempat_pic_jabatan" name="tempat_pic_jabatan"
                                       class="form-control"
                                       value="<?php echo $obj_tempat->getTempatPicJabatan(); ?>" required/>
                                <small class="text-muted">
                                    Jabatan penanggung jawab dalam Kantor/Perusahaan/Dinas
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_pic_hp">
                                Telp / HP *
                            </label>
                            <div class="col-sm-8 col-lg-4">
                                <input type="text" id="tempat_pic_hp" name="tempat_pic_hp"
                                       class="form-control"
                                       value="<?php echo $obj_tempat->getTempatPicHp(); ?>" required/>
                                <small class="text-muted">
                                    Kontak dari penanggung jawab
                                </small>
                            </div>
                        </div>

                        <?php Modals::_status($_statuses, CStatus::_jenis_tempat, $_is_operator_prodi); ?>

                        <div class="form-group row">
                            <div class="col-sm-8 col-sm-offset-4">

                                <div class="alert alert-danger">
                                    <p><strong><i class="fa fa-warning"></i> &nbsp;Penting</strong></p>
                                    <p>Harap memastikan data Tempat PKL <strong>sudah ada atau belum</strong> pada
                                        halaman Daftar Tempat PKL sebelum menambhakan data baru, data yang sudah ada
                                        (duplicate) tidak akan diproses.</p>
                                    <p>Setelah menambahkan data Tempat silakan segera <strong>menghubungi Admin
                                            Prodi</strong> untuk diverifikasi.</p>
                                </div>

                                <?php if ($_can_update) : ?>
                                    <button class="btn btn-success btn-outline _confirm">
                                        <i class="fa fa-cloud-upload"></i>
                                        &nbsp;Simpan
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                    </div>
                </div>

                <input type="hidden" name="_tempat_id" value="<?php echo $obj_tempat->getTempatId(); ?>"/>

            </form>

        </div>

        <div class="ibox-footer">
            <ul>
                <li>
                    Isian wajib (*) harus diisi
                </li>
                <li>
                    Silakan menghubungi admin prodi untuk mengkonfirmasi tempat PKL yang baru dimasukkan
                </li>
            </ul>
        </div>

    </div>

    <?php if ($_is_operator_prodi)
        Modals::_verifikasi(Helpers::_a_op(Helpers::op_tempat . DS . Helpers::action_verify, true),
            $_statuses, CStatus::_jenis_tempat, $obj_tempat->getTempatId(), $obj_operator->getOperatorId());


} else {

    $_max_item = 25;

    $_params = Helpers::_params(array(
        'tempat_nama' => '',
        'tempat_alamat' => '',
        'tempat_pic' => '',
        'tempat_status' => -1,
        'page' => 1,
        'number' => $_max_item
    ), $_REQUEST);

    $_lists = CTempat::_gi()->_gets(array(
        'tempat_nama' => $_params['tempat_nama'],
        'tempat_alamat' => $_params['tempat_alamat'],
        'tempat_pic' => $_params['tempat_pic'],
        'tempat_status' => $_params['tempat_status'],
        'offset' => ($_params['page'] - 1) * $_max_item,
        'number' => $_max_item
    ));

    $_lists_count = CTempat::_gi()->_count(); ?>

    <?php echo Helpers::_notif_crud('Tambah', Routes::_gi()->_depth(2), '{{action}} ' . $page_title . ' {{status}}.'); ?>

    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <h5>Daftar Tempat PKL</h5>
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
                        <label for="tempat_nama">Nama</label>
                        <input id="tempat_nama" name="tempat_nama" type="text" class="form-control f"
                               placeholder="Cari Nama"
                               value="<?php echo $_params['tempat_nama']; ?>"/>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label for="tempat_alamat">Alamat</label>
                        <input id="tempat_alamat" name="tempat_alamat" type="text" class="form-control f"
                               placeholder="Cari Alamat"
                               value="<?php echo $_params['tempat_alamat']; ?>"/>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label for="tempat_pic">PIC</label>
                        <input id="tempat_pic" name="tempat_pic" type="text" class="form-control f"
                               placeholder="Cari Penanggung Jawab"
                               value="<?php echo $_params['tempat_pic']; ?>"/>
                    </div>
                    <?php if ($_is_operator_prodi) : ?>
                        <div class="col-md-3 col-lg-2">
                            <label for="tempat_status">Status</label>
                            <select id="tempat_status" name="tempat_status" class="form-control f">
                                <option value="-1">&mdash; Semua &mdash;</option>
                                <option value="-2" <?php echo $_params['tempat_status'] == -2 ? 'selected' : ''; ?> >
                                    Menunggu
                                </option>
                                <?php foreach (CStatus::$_status_label as $_k => $_v) : ?>
                                    <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['tempat_status'] ? 'selected' : ''; ?>>
                                        <?php echo $_v; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-4 col-lg-4">
                        <br/>
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <?php if ($_is_mahasiswa || $_is_operator_prodi) : ?>
                            &nbsp;
                            <a class="btn btn-primary"
                               href="<?php echo $_base_url; ?>/0">
                                <i class="fa fa-plus"></i>
                                &nbsp;Tambah
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </form>

            <br/><br/>

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 100px">ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Penanggung Jawab</th>
                        <th>Jabatan</th>
                        <th style="width: 100px">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php /** @var MTempat $_item */
                    foreach ($_lists as $_item) : ?>
                        <tr>
                            <td>
                                <?php echo $_item->getTempatId(); ?>
                                <br/>
                                <small class="text-muted">
                                    <?php echo $_item->getTempatWaktu('Y-m-d'); ?><br/>
                                    <?php echo $_item->getTempatWaktu('H:i:s'); ?>
                                </small>
                            </td>
                            <td nowrap>
                                <?php echo $_item->getTempatNama(); ?>
                                <br/>
                                <small class="text-muted">
                                    <?php echo $_item->getTempatTelpon(); ?>
                                </small>
                            </td>
                            <td>
                                <?php echo $_item->getTempatAlamat(); ?>
                            </td>
                            <td>
                                <?php echo $_item->getTempatPic(); ?>
                                <br/>
                                <small class="text-muted">
                                    <?php echo $_item->getTempatPicHp(); ?>
                                </small>
                            </td>
                            <td>
                                <?php echo $_item->getTempatPicJabatan(); ?>
                            </td>
                            <td>
                                <span class="btn btn-sm btn-<?php echo CStatus::$_status_color[$_item->getTempatStatus()]; ?>"
                                      data-toggle="modal"
                                      data-target="#modalVerifikasi<?php echo $_item->getTempatId(); ?>">
                                    <?php echo CStatus::$_status_label[$_item->getTempatStatus()]; ?>
                                </span>
                                <?php if ($_is_operator_prodi) : ?>
                                    <br/>
                                    <a href="<?php echo Helpers::_a_op(Helpers::op_tempat . DS . $_item->getTempatId()); ?>"
                                       target="_blank"
                                       class="btn btn-xs btn-primary btn-outline">
                                        Detail&nbsp;
                                        <i class="fa fa-external-link"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ibox-footer">
            <?php echo Helpers::_paging($_base_url . '?' . http_build_query($_params), $_lists_count, $_params['page'], $_max_item); ?>
            <div class="clearfix"></div>
        </div>
    </div>

    <?php if ($_is_operator_prodi):

        /** @var MTempat $_item */
        foreach ($_lists as $_item)
            Modals::_verifikasi_list(Helpers::_a_op(Helpers::op_tempat . DS . Helpers::action_verify, true),
                CStatus::_jenis_tempat, $_item->getTempatId(), $_item->getTempatStatus(), $obj_operator->getOperatorId());

    endif; ?>

<?php }