<?php
// Include config dan class
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../controllers/Databases.php';
include_once __DIR__ . '/../controllers/CLogbook.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header JSON
header('Content-Type: application/json');

// Bersihkan buffer jika ada
@ob_clean();


function handleInsert() {
    $nim = '12345';
    $tanggal = $_POST['tanggal'] ?? null;
    $jkem = $_POST['jkem'] ?? null;
    $uraian = $_POST['uraian'] ?? null;
    $target = $_POST['target'] ?? null;

    $uploadedFiles = uploadFiles('foto');

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

function uploadFiles($inputName) {
    $uploadedFiles = [];
    if (isset($_FILES[$inputName])) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        foreach ($_FILES[$inputName]['name'] as $key => $filename) {
            $tmp_name = $_FILES[$inputName]['tmp_name'][$key];
            if (is_uploaded_file($tmp_name)) {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $newName = uniqid('foto_') . '.' . $ext;
                $uploadPath = $uploadDir . $newName;

                if (!move_uploaded_file($tmp_name, $uploadPath)) {
                    throw new Exception("Gagal upload file: $filename");
                }

                $uploadedFiles[] = $newName;
            }
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
