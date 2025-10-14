<?php

require_once '../../init.php';

$_nip = 'D00001';
$_obj_dosen = CDosen::_gi()->_get($_nip);
if (!$_obj_dosen) {
    $_obj_dosen = new MDosen();
    $_obj_dosen
        ->setDosenKode($_nip)
        ->setDosenNip($_nip)
        ->setDosenNidn($_nip)
        ->setDosenNama('Coba')
        ->setDosenNomorHp('081234567890')
        ->setDosenEmail('mail@domain.com')
        ->setDosenFoto('')
        ->setDosenStatus(1)
        ->setProdiId(552011);
    CDosen::_gi()->_insert($_obj_dosen);
}

Sessions::_gi()->_set(
    Helpers::dir_dosen, $_nip, $_obj_dosen);

Helpers::_redirect(Helpers::_a(Helpers::$_dir_default_page_map[Helpers::dir_dosen]));