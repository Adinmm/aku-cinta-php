<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class Mails
{

    const tpl_notif_dosen_counseling = 'dosen-bimbingan';
    const tpl_notif_mahasiswa_counseling_message = 'mahasiswa-bimbingan-pesan';
    const tpl_notif_dosen_counseling_message = 'dosen-bimbingan-pesan';
    const tpl_notif_dosen_submit = 'dosen-ajukan';

    const var_bimbingan_mahasiswa_nama = '{{bimbingan_mahasiswa_nama}}';
    const var_bimbingan_mahasiswa_nim = '{{bimbingan_mahasiswa_nim}}';
    const var_bimbingan_dosen_nama = '{{bimbingan_dosen_nama}}';
    const var_bimbingan_dosen_nip = '{{bimbingan_dosen_nip}}';
    const var_bimbingan_jenis = '{{bimbingan_jenis}}';
    const var_bimbingan_keterangan = '{{bimbingan_keterangan}}';
    const var_bimbingan_uri = '{{bimbingan_uri}}';
    const var_pesan_isi = '{{pesan_isi}}';
    const var_pesan_berkas = '{{pesan_berkas}}';

    static $_cfg = array(
        'key' => MAIL_KEY,
        'to_email' => '',
        'to_name' => '',
        'from_email' => 'if@unram.ac.id',
        'from_name' => 'Teknik Informatika Universitas Mataram',
        'subject' => '',
        'content' => '',
        'reply_to_email' => 'if@unram.ac.id',
        'reply_to_name' => 'Teknik Informatika Universitas Mataram',
    );

    static $_tpl_map = array(

        self::tpl_notif_dosen_counseling => array(

            '[PKL] Bimbingan ' . self::var_bimbingan_mahasiswa_nama . ' (' . self::var_bimbingan_jenis . ')',

            'Yth, ' . self::var_bimbingan_dosen_nama . '.<br/><br/>' .
            'Terdapat bimbingan <strong>' . self::var_bimbingan_jenis . '</strong> sebagai berikut:<br/><br/>' .
            'NIM : <strong>' . self::var_bimbingan_mahasiswa_nim . '</strong><br/>' .
            'Nama : <strong>' . self::var_bimbingan_mahasiswa_nama . '</strong><br/>' .
            'Keterangan :<br/><strong>' . self::var_bimbingan_keterangan . '</strong><br/><br/>' .
            'Silakan masuk kembali ke ' . self::var_bimbingan_uri . ' untuk melakukan konfirmasi.<br/><br/>' .
            'Terima kasih.'

        ),

        self::tpl_notif_mahasiswa_counseling_message => array(

            '[PKL] Bimbingan ' . self::var_bimbingan_dosen_nama . ' (' . self::var_bimbingan_jenis . ')',

            'Halo, ' . self::var_bimbingan_mahasiswa_nama . '.<br/><br/>' .
            'Terdapat pesan dari bimbingan <strong>' . self::var_bimbingan_jenis . '</strong> sebagai berikut:<br/><br/>' .
            'NIP : <strong>' . self::var_bimbingan_dosen_nip . '</strong><br/>' .
            'Nama : <strong>' . self::var_bimbingan_dosen_nama . '</strong><br/>' .
            'Pesan :<br/><strong>' . self::var_pesan_isi . '</strong><br/>' .
            'Berkas :<br/><strong>' . self::var_pesan_berkas . '</strong><br/><br/>' .
            'Silakan masuk kembali ke ' . self::var_bimbingan_uri . ' untuk membalas pesan.<br/><br/>' .
            'Terima kasih.'

        ),

        self::tpl_notif_dosen_counseling_message => array(

            '[PKL] Bimbingan ' . self::var_bimbingan_mahasiswa_nama . ' (' . self::var_bimbingan_jenis . ')',

            'Yth, ' . self::var_bimbingan_dosen_nama . '.<br/><br/>' .
            'Terdapat pesan dari bimbingan <strong>' . self::var_bimbingan_jenis . '</strong> sebagai berikut:<br/><br/>' .
            'NIM : <strong>' . self::var_bimbingan_mahasiswa_nim . '</strong><br/>' .
            'Nama : <strong>' . self::var_bimbingan_mahasiswa_nama . '</strong><br/>' .
            'Pesan :<br/><strong>' . self::var_pesan_isi . '</strong><br/>' .
            'Berkas :<br/><strong>' . self::var_pesan_berkas . '</strong><br/><br/>' .
            'Silakan masuk kembali ke ' . self::var_bimbingan_uri . ' untuk membalas pesan.<br/><br/>' .
            'Terima kasih.'

        ),

        self::tpl_notif_dosen_submit => array(

            '[PKL] Pengajuan ' . self::var_bimbingan_jenis . ' dari ' . self::var_bimbingan_mahasiswa_nama . '(' . self::var_bimbingan_mahasiswa_nim . ')',

            'Yth, ' . self::var_bimbingan_dosen_nama . '.<br/><br/>' .
            'Terdapat pengajuan <strong>' . self::var_bimbingan_jenis . '</strong> sebagai berikut:<br/><br/>' .
            'NIM : <strong>' . self::var_bimbingan_mahasiswa_nim . '</strong><br/>' .
            'Nama : <strong>' . self::var_bimbingan_mahasiswa_nama . '</strong><br/>' .
            'Keterangan :<br/><strong>' . self::var_bimbingan_keterangan . '</strong><br/><br/>' .
            'Silakan masuk kembali ke ' . self::var_bimbingan_uri . ' untuk membalas pesan.<br/><br/>' .
            'Terima kasih.'

        ),
    );

    static function _send($to_email, $to_name, $_tpl, $_vars = array())
    {
        if (Helpers::_empty($to_email))
            return false;

        if (!$__tpl = Helpers::_arr(self::$_tpl_map, $_tpl))
            return false;

        list($_subject, $_content) = $__tpl;

        foreach ($_vars as $_var => $_replace) {
            $_subject = str_replace($_var, $_replace, $_subject);
            $_content = str_replace($_var, $_replace, $_content);
        }

        $_url = MAIL_URI . 'send?' . http_build_query(
                Helpers::_params(self::$_cfg, array(
                    'to_email' => $to_email,
                    'to_name' => $to_name,
                    'subject' => $_subject,
                    'content' => $_content
                ))
            );

        return file_get_contents($_url);

    }

}