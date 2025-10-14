<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

$obj_seminar = CSeminar::_gi()->_get(Routes::_gi()->_depth(3));
$obj_seminar || $obj_seminar = new MSeminar();

$obj_pengajuan = CPengajuan::_gi()->_get($obj_seminar->getPengajuanId());
$obj_pengajuan || $obj_pengajuan = new MPengajuan(); ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Form Penilaian Pembimbing Lapangan</title>
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/normalize.min.css">
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/paper.min.css">
        <style>
            @page {
                size: A4
            }

            table {
                width: 100%;
            }

            table._bordered {
                border-collapse: collapse;
            }

            table._bordered tr td,
            table._bordered tr th {
                border: 1px solid #333333;
                padding: 3px 5px;
                vertical-align: top;
                line-height: 24px;
            }

            table._bordered tr td._ct {
                text-align: center;
            }

            table._condense tr td,
            table._condense tr th {
                padding: 3px 5px;
                line-height: 16px;
            }

            table._stretch tr td {
                vertical-align: top;
                padding: 5px 8px;
            }

            hr {
                margin-top: 0;
                border: 2px solid #000;
            }

            ._justify {
                text-align: justify;
            }

            ._center {
                text-align: center;
            }

            ._right {
                text-align: right;
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

            ._head .url {
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
                padding-left: 48px;
                padding-right: 24px;
            }

            ._main .title {
                margin-top: 4px;
                font-size: 24px;
                line-height: 32px;
            }

            ._main .big {
                font-size: 100px;
                margin: 0;
            }

            ._note {
                font-size: 12px;
            }

            ._no {
                letter-spacing: 1px;
            }
        </style>
    </head>

    <body class="A4">

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
                    <p class="subtitle">FAKULTAS TEKNIK</p>
                    <p class="title"><strong>PROGRAM STUDI TEKNIK INFORMATIKA</strong></p>
                    <p class="address">
                        Jalan Majapahit No. 62 Mataram 83125 Telpon (0370) 631712, 636126, Fax (0370) 636523
                    </p>
                    <p class="url">Laman: <u>if.unram.ac.id</u> &nbsp;&nbsp; Surel: <u>if@unram.ac.id</u></p>
                </td>
            </tr>
            </tbody>
        </table>

        <hr/>

        <div class="_main">

            <div class="_center">
                <p>
                    <strong>LEMBAR PENILAIAN PEMBIMBING LAPANGAN</strong>
                </p>
            </div>

            <table>
                <tbody>
                <tr>
                    <td style="width: 80px">Nama</td>
                    <td style="width: 10px">:</td>
                    <td><strong><?php echo $obj_seminar->getMahasiswaNama(); ?></strong></td>
                </tr
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td><strong><?php echo $obj_seminar->getMahasiswaNim(); ?></strong></td>
                </tr>
                </tbody>
            </table>
            <br/>
            <table class="_bordered _condense">
                <thead>
                <tr>
                    <th>Aspek<br/>Penilaian</th>
                    <th>Deskripsi Aspek Penilaian</th>
                    <th>Pedoman Nilai</th>
                    <th style="width: 50px">Nilai</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach (CSeminar::$_nilai_aspek_pl as $_aspek => $_v) :
                    list($_deskripsi, $_pedoman) = $_v;
                    $__rs = count($_pedoman); ?>
                    <tr>
                        <td>
                            <?php echo $_aspek; ?>
                        </td>
                        <td>
                            <?php echo $_deskripsi; ?>
                        </td>
                        <td>
                            <table class="_condense">
                                <?php foreach ($_pedoman as $__k => $__v) : ?>
                                    <tr>
                                        <td nowrap style="border: none"><?php echo $__k; ?></td>
                                        <td nowrap style="border: none"><?php echo $__v; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3">Total Nilai [0 s/d 100]</th>
                    <td></td>
                </tr>
                </tbody>
            </table>

            <br/>
            <table>
                <tbody>
                <tr>
                    <td style="width: 50%" valign="top">
                        <p><strong>Pembimbing Lapangan</strong></p>
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan'); ?></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td><?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan_jabatan'); ?></td>
                            </tr>
                            <tr>
                                <td>NIP/NIK</td>
                                <td>:</td>
                                <td><?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan_nip'); ?></td>
                            </tr>
                            <tr>
                                <td>Tempat</td>
                                <td>:</td>
                                <td><?php echo $obj_seminar->getTempatNama(); ?></td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: center">
                        <?php echo str_repeat('.', 30) . ', ' . str_repeat('.', 20); ?> 20 .....
                        <br/><br/><br/><br/><br/>
                        <p>(<?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan'); ?>)</p>
                        <small class="text-muted">
                            <i>* disertai stempel</i>
                        </small>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    </section>

    <script>
        window.print();
    </script>

    </body>

    </html>


<?php die();