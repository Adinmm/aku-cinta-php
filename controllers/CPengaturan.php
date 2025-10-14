<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CPengaturan extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'pengaturan_key';
    const _class = __CLASS__;

    public function _get($key, $default = '')
    {
        /** @var MPengaturan $_tmp */
        $_tmp = $this->_fetch(
            'SELECT * FROM ' . Helpers::_table_name(__CLASS__) . ' WHERE pengaturan_key = "' . $key . '"',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));

        return $_tmp ? $_tmp->getPengaturanValue() : $default;
    }

    public function _save($key, $value)
    {
        $stmt = $this->_DBH->prepare(sprintf('INSERT INTO %s (pengaturan_key, pengaturan_value) 
            VALUES (:key, :value) ON DUPLICATE KEY UPDATE pengaturan_value = :update_value', Helpers::_table_name(__CLASS__)));

        return $stmt->execute([
            ':key' => $key,
            ':value' => $value,
            ':update_value' => $value
        ]);
    }

    public function _gets($args)
    {

    }

    public function _insert($obj)
    {

    }

    public function _update($obj)
    {

    }

    public function _delete($id)
    {

    }

    public function _count()
    {

    }
}
