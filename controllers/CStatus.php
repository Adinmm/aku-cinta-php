<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CStatus extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'status_id';
    const _class = __CLASS__;

    const _jenis_persetujuan = 'persetujuan';
    const _jenis_pengajuan = 'pengajuan';
    const _jenis_pengantar = 'pengantar';
    const _jenis_surat_tugas = 'surat-tugas';
    const _jenis_seminar = 'seminar';
    const _jenis_tempat = 'tempat';

    const _status_menunggu = 0;
    const _status_diajukan = 1;
    const _status_diterima = 2;
    const _status_ditolak = 3;
    const _status_selesai = 4;

    const _status_type_label = 1;
    const _status_type_color = 2;
    const _status_type_icon = 3;

    public static $_status_label = array(
        self::_status_menunggu => 'Belum diajukan',
        self::_status_diajukan => 'Diajukan',
        self::_status_diterima => 'Diterima',
        self::_status_ditolak => 'Ditolak',
        self::_status_selesai => 'Selesai',
    );

    public static $_status_color = array(
        self::_status_menunggu => 'default',
        self::_status_diajukan => 'warning',
        self::_status_diterima => 'success',
        self::_status_ditolak => 'danger',
        self::_status_selesai => 'info',
    );

    public static $_status_icon = array(
        self::_status_menunggu => '',
        self::_status_diajukan => 'fa fa-info',
        self::_status_ditolak => 'fa fa-times',
        self::_status_diterima => 'fa fa-check',
        self::_status_selesai => 'fa fa-check',
    );

    private $_q_count;

    public function _get($key, $by)
    {
        // TODO: Implement _get() method.
    }

    /**
     * @param $_jenis
     * @param $_jenis_id
     * @param string $_tahun_akademik
     * @param string $_order
     * @return array|mixed
     */
    public function _last($_jenis, $_jenis_id, $_tahun_akademik = '', $_order = 'status_waktu')
    {
        return $this->_fetch(
            'SELECT a.*, b.operator_nama AS _operator_nama, c.dosen_nama AS _dosen_nama, d.mahasiswa_nama AS _mahasiswa_nama' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(COperator::_class) . ' b ON a.operator_id = b.operator_id' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' c ON a.operator_id = c.dosen_kode' .
            ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' d ON a.operator_id = d.mahasiswa_nim' .
            ' WHERE a.status_jenis = "' . $_jenis . '" AND a.status_jenis_id = "' . $_jenis_id . '"' . ($_tahun_akademik ? ' AND a.status_tahun_akademik = "' . $_tahun_akademik . '"' : '') . ' ORDER BY a.' . $_order . ' DESC',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    public function _gets($args)
    {
        $default_args = array(
            'status_jenis' => '',
            'status_jenis_id' => '',
            'operator_id' => -1,
            'operator_jenis' => '',
            'mahasiswa_nim' => '',
            'mahasiswa_nama' => '',
            'join_dosen' => false,
            'join_mahasiswa' => false,
            'count' => false,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        if ($list_args['count'])
            $query = 'SELECT COUNT(a.status_id) AS _count';

        else {
            $query = 'SELECT a.*, b.operator_nama AS _operator_nama';

            if ($list_args['join_dosen'])
                $query .= ', c.dosen_nama AS _dosen_nama';

            if ($list_args['join_mahasiswa'])
                $query .= ', d.mahasiswa_nama AS _mahasiswa_nama';
        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(COperator::_class) . ' b ON a.operator_id = b.operator_id';

        if ($list_args['join_dosen'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' c ON a.operator_id = c.dosen_kode';

        if ($list_args['join_mahasiswa'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' d ON a.operator_id = d.mahasiswa_nim';

        $query .= ' WHERE 1';

        if (!empty($list_args['status_jenis']))
            $query .= ' AND a.status_jenis = "' . $list_args['status_jenis'] . '"';

        if (!empty($list_args['status_jenis_id']))
            $query .= ' AND a.status_jenis_id = "' . $list_args['status_jenis_id'] . '"';

        if ($list_args['operator_id'] > 0)
            $query .= ' AND a.operator_id = ' . $list_args['operator_id'];

        if (!empty($list_args['operator_jenis']))
            $query .= ' AND b.operator_jenis LIKE "%' . $list_args['operator_jenis'] . '%"';

        if ($list_args['join_dosen']) {

            if (!empty($list_args['dosen_kode']))
                $query .= ' AND c.dosen_kode = "' . $list_args['dosen_kode'] . '"';

            if (!empty($list_args['dosen_nama']))
                $query .= ' AND d.dosen_nama LIKE "%' . $list_args['dosen_nama'] . '%"';

        }

        if ($list_args['join_mahasiswa']) {

            if (!empty($list_args['mahasiswa_nim']))
                $query .= ' AND d.mahasiswa_nim = "' . $list_args['mahasiswa_nim'] . '"';

            if (!empty($list_args['mahasiswa_nama']))
                $query .= ' AND d.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';

        }

        $this->_q_count = $query;

        if ($list_args['count']) {

            $_tmp = $this->_fetch($query);
            return Helpers::_arr($_tmp, '_count', 0);


        } else {

            $query .= ' ORDER BY `' . $list_args['order_by'] . '` ' . $list_args['order'];

            if ($list_args['number'] >= 0)
                $query .= ' LIMIT ' . $list_args['offset'] . ', ' . $list_args['number'];

            return $this->_fetch($query, true, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
        }
    }

    /**
     * @param $obj Template
     * @return mixed
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj_status
     * @return mixed|MStatus|null
     */
    public function _insert2($obj_status = null)
    {
        if (!$obj_status instanceof MStatus) {
            $obj_status = new MStatus();
            $obj_status->_init($_REQUEST);
        }
        $this->_insert($obj_status);
        return $obj_status;
    }

    /**
     * @param $obj Template
     * @return mixed
     */
    public function _update($obj)
    {
        return parent::_s_update(__CLASS__, self::_id, $obj, $obj->_id());
    }

    public function _delete($_id)
    {
        return parent::_s_delete(__CLASS__, self::_id, $_id);
    }

    public function _count()
    {
        return parent::_s_count(__CLASS__, $this->_q_count);
    }
}