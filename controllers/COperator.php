<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class COperator extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'operator_id';
    const _class = __CLASS__;

    static $_jenis = array(
        Helpers::dir_operator_prodi,
    );

    const _meta_operator_prodi = 'operator_prodi';
    const _meta_operator_nama = 'operator_nama';
    const _meta_operator_nomor_hp = 'operator_nomor_hp';

    const _status_active = 1;
    const _status_inactive = 0;

    static $_status = array(
        self::_status_active => 'Aktif',
        self::_status_inactive => 'Tidak Aktif'
    );

    static $_status_icon_map = array(
        self::_status_active => 'check',
        self::_status_inactive => 'times'
    );

    static $_status_label_map = array(
        self::_status_active => 'success',
        self::_status_inactive => 'danger'
    );

    private $_q_count;

    /**
     * @param $id
     * @param $dir
     * @return array|mixed
     */
    public function _get($id, $dir)
    {
        return $this->_fetch(
            'SELECT a.*' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' WHERE a.operator_id = ' . $id . ' AND a.operator_jenis LIKE "%' . $dir . '%"',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    public function _get_by_id($id)
    {
        return $this->_fetch(
            'SELECT a.* FROM ' . Helpers::_table_name(__CLASS__) . ' a WHERE a.operator_id = "' . $id . '"',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    /**
     * @param $dir
     * @param $username
     * @param $password
     * @return bool
     */
    public function _login($dir, $username, $password)
    {
        $_username = Helpers::_sanitize($username);
        $_password = md5(Helpers::_sanitize($password));
        $_result = $this->_fetch('SELECT ' . self::_id . ' FROM ' . Helpers::_table_name(__CLASS__) .
            ' WHERE operator_jenis LIKE "%' . $dir . '%" AND operator_username = "' . $_username . '" AND operator_password = "' . $_password . '" AND operator_status = 1');
        return $_result ? $_result[self::_id] : false;
    }

    /**
     * @param $dir
     * @param $id
     * @param $password
     * @return bool
     */
    public function _login2($dir, $id, $password)
    {
        $_result = $this->_fetch('SELECT ' . self::_id . ' FROM ' . Helpers::_table_name(__CLASS__) .
            ' WHERE operator_jenis LIKE "%' . $dir . '%" AND operator_id = ' . $id . ' AND operator_password = "' . $password . '" AND operator_status = 1');
        return $_result ? $_result[self::_id] : false;
    }

    /**
     * @param $args
     * @return array|mixed
     */
    public function _gets($args)
    {
        $default_args = array(
            'operator_nama' => '',
            'operator_jenis' => '',
            'operator_status' => -1,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        $query = 'SELECT a.* FROM ' . Helpers::_table_name(__CLASS__) . ' a WHERE 1';

        if (!empty($list_args['operator_nama']))
            $query .= ' AND a.operator_nama LIKE "%' . $list_args['operator_nama'] . '%"';

        if (!empty($list_args['operator_jenis']))
            $query .= ' AND a.operator_jenis LIKE "%' . $list_args['operator_jenis'] . '%"';

        if ($list_args['operator_status'] >= 0)
            $query .= ' AND a.operator_status = ' . $list_args['operator_status'];

        $this->_q_count = $query;

        $query .= ' ORDER BY ' . $list_args['order_by'] . ' ' . $list_args['order'];

        if ($list_args['number'] >= 0)
            $query .= ' LIMIT ' . $list_args['offset'] . ', ' . $list_args['number'];

        return $this->_fetch($query, true, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, '', $obj, true);
    }

    /**
     * @param $obj Template
     * @return bool
     */
    public function _update($obj)
    {
        return parent::_s_update(__CLASS__, self::_id, $obj, $obj->_id());
    }

    public function _delete($id)
    {

    }

    public function _count()
    {
        return parent::_s_count(__CLASS__, $this->_q_count);
    }
}