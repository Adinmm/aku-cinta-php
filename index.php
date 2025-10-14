<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'init.php';

Helpers::_validate_URI($_SERVER);

try {
    Helpers::_validate_URI($_SERVER);
    
    if (empty(Routes::_gi()->_depths())) {
        Helpers::_redirect(Helpers::_a(Helpers::page_beranda));
    } else {
        Routes::_gi()->_render();
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    echo '<br>File: ' . $e->getFile();
    echo '<br>Line: ' . $e->getLine();
}

if (empty(Routes::_gi()->_depths()))
    Helpers::_redirect(
        Helpers::_a(Helpers::page_beranda));
else 
    Routes::_gi()->_render();

Routes::_gi()->_render();