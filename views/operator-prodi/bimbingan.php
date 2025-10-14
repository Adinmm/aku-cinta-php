<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $obj_bimbingan, $obj_operator, $obj_dosen, $obj_mahasiswa, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

$_bimbingan_id = Routes::_gi()->_depth(3);

if (is_numeric($_bimbingan_id)) :
    $obj_bimbingan = CBimbingan::_gi()->_get($_bimbingan_id);
    Routes::_gi()->_render(2, Helpers::dir_mahasiswa . DS . Helpers::op_bimbingan . '-');

else :

    $_max_item = 25;

    if ($_is_dosen) {
        $_pesan_jenis = CPesan::_jenis_mahasiswa;
        $_base_url = Helpers::_a_d(Helpers::d_bimbingan);
    } elseif ($_is_mahasiswa) {
        $_pesan_jenis = CPesan::_jenis_dosen;
        $_base_url = Helpers::_a_m(Helpers::m_bimbingan);
    } else {
        $_pesan_jenis = '';
        $_base_url = Helpers::_a_op(Helpers::op_bimbingan);
    }

    $_params = Helpers::_params(array(
        'bimbingan_jenis' => '',
        'bimbingan_status' => -1,
        'mahasiswa_nama' => '',
        'dosen_nama' => '',
        'page' => 1,
        'number' => $_max_item
    ), $_REQUEST);

    $_lists = CBimbingan::_gi()->_gets(array(
        'bimbingan_jenis' => $_params['bimbingan_jenis'],
        'bimbingan_status' => $_params['bimbingan_status'],
        'mahasiswa_nim' => $_is_mahasiswa ? $obj_mahasiswa->getMahasiswaNim() : '',
        'mahasiswa_nama' => $_params['mahasiswa_nama'],
        'dosen_kode' => $_is_dosen ? $obj_dosen->getDosenKode() : '',
        'dosen_nama' => $_params['dosen_nama'],
        'join_mahasiswa' => true,
        'join_dosen' => true,
        'order_by' => 'bimbingan_waktu_update',
        'order' => 'DESC',
        'offset' => ($_params['page'] - 1) * $_max_item,
        'number' => $_max_item
    ));

    $_lists_count = CBimbingan::_gi()->_count();

    echo Helpers::_notif_crud('', Routes::_gi()->_depth(2), '{{status}}'); ?>

    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <h5>Bimbingan</h5>
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
                        <label for="bimbingan_jenis">Jenis</label>
                        <select id="bimbingan_jenis" name="bimbingan_jenis" class="form-control f">
                            <option value>&mdash; Semua &mdash;</option>
                            <?php foreach (CBimbingan::$_jenis as $_k => $_v) : ?>
                                <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['bimbingan_jenis'] ? 'selected' : ''; ?>>
                                    <?php echo $_v; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <label for="bimbingan_status">Status</label>
                        <select id="bimbingan_status" name="bimbingan_status" class="form-control f">
                            <option value="-1">&mdash; Semua &mdash;</option>
                            <?php foreach (CBimbingan::$_status as $_k => $_v) : ?>
                                <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['bimbingan_status'] ? 'selected' : ''; ?>>
                                    <?php echo $_v; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($_is_dosen || $_is_operator_prodi) : ?>
                        <div class="col-md-3 col-lg-2">
                            <label for="mahasiswa_nama">Mahasiswa</label>
                            <input id="mahasiswa_nama" name="mahasiswa_nama" type="text" class="form-control f"
                                   placeholder="Cari mahasiswa"
                                   value="<?php echo $_params['mahasiswa_nama']; ?>"/>
                        </div>
                    <?php endif; ?>
                    <?php if ($_is_operator_prodi) : ?>
                        <div class="col-md-3 col-lg-2">
                            <label for="dosen_nama">Dosen</label>
                            <input id="dosen_nama" name="dosen_nama" type="text" class="form-control f"
                                   placeholder="Cari dosen"
                                   value="<?php echo $_params['dosen_nama']; ?>"/>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12 col-lg-4">
                        <br/>
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <?php if ($_is_mahasiswa) : ?>
                            &nbsp;
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalBaru">
                                <i class="fa fa-comment-o"></i>
                                &nbsp;Baru
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
                        <th nowrap>Jenis</th>
                        <th>Mahasiswa</th>
                        <th>Dosen</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th style="width: 80px">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php /** @var MBimbingan $_item */
                    foreach ($_lists as $_item):
                        $_pesan_count_menunggu = CPesan::_gi()->_gets([
                            'pesan_jenis' => $_pesan_jenis,
                            'pesan_status' => CPesan::_status_menunggu,
                            'bimbingan_id' => $_item->getBimbinganId(),
                            'count' => true
                        ]); ?>
                        <tr <?php echo $_pesan_count_menunggu ? 'class="bg-success"' : ''; ?> >
                            <td nowrap>
                                <?php echo $_item->getBimbinganJenis(true); ?>
                                <?php if ($_pesan_count_menunggu) : ?>
                                    &nbsp;
                                    <span class="badge badge-warning"><?php echo $_pesan_count_menunggu; ?></span>
                                <?php endif; ?>
                                <br/>
                                <small class="text-muted"><?php echo $_item->getBimbinganWaktuUpdate(); ?></small>
                            </td>
                            <td>
                                <strong><?php echo $_item->getMahasiswaNama(); ?></strong><br/>
                                <small class="text-muted"><?php echo $_item->getMahasiswaNim(); ?></small>
                            </td>
                            <td>
                                <strong><?php echo $_item->getDosenNama(); ?></strong><br/>
                                <small class="text-muted"><?php echo $_item->getDosenKode(); ?></small>
                            </td>
                            <td>
                                <?php echo $_item->getBimbinganKeterangan(); ?>
                            </td>
                            <td>
                                <span class="btn btn-xs btn-<?php echo Helpers::_arr(CBimbingan::$_status_color_map, $_item->getBimbinganStatus()); ?>"
                                      data-toggle="modal"
                                      data-target="#modalKonfirmasi<?php echo $_item->getBimbinganId(); ?>">
                                    <?php echo $_item->getBimbinganStatus(true); ?>
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="<?php echo $_base_url . DS . Helpers::page_pesan . DS . $_item->getBimbinganId(); ?>"
                                   class="btn btn-primary btn-sm btn-outline">
                                    <i class="fa fa-comments"></i>
                                    &nbsp;Buka
                                </a>
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

    <?php

    if ($_is_dosen) :

        /** @var MBimbingan $_item */
        foreach ($_lists as $_item) : ?>
            <div class="modal inmodal fade" id="modalKonfirmasi<?php echo $_item->getBimbinganId(); ?>" tabindex="-1"
                 role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="<?php echo Helpers::_a_d(Helpers::d_bimbingan, true); ?>"
                              method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Konfirmasi</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="bimbingan_id"
                                       value="<?php echo $_item->getBimbinganId(); ?>">
                                <?php foreach (CBimbingan::$_status as $_k => $_status) : ?>
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="bimbingan_status"
                                                   value="<?php echo $_k; ?>" <?php echo $_k == $_item->getBimbinganStatus() ? 'checked' : ''; ?>/>
                                            &nbsp;&nbsp;<?php echo $_status; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach;

    endif;

    if ($_is_mahasiswa): ?>

        <div class="modal inmodal fade" id="modalBaru" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form action="<?php echo Helpers::_a_m(Helpers::m_bimbingan, true); ?>"
                          enctype="multipart/form-data"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">
                                Bimbingan
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-md-6" for="_bimbingan_jenis">
                                    Jenis Bimbingan
                                </label>
                                <div class="col-sm-8 col-md-6">
                                    <select id="_bimbingan_jenis" name="bimbingan_jenis" class="form-control f"
                                            required>
                                        <?php foreach (CBimbingan::$_jenis as $_k => $_v) : ?>
                                            <option value="<?php echo $_k; ?>" <?php echo $_k == $_params['bimbingan_jenis'] ? 'selected' : ''; ?>>
                                                <?php echo $_v; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dosen_kode">Dosen Tujuan</label>
                                <select id="dosen_kode" name="dosen_kode" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="bimbingan_keterangan">Keterangan</label>
                                <input type="text" id="bimbingan_keterangan" name="bimbingan_keterangan"
                                       class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label for="pesan_isi">Isi pesan</label>
                                <textarea id="pesan_isi" name="pesan_isi" rows="3"
                                          class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pesan_berkas">
                                    Berkas
                                </label>
                                <input type="file" id="pesan_berkas" name="pesan_berkas" accept=".pdf,.doc,.docx"
                                       class="form-control"/>
                                <small class="text-muted">Optional, format <code>pdf</code>, <code>doc</code>,
                                    <code>docx</code></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Kirim
                                &nbsp;<i class="fa fa-send-o"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>

            $(document).ready(function () {

                $('#dosen_kode').select2({
                    width: '100%',
                    ajax: {
                        url: '<?php echo Helpers::_api(Helpers::api_dosen); ?>',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                __csrf_token: "<?php echo md5(time()); ?>",
                                nama: params.term,
                                number: 25
                            }
                        },
                        processResults: function (response) {
                            var results = [];
                            $.each(response, function (index, item) {
                                results.push({
                                    id: item.kode,
                                    text: item.nama,
                                });
                            });
                            return {results: results}
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    minimumInputLength: 1,
                    templateResult: function (item) {
                        if (item.loading)
                            return item.text;

                        return '<strong>' + item.text + '</strong><br/>' +
                            '<small>' + item.id + '</small>';
                    },
                    templateSelection: function (item) {
                        return item.text;
                    }
                });
            });

        </script>

    <?php endif;

endif;