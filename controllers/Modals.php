<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class Modals
{
    static function _status($statuses, $jenis, $is_admin)
    {
        $status_lists = Helpers::_arr($statuses, $jenis, array());
        /** @var MStatus $obj_status */
        $obj_status = Helpers::_arr($status_lists, 0, new MStatus());
        if (!$obj_status->_empty()) : ?>
            <div class="form-group row">
                <label class="col-sm-4 control-label">
                    Status
                </label>
                <div class="col-sm-8">
                    <p>
                        <span class="btn btn-sm btn-<?php echo $obj_status->getStatusStatus(CStatus::_status_type_color); ?>"
                              data-toggle="modal"
                              data-target="#modalVerifikasi-<?php echo $jenis; ?>">
                            <?php echo $obj_status->getStatusStatus(CStatus::_status_type_label); ?>
                        </span>

                        <?php if ($is_admin): ?>
                            &nbsp;&nbsp;
                            <a data-toggle="modal" data-target="#modalRiwayat-<?php echo $jenis; ?>">
                                <i class="fa fa-history"></i>
                                &nbsp;Riwayat
                            </a>
                        <?php endif; ?>

                    </p>
                    <?php if ($obj_status->hasStatusKeterangan()) : ?>
                        <blockquote>
                            <p><?php echo $obj_status->getStatusKeterangan(); ?></p>
                            <?php if ($is_admin) : ?>
                                <small>
                                    <?php echo $obj_status->getNama(); ?>
                                    (<?php echo $obj_status->getStatusWaktu('j/n/Y g:ia'); ?>)
                                </small>
                            <?php endif; ?>
                        </blockquote>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif;
    }

    static function _verifikasi($form_target, $statuses, $jenis, $jenis_id, $admin_id)
    {
        $_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));
        $status_lists = Helpers::_arr($statuses, $jenis, array());
        /** @var MStatus $obj_status */
        $obj_status = Helpers::_arr($status_lists, 0, new MStatus()); ?>

        <div class="modal inmodal fade" id="modalVerifikasi-<?php echo $jenis; ?>" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="<?php echo $form_target; ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Verifikasi</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="status_jenis" value="<?php echo $jenis; ?>">
                            <input type="hidden" name="status_jenis_id" value="<?php echo $jenis_id; ?>">
                            <div class="form-group">
                                <label for="status_status">Status</label>
                                <select id="status_status" name="status_status" class="form-control">
                                    <?php foreach (CStatus::$_status_label as $_k => $_status) : ?>
                                        <option value="<?php echo $_k; ?>" <?php echo $_k == $obj_status->getStatusStatus() ? 'selected' : ''; ?> >
                                            <?php echo $_status; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_keterangan">Keterangan</label>
                                <textarea id="status_keterangan" name="status_keterangan"
                                          class="form-control"></textarea>
                            </div>
                            <input type="hidden" name="status_waktu" value="<?php echo date('Y-m-d H:i:s'); ?>">
                            <input type="hidden" name="status_tahun_akademik"
                                   value="<?php echo $_o_tahun_akademik_aktif; ?>">
                            <input type="hidden" name="operator_id" value="<?php echo $admin_id; ?>">
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

        <div class="modal inmodal fade" id="modalRiwayat-<?php echo $jenis; ?>" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Riwayat Verifikasi</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /** @var MStatus $_item */
                            foreach ($status_lists as $_item): ?>
                                <tr>
                                    <td>
                                        <?php echo $_item->getNama(); ?><br/>
                                        <small class="text-muted"><?php echo $_item->getStatusWaktu(); ?></small>
                                    </td>
                                    <td>
                                        <p class="btn btn-sm btn-<?php echo $_item->getStatusStatus(CStatus::_status_type_color); ?>">
                                            <?php echo $_item->getStatusStatus(CStatus::_status_type_label); ?>
                                        </p>
                                    </td>
                                    <td><?php echo $_item->getStatusKeterangan(); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php

    }

    static function _verifikasi_list($form_target, $jenis, $jenis_id, $status, $admin_id)
    {
        $_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1')); ?>

        <div class="modal inmodal fade" id="modalVerifikasi<?php echo $jenis_id; ?>" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="<?php echo $form_target; ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Verifikasi</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="status_jenis" value="<?php echo $jenis; ?>">
                            <input type="hidden" name="status_jenis_id" value="<?php echo $jenis_id; ?>">
                            <div class="form-group">
                                <label for="status_status">Status</label>
                                <select id="status_status" name="status_status" class="form-control">
                                    <?php foreach (CStatus::$_status_label as $_k => $_status) : ?>
                                        <option value="<?php echo $_k; ?>" <?php echo $_k == $status ? 'selected' : ''; ?> >
                                            <?php echo $_status; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_keterangan">Keterangan</label>
                                <textarea id="status_keterangan" name="status_keterangan"
                                          class="form-control"></textarea>
                            </div>
                            <input type="hidden" name="status_waktu" value="<?php echo date('Y-m-d H:i:s'); ?>">
                            <input type="hidden" name="status_tahun_akademik"
                                   value="<?php echo $_o_tahun_akademik_aktif; ?>">
                            <input type="hidden" name="operator_id" value="<?php echo $admin_id; ?>">
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

    }

    static function _ttd($form_target, $ttd_data, $jenis, $jenis_id, $jenis_keterangan, $admin_id)
    { ?>

        <div class="modal inmodal fade" id="modalTandaTangan" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="<?php echo $form_target; ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Konfirmasi</h4>
                        </div>
                        <div class="modal-body text-center">

                            <img id="ttdFoto" alt="" class="img-responsive"
                                 src="<?php echo Helpers::_arr($ttd_data, 'foto'); ?>"
                                <?php echo $ttd_data ? '' : 'style="display: none"'; ?>/>

                            <br/>

                            <a class="btn btn-danger btn-lg __generate_ttd ladda-button"
                               data-keterangan="<?php echo $jenis_keterangan; ?>"
                               data-id-foto="ttdFoto"
                               data-id-data-kode="ttdDataKode"
                               data-id-data-foto="ttdDataFoto"
                               data-id-btn-save="ttdSave"
                               data-style="expand-right">
                                <i class="fa fa-xing"></i>
                                &nbsp;Generate Ttd
                            </a>

                            <hr/>
                            <p>
                                <small>
                                    Klik tombol diatas untuk menggenerate tanda tangan untuk kemudian disimpan, data
                                    juga akan tersimpan pada sistem<br/><a href="<?php echo E_SIGN_URI; ?>">E-Sign UNRAM
                                        &nbsp;<i class="fa fa-external-link"></i></a>
                                </small>
                            </p>

                            <input type="hidden"
                                   name="ttd_data[<?php echo $admin_id; ?>][keterangan]"
                                   value="<?php echo $jenis_keterangan; ?>"/>
                            <input type="hidden" id="ttdDataKode" value=""
                                   name="ttd_data[<?php echo $admin_id; ?>][kode]"/>
                            <input type="hidden" id="ttdDataFoto" value=""
                                   name="ttd_data[<?php echo $admin_id; ?>][foto]"/>
                            <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>"
                                   name="ttd_data[<?php echo $admin_id; ?>][waktu]"/>

                            <input type="hidden" name="<?php echo $jenis; ?>"
                                   value="<?php echo $jenis_id; ?>"/>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                Batal
                            </button>
                            <button id="ttdSave" type="submit" class="btn btn-primary"
                                    disabled>
                                Gunakan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php }

    static function _ttd_list($form_target, $ttd_data, $jenis, $jenis_id, $jenis_keterangan, $admin_id)
    { ?>

        <div class="modal inmodal fade" id="modalTtd<?php echo $jenis_id; ?>" tabindex="-1"
             role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="<?php echo $form_target; ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Konfirmasi</h4>
                        </div>
                        <div class="modal-body text-center">

                            <img id="ttdFoto<?php echo $jenis_id; ?>" alt="" class="img-responsive"
                                 src="<?php echo Helpers::_arr($ttd_data, 'foto'); ?>"
                                <?php echo $ttd_data ? '' : 'style="display: none"'; ?>/>

                            <br/>

                            <a class="btn btn-danger btn-lg __generate_ttd ladda-button"
                               data-keterangan="<?php echo $jenis_keterangan; ?>"
                               data-id-foto="ttdFoto<?php echo $jenis_id; ?>"
                               data-id-data-kode="ttdDataKode<?php echo $jenis_id; ?>"
                               data-id-data-foto="ttdDataFoto<?php echo $jenis_id; ?>"
                               data-id-btn-save="ttdSave<?php echo $jenis_id; ?>"
                               data-style="expand-right">
                                <i class="fa fa-xing"></i>
                                &nbsp;Generate Ttd
                            </a>

                            <hr/>
                            <p>
                                <small>
                                    Klik tombol diatas untuk menggenerate tanda tangan untuk kemudian disimpan, data
                                    juga akan tersimpan pada sistem<br/><a href="<?php echo E_SIGN_URI; ?>">E-Sign UNRAM
                                        &nbsp;<i class="fa fa-external-link"></i></a>
                                </small>
                            </p>

                            <input type="hidden"
                                   name="ttd_data[<?php echo $admin_id; ?>][keterangan]"
                                   value="<?php echo $jenis_keterangan; ?>"/>
                            <input type="hidden" id="ttdDataKode<?php echo $jenis_id; ?>" value=""
                                   name="ttd_data[<?php echo $admin_id; ?>][kode]"/>
                            <input type="hidden" id="ttdDataFoto<?php echo $jenis_id; ?>" value=""
                                   name="ttd_data[<?php echo $admin_id; ?>][foto]"/>
                            <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>"
                                   name="ttd_data[<?php echo $admin_id; ?>][waktu]"/>

                            <input type="hidden" name="<?php echo $jenis; ?>"
                                   value="<?php echo $jenis_id; ?>"/>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                Batal
                            </button>
                            <button id="ttdSave<?php echo $jenis_id; ?>" type="submit"
                                    class="btn btn-primary"
                                    disabled>
                                Gunakan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php }

    static function _ajukan($form_target, $jenis, $jenis_id, $admin_id)
    { ?>

        <div class="modal inmodal fade" id="modalAjukan" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form action="<?php echo $form_target; ?>"
                          method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title">Konfirmasi</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="status_jenis" value="<?php echo $jenis; ?>">
                            <input type="hidden" name="status_jenis_id"
                                   value="<?php echo $jenis_id; ?>">
                            <input type="hidden" name="status_status" value="<?php echo CStatus::_status_diajukan; ?>">
                            <input type="hidden" name="status_keterangan" value="">
                            <input type="hidden" name="operator_id"
                                   value="<?php echo $admin_id; ?>">
                            <p>Apakah anda yakin?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-danger">
                                Ajukan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php }
}