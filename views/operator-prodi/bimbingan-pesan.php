<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $obj_bimbingan, $obj_operator, $obj_dosen, $obj_mahasiswa, $_is_operator_prodi, $_is_dosen, $_is_mahasiswa;

if ($_is_mahasiswa) {
    $_title = sprintf('%s (%s)',
        $obj_bimbingan->getDosenNama(), $obj_bimbingan->getBimbinganJenis(true));
    $_url_bimbingan = Helpers::_a_m(Helpers::m_bimbingan);
    $_url_form_submit = Helpers::_a_m(Helpers::m_bimbingan . DS . Helpers::page_pesan, true);
    CPesan::_gi()->_update_dibaca(CPesan::_jenis_dosen, $obj_bimbingan->getBimbinganId());
} elseif ($_is_dosen) {
    $_title = sprintf('%s (%s)',
        $obj_bimbingan->getMahasiswaNama(), $obj_bimbingan->getBimbinganJenis(true));
    $_url_bimbingan = Helpers::_a_d(Helpers::d_bimbingan);
    $_url_form_submit = Helpers::_a_d(Helpers::d_bimbingan . DS . Helpers::page_pesan, true);
    CPesan::_gi()->_update_dibaca(CPesan::_jenis_mahasiswa, $obj_bimbingan->getBimbinganId());
} else {
    $_title = sprintf('%s &nbsp;&mdash;&nbsp; %s (%s)',
        $obj_bimbingan->getMahasiswaNama(), $obj_bimbingan->getDosenNama(), $obj_bimbingan->getBimbinganJenis(true));
    $_url_bimbingan = Helpers::_a_op(Helpers::op_bimbingan);
    $_url_form_submit = '';
}

$_can_add = $_is_mahasiswa || $_is_dosen;

$_lists = CPesan::_gi()->_gets(array(
    'bimbingan_id' => $obj_bimbingan->getBimbinganId(),
    'join_bimbingan' => true,
    'join_mahasiswa' => true,
    'join_dosen' => true,
    'order_by' => 'pesan_waktu',
    'order' => 'DESC',
    'number' => -1
));

echo Helpers::_notif_crud('', Routes::_gi()->_depth(4), '{{status}}'); ?>

    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <h5><?php echo $_title; ?></h5>
            <div class="ibox-tools">
                <a href="<?php echo $_url_bimbingan; ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i>
                    &nbsp;Kembali
                </a>
                <?php if ($_can_add) : ?>
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalPesan">
                        Kirim pesan baru
                        &nbsp;<i class="fa fa-send-o"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="ibox-content forum-post-container">

            <?php if ($_lists):
                /** @var MPesan $_item */
                foreach ($_lists as $_item) : ?>
                    <div class="media">
                        <a class="forum-avatar" href="#">
                            <img src="<?php echo $_item->_foto(100, 100); ?>"
                                 alt="image" style="max-width: 75px">
                        </a>
                        <div class="media-body">
                            <?php echo $_item->getPesanIsi(); ?>
                            <?php if ($_item->hasPesanBerkas()) : ?>
                                <br/><br/>
                                <a href="<?php echo $_item->getPesanBerkas(); ?>" target="_blank"
                                   class="btn btn-sm btn-warning">
                                    <i class="fa fa-download"></i>
                                    &nbsp;Unduh berkas
                                </a>
                            <?php endif; ?>
                            <br/><br/>
                            <small>
                                <strong><?php echo $_item->_nama(); ?></strong>
                                &nbsp;&nbsp;&mdash;&nbsp;&nbsp;
                                <i class="fa fa-calendar-o"></i>
                                &nbsp;<?php echo Helpers::_camel_case(Helpers::__(
                                    $_item->getPesanWaktu('l, j F Y')), ' '); ?>
                                &nbsp;&nbsp;&mdash;&nbsp;&nbsp;
                                <i class="fa fa-clock-o"></i>
                                &nbsp;<?php echo $_item->getPesanWaktu('H:i \W\I\T\A'); ?>
                                &nbsp;&nbsp;
                                <i class="fa fa-check-square-o text-<?php echo $_item->isPesanStatusDibaca() ? 'success' : 'muted'; ?>"></i>
                            </small>
                        </div>
                    </div>
                <?php endforeach;
            else :?>
                <p class="text-danger">Belum ada pesan, silakan dapat menambahkan pesan baru.</p>
            <?php endif; ?>
        </div>

    </div>

<?php if ($_can_add) : ?>
    <div class="modal inmodal fade" id="modalPesan" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="<?php echo $_url_form_submit; ?>"
                      enctype="multipart/form-data"
                      method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">
                            Pesan
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pesan_isi">Isi pesan *</label>
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
                    <input type="hidden" name="bimbingan_id" value="<?php echo $obj_bimbingan->getBimbinganId(); ?>"/>
                </form>
            </div>
        </div>
    </div>
<?php endif;