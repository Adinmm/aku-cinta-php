<?php
include_once __DIR__ . '/../../controllers/CLogbook.php';

// Ambil semua logbook mahasiswa
$logbooks = CLogbook::_gi()->getAll('12345');

foreach ($logbooks as $lb) {
    echo $lb['tanggal'] . ' - ' . $lb['uraian'] . ' - ' . $lb['target'] . '<br>';
}
?>
<!-- Button Tambah Logbook -->
<div class="mb-3 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Logbook
    </button>
</div>

<!-- Tabel Logbook -->
<table class="table table-striped table- mt-2">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>JKEM</th>
            <th>Uraian</th>
            <th>Target</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($logbooks)): ?>
            <tr>
                <td colspan="7" class="text-center">Belum ada data logbook.</td>
            </tr>
        <?php else: ?>
            <?php foreach($logbooks as $i => $lb): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($lb->getTanggal()) ?></td>
                    <td><?= htmlspecialchars($lb->getJkem()) ?></td>
                    <td><?= htmlspecialchars($lb->getUraian()) ?></td>
                    <td><?= htmlspecialchars($lb->getTarget()) ?></td>
                    <td>
                        <?php
                        $fotos = json_decode($lb->getFoto(), true) ?: [];
                        foreach($fotos as $j => $f) {
                            echo "<a href='".htmlspecialchars($f)."' target='_blank'>#".($j+1)."</a><br>";
                        }
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="deleteLogbook(<?= $lb->getId() ?>)">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- Modal Tambah Logbook -->
<div id="modalTambah" class="modal" style="display:none;">
  <div class="modal-content">
    <div class="modal-header">
      <h4>Tambah Logbook</h4>
      <span class="close" onclick="closeModal()">&times;</span>
    </div>
    <form id="logbookForm" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="form-group">
            <label>JKEM</label>
            <input type="text" name="jkem" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Uraian</label>
            <textarea name="uraian" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Target</label>
            <input type="text" name="target" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Foto (boleh lebih dari 1)</label>
            <input type="file" name="foto[]" class="form-control" multiple accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
    document.getElementById('logbookForm').addEventListener('submit', function(e){
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    formData.append('action','add');

    fetch('controllers/LogbookController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            closeModal();

            const tbody = document.getElementById('logbookTableBody');

            // hapus row kosong jika ada
            const emptyRow = document.getElementById('emptyRow');
            if(emptyRow) emptyRow.remove();

            // buat row baru
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td>${data.logbook.tanggal}</td>
                <td>${data.logbook.jkem}</td>
                <td>${data.logbook.uraian}</td>
                <td>${data.logbook.target}</td>
                <td></td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="deleteLogbook(${data.logbook.id}, this)">Hapus</button>
                </td>
            `;
            tbody.appendChild(newRow);

            form.reset();
        }
    })
    .catch(err => console.error(err));
});


</script>