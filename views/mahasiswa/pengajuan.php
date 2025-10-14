<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_pengajuan, $obj_mahasiswa, $_can_update, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

if ($obj_pengajuan) {
    $obj_mahasiswa = CMahasiswa::_gi()->_get($obj_pengajuan->getMahasiswaNim());
    $obj_mahasiswa || $obj_mahasiswa = new MMahasiswa();
} else $obj_pengajuan = CPengajuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');

$obj_pengajuan || $obj_pengajuan = new MPengajuan();

$obj_pengantar = CPengantar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
$obj_pengantar || $obj_pengantar = new MPengantar();

if ($obj_pengantar->isPengantarStatusDiterima() || $obj_pengantar->isPengantarStatusSelesai()) {

    if ($_is_operator_prodi) {
        $_base_url = Helpers::_a_op(Helpers::op_pengajuan);
        $_base_url_persetujuan = Helpers::_a_op(Helpers::op_persetujuan);
        $_base_url_pengantar = Helpers::_a_op(Helpers::op_pengantar);
        $_base_url_print = Helpers::_a_op(Helpers::action_print);
        $_base_url_action = Helpers::_a_op(Helpers::op_pengajuan, true);
    } elseif ($_is_dosen) {
        $_base_url = Helpers::_a_d(Helpers::d_pengajuan);
        $_base_url_persetujuan = Helpers::_a_d(Helpers::d_persetujuan);
        $_base_url_pengantar = Helpers::_a_d(Helpers::d_pengantar);
        $_base_url_print = Helpers::_a_d(Helpers::action_print);
        $_base_url_action = Helpers::_a_d(Helpers::d_pengajuan, true);
    } else {
        $_base_url = Helpers::_a_m(Helpers::m_pengajuan);
        $_base_url_persetujuan = Helpers::_a_m(Helpers::m_persetujuan);
        $_base_url_pengantar = Helpers::_a_m(Helpers::m_pengantar);
        $_base_url_print = Helpers::_a_m(Helpers::action_print);
        $_base_url_action = Helpers::_a_m(Helpers::m_pengajuan, true);
    }

    $_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

    $_pengajuan_nomor_ext = !$obj_pengajuan->hasPengajuanNomor() ?
        sprintf('%s%s', CPengajuan::_ext, date('Y')) : $obj_pengajuan->getPengajuanNomorExt();

    $obj_persetujuan = CPersetujuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
    $obj_persetujuan || $obj_persetujuan = new MPersetujuan();

    $_pembimbing_lapangan = $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan');
    $_pembimbing_lapangan_jabatan = $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan_jabatan');
    $_pembimbing_lapangan_nip = $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan_nip');
    $_keterangan = $obj_pengajuan->getPengajuanData('array', 'keterangan');
    $_surat_tugas = $obj_pengajuan->getPengajuanUpload('array', 'surat_tugas');
    $_balasan_tempat_pkl = $obj_pengajuan->getPengajuanUpload('array', 'balasan_tempat_pkl');
    $_transkrip_nilai = $obj_persetujuan->getPersetujuanUpload('array', 'transkrip_nilai');
    $_krs_terakhir = $obj_persetujuan->getPersetujuanUpload('array', 'krs_terakhir');

    $_can_update = $_can_update && ($obj_pengajuan->isPengajuanStatusMenunggu() || $obj_pengajuan->isPengajuanStatusDitolak());
    $_can_update = $_can_update || $_is_operator_prodi;

    $_can_submit = $obj_pengajuan->isPengajuanStatusMenunggu() || $obj_pengajuan->isPengajuanStatusDitolak();
    $_can_submit = $_can_submit && $_balasan_tempat_pkl;
    $_can_submit = $_can_submit && $_is_mahasiswa;

    $_can_print_penunjukan_dosen = $obj_pengajuan->hasPengajuanNomor() && ($_is_operator_prodi || $_is_dosen);
    $_can_print_tugas_dosen = $obj_pengajuan->hasPengajuanNomor() && ($_is_operator_prodi || $_is_dosen);

    $_statuses = [CStatus::_jenis_pengajuan => $obj_pengajuan->_empty() ? [] : CStatus::_gi()->_gets(array(
        'status_jenis' => CStatus::_jenis_pengajuan,
        'status_jenis_id' => $obj_pengajuan->getPengajuanId(),
        'join_dosen' => true,
        'join_mahasiswa' => true,
        'number' => -1
    ))];

    ?>

    <div class="ibox float-e-margins">

        <?php echo Helpers::_notif_crud('Perbarui', Routes::_gi()->_depth(2), '{{action}} ' . $page_title . ' {{status}}.'); ?>

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

            <form action="<?php echo $_can_update ? $_base_url_action : ''; ?>"
                  enctype="multipart/form-data"
                  method="post"
                  class="form-horizontal">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_data[pembimbing_lapangan]">
                                Pembimbing *<br/>
                                <small class="text-muted">Lapangan</small>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="pengajuan_data[pembimbing_lapangan]"
                                       name="pengajuan_data[pembimbing_lapangan]"
                                       class="form-control"
                                       value="<?php echo $_pembimbing_lapangan; ?>" required/>
                                <small class="text-muted">
                                    Pembimbing yang ditunjuk sebagai pembimbing lapangan di tempat PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_data[pembimbing_lapangan_jabatan]">
                                Jabatan *<br/>
                                <small class="text-muted">Pembimbing PKL</small>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="pengajuan_data[pembimbing_lapangan_jabatan]"
                                       name="pengajuan_data[pembimbing_lapangan_jabatan]"
                                       class="form-control"
                                       value="<?php echo $_pembimbing_lapangan_jabatan; ?>" required/>
                                <small class="text-muted">
                                    Jabatan pembimbing PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_data[pembimbing_lapangan_nip]">
                                NIP/NIK<br/>
                                <small class="text-muted">Pembimbing PKL</small>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="pengajuan_data[pembimbing_lapangan_nip]"
                                       name="pengajuan_data[pembimbing_lapangan_nip]"
                                       class="form-control"
                                       value="<?php echo $_pembimbing_lapangan_nip; ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 control-label" for="_pengajuan_upload[balasan_tempat_pkl]">
                                Surat Balasan *<br/>
                                <small class="text-muted">Tempat PKL</small>
                            </label>
                            <div class="col-sm-8">
                                <?php if ($_balasan_tempat_pkl) : ?>
                                    <a href="<?php echo $_balasan_tempat_pkl; ?>" target="_blank">
                                        <img alt="image" class="m-t-xs img-responsive"
                                             src="<?php echo $_balasan_tempat_pkl; ?>">
                                    </a>
                                    <br/>
                                <?php endif; ?>
                                <input type="file" id="_pengajuan_upload[balasan_tempat_pkl]"
                                       name="_pengajuan_upload[balasan_tempat_pkl]"
                                       class="form-control"/>
                                <small class="text-muted">Format dokumen scan JPG/PNG/JPEG.</small>
                                <input type="hidden" name="_pengajuan_upload[balasan_tempat_pkl]"
                                       value="<?php echo $_balasan_tempat_pkl; ?>"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_data[keterangan]">
                                Keterangan
                            </label>
                            <div class="col-sm-8">
                                <textarea rows="3" id="pengajuan_data[keterangan]"
                                          name="pengajuan_data[keterangan]"
                                          class="form-control"><?php echo $_keterangan; ?></textarea>
                            </div>
                        </div>

                        <?php Modals::_status($_statuses, CStatus::_jenis_pengajuan, $_is_operator_prodi); ?>

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
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_tahun_akademik">
                                Tahun
                            </label>
                            <div class="col-sm-8">
                                <?php if ($obj_pengajuan->_empty()) : ?>
                                    <p class="form-control-static">
                                        <?php echo $_o_tahun_akademik_aktif; ?>
                                    </p>
                                    <input type="hidden" name="pengajuan_tahun_akademik"
                                           value="<?php echo $_o_tahun_akademik_aktif; ?>"/>
                                <?php else : ?>
                                    <p class="form-control-static">
                                        <?php echo $obj_pengajuan->getPengajuanTahunAkademik(); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="dosen_kode">
                                Pembimbing<br/>
                                <small class="text-muted">Dosen</small>
                            </label>
                            <div class="col-sm-8">

                                <?php if (!$_is_operator_prodi) : ?>

                                <input type="text" id="dosen_kode"
                                       class="form-control"
                                       value="<?php echo $obj_pengajuan->getDosenNama(); ?>"
                                       readonly/>

                                <?php else : ?>

                                    <select id="dosen_kode" name="dosen_kode"
                                            class="form-control">
                                        <option value="<?php echo $obj_pengajuan->getDosenKode(); ?>">
                                            <?php echo $obj_pengajuan->getDosenNama(); ?>
                                        </option>
                                    </select>
                                    <script type="text/javascript">
                                        $('#dosen_kode').select2({
                                            ajax: {
                                                url: '<?php echo Helpers::_api(Helpers::api_dosen); ?>',
                                                dataType: 'json',
                                                data: function (params) {
                                                    return {
                                                        nama: params.term,
                                                        number: 100
                                                    }
                                                },
                                                processResults: function (response) {
                                                    var results = [];
                                                    $.each(response, function (index, item) {
                                                        results.push({
                                                            id: item.kode,
                                                            text: item.nama,
                                                            desc: item.NIP,
                                                        });
                                                    });
                                                    return {
                                                        results: results
                                                    }
                                                },
                                                cache: true
                                            },
                                            placeholder: 'Pilih Dosen',
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

                                <?php endif; ?>

                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Nama dosen pembimbing PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_bimbingan_tanggal_mulai">
                                Pembimbingan
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="pengajuan_bimbingan_tanggal_mulai"
                                           name="pengajuan_bimbingan_tanggal_mulai"
                                           value="<?php echo $obj_pengajuan->getPengajuanBimbinganTanggalMulai(); ?>"
                                           class="form-control <?php echo $_is_operator_prodi ? '__tanggal' : ''; ?>"
                                           autocomplete="off" <?php echo !$_is_operator_prodi ? 'readonly' : ''; ?> />
                                </div>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Tanggal mulai pembimbingan PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_bimbingan_tanggal_selesai">
                            </label>
                            <div class="col-sm-8 col-md-6">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="pengajuan_bimbingan_tanggal_selesai"
                                           name="pengajuan_bimbingan_tanggal_selesai"
                                           value="<?php echo $obj_pengajuan->getPengajuanBimbinganTanggalSelesai(); ?>"
                                           class="form-control <?php echo $_is_operator_prodi ? '__tanggal' : ''; ?>"
                                           autocomplete="off" <?php echo !$_is_operator_prodi ? 'readonly' : ''; ?> />
                                </div>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Tanggal selesai pembimbingan PKL
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="pengajuan_nomor">
                                No. Surat Tugas
                            </label>
                            <div class="col-sm-8 col-lg-6">
                                <div class="input-group">
                                    <input type="text" id="pengajuan_nomor"
                                           name="pengajuan_nomor"
                                           value="<?php echo $obj_pengajuan->getPengajuanNomor(); ?>"
                                           class="form-control" <?php echo !$_is_operator_prodi ? 'readonly' : ''; ?> />
                                    <span class="input-group-addon">
                                        <?php echo $_pengajuan_nomor_ext; ?>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Nomor surat tugas dosen
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="_pengajuan_upload[surat_tugas]">
                                Surat Tugas<br/>
                                <small class="text-muted">Manual</small>
                            </label>
                            <div class="col-sm-8">
                                <?php // @todo hapus jika sudah tidak diperlukan
                                if ($_is_operator_prodi || 1) : ?>
                                    <input type="file" id="_pengajuan_upload[surat_tugas]"
                                           name="_pengajuan_upload[surat_tugas]"
                                           class="form-control"/>
                                    <small class="text-muted">Format dokumen scan JPG/PNG/JPEG.</small>
                                    <br/><br/>
                                <?php endif; ?>
                                <?php if ($_surat_tugas) : ?>
                                    <a href="<?php echo $_surat_tugas; ?>" target="_blank">
                                        <img alt="image" class="m-t-xs img-responsive"
                                             src="<?php echo $_surat_tugas; ?>">
                                    </a>
                                    <br/>
                                <?php endif; ?>
                                <small class="text-muted">
                                    <span class="text-danger">[Admin]</span> Scan surat tugas yang telah
                                    ditandatangani/stempel basah
                                </small>
                                <input type="hidden" name="_pengajuan_upload[surat_tugas]"
                                       value="<?php echo $_surat_tugas; ?>"/>
                            </div>
                        </div>

                        <br/>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label">
                                Tempat
                            </label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <?php echo $obj_pengantar->getTempatNama(); ?>
                                </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label">
                                Alamat
                            </label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <?php echo $obj_pengantar->getTempatAlamat(); ?>
                                </p>
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

                    <?php if ($_can_print_penunjukan_dosen) : ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $_base_url_print . DS . 'penunjukan' . DS . $obj_pengajuan->getPengajuanId(); ?>"
                           target="_blank"
                           class="btn btn-info">
                            <i class="fa fa-print"></i>
                            &nbsp;Penunjukan Dosen Pembimbing
                        </a>
                    <?php endif; ?>

                    <?php if ($_can_print_tugas_dosen) : ?>
                        &nbsp;&nbsp;
                        <a href="<?php echo $_base_url_print . DS . 'surat-tugas' . DS . $obj_pengajuan->getPengajuanId(); ?>"
                           target="_blank"
                           class="btn btn-danger">
                            <i class="fa fa-print"></i>
                            &nbsp;Surat Tugas Dosen Pembimbing
                        </a>
                    <?php endif; ?>

                </div>

                <input type="hidden" name="_pengajuan_id" value="<?php echo $obj_pengajuan->getPengajuanId(); ?>"/>
                <input type="hidden" name="pengajuan_nomor_ext" value="<?php echo $_pengajuan_nomor_ext; ?>"/>

            </form>

        </div>

        <div class="ibox-footer">
            <ul>
                <li>
                    Isian wajib (*) harus diisi, jika belum melengkapi semua isian wajib maka pengajuan tidak dapat
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
        Modals::_ajukan(Helpers::_a_m(Helpers::m_pengajuan . DS . Helpers::action_submit, true),
            CStatus::_jenis_pengajuan, $obj_pengajuan->getPengajuanId(), $obj_mahasiswa->getMahasiswaNim());

    if ($_is_operator_prodi)
        Modals::_verifikasi(Helpers::_a_op(Helpers::op_pengajuan . DS . Helpers::action_verify, true),
            $_statuses, CStatus::_jenis_pengajuan, $obj_pengajuan->getPengajuanId(),
            Sessions::_gi()->_get(Helpers::dir_operator_prodi));

} else { ?>

    <div class="alert alert-danger">
        Halaman ini dapat diakses jika sudah Pengantar diverifikasi.
    </div>

<?php }
