<?php
include_once __DIR__ . '/../../controllers/CLogbook.php';


$nim = $_GET['nim'] ?? '';

$logbooks = [];
if (!empty($nim)) {
    // panggil controller dengan NIM dari input
    $logbooks = CLogbook::_gi()->getAll($nim);
}
?>

<div style="width:100%; display:flex; justify-content: space-between; margin-bottom:20px;">
    <div class="mb-3 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Logbook
    </button>
</div>
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
    <table class="table table-striped mt-2" style="width:100%; table-layout: auto;">
        <thead>
            <tr>
                <th style="width:5%; text-align:center;">No</th>
                <th style="width:12%; text-align:center;">Tanggal</th>
                <th style="min-width:250px; text-align:start;">JKEM</th> <!-- Bisa melebar -->
                <th style="min-width:150px; text-align:start;">Uraian</th>
                <th style="min-width:150px; text-align:center;">Target</th>
                <th style="width:15%; text-align:center;">Foto</th>
                <th style="width:16%; text-align:center;">Aksi</th>
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
                        <td style="text-align:center;" title="<?= htmlspecialchars($lb['target']) ?>">
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

                        <td style="text-align:center;">
                            <div style="display: flex; justify-content: center; gap: 5px;">
                                <button class="btn btn-warning btn-sm" onclick="editLogbook(<?= $lb['id'] ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteLogbook(<?= $lb['id'] ?>, this)">Hapus</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<!-- Modal Tambah Logbook -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Tambah Logbook</h4>
            <span class="close" onclick="closeModalTambah()">&times;</span>
        </div>
        <form id="logbookForm" method="post" enctype="multipart/form-data" action="proses_tambah_logbook.php">
            <div class="modal-body">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="jkem">JKEM</label>
                    <input type="text" name="jkem" id="jkem" class="form-control" placeholder="Masukkan JKEM" required>
                </div>
                <div class="form-group">
                    <label for="uraian">Uraian</label>
                    <textarea name="uraian" id="uraian" class="form-control" placeholder="Masukkan uraian" required></textarea>
                </div>
                <div class="form-group">
                    <label for="target">Target</label>
                    <input type="text" name="target" id="target" class="form-control" placeholder="Masukkan target" required>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto[]" id="foto" class="form-control" multiple>
                    <small class="text-muted">Bisa memilih lebih dari satu foto</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalTambah()">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Logbook -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Edit Logbook</h4>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="logbookEditForm" method="post" enctype="multipart/form-data" action="proses_edit_logbook.php">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="edit_tanggal" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_jkem">JKEM</label>
                    <input type="text" name="jkem" id="edit_jkem" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit_uraian">Uraian</label>
                    <textarea name="uraian" id="edit_uraian" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_target">Target</label>
                    <input type="text" name="target" id="edit_target" class="form-control">
                </div>
                <div class="form-group">
                    <label>Foto Lama</label>
                    <div id="edit_foto_lama" class="mb-2"></div>
                </div>
                <div class="form-group">
                    <label for="edit_foto">Tambah Foto Baru</label>
                    <input type="file" name="foto[]" id="edit_foto" class="form-control" multiple>
                    <small class="text-muted">Bisa memilih lebih dari satu foto</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>


