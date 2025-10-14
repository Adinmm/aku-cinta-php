<?php
include_once __DIR__ . '/Databases.php';

class CLogbook extends Databases
{
    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    // Ambil semua logbook mahasiswa berdasarkan NIM
    public function getAll($nim)
    {
        $query = "SELECT * FROM logbook WHERE mahasiswa_nim = ?";
        $this->_STH = $this->_DBH->prepare($query);
        $this->_STH->execute([$nim]);
        return $this->_STH->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah logbook baru
    public function insertLogbook($data)
    {
        return $this->insert(
            'logbook',
            ['nim', 'tanggal', 'uraian', 'target'], // kolom
            [[$data['nim'], $data['tanggal'], $data['uraian'], $data['target']]] // value
        );
    }

    // Update logbook
    public function updateLogbook($id, $data)
    {
        return $this->update(
            'logbook',
            ['tanggal', 'uraian', 'target'], // kolom
            [$data['tanggal'], $data['uraian'], $data['target']], // value
            ['id', $id] // kondisi
        );
    }

    // Hapus logbook
    public function deleteLogbook($id)
    {
        return $this->delete('logbook', 'id', $id);
    }
}
