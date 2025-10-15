<?php

/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

class Databases {
    /** @var PDO $_DBH */
    protected $_DBH;

    /** @var PDOStatement $_STH */
    protected $_STH;

    /** @var self $_i */
    private static $_i;

    public static function _gi() {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    /**
     * koneksi langsung saat class di instance
     *
     * @author Zaf
     */
    function __construct() {
        $this->_connect();
    }

    /**
     * koneksi ke database
     *
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $pass
     */
    function _connect($host = DB_HOST, $name = DB_NAME, $user = DB_USER, $pass = DB_PASS) {

        try {
            $this->_DBH = new PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $pass, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ));
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
     * eksekusi query tanpa ada pengembalian data
     *
     * @param $query
     * @return int
     */
    protected function _exec($query) {
        try {
            return $this->_DBH->exec($query);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * eksekusi query dengan data return
     *
     * @param $query
     * @param bool $all
     * @param int $mode
     * @param string $class
     * @return array|mixed
     */
    protected function _fetch($query, $all = false, $mode = PDO::FETCH_ASSOC, $class = '') {
        try {

            /**
             * saat `class_name` tidak ditentukan,
             * gunakan parameter `$mode` untuk fetch style
             */
            if (empty($class))
                return $all ?
                    $this->_DBH->query($query)->fetchAll($mode) :
                    $this->_DBH->query($query)->fetch($mode);

            /**
             * jika `class_name` ditentukan bisa dipastikan
             * kalau jenis fetch adalah objek (FETCH_CLASS)
             */
            else
                return $all ?
                    $this->_DBH->query($query)->fetchAll($mode, $class) :
                    $this->_DBH->query($query)->fetchObject($class);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * jumlah row yang dihasilkan dari suatu query
     *
     * @param $query
     * @return int
     */
    protected function _rows($query) {
        try {
            return $this->_DBH->query($query)->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * jumlah kolom yang dihasilkan dari suatu query
     *
     * @param $query
     * @return int
     */
    protected function _fields($query) {
        try {
            return $this->_DBH->query($query)->columnCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * fungsi buat insert value
     *
     * @param string $table
     * @param array $column
     * @param array $value
     * @param bool $ignore_on_duplicate
     * @return bool $res
     * @author Zaf
     */
    protected function insert($table, $column = array(), $value = array(), $ignore_on_duplicate = false) {

        $values = array();
        $number_of_value = count($value);
        $query = 'INSERT ' . ($ignore_on_duplicate ? 'IGNORE ' : '') . 'INTO ' . $table . ' ( ' . implode(', ', $column) . ' ) VALUES ';

        foreach ($value as $k => $v) {
            $values = array_merge($values, $v);
            $query .= '(' . implode(', ', array_fill(0, count($v), '?')) . ')' .
                ($k < ($number_of_value - 1) ? ', ' : '');
        }

        $this->_STH = $this->_DBH->prepare($query);

        try {
            $this->_STH->execute($values);
            return $this->_DBH->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * fungsi standar buat update value,
     *
     * @param string $table
     * @param array $column
     * @param array $value
     * @param array $condition
     * @return bool
     * @author Zaf
     */
    protected function update($table, $data = array(), $keyField = '', $keyValue = '') {
        $set = [];
        $params = [];

        foreach ($data as $field => $value) {
            $set[] = "$field = ?";
            $params[] = $value;
        }

        $sql = "UPDATE $table SET " . implode(', ', $set);

        if ($keyField && $keyValue !== '') {
            $sql .= " WHERE $keyField = ?";
            $params[] = $keyValue; // tambahkan ID ke array params
        }

        $this->_STH = $this->_DBH->prepare($sql);

        try {
            return $this->_STH->execute($params); // <-- pastikan semua parameter ada di array
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
     * fungsi buat delete value
     *
     * @param string $table
     * @param string $column
     * @param string $value
     * @return bool
     * @author Zaf
     */
    protected function delete($table, $column, $value) {
        $query = 'DELETE FROM `' . $table . '` WHERE `' . $column . '` = "' . $value . '"';
        return $this->_exec($query);
    }


    public function fetchPublic($query, $multi = false) {
        return $this->_fetch($query, $multi);
    }
}
