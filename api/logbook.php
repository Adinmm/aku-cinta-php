<?php

include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../controllers/Databases.php';
include_once __DIR__ . '/../controllers/CLogbook.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);


header('Content-Type: application/json');

@ob_clean();


function handleInsert() {
    $nim = $_GET['nim'] ?? '12345';
    $tanggal = $_POST['tanggal'] ?? null;
    $jkem = $_POST['jkem'] ?? null;
    $uraian = $_POST['uraian'] ?? null;
    $target = $_POST['target'] ?? null;

    $uploadedFiles = uploadFiles();

    $data = [
        'nim' => $nim,
        'tanggal' => $tanggal,
        'jkem' => $jkem,
        'uraian' => $uraian,
        'target' => $target,
        'foto' => $uploadedFiles
    ];

    $id = CLogbook::_gi()->insertLogbook($data);

    echo json_encode([
        'status' => 'success',
        'logbook' => array_merge(['id' => $id], $data)
    ]);
}



function handleDelete() {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID tidak ada.");
    CLogbook::_gi()->deleteLogbook($id);
    echo json_encode(['status' => 'success']);
}

function handleEdit() {
    $id = $_POST['id'] ?? null;
    if (!$id) throw new Exception("ID tidak ada.");

    $logbookOld = CLogbook::_gi()->getLogbookById($id);
    if (!$logbookOld) throw new Exception("Logbook tidak ditemukan!");

    $tanggal = $_POST['tanggal'] ?? $logbookOld['tanggal'];
    $jkem = $_POST['jkem'] ?? $logbookOld['jkem'];
    $uraian = $_POST['uraian'] ?? $logbookOld['uraian'];
    $target = $_POST['target'] ?? $logbookOld['target'];

    $uploadedFiles = uploadFiles('foto');
    if (empty($uploadedFiles)) {
        $uploadedFiles = json_decode($logbookOld['foto'], true) ?? [];
    }

    $data = [
        'tanggal' => $tanggal,
        'jkem' => $jkem,
        'uraian' => $uraian,
        'target' => $target,
        'foto' => $uploadedFiles
    ];

    CLogbook::_gi()->updateLogbook($id, $data);

    echo json_encode([
        'status_code' => 200,
        'status' => 'success',
        'logbook' => array_merge(['id' => $id], $data)
    ]);
}

function uploadFiles() {
    $uploadedFiles = [];
    foreach (['foto1', 'foto2', 'foto3'] as $field) {
        if (!empty($_FILES[$field]['name'])) {
            $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
            $newName = uniqid('foto_') . '.' . $ext;
            $uploadPath = __DIR__ . '/../uploads/' . $newName;
            move_uploaded_file($_FILES[$field]['tmp_name'], $uploadPath);
            $uploadedFiles[] = $newName;
        }
    }
    return $uploadedFiles;
}


function handleRequest() {
    $action = $_POST['action'] ?? '';
    try {
        switch ($action) {
            case 'insert':
                handleInsert();
                break;
            case 'edit':
                handleEdit();
                break;
            case 'delete':
                handleDelete();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}


handleRequest();
