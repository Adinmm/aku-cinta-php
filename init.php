<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

date_default_timezone_set('Asia/Makassar');

require_once 'config.php';

define('ABS_PATH', dirname(__FILE__));


const DS = '/';
const ABS_VIEW_PATH = ABS_PATH . DS . 'views';
const ABS_MODEL_PATH = ABS_PATH . DS . 'models';
const ABS_CONTROLLER_PATH = ABS_PATH . DS . 'controllers';
const ABS_PLUGIN_PATH = ABS_PATH . DS . 'plugins';

const URI_ASSET_PATH = URI_PATH . DS . 'assets';
const URI_CSS_PATH = URI_ASSET_PATH . DS . 'css';
const URI_JS_PATH = URI_ASSET_PATH . DS . 'js';
const URI_IMG_PATH = URI_ASSET_PATH . DS . 'img';

spl_autoload_register(function ($class) {

    $parts = explode('\\', $class);

    $script_file = $parts[0] . '.php';

    $class_model = ABS_MODEL_PATH . DS . $script_file;
    if (is_readable($class_model))
        require_once $class_model;

    $class_controller = ABS_CONTROLLER_PATH . DS . $script_file;
    if (is_readable($class_controller))
        require_once $class_controller;

});

//include_once ABS_PLUGIN_PATH . DS . 'S3.php';
include_once ABS_PLUGIN_PATH . DS . 'aws/aws-autoloader.php';

function minify_HTML($buffer)
{
    return Helpers::_minify_HTML_output($buffer);
}

Routes::_gi()->_init();

session_start();

require(sprintf('%s/i18n/init.php', ABS_PLUGIN_PATH));