<style>
    /* Semua modal memakai class sama */
    .modal {
        display: none;
        align-items: center;
        justify-content: center;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow-y: auto;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    .modal-content {
        background-color: #fff;
        margin: 50px auto;
        padding: 0;
        border-radius: 10px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        animation: slideIn 0.3s;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .modal-header h4 {
        margin: 0;
        font-size: 1.3rem;
    }

    .close {
        position: absolute;
        right: 20px;
        font-size: 1.5rem;
        cursor: pointer;
        color: #999;
        transition: color 0.2s;
    }

    .close:hover {
        color: #333;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 3px rgba(40, 167, 69, 0.3);
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn {
        padding: 8px 18px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>


<script>
    const form = document.getElementById('logbookForm');
    const modal = document.getElementById('modalTambah');
    const tbody = document.getElementById('logbookTableBody');
    const logbookEdit = document.getElementById('logbookEditForm');

    function closeModalTambah() {
        document.getElementById('modalTambah').style.display = 'none';
        form.reset();
    }

    function openModal() {
        modal.style.display = 'flex';
    }


    window.onclick = (event) => {
        if (event.target === modal) closeModal();
    };

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        formData.append('action', 'insert');


        for (const [key, value] of formData.entries()) {
            if (value instanceof File) {
                console.log(`${key}: File { name: ${value.name}, size: ${value.size} }`);
            } else {
                console.log(`${key}: ${value}`);
            }
        }


        try {
            const res = await fetch('http://localhost:8080/api/logbook.php', {
                method: 'POST',
                body: formData
            });

            const text = await res.text();
            console.log('Response:', text);

            let data;
            try {
                data = JSON.parse(text);
            } catch {
                throw new Error("Response bukan JSON! Cek PHP.");
            }

            if (data.status === 'success') {
                alert('✅ Logbook berhasil disimpan!');
                location.reload();

                const emptyRow = document.getElementById('emptyRow');
                if (emptyRow) emptyRow.remove();

                const fotoCell = data.logbook.foto ?
                    `<img src="http://localhost:8080/uploads/${data.logbook.foto}" alt="Foto" width="60" class="rounded">` :
                    '-';

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td>${data.logbook.tanggal}</td>
                <td>${data.logbook.jkem}</td>
                <td>${data.logbook.uraian}</td>
                <td>${data.logbook.target}</td>
                <td>${fotoCell}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="deleteLogbook(${data.logbook.id}, this)">Hapus</button>
                </td>
            `;
                tbody.appendChild(newRow);
            } else {
                alert('❌ Gagal menyimpan logbook: ' + (data.message || 'Terjadi kesalahan.'));
            }

        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan! Lihat console.');
        }
    });


    async function deleteLogbook(id, btn) {
        if (!confirm('Yakin ingin menghapus logbook ini?')) return;

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        try {
            const res = await fetch('http://localhost:8080/api/logbook.php', {
                method: 'POST',
                body: formData
            });

            const text = await res.text();
            console.log('Delete response:', text);

            let data;
            try {
                data = JSON.parse(text);
            } catch {
                throw new Error("Response delete bukan JSON!");
            }

            if (data.status === 'success') {
                btn.closest('tr').remove();
            } else alert('❌ Gagal menghapus logbook!');
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus!');
        }
    }



    function editLogbook(id) {
        // Ambil data logbook berdasarkan ID (bisa dari array JS atau fetch API)
        const logbook = <?= json_encode($logbooks) ?>.find(lb => lb.id == id);
        if (!logbook) {
            alert('Logbook tidak ditemukan!');
            return;
        }

        // Isi form edit dengan data logbook
        document.getElementById('edit_id').value = logbook.id;
        document.getElementById('edit_tanggal').value = logbook.tanggal;
        document.getElementById('edit_jkem').value = logbook.jkem;
        document.getElementById('edit_uraian').value = logbook.uraian;
        document.getElementById('edit_target').value = logbook.target;

        // Tampilkan foto lama
        const fotoLamaDiv = document.getElementById('edit_foto_lama');
        fotoLamaDiv.innerHTML = '';
        if (logbook.foto) {
            const fotos = JSON.parse(logbook.foto);
            fotos.forEach(foto => {
                const img = document.createElement('img');
                img.src = 'http://localhost:8080/uploads/' + foto;
                img.alt = 'Foto';
                img.style.width = '50px';
                img.style.height = '50px';
                img.style.margin = '2px';
                img.style.borderRadius = '5px';
                fotoLamaDiv.appendChild(img);
            });
        } else {
            fotoLamaDiv.innerText = 'Tidak ada foto.';
        }


        openModalEdit();
    }

    logbookEdit.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(logbookEdit);
        formData.append('action', 'edit');

        try {
            const res = await fetch('http://localhost:8080/api/logbook.php', {
                method: 'POST',
                body: formData
            });

            const text = await res.text();
            console.log('Update response:', text);

            let data;
            try {
                data = JSON.parse(text);
            } catch {
                throw new Error("Response update bukan JSON!");
            }

            if (data.status === 'success') {
                alert('✅ Logbook berhasil diubah!');
                location.reload();
            } else alert('❌ Gagal mengubah logbook!');
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat mengubah!');
        }
    });



    function closeEditModal() {
        document.getElementById('modalEdit').style.display = 'none';
    }

    const openModalEdit = () => {
        document.getElementById('modalEdit').style.display = 'flex';

    }
</script>