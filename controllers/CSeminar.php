<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class CSeminar extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'seminar_id';
    const _class = __CLASS__;

    public static $_nilai = array(
        'A' => array(85, 100),
        'B+' => array(80, 85),
        'B' => array(75, 80),
        'C+' => array(70, 75),
        'C' => array(65, 70),
        'D+' => array(55, 65),
        'D' => array(45, 55),
        'E' => array(0, 45)
    );

    public static $_upload = array(
//        'acc_bimbingan' => 'Bukti Acc Bimbingan',
        'submit_jbegati' => 'Bukti Submit jBegaTI',
        'nilai_pembimbing_lapangan' => 'Nilai Pembimbing Lapangan',
    );

    public static $_nilai_aspek_pl = [
        'Komunikasi' => [
            'Kemampuan untuk menyampaikan informasi, mendengarkan orang lain, berkomunikasi secara efektif, dan memberikan respon positif yang mendorong komunikasi terbuka',
            [
                'Kurang' => '[0 &mdash; 5.0]',
                'Cukup' => '[5.1 &mdash; 9.0]',
                'Baik' => '[9.1 &mdash; 12.0]',
                'Sangat Baik' => '[12.1 &mdash; 15.0]',
            ], 15
        ],
        'Kerjasama' => [
            'Kemampuan menjalin kerjasama dalam tim, peka akan kebutuhan orang lain dan memberikan kontribusi dalam aktivitas tim untuk mencapai tujuan dan hasil yang positif',
            [
                'Kurang' => '[0 &mdash; 5.0]',
                'Cukup' => '[5.1 &mdash; 9.0]',
                'Baik' => '[9.1 &mdash; 12.0]',
                'Sangat Baik' => '[12.1 &mdash; 15.0]',
            ], 15
        ],
        'Inisiatif' => [
            'Kemampuan merespon masalah secara proaktifdan gigih, menjajaki kesempatan yang ada,melakukan sesuatu tanpa disuruh gunamengatasi hambatan, yang ditampilkan secaramotorik/verbal (yang berkonsekuen tindakan)',
            [
                'Kurang' => '[0 &mdash; 5.0]',
                'Cukup' => '[5.1 &mdash; 10.0]',
                'Baik' => '[10.1 &mdash; 15.0]',
                'Sangat Baik' => '[15.1 &mdash; 20.0]',
            ], 20
        ],
        'Adaptasi' => [
            'Kemampuan menyesuaikan perilaku agar dapat bekerja secara efektif dan efisien saat adanya informasi baru, perubahan situasi atau kondisi lingkungan kerja yang berbeda',
            [
                'Kurang' => '[0 &mdash; 5.0]',
                'Cukup' => '[5.1 &mdash; 10.0]',
                'Baik' => '[10.1 &mdash; 15.0]',
                'Sangat Baik' => '[15.1 &mdash; 20.0]',
            ], 20
        ],
        'Pengerjaan Tugas' => [
            'Penyelesaian setiap tugas yang diberikan oleh Pembimbing Lapangan. Penilaian berdasarkan persentase penyelesaian tugas',
            [
                '0% &mdash; 50%' => '[0 &mdash; 15.0]',
                '50.1% &mdash; 75%' => '[15.1 &mdash; 25.0]',
                '75.1% &mdash; 100%' => '[25.1 &mdash; 30.0]',
            ], 30
        ],
    ];

    public static $_nilai_aspek_dp = [
        'Laporan Seminar' => [
            'Aturan penulisan dan tata Bahasa' => 15,
            'Latar belakang dan tujuan' => 15,
            'Uraian perumusan masalah dan pembahasan hasil' => 30,
        ],
        'Seminar Hasil' => [
            'Kemampuan menyelesaikan pekerjaan' => 20,
            'Kesesuaian hasil/produk dengan tujuan' => 10,
            'Kemampuan presentasi' => 10
        ]
    ];

    private $_q_count;

    /**
     * @param $key
     * @param string $by
     * @param string $key2
     * @param string $by2
     * @return MSeminar
     */
    public function _get($key, $by = self::_id, $key2 = '', $by2 = '')
    {
        return $this->_fetch(
            'SELECT ab.*' .
            ', b.mahasiswa_nim AS _mahasiswa_nim, b.mahasiswa_nama AS _mahasiswa_nama' .
            ', c.tempat_id AS _tempat_id, c.tempat_nama AS _tempat_nama, c.tempat_alamat AS _tempat_alamat' .
            ', d.dosen_kode AS _dosen_kode, d.dosen_nama AS _dosen_nama, d.dosen_email AS _dosen_email, d.dosen_nip AS _dosen_nip' .
            ' FROM ' . Helpers::_table_name(__CLASS__) . ' ab' .
            ' LEFT JOIN ' . Helpers::_table_name(CPengajuan::_class) . ' aa ON ab.pengajuan_id = aa.pengajuan_id' .
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
            'seminar_judul' => '',
            'seminar_status' => -1,
            'mahasiswa_nim' => '',
            'mahasiswa_nama' => '',
            'dosen_kode' => '',
            'join_pengajuan' => false,
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
            $query = 'SELECT COUNT(a.seminar_id) AS _count';

        else {
            $query = 'SELECT ab.*';

            if ($list_args['join_mahasiswa'])
                $query .= ', b.mahasiswa_nim AS _mahasiswa_nim, b.mahasiswa_nama AS _mahasiswa_nama';

            if ($list_args['join_tempat'])
                $query .= ', c.tempat_id AS _tempat_id, c.tempat_nama AS _tempat_nama, c.tempat_alamat AS _tempat_alamat';

            if ($list_args['join_dosen'])
                $query .= ', d.dosen_kode AS _dosen_kode, d.dosen_nama AS _dosen_nama, d.dosen_email AS _dosen_email, d.dosen_nip AS _dosen_nip';
        }

        $query .= ' FROM ' . Helpers::_table_name(__CLASS__) . ' ab';

        if ($list_args['join_pengajuan'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CPengajuan::_class) . ' aa ON ab.pengajuan_id = aa.pengajuan_id';

        if ($list_args['join_pengantar'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CPengantar::_class) . ' a ON aa.pengantar_id = a.pengantar_id';

        if ($list_args['join_mahasiswa'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CMahasiswa::_class) . ' b ON a.mahasiswa_nim = b.mahasiswa_nim';

        if ($list_args['join_tempat'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CTempat::_class) . ' c ON a.tempat_id = c.tempat_id';

        if ($list_args['join_dosen'])
            $query .= ' LEFT JOIN ' . Helpers::_table_name(CDosen::_class) . ' d ON aa.dosen_kode = d.dosen_kode';

        $query .= ' WHERE 1';

        if (!empty($list_args['seminar_judul']))
            $query .= ' AND ab.seminar_judul LIKE "%' . $list_args['seminar_judul'] . '%"';

        if ($list_args['seminar_status'] >= 0)
            $query .= ' AND ab.seminar_status = ' . $list_args['seminar_status'];

        elseif ($list_args['seminar_status'] == -2)
            $query .= ' AND (ab.seminar_status = ' . CStatus::_status_diajukan . ' OR ab.seminar_status = ' . CStatus::_status_diterima . ')';

        if ($list_args['join_pengajuan']) {

            if (!empty($list_args['dosen_kode']))
                $query .= ' AND aa.dosen_kode = "' . $list_args['dosen_kode'] . '"';

            if ($list_args['join_pengantar']) {

                if (!empty($list_args['pengantar_judul']))
                    $query .= ' AND a.pengantar_judul LIKE "%' . $list_args['pengantar_judul'] . '%"';

                if (!empty($list_args['mahasiswa_nim']))
                    $query .= ' AND a.mahasiswa_nim LIKE "%' . $list_args['mahasiswa_nim'] . '%"';

                if (!empty($list_args['mahasiswa_nama']) && $list_args['join_mahasiswa'])
                    $query .= ' AND b.mahasiswa_nama LIKE "%' . $list_args['mahasiswa_nama'] . '%"';
            }

            if (!empty($list_args['dosen_nama']) && $list_args['join_dosen'])
                $query .= ' AND d.dosen_nama LIKE "%' . $list_args['dosen_nama'] . '%"';

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
     * @param $obj MSeminar
     * @return bool
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj MSeminar
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

    public function _valid($seminar_id, $mahasiswa_nim, $_die = false)
    {
        $_valid = $this->_rows('SELECT * FROM ' . Helpers::_table_name(__CLASS__) . ' WHERE seminar_id = ' . $seminar_id . ' AND mahasiswa_nim = "' . $mahasiswa_nim . '"');
        if ($_die && !$_valid)
            die('401 - Akses tidak diizinkan!');
        else return $_valid;
    }

    /**
     * @param $x
     * @return int|double
     */
    public static function _nilai($x)
    {
        $y = '';
        foreach (self::$_nilai as $a => $b) {
            list($b1, $b2) = $b;
            if ($b1 <= $x && $x < $b2) {
                $y = $a;
                break;
            }
        }
        return $y;
    }
}