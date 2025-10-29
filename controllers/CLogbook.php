<?php
include_once __DIR__ . '/Databases.php';

class CLogbook extends Databases {
    private static $_i;

    public static function _gi() {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    // Ambil semua logbook mahasiswa berdasarkan NIM
    public function getById($nim) {
        $query = "SELECT * FROM logbook WHERE mahasiswa_nim = ?";
        $this->_STH = $this->_DBH->prepare($query);
        $this->_STH->execute([$nim]);
        return $this->_STH->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "
        SELECT 
            l.*, 
            s.seminar_status
        FROM logbook l
        LEFT JOIN seminar s ON l.seminar_id = s.seminar_id
    ";

        $this->_STH = $this->_DBH->prepare($query);
        $this->_STH->execute();

        return $this->_STH->fetchAll(PDO::FETCH_ASSOC);
    }


    // Tambah logbook baru
    public function insertLogbook($data) {

        $foto = isset($data['foto']) && is_array($data['foto']) ? $data['foto'] : [];

        return $this->insert(
            'logbook',
            ['seminar_id', 'nama', 'mahasiswa_nim', 'tanggal', 'jkem', 'uraian', 'target', 'foto'],
            [[$data['seminar_id'], $data['nama'], $data['nim'], $data['tanggal'], $data['jkem'], $data['uraian'], $data['target'], json_encode($foto)]]
        );
    }


    // Hapus logbook
    public function deleteLogbook($id) {
        return $this->delete('logbook', 'id', $id);
    }
    public function updateLogbook($id, $data) {

        if (isset($data['foto']) && is_array($data['foto'])) {
            $data['foto'] = json_encode($data['foto']);
        }


        return $this->update('logbook', $data, 'id', $id);
    }

    public function getLogbookById($id) {
        $query = "SELECT * FROM logbook WHERE id = ?";
        $this->_STH = $this->_DBH->prepare($query);
        $this->_STH->execute([$id]);
        return $this->_STH->fetch(PDO::FETCH_ASSOC); // ambil satu row
    }
}
