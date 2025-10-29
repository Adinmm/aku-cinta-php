<?php
include_once __DIR__ . '/../../controllers/CLogbook.php';


$logbooks = CLogbook::_gi()->getById('F1D021001');
?>

<head>
    <link rel="stylesheet" href="../../assets/css/logbook.css">
</head>

<div class="logbook-root">

    <p class="logbook-periode">
        Periode 2025 (Ganjil)
    </p>

    <div class="content">
        <div class="mb-3">

            <button
                class="btn-tambah"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>

                <p style="  margin: 0; line-height: 1; font-size: 1.5rem;">Tambah</p>
            </button>
        </div>
        <div style="overflow-x:auto;">
            <table class="table table-striped mt-2 width:100%; ">
                <thead>
                    <tr>
                        <th style="width:5%; text-align:center;">No</th>
                        <th class="truncate" style="  width: 200px;white-space: nowrap; text-overflow: ellipsis;text-align:start;">Tanggal</th>
                        <th class="truncate" style="  width: 200px; white-space: nowrap; text-overflow: ellipsis;text-align:start;">Durasi (Jam)</th>
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
                                <td class="truncate" style="  width: 200px;white-space: nowrap; text-overflow: ellipsis;text-align:start;"><?= htmlspecialchars($lb['tanggal']) ?></td>
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
                                        <button class="btn-edit" style="" onclick="editLogbook(<?= $lb['id'] ?>, this)">
                                            <i class="fa fa-pencil"></i> Edit
                                        </button>
                                        <button class="btn-hapus" onclick="deleteLogbook(<?= $lb['id'] ?>, this)">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="total-footer">
                            <td colspan="2">Total</td>
                            <td colspan="2"><?= number_format($totalJkem) ?> Jam</td>
                            <td colspan="4"></td>

                        </tr>


                    <?php endif; ?>
                </tbody>
            </table>

        </div>

    </div>
    <div style="border-top: solid 1px #ccc; padding-top: 10px; padding: 20px; margin-top: 30px;">
        <p>

            * Isian wajib (*) harus diisi, jika belum melengkapi semua isian wajib maka logbook tidak dapat dilanjutkan.
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
            <input type="hidden" name="id" id="edit_id" />

            <div style="background-color: #f5f5f5; width: 100%; padding: 10px 0;">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal <span>*</span></label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label for="edit_jkem">Durasi<span>*</span></label>
                        <div class="input-group">
                            <input
                                type="number"
                                name="jkem"
                                id="edit_jkem"
                                class="form-control"
                                placeholder="Masukkan JKEM"
                                required />
                            <span style="font-size: 12px; color: #000000;" class="input-addon">Jam</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_uraian">Uraian <span>*</span></label>
                        <textarea
                            name="uraian"
                            id="edit_uraian"
                            class="form-control"
                            placeholder="Masukkan uraian"
                            rows="5"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_target">Target <span>*</span></label>
                        <textarea
                            name="target"
                            id="edit_target"
                            class="form-control"
                            placeholder="Masukkan target"
                            rows="5"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_foto1" class="font-weight-bold">Foto 1</label>
                        <div>
                            <input
                                type="file"
                                name="foto1"
                                id="edit_foto1"
                                class="form-control-file"
                                accept=".jpg,.jpeg,.png" />
                            <small class="text-muted d-block mt-1">
                                Format dokumen scan <span class="text-danger">JPG, JPEG, PNG</span>
                            </small>

                            <?php
                            if (!empty($lb['foto'])) {
                                $fotos = json_decode($lb['foto'], true);
                                if (is_array($fotos) && isset($fotos[0])) {
                                    $foto = $fotos[0];
                                    $filePath = 'http://localhost:8080/uploads/' . htmlspecialchars($foto);
                                    echo '<div class="mt-2 p-2" style="display: inline-flex; align-items: center; gap: 6px;">';
                                    echo '<i class="fa fa-download" style="font-size:16px; line-height:1; color:blue;"></i>';
                                    echo '<a href="' . $filePath . '" download title="Download Foto" >#1</a>';
                                    echo '</div>';
                                } else {
                                    echo '<p style="color:red;" class="text-muted mt-2">Tidak ada foto.</p>';
                                }
                            } else {
                                echo '<p style="color:red;" class="text-muted mt-2">Tidak ada foto.</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="edit_foto2" class="font-weight-bold">Foto 2</label>
                        <div>
                            <input
                                type="file"
                                name="foto2"
                                id="edit_foto2"
                                class="form-control-file"
                                accept=".jpg,.jpeg,.png" />
                            <small class="text-muted d-block mt-1">
                                Format dokumen scan <span class="text-danger">JPG, JPEG, PNG</span>
                            </small>
                            <?php
                            if (!empty($lb['foto'])) {
                                $fotos = json_decode($lb['foto'], true);
                                if (is_array($fotos) && isset($fotos[1])) {
                                    $foto = $fotos[1];
                                    $filePath = 'http://localhost:8080/uploads/' . htmlspecialchars($foto);
                                    echo '<div class="mt-2 p-2" style="display: inline-flex; align-items: center; gap: 6px;">';
                                    echo '<i class="fa fa-download" style="font-size:16px; line-height:1; color:blue;"></i>';
                                    echo '<a href="' . $filePath . '" download title="Download Foto" >#2</a>';
                                    echo '</div>';
                                } else {
                                    echo '<p style="color:red;" class="text-muted mt-2">Tidak ada foto.</p>';
                                }
                            } else {
                                echo '<p style="color:red;" class="text-muted mt-2">Tidak ada foto.</p>';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="edit_foto3" class="font-weight-bold">Foto 3</label>
                        <div>
                            <input
                                type="file"
                                name="foto3"
                                id="edit_foto3"
                                class="form-control-file"
                                accept=".jpg,.jpeg,.png" />
                            <small class="text-muted d-block mt-1">
                                Format dokumen scan <span class="text-danger">JPG, JPEG, PNG</span>
                            </small>

                            <?php
                            if (!empty($lb['foto'])) {
                                $fotos = json_decode($lb['foto'], true);
                                if (is_array($fotos) && isset($fotos[2])) {
                                    $foto = $fotos[2];
                                    $filePath = 'http://localhost:8080/uploads/' . htmlspecialchars($foto);
                                    echo '<div class="mt-2 p-2 text-white rounded" style="display: inline-flex; align-items: center; gap: 6px;">';
                                    echo '<div class="mt-2 p-2" style="display: inline-flex; align-items: center; gap: 6px;">';
                                    echo '<i class="fa fa-download" style="font-size:16px; line-height:1; color:blue;"></i>';
                                    echo '<a href="' . $filePath . '" download title="Download Foto" >#3</a>';
                                    echo '</div>';
                                } else {
                                    echo '<p style="color:red;" class="text-muted mt-2">Tidak ada foto.</p>';
                                }
                            } else {
                                echo '<p style="color:red;" class="text-muted mt-2">Tidak ada foto.</p>';
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-success btn-simpan">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-floppy"
                        viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z" />
                        <path
                            d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                    </svg>
                    <p>Update</p>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" enctype="multipart/form-data" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModalTambah()">&times;</span>
        <div class="modal-header">
            <div>
                <h4 style="text-align: center; font-size: 2.5rem;">Tambah</h4>
                <p style="text-align: center;">Logbook PKL</p>
            </div>

        </div>

        <form id="logbookForm" method="post" enctype="multipart/form-data" action="proses_tambah_logbook.php">
            <div style="background-color: #f5f5f5; width: 100%; padding: 10px 0;">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal">Tanggal <span>*</span></label>

                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_jkem">Durasi <span>*</span></label>
                        <div class="input-group">
                            <input
                                type="number"
                                name="jkem"
                                id="edit_jkem"
                                class="form-control"
                                placeholder="Masukkan JKEM"
                                required />
                            <span style="font-size: 12px; color: #000000;" class="input-addon">Jam</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="uraian">Uraian <span>*</span></label>
                        <textarea name="uraian" id="uraian" class="form-control" placeholder="Masukkan uraian" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="target">Target <span>*</span></label>
                        <textarea name="target" id="target" class="form-control" placeholder="Masukkan target" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="foto1">Foto</label>
                        <div>
                            <input type="file" name="foto1" id="foto1" class="form-control-file" accept=".jpg,.jpeg,.png" required>
                            <span>Format dokumen scan <span class="text-danger">jpg/jpeg, png</span></span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="foto2"></label>
                        <div>
                            <input type="file" name="foto2" id="foto2" class="form-control-file" accept=".jpg,.jpeg,.png">
                            <span>Format dokumen scan <span class="text-danger">jpg/jpeg, png</span></span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="foto3"></label>
                        <div>
                            <input type="file" name="foto3" id="foto3" class="form-control-file" accept=".jpg,.jpeg,.png">
                            <span>Format dokumen scan <span class="text-danger">jpg/jpeg, png</span></span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalTambah()">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                        <path d="M11 2H9v3h2z" />
                        <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                    </svg>
                    <p>Simpan</p>
                </button>
            </div>
        </form>
    </div>
</div>


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

                const logbook = data.data || {};
                const fotos = Array.isArray(logbook.foto) && logbook.foto.length > 0 ?
                    logbook.foto.map(f => f ? `<img src="http://localhost:8080/uploads/${f}" width="60" class="rounded me-1">` : '-').join('') :
                    '-';

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td>${tbody.children.length + 1}</td>
                <td>${logbook.tanggal || '-'}</td>
                <td>${logbook.jkem || '-'}</td>
                <td>${logbook.uraian || '-'}</td>
                <td>${logbook.target || '-'}</td>
                <td>${fotos}</td>
                <td>
                  <button class="btn btn-danger btn-sm" onclick="deleteLogbook(${logbook.id}, this)">Hapus</button>
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

            let data;
            try {
                data = JSON.parse(text);
            } catch {
                throw new Error("Response delete bukan JSON!");
            }

            if (data.status === 'success') {
                btn.closest('tr').remove();
                window.location.reload();
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