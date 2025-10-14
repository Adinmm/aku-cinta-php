ALTER TABLE `mahasiswa` DROP `dosen_pa_nip`;
ALTER TABLE `mahasiswa` CHANGE `dosen_pa_nama` `dosen_pa_kode` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `mahasiswa` ADD INDEX(`dosen_pa_kode`);
ALTER TABLE `persetujuan` DROP `dosen_kode`;