<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $obj_bimbingan;

$_bimbingan_id = Routes::_gi()->_depth(3);

if (is_numeric($_bimbingan_id)) {
    $obj_bimbingan = CBimbingan::_gi()->_get($_bimbingan_id);
    Routes::_gi()->_render(2, Helpers::dir_operator_prodi . DS . Helpers::op_bimbingan . '-');

} else Routes::_gi()->_render(1, Helpers::dir_operator_prodi . DS);