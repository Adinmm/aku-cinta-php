<?php
include_once __DIR__ . '/CLogbook.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
ob_clean();

$action = $_POST['action'] ?? '';

if ($action === 'insert') {
    $nim = '12345';
    $tanggal = $_POST['tanggal'];
    $jkem = $_POST['jkem'];
    $uraian = $_POST['uraian'];
    $target = $_POST['target'];
    $foto = $_FILES['foto']['name'] ?? null;

    // Upload file
    if ($foto) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadPath = $uploadDir . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $uploadPath);
    }

    $data = [
        'nim' => $nim,
        'tanggal' => $tanggal,
        'jkem' => $jkem,
        'uraian' => $uraian,
        'target' => $target,
        'foto' => $foto
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
            'foto' => $foto
        ]
    ]);
    exit;
}

if ($action === 'delete') {
    $id = $_POST['id'];
    CLogbook::_gi()->deleteLogbook($id);
    echo json_encode(['status' => 'success']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
exit;
