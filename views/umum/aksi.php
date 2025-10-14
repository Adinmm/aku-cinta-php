<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

set_time_limit(0);

switch (Routes::_gi()->_depth(2)) {

    case Helpers::action_language:

        Sessions::_gi()->_lang_set(Routes::_gi()->_depth(3));
        Helpers::_redirect(
            Helpers::_arr($_REQUEST, 'redirect', URI_PATH));

        break;

    case Helpers::page_akun:

        $_page = Helpers::_arr($_REQUEST, '_page');
        $_operator_password = Helpers::_arr($_REQUEST, 'operator_password_new');

        $_operator_id = Routes::_gi()->_depth(4);

        if ($_operator_id)
            $obj_operator = COperator::_gi()->_get_by_id($_operator_id);

        else
            $obj_operator = Sessions::_gi()->_get(Routes::_gi()->_depth(3), 1);

        $obj_operator
            ->_init($_REQUEST)
            ->parseOperatorJenis();

        if ($_operator_password)
            $obj_operator->setOperatorPassword(md5($_operator_password));

        COperator::_gi()->_update($obj_operator);
        Helpers::_redirect(
            Helpers::_a($_page . DS . Helpers::page_akun . DS . ($_operator_id ? $_operator_id : Helpers::status_success)));

        break;

}

die();