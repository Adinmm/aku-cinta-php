<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

Sessions::_gi()->_destroy();
//Helpers::_redirect(URI_PATH . DS . Helpers::page_index);
Helpers::_redirect(Helpers::_sso(true));