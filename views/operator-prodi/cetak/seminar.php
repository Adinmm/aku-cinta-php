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
$obj_pengajuan || $obj_pengajuan = new MPengajuan();

$obj_tempat = CTempat::_gi()->_get($obj_seminar->getTempatId());
$obj_tempat || $obj_tempat = new MTempat(); ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Berita Acara</title>
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

            table._unbordered tr td,
            table._unbordered tr th {
                padding: 3px 0;
                vertical-align: top;
                line-height: 20px;
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

            <br/><br/><br/><br/>

            <div class="_center">
                <p class="title">
                    SEMINAR HASIL PKL MAHASISWA
                </p>
                <p class="big">
                    <?php echo $obj_seminar->getSeminarNomor(); ?>
                </p>
            </div>

            <br/><br/>

            <table class="_bordered">
                <tbody>
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td>
                        <strong><?php echo $obj_seminar->getMahasiswaNama(); ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>
                        <strong><?php echo $obj_seminar->getMahasiswaNim(); ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>JUDUL PKL</td>
                    <td>:</td>
                    <td><?php echo $obj_seminar->getSeminarJudul(); ?></td>
                </tr>
                <tr>
                    <td>HARI/TANGGAL</td>
                    <td>:</td>
                    <td><?php echo Helpers::_camel_case(Helpers::__(
                            $obj_seminar->getSeminarTanggal('l, j F Y')), ' '); ?></td>
                </tr>
                <tr>
                    <td>WAKTU</td>
                    <td>:</td>
                    <td><?php echo $obj_seminar->getSeminarJam(); ?> WITA</td>
                </tr>
                <tr>
                    <td>TEMPAT</td>
                    <td>:</td>
                    <td><?php echo $obj_seminar->getSeminarTempat(); ?></td>
                </tr>
                </tbody>
            </table>

        </div>

    </section>

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
                <?php
                $__nilai_pembimbing_lapangan = $obj_seminar->getSeminarNilai('array', 'pembimbing-lapangan', []);
                $__nilai_pembimbing_lapangan_aspek = Helpers::_arr($__nilai_pembimbing_lapangan, 'aspek', []);
                $__nilai_pembimbing_lapangan_total = Helpers::_arr($__nilai_pembimbing_lapangan, 'total', 0);
                foreach (CSeminar::$_nilai_aspek_pl as $_aspek => $_v) :
                    $__v_i = Helpers::_arr($__nilai_pembimbing_lapangan_aspek, $_aspek, 0);
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
                        <td class="_ct" style="vertical-align: middle"><?php echo $__v_i; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3">Total Nilai [0 s/d 100]</th>
                    <th class="_ct" style="vertical-align: middle">
                        <?php echo $__nilai_pembimbing_lapangan_total; ?>
                    </th>
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
                                <td valign="top">Nama</td>
                                <td valign="top">:</td>
                                <td><?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Jabatan</td>
                                <td valign="top">:</td>
                                <td><?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan_jabatan'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">NIP/NIK</td>
                                <td valign="top">:</td>
                                <td><?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan_nip'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Tempat</td>
                                <td valign="top">:</td>
                                <td><?php echo $obj_seminar->getTempatNama(); ?></td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: center">
                        <?php echo str_repeat('.', 30) . ', ' . str_repeat('.', 20); ?> 20 .....
                        <br/><br/><br/><br/><br/>
                        <p>(<?php echo $obj_pengajuan->getPengajuanData('array', 'pembimbing_lapangan'); ?>)</p>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    </section>

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
                    <strong>LEMBAR PENILAIAN DOSEN PEMBIMBING</strong>
                </p>
            </div>

            <table>
                <tbody>
                <tr>
                    <td style="width: 80px">Hari/Tanggal</td>
                    <td style="width: 10px">:</td>
                    <td><?php echo Helpers::_camel_case(Helpers::__(
                            $obj_seminar->getSeminarTanggal('l, j F Y')), ' '); ?></td>
                </tr
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong><?php echo $obj_seminar->getMahasiswaNama(); ?></strong></td>
                </tr
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td><strong><?php echo $obj_seminar->getMahasiswaNim(); ?></strong></td>
                </tr>
                <tr>
                    <td style="vertical-align: top">Judul PKL</td>
                    <td style="vertical-align: top">:</td>
                    <td><?php echo $obj_seminar->getSeminarJudul(); ?></td>
                </tr>
                </tbody>
            </table>
            <br/>
            <table class="_bordered">
                <thead>
                <tr>
                    <th>Aspek<br/>Penilaian</th>
                    <th>Komponen</th>
                    <th>Nilai<br/>Max</th>
                    <th style="width: 50px">Nilai</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $__nilai_dosen_pembimbing = $obj_seminar->getSeminarNilai('array', 'dosen-pembimbing', []);
                $__nilai_dosen_pembimbing_aspek = Helpers::_arr($__nilai_dosen_pembimbing, 'aspek', []);
                $__nilai_dosen_pembimbing_total = Helpers::_arr($__nilai_dosen_pembimbing, 'total', 0);
                foreach (CSeminar::$_nilai_aspek_dp as $_aspek => $_komponen) :
                    $__i = 0;
                    $__rs = count($_komponen);
                    foreach ($_komponen as $__title => $__max):
                        $__v_i = Helpers::_arr($__nilai_dosen_pembimbing_aspek, $__title, 0); ?>
                        <tr>
                            <?php if ($__i == 0) : ?>
                                <td rowspan="<?php echo $__rs; ?>" style="vertical-align: middle">
                                    <?php echo $_aspek; ?>
                                </td>
                            <?php endif; ?>
                            <td>
                                <?php echo $__title; ?>
                            </td>
                            <td class="_ct"><?php echo $__max; ?></td>
                            <td class="_ct"><strong><?php echo $__v_i; ?></strong></td>
                        </tr>
                        <?php $__i++;
                    endforeach; ?>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3">Total Nilai</th>
                    <th class="_ct">
                        <?php echo $__nilai_dosen_pembimbing_total; ?>
                    </th>
                </tr>
                </tbody>
            </table>

            <br/>
            <table>
                <tbody>
                <tr>
                    <td rowspan="2" style="width: 280px; height: 100px;" valign="top">
                        <?php printf('Nilai Akhir &nbsp;=&nbsp; %s', $__nilai_dosen_pembimbing_total); ?>
                    </td>
                    <td class="_center">
                        Mataram,
                        <?php echo Helpers::_camel_case(Helpers::__($obj_seminar->getSeminarTanggal('l j F Y')), ' '); ?>
                        <br/>
                        Dosen Pembimbing
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" class="_center">
                        <?php $_ttd_data = $obj_seminar->getSeminarTtd('array', $obj_seminar->getDosenKode());
                        if ($__sign = Helpers::_arr($_ttd_data, 'foto')) : ?>
                            <img alt="ttd"
                                 height="80px"
                                 src="<?php echo $__sign; ?>"
                                 style="display: block; margin-left: auto; margin-right: auto;"/>
                        <?php else : ?>
                            <br/><br/><br/><br/><br/>
                        <?php endif; ?>
                        <?php echo $obj_seminar->getDosenNama(); ?><br/>
                        NIP. <?php echo $obj_seminar->getDosenNip(); ?>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    </section>

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
                    <strong>
                        BERITA ACARA SEMINAR HASIL
                    </strong>
                </p>
                <p>
                    <strong>
                        PRAKTIK KERJA LAPANGAN (PKL)
                    </strong>
                </p>
            </div>

            <br/>

            <p>
                Pada hari ini
                <strong><?php echo Helpers::_camel_case(Helpers::__($obj_seminar->getSeminarTanggal('l')), ' '); ?></strong>,
                tanggal <strong><?php echo $obj_seminar->getSeminarTanggal('j'); ?></strong> bulan
                <strong><?php echo Helpers::_camel_case(Helpers::__($obj_seminar->getSeminarTanggal('F')), ' '); ?></strong>
                tahun <strong><?php echo $obj_seminar->getSeminarTanggal('Y'); ?></strong> telah dilaksanakan Seminar
                Hasil Praktik Kerja Lapangan (PKL), atas nama:
            </p>

            <table class="_unbordered">
                <tbody>
                <tr>
                    <td style="width: 120px">Nama</td>
                    <td style="width: 20px">:</td>
                    <td><?php echo $obj_seminar->getMahasiswaNama(); ?></td>
                </tr
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td><?php echo $obj_seminar->getMahasiswaNim(); ?></td>
                </tr>
                <tr>
                    <td valign="top">Judul PKL</td>
                    <td valign="top">:</td>
                    <td valign="top"><?php echo $obj_seminar->getSeminarJudul(); ?></td>
                </tr>
                <tr>
                    <td>Nilai</td>
                    <td>=</td>
                    <td>(60% x Nilai Pembimbing Lapangan) + (40% x Nilai Dosen Pembimbing)</td>
                </tr>
                <tr>
                    <td></td>
                    <td>=</td>
                    <td><?php printf('%s &nbsp;+&nbsp; %s', $__nilai_pembimbing_lapangan_total, $__nilai_dosen_pembimbing_total); ?></td>
                </tr>
                <tr>
                    <td>Hasil</td>
                    <td>=</td>
                    <td>
                        <strong>
                            <?php printf('%s &nbsp; ( %s )',
                                $obj_seminar->getSeminarNilai('array', 'total', 0),
                                $obj_seminar->getSeminarNilai('array', 'huruf')); ?>
                        </strong>
                    </td>
                </tr>
                </tbody>
            </table>

            <br/><br/>

            <table>
                <tbody>
                <tr>
                    <td style="width: 50%" valign="bottom" class="_center">Dosen Pembimbing,</td>
                    <td valign="bottom" class="_center">Mahasiswa,</td>
                </tr>
                <tr>
                    <td valign="bottom" class="_center">
                        <?php $_ttd_data = $obj_seminar->getSeminarTtd('array', $obj_seminar->getDosenKode());
                        if ($__sign = Helpers::_arr($_ttd_data, 'foto')) : ?>
                            <img alt="ttd"
                                 height="80px"
                                 src="<?php echo $__sign; ?>"
                                 style="display: block; margin-left: auto; margin-right: auto;"/>
                        <?php else : ?>
                            <br/><br/><br/><br/><br/>
                        <?php endif; ?>
                        <?php echo $obj_seminar->getDosenNama(); ?><br/>
                        NIP. <?php echo $obj_seminar->getDosenNip(); ?>
                    </td>
                    <td valign="bottom" class="_center">
                        <?php $_ttd_data = $obj_seminar->getSeminarTtd('array', $obj_seminar->getMahasiswaNim());
                        if ($__sign = Helpers::_arr($_ttd_data, 'foto')) : ?>
                            <img alt="ttd"
                                 height="80px"
                                 src="<?php echo $__sign; ?>"
                                 style="display: block; margin-left: auto; margin-right: auto;"/>
                        <?php else : ?>
                            <br/><br/><br/><br/><br/>
                        <?php endif; ?>
                        <?php echo $obj_seminar->getMahasiswaNama(); ?><br/>
                        NIM. <?php echo $obj_seminar->getMahasiswaNim(); ?>
                    </td>
                </tr>
                </tbody>
            </table>

            <br/><br/>
            <div class="_center">
                Mengetahui,<br/>
                Program Studi Teknik Informatika
                <?php $_ttd_data = $obj_seminar->getSeminarTtd('array', CPengaturan::_gi()->_get('sekprodi_nip'));
                if ($__sign = Helpers::_arr($_ttd_data, 'foto')) : ?>
                    <img alt="ttd"
                         height="80px"
                         src="<?php echo $__sign; ?>"
                         style="display: block; margin-left: auto; margin-right: auto;"/>
                <?php else : ?>
                    <br/><br/><br/><br/><br/>
                <?php endif; ?>
                <?php echo CPengaturan::_gi()->_get('sekprodi_nama'); ?><br/>
                <?php echo CPengaturan::_gi()->_get('sekprodi_nip'); ?>
            </div>

        </div>

    </section>

    <script>
        window.print();
    </script>

    </body>

    </html>


<?php die();