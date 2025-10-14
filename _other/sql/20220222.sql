DROP TABLE `seminar`, `surattugas`, `tugasakhir`;

CREATE TABLE `seminar`
(
    `seminar_id`           int NOT NULL,
    `seminar_waktu`        datetime    DEFAULT NULL,
    `seminar_waktu_update` datetime    DEFAULT NULL,
    `seminar_judul`        text,
    `seminar_jam`          time        DEFAULT NULL,
    `seminar_tanggal`      date        DEFAULT NULL,
    `seminar_tempat`       text CHARACTER SET utf8 COLLATE utf8_general_ci,
    `seminar_nomor`        varchar(50) DEFAULT NULL,
    `seminar_status`       tinyint(1) DEFAULT NULL,
    `seminar_data`         text CHARACTER SET utf8 COLLATE utf8_general_ci,
    `seminar_nilai`        text CHARACTER SET utf8 COLLATE utf8_general_ci,
    `seminar_upload`       text,
    `seminar_ttd`          text CHARACTER SET utf8 COLLATE utf8_general_ci,
    `pengajuan_id`         int         DEFAULT NULL
);

ALTER TABLE `seminar`
    ADD PRIMARY KEY (`seminar_id`);

ALTER TABLE `seminar` CHANGE `seminar_id` `seminar_id` INT NOT NULL AUTO_INCREMENT;

ALTER TABLE `seminar` CHANGE `seminar_jam` `seminar_jam` VARCHAR (25) NULL DEFAULT NULL;