<?php

class i18n
{

    const SESSION_NAME = 'LANG_ACTIVE';

    const lang_id = 'id';
    const lang_en = 'en';

    const lang_default = self::lang_id;

    public static $_lang = [
        self::lang_id => 'Bahasa',
        self::lang_en => 'English',
    ];

    public static function translate($str, $domain = '', $print = true)
    {
        global $_strings;
        if ($_domain = $_strings[$domain] ?? []) {
            $_tmp = $_domain[$str] ?? '';
            if (!$_tmp)
                $_tmp = $_strings[$str] ?? $str;
        } else $_tmp = $_strings[$str] ?? $str;
        if ($print) echo $_tmp;
        else return $_tmp;
    }
}

/**
 * @param $str
 * @param $domain
 * @param $print
 * @return void|string
 */
function __($str, $domain = '', $print = true)
{
    return i18n::translate($str, $domain, $print);
}

require_once(sprintf('%s.php', Sessions::_gi()->_lang_get()));