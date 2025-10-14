<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_pengantar, $obj_mahasiswa, $_can_update, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

if ($obj_pengantar) {
    $obj_mahasiswa = CMahasiswa::_gi()->_get($obj_pengantar->getMahasiswaNim());
    $obj_mahasiswa || $obj_mahasiswa = new MMahasiswa();
} else $obj_pengantar = CPengantar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');

$obj_pengantar || $obj_pengantar = new MPengantar();

$obj_persetujuan = CPersetujuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
$obj_persetujuan || $obj_persetujuan = new MPersetujuan();

if ($obj_persetujuan->isPersetujuanStatusDiterima() || $obj_persetujuan->isPersetujuanStatusSelesai()) {

    if ($_is_operator_prodi) {
        $_base_url = Helpers::_a_op(Helpers::op_pengantar);
        $_base_url_persetujuan = Helpers::_a_op(Helpers::op_persetujuan);
        $_base_url_print = Helpers::_a_op(Helpers::action_print);
        $_base_url_action = Helpers::_a_op(Helpers::op_pengantar, true);
    } elseif ($_is_dosen) {
        $_base_url = Helpers::_a_d(Helpers::d_pengantar);
        $_base_url_persetujuan = Helpers::_a_d(Helpers::d_persetujuan);
        $_base_url_print = Helpers::_a_d(Helpers::action_print);
        $_base_url_action = Helpers::_a_d(Helpers::d_pengantar, true);
    } else {
        $_base_url = Helpers::_a_m(Helpers::m_pengantar);
        $_base_url_persetujuan = Helpers::_a_m(Helpers::m_persetujuan);
        $_base_url_print = Helpers::_a_m(Helpers::action_print);
        $_base_url_action = Helpers::_a_m(Helpers::m_pengantar, true);
    }

    $_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

    $_pengantar_nomor_ext = !$obj_pengantar->hasPengantarNomor() ?
        sprintf('%s%s', CPengantar::_ext, date('Y')) : $obj_pengantar->getPengantarNomorExt();

    $_tanggal_surat = $obj_pengantar->getPengantarData('array', 'tanggal_surat');
    $_keterangan = $obj_pengantar->getPengantarData('array', 'keterangan');
    $_pengantar_pkl = $obj_pengantar->getPengantarUpload('array', 'pengantar_pkl');

    $_can_update = $_can_update && ($obj_pengantar->isPengantarStatusMenunggu() || $obj_pengantar->isPengantarStatusDitolak());
    $_can_update = $_can_update || $_is_operator_prodi;

    $_can_submit = $obj_pengantar->isPengantarStatusMenunggu() || $obj_pengantar->isPengantarStatusDitolak();
    $_can_submit = $_can_submit && $_is_mahasiswa;
    $_can_submit = $_can_submit && $obj_pengantar->_passRequiredFields();

    $_can_print_pengantar = $obj_pengantar->hasPengantarNomor() || $_is_operator_prodi;

    $_statuses = [CStatus::_jenis_pengantar => $obj_pengantar->_empty() ? [] : CStatus::_gi()->_gets(array(
        'status_jenis' => CStatus::_jenis_pengantar,
        'status_jenis_id' => $obj_pengantar->getPengantarId(),
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

            <form action="<?php echo $_can_update ? $_base_url_action : ''; ?>"
                  enctype="multipart/form-data"
                  method="post"
                  class="form-horizontal">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_tahun_akademik">
                                Tahun
                            </label>
                            <div class="col-sm-8">
                                <?php if ($obj_pengantar->_empty()) : ?>
                                    <p class="form-control-static">
                                        <?php echo $_o_tahun_akademik_aktif; ?>
                                    </p>
                                    <input type="hidden" name="pengantar_tahun_akademik"
                                           value="<?php echo $_o_tahun_akademik_aktif; ?>"/>
                                <?php else : ?>
                                    <p class="form-control-static">
                                        <?php echo $obj_pengantar->getPengantarTahunAkademik(); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="tempat_id">
                                Tempat *
                            </label>
                            <div class="col-sm-8">

                                <select id="tempat_id" name="tempat_id"
                                        class="form-control">
                                    <option value="<?php echo $obj_pengantar->getTempatId(); ?>">
                                        <?php echo $obj_pengantar->getTempatNama(); ?>
                                    </option>
                                </select>
                                <script type="text/javascript">
                                    $('#tempat_id').select2({
                                        ajax: {
                                            url: '<?php echo Helpers::_api(Helpers::api_tempat); ?>',
                                            dataType: 'json',
                                            data: function (params) {
                                                return {
                                                    tempat_nama: params.term,
                                                    number: 100
                                                }
                                            },
                                            processResults: function (response) {
                                                var results = [];
                                                $.each(response, function (index, item) {
                                                    results.push({
                                                        id: item.tempat_id,
                                                        text: item.tempat_nama,
                                                        desc: item.tempat_alamat,
                                                    });
                                                });
                                                return {
                                                    results: results
                                                }
                                            },
                                            cache: true
                                        },
                                        placeholder: 'Pilih Tempat',
                                        escapeMarkup: function (markup) {
                                            return markup;
                                        },
                                        minimumInputLength: 1,
                                        templateResult: function (item) {
                                            if (item.loading)
                                                return item.text;

                                            return '<strong>' + item.text + '</strong><br/>' +
                                                '<small>' + item.desc + '</small>';
                                        },
                                        templateSelection: function (item) {
                                            return item.text;
                                        }
                                    });
                                </script>

                                <small class="text-navy">
                                    Jika tempat PKL tidak ada dalam daftar diatas, silakan memeriksa atau menambahkan
                                    tempat baru melalui menu <a href="<?php echo Helpers::_a_m(Helpers::m_tempat); ?>">Tempat
                                        &nbsp;<i class="fa fa-external-link"></i></a>.
                                </small>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_judul">
                                Judul *
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="pengantar_judul"
                                          name="pengantar_judul"
                                          required><?php echo $obj_pengantar->getPengantarJudul(); ?></textarea>
                                <small class="text-muted">
                                    Rencana judul PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_topik">
                                Topik *
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="pengantar_topik" name="pengantar_topik"
                                          required><?php echo $obj_pengantar->getPengantarTopik(); ?></textarea>
                                <small class="text-muted">
                                    Rencana materi / topik PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_tanggal_mulai">
                                Tanggal Mulai *
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="pengantar_tanggal_mulai"
                                           name="pengantar_tanggal_mulai"
                                           value="<?php echo $obj_pengantar->_empty() ? '' : $obj_pengantar->getPengantarTanggalMulai(); ?>"
                                           class="form-control __tanggal" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_tanggal_selesai">
                                Tanggal Selesai *
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="pengantar_tanggal_selesai"
                                           name="pengantar_tanggal_selesai"
                                           value="<?php echo $obj_pengantar->_empty() ? '' : $obj_pengantar->getPengantarTanggalSelesai(); ?>"
                                           class="form-control __tanggal" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_nomor">
                                No. Surat
                            </label>
                            <div class="col-sm-8 col-lg-6">
                                <div class="input-group">
                                    <input type="text" id="pengantar_nomor"
                                           name="pengantar_nomor"
                                           value="<?php echo $obj_pengantar->getPengantarNomor(); ?>"
                                           class="form-control" <?php echo !$_is_operator_prodi ? 'readonly' : ''; ?> />
                                    <span class="input-group-addon">
                                        <?php echo $_pengantar_nomor_ext; ?>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Nomor surat pengantar
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_data[tanggal_surat]">
                                Tanggal Surat
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="pengantar_data[tanggal_surat]"
                                           name="pengantar_data[tanggal_surat]"
                                           value="<?php echo $_tanggal_surat; ?>"
                                           class="form-control __tanggal" autocomplete="off"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengantar_data[keterangan]">
                                Keterangan
                            </label>
                            <div class="col-sm-8">
                                <textarea rows="3" id="pengantar_data[keterangan]"
                                          name="pengantar_data[keterangan]"
                                          class="form-control"><?php echo $_keterangan; ?></textarea>
                            </div>
                        </div>

                        <?php Modals::_status($_statuses, CStatus::_jenis_pengantar, $_is_operator_prodi); ?>

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
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="_pengantar_upload[pengantar_pkl]">
                                Pengantar PKL<br/>
                                <small class="text-muted">Manual</small>
                            </label>
                            <div class="col-sm-8">
                                <?php // @todo hapus jika sudah tidak diperlukan
                                if ($_is_operator_prodi || 1) : ?>
                                    <input type="file" id="_pengantar_upload[pengantar_pkl]"
                                           name="_pengantar_upload[pengantar_pkl]"
                                           class="form-control"/>
                                    <small class="text-muted">Format dokumen scan JPG/PNG/JPEG.</small>
                                    <br/><br/>
                                <?php endif; ?>
                                <?php if ($_pengantar_pkl) : ?>
                                    <a href="<?php echo $_pengantar_pkl; ?>" target="_blank">
                                        <img alt="image" class="m-t-xs img-responsive"
                                             src="<?php echo $_pengantar_pkl; ?>">
                                    </a>
                                    <br/>
                                <?php endif; ?>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Scan surat pengantar yang telah
                                    ditandatangani/stempel basah
                                </small>
                                <input type="hidden" name="_pengantar_upload[pengantar_pkl]"
                                       value="<?php echo $_pengantar_pkl; ?>"/>
                            </div>
                        </div>

                    </div>
                </div>

                <hr/>

                <div class="text-center">
                    <br/><br/>

                    <?php if ($_can_update) : ?>
                        <button class="btn btn-success btn-outline">
                            <i class="fa fa-cloud-upload"></i>
                            &nbsp;Simpan
                        </button>
                    <?php endif;

                    if ($_can_submit) : ?>
                        &nbsp;&nbsp;
                        <a class="btn btn-danger btn-outline"
                           data-toggle="modal"
                           data-target="#modalAjukan">
                            <i class="fa fa-send-o"></i>
                            &nbsp;Ajukan
                        </a>
                    <?php endif; ?>

                    <?php if ($_can_print_pengantar) : ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $_base_url_print . DS . 'pengantar' . DS . $obj_pengantar->getPengantarId(); ?>"
                           target="_blank"
                           class="btn btn-danger">
                            <i class="fa fa-print"></i>
                            &nbsp;Pengantar PKL
                        </a>
                    <?php endif; ?>

                </div>

                <input type="hidden" name="_pengantar_id" value="<?php echo $obj_pengantar->getPengantarId(); ?>"/>
                <input type="hidden" name="pengantar_nomor_ext" value="<?php echo $_pengantar_nomor_ext; ?>"/>

            </form>

        </div>

        <div class="ibox-footer">
            <ul>
                <li>
                    Isian wajib (*) harus diisi, jika belum melengkapi semua isian wajib maka pengantar tidak dapat
                    diproses
                </li>
                <li>
                    Setiap upload scan dokumen pendukung mahasiswa wajib menekan tombol ajukan.
                </li>
                <li>
                    Isian dengan keterangan <span class="text-danger">[Admin]</span> hanya dapat diisi oleh Prodi.
                </li>
            </ul>
        </div>

    </div>

    <?php

    if ($_can_submit)
        Modals::_ajukan(Helpers::_a_m(Helpers::m_pengantar . DS . Helpers::action_submit, true),
            CStatus::_jenis_pengantar, $obj_pengantar->getPengantarId(), $obj_mahasiswa->getMahasiswaNim());

    if ($_is_operator_prodi)
        Modals::_verifikasi(Helpers::_a_op(Helpers::op_pengantar . DS . Helpers::action_verify, true),
            $_statuses, CStatus::_jenis_pengantar, $obj_pengantar->getPengantarId(),
            Sessions::_gi()->_get(Helpers::dir_operator_prodi));

} else { ?>

    <div class="alert alert-danger">
        Halaman ini dapat diakses jika sudah mendapat persetujuan dari dosen PA.
    </div>

<?php }
