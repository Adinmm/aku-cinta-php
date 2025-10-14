<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

/** @var MOperator $obj_operator */

global $page_title, $obj_operator, $_page, $_operator_id;
$_page = Helpers::page_op;

$_operator_id = Routes::_gi()->_depth(2);

if ($_operator_id)
    $obj_operator = COperator::_gi()->_get_by_id($_operator_id);

else $obj_operator = Sessions::_gi()->_get(Helpers::$_dir_map[$_page], 1);

include_once ABS_VIEW_PATH . DS . Helpers::dir_umum . DS . 'akun.php';