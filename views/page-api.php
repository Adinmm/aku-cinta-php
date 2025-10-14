<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

header('Content-Type: application/json');

if ($_session_id = Sessions::_gi()->_get_id()) {

    switch (Routes::_gi()->_depth(1)) {

        case Helpers::api_dosen:
            echo Helpers::_fetch(SIA_URI . '/index.php/api2/Dosens?' . http_build_query($_GET), false);
            break;

        case Helpers::api_mahasiswa:
            $_ret = array();
            $_insert = Helpers::_arr($_GET, '_insert', false);
            $_resp = Helpers::_fetch(SIA_URI . '/index.php/api2/Mahasiswas?' . http_build_query($_GET));
            foreach ($_resp as $_arr) {
                $__nim = Helpers::_arr($_arr, 'NIM');
                $_ret[] = array(
                    'id' => $__nim,
                    'nama' => Helpers::_arr($_arr, 'nama'),
                    'prodi' => Helpers::_arr($_arr, 'nama_prodi'),
                    'fakultas' => Helpers::_arr($_arr, 'nama_fakultas'));
                if ($_insert) {
                    $obj_mahasiswa = new MMahasiswa();
                    $obj_mahasiswa
                        ->_init_SIA($__nim)
                        ->setMahasiswaNim($__nim);
                    CMahasiswa::_gi()->_insert($obj_mahasiswa);
                }
            }
            echo json_encode($_ret);
            break;

        case Helpers::api_tempat:
            $_lists = array();
            $_lists_tmp = CTempat::_gi()->_gets(array_merge(
                $_REQUEST, ['tempat_status' => CStatus::_status_diterima]
            ));
            /** @var MTempat $_item */
            foreach ($_lists_tmp as $_item)
                $_lists[] = $_item->_toArray();
            echo json_encode($_lists);
            break;

        case Helpers::api_tanda_tangan:
            echo Helpers::_fetch(E_SIGN_URI . '/index.php/api/tanda-tangan?' . http_build_query(array(
                    'tanda_tangan_keterangan' => Helpers::_arr($_REQUEST, 'tanda_tangan_keterangan'),
                    'tanda_tangan_data' => array('posisi' => 6, 'rasio' => 75, 'warna' => 3),
                    'pengguna_kode' => $_session_id,
                    '__csrf_token' => md5(time()))), false);
            break;

    }

} else echo json_encode(array(
    'status' => false,
    'data' => 'Unauthorized access!'
));