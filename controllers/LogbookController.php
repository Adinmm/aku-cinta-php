<?php
include_once __DIR__ . '/CLogbook.php';

$action = $_POST['action'] ?? '';

if ($action == 'add') {
    $nim = '12345'; // ganti sesuai session login
    $tanggal = $_POST['tanggal'];
    $jkem = $_POST['jkem'];
    $uraian = $_POST['uraian'];
    $target = $_POST['target'];

    $data = [
        'nim' => $nim,
        'tanggal' => $tanggal,
        'uraian' => $uraian,
        'target' => $target
    ];

    $id = CLogbook::_gi()->insertLogbook($data);

    echo json_encode([
        'status' => 'success',
        'logbook' => [
            'id' => $id,
            'tanggal' => $tanggal,
            'jkem' => $jkem,
            'uraian' => $uraian,
            'target' => $target,
            'fotos' => []
        ]
    ]);
    exit;
}

if ($action == 'delete') {
    $id = $_POST['id'];
    CLogbook::_gi()->deleteLogbook($id);
    echo json_encode(['status' => 'success']);
    exit;
}
