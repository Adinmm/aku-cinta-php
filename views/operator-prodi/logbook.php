<?php
include_once __DIR__ . '/../../controllers/CLogbook.php';

// Ambil semua logbook mahasiswa
$nim = $_GET['nim'] ?? null;
if ($nim) {
    $logbooks = CLogbook::_gi()->getById($nim);
}
$students = CLogbook::_gi()->getAllMahasiswa();
?>

<head>
    <link rel="stylesheet" href="../../assets/css/logbook.css">
</head>

<div id="daftar-mahasiswa" class="logbook-root">
    <p class="logbook-periode">
        Daftar Logbook Mahasiswa
    </p>
    <div class="content">
        <div style="overflow-x:auto;">
            <table class="table table-striped mt-2 width:100%; ">
                <thead>
                    <tr>
                        <th style="width:5%; text-align:center;">No</th>
                        <th style="width:12%; text-align:center;">Nama</th>
                        <th style="min-width:10px; text-align:start;">NIM</th>
                        <th style="width:20%; text-align:center;">#</th>
                    </tr>
                </thead>
                <tbody id="logbookTableBody">
                    <?php if (empty($students)): ?>
                        <tr id="emptyRow">
                            <td colspan="7" style="text-align:start;">Belum ada data logbook.</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        foreach ($students as $i => $lb):
                        ?>
                            <tr>
                                <td style="text-align:center;"><?= $i + 1 ?></td>
                                <td style="text-align:center;"><?= htmlspecialchars($lb['mahasiswa_nama']) ?></td>
                                <td style="text-align:left;"><?= htmlspecialchars($lb['mahasiswa_nim']) ?> </td>
                                <td style="text-align:center;">
                                    <div style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;">
                                        <button class="btn-edit" id="btn-detail" onclick="openDetail('<?php echo $lb['mahasiswa_nim']; ?>')">
                                            Detail
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div>
    <div id="logbook" style="border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); background-color: #fff; display: none; margin-top: 20px;">
        <div style="display: flex; width: 100%; justify-content: space-between; align-items: center; border-bottom: solid 1px #ccc; padding: 2rem;">
            <p style=" font-size: 1.5rem; font-weight: bold;">
                Periode 2025 (Ganjil)
            </p>
            <button id="back" type="button" class="btn btn-success">Kembali</button>
        </div>
        <div style="  padding: 2rem;">
            <div style="overflow-x:auto;">
                <table style="border-bottom: solid 1px #ccc;" class="table table-striped mt-2 width:100%; ">
                    <thead>
                        <tr>
                            <th style="width:5%; text-align:center;">No</th>
                            <th class="truncate" style=" width: 200px; white-space: nowrap; text-overflow: ellipsis;text-align:start;">Tanggal</th>
                            <th class="truncate" style="width: 200px; white-space: nowrap; text-overflow: ellipsis;text-align:start;">Target</th>
                            <th style="min-width:450px; text-align:start;">Uraian</th>
                        </tr>
                    </thead>
                    <tbody id="logbookTableBody">
                        <?php if (empty($logbooks)): ?>
                            <tr id="emptyRow">
                                <td colspan="7" style="text-align:start;">Belum ada data logbook.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            foreach ($logbooks as $i => $lb):
                            ?>
                                <tr>
                                    <td style="text-align:center;"><?= $i + 1 ?></td>
                                    <td class="truncate" style=" width: 200px;white-space: nowrap; text-overflow: ellipsis;text-align:start;"><?= htmlspecialchars($lb['tanggal']) ?></td>
                                    <td style="text-align:left;" title="<?= htmlspecialchars($lb['uraian']) ?>">
                                        <?= htmlspecialchars($lb['uraian']) ?>
                                    </td>
                                    <td style="text-align:left;" title="<?= htmlspecialchars($lb['target']) ?>">
                                        <?= htmlspecialchars($lb['target']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </div>
        <div style="border-top: solid 1px #ccc; padding-top: 10px; padding: 20px; margin-top: 20px;">
            <p>
                <span style="color: red;">*</span>
                Isian wajib (*) harus diisi, jika belum melengkapi semua isian wajib maka logbook tidak dapat dilanjutkan.
            </p>
        </div>

    </div>
</div>


<script>
    const detail = document.getElementById("btn-detail");
    const logbook = document.getElementById("logbook");
    const students = document.getElementById("daftar-mahasiswa");
    const back = document.getElementById("back");
    const openDetail = (nim) => {
        window.location.href = `logbook?nim=${nim}`;
    }

    back.addEventListener("click", () => {
        window.location.href = "logbook";
    })

    window.onload = () => {
        const urlParams = new URLSearchParams(window.location.search);
        const nim = urlParams.get("nim");
        if (nim) {

            logbook.style.display = "block";
            students.style.display = "none";
        }
    }
</script>