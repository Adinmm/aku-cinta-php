<?php
include_once __DIR__ . '/../../controllers/CLogbook.php';

// Ambil semua logbook mahasiswa
$logbooks = CLogbook::_gi()->getAll('12345');
?>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<div style="
    border: 1px solid #ccc;
  
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    background-color: #fff;
  ">

    <p style="padding: 2rem; font-size: 1.5rem; border-bottom: solid 1px #ccc; font-weight: bold;">
        Periode 2025 (Ganjil)
    </p>

    <div style="  padding: 2rem;">

        <div style="display: flex; align-items: end; gap: 10px;" class="mb-3 text-end">


            <button
                type="button"
                style="
             padding: 0 10px;
             display: inline-flex;
             align-items: center;
             gap: 6px;
             cursor: pointer;
             border: solid 1px #3954f0ff;
             border-radius: 3px;
             background-color: #3954f0ff;
             color: white;
             height: 25px;
        
         ">

                <span style="font-size:1.3rem;">Kelompok</span>
            </button>


            <button
                style="
             padding: 7px 14px;
             border: 1px solid #22b0b0ff;
             background-color: transparent;
             color: #22b0b0ff;
             border-radius: 6px;
             display: flex;
             align-items: center;
             gap: 5px;
             cursor: pointer;
         "
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">
                <i class="bi bi-plus" style="font-size: 2rem; line-height: 1; font-weight: 700;"></i>
                <p style="margin: 0; line-height: 1; font-size: 1.5rem;">Tambah</p>
            </button>



        </div>

        <div style="overflow-x:auto;">
            <table style="border-bottom: solid 1px #ccc;" class="table table-striped mt-2 width:100%; ">
                <thead>
                    <tr>
                        <th style="width:5%; text-align:center;">No</th>
                        <th style="width:12%; text-align:center;">Tanggal</th>
                        <th style="min-width:10px; text-align:start;">JKEM</th>
                        <th style="min-width:450px; text-align:start;">Uraian</th>
                        <th style="min-width:350px; text-align:start;">Target</th>
                        <th style="width:5%; text-align:center;">Foto</th>
                        <th style="width:20%; text-align:center;">#</th>
                    </tr>
                </thead>
                <tbody id="logbookTableBody">
                    <?php if (empty($logbooks)): ?>
                        <tr id="emptyRow">
                            <td colspan="7" style="text-align:start;">Belum ada data logbook.</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $totalJkem = 0; // Inisialisasi total JKEM
                        foreach ($logbooks as $i => $lb):
                            $totalJkem += (float)$lb['jkem']; // Tambahkan JKEM ke total
                        ?>
                            <tr>
                                <td style="text-align:center;"><?= $i + 1 ?></td>
                                <td style="text-align:center;"><?= htmlspecialchars($lb['tanggal']) ?></td>
                                <td style="text-align:left;"><?= htmlspecialchars($lb['jkem']) ?> </td>
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
                                            $fotoNum = 1;

                                            foreach ($fotos as $foto) {
                                                $filePath = 'http://localhost:8080/uploads/' . htmlspecialchars($foto);

                                                echo '<a href="' . $filePath . '" download title="Download foto">';
                                                echo '<div style="display: flex; justify-content: center; align-items: center; gap: 5px; margin-bottom: 5px;">';
                                                echo '<i class="fa fa-download" style="font-size:16px; line-height:1;"></i>';
                                                echo '<p style="margin:0; line-height:1;">#' . $fotoNum . '</p>';
                                                echo '</div>';
                                                echo '</a>';

                                                $fotoNum++;
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
                                    <div style="display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;">
                                        <button style="padding: 5px 10px; border:1px solid blue; background-color: transparent; color: blue; border-radius: 6px;" onclick="editLogbook(<?= $lb['id'] ?>, this)">
                                            <i class="fa fa-pencil"></i> Edit
                                        </button>
                                        <button style="padding: 5px 10px; border:1px solid red; background-color: transparent; color: red; border-radius: 6px; width: 80px;" onclick="deleteLogbook(<?= $lb['id'] ?>, this)">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: white; font-weight: bold; width: 100%;">
                            <td colspan="2" style=" padding-right: 15px; padding-bottom: 60px; padding-top: 10px;">Total</td>
                            <td style="text-align:left; width: 50%; color: red;padding-bottom: 60px; padding-top: 10px;"><?= number_format($totalJkem) ?> Jam</td>
                            <td colspan="4"></td>

                        </tr>


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





<!-- Modal Edit Logbook -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <div class="modal-header">
            <div>
                <h4 style="text-align: center; font-size: 2.5rem;">Edit</h4>
                <p style="text-align: center;">Logbook PKL</p>
            </div>

        </div>

        <form id="logbookEditForm" method="post" enctype="multipart/form-data" action="proses_edit_logbook.php">
            <input type="hidden" name="id" id="edit_id">

            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_tanggal">Tanggal</label>

                    <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_jkem">JKEM</label>
                    <div class="input-group">
                        <input type="number" name="jkem" id="edit_jkem" class="form-control" placeholder="Masukkan JKEM" required>
                        <span class="input-addon">Jam</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_uraian">Uraian</label>
                    <textarea name="uraian" id="edit_uraian" class="form-control" placeholder="Masukkan uraian" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_target">Target</label>
                    <textarea name="target" id="edit_target" class="form-control" placeholder="Masukkan target" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_foto1">Foto 1 (Baru)</label>
                    <input type="file" name="foto1" id="edit_foto1" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format: <span class="text-danger">jpg/jpeg, png</span></small>
                </div>

                <div class="form-group">
                    <label for="edit_foto2">Foto 2 (Baru)</label>
                    <input type="file" name="foto2" id="edit_foto2" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format: <span class="text-danger">jpg/jpeg, png</span></small>
                </div>

                <div class="form-group">
                    <label for="edit_foto3">Foto 3 (Baru)</label>
                    <input type="file" name="foto3" id="edit_foto3" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format: <span class="text-danger">jpg/jpeg, png</span></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModalTambah()">&times;</span>
        <div class="modal-header">
            <div>
                <h4 style="text-align: center; font-size: 2.5rem;">Tambah</h4>
                <p style="text-align: center;">Logbook PKL</p>
            </div>

        </div>

        <form id="logbookForm" method="post" enctype="multipart/form-data" action="proses_tambah_logbook.php">
            <div class="modal-body">
                <div class="form-group">
                    <label for="tanggal">Tanggal <span style="color: red;">*</span></label>

                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jkem">JKEM <span style="color: red;">*</span></label>
                    <div class="input-group">
                        <input type="number" name="jkem" id="jkem" class="form-control" placeholder="Masukkan JKEM" required>
                        <span class="input-addon">Jam</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="uraian">Uraian <span style="color: red;">*</span></label>
                    <textarea name="uraian" id="uraian" class="form-control" placeholder="Masukkan uraian" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="target">Target <span style="color: red;">*</span></label>
                    <textarea name="target" id="target" class="form-control" placeholder="Masukkan target" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="foto1">Foto 1</label>
                    <input type="file" name="foto1" id="foto1" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format: <span class="text-danger">jpg/jpeg, png</span></small>
                </div>

                <div class="form-group">
                    <label for="foto2">Foto 2</label>
                    <input type="file" name="foto2" id="foto2" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format: <span class="text-danger">jpg/jpeg, png</span></small>
                </div>

                <div class="form-group">
                    <label for="foto3">Foto 3</label>
                    <input type="file" name="foto3" id="foto3" class="form-control-file" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">Format: <span class="text-danger">jpg/jpeg, png</span></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalTambah()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Hilangkan panah number input */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }


    .modal {
        display: none;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        padding: 20px;
        animation: fadeIn 0.3s ease;
      
    }

    .modal-content {
        background-color: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s ease;
        
    }

    .modal-header {
        padding: 18px 20px 14px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;

    }

    .modal-header h4 {
        margin: 0 0 2px 0;
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    .modal-header p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }

    .close {
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.2s;
        background: none;
        border: none;
        padding: 0;
        margin-left: 16px;
        position: absolute;
        top: 0;
        right: 0;
        padding: 1rem;
    }

    .close:hover {
        color: #374151;
    }

    .modal-body {
        padding: 16px 20px;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
        font-size: 13px;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        font-size: 13px;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-addon {
        display: flex;
        align-items: center;
        padding: 6.8px 12px;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-left: none;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .form-control-file {
        width: 100%;
        padding: 7px 10px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        font-size: 13px;
        background-color: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }

    .form-control-file:hover {
        border-color: #3b82f6;
    }

    .text-muted {
        display: block;
        margin-top: 3px;
        font-size: 11px;
        color: #6b7280;
    }

    .text-danger {
        color: #ef4444;
        font-weight: 500;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 50px;
        font-family: inherit;
    }

    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background-color: #f9fafb;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
    }

    .btn-secondary {
        background-color: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background-color: #f3f4f6;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #2563eb;
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
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Scrollbar styling */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Responsive */
    @media (max-height: 700px) {
        .modal-body {
            max-height: calc(100vh - 180px);
        }
    }

    @media (max-width: 576px) {
        .modal {
            padding: 10px;
        }

        .modal-header {
            padding: 16px 16px 12px;
        }

        .modal-body {
            padding: 14px 16px;
        }

        .modal-footer {
            padding: 10px 16px;
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
            let data;

            try {
                data = JSON.parse(text);
            } catch {
                console.error('Response bukan JSON:', text);
                throw new Error("Response bukan JSON! Cek PHP.");
            }

            if (data.status === 'success') {
                alert('✅ Logbook berhasil disimpan!');
                window.location.reload()

                const emptyRow = document.getElementById('emptyRow');
                if (emptyRow) emptyRow.remove();

                const fotos = Array.isArray(data.logbook.foto) && data.logbook.foto.length > 0 ?
                    data.logbook.foto.map(f => `<img src="http://localhost:8080/uploads/${f}" width="60" class="rounded me-1">`).join('') :
                    '-';


                const newRow = document.createElement('tr');
                newRow.innerHTML = `
        <td>${tbody.children.length + 1}</td>
        <td>${data.logbook.tanggal}</td>
        <td>${data.logbook.jkem}</td>
        <td>${data.logbook.uraian}</td>
        <td>${data.logbook.target}</td>
        <td>${fotos}</td>
        <td>
          <button class="btn btn-danger btn-sm" onclick="deleteLogbook(${data.logbook.id}, this)">Hapus</button>
        </td>
      `;
                tbody.appendChild(newRow);

                form.reset();
                closeModalTambah();
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