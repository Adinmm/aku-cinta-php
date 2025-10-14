<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

$obj_persetujuan = CPersetujuan::_gi()->_get(Routes::_gi()->_depth(3));
$obj_persetujuan || $obj_persetujuan = new MPersetujuan();

$__jumlah_sks = $obj_persetujuan->getPersetujuanData('array', 'jumlah_sks');
$__ipk_terakhir = $obj_persetujuan->getPersetujuanData('array', 'ipk_terakhir');
$__pkl_ke = $obj_persetujuan->getPersetujuanData('array', 'pkl_ke');
$__transkrip_nilai = $obj_persetujuan->getPersetujuanUpload('array', 'transkrip_nilai');
$__krs_terakhir = $obj_persetujuan->getPersetujuanUpload('array', 'krs_terakhir');

$__sign_dosen = Helpers::_arr($obj_persetujuan->getPersetujuanTtd('array', $obj_persetujuan->getDosenKode()), 'foto');
$__sign_mahasiswa = Helpers::_arr($obj_persetujuan->getPersetujuanTtd('array', $obj_persetujuan->getMahasiswaNim()), 'foto'); ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Persetujuan Dosen PA</title>
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/normalize.min.css">
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/paper.min.css">
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/font-awesome.css">
        <style>
            @page {
                size: A4
            }

            table {
                width: 100%;
            }

            p {
                line-height: 26px;
                font-size: 18px;
            }

            ._justify {
                text-align: justify;
            }

            ._center {
                text-align: center;
            }

            .title {
                font-size: 24px;
            }

            ._box {
                border: thin solid #000;
                padding: 0 8px;
                margin-right: 8px;
                font-size: 12px;
            }

            ._note * {
                font-size: 14px;
            }

        </style>
    </head>

    <body class="A4">

    <section class="sheet padding-10mm">

        <br/>

        <p class="title _center">PERMOHONAN PRAKTEK KERJA LAPANGAN</p>

        <br/><br/><br/>

        <p>
            Yth. Ketua Program Studi Teknik Informatika<br/>
            Fakultas Teknik Universitas Mataram<br/>
            di Mataram
        </p>

        <br/>

        <p class="_justify">
            Bersama ini kami mengajukan permohonan untuk dapat mengikuti Praktek Kerja Lapangan (PKL) <strong>Tahun
                Akademik <?php echo Helpers::_parse_tahun_akademik($obj_persetujuan->getPersetujuanTahunAkademik()); ?></strong>.
            Berikut saya lampirkan data-data yang diperlukan dan saya akan mentaati semua ketentuan yang berlaku
            berikut sanksi akademisnya.
        </p>

        <br/><br/><br/>

        <table>
            <tbody>
            <tr>
                <td style="min-width: 300px">Disetujui</td>
                <td></td>
                <td style="min-width: 300px"></td>
            </tr>
            <tr>
                <td>Dosen Wali</td>
                <td></td>
                <td>Mahasiswa,</td>
            </tr>
            <tr>
                <td valign="bottom" <?php echo !$__sign_dosen ? 'style="height: 100px;"' : ''; ?>>
                    <?php if ($__sign_dosen) : ?>
                        <img alt="ttd"
                             height="100px"
                             src="<?php echo $__sign_dosen; ?>" style="display: block"/>
                    <?php endif; ?>
                    <u><?php echo $obj_persetujuan->getDosenNama(); ?></u><br/>
                    NIP. <?php echo $obj_persetujuan->getDosenNip(); ?>
                </td>
                <td></td>
                <td valign="bottom">
                    <?php if ($__sign_mahasiswa) : ?>
                        <img alt="ttd"
                             height="100px"
                             src="<?php echo $__sign_mahasiswa; ?>" style="display: block"/>
                    <?php endif; ?>
                    <u><?php echo $obj_persetujuan->getMahasiswaNama(); ?></u><br/>
                    NIM. <?php echo $obj_persetujuan->getMahasiswaNim(); ?>
                </td>
            </tr>
            </tbody>
        </table>

        <br/><br/><br/><br/>

        <table class="_note">
            <thead>
            <tr>
                <td valign="top">
                    <p><u>Persyaratan</u> :</p>
                    <p>
                        <i class="fa fa-<?php echo $__transkrip_nilai ? 'check' : 'times'; ?>"></i>
                        &nbsp;Transkrip Nilai<br/>
                        <i class="fa fa-<?php echo $__krs_terakhir ? 'check' : 'times'; ?>"></i>
                        &nbsp;KRS terakhir<br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jumlah SKS &nbsp;&nbsp;
                        : <?php echo $__jumlah_sks; ?><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IPK Terakhir &nbsp; : <?php echo $__ipk_terakhir; ?><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PKL ke- &nbsp; : <?php echo $__pkl_ke; ?><br/>
                    </p>
                </td>
                <td valign="top">
                    <p>Catatan :</p>
                    <ul>
                        <li>Lulus <strong>95</strong> SKS dengan IPK minimal <strong>2.50</strong>, atau</li>
                        <li>Lulus <strong>90</strong> SKS dengan IPK minimal <strong>2.75</strong></li>
                    </ul>
                </td>
            </tr>
            </thead>
        </table>

    </section>

    <script>
        window.print();
    </script>

    </body>

    </html>


<?php die();