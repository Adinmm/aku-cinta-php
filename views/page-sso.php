<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Origin: ' . SSO_URI);

$_usso = Helpers::_arr($_POST, 'usso', array());
$_info = Helpers::_arr($_usso, 'info', array());
$_login = Helpers::_arr($_usso, 'login', array());
$_level = Helpers::_arr($_usso, 'level', array());

$_signature = Helpers::_arr($_usso, 'signature', time());
$__akses = Helpers::_arr($_level, 'kode_akses', time());

if (Helpers::_signature_verify($_signature, array($_login, $__akses), SSO_SECRET)) {

    switch (Helpers::_arr($_level, 'kode_view')) {

        case Helpers::sso_operator_prodi:

            $_kode = Helpers::_arr($_info, 'kode');

            if ($_kode == PRODI_KODE) {

                $_username = Helpers::_arr($_login, 'username');

                $obj_operator = COperator::_gi()->_get_by_id($_username);
                $obj_operator || $obj_operator = new MOperator();

                $obj_operator
                    ->setOperatorJenis(Helpers::dir_operator_prodi)
                    ->setOperatorUsername($_username)
                    ->setOperatorPassword(Helpers::_arr($_login, 'password'))
                    ->setOperatorStatus(COperator::_status_active);

                $_fetch_sia = true;

                if ($_fetch_sia) {
                    $_sia_data = Helpers::_fetch(SIA_URI . '/index.php/api2/UserLevel?username=' . $_username);
                    if ($_level_akses = Helpers::_arr($_sia_data, 'level_akses')) {
                        $__tmp = explode('-', $_level_akses);
                        $_level = Helpers::_arr($__tmp, 0);
                        $_kode_fakultas_prodi = Helpers::_arr($__tmp, 1);
                        if ($_level == 'OP' && $_kode_fakultas_prodi) {
                            $_sia_data = Helpers::_fetch(SIA_URI . '/index.php/api2/Prodi?by=kode_prodi_unram&kode=' . $_kode_fakultas_prodi);
                            if ($_kode = Helpers::_arr($_sia_data, 'kode'))
                                $obj_operator
                                    ->setOperatorNama(Helpers::_arr($_sia_data, 'operator_nama'))
                                    ->addOperatorMeta(COperator::_meta_operator_prodi, Helpers::_arr($_sia_data, 'nama_PS'))
                                    ->addOperatorMeta(COperator::_meta_operator_nama, Helpers::_arr($_sia_data, 'operator_nama'))
                                    ->addOperatorMeta(COperator::_meta_operator_nomor_hp, Helpers::_arr($_sia_data, 'operator_hp'));
                            $_fetch_sia = false;
                        }
                    }
                }

                if ($_fetch_sia) {
                    $_sia_data = Helpers::_fetch(SIA_URI . '/index.php/api2/Dosen?kode=' . $_username);
                    if ($_kode = Helpers::_arr($_sia_data, 'kode')) {
                        $obj_operator
                            ->setOperatorNama(Helpers::_arr($_sia_data, 'nama'))
                            ->addOperatorMeta(COperator::_meta_operator_prodi, Helpers::_arr($_sia_data, 'nama_PS'))
                            ->addOperatorMeta(COperator::_meta_operator_nama, Helpers::_arr($_sia_data, 'nama'))
                            ->addOperatorMeta(COperator::_meta_operator_nomor_hp, Helpers::_arr($_sia_data, 'tlp_hp'));
                        $_fetch_sia = false;
                    }
                }

                if ($obj_operator->_empty())
                    COperator::_gi()->_insert(
                        $obj_operator->setOperatorId($_username));

                else COperator::_gi()->_update($obj_operator);

                Sessions::_gi()->_set(
                    Helpers::dir_operator_prodi, $_username, $obj_operator);

                echo json_encode(array(
                    'status' => true,
                    'redirect' => Helpers::_a(Helpers::$_dir_default_page_map[Helpers::dir_operator_prodi])
                ));

            } else echo json_encode(array(
                'status' => false,
                'data' => 'Akses operator prodi tidak tersedia di ' . APP_NAME . ' ' . APP_AUTHOR
            ));

            break;

        case Helpers::sso_dosen:

            $_kode = Helpers::_arr($_info, 'kode');
            $_kode_prodi = Helpers::_arr($_info, 'kode_PS');
            $_is_dekan = $_kode == CPengaturan::_gi()->_get('dekan_nip');

            if ($_kode_prodi == PRODI_KODE || $_kode_prodi == PRODI_KODE2 || $_is_dekan) {

                $obj_dosen = CDosen::_gi()->_get($_kode);
                $obj_dosen || $obj_dosen = new MDosen();

                $obj_dosen
                    ->_init_SIA($_kode)
                    ->_filter();

                if ($obj_dosen->_empty())
                    CDosen::_gi()->_insert(
                        $obj_dosen->setDosenKode($_kode));

                else CDosen::_gi()->_update($obj_dosen);

                Sessions::_gi()->_set(
                    Helpers::dir_dosen, $_kode, $obj_dosen);

                echo json_encode(array(
                    'status' => true,
                    'redirect' => Helpers::_a(Helpers::$_dir_default_page_map[Helpers::dir_dosen])
                ));

            } else echo json_encode(array(
                'status' => false,
                'data' => 'Akses dosen tidak tersedia di ' . APP_NAME . ' ' . APP_AUTHOR
            ));

            break;

        case Helpers::sso_mahasiswa:

            $_kode_prodi = Helpers::_arr($_info, 'kode_prodi');

            if ($_kode_prodi == PRODI_KODE) {

                $_nim = Helpers::_arr($_info, 'NIM');
                $obj_mahasiswa = CMahasiswa::_gi()->_get($_nim);
                $obj_mahasiswa || $obj_mahasiswa = new MMahasiswa();

                $obj_mahasiswa
                    ->_init_SIA($_nim)
                    ->_filter();

                if ($obj_mahasiswa->_empty())
                    CMahasiswa::_gi()->_insert(
                        $obj_mahasiswa->setMahasiswaNim($_nim));

                else CMahasiswa::_gi()->_update($obj_mahasiswa);

                $obj_mahasiswa = CMahasiswa::_gi()->_get($_nim);

                Sessions::_gi()->_set(
                    Helpers::dir_mahasiswa, $_nim, $obj_mahasiswa);

                echo json_encode(array(
                    'status' => true,
                    'redirect' => Helpers::_a(Helpers::$_dir_default_page_map[Helpers::dir_mahasiswa])
                ));

            } else echo json_encode(array(
                'status' => false,
                'data' => 'Akses mahasiswa tidak tersedia di ' . APP_NAME . ' ' . APP_AUTHOR
            ));

            break;

        default:
            echo json_encode(array(
                'status' => false,
                'data' => 'Kode akses tidak dikenal.'
            ));
    }

} else echo json_encode(array(
    'status' => false,
    'data' => 'Sesi tidak valid, silakan muat ulang halaman kembali.',
));