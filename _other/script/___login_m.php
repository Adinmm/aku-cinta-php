<?php

require_once '../../init.php';

// quick login helper (debug friendly)
// Usage:
//  - show debug (no redirect):  http://.../__login_m.php?nim=M00001
//  - auto redirect after login: http://.../__login_m.php?nim=M00001&auto=1

$_nim = isset($_GET['nim']) && $_GET['nim'] ? $_GET['nim'] : 'M00001';

try {
    $_obj_mahasiswa = CMahasiswa::_gi()->_get($_nim);
    if (!$_obj_mahasiswa) {
        $_obj_mahasiswa = new MMahasiswa();
        $_obj_mahasiswa
            ->setMahasiswaNim($_nim)
            ->setMahasiswaNama('Coba')
            ->setMahasiswaNomorHp('081234567890')
            ->setMahasiswaEmail('mail@domain.com')
            ->setMahasiswaKuliah('Aktif')
            ->setMahasiswaFoto('')
            ->setDosenPaKode('D00001')
            ->setProdiId('552011');
        CMahasiswa::_gi()->_insert($_obj_mahasiswa);
    }

    Sessions::_gi()->_set(Helpers::dir_mahasiswa, $_nim, $_obj_mahasiswa);

    // Prepare redirect URL
    $redirect = Helpers::_a(Helpers::$_dir_default_page_map[Helpers::dir_mahasiswa]);

    // Debug output — show session info so we can confirm login worked
    echo '<h2>Quick login (debug)</h2>';
    echo '<p>NIM: <strong>' . htmlspecialchars($_nim) . '</strong></p>';
    echo '<p>Session name (class): ' . Sessions::SESSION_NAME . '</p>';
    echo '<p>PHP session name: ' . session_name() . '</p>';
    echo '<p>Session id: ' . session_id() . '</p>';
    echo '<h3>$_SESSION</h3>';
    echo '<pre>' . htmlspecialchars(print_r(
            isset($_SESSION) ? $_SESSION : 'SESSION_NOT_STARTED', true
        )) . '</pre>';

    echo '<p><a href="' . $redirect . '">Open app page</a></p>';

    // Auto-redirect only when explicitly requested to avoid hiding debug output
    if (isset($_GET['auto']) && $_GET['auto'] == '1') {
        header('Location: ' . $redirect);
        exit;
    }

} catch (Exception $e) {
    echo '<h2>Error</h2>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
}