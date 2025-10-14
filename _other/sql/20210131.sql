-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2021 at 12:20 AM
-- Server version: 8.0.13
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unram_if_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `dosen_kode` varchar(25) NOT NULL,
  `dosen_nip` varchar(25) DEFAULT NULL,
  `dosen_nidn` varchar(15) DEFAULT NULL,
  `dosen_nama` varchar(100) DEFAULT NULL,
  `dosen_nomor_hp` varchar(25) DEFAULT NULL,
  `dosen_email` varchar(50) DEFAULT NULL,
  `dosen_foto` text,
  `dosen_status` tinyint(4) DEFAULT NULL,
  `prodi_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`dosen_kode`, `dosen_nip`, `dosen_nidn`, `dosen_nama`, `dosen_nomor_hp`, `dosen_email`, `dosen_foto`, `dosen_status`, `prodi_id`) VALUES
('', '', '', '', '', '', '', 0, 0),
('197005141999031002', '197005141999031002', '', 'Ida Bagus Ketut Widiartha. ST..MT', '+6287-864-052-132', '', '', 0, 552011),
('197210191999032001', '197210191999032001', '', 'Budi Irmawati. S.Kom..MT', '123', '', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/dosen/197210191999032001-2020_04_22-37874821_243082282991847_6911194436210786304_n.jpg', 0, 552011),
('197311302000031001', '197311302000031001', '', 'I Gd Pasek Sutha Wijaya. ST.MT.Dr.Eng', '', '', '', 0, 552011),
('197506122000031001', '197506122000031001', '', 'Heri Wijayanto. ST..MT', '123', '', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/dosen/197506122000031001-2020_04_16-37874821_243082282991847_6911194436210786304_n.jpg', 0, 552011),
('198312092012121001', '198312092012121001', '', 'Andy Hidayat Jatmika,ST.,M.Kom', '', '', '', 0, 552011),
('198507072014042001', '198507072014042001', '', 'Royana Afwani, ST., MT', '', '', '', 0, 552011),
('199012182012121002', '199012182012121002', '', 'Ario Yudo Husodo, ST.,MT.', '123', '', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/dosen/199012182012121002-2019_02_15-37874821_243082282991847_6911194436210786304_n.jpg', 0, 552011),
('201803282192013', '201803282192013', '', 'Ahmad Zafrullah Mardiansyah., S.T., M.Eng.', '087864052132', 'zaf@elektro08.com', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/dosen/201803282192013-2019_02_02-21082011165.jpg', 1, 552011);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `mahasiswa_nim` varchar(15) NOT NULL,
  `mahasiswa_nama` varchar(100) DEFAULT NULL,
  `mahasiswa_nomor_hp` varchar(25) DEFAULT NULL,
  `mahasiswa_email` varchar(200) DEFAULT NULL,
  `mahasiswa_kuliah` varchar(30) DEFAULT NULL,
  `mahasiswa_foto` text,
  `dosen_pa_nama` varchar(100) DEFAULT NULL,
  `dosen_pa_nip` varchar(30) DEFAULT NULL,
  `prodi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`mahasiswa_nim`, `mahasiswa_nama`, `mahasiswa_nomor_hp`, `mahasiswa_email`, `mahasiswa_kuliah`, `mahasiswa_foto`, `dosen_pa_nama`, `dosen_pa_nip`, `prodi_id`) VALUES
