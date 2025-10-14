<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CPersetujuan extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'persetujuan_id';
    const _class = __CLASS__;

    private $_q_count;

    /**
     * @param $key
     * @param string $by
     * @param string $key2
     * @param string $by2
     * @return MPersetujuan
     */
    public function _get($key, $by = self::_id, $key2 = '', $by2 = '')
    {
        return $this->_fetch(
            'SELECT a.*' .
            ', b.mahasiswa_nama AS _mahasiswa_nama' .
            ', c.dosen_kode AS _dosen_kode, c.dosen_nama AS _dosen_nama, c.dosen_nip AS _dosen_nip, c.dosen_email AS _dosen_email' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' c ON b.dosen_pa_kode = c.dosen_kode' .
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
            'persetujuan_status' => -1,
            'mahasiswa_nim' => '',
            'mahasiswa_nama' => '',
            'dosen_pa_kode' => '',
            'dosen_pa_nama' => '',
            'join_mahasiswa' => false,
            'join_dosen' => false,
            'count' => false,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        if ($list_args['count'])
            $query = 'SELECT COUNT(a.persetujuan_id) AS _count';

        else {
            $query = 'SELECT a.*';

            if ($list_args['join_mahasiswa']) {
                $query .= ', b.mahasiswa_nama AS _mahasiswa_nama';

                if ($list_args['join_dosen'])
                    $query .= ', c.dosen_kode AS _dosen_kode, c.dosen_nama AS _dosen_nama, c.dosen_nip AS _dosen_nip, c.dosen_email AS _dosen_email';
            }
        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a';

        if ($list_args['join_mahasiswa']) {
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim';

            if ($list_args['join_dosen'])
                $query .= ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' c ON b.dosen_pa_kode = c.dosen_kode';
        }

        $query .= ' WHERE 1';

        if ($list_args['persetujuan_status'] >= 0)
            $query .= ' AND a.persetujuan_status = ' . $list_args['persetujuan_status'];

        elseif ($list_args['persetujuan_status'] == -2)
            $query .= ' AND (a.persetujuan_status = ' . CStatus::_status_diajukan . ' OR a.persetujuan_status = ' . CStatus::_status_diterima . ')';

        if (!empty($list_args['mahasiswa_nim']))
            $query .= ' AND a.mahasiswa_nim LIKE "%' . $list_args['mahasiswa_nim'] . '%"';

        if (!empty($list_args['mahasiswa_nama']) && $list_args['join_mahasiswa'])
            $query .= ' AND b.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';

        if (!empty($list_args['dosen_pa_kode']) && $list_args['join_mahasiswa'])
            $query .= ' AND b.dosen_pa_kode = "' . $list_args['dosen_pa_kode'] . '"';

        if (!empty($list_args['dosen_pa_nama']) && $list_args['join_dosen'])
            $query .= ' AND c.dosen_nama LIKE "%' . $list_args['dosen_pa_nama'] . '%"';

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
     * @param $obj MPersetujuan
     * @return bool
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj MPersetujuan
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

    public function _valid($persetujuan_id, $mahasiswa_nim, $_die = false)
    {
        $_valid = $this->_rows('SELECT * FROM ' . Helpers::_table_name(__CLASS__) . ' WHERE persetujuan_id = ' . $persetujuan_id . ' AND mahasiswa_nim = "' . $mahasiswa_nim . '"');
        if ($_die && !$_valid)
            die('401 - Akses tidak diizinkan!');
        else return $_valid;
    }
}