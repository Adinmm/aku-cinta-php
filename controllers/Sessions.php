<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class Sessions
{

    const SESSION_NAME = '___UNRAM_IF_PKL';

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    public function _destroy()
    {
        unset($_SESSION[self::SESSION_NAME]);
        session_destroy();
    }

    /**
     * @param $dir
     * @param $id
     * @param $obj MOperator
     */
    public function _set($dir, $id, $obj = null)
    {
        $_SESSION[self::SESSION_NAME][$dir] = array($id, $obj);
    }

    /**
     * @param $dir
     * @param int $index
     * @return boolean|array|MMahasiswa|MDosen|MOperator
     */
    public function _get($dir, $index = 0)
    {
        return $this->_has($dir, $index) ? $_SESSION[self::SESSION_NAME][$dir][$index] : false;
    }

    public function _get_id()
    {
        $_id = false;
        foreach (Helpers::$_dir_map as $_k => $_v) {
            if (!$_id) $_id = $this->_get($_v);
            else break;
        }
        return $_id;
    }

    /**
     * @param $dir
     * @param int $index
     * @return bool
     */
    public function _has($dir, $index = 0)
    {
        return isset($_SESSION[self::SESSION_NAME][$dir][$index]);
    }

    public function _auth($dir)
    {

        $_id = $this->_get($dir);

        if (!$_id)
            Helpers::_redirect();


        else {

            switch ($dir) {

                /**
                 * @todo
                 * disable alternative login for
                 * - operator prodi
                 * - mahasiswa
                 * SSO only
                 */
                case Helpers::dir_operator_prodi:
                case Helpers::dir_dosen:
                case Helpers::dir_mahasiswa:
//                    $this->_set($dir, $_id, CDosen::_gi()->_get($_id));
                    break;

            }

        }
    }

    public function _lang_set($lang)
    {
        $_SESSION[self::SESSION_NAME][i18n::SESSION_NAME] = array_key_exists($lang, i18n::$_lang) ? $lang : i18n::lang_default;
    }

    public function _lang_get()
    {
        return $_SESSION[self::SESSION_NAME][i18n::SESSION_NAME] ?? i18n::lang_default;
    }

}