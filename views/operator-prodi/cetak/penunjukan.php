<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

$obj_pengajuan = CPengajuan::_gi()->_get(Routes::_gi()->_depth(3));
$obj_pengajuan || $obj_pengajuan = new MPengajuan();

$obj_pengantar = CPengantar::_gi()->_get($obj_pengajuan->getPengantarId());
$obj_pengantar || $obj_pengantar = new MPengantar();

$_sign = Helpers::_arr($obj_pengajuan->getPengajuanTtd('array', CPengaturan::_gi()->_get('sekprodi_nip')), 'foto');

$__sheets = array(
    array(
        $obj_pengajuan->getMahasiswaNim(),
        $obj_pengajuan->getMahasiswaNama(),
        $obj_pengantar->getPengantarJudul(),
        $obj_pengantar->getPengantarTopik(),
    )
);

?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Penunjukan Dosen Pembimbing PKL</title>
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/normalize.min.css">
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/paper.min.css">
        <style>
            @page {
                size: A4
            }

            table {
                width: 100%;
            }

            ._center {
                text-align: center;
            }

            .title {
                font-size: 24px;
            }

            ._head .title {
                margin-top: 4px;
                font-size: 24px;
            }

            ._head .subtitle {
                font-size: 18px;
            }

            ._head .address {
                margin-top: 4px;
                font-size: 14px;
            }

            ._head .logo {
                padding: 0;
            }

            ._head .logo img {
                max-width: 100px;
            }

            ._head p {
                margin: 0 0 4px;
            }

            ._main {
                font-size: 16px;
            }

            ._note {
                font-size: 12px;
            }
        </style>
    </head>

    <body class="A4">

    <?php foreach ($__sheets as $__sheet) :
        list($__nim, $__nama, $__judul, $__topik) = $__sheet; ?>

        <section class="sheet padding-10mm">

            <table class="_head">
                <tbody>
                <tr>
                    <td class="logo">
                        <img src="<?php echo URI_IMG_PATH; ?>/logo.png" alt="<?php echo APP_NAME; ?>>"/>
                    </td>
                    <td class="_center">
                        <p class="subtitle">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</p>
                        <p class="subtitle">UNIVERSITAS MATARAM</p>
                        <p class="subtitle"><strong>FAKULTAS TEKNIK</strong></p>
                        <p class="address">Jln. Majapahit No. 62 Mataram 83125 Telp (0370) 636126, Fax (0370) 636523</p>
                    </td>
                </tr>
                </tbody>
            </table>

            <hr/>

            <p class="title _center">PENUNJUKAN DOSEN PEMBIMBING PRAKTEK KERJA LAPANGAN (PKL)</p>

            <br/>

            <table class="_main">
                <tbody>
                <tr>
                    <td style="width: 30px">1</td>
                    <td>Nama Mahasiswa / NIM :</td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php printf('%s (%s)', $__nama, $__nim); ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tempat PKL :</td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $obj_pengajuan->getTempatNama(); ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Judul PKL :</td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $__judul; ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Materi/topik PKL :</td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $__topik; ?></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Waktu Pelaksanaan PKL :</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php echo Helpers::__($obj_pengantar->getPengantarTanggalMulai('j F Y'), true); ?>
                        s/d <?php echo Helpers::__($obj_pengantar->getPengantarTanggalSelesai('j F Y'), true); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Dosen Pembimbing PKL yang ditugaskan oleh Kaprodi ( diisi oleh Kaprodi ) :</td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php printf('%s (%s)', $obj_pengajuan->getDosenNama(), $obj_pengajuan->getDosenNip('-')); ?></td>
                </tr>
                </tbody>
            </table>

            <br/>

            <table class="_main">
                <tbody>
                <tr>
                    <td style="width: 400px"></td>
                    <td>
                        Menyetujui<br/>
                        Program Studi Teknik Informatika<br/>
                        Sekretaris,
                    </td>
                </tr>
                <tr>
                    <td <?php echo !$_sign ? 'style="height: 100px;"' : ''; ?> ></td>
                    <td valign="bottom">
                        <?php if ($_sign) : ?>
                            <img alt="ttd"
                                 height="100px"
                                 src="<?php echo $_sign; ?>" style="display: block"/>
                        <?php endif; ?>
                        <u><?php echo CPengaturan::_gi()->_get('sekprodi_nama'); ?></u><br/>
                        NIP. <?php echo CPengaturan::_gi()->_get('sekprodi_nip'); ?>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="_note">
                <p>Catatan :</p>
                <ul>
                    <li>Blangko penunjukan dosen pembimbing PKL diserahkan kepada Sekprodi jika sudah mendapat
                        surat_tugas balasan dari Instansi tempat PKL.
                    </li>
                    <li>Mahasiswa harus melampirkan surat_tugas balasan PKL (asli) dari Instansi tempat PKL.</li>
                    <li>Pengisian materi PKL harus lengkap dan jelas.</li>
                </ul>
            </div>

        </section>

    <?php endforeach; ?>

    <script>
        window.print();
    </script>

    </body>

    </html>


<?php die();