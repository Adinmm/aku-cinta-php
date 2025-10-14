<?php

require_once '../../init.php';

$_kode = 'OP00001';
$_obj_operator = COperator::_gi()->_get_by_id($_kode);
if (!$_obj_operator) {
    $_obj_operator = new MOperator();
    $_obj_operator
        ->setOperatorId($_kode)
        ->setOperatorNama('Coba')
        ->setOperatorJenis('operator-prodi')
        ->setOperatorUsername($_kode)
        ->setOperatorPassword('')
        ->setOperatorMetas('')
        ->setOperatorStatus(1);
    COperator::_gi()->_insert($_obj_operator);
}

Sessions::_gi()->_set(
    Helpers::dir_operator_prodi, $_kode, $_obj_operator);

Helpers::_redirect(Helpers::_a(Helpers::$_dir_default_page_map[Helpers::dir_operator_prodi]));