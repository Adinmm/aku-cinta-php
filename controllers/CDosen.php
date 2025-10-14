<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CDosen extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'dosen_kode';
    const _class = __CLASS__;

    private $_q_count;

    static $_status = array(
        1 => 'Aktif',
        2 => 'Tidak Aktif',
        3 => 'Tugas Belajar',
        4 => 'Cuti'
    );

    /**
     * @param $key
     * @param string $by
     * @return MDosen
     */
    public function _get($key, $by = self::_id)
    {
        return $this->_fetch(
            'SELECT a.*' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' WHERE a.' . $by . ' = "' . $key . '"',
            false, PDO::FETCH_CLASS, Helpers::_model_name(__CLASS__));
    }

    /**
     * @param $args
     * @return array|mixed
     */
    public function _gets($args)
    {
        $default_args = array(
            'dosen_nama' => '',
            'dosen_nip' => '',
            'dosen_nidn' => '',
            'prodi_id' => -1,
            'prodi_id2' => -1,
            'count_as_pembimbing' => false,
            'count' => false,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        if ($list_args['count'])
            $query = 'SELECT COUNT(a.dosen_kode) AS _count';

        else {

            $query = 'SELECT a.*';

            if ($list_args['count_as_pembimbing']) {

                $query .= sprintf(', (SELECT COUNT(b.pengajuan_id) FROM %s b WHERE b.dosen_kode = a.dosen_kode) AS _pembimbing',
                    Helpers::_table_name(CPengajuan::_class));

                $query .= sprintf(', (SELECT COUNT(b.pengajuan_id) FROM %s b WHERE b.dosen_kode = a.dosen_kode AND b.pengajuan_status <> %d) AS _pembimbing_berlangsung',
                    Helpers::_table_name(CPengajuan::_class), CStatus::_status_selesai);

                $query .= sprintf(', (SELECT COUNT(b.pengajuan_id) FROM %s b WHERE b.dosen_kode = a.dosen_kode AND b.pengajuan_status = %d) AS _pembimbing_selesai',
                    Helpers::_table_name(CPengajuan::_class), CStatus::_status_selesai);

            }

        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a';

        $query .= ' WHERE 1';

        if (!empty($list_args['dosen_nama']))
            $query .= ' AND a.dosen_nama LIKE "%' . $list_args['dosen_nama'] . '%"';

        if (!empty($list_args['dosen_nip']))
            $query .= ' AND a.dosen_nip LIKE "%' . $list_args['dosen_nip'] . '%"';

        if (!empty($list_args['dosen_nidn']))
            $query .= ' AND a.dosen_nidn LIKE "%' . $list_args['dosen_nidn'] . '%"';

        if ($list_args['prodi_id'] > 0)
        {
            $query .= ' AND (a.prodi_id = ' . $list_args['prodi_id'];

            if ($list_args['prodi_id2'] > 0)
                $query .= ' OR a.prodi_id = ' . $list_args['prodi_id2'];

            $query .= ')';
        }

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
     * @param $obj Template
     * @return mixed
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, '', $obj, true);
    }

    /**
     * @param $obj MDosen
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

    public function _get_sia($kode)
    {
        return Helpers::_fetch(SIA_URI . '/index.php/api2/Dosen?kode=' . $kode);
    }
}