('F1D008004', 'AHMAD ZAFRULLAH', '087864052132', 'zaf@elektro08.com', 'Aktif', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/mahasiswa/F1D008004-2020_04_09-21082011165.jpg', 'Ario Yudo Husodo, ST.,MT.', '199012182012121002', 552011),
('F1D012001', 'ADI SUGITA PANDEY', '087864052132', '23Pstars@gmail.com', 'Aktif', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/mahasiswa/F1D012001-2019_06_30-37874821_243082282991847_6911194436210786304_n.jpg', 'Heri Wijayanto. ST..MT', '197506122000031001', 552011),
('F1D012002', 'AHMAD JADID AKBAR', '123', 'a@a.com', 'Aktif', 'https://unram.sgp1.digitaloceanspaces.com/sia/foto/mahasiswa/F1D012002-2020_05_03-37874821_243082282991847_6911194436210786304_n.jpg', 'Ida Bagus Ketut Widiartha. ST..MT', '197005141999031002', 552011);

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `operator_id` varchar(25) NOT NULL,
  `operator_nama` varchar(200) DEFAULT NULL,
  `operator_jenis` varchar(100) DEFAULT NULL,
  `operator_username` varchar(100) DEFAULT NULL,
  `operator_password` varchar(100) DEFAULT NULL,
  `operator_metas` text,
  `operator_status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`operator_id`, `operator_nama`, `operator_jenis`, `operator_username`, `operator_password`, `operator_metas`, `operator_status`) VALUES
('197311302000031001', 'I Gd Pasek Sutha Wijaya. ST.MT.Dr.Eng', 'operator-prodi', '197311302000031001', '$6$nuZMQ.8u$7j0RhAS5XQGXgqTsdc58tNOEiaG36S1gSyiKhW2ZXgFYhWYYmDKNO6OTLjV.MU9i4i4K2HzpCfKyHgKhRsTHR.', '{\"operator_prodi\":\"Teknik Informatika\",\"operator_nama\":\"I Gd Pasek Sutha Wijaya. ST.MT.Dr.Eng\",\"operator_nomor_hp\":\"123\"}', 1),
('201803282192013', 'Ahmad Zafrullah Mardiansyah., S.T., M.Eng.', 'operator-prodi', '201803282192013', '$6$nuZMQ.8u$7j0RhAS5XQGXgqTsdc58tNOEiaG36S1gSyiKhW2ZXgFYhWYYmDKNO6OTLjV.MU9i4i4K2HzpCfKyHgKhRsTHR.', '{\"operator_prodi\":\"Teknik Informatika\",\"operator_nama\":\"Ahmad Zafrullah Mardiansyah., S.T., M.Eng.\",\"operator_nomor_hp\":\"087864052132\"}', 1),
('adminOPFD', 'Zaf', 'operator-prodi', 'adminOPFD', '$6$nuZMQ.8u$7j0RhAS5XQGXgqTsdc58tNOEiaG36S1gSyiKhW2ZXgFYhWYYmDKNO6OTLjV.MU9i4i4K2HzpCfKyHgKhRsTHR.', '{\"operator_prodi\":\"Teknik Informatika\",\"operator_nama\":\"Zaf\",\"operator_nomor_hp\":\"123\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `pengaturan_key` varchar(200) NOT NULL,
  `pengaturan_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan_key`, `pengaturan_value`) VALUES
('dekan_nama', 'I Gd Pasek Sutha Wijaya. ST.MT.Dr.Eng'),
('dekan_nip', '197311302000031001'),
('kaprodi_nama', 'Ahmad Zafrullah Mardiansyah., S.T., M.Eng.'),
('kaprodi_nip', '201803282192013'),
('pengumuman', ''),
('sekprodi_nama', 'Andy Hidayat Jatmika,ST.,M.Kom'),
('sekprodi_nip', '198312092012121001'),
('tahun_akademik_aktif', '20201'),
('wd1_nama', ''),
('wd1_nip', ''),
('wd2_nama', ''),
('wd2_nip', ''),
('wd3_nama', ''),
('wd3_nip', '');

-- --------------------------------------------------------

--
-- Table structure for table `pkl`
--

CREATE TABLE `pkl` (
  `pkl_id` int(11) NOT NULL,
  `pkl_waktu` datetime DEFAULT NULL,
  `pkl_waktu_update` datetime DEFAULT NULL,
  `pkl_tahun_akademik` int(5) DEFAULT NULL,
  `pkl_judul` varchar(200) DEFAULT NULL,
  `pkl_topik` text,
  `pkl_tanggal_mulai` date DEFAULT NULL,
  `pkl_tanggal_selesai` date DEFAULT NULL,
  `pkl_bimbingan_mulai` date DEFAULT NULL,
  `pkl_bimbingan_selesai` date DEFAULT NULL,
  `pkl_nomor_permohonan` varchar(25) DEFAULT NULL,
  `pkl_nomor_surat_tugas` varchar(25) DEFAULT NULL,
  `dosen_kode` varchar(25) DEFAULT NULL,
  `mahasiswa_nim` varchar(9) DEFAULT NULL,
  `data_tempat` text,
  `data_upload` text,
  `data_nilai` text,
  `data_ttd` text,
  `pkl_status` tinyint(1) DEFAULT NULL,
  `dosen_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pkl`
--

INSERT INTO `pkl` (`pkl_id`, `pkl_waktu`, `pkl_waktu_update`, `pkl_tahun_akademik`, `pkl_judul`, `pkl_topik`, `pkl_tanggal_mulai`, `pkl_tanggal_selesai`, `pkl_bimbingan_mulai`, `pkl_bimbingan_selesai`, `pkl_nomor_permohonan`, `pkl_nomor_surat_tugas`, `dosen_kode`, `mahasiswa_nim`, `data_tempat`, `data_upload`, `data_nilai`, `data_ttd`, `pkl_status`, `dosen_status`) VALUES
(1, '2020-07-03 00:08:42', '2020-10-27 00:33:04', 20202, 'asdf', 'asf', '2020-07-08', '2020-07-30', '2020-07-14', '2020-07-29', '123', '123', '201803282192013', 'F1D008004', '{\"nama\":\"asdf\",\"alamat\":\"asdf\",\"telepon\":\"123\",\"penanggung_jawab\":\"asdf\",\"penanggung_jawab_jabatan\":\"asdf\",\"penanggung_jawab_hp\":\"asdf\"}', '{\"transkrip_nilai\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/if\\/pkl\\/transkrip_nilai\\/F1D008004-1-2020_07_04-37874821_243082282991847_6911194436210786304_n.jpg\",\"balasan_tempat_pkl\":\"\"}', '', '{\"F1D008004\":{\"keterangan\":\"PKL AHMAD ZAFRULLAH (F1D008004) - asdf\",\"kode\":\"f5cfcffd887298ae61950cbc550c9053\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/F1D008004\\/f5cfcffd887298ae61950cbc550c9053-1603729967.png\"}}', 12, 21);

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `seminar_id` int(11) NOT NULL,
  `seminar_waktu` datetime DEFAULT NULL,
  `seminar_waktu_update` datetime DEFAULT NULL,
  `seminar_judul` text,
  `seminar_jadwal_tanggal` date DEFAULT NULL,
  `seminar_jadwal_waktu` time DEFAULT NULL,
  `seminar_jadwal_tempat` text,
  `dosen_kode` varchar(25) DEFAULT NULL,
  `mahasiswa_nim` varchar(9) DEFAULT NULL,
  `data_upload` text,
  `data_nilai` text,
  `data_ttd` text,
  `seminar_status` tinyint(1) DEFAULT NULL,
  `dosen_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_waktu` datetime DEFAULT NULL,
  `status_jenis` varchar(45) DEFAULT NULL COMMENT 'peserta, pendidikan, pembayaran',
  `status_jenis_id` varchar(20) DEFAULT NULL COMMENT 'id dari jenis status yang di-set',
  `status_status` int(11) DEFAULT NULL,
  `status_keterangan` text,
  `status_tahun_akademik` varchar(5) DEFAULT NULL,
  `operator_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_waktu`, `status_jenis`, `status_jenis_id`, `status_status`, `status_keterangan`, `status_tahun_akademik`, `operator_id`) VALUES
(1, '2020-07-03 00:17:13', 'pkl', '1', 0, '', '20201', 'F1D008004'),
(2, '2020-07-03 23:57:51', 'dp', '1', 11, '', '20201', 'F1D008004'),
(3, '2020-07-04 00:01:13', 'pkl', '1', 11, '', '20201', 'F1D008004'),
(4, '2020-07-06 01:40:02', 'pkl-dp', '1', 11, '', '20201', 'F1D008004'),
(5, '2020-07-06 01:40:14', 'pkl-dp', '1', 13, '', '20201', '201803282192013'),
(6, '2020-07-06 01:40:48', 'pkl', '1', 21, '', '20201', ''),
(7, '2020-07-06 01:43:40', 'pkl', '1', 21, '', '20201', ''),
(8, '2020-07-06 01:44:09', 'pkl', '1', 21, '', '20201', ''),
(9, '2020-07-06 01:44:55', 'pkl-dp', '1', 21, '', '20201', ''),
(10, '2020-07-06 01:45:09', 'pkl-dp', '1', 21, '', '20201', ''),
(11, '2020-07-06 01:46:09', 'pkl', '1', 12, '', '20201', '201803282192013');

-- --------------------------------------------------------

--
-- Table structure for table `tugasakhir`
--

CREATE TABLE `tugasakhir` (
  `ta_id` int(11) NOT NULL,
  `mahasiswa_nim` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_waktu` datetime DEFAULT NULL,
  `ta_waktu_update` datetime DEFAULT NULL,
  `ta_jenis` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_judul` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `ta_keterangan` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `ta_laporan` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `ta_berkas` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `ta_pembimbing1` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_pembimbing1_status` tinyint(2) DEFAULT NULL,
  `ta_pembimbing2` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_pembimbing2_status` tinyint(2) DEFAULT NULL,
  `ta_penguji1` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_penguji1_status` tinyint(2) DEFAULT NULL,
  `ta_penguji2` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_penguji2_status` tinyint(2) DEFAULT NULL,
  `ta_penguji3` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ta_penguji3_status` tinyint(2) DEFAULT NULL,
  `ta_status` tinyint(2) DEFAULT NULL,
  `jadwal_nomor` varchar(4) DEFAULT NULL,
  `jadwal_jam` varchar(10) DEFAULT NULL,
  `jadwal_tanggal` date DEFAULT NULL,
  `jadwal_tempat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `jadwal_status` tinyint(2) DEFAULT NULL,
  `nilai_angka` double DEFAULT NULL,
  `nilai_huruf` varchar(2) DEFAULT NULL,
  `nilai_data` text,
  `revisi_data` text,
  `ttd_data` text,
  `ttd_pengesahan_data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tugasakhir`
--

INSERT INTO `tugasakhir` (`ta_id`, `mahasiswa_nim`, `ta_waktu`, `ta_waktu_update`, `ta_jenis`, `ta_judul`, `ta_keterangan`, `ta_laporan`, `ta_berkas`, `ta_pembimbing1`, `ta_pembimbing1_status`, `ta_pembimbing2`, `ta_pembimbing2_status`, `ta_penguji1`, `ta_penguji1_status`, `ta_penguji2`, `ta_penguji2_status`, `ta_penguji3`, `ta_penguji3_status`, `ta_status`, `jadwal_nomor`, `jadwal_jam`, `jadwal_tanggal`, `jadwal_tempat`, `jadwal_status`, `nilai_angka`, `nilai_huruf`, `nilai_data`, `revisi_data`, `ttd_data`, `ttd_pengesahan_data`) VALUES
(5, 'F1D008004', '2020-04-16 07:00:34', '2020-05-06 15:54:31', 'ta1', 'Rapidiously extend B2C leadership skills vis-a-vis front-end process improvements. Interactively.', '', 'https://sgp1.digitaloceanspaces.com/unram/if/ta/F1D008004/laporan-1586991632-2020_04_16-thank_you_61672745___ssls_com.pdf', 'https://sgp1.digitaloceanspaces.com/unram/if/ta/F1D008004/berkas-1586991633-2020_04_16-thank_you_61672745___ssls_com_pdf.zip', '199012182012121002', 21, '201803282192013', 21, '197210191999032001', 21, '197506122000031001', 21, '197311302000031001', 21, 17, '', '', '9999-01-01', 'Zoom', 0, 0, '', '{\"201803282192013\":{\"aspek\":{\"1\":\"80\",\"2\":\"80\",\"3\":\"80\",\"4\":\"80\"},\"catatan\":\"asdf\",\"kesimpulan\":\"Layak Dengan Catatan\"}}', '', '{\"F1D008004\":{\"keterangan\":\"TA 1 AHMAD ZAFRULLAH (F1D008004) - Rapidiously extend B2C leadership skills vis-a-vis front-end process improvements. Interactively.\",\"kode\":\"7a5dfdb7322d1cc1012a29766877d8ea\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/F1D008004\\/7a5dfdb7322d1cc1012a29766877d8ea-1588751487.png\"}}', NULL),
(7, 'F1D012001', '2020-04-17 09:00:02', '2020-06-15 15:42:26', 'ta1', 'Phosfluorescently build team building human capital after granular process improvements.', '', 'https://sgp1.digitaloceanspaces.com/unram/if/ta/F1D012001/laporan-1587085328-2020_04_17-thank_you_61672745___ssls_com.pdf', 'https://sgp1.digitaloceanspaces.com/unram/if/ta/F1D012001/berkas-1587085330-2020_04_17-thank_you_61672745___ssls_com_pdf.zip', '199012182012121002', 18, '197506122000031001', 18, '201803282192013', 13, '197210191999032001', 18, '197311302000031001', 18, 31, '280', '22:55', '2020-04-16', 'Zoom', 0, 0, '', '{\"201803282192013\":{\"aspek\":{\"1\":\"80\",\"2\":\"80\",\"3\":\"80\",\"4\":\"80\"},\"catatan\":\"asdf\",\"kesimpulan\":\"Layak Dengan Catatan\"},\"199012182012121002\":{\"aspek\":{\"1\":\"80\",\"2\":\"80\",\"3\":\"80\",\"4\":\"80\"},\"catatan\":\"asdf\",\"kesimpulan\":\"Layak Tanpa Catatan\"},\"197506122000031001\":{\"aspek\":{\"1\":\"80\",\"2\":\"80\",\"3\":\"80\",\"4\":\"80\"},\"catatan\":\"asdf\",\"kesimpulan\":\"Layak Tanpa Catatan\"},\"197210191999032001\":{\"aspek\":{\"1\":\"80\",\"2\":\"80\",\"3\":\"80\",\"4\":\"80\"},\"catatan\":\"asdf\",\"kesimpulan\":\"Layak Dengan Catatan\"},\"197311302000031001\":{\"aspek\":{\"1\":\"89\",\"2\":\"77\",\"3\":\"89\",\"4\":\"68\"},\"catatan\":\"asdf\",\"kesimpulan\":\"Layak Dengan Catatan\"}}', '', '{\"201803282192013\":{\"keterangan\":\"TA 1 ADI SUGITA PANDEY (F1D012001) - Phosfluorescently build team building human capital after granular process improvements.\",\"kode\":\"0d895d62d1bdfa2d92f5ff325c5ea4b3\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/201803282192013\\/0d895d62d1bdfa2d92f5ff325c5ea4b3-1588425339.png\"}}', '{\"201803282192013\":{\"keterangan\":\"Lembar Pengesahan TA 1 ADI SUGITA PANDEY (F1D012001) - Phosfluorescently build team building human capital after granular process improvements.\",\"kode\":\"dc8fe8d73841093850cb8a65f161a8b4\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/201803282192013\\/dc8fe8d73841093850cb8a65f161a8b4-1592127117.png\",\"waktu\":\"2020-06-14 17:31:07\"}}'),
(10, 'F1D008004', '2020-04-21 12:09:52', '2020-06-14 17:54:20', 'ta2', 'Rapidiously extend B2C leadership skills vis-a-vis front-end process improvements. Interactively.', 'asdf', 'https://sgp1.digitaloceanspaces.com/unram/if/ta/F1D008004/laporan-1587442895-2020_04_21-thank_you_61672745___ssls_com.pdf', 'https://sgp1.digitaloceanspaces.com/unram/if/ta/F1D008004/berkas-1587442896-2020_04_21-thank_you_61672745___ssls_com_pdf.zip', '199012182012121002', 18, '197210191999032001', 18, '201803282192013', 13, '197506122000031001', 18, '198507072014042001', 18, 17, '290', '10:55', '2020-04-17', 'Zoom', 0, 0, '', '{\"197210191999032001\":{\"aspek\":{\"1\":\"90\",\"2\":\"90\",\"3\":\"90\",\"4\":\"90\",\"5\":\"90\"},\"catatan\":\"asdf\",\"kesimpulan\":\"LULUS\"},\"201803282192013\":{\"aspek\":{\"1\":\"80\",\"2\":\"80\",\"3\":\"80\",\"4\":\"80\",\"5\":\"80\"},\"catatan\":\"asdf\",\"kesimpulan\":\"LULUS\"}}', '{\"197210191999032001\":{\"aspek\":{\"1\":\"asdf\",\"2\":\"asdf\",\"3\":\"asdf\",\"4\":\"asdf\",\"5\":\"asdf\"}}}', '{\"201803282192013\":{\"waktu\":\"2020-06-13 19:27:18\"},\"197311302000031001\":{\"keterangan\":\"Lembar Pengesahan TA 2 AHMAD ZAFRULLAH (F1D008004) - Rapidiously extend B2C leadership skills vis-a-vis front-end process improvements. Interactively.\",\"kode\":\"5a6473f04fd5a8535c98a90251e515fa\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/197311302000031001\\/5a6473f04fd5a8535c98a90251e515fa-1592126934.png\",\"waktu\":\"2020-06-14 17:28:50\"}}', '{\"201803282192013\":{\"keterangan\":\"Lembar Pengesahan TA 2 AHMAD ZAFRULLAH (F1D008004) - Rapidiously extend B2C leadership skills vis-a-vis front-end process improvements. Interactively.\",\"kode\":\"ed5e4f6d81982ebcf8e55b9f4b3aab6c\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/201803282192013\\/ed5e4f6d81982ebcf8e55b9f4b3aab6c-1592047779.png\",\"waktu\":\"2020-06-13 19:29:32\"},\"197311302000031001\":{\"keterangan\":\"Lembar Pengesahan TA 2 AHMAD ZAFRULLAH (F1D008004) - Rapidiously extend B2C leadership skills vis-a-vis front-end process improvements. Interactively.\",\"kode\":\"9595e86ccd62937c02784b2f9dbb837d\",\"foto\":\"https:\\/\\/sgp1.digitaloceanspaces.com\\/unram\\/e-sign\\/ttd\\/197311302000031001\\/9595e86ccd62937c02784b2f9dbb837d-1592126999.png\",\"waktu\":\"2020-06-14 17:29:54\"}}'),
(11, 'F1D012002', '2020-05-03 08:09:12', '2020-05-03 08:09:12', 'ta2', 'asdf', 'asdf', '', '', '', 0, '', 0, '', 0, '', 0, '', 0, 0, '', '', '9999-01-01', '', 0, 0, '', '', '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`dosen_kode`),
  ADD KEY `dosen_kode` (`dosen_kode`),
  ADD KEY `dosen_nip` (`dosen_nip`,`dosen_nidn`,`dosen_nama`,`dosen_status`,`prodi_id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`mahasiswa_nim`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`,`mahasiswa_nama`,`prodi_id`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`operator_id`),
  ADD KEY `operator_id` (`operator_id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`pengaturan_key`),
  ADD KEY `pengaturan_key` (`pengaturan_key`);

--
-- Indexes for table `pkl`
--
ALTER TABLE `pkl`
  ADD PRIMARY KEY (`pkl_id`),
  ADD KEY `dosen_kode` (`dosen_kode`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`),
  ADD KEY `pkl_status` (`pkl_status`),
  ADD KEY `dosen_status` (`dosen_status`);

--
-- Indexes for table `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`seminar_id`),
  ADD KEY `dosen_kode` (`dosen_kode`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `operator_idx` (`operator_id`),
  ADD KEY `peserta_idx` (`status_jenis_id`),
  ADD KEY `status_id` (`status_id`,`status_waktu`,`status_jenis`,`status_status`);

--
-- Indexes for table `tugasakhir`
--
ALTER TABLE `tugasakhir`
  ADD PRIMARY KEY (`ta_id`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`),
  ADD KEY `ta_pembimbing1` (`ta_pembimbing1`,`ta_pembimbing2`,`ta_penguji1`,`ta_penguji2`,`ta_penguji3`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pkl`
--
ALTER TABLE `pkl`
  MODIFY `pkl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tugasakhir`
--
ALTER TABLE `tugasakhir`
  MODIFY `ta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
