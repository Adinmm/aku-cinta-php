<?php
/**
 * Model MLogbookFoto
 */
class MLogbookFoto extends Databases
{
    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) self::$_i = new self();
        return self::$_i;
    }

    public function insertFoto($data)
    {
        $table = 'logbook_foto';
        $columns = array_keys($data);
        $values = array(array_values($data));
        return $this->insert($table, $columns, $values);
    }

    public function getByLogbookId($id)
    {
        $id = intval($id);
        $query = 'SELECT * FROM logbook_foto WHERE logbook_id = ' . $id . ' ORDER BY id ASC';
        return $this->_fetch($query, true); 
    }

    public function deleteFoto($id)
    {
        return $this->delete('logbook_foto', 'id', $id);
    }

    public function deleteByLogbookId($logbook_id)
    {
        $logbook_id = intval($logbook_id);
        $query = 'DELETE FROM logbook_foto WHERE logbook_id = ' . $logbook_id;
        return $this->_exec($query);
    }
}
?>