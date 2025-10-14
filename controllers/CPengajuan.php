<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CPengajuan extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'pengajuan_id';
    const _class = __CLASS__;

    const _ext = '/UN18.F6/EP/';

    private $_q_count;

    /**
     * @param $key
     * @param string $by
     * @param string $key2
     * @param string $by2
     * @return MPengajuan
     */
    public function _get($key, $by = self::_id, $key2 = '', $by2 = '')
    {
        return $this->_fetch(
            'SELECT aa.*' .
            ', b.mahasiswa_nim AS _mahasiswa_nim, b.mahasiswa_nama AS _mahasiswa_nama' .
            ', c.tempat_id AS _tempat_id, c.tempat_nama AS _tempat_nama, c.tempat_alamat AS _tempat_alamat, d.dosen_nama AS _dosen_nama, d.dosen_nip AS _dosen_nip' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' aa' .
            ' LEFT JOIN ' . Helpers::_table_name(CPengantar::_class) . ' a ON aa.pengantar_id = a.pengantar_id' .
            ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim' .
            ' LEFT JOIN ' . Helpers::_table_name(CTempat::_class) . ' c ON a.tempat_id = c.tempat_id' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' d ON aa.dosen_kode = d.dosen_kode' .
            ' WHERE ' . $by . ' = "' . $key . '"' . (!empty($key2) && !empty($by2) ? ' AND ' . $by2 . ' = "' . $key2 . '"' : ''),
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    /**
     * @param $args
     * @return array
     */
    public function _gets($args)
    {
        $default_args = array(
            'pengajuan_status' => -1,
            'dosen_kode' => '',
            'dosen_nama' => '',
            'pengantar_judul' => '',
            'mahasiswa_nim' => '',
            'mahasiswa_nama' => '',
            'tempat_id' => -1,
            'join_pengantar' => false,
            'join_mahasiswa' => false,
            'join_tempat' => false,
            'join_dosen' => false,
            'count' => false,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        if ($list_args['count'])
            $query = 'SELECT COUNT(a.pengajuan_id) AS _count';

        else {
            $query = 'SELECT aa.*';

            if ($list_args['join_mahasiswa'])
                $query .= ', b.mahasiswa_nim AS _mahasiswa_nim, b.mahasiswa_nama AS _mahasiswa_nama';

            if ($list_args['join_tempat'])
                $query .= ', c.tempat_id AS _tempat_id, c.tempat_nama AS _tempat_nama, c.tempat_alamat AS _tempat_alamat';

            if ($list_args['join_dosen'])
                $query .= ', d.dosen_nama AS _dosen_nama, d.dosen_nip AS _dosen_nip';
        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' aa';

        if ($list_args['join_pengantar'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CPengantar::_class) . ' a ON aa.pengantar_id = a.pengantar_id';

        if ($list_args['join_mahasiswa'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim';

        if ($list_args['join_tempat'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CTempat::_class) . ' c ON a.tempat_id = c.tempat_id';

        if ($list_args['join_dosen'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' d ON aa.dosen_kode = d.dosen_kode';

        $query .= ' WHERE 1';

        if ($list_args['pengajuan_status'] >= 0)
            $query .= ' AND aa.pengajuan_status = ' . $list_args['pengajuan_status'];

        elseif ($list_args['pengajuan_status'] == -2)
            $query .= ' AND (aa.pengajuan_status = ' . CStatus::_status_diajukan . ' OR aa.pengajuan_status = ' . CStatus::_status_diterima . ')';

        if (!empty($list_args['dosen_kode']))
            $query .= ' AND aa.dosen_kode = "' . $list_args['dosen_kode'] . '"';

        if ($list_args['join_pengantar']) {

            if (!empty($list_args['pengantar_judul']))
                $query .= ' AND a.pengantar_judul LIKE "%' . $list_args['pengantar_judul'] . '%"';

            if (!empty($list_args['mahasiswa_nim']))
                $query .= ' AND a.mahasiswa_nim LIKE "%' . $list_args['mahasiswa_nim'] . '%"';

            if (!empty($list_args['mahasiswa_nama']) && $list_args['join_mahasiswa'])
                $query .= ' AND b.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';

            if ($list_args['tempat_id'] >= 0 && $list_args['join_tempat'])
                $query .= ' AND a.tempat_id = ' . $list_args['tempat_id'];
        }

        if (!empty($list_args['dosen_nama']) && $list_args['join_dosen'])
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
     * @param $obj MPengajuan
     * @return bool
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj MPengajuan
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

    public function _valid($pengajuan_id, $mahasiswa_nim, $_die = false)
    {
        $_valid = $this->_rows('SELECT * FROM ' . Helpers::_table_name(__CLASS__) . ' WHERE pengajuan_id = ' . $pengajuan_id . ' AND mahasiswa_nim = "' . $mahasiswa_nim . '"');
        if ($_die && !$_valid)
            die('401 - Akses tidak diizinkan!');
        else return $_valid;
    }
}