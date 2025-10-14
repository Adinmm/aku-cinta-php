ALTER TABLE `persetujuan`
    ADD `persetujuan_upload` TEXT NULL AFTER `persetujuan_data`, ADD `persetujuan_ttd` TEXT NULL AFTER `persetujuan_upload`;

CREATE TABLE `bimbingan`
(
    `bimbingan_id`           int NOT NULL,
    `bimbingan_waktu`        datetime    DEFAULT NULL,
    `bimbingan_waktu_update` datetime    DEFAULT NULL,
    `bimbingan_jenis`        varchar(50) DEFAULT NULL,
    `bimbingan_keterangan`   text,
    `bimbingan_status`       tinyint     DEFAULT NULL,
    `mahasiswa_nim`          varchar(9)  DEFAULT NULL,
    `dosen_kode`             varchar(25) DEFAULT NULL
);

ALTER TABLE `bimbingan`
    ADD PRIMARY KEY (`bimbingan_id`),
  ADD KEY `mahasiswa_nim` (`mahasiswa_nim`),
  ADD KEY `dosen_kode` (`dosen_kode`),
  ADD KEY `bimbingan_status` (`bimbingan_status`);

ALTER TABLE `bimbingan`
    MODIFY `bimbingan_id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `pesan`
(
    `pesan_id`     int NOT NULL,
    `pesan_waktu`  datetime    DEFAULT NULL,
    `pesan_jenis`  varchar(50) DEFAULT NULL,
    `pesan_isi`    text,
    `pesan_berkas` text,
    `pesan_status` tinyint     DEFAULT NULL,
    `bimbingan_id` int         DEFAULT NULL
);

ALTER TABLE `pesan`
    ADD PRIMARY KEY (`pesan_id`),
  ADD KEY `bimbingan_status` (`bimbingan_id`);

ALTER TABLE `pesan`
    MODIFY `pesan_id` int NOT NULL AUTO_INCREMENT;