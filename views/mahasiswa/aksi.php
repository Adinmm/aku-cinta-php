<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

set_time_limit(0);

global $obj_mahasiswa;

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

switch (Routes::_gi()->_depth(2)) {

    case Helpers::m_bimbingan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::page_pesan:

                $obj_pesan = new MPesan();
                $obj_pesan
                    ->_init($_REQUEST)
                    ->setPesanWaktu(date('Y-m-d H:i:s'))
                    ->setPesanJenis(CPesan::_jenis_mahasiswa)
                    ->setPesanStatus(CPesan::_status_menunggu);

                $_pesan_berkas = Helpers::_arr($_FILES, 'pesan_berkas');
                if ($_pesan_berkas && $_pesan_berkas['error'] == 0) {
                    $__data = Files::_gi()->saveDO($_pesan_berkas, $obj_mahasiswa->getMahasiswaNim(),
                        array(Files::type_documents), $obj_mahasiswa->getMahasiswaNim() . '-berkas-' . time());
                    /** @var File $obj_file */
                    $obj_file = $__data['obj_file'];
                    $obj_pesan->setPesanBerkas($obj_file->get_file_uri_path());
                }

                CPesan::_gi()->_insert($obj_pesan);

                $obj_bimbingan = CBimbingan::_gi()->_get($obj_pesan->getBimbinganId());
                $obj_bimbingan || $obj_bimbingan = new MBimbingan();

                $_redirect_uri = Helpers::_a_m(Helpers::m_bimbingan . DS . Helpers::page_pesan . DS . $obj_pesan->getBimbinganId());

                if (!$obj_bimbingan->_empty()) {
                    $obj_bimbingan->setBimbinganWaktuUpdate($obj_pesan->getPesanWaktu());
                    CBimbingan::_gi()->_update($obj_bimbingan);

                    Mails::_send($obj_bimbingan->getDosenEmail(), $obj_bimbingan->getDosenNama(), Mails::tpl_notif_dosen_counseling_message, array(
                        Mails::var_bimbingan_mahasiswa_nama => $obj_bimbingan->getMahasiswaNama(),
                        Mails::var_bimbingan_mahasiswa_nim => $obj_bimbingan->getMahasiswaNim(),
                        Mails::var_bimbingan_dosen_nama => $obj_bimbingan->getDosenNama(),
                        Mails::var_bimbingan_jenis => $obj_bimbingan->getBimbinganJenis(true),
                        Mails::var_pesan_isi => $obj_pesan->getPesanIsi(),
                        Mails::var_pesan_berkas => $obj_pesan->getPesanBerkas(),
                        Mails::var_bimbingan_uri => $_redirect_uri,
                    ));
                }

                Helpers::_redirect($_redirect_uri . DS . Helpers::status_success);

                break;

            default:
                $obj_bimbingan = new MBimbingan();
                $obj_bimbingan
                    ->_init($_REQUEST)
                    ->setBimbinganWaktu(date('Y-m-d H:i:s'))
                    ->setBimbinganWaktuUpdate(date('Y-m-d H:i:s'))
                    ->setBimbinganStatus(CBimbingan::_status_berlangsung)
                    ->setMahasiswaNim($obj_mahasiswa->getMahasiswaNim());

                $_obj_dosen = CDosen::_gi()->_get($obj_bimbingan->getDosenKode());
                if (!$_obj_dosen->_empty()) {

                    $_new_bimbingan_id = CBimbingan::_gi()->_insert($obj_bimbingan);
                    $obj_bimbingan->setBimbinganId($_new_bimbingan_id);

                    $obj_pesan = new MPesan();
                    $obj_pesan
                        ->_init($_REQUEST)
                        ->setPesanWaktu(date('Y-m-d H:i:s'))
                        ->setPesanJenis(CPesan::_jenis_mahasiswa)
                        ->setPesanStatus(CPesan::_status_menunggu)
                        ->setBimbinganId($_new_bimbingan_id);

                    $_pesan_berkas = Helpers::_arr($_FILES, 'pesan_berkas');
                    if ($_pesan_berkas && $_pesan_berkas['error'] == 0) {
                        $__data = Files::_gi()->saveDO($_pesan_berkas, $obj_mahasiswa->getMahasiswaNim(),
                            array(Files::type_documents), $obj_mahasiswa->getMahasiswaNim() . '-berkas-' . time());
                        /** @var File $obj_file */
                        $obj_file = $__data['obj_file'];
                        $obj_pesan->setPesanBerkas($obj_file->get_file_uri_path());
                    }

                    CPesan::_gi()->_insert($obj_pesan);

                    $_redirect_uri = Helpers::_a_m(Helpers::m_bimbingan . DS . Helpers::page_pesan . DS . $_new_bimbingan_id);

                    Mails::_send($_obj_dosen->getDosenEmail(), $_obj_dosen->getDosenNama(), Mails::tpl_notif_dosen_counseling, array(
                        Mails::var_bimbingan_mahasiswa_nama => $obj_mahasiswa->getMahasiswaNama(),
                        Mails::var_bimbingan_mahasiswa_nim => $obj_mahasiswa->getMahasiswaNim(),
                        Mails::var_bimbingan_dosen_nama => $_obj_dosen->getDosenNama(),
                        Mails::var_bimbingan_jenis => $obj_bimbingan->getBimbinganJenis(true),
                        Mails::var_bimbingan_keterangan => $obj_bimbingan->getBimbinganKeterangan(-1),
                        Mails::var_bimbingan_uri => $_redirect_uri,
                    ));

                    Helpers::_redirect($_redirect_uri);

                } else Helpers::_redirect(Helpers::_a_m(Helpers::m_bimbingan . DS . Helpers::status_failed));
        }

        break;

    case Helpers::m_persetujuan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_submit:

                $obj_status = new MStatus();
                $obj_status
                    ->_init($_REQUEST)
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif);

                CStatus::_gi()->_insert($obj_status);

                $obj_persetujuan = CPersetujuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
                $obj_persetujuan || $obj_persetujuan = new MPersetujuan();

                $obj_persetujuan
                    ->setPersetujuanStatus($obj_status->getStatusStatus())
                    ->setPersetujuanWaktuUpdate($obj_status->getStatusWaktu());

                CPersetujuan::_gi()->_update($obj_persetujuan);

                Mails::_send($obj_persetujuan->getDosenEmail(), $obj_persetujuan->getDosenNama(), Mails::tpl_notif_dosen_submit, array(
                    Mails::var_bimbingan_mahasiswa_nama => $obj_persetujuan->getMahasiswaNama(),
                    Mails::var_bimbingan_mahasiswa_nim => $obj_persetujuan->getMahasiswaNim(),
                    Mails::var_bimbingan_dosen_nama => $obj_persetujuan->getDosenNama(),
                    Mails::var_bimbingan_jenis => CStatus::_jenis_persetujuan,
                    Mails::var_bimbingan_keterangan => sprintf('Persetujuan PKL tahun akademik %s', $obj_persetujuan->getPersetujuanTahunAkademik(true)),
                    Mails::var_bimbingan_uri => Helpers::_a_d(Helpers::d_persetujuan . DS . $obj_persetujuan->getPersetujuanId()),
                ));

                Helpers::_send_tg_notif(CStatus::_jenis_persetujuan, $obj_persetujuan->getMahasiswaNama(),
                    $obj_persetujuan->getMahasiswaNim(), $obj_status->getStatusStatus(CStatus::_status_type_label));

                break;

            case Helpers::action_sign:

                $obj_persetujuan = CPersetujuan::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'persetujuan_id'));

                if ($obj_persetujuan) {

                    $obj_persetujuan->setPersetujuanWaktuUpdate(date('Y-m-d H:i:s'));

                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', array()))
                        $obj_persetujuan->addPersetujuanTtd($obj_mahasiswa->getMahasiswaNim(),
                            Helpers::_arr($_ttd_data, $obj_mahasiswa->getMahasiswaNim()));

                    CPersetujuan::_gi()->_update($obj_persetujuan);

                }

                break;

            default:

                $obj_persetujuan = CPersetujuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
                $obj_persetujuan || $obj_persetujuan = new MPersetujuan();

                $obj_persetujuan
                    ->_init($_REQUEST)
                    ->_filter()
                    ->setPersetujuanWaktuUpdate(date('Y-m-d H:i:s'))
                    ->setMahasiswaNim($obj_mahasiswa->getMahasiswaNim());

                $_data_upload_files = Helpers::_arr($_FILES, '_persetujuan_upload', []);
                if ($_data_upload_files) {
                    foreach ($_data_upload_files['name'] as $_k => $_v) {
                        if ($_data_upload_files['error'][$_k] == 0) {
                            $__data = Files::_gi()->saveDO(array(
                                'name' => $_v,
                                'type' => $_data_upload_files['type'][$_k],
                                'tmp_name' => $_data_upload_files['tmp_name'][$_k],
                                'error' => $_data_upload_files['error'][$_k],
                                'size' => $_data_upload_files['size'][$_k]
                            ), $_k, array(Files::type_images), $obj_mahasiswa->getMahasiswaNim() . '-' . $obj_persetujuan->getPersetujuanId());
                            /** @var File $obj_file */
                            $obj_file = $__data['obj_file'];
                            $obj_persetujuan->addPersetujuanUpload($_k, $obj_file->get_file_uri_path());
                        }
                    }
                }

                if ($obj_persetujuan->_empty()) {
                    $obj_persetujuan->setPersetujuanWaktu(date('Y-m-d H:i:s'));
                    $_new_id = CPersetujuan::_gi()->_insert($obj_persetujuan);
                    $obj_persetujuan->setPersetujuanId($_new_id);
                } else CPersetujuan::_gi()->_update($obj_persetujuan);

                $obj_status = CStatus::_gi()->_last(CStatus::_jenis_persetujuan, $obj_persetujuan->getPersetujuanId(), $_o_tahun_akademik_aktif);
                $obj_status || $obj_status = new MStatus();

                if (($obj_status->_empty() || $obj_status->isStatusReject())) {
                    $obj_status
                        ->setStatusWaktu(date('Y-m-d H:i:s'))
                        ->setStatusJenis(CStatus::_jenis_persetujuan)
                        ->setStatusJenisId($obj_persetujuan->getPersetujuanId())
                        ->setStatusStatus(CStatus::_status_menunggu)
                        ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                        ->setOperatorId($obj_mahasiswa->getMahasiswaNim());
                    CStatus::_gi()->_insert($obj_status);

                    $obj_persetujuan->setPersetujuanStatus(CStatus::_status_menunggu);
                }

                CPersetujuan::_gi()->_update($obj_persetujuan);

                /** @TODO sementara, mahasiswa bantu update data dosen */
                if (true && !$obj_persetujuan->hasDosenNama()) {
                    $obj_dosen = new MDosen();
                    $obj_dosen->_init_SIA($obj_persetujuan->getDosenKode())
                        ->setDosenKode($obj_persetujuan->getDosenKode());
                    CDosen::_gi()->_insert($obj_dosen);
                }

                break;

        }
        Helpers::_redirect(Helpers::_a_m(Helpers::m_persetujuan . DS . Helpers::status_success));

        break;

    case Helpers::m_pengantar:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_submit:

                $obj_status = new MStatus();
                $obj_status
                    ->_init($_REQUEST)
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif);

                CStatus::_gi()->_insert($obj_status);

                $obj_pengantar = CPengantar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
                $obj_pengantar || $obj_pengantar = new MPengantar();

                $obj_pengantar
                    ->setPengantarStatus($obj_status->getStatusStatus())
                    ->setPengantarWaktuUpdate($obj_status->getStatusWaktu());

                CPengantar::_gi()->_update($obj_pengantar);

                Helpers::_send_tg_notif(CStatus::_jenis_pengantar, $obj_pengantar->getMahasiswaNama(),
                    $obj_pengantar->getMahasiswaNim(), $obj_status->getStatusStatus(CStatus::_status_type_label));

                break;

            default:

                $obj_pengantar = CPengantar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
                $obj_pengantar || $obj_pengantar = new MPengantar();

                $obj_pengantar
                    ->_init($_REQUEST)
                    ->_filter()
                    ->setPengantarWaktuUpdate(date('Y-m-d H:i:s'))
                    ->setMahasiswaNim($obj_mahasiswa->getMahasiswaNim());

                if ($obj_pengantar->_empty()) {
                    $obj_pengantar->setPengantarWaktu(date('Y-m-d H:i:s'));
                    $_new_id = CPengantar::_gi()->_insert($obj_pengantar);
                    $obj_pengantar->setPengantarId($_new_id);
                } else CPengantar::_gi()->_update($obj_pengantar);

                $obj_status = CStatus::_gi()->_last(CStatus::_jenis_pengantar, $obj_pengantar->getPengantarId(), $_o_tahun_akademik_aktif);
                $obj_status || $obj_status = new MStatus();

                if ($obj_status->_empty() || $obj_status->isStatusReject()) {
                    $obj_status
                        ->setStatusWaktu(date('Y-m-d H:i:s'))
                        ->setStatusJenis(CStatus::_jenis_pengantar)
                        ->setStatusJenisId($obj_pengantar->getPengantarId())
                        ->setStatusStatus(CStatus::_status_menunggu)
                        ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                        ->setOperatorId($obj_mahasiswa->getMahasiswaNim());
                    CStatus::_gi()->_insert($obj_status);

                    $obj_pengantar->setPengantarStatus(CStatus::_status_menunggu);
                }

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
                }

                CPengantar::_gi()->_update($obj_pengantar);

                break;

        }
        Helpers::_redirect(Helpers::_a_m(Helpers::m_pengantar . DS . Helpers::status_success));

        break;

    case Helpers::m_pengajuan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_submit:

                $obj_status = new MStatus();
                $obj_status
                    ->_init($_REQUEST)
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif);

                CStatus::_gi()->_insert($obj_status);

                $obj_pengajuan = CPengajuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');
                $obj_pengajuan || $obj_pengajuan = new MPengajuan();

                $obj_pengajuan
                    ->setPengajuanStatus($obj_status->getStatusStatus())
                    ->setPengajuanWaktuUpdate($obj_status->getStatusWaktu());

                CPengajuan::_gi()->_update($obj_pengajuan);

                Helpers::_send_tg_notif(CStatus::_jenis_pengajuan, $obj_pengajuan->getMahasiswaNama(),
                    $obj_pengajuan->getMahasiswaNim(), $obj_status->getStatusStatus(CStatus::_status_type_label));

                break;

            default:

                $obj_pengajuan = CPengajuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');
                $obj_pengajuan || $obj_pengajuan = new MPengajuan();

                $obj_pengantar = CPengantar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'mahasiswa_nim');
                $obj_pengantar || $obj_pengantar = new MPengantar();

                $obj_pengajuan
                    ->_init($_REQUEST)
                    ->_filter()
                    ->setPengajuanWaktuUpdate(date('Y-m-d H:i:s'))
                    ->setPengantarId($obj_pengantar->getPengantarId());

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
                            ), $_k, array(Files::type_images), $obj_mahasiswa->getMahasiswaNim() . '-' . $obj_pengajuan->getPengajuanId());
                            /** @var File $obj_file */
                            $obj_file = $__data['obj_file'];
                            $obj_pengajuan->addPengajuanUpload($_k, $obj_file->get_file_uri_path());
                        }
                    }
                }

                if ($obj_pengajuan->_empty()) {
                    $obj_pengajuan->setPengajuanWaktu(date('Y-m-d H:i:s'));
                    $_new_id = CPengajuan::_gi()->_insert($obj_pengajuan);
                    $obj_pengajuan->setPengajuanId($_new_id);
                } else CPengajuan::_gi()->_update($obj_pengajuan);

                $obj_status = CStatus::_gi()->_last(CStatus::_jenis_pengajuan, $obj_pengajuan->getPengajuanId(), $_o_tahun_akademik_aktif);
                $obj_status || $obj_status = new MStatus();

                if (($obj_status->_empty() || $obj_status->isStatusReject())) {
                    $obj_status
                        ->setStatusWaktu(date('Y-m-d H:i:s'))
                        ->setStatusJenis(CStatus::_jenis_pengajuan)
                        ->setStatusJenisId($obj_pengajuan->getPengajuanId())
                        ->setStatusStatus(CStatus::_status_menunggu)
                        ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                        ->setOperatorId($obj_mahasiswa->getMahasiswaNim());
                    CStatus::_gi()->_insert($obj_status);

                    $obj_pengajuan->setPengajuanStatus(CStatus::_status_menunggu);
                }

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
                }

                CPengajuan::_gi()->_update($obj_pengajuan);

                break;

        }
        Helpers::_redirect(Helpers::_a_m(Helpers::m_pengajuan . DS . Helpers::status_success));

        break;

    case Helpers::m_seminar:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_submit:

                $obj_status = new MStatus();
                $obj_status
                    ->_init($_REQUEST)
                    ->setStatusWaktu(date('Y-m-d H:i:s'))
                    ->setStatusTahunAkademik($_o_tahun_akademik_aktif);

                CStatus::_gi()->_insert($obj_status);

                $obj_seminar = CSeminar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');
                $obj_seminar || $obj_seminar = new MSeminar();

                $obj_seminar
                    ->setSeminarStatus($obj_status->getStatusStatus())
                    ->setSeminarWaktuUpdate($obj_status->getStatusWaktu());

                CSeminar::_gi()->_update($obj_seminar);

                Mails::_send($obj_seminar->getDosenEmail(), $obj_seminar->getDosenNama(), Mails::tpl_notif_dosen_submit, array(
                    Mails::var_bimbingan_mahasiswa_nama => $obj_seminar->getMahasiswaNama(),
                    Mails::var_bimbingan_mahasiswa_nim => $obj_seminar->getMahasiswaNim(),
                    Mails::var_bimbingan_dosen_nama => $obj_seminar->getDosenNama(),
                    Mails::var_bimbingan_jenis => CStatus::_jenis_seminar,
                    Mails::var_bimbingan_keterangan => sprintf('Seminar PKL pada tanggal %s jam %s WITA', $obj_seminar->getSeminarTanggal(), $obj_seminar->getSeminarJam()),
                    Mails::var_bimbingan_uri => Helpers::_a_d(Helpers::d_seminar . DS . $obj_seminar->getSeminarId()),
                ));

                Helpers::_send_tg_notif(CStatus::_jenis_seminar, $obj_seminar->getMahasiswaNama(),
                    $obj_seminar->getMahasiswaNim(), $obj_status->getStatusStatus(CStatus::_status_type_label));

                break;

            case Helpers::action_sign:

                $obj_seminar = CSeminar::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'seminar_id'));

                if ($obj_seminar) {

                    $obj_seminar->setSeminarWaktuUpdate(date('Y-m-d H:i:s'));

                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', array()))
                        $obj_seminar->addSeminarTtd($obj_mahasiswa->getMahasiswaNim(),
                            Helpers::_arr($_ttd_data, $obj_mahasiswa->getMahasiswaNim()));

                    CSeminar::_gi()->_update($obj_seminar);

                }

                break;

            default:

                $obj_seminar = CSeminar::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');
                $obj_seminar || $obj_seminar = new MSeminar();

                $obj_pengajuan = CPengajuan::_gi()->_get($obj_mahasiswa->getMahasiswaNim(), 'a.mahasiswa_nim');
                $obj_pengajuan || $obj_pengajuan = new MPengajuan();

                $obj_seminar
                    ->_init($_REQUEST)
                    ->_filter()
                    ->setSeminarWaktu(date('Y-m-d H:i:s'))
                    ->setSeminarWaktuUpdate(date('Y-m-d H:i:s'))
                    ->setPengajuanId($obj_pengajuan->getPengajuanId());

                $_data_upload_files = Helpers::_arr($_FILES, '_seminar_upload', []);
                if ($_data_upload_files) {
                    foreach ($_data_upload_files['name'] as $_k => $_v) {
                        if ($_data_upload_files['error'][$_k] == 0) {
                            $__data = Files::_gi()->saveDO(array(
                                'name' => $_v,
                                'type' => $_data_upload_files['type'][$_k],
                                'tmp_name' => $_data_upload_files['tmp_name'][$_k],
                                'error' => $_data_upload_files['error'][$_k],
                                'size' => $_data_upload_files['size'][$_k]
                            ), $_k, array(Files::type_images, Files::type_documents, Files::type_archives), $obj_mahasiswa->getMahasiswaNim() . '-' . $obj_seminar->getSeminarId());
                            /** @var File $obj_file */
                            $obj_file = $__data['obj_file'];
                            $obj_seminar->addSeminarUpload($_k, $obj_file->get_file_uri_path());
                        }
                    }
                }

                if ($obj_seminar->_empty()) {
                    $obj_seminar->setSeminarWaktu(date('Y-m-d H:i:s'));
                    $_new_id = CSeminar::_gi()->_insert($obj_seminar);
                    $obj_seminar->setSeminarId($_new_id);
                } else CSeminar::_gi()->_update($obj_seminar);

                $obj_status = CStatus::_gi()->_last(CStatus::_jenis_seminar, $obj_seminar->getSeminarId(), $_o_tahun_akademik_aktif);
                $obj_status || $obj_status = new MStatus();

                if (($obj_status->_empty() || $obj_status->isStatusReject())) {
                    $obj_status
                        ->setStatusWaktu(date('Y-m-d H:i:s'))
                        ->setStatusJenis(CStatus::_jenis_seminar)
                        ->setStatusJenisId($obj_seminar->getSeminarId())
                        ->setStatusStatus(CStatus::_status_menunggu)
                        ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
                        ->setOperatorId($obj_mahasiswa->getMahasiswaNim());
                    CStatus::_gi()->_insert($obj_status);

                    $obj_seminar->setSeminarStatus(CStatus::_status_menunggu);
                }

                CSeminar::_gi()->_update($obj_seminar);

                break;

        }
        Helpers::_redirect(Helpers::_a_m(Helpers::m_seminar . DS . Helpers::status_success));

        break;

    case Helpers::m_tempat:

        $obj_tempat = new MTempat();
        $obj_tempat
            ->_init($_REQUEST)
            ->setTempatWaktu(date('Y-m-d H:i:s'))
            ->setTempatWaktuUpdate(date('Y-m-d H:i:s'))
            ->setTempatStatus(CStatus::_status_diajukan);

        $_tempat_id = CTempat::_gi()->_insert($obj_tempat);

        $obj_status = new MStatus();
        $obj_status
            ->setStatusWaktu(date('Y-m-d H:i:s'))
            ->setStatusJenis(CStatus::_jenis_tempat)
            ->setStatusJenisId($_tempat_id)
            ->setStatusStatus($obj_tempat->getTempatStatus())
            ->setStatusTahunAkademik($_o_tahun_akademik_aktif)
            ->setOperatorId($obj_mahasiswa->getMahasiswaNim());

        CStatus::_gi()->_insert($obj_status);

        Helpers::_redirect(Helpers::_a_m(Helpers::m_tempat . DS . Helpers::status_success));

        break;

}

die();