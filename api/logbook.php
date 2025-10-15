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

$action = $_POST['action'] ?? '';

try {
    if ($action === 'insert') {
        $nim = '12345'; // bisa diganti sesuai session/user login
        $tanggal = $_POST['tanggal'] ?? null;
        $jkem = $_POST['jkem'] ?? null;
        $uraian = $_POST['uraian'] ?? null;
        $target = $_POST['target'] ?? null;
        $foto = $_FILES['foto']['name'] ?? null;

        // Upload file
        if ($foto && isset($_FILES['foto']['tmp_name']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadPath = $uploadDir . basename($foto);
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $uploadPath)) {
                throw new Exception("Gagal upload file.");
            }
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
        $id = $_POST['id'] ?? null;
        if (!$id) throw new Exception("ID tidak ada.");
        CLogbook::_gi()->deleteLogbook($id);
        echo json_encode(['status' => 'success']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
    exit;

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}
