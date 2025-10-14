<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

set_time_limit(0);

global $obj_dosen;

$_o_tahun_akademik_aktif = CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1'));

switch (Routes::_gi()->_depth(2)) {

    case Helpers::d_bimbingan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::page_pesan:

                $obj_pesan = new MPesan();
                $obj_pesan
                    ->_init($_REQUEST)
                    ->setPesanWaktu(date('Y-m-d H:i:s'))
                    ->setPesanJenis(CPesan::_jenis_dosen)
                    ->setPesanStatus(CPesan::_status_menunggu);

                $_pesan_berkas = Helpers::_arr($_FILES, 'pesan_berkas');
                if ($_pesan_berkas && $_pesan_berkas['error'] == 0) {
                    $__data = Files::_gi()->saveDO($_pesan_berkas, $obj_dosen->getDosenKode(),
                        array(Files::type_documents), $obj_dosen->getDosenKode() . '-berkas-' . time());
                    /** @var File $obj_file */
                    $obj_file = $__data['obj_file'];
                    $obj_pesan->setPesanBerkas($obj_file->get_file_uri_path());
                }

                CPesan::_gi()->_insert($obj_pesan);

                $obj_bimbingan = CBimbingan::_gi()->_get($obj_pesan->getBimbinganId());
                $obj_bimbingan || $obj_bimbingan = new MBimbingan();

                $_redirect_uri = Helpers::_a_d(Helpers::d_bimbingan . DS . Helpers::page_pesan . DS . $obj_pesan->getBimbinganId());

                if (!$obj_bimbingan->_empty()) {
                    $obj_bimbingan->setBimbinganWaktuUpdate($obj_pesan->getPesanWaktu());
                    CBimbingan::_gi()->_update($obj_bimbingan);

                    Mails::_send($obj_bimbingan->getMahasiswaEmail(), $obj_bimbingan->getMahasiswaNama(), Mails::tpl_notif_mahasiswa_counseling_message, array(
                        Mails::var_bimbingan_mahasiswa_nama => $obj_bimbingan->getMahasiswaNama(),
                        Mails::var_bimbingan_dosen_nama => $obj_bimbingan->getDosenNama(),
                        Mails::var_bimbingan_dosen_nip => $obj_bimbingan->getDosenNip(),
                        Mails::var_bimbingan_jenis => $obj_bimbingan->getBimbinganJenis(true),
                        Mails::var_pesan_isi => $obj_pesan->getPesanIsi(),
                        Mails::var_pesan_berkas => $obj_pesan->getPesanBerkas(),
                        Mails::var_bimbingan_uri => $_redirect_uri,
                    ));
                }

                Helpers::_redirect($_redirect_uri . DS . Helpers::status_success);

                break;

            default:
                $_bimbingan_id = Helpers::_arr($_REQUEST, 'bimbingan_id');
                $obj_bimbingan = CBimbingan::_gi()->_get($_bimbingan_id);
                $obj_bimbingan || $obj_bimbingan = new MBimbingan();
                $obj_bimbingan
                    ->_init($_REQUEST)
                    ->setBimbinganWaktuUpdate(date('Y-m-d H:i:s'));

                if (!$obj_bimbingan->_empty())
                    CBimbingan::_gi()->_update($obj_bimbingan);

        }

        Helpers::_redirect(Helpers::_a_d(Helpers::d_bimbingan . DS . Helpers::status_success));

        break;

    case Helpers::d_pengantar:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();

                $obj_pengantar = CPengantar::_gi()->_get($obj_status->getStatusJenisId());
                $obj_pengantar
                    ->setPengantarWaktuUpdate($obj_status->getStatusWaktu())
                    ->setPengantarStatus($obj_status->getStatusStatus());
                CPengantar::_gi()->_update($obj_pengantar);

                Helpers::_redirect(Helpers::_a_d(Helpers::d_pengantar));

                break;

            case Helpers::action_sign:

                $obj_pengantar = CPengantar::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'pengantar_id'));

                if ($obj_pengantar) {
                    $obj_pengantar->setPengantarWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_pengantar->addPengantarTtd($obj_dosen->getDosenKode(),
                            Helpers::_arr($_ttd_data, $obj_dosen->getDosenKode()));
                    CPengantar::_gi()->_update($obj_pengantar);
                }

                Helpers::_redirect(Helpers::_a_d(Helpers::d_pengantar));

                break;

        }

        break;

    case Helpers::d_pengajuan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();

                $obj_pengajuan = CPengajuan::_gi()->_get($obj_status->getStatusJenisId());
                $obj_pengajuan
                    ->setPengajuanWaktuUpdate($obj_status->getStatusWaktu())
                    ->setPengajuanStatus($obj_status->getStatusStatus());
                CPengajuan::_gi()->_update($obj_pengajuan);

                Helpers::_redirect(Helpers::_a_d(Helpers::d_pengajuan));

                break;

            case Helpers::action_sign:

                $obj_pengajuan = CPengajuan::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'pengajuan_id'));

                if ($obj_pengajuan) {
                    $obj_pengajuan->setPengajuanWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_pengajuan->addPengajuanTtd($obj_dosen->getDosenKode(),
                            Helpers::_arr($_ttd_data, $obj_dosen->getDosenKode()));
                    CPengajuan::_gi()->_update($obj_pengajuan);
                }

                Helpers::_redirect(Helpers::_a_d(Helpers::d_pengajuan));

                break;

        }

        break;

    case Helpers::d_persetujuan:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_verify:

                $obj_status = CStatus::_gi()->_insert2();

                $obj_persetujuan = CPersetujuan::_gi()->_get($obj_status->getStatusJenisId());
                $obj_persetujuan
                    ->setPersetujuanWaktuUpdate($obj_status->getStatusWaktu())
                    ->setPersetujuanStatus($obj_status->getStatusStatus());
                CPersetujuan::_gi()->_update($obj_persetujuan);

                Helpers::_redirect(Helpers::_a_d(Helpers::d_persetujuan));

                break;

            case Helpers::action_sign:

                $obj_persetujuan = CPersetujuan::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'persetujuan_id'));

                if ($obj_persetujuan) {
                    $obj_persetujuan->setPersetujuanWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_persetujuan->addPersetujuanTtd($obj_dosen->getDosenKode(),
                            Helpers::_arr($_ttd_data, $obj_dosen->getDosenKode()));
                    CPersetujuan::_gi()->_update($obj_persetujuan);
                }

                Helpers::_redirect(Helpers::_a_d(Helpers::d_persetujuan));

                break;

        }

        break;

    case Helpers::d_seminar:

        switch (Routes::_gi()->_depth(3)) {

            case Helpers::action_grade:

                $_seminar_id = Helpers::_arr($_REQUEST, 'seminar_id');
                $_seminar_nilai = Helpers::_arr($_REQUEST, '_seminar_nilai', []);

                $obj_seminar = CSeminar::_gi()->_get($_seminar_id);
                $obj_seminar || $obj_seminar = new MSeminar();

                if (!$obj_seminar->_empty()) {


                    $__nilai_dosen_pembimbing = Helpers::_arr($_seminar_nilai, 'dosen-pembimbing', []);
                    $__nilai_dosen_pembimbing_aspek = Helpers::_arr($__nilai_dosen_pembimbing, 'aspek', []);

                    if ($__nilai_dosen_pembimbing_aspek) {
                        $___total = 0;
                        foreach ($__nilai_dosen_pembimbing_aspek as $___v)
                            $___total += $___v;
                        $__nilai_dosen_pembimbing['total'] = $___total;
                        $obj_seminar->addSeminarNilai('dosen-pembimbing', $__nilai_dosen_pembimbing);
                    }

                    $__nilai_pembimbing_lapangan = Helpers::_arr($_seminar_nilai, 'pembimbing-lapangan', []);
                    $__nilai_pembimbing_lapangan_aspek = Helpers::_arr($__nilai_pembimbing_lapangan, 'aspek', []);

                    if ($__nilai_pembimbing_lapangan_aspek) {
                        $___total = 0;
                        foreach ($__nilai_pembimbing_lapangan_aspek as $___v)
                            $___total += $___v;
                        $__nilai_pembimbing_lapangan['total'] = $___total;
                        $obj_seminar->addSeminarNilai('pembimbing-lapangan', $__nilai_pembimbing_lapangan);
                    }

                    $__total = (Helpers::_arr($obj_seminar->getSeminarNilai('array', 'dosen-pembimbing', []), 'total', 0) * 0.4)
                        + (Helpers::_arr($obj_seminar->getSeminarNilai('array', 'pembimbing-lapangan', []), 'total', 0) * 0.6);
                    $obj_seminar->addSeminarNilai('total', $__total);

                    $__huruf = CSeminar::_nilai($__total);
                    $obj_seminar->addSeminarNilai('huruf', $__huruf);

                    CSeminar::_gi()->_update($obj_seminar);

                }

                Helpers::_redirect(Helpers::_a_d(Helpers::d_seminar) . DS . $_seminar_id . DS . Helpers::status_success);

                break;

            case Helpers::action_sign:

                $obj_seminar = CSeminar::_gi()->_get(
                    Helpers::_arr($_REQUEST, 'seminar_id'));

                if ($obj_seminar) {
                    $obj_seminar->setSeminarWaktuUpdate(date('Y-m-d H:i:s'));
                    if ($_ttd_data = Helpers::_arr($_REQUEST, 'ttd_data', []))
                        $obj_seminar->addSeminarTtd($obj_dosen->getDosenKode(),
                            Helpers::_arr($_ttd_data, $obj_dosen->getDosenKode()));
                    CSeminar::_gi()->_update($obj_seminar);
                }

                Helpers::_redirect(Helpers::_a_d(Helpers::d_seminar));

                break;

        }

        break;

}

die();