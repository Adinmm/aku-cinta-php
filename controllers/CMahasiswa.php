<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CMahasiswa extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'mahasiswa_nim';
    const _class = __CLASS__;

    const _kuliah_aktif = 1;
    const _kuliah_pindah = 2;
    const _kuliah_cuti = 3;
    const _kuliah_do = 4;
    const _kuliah_bayar_spp_tapi_tidak_krs = 5;
    const _kuliah_tidak_bayar_spp = 6;
    const _kuliah_non_aktif = 7;
    const _kuliah_double_degree = 8;
    const _kuliah_lulus = 9;

    private $_q_count;

    static $_jenis_kelamin = array(
        'L' => 'Laki-laki',
        'P' => 'Perempuan'
    );

    static $_kuliah = array(
        'A' => 'Aktif',
        'P' => 'Pindah',
        'C' => 'Cuti',
        'D' => 'DO',
        'B' => 'Bayar SPP Tapi Tidak KRS',
        'M' => 'Tidak Bayar SPP',
        'N' => 'Non Aktif',
        'G' => 'Double Degree',
        'L' => 'Lulus'
    );

    static $_kuliah_text = array(
        self::_kuliah_aktif => 'Aktif',
        self::_kuliah_pindah => 'Pindah',
        self::_kuliah_cuti => 'Cuti',
        self::_kuliah_do => 'DO',
        self::_kuliah_bayar_spp_tapi_tidak_krs => 'Bayar SPP Tapi Tidak KRS',
        self::_kuliah_tidak_bayar_spp => 'Tidak Bayar SPP',
        self::_kuliah_non_aktif => 'Non Aktif',
        self::_kuliah_double_degree => 'Double Degree',
        self::_kuliah_lulus => 'Lulus'
    );

    static $_kuliah_kode = array(
        self::_kuliah_aktif => 'A',
        self::_kuliah_pindah => 'P',
        self::_kuliah_cuti => 'C',
        self::_kuliah_do => 'D',
        self::_kuliah_bayar_spp_tapi_tidak_krs => 'B',
        self::_kuliah_tidak_bayar_spp => 'M',
        self::_kuliah_non_aktif => 'N',
        self::_kuliah_double_degree => 'G',
        self::_kuliah_lulus => 'L'
    );

    static $_agama = array(
        1 => 'Islam',
        2 => 'Kristen',
        3 => 'Katolik',
        4 => 'Hindu',
        5 => 'Buddha',
        6 => 'Konghucu',
        99 => 'Lainnya'
    );

    static $_kewarganegaraan = array(
        'Warga Negara Indonesia',
        'Warga Negara Asing'
    );


    /**
     * @param $key
     * @param string $by
     * @return MMahasiswa
     */
    public function _get($key, $by = self::_id)
    {
        return $this->_fetch(
            'SELECT a.*' .
            ', b.dosen_nama AS _dosen_pa_nama, b.dosen_nip AS _dosen_pa_nip, b.dosen_email AS _dosen_pa_email' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' b ON a.dosen_pa_kode = b.dosen_kode' .
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
            'mahasiswa_nim' => '',
            'mahasiswa_tahun_masuk' => '',
            'mahasiswa_nama' => '',
            'mahasiswa_email' => '',
            'mahasiswa_kuliah' => '',
            'prodi_id' => -1,
            'prodi_kode_unram' => '',
            'count' => false,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Helpers::_params($default_args, $args);

        if ($list_args['count'])
            $query = 'SELECT COUNT(a.mahasiswa_id) AS _count';

        else $query = 'SELECT a.*' .
            ', b.dosen_nama AS _dosen_pa_nama, b.dosen_nip AS _dosen_pa_nip, b.dosen_email AS _dosen_pa_email';

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' a' .
            ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' b ON a.dosen_pa_kode = b.dosen_kode';

        $query .= ' WHERE 1';

        if (!empty($list_args['mahasiswa_nim']))
            $query .= ' AND a.mahasiswa_nim LIKE "%' . $list_args['mahasiswa_nim'] . '%"';

        if (!empty($list_args['mahasiswa_tahun_masuk']))
            $query .= ' AND a.mahasiswa_tahun_masuk LIKE "%' . $list_args['mahasiswa_tahun_masuk'] . '%"';

        if (!empty($list_args['mahasiswa_nama']))
            $query .= ' AND a.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';

        if (!empty($list_args['mahasiswa_email']))
            $query .= ' AND a.mahasiswa_email LIKE "%' . $list_args['mahasiswa_email'] . '%"';

        if (!empty($list_args['mahasiswa_kuliah']))
            $query .= ' AND a.mahasiswa_kuliah LIKE "%' . $list_args['mahasiswa_kuliah'] . '%"';

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
     * @param $obj MMahasiswa
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

    public function _get_sia($nim)
    {
        return Helpers::_fetch(SIA_URI . '/index.php/api2/Mahasiswa?nim=' . $nim);
    }

}