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

$_sign = Helpers::_arr($obj_pengajuan->getPengajuanTtd('array', CPengaturan::_gi()->_get('dekan_nip')), 'foto');

$__sheets = array(
    array(
        $obj_pengajuan->getMahasiswaNim(),
        $obj_pengajuan->getMahasiswaNama(),
        $obj_pengantar->getTempatNama(),
        $obj_pengantar->getPengantarJudul(),
    )
);

?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Surat Tugas Dosen</title>
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/normalize.min.css">
        <link rel="stylesheet" href="<?php echo URI_CSS_PATH; ?>/paper.min.css">
        <style>
            @page {
                size: A4
            }

            table {
                width: 100%;
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

            ._no {
                letter-spacing: 1px;
            }

        </style>
    </head>

    <body class="A4">

    <?php foreach ($__sheets as $__sheet) :
        list($__nim, $__nama, $__tempat, $__judul) = $__sheet; ?>

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
                        <p class="url">Laman: <u>ft.unram.ac.id</u></p>
                    </td>
                </tr>
                </tbody>
            </table>

            <hr/>

            <p class="title _center" style="margin-bottom: 0">S U R A T &nbsp; T U G A S</p>
            <p class="_center" style="margin-top: 4px">
                Nomor : <?php echo $obj_pengajuan->getPengajuanNomor() ?: str_repeat('&nbsp;', 6); ?>
                <span class="_no"><?php echo $obj_pengajuan->getPengajuanNomorExt(); ?></span>
            </p>

            <br/>

            <div class="_main">

                <p>Dekan Fakultas Teknik Universitas Mataram menugaskan :</p>
                <table>
                    <tbody>
                    <tr>
                        <td style="width: 120px">Nama</td>
                        <td style="width: 10px">:</td>
                        <td><?php echo $obj_pengajuan->getDosenNama(); ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo $obj_pengajuan->getDosenNip('-'); ?></td>
                    </tr>
                    <tr>
                        <td>Unit Organisasi</td>
                        <td>:</td>
                        <td>Fakultas Teknik Universitas Mataram</td>
                    </tr>
                    <tr>
                        <td>Tugas</td>
                        <td>:</td>
                        <td>Pembimbing</td>
                    </tr>
                    </tbody>
                </table>
                <p class="_justify">
                    untuk membimbing Praktek Kerja Lapangan Mahasiswa selama 6 bulan terhitung mulai
                    tanggal <?php echo Helpers::__(date('j F Y', strtotime($obj_pengajuan->getPengajuanBimbinganTanggalMulai())), true); ?>
                    sampai dengan
                    tanggal <?php echo Helpers::__(date('j F Y', strtotime($obj_pengajuan->getPengajuanBimbinganTanggalSelesai())), true); ?>
                    .<br/>
                    Adapun nama Mahasiswa dimaksud :
                </p>
                <table>
                    <tbody>
                    <tr>
                        <td style="width: 120px">Nama</td>
                        <td style="width: 10px">:</td>
                        <td><?php echo $__nama; ?></td>
                    </tr>
                    <tr>
                        <td>NIM</td>
                        <td>:</td>
                        <td><?php echo $__nim; ?></td>
                    </tr>
                    <tr>
                        <td>Tempat PKL</td>
                        <td>:</td>
                        <td><?php echo $__tempat; ?></td>
                    </tr>
                    <tr>
                        <td valign="top">Judul PKL</td>
                        <td valign="top">:</td>
                        <td><?php echo $__judul; ?></td>
                    </tr>
                    </tbody>
                </table>
                <p class="_justify">
                    Demikian surat tugas ini dibuat untuk dapat dilaksanakan dengan sebaik-baiknya, dan setelah
                    melaksanakan tugas harap saudara menyampaikan laporan secara tertulis.
                </p>

                <br/>

                <table>
                    <tbody>
                    <tr>
                        <td style="width: 340px"></td>
                        <td>
                            Mataram, <?php echo Helpers::_camel_case(Helpers::__(date('j F Y')), ' '); ?><br/>
                            Dekan,
                        </td>
                    </tr>
                    <tr>
                        <td <?php echo !$_sign ? 'style="height: 100px;"' : ''; ?> ></td>
                        <td valign="bottom">
                            <?php if ($_sign) : ?>
                                <img alt="ttd"
                                     width="400px"
                                     src="<?php echo $_sign; ?>" style="display: block"/>
                            <?php endif; ?>
                            <?php echo CPengaturan::_gi()->_get('dekan_nama'); ?><br/>
                            NIP. <?php echo CPengaturan::_gi()->_get('dekan_nip'); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </section>

    <?php endforeach; ?>

    <script>
        // window.print();
    </script>

    </body>

    </html>


<?php die();