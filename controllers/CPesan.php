<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CPesan extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'pesan_id';
    const _class = __CLASS__;

    const _jenis_mahasiswa = 'm';
    const _jenis_dosen = 'd';

    const _status_menunggu = 1;
    const _status_dibaca = 2;

    private $_q_count;

    /**
     * @param $key
     * @param string $by
     * @return MPesan
     */
    public function _get($key, $by = self::_id)
    {
        return $this->_fetch(
            'SELECT a.*' .
            ', b.bimbingan_jenis AS _bimbingan_jenis, b.bimbingan_status AS _bimbingan_status' .
            ', c.mahasiswa_nim AS _mahasiswa_nim, c.mahasiswa_nama AS _mahasiswa_nama, c.mahasiswa_foto AS _mahasiswa_foto' .
            ', d.dosen_kode AS _dosen_kode, d.dosen_nama AS _dosen_nama, d.dosen_nip AS _dosen_nip, d.dosen_email AS _dosen_email' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(CBimbingan::_class) . ' b ON a.bimbingan_id = b.bimbingan_id' .
            ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' c ON b.mahasiswa_nim = c.mahasiswa_nim' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' d ON b.dosen_kode = d.dosen_kode' .
            ' WHERE a.' . $by . ' = "' . $key . '"',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    /**
     * @param $args
     * @return array|integer
     */
    public function _gets($args)
    {
        $default_args = array(
            'pesan_jenis' => '',
            'pesan_status' => -1,
            'bimbingan_id' => -1,
            'bimbingan_jenis' => '',
            'bimbingan_status' => -1,
            'mahasiswa_nim' => '',
            'mahasiswa_nama' => '',
            'dosen_kode' => '',
            'dosen_nama' => '',
            'join_bimbingan' => false,
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
            $query = 'SELECT COUNT(a.pesan_id) AS _count';

        else {
            $query = 'SELECT a.*';

            if ($list_args['join_bimbingan'])
                $query .= ', b.bimbingan_jenis AS _bimbingan_jenis, b.bimbingan_status AS _bimbingan_status';

            if ($list_args['join_mahasiswa'])
                $query .= ', c.mahasiswa_nim AS _mahasiswa_nim, c.mahasiswa_nama AS _mahasiswa_nama, c.mahasiswa_foto AS _mahasiswa_foto';

            if ($list_args['join_dosen'])
                $query .= ', d.dosen_kode AS _dosen_kode, d.dosen_nama AS _dosen_nama, d.dosen_nip AS _dosen_nip, d.dosen_email AS _dosen_email';
        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a';

        if ($list_args['join_bimbingan'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CBimbingan::_class) . ' b ON a.bimbingan_id = b.bimbingan_id';

        if ($list_args['join_mahasiswa'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' c ON b.mahasiswa_nim = c.mahasiswa_nim';

        if ($list_args['join_dosen'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' d ON b.dosen_kode = d.dosen_kode';

        $query .= ' WHERE 1';

        if (!empty($list_args['pesan_jenis']))
            $query .= ' AND a.pesan_jenis LIKE "' . $list_args['pesan_jenis'] . '"';

        if ($list_args['pesan_status'] >= 0)
            $query .= ' AND a.pesan_status = ' . $list_args['pesan_status'];

        if ($list_args['bimbingan_id'] >= 0)
            $query .= ' AND a.bimbingan_id = ' . $list_args['bimbingan_id'];

        if (!empty($list_args['bimbingan_jenis']) && $list_args['join_bimbingan'])
            $query .= ' AND b.bimbingan_jenis LIKE "' . $list_args['bimbingan_jenis'] . '"';

        if ($list_args['bimbingan_status'] >= 0 && $list_args['join_bimbingan'])
            $query .= ' AND b.bimbingan_status = ' . $list_args['bimbingan_status'];

        if (!empty($list_args['mahasiswa_nim']) && $list_args['join_bimbingan'])
            $query .= ' AND b.mahasiswa_nim = "' . $list_args['mahasiswa_nim'] . '"';

        if (!empty($list_args['mahasiswa_nama']) && $list_args['join_bimbingan'] && $list_args['join_mahasiswa'])
            $query .= ' AND c.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';

        if (!empty($list_args['dosen_kode']) && $list_args['join_bimbingan'])
            $query .= ' AND b.dosen_kode = "' . $list_args['dosen_kode'] . '"';

        if (!empty($list_args['dosen_nama']) && $list_args['join_bimbingan'] && $list_args['join_dosen'])
            $query .= ' AND d.dosen_nama LIKE "%' . $list_args['dosen_nama'] . '%"';

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
     * @param $obj MPesan
     * @return bool
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj MPesan
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

    public function _valid_m($bimbingan_id, $mahasiswa_nim, $_die = false)
    {
        return $this->_valid($bimbingan_id, Helpers::dir_mahasiswa, $mahasiswa_nim, $_die);
    }

    public function _valid_d($bimbingan_id, $dosen_kode, $_die = false)
    {
        return $this->_valid($bimbingan_id, Helpers::dir_dosen, $dosen_kode, $_die);
    }

    private function _valid($bimbingan_id, $_dir, $_dir_id, $_die)
    {
        $_query = 'SELECT * FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(CBimbingan::_class) . ' b ON a.bimbingan_id = b.bimbingan_id' .
            ' WHERE a.bimbingan_id = ' . $bimbingan_id;
        if ($_dir == Helpers::dir_mahasiswa)
            $_query .= ' AND b.mahasiswa_nim = "' . $_dir_id . '"';
        elseif ($_dir == Helpers::dir_dosen)
            $_query .= ' AND b.dosen_kode = "' . $_dir_id . '"';
        $_valid = $this->_rows($_query);
        if ($_die && !$_valid)
            die('401 - Akses tidak diizinkan!');
        else return $_valid;
    }

    public function _update_dibaca($jenis, $bimbingan_id)
    {
        $_query = 'UPDATE ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' SET a.pesan_status = ' . CPesan::_status_dibaca .
            ' WHERE a.pesan_jenis = "' . $jenis . '"' .
            ' AND a.bimbingan_id = ' . $bimbingan_id;
        $this->_exec($_query);
    }
}