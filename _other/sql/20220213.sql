CREATE TABLE `tempat`
(
    `tempat_id`           INT NOT NULL AUTO_INCREMENT,
    `tempat_waktu`        DATETIME NULL,
    `tempat_waktu_update` DATETIME NULL,
    `tempat_nama`         VARCHAR(100) NULL,
    `tempat_alamat`       TEXT NULL,
    `tempat_telpon`       VARCHAR(50) NULL,
    `tempat_pic`          VARCHAR(100) NULL,
    `tempat_pic_jabatan`      VARCHAR(100) NULL,
    `tempat_pic_hp`       VARCHAR(50) NULL,
    `tempat_keterangan`   TEXT NULL,
    `tempat_status`       TINYINT(4) NULL,
    PRIMARY KEY (`tempat_id`)
);