-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Waktu pembuatan: 29 Okt 2025 pada 04.50
-- Versi server: 8.0.43
-- Versi PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `dummy_DB`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bimbingan`
--

CREATE TABLE `bimbingan` (
  `bimbingan_id` int NOT NULL,
  `bimbingan_waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bimbingan_waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bimbingan_jenis` int DEFAULT '1',
  `bimbingan_keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `bimbingan_status` int DEFAULT '1',
  `mahasiswa_nim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosen_kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bimbingan`
--

INSERT INTO `bimbingan` (`bimbingan_id`, `bimbingan_waktu`, `bimbingan_waktu_update`, `bimbingan_jenis`, `bimbingan_keterangan`, `bimbingan_status`, `mahasiswa_nim`, `dosen_kode`) VALUES
(1, '2025-09-02 07:16:47', '2025-09-02 07:16:47', 1, 'Bimbingan Pendahuluan dan Penentuan Topik', 2, 'E1E122001', 'DSN002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `dosen_kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosen_nip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosen_nidn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosen_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosen_nomor_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosen_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosen_foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `dosen_status` tinyint(1) DEFAULT '1',
  `prodi_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`dosen_kode`, `dosen_nip`, `dosen_nidn`, `dosen_nama`, `dosen_nomor_hp`, `dosen_email`, `dosen_foto`, `dosen_status`, `prodi_id`) VALUES
('DSN001', '198505152010011001', '0015058501', 'Dr. Budi Santoso, M.Kom.', '081234567890', 'budi.s@example.ac.id', NULL, 1, 1),
('DSN002', '198808202012012002', '0020088802', 'Siti Aminah, S.T., M.Cs.', '081298765432', 'siti.a@example.ac.id', NULL, 1, 1),
('DSN003', '199001102015031003', '0010019003', 'Dr. Agus Wijaya, S.Kom., M.M.', '081122334455', 'agus.w@example.ac.id', NULL, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `logbook`
--

CREATE TABLE `logbook` (
  `id` int NOT NULL,
  `seminar_id` int DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mahasiswa_nim` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `jkem` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `uraian` text COLLATE utf8mb4_general_ci,
  `target` text COLLATE utf8mb4_general_ci,
  `foto` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `logbook`
--

INSERT INTO `logbook` (`id`, `seminar_id`, `nama`, `mahasiswa_nim`, `jkem`, `tanggal`, `uraian`, `target`, `foto`, `created_at`) VALUES
(1, 1, 'Ahmad Rizki', 'F1D021001', '6', '2025-10-20', 'Membuat tampilan awal halaman seminar', 'Selesai desain UI', '[\"foto_ui1.jpg\", \"foto_ui2.jpg\"]', '2025-10-29 01:34:06'),
(2, 2, 'Siti Nuraini', 'F1D021002', '9', '2025-10-21', 'Mendesain struktur tabel untuk seminar', 'Selesai tabel awal', '[\"db_schema.png\", \"db_relation.jpg\"]', '2025-10-29 01:34:06'),
(3, 3, 'Muhammad Daffa', 'F1D021003', '10', '2025-10-22', 'Implementasi komponen React untuk form seminar', 'Integrasi API form', '[\"react_form.png\", \"form_submit.jpg\"]', '2025-10-29 01:34:06'),
(4, 4, 'Nurul Hidayah', 'F1D021004', '5', '2025-10-23', 'Membuat API CRUD seminar', 'Selesai endpoint POST dan GET', '[\"api_test1.png\", \"postman_result.png\"]', '2025-10-29 01:34:06'),
(5, 5, 'Lukman Hakim', 'F1D021005', '8', '2025-10-24', 'Menghubungkan logbook dengan seminar', 'Testing relasi database', '[\"relasi_er.png\", \"testing_result.jpg\"]', '2025-10-29 01:34:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `mahasiswa_nim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mahasiswa_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mahasiswa_nomor_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mahasiswa_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mahasiswa_kuliah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Aktif',
  `mahasiswa_foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `dosen_pa_kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prodi_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`mahasiswa_nim`, `mahasiswa_nama`, `mahasiswa_nomor_hp`, `mahasiswa_email`, `mahasiswa_kuliah`, `mahasiswa_foto`, `dosen_pa_kode`, `prodi_id`) VALUES
('E1E122001', 'Andi Pratama', '085211112222', 'andi.p@student.example.ac.id', 'Aktif', NULL, 'DSN001', 1),
('E1E122002', 'Citra Lestari', '085333334444', 'citra.l@student.example.ac.id', 'Aktif', NULL, 'DSN002', 1),
('F1F122001', 'Farhan Ghifari', '087812345678', 'farhan.g@student.example.ac.id', 'Aktif', NULL, 'DSN003', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operator`
--

CREATE TABLE `operator` (
  `operator_id` int NOT NULL,
  `operator_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `operator_jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `operator_username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `operator_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `operator_metas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `operator_status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `operator`
--

INSERT INTO `operator` (`operator_id`, `operator_nama`, `operator_jenis`, `operator_username`, `operator_password`, `operator_metas`, `operator_status`) VALUES
(1, 'Admin Utama', 'admin', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', '{\"role\": \"superuser\"}', 1),
(2, 'Operator TI', 'operator:prodi', 'operator_ti', '5f4dcc3b5aa765d61d8327deb882cf99', '{\"prodi_id\": 1}', 1),
(3, 'Coba', 'operator-prodi', 'OP00001', '', '\"\"', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `pengajuan_id` int NOT NULL,
  `pengajuan_waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pengajuan_waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pengajuan_tahun_akademik` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pengajuan_bimbingan_tanggal_mulai` date DEFAULT NULL,
  `pengajuan_bimbingan_tanggal_selesai` date DEFAULT NULL,
  `pengajuan_nomor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pengajuan_nomor_ext` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pengajuan_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pengajuan_upload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pengajuan_ttd` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pengajuan_status` tinyint(1) DEFAULT '0',
  `pengantar_id` int NOT NULL,
  `dosen_kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`pengajuan_id`, `pengajuan_waktu`, `pengajuan_waktu_update`, `pengajuan_tahun_akademik`, `pengajuan_bimbingan_tanggal_mulai`, `pengajuan_bimbingan_tanggal_selesai`, `pengajuan_nomor`, `pengajuan_nomor_ext`, `pengajuan_data`, `pengajuan_upload`, `pengajuan_ttd`, `pengajuan_status`, `pengantar_id`, `dosen_kode`) VALUES
(1, '2025-09-02 07:16:47', '2025-09-02 07:16:47', '20241', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 'DSN002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengantar`
--

CREATE TABLE `pengantar` (
  `pengantar_id` int NOT NULL,
  `pengantar_waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pengantar_waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pengantar_tahun_akademik` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pengantar_tanggal_mulai` date DEFAULT NULL,
  `pengantar_tanggal_selesai` date DEFAULT NULL,
  `pengantar_judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pengantar_topik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `pengantar_nomor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pengantar_nomor_ext` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pengantar_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pengantar_upload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pengantar_ttd` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `pengantar_status` tinyint(1) DEFAULT '0',
  `mahasiswa_nim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengantar`
--

INSERT INTO `pengantar` (`pengantar_id`, `pengantar_waktu`, `pengantar_waktu_update`, `pengantar_tahun_akademik`, `pengantar_tanggal_mulai`, `pengantar_tanggal_selesai`, `pengantar_judul`, `pengantar_topik`, `pengantar_nomor`, `pengantar_nomor_ext`, `pengantar_data`, `pengantar_upload`, `pengantar_ttd`, `pengantar_status`, `mahasiswa_nim`, `tempat_id`) VALUES
(1, '2025-09-02 07:16:47', '2025-09-02 07:16:47', '20241', '2025-02-01', '2025-05-01', 'Analisis dan Implementasi Sistem Monitoring Jaringan', NULL, NULL, NULL, NULL, NULL, NULL, 2, 'E1E122001', 1),
(2, '2025-09-02 07:16:47', '2025-09-02 07:16:47', '20241', '2025-02-15', '2025-05-15', 'Pengembangan Aplikasi Mobile untuk Pelayanan Publik', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'F1F122001', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `pengaturan_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pengaturan_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan_key`, `pengaturan_value`) VALUES
('app_name', 'Sistem Informasi PKL'),
('app_version', '1.0.0'),
('current_academic_year', '20241');

-- --------------------------------------------------------

--
-- Struktur dari tabel `persetujuan`
--

CREATE TABLE `persetujuan` (
  `persetujuan_id` int NOT NULL,
  `persetujuan_waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `persetujuan_waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `persetujuan_tahun_akademik` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `persetujuan_status` tinyint(1) DEFAULT '0',
  `persetujuan_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `persetujuan_upload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `persetujuan_ttd` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `mahasiswa_nim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `persetujuan`
--

INSERT INTO `persetujuan` (`persetujuan_id`, `persetujuan_waktu`, `persetujuan_waktu_update`, `persetujuan_tahun_akademik`, `persetujuan_status`, `persetujuan_data`, `persetujuan_upload`, `persetujuan_ttd`, `mahasiswa_nim`) VALUES
(1, '2025-09-02 07:16:47', '2025-09-02 07:16:47', '20241', 2, NULL, NULL, NULL, 'E1E122001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan`
--

CREATE TABLE `pesan` (
  `pesan_id` int NOT NULL,
  `pesan_waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pesan_jenis` int NOT NULL,
  `pesan_isi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `pesan_berkas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pesan_status` int DEFAULT '0',
  `bimbingan_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesan`
--

INSERT INTO `pesan` (`pesan_id`, `pesan_waktu`, `pesan_jenis`, `pesan_isi`, `pesan_berkas`, `pesan_status`, `bimbingan_id`) VALUES
(1, '2025-09-02 07:16:47', 1, 'Selamat pagi, Bu. Saya Andi, mahasiswa bimbingan Ibu. Saya ingin mengajukan Bab 1 untuk direview.', 'proposal_bab1_andi.pdf', 1, 1),
(2, '2025-09-02 07:16:47', 2, 'Baik, Andi. Silakan diunggah filenya. Nanti saya periksa segera.', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `prodi_id` int NOT NULL,
  `prodi_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`prodi_id`, `prodi_nama`) VALUES
(1, 'Teknik Informatika'),
(2, 'Magister Teknik Informatika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seminar`
--

CREATE TABLE `seminar` (
  `seminar_id` int NOT NULL,
  `pengajuan_id` int DEFAULT NULL,
  `seminar_judul` text COLLATE utf8mb4_general_ci,
  `seminar_tempat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `seminar_nomor` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `seminar_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `seminar_nilai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `seminar_upload` text COLLATE utf8mb4_general_ci,
  `seminar_ttd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `seminar_tanggal` date DEFAULT NULL,
  `seminar_jam` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `seminar_waktu` datetime DEFAULT NULL,
  `seminar_waktu_update` datetime DEFAULT NULL,
  `seminar_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `seminar`
--

INSERT INTO `seminar` (`seminar_id`, `pengajuan_id`, `seminar_judul`, `seminar_tempat`, `seminar_nomor`, `seminar_data`, `seminar_nilai`, `seminar_upload`, `seminar_ttd`, `seminar_tanggal`, `seminar_jam`, `seminar_waktu`, `seminar_waktu_update`, `seminar_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Implementasi Sistem Informasi Pertanian di Kabupaten Sumbawa', 'Aula Dinas Pertanian Sumbawa', 'SMR-001', 'Data peserta lengkap dan sudah diverifikasi', 'A', 'upload_berkas_1.pdf', 'ttd_ketua_1.png', '2025-10-30', '09:00', '2025-10-30 09:00:00', NULL, 0, '2025-10-29 01:23:42', '2025-10-29 01:46:28'),
(2, 2, 'Rancang Bangun Website Wisata Desa Pemepek', 'Ruang Seminar Universitas Mataram', 'SMR-002', 'Data presentasi sudah diterima', 'B+', 'upload_berkas_2.pdf', 'ttd_ketua_2.png', '2025-11-02', '10:30', '2025-11-02 10:30:00', NULL, 1, '2025-10-29 01:23:42', '2025-10-29 01:23:42'),
(3, 3, 'Analisis Keamanan Jaringan pada Infrastruktur Kampus', 'Gedung FTI Lantai 3', 'SMR-003', 'Masih menunggu validasi nilai', NULL, 'upload_berkas_3.pdf', NULL, '2025-11-05', '13:00', '2025-11-05 13:00:00', NULL, 0, '2025-10-29 01:23:42', '2025-10-29 01:23:42'),
(4, 4, 'Pengembangan Aplikasi Pemesanan Produk Lokal Berbasis Web', 'Aula Fakultas Ekonomi', 'SMR-004', 'Data seminar sudah lengkap', 'A-', 'upload_berkas_4.pdf', 'ttd_ketua_4.png', '2025-11-07', '08:30', '2025-11-07 08:30:00', NULL, 1, '2025-10-29 01:23:42', '2025-10-29 01:23:42'),
(5, 5, 'Penerapan Machine Learning untuk Prediksi Cuaca Pertanian', 'Ruang Lab Informatika 2', 'SMR-005', 'Data pengujian model telah disetujui', 'A', 'upload_berkas_5.pdf', 'ttd_ketua_5.png', '2025-11-10', '11:00', '2025-11-10 11:00:00', NULL, 1, '2025-10-29 01:23:42', '2025-10-29 01:23:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tempat`
--

CREATE TABLE `tempat` (
  `tempat_id` int NOT NULL,
  `tempat_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tempat`
--

INSERT INTO `tempat` (`tempat_id`, `tempat_nama`, `tempat_alamat`) VALUES
(1, 'PT. Teknologi Maju Bersama', 'Jl. Sudirman No. 123, Jakarta'),
(2, 'Dinas Komunikasi dan Informatika', 'Jl. Pahlawan No. 45, Surabaya');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`bimbingan_id`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`),
  ADD KEY `dosen_kode` (`dosen_kode`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`dosen_kode`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_logbook_seminar` (`seminar_id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`mahasiswa_nim`),
  ADD KEY `dosen_pa_kode` (`dosen_pa_kode`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indeks untuk tabel `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`operator_id`),
  ADD UNIQUE KEY `operator_username` (`operator_username`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`pengajuan_id`),
  ADD KEY `pengantar_id` (`pengantar_id`),
  ADD KEY `dosen_kode` (`dosen_kode`);

--
-- Indeks untuk tabel `pengantar`
--
ALTER TABLE `pengantar`
  ADD PRIMARY KEY (`pengantar_id`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`),
  ADD KEY `tempat_id` (`tempat_id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`pengaturan_key`);

--
-- Indeks untuk tabel `persetujuan`
--
ALTER TABLE `persetujuan`
  ADD PRIMARY KEY (`persetujuan_id`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`);

--
-- Indeks untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`pesan_id`),
  ADD KEY `bimbingan_id` (`bimbingan_id`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`prodi_id`);

--
-- Indeks untuk tabel `seminar`
--
ALTER TABLE `seminar`
  ADD PRIMARY KEY (`seminar_id`);

--
-- Indeks untuk tabel `tempat`
--
ALTER TABLE `tempat`
  ADD PRIMARY KEY (`tempat_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bimbingan`
--
ALTER TABLE `bimbingan`
  MODIFY `bimbingan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `operator`
--
ALTER TABLE `operator`
  MODIFY `operator_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `pengajuan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengantar`
--
ALTER TABLE `pengantar`
  MODIFY `pengantar_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `persetujuan`
--
ALTER TABLE `persetujuan`
  MODIFY `persetujuan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pesan`
--
ALTER TABLE `pesan`
  MODIFY `pesan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `prodi`
--
ALTER TABLE `prodi`
  MODIFY `prodi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `seminar`
--
ALTER TABLE `seminar`
  MODIFY `seminar_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tempat`
--
ALTER TABLE `tempat`
  MODIFY `tempat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_ibfk_1` FOREIGN KEY (`mahasiswa_nim`) REFERENCES `mahasiswa` (`mahasiswa_nim`) ON DELETE CASCADE,
  ADD CONSTRAINT `bimbingan_ibfk_2` FOREIGN KEY (`dosen_kode`) REFERENCES `dosen` (`dosen_kode`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`prodi_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `logbook`
--
ALTER TABLE `logbook`
  ADD CONSTRAINT `fk_logbook_seminar` FOREIGN KEY (`seminar_id`) REFERENCES `seminar` (`seminar_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`dosen_pa_kode`) REFERENCES `dosen` (`dosen_kode`) ON DELETE SET NULL,
  ADD CONSTRAINT `mahasiswa_ibfk_2` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`prodi_id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`pengantar_id`) REFERENCES `pengantar` (`pengantar_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_ibfk_2` FOREIGN KEY (`dosen_kode`) REFERENCES `dosen` (`dosen_kode`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengantar`
--
ALTER TABLE `pengantar`
  ADD CONSTRAINT `pengantar_ibfk_1` FOREIGN KEY (`mahasiswa_nim`) REFERENCES `mahasiswa` (`mahasiswa_nim`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengantar_ibfk_2` FOREIGN KEY (`tempat_id`) REFERENCES `tempat` (`tempat_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `persetujuan`
--
ALTER TABLE `persetujuan`
  ADD CONSTRAINT `persetujuan_ibfk_1` FOREIGN KEY (`mahasiswa_nim`) REFERENCES `mahasiswa` (`mahasiswa_nim`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`bimbingan_id`) REFERENCES `bimbingan` (`bimbingan_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
