CREATE TABLE `pengajuan`
(
    `pengajuan_id`                        INT NOT NULL AUTO_INCREMENT,
    `pengajuan_waktu`                     DATETIME NULL,
    `pengajuan_waktu_update`              DATETIME NULL,
    `pengajuan_tahun_akademik`            VARCHAR(5) NULL,
    `pengajuan_tanggal_mulai`             DATETIME NULL,
    `pengajuan_tanggal_selesai`           DATETIME NULL,
    `pengajuan_judul`                     VARCHAR(150) NULL,
    `pengajuan_topik`                     TEXT NULL,
    `pengajuan_bimbingan_tanggal_mulai`   DATETIME NULL,
    `pengajuan_bimbingan_tanggal_selesai` DATETIME NULL,
    `pengajuan_nomor`                     VARCHAR(50) NULL,
    `pengajuan_nomor_ext`                 VARCHAR(50) NULL,
    `pengajuan_nomor_surat_tugas`         VARCHAR(50) NULL,
    `pengajuan_data`                      TEXT NULL,
    `pengajuan_upload`                    TEXT NULL,
    `pengajuan_status`                    TINYINT(4) NULL,
    `mahasiswa_nim`                       VARCHAR(9) NULL,
    `tempat_id`                           INT NULL,
    `dosen_kode`                          VARCHAR(25) NULL,
    PRIMARY KEY (`pengajuan_id`)
);

ALTER TABLE `pengajuan` CHANGE `pengajuan_bimbingan_tanggal_mulai` `pengajuan_bimbingan_tanggal_mulai` VARCHAR (25) NULL DEFAULT NULL, CHANGE `pengajuan_bimbingan_tanggal_selesai` `pengajuan_bimbingan_tanggal_selesai` VARCHAR (25) NULL DEFAULT NULL;

ALTER TABLE `pengajuan` CHANGE `pengajuan_tanggal_mulai` `pengajuan_tanggal_mulai` DATE NULL DEFAULT NULL, CHANGE `pengajuan_tanggal_selesai` `pengajuan_tanggal_selesai` DATE NULL DEFAULT NULL;