DROP TABLE `pengantar`;

CREATE TABLE `pengantar`
(
    `pengantar_id`              INT NOT NULL AUTO_INCREMENT,
    `pengantar_waktu`           DATETIME NULL,
    `pengantar_waktu_update`    DATETIME NULL,
    `pengantar_tahun_akademik`  VARCHAR(5) NULL,
    `pengantar_tanggal_mulai`   DATE NULL,
    `pengantar_tanggal_selesai` DATE NULL,
    `pengantar_judul`           TEXT NULL,
    `pengantar_topik`           TEXT NULL,
    `pengantar_nomor`           VARCHAR(50) NULL,
    `pengantar_nomor_ext`       VARCHAR(50) NULL,
    `pengantar_data`            TEXT NULL,
    `pengantar_upload`          TEXT NULL,
    `pengantar_status`          TINYINT(4) NULL,
    `mahasiswa_nim`             VARCHAR(9) NULL,
    `tempat_id`                 INT NULL,
    PRIMARY KEY (`pengantar_id`)
);

ALTER TABLE `pengajuan`
DROP
`pengajuan_tanggal_mulai`,
  DROP
`pengajuan_tanggal_selesai`,
  DROP
`pengajuan_judul`,
  DROP
`pengajuan_topik`,
  DROP
`pengajuan_nomor_surat_tugas`,
  DROP
`mahasiswa_nim`;

ALTER TABLE `pengajuan` CHANGE `tempat_id` `pengantar_id` INT NULL DEFAULT NULL;