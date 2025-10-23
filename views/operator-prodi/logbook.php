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

        <div style="display: flex; align-items: end; gap: 10px;" class="mb-3 text-end margin-bottom: 10px;">


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



