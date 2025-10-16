<?php
include_once __DIR__ . '/../../controllers/CLogbook.php';


$nim = $_GET['nim'] ?? '';

$logbooks = [];
if (!empty($nim)) {
    // panggil controller dengan NIM dari input
    $logbooks = CLogbook::_gi()->getAll($nim);
}
?>

<div style="width:100%; display:flex; justify-content: end; margin-bottom:20px;">

    <form method="GET" style="display:flex; gap:10px; max-width:450px; width:100%;">
        <!-- Input dengan icon di depan -->
        <span class="input-group-text bg-white border-end-0">
            <i class="bi bi-search"></i>
        </span>
        <input
            type="text"
            name="nim"
            class="form-control border-start-0"
            placeholder="Cari berdasarkan NIM"
            required>
        <!-- Tombol Search -->
        <button class="btn btn-primary" type="submit">
            Cari
        </button>
    </form>
</div>




<div style="overflow-x:auto;">
    <table class="table table-striped mt-2 width:100%;">
        <thead>
            <tr>
                <th style="width:5%; text-align:center;">No</th>
                <th style="width:12%; text-align:center;">Tanggal</th>
                <th style="min-width:450px; text-align:start;">JKEM</th> <!-- Bisa melebar -->
                <th style="min-width:350px; text-align:start;">Uraian</th>
                <th style="min-width:250px; text-align:start;">Target</th>
                <th style="width:15%; text-align:center;">Foto</th>
       

            </tr>
        </thead>
        <tbody id="logbookTableBody">
            <?php if (empty($logbooks)): ?>
                <tr id="emptyRow">
                    <td colspan="7" style="text-align:center;">Belum ada data logbook.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($logbooks as $i => $lb): ?>
                    <tr>
                        <td style="text-align:center;"><?= $i + 1 ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($lb['tanggal']) ?></td>
                        <td style="text-align:left;"><?= htmlspecialchars($lb['jkem']) ?></td> <!-- Tampil penuh -->
                        <td style="text-align:left;" title="<?= htmlspecialchars($lb['uraian']) ?>">
                            <?= htmlspecialchars($lb['uraian']) ?>
                        </td>
                        <td style="text-align:left;" title="<?= htmlspecialchars($lb['target']) ?>">
                            <?= htmlspecialchars($lb['target']) ?>
                        </td>
                        <td style="text-align:center;">
                            <?php
                            if (!empty($lb['foto'])) {
                                $fotos = json_decode($lb['foto'], true);
                                if (is_array($fotos) && count($fotos) > 0) {
                                    foreach ($fotos as $foto) {
                                        $filePath = 'http://localhost:8080/uploads/' . $foto;
                                        echo '<a href="' . htmlspecialchars($filePath) . '" download title="Download foto">';
                                        echo '<img src="' . htmlspecialchars($filePath) . '" alt="Foto" style="width:50px;height:50px;margin:2px;border-radius:5px;">';
                                        echo ' <i class="fa fa-download"></i>';
                                        echo '</a><br>';
                                    }
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>






