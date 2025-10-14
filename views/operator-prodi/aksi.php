<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

set_time_limit(0);

global $obj_operator;

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

switch (Routes::_gi()->_depth(2)) {

    case Helpers::op_pengantar:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();
                $obj_pengantar = CPengantar::_gi()->_get($obj_status->getStatusJenisId());
                $obj_pengantar || $obj_pengantar = new MPengantar();

                $obj_pengantar->setPengantarStatus($obj_status->getStatusStatus());
                CPengantar::_gi()->_update($obj_pengantar);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_pengantar . DS . Helpers::status_success));

                break;

            case Helpers::action_sign:

                $obj_pengantar = CPengantar::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'pengantar_id'));

                if ($obj_pengantar) {
                    $obj_pengantar->setPengantarWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_pengantar->addPengantarTtd($obj_operator->getOperatorId(),
                            Helpers::_arr($_ttd_data, $obj_operator->getOperatorId()));
                    CPengantar::_gi()->_update($obj_pengantar);
                }

                Helpers::_redirect(Helpers::_a_op(Helpers::op_pengantar . DS . Helpers::status_success));

                break;

            default:

                $_pengantar_id = Helpers::_arr($_REQUEST, '_pengantar_id');
                $obj_pengantar = CPengantar::_gi()->_get($_pengantar_id);
                $obj_pengantar || $obj_pengantar = new MPengantar();

                $obj_pengantar
                    ->_init($_REQUEST)
                    ->setPengantarWaktuUpdate(date('Y-m-d H:i:s'));

                $_data_upload_files = Helpers::_arr($_FILES, '_pengantar_upload', []);
                if ($_data_upload_files) {
                    foreach ($_data_upload_files['name'] as $_k => $_v) {
                        if ($_data_upload_files['error'][$_k] == 0) {
                            $__data = Files::_gi()->saveDO(array(
                                'name' => $_v,
                                'type' => $_data_upload_files['type'][$_k],
                                'tmp_name' => $_data_upload_files['tmp_name'][$_k],
                                'error' => $_data_upload_files['error'][$_k],
                                'size' => $_data_upload_files['size'][$_k]
                            ), $_k, array(Files::type_images), $obj_pengantar->getMahasiswaNim() . '-' . $obj_pengantar->getPengantarId());
                            /** @var File $obj_file */
                            $obj_file = $__data['obj_file'];
                            $obj_pengantar->addPengantarUpload($_k, $obj_file->get_file_uri_path());
                        }
                    }
                    CPengantar::_gi()->_update($obj_pengantar);
                }

                $obj_status = new MStatus();
                $obj_status
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusJenis(CStatus::_jenis_pengantar)
                    ->setStatusJenisId($obj_pengantar->getPengantarId())
                    ->setStatusStatus($obj_pengantar->getPengantarStatus())
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                    ->setOperatorId($obj_operator->getOperatorId());

                CStatus::_gi()->_insert($obj_status);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_pengantar . DS . $obj_pengantar->getPengantarId() . DS . Helpers::status_success));

                break;

        }

        break;

    case Helpers::op_pengajuan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();
                $obj_pengajuan = CPengajuan::_gi()->_get($obj_status->getStatusJenisId());
                $obj_pengajuan || $obj_pengajuan = new MPengajuan();

                $obj_pengajuan->setPengajuanStatus($obj_status->getStatusStatus());
                CPengajuan::_gi()->_update($obj_pengajuan);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_pengajuan . DS . Helpers::status_success));

                break;

            case Helpers::action_sign:

                $obj_pengajuan = CPengajuan::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'pengajuan_id'));

                if ($obj_pengajuan) {
                    $obj_pengajuan->setPengajuanWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_pengajuan->addPengajuanTtd($obj_operator->getOperatorId(),
                            Helpers::_arr($_ttd_data, $obj_operator->getOperatorId()));
                    CPengajuan::_gi()->_update($obj_pengajuan);
                }

                Helpers::_redirect(Helpers::_a_op(Helpers::op_pengajuan . DS . Helpers::status_success));

                break;

            default:

                $_pengajuan_id = Helpers::_arr($_REQUEST, '_pengajuan_id');
                $obj_pengajuan = CPengajuan::_gi()->_get($_pengajuan_id);
                $obj_pengajuan || $obj_pengajuan = new MPengajuan();

                $obj_pengajuan
                    ->_init($_REQUEST)
                    ->setPengajuanWaktuUpdate(date('Y-m-d H:i:s'));

                $_data_upload_files = Helpers::_arr($_FILES, '_pengajuan_upload', []);
                if ($_data_upload_files) {
                    foreach ($_data_upload_files['name'] as $_k => $_v) {
                        if ($_data_upload_files['error'][$_k] == 0) {
                            $__data = Files::_gi()->saveDO(array(
                                'name' => $_v,
                                'type' => $_data_upload_files['type'][$_k],
                                'tmp_name' => $_data_upload_files['tmp_name'][$_k],
                                'error' => $_data_upload_files['error'][$_k],
                                'size' => $_data_upload_files['size'][$_k]
                            ), $_k, array(Files::type_images), $obj_pengajuan->getMahasiswaNim() . '-' . $obj_pengajuan->getPengajuanId());
                            /** @var File $obj_file */
                            $obj_file = $__data['obj_file'];
                            $obj_pengajuan->addPengajuanUpload($_k, $obj_file->get_file_uri_path());
                        }
                    }
                    CPengajuan::_gi()->_update($obj_pengajuan);
                }

                $obj_status = new MStatus();
                $obj_status
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusJenis(CStatus::_jenis_pengajuan)
                    ->setStatusJenisId($obj_pengajuan->getPengajuanId())
                    ->setStatusStatus($obj_pengajuan->getPengajuanStatus())
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                    ->setOperatorId($obj_operator->getOperatorId());

                CStatus::_gi()->_insert($obj_status);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_pengajuan . DS . $obj_pengajuan->getPengajuanId() . DS . Helpers::status_success));

                break;

        }

        break;

    case Helpers::op_seminar:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();
                $obj_seminar = CSeminar::_gi()->_get($obj_status->getStatusJenisId());
                $obj_seminar || $obj_seminar = new MSeminar();

                $obj_seminar->setSeminarStatus($obj_status->getStatusStatus());
                CSeminar::_gi()->_update($obj_seminar);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_seminar . DS . Helpers::status_success));

                break;

            case Helpers::action_sign:

                $obj_seminar = CSeminar::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'seminar_id'));

                if ($obj_seminar) {
                    $obj_seminar->setSeminarWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_seminar->addSeminarTtd($obj_operator->getOperatorId(),
                            Helpers::_arr($_ttd_data, $obj_operator->getOperatorId()));
                    CSeminar::_gi()->_update($obj_seminar);
                }

                Helpers::_redirect(Helpers::_a_op(Helpers::op_seminar . DS . Helpers::status_success));

                break;

            default:

                $_seminar_id = Helpers::_arr($_REQUEST, '_seminar_id');
                $obj_seminar = CSeminar::_gi()->_get($_seminar_id);
                $obj_seminar || $obj_seminar = new MSeminar();

                $obj_seminar
                    ->_init($_REQUEST)
                    ->setSeminarWaktuUpdate(date('Y-m-d H:i:s'));

                CSeminar::_gi()->_update($obj_seminar);

                $obj_status = new MStatus();
                $obj_status
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusJenis(CStatus::_jenis_seminar)
                    ->setStatusJenisId($obj_seminar->getSeminarId())
                    ->setStatusStatus($obj_seminar->getSeminarStatus())
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                    ->setOperatorId($obj_operator->getOperatorId());

                CStatus::_gi()->_insert($obj_status);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_seminar . DS . $obj_seminar->getSeminarId() . DS . Helpers::status_success));

                break;

        }

        break;

    case Helpers::op_tempat:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();
                $obj_tempat = CTempat::_gi()->_get($obj_status->getStatusJenisId());
                $obj_tempat || $obj_tempat = new MTempat();

                $obj_tempat->setTempatStatus($obj_status->getStatusStatus());
                CTempat::_gi()->_update($obj_tempat);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_tempat . DS . Helpers::status_success));

                break;

            default:

                $_tempat_id = Helpers::_arr($_REQUEST, '_tempat_id');
                $obj_tempat = CTempat::_gi()->_get($_tempat_id);
                $obj_tempat || $obj_tempat = new MTempat();

                $obj_tempat
                    ->_init($_REQUEST)
                    ->setTempatWaktuUpdate(date('Y-m-d H:i:s'));

                if ($obj_tempat->_empty()) {
                    $obj_tempat
                        ->setTempatWaktu(date('Y-m-d H:i:s'))
                        ->setTempatStatus(CStatus::_status_diterima);
                    $_new_tempat_id = CTempat::_gi()->_insert($obj_tempat);
                    $obj_tempat->setTempatId($_new_tempat_id);
                } else CTempat::_gi()->_update($obj_tempat);

                $obj_status = new MStatus();
                $obj_status
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusJenis(CStatus::_jenis_tempat)
                    ->setStatusJenisId($obj_tempat->getTempatId())
                    ->setStatusStatus($obj_tempat->getTempatStatus())
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                    ->setOperatorId($obj_operator->getOperatorId());

                CStatus::_gi()->_insert($obj_status);

                Helpers::_redirect(Helpers::_a_op(Helpers::op_tempat . DS . $obj_tempat->getTempatId() . DS . Helpers::status_success));

                break;

        }

        break;

    case Helpers::op_pengaturan:

        $_lists = Helpers::_arr($_REQUEST, Helpers::op_pengaturan, array());

        foreach ($_lists as $_key => $_value)
            CPengaturan::_gi()->_save($_key, is_array($_value) ? json_encode($_value) : $_value);

        Helpers::_redirect(
            Helpers::_a_op(Helpers::op_pengaturan) . DS . Helpers::status_success);

        break;
}

die();