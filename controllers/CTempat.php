<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CTempat extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'tempat_id';
    const _class = __CLASS__;

    private $_q_count;

    /**
     * @param $key
     * @param string $by
     * @param string $key2
     * @param string $by2
     * @return MTempat
     */
    public function _get($key, $by = self::_id, $key2 = '', $by2 = '')
    {
        return $this->_fetch(
            'SELECT a.*' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' WHERE a.' . $by . ' = "' . $key . '"' . (!empty($key2) && !empty($by2) ? ' AND a.' . $by2 . ' = "' . $key2 . '"' : ''),
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    /**
     * @param $args
     * @return array
     */
    public function _gets($args)
    {
        $default_args = array(
            'tempat_nama' => '',
            'tempat_alamat' => '',
            'tempat_pic' => '',
            'tempat_status' => -1,
            'count' => false,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        if ($list_args['count'])
            $query = 'SELECT COUNT(a.tempat_id) AS _count';

        else $query = 'SELECT a.*';

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a WHERE 1';

        if (!empty($list_args['tempat_nama']))
            $query .= ' AND a.tempat_nama LIKE "%' . $list_args['tempat_nama'] . '%"';

        if (!empty($list_args['tempat_alamat']))
            $query .= ' AND a.tempat_alamat LIKE "%' . $list_args['tempat_alamat'] . '%"';

        if (!empty($list_args['tempat_pic']))
            $query .= ' AND a.tempat_pic LIKE "%' . $list_args['tempat_pic'] . '%"';

        if ($list_args['tempat_status'] >= 0)
            $query .= ' AND a.tempat_status = ' . $list_args['tempat_status'];

        elseif ($list_args['tempat_status'] == -2)
            $query .= ' AND (a.tempat_status <> ' . CStatus::_status_menunggu . ')';

        $this->_q_count = $query;

        if ($list_args['count']) {

            $_tmp = $this->_fetch($query);
            return Helpers::_arr($_tmp, '_count', 0);


        } else {

            $query .= ' ORDER BY ' . $list_args['order_by'] . ' ' . $list_args['order'];

            if ($list_args['number'] >= 0)
                $query .= ' LIMIT ' . $list_args['offset'] . ', ' . $list_args['number'];

            return $this->_fetch($query, true, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
        }
    }

    /**
     * @param $obj MTempat
     * @return bool
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj MTempat
     * @return bool
     */
    public function _update($obj)
    {
        return parent::_s_update(__CLASS__, self::_id, $obj, $obj->_id());
    }

    public function _delete($id)
    {
        return parent::_s_delete(__CLASS__, self::_id, $id);
    }

    public function _count()
    {
        return parent::_s_count(__CLASS__, $this->_q_count);
    }
}