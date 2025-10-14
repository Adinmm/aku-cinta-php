<?php

include_once '../../init.php';

const ENABLE = true;

class DB extends Databases
{
    function _update_kode($_old, $_new)
    {
        $_changes = array(
            array(
                'table' => 'bimbingan',
                'field' => 'dosen_kode', 'fieldv' => $_new,
                'where' => 'dosen_kode', 'wherev' => $_old),
            array(
                'table' => 'mahasiswa',
                'field' => 'dosen_pa_kode ', 'fieldv' => $_new,
                'where' => 'dosen_pa_kode ', 'wherev' => $_old),
            array(
                'table' => 'dosen',
                'field' => 'dosen_kode', 'fieldv' => $_new,
                'where' => 'dosen_kode', 'wherev' => $_old),
            array(
                'table' => 'dosen',
                'field' => 'dosen_nip', 'fieldv' => $_new,
                'where' => 'dosen_nip', 'wherev' => $_old),
            array(
                'table' => 'operator',
                'field' => 'operator_id', 'fieldv' => $_new,
                'where' => 'operator_id', 'wherev' => $_old),
            array(
                'table' => 'operator',
                'field' => 'operator_username', 'fieldv' => $_new,
                'where' => 'operator_username', 'wherev' => $_old),
            array(
                'table' => 'pengajuan',
                'field' => 'dosen_kode', 'fieldv' => $_new,
                'where' => 'dosen_kode', 'wherev' => $_old),
            array(
                'table' => 'pengajuan', 'use_like' => true,
                'field' => 'pengajuan_ttd', 'fieldv' => $_new,
                'where' => 'pengajuan_ttd', 'wherev' => $_old),
            array(
                'table' => 'status',
                'field' => 'operator_id', 'fieldv' => $_new,
                'where' => 'operator_id', 'wherev' => $_old),
        );

        foreach ($_changes as $_item) {
            if (isset($_item['use_like'])) {
                $this->_exec('UPDATE IGNORE ' . $_item['table'] . ' SET ' . $_item['field'] . ' = REPLACE(' . $_item['field'] . ', "' . $_item['wherev'] . '", "' . $_item['fieldv'] . '") WHERE ' . $_item['where'] . ' LIKE "%' . $_item['wherev'] . '%"');
            } else {
                $this->_exec('UPDATE IGNORE ' . $_item['table'] . ' SET ' . $_item['field'] . ' = "' . $_item['fieldv'] . '" WHERE ' . $_item['where'] . ' = "' . $_item['wherev'] . '"');
            }
        }
    }
}


if (ENABLE) {

    $_old = Helpers::_arr($_POST, 'old');
    $_new = Helpers::_arr($_POST, 'new');

    ?>

    <h1>Migrasi username</h1>

    <form method="post">
        <input type="text" name="old" placeholder="Username lama" value="<?php echo $_old; ?>">
        <input type="text" name="new" placeholder="Username baru" value="<?php echo $_new; ?>">
        <input type="submit" name="submit" value="Proses">
    </form>

    <?php

    if (Helpers::_arr($_POST, 'submit') && $_old != '' && $_new != '') {

        $_db = new DB();
        $_db->_update_kode($_old, $_new);

        print '... selesai!';

    }

}