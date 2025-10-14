<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CBimbingan extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'bimbingan_id';
    const _class = __CLASS__;

    const _jenis_p1 = 'p1';
    const _jenis_p2 = 'p2';

    const _status_berlangsung = 1;
    const _status_selesai = 2;

    static $_jenis = [
        self::_jenis_p1 => 'Pembina Akademik (PA)',
        self::_jenis_p2 => 'Pembimbing PKL',
    ];

    static $_status = [
        self::_status_berlangsung => 'Berlangsung',
        self::_status_selesai => 'Selesai',
    ];

    static $_status_color_map = [
        self::_status_berlangsung => 'danger btn-outline',
        self::_status_selesai => 'primary',
    ];

    private $_q_count;

    /**
     * @param $key
     * @param string $by
     * @return MBimbingan
     */
    public function _get($key, $by = self::_id)
    {
        return $this->_fetch(
            'SELECT a.*' .
            ', b.mahasiswa_nama AS _mahasiswa_nama, b.mahasiswa_email AS _mahasiswa_email, b.mahasiswa_foto AS _mahasiswa_foto' .
            ', c.dosen_nama AS _dosen_nama, c.dosen_nip AS _dosen_nip, c.dosen_email AS _dosen_email' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' c ON a.dosen_kode = c.dosen_kode' .
            ' WHERE a.' . $by . ' = "' . $key . '"',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    /**
     * @param $args
     * @return array
     */
    public function _gets($args)
    {
        $default_args = array(
            'bimbingan_jenis' => '',
            'bimbingan_status' => -1,
            'mahasiswa_nim' => '',
            'mahasiswa_nama' => '',
            'dosen_kode' => '',
            'dosen_nama' => '',
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
            $query = 'SELECT COUNT(a.bimbingan_id) AS _count';

        else {
            $query = 'SELECT a.*';

            if ($list_args['join_mahasiswa'])
                $query .= ', b.mahasiswa_nama AS _mahasiswa_nama, b.mahasiswa_email AS _mahasiswa_email, b.mahasiswa_foto AS _mahasiswa_foto';

            if ($list_args['join_dosen'])
                $query .= ', c.dosen_nama AS _dosen_nama, c.dosen_nip AS _dosen_nip, c.dosen_email AS _dosen_email';
        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a';

        if ($list_args['join_mahasiswa'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim';

        if ($list_args['join_dosen'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' c ON a.dosen_kode = c.dosen_kode';

        $query .= ' WHERE 1';

        if (!empty($list_args['bimbingan_jenis']))
            $query .= ' AND a.bimbingan_jenis LIKE "' . $list_args['bimbingan_jenis'] . '"';

        if ($list_args['bimbingan_status'] >= 0)
            $query .= ' AND a.bimbingan_status = ' . $list_args['bimbingan_status'];

        if (!empty($list_args['mahasiswa_nim']))
            $query .= ' AND a.mahasiswa_nim = "' . $list_args['mahasiswa_nim'] . '"';

        if (!empty($list_args['mahasiswa_nama']) && $list_args['join_mahasiswa'])
            $query .= ' AND b.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';

        if (!empty($list_args['dosen_kode']))
            $query .= ' AND a.dosen_kode = "' . $list_args['dosen_kode'] . '"';

        if (!empty($list_args['dosen_nama']) && $list_args['join_dosen'])
            $query .= ' AND c.dosen_nama LIKE "%' . $list_args['dosen_nama'] . '%"';

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
     * @param $obj MBimbingan
     * @return bool
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj MBimbingan
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
        $_query = 'SELECT * FROM ' . Helpers::_table_name(__CLASS__) . ' WHERE bimbingan_id = ' . $bimbingan_id;
        if ($_dir == Helpers::dir_mahasiswa)
            $_query .= ' AND mahasiswa_nim = "' . $_dir_id . '"';
        elseif ($_dir == Helpers::dir_dosen)
            $_query .= ' AND dosen_kode = "' . $_dir_id . '"';
//        $_query .= ' AND bimbingan_status <> ' . CBimbingan::_status_menunggu;
        $_valid = $this->_rows($_query);
        if ($_die && !$_valid)
            die('401 - Akses tidak diizinkan!');
        else return $_valid;
    }
}