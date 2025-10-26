-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Waktu pembuatan: 26 Okt 2025 pada 09.49
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
  `nama` text NOT NULL,
  `mahasiswa_nim` varchar(20) NOT NULL,
  `jkem` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal` date NOT NULL,
  `uraian` text NOT NULL,
  `target` text,
  `foto` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `logbook`
--

INSERT INTO `logbook` (`id`, `nama`, `mahasiswa_nim`, `jkem`, `tanggal`, `uraian`, `target`, `foto`, `created_at`) VALUES
(34, 'Nama 1', '12345', '10', '2025-10-21', 'Manchester United Football Club adalah sebuah klub sepak bola profesional yang berbasis di Old Trafford, Manchester Raya, Inggris, dan bermain di Liga Utama Inggris. Klub ini memiliki 20 gelar Liga Inggris dengan 13 di antaranya di era Liga Utama, terbanyak sepanjang masa. Didirikan sebagai Newton Heath LYR Football Club pada tahun 1878, klub ini berganti nama menjadi Manchester United pada 1902 dan pindah ke Old Trafford pada tahun 1910.\r\n\r\nManchester United telah memenangkan banyak trofi di sepak bola Inggris, termasuk 20 gelar Liga—terbanyak dalam sejarah, 13 gelar Piala FA, 6 gelar Piala Liga dan 21 gelar Community Shield FA—juga terbanyak dalam sejarah. Klub ini juga telah memenangkan tiga gelar Piala/Liga Champions, satu Liga Eropa UEFA, satu Piala Winners UEFA, satu Piala Super UEFA, satu Piala Interkontinental, dan satu Piala Dunia Antarklub FIFA—klub Inggris pertama yang menjuarai ajang ini. Pada musim 1998–1999, klub ini memenangkan treble (trigelar) dari Liga Utama, Piala FA, dan Liga Champions; prestasi ini belum pernah terjadi sebelumnya untuk klub Inggris. Manchester United juga merupakan salah satu klub tersukses sepanjang masa di Inggris.', 'Manchester United Football Club adalah sebuah klub sepak bola profesional yang berbasis di Old Trafford, Manchester Raya, Inggris, dan bermain di Liga Utama Inggris. Klub ini memiliki 20 gelar Liga Inggris dengan 13 di antaranya di era Liga Utama, ', '[\"foto_68f70245ce350.png\"]', '2025-10-21 03:47:17'),
(35, 'Nama 3', '2222', '6', '2025-10-24', 'vghuijk', 'gvyhuij', '[\"foto_68fa3a23932a8.png\",\"foto_68fa3a2395562.png\",\"foto_68fa3a23972e0.png\"]', '2025-10-23 14:22:27');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `operator`
--
ALTER TABLE `operator`
  MODIFY `operator_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
