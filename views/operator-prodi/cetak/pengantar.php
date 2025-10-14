<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

$obj_pengantar = CPengantar::_gi()->_get(Routes::_gi()->_depth(3));
$obj_pengantar || $obj_pengantar = new MPengantar();

$obj_tempat = CTempat::_gi()->_get($obj_pengantar->getTempatId());
$obj_tempat || $obj_tempat = new MTempat();

$_tanggal_surat = $obj_pengantar->getPengantarData('array', 'tanggal_surat');

$_sign = Helpers::_arr($obj_pengantar->getPengantarTtd('array', CPengaturan::_gi()->_get('dekan_nip')), 'foto');

$__sheets = array(
    array(
        $obj_pengantar->getMahasiswaNim(), $obj_pengantar->getMahasiswaNama()
    )
);

?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <title>Pengantar PKL</title>
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
                font-size: 16px;
                padding-left: 48px;
                padding-right: 24px;
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
                    <p class="subtitle"><strong>FAKULTAS TEKNIK</strong></p>
                    <p class="address">Jln. Majapahit No. 62 Mataram 83125 Telp (0370) 636126, Fax (0370) 636523</p>
                    <p class="url">Laman: <u>ft.unram.ac.id</u></p>
                </td>
            </tr>
            </tbody>
        </table>

        <hr/>

        <div class="_main">

            <br/>

            <table>
                <tbody>
                <tr>
                    <td style="width: 80px">Nomor</td>
                    <td style="width: 5px">:</td>
                    <td class="_no">
                        <?php echo $obj_pengantar->getPengantarNomor(true, str_repeat('&nbsp;', 7)); ?>
                    </td>
                    <td class="_right">
                        <?php if ($_tanggal_surat)
                            echo Helpers::__(date('j F Y', strtotime($_tanggal_surat)), true); ?>
                    </td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>&mdash;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>Permohonan Praktek Kerja Lapangan (PKL)</td>
                    <td></td>
                </tr>
                </tbody>
            </table>

            <br/><br/>

            <table>
                <tbody>
                <tr>
                    <td style="width: 85px">Kepada</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Yth.</td>
                    <td>
                        <?php printf('%s %s',
                            $obj_tempat->getTempatPicJabatan(), $obj_tempat->getTempatNama()); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php echo $obj_tempat->getTempatAlamat(true); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <p class="_justify">
                            Dengan hormat, disampaikan permohonan Praktek Kerja Lapangan (PKL) untuk mahasiswa Program
                            Studi
                            Teknik Informatika Fakultas Teknik Universitas Mataram sebagai berikut :
                        </p>
                        <?php foreach ($__sheets as $__sheet) :
                            list($__nim, $__nama) = $__sheet; ?>
                            <table>
                                <tbody>
                                <tr>
                                    <td style="width: 120px">Nama</td>
                                    <td>:</td>
                                    <td><?php echo $__nama; ?></td>
                                </tr>
                                <tr>
                                    <td>NIM</td>
                                    <td>:</td>
                                    <td><?php echo $__nim; ?></td>
                                </tr>
                                <tr>
                                    <td nowrap>Jurusan/Program Studi</td>
                                    <td>:</td>
                                    <td>Teknik Informatika Fakultas Teknik Universitas Mataram</td>
                                </tr>
                                </tbody>
                            </table>
                            <br/>
                        <?php endforeach; ?>
                        <p class="_justify">
                            Besar harapan kami kiranya dapat diberikan izin kepada mahasiswa tersebut di atas, untuk
                            dapat
                            melaksanakan Praktek Kerja Lapangan (PKL) selama 2 (dua) bulan mulai
                            tanggal <?php echo Helpers::__($obj_pengantar->getPengantarTanggalMulai('j F Y'), true); ?>
                            s/d <?php echo Helpers::__($obj_pengantar->getPengantarTanggalSelesai('j F Y'), true); ?>
                            di <?php echo $obj_tempat->getTempatNama(); ?> yang Bapak/Ibu pimpin.
                        </p>
                        <p class="_justify">Demikian, atas perhatian dan kerjasamanya disampaikan terima kasih.</p>
                    </td>
                </tr>
                </tbody>
            </table>

            <br/>

            <table>
                <tbody>
                <tr>
                    <td style="width: 340px"></td>
                    <td>Dekan,</td>
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

            <div class="_note">
                <p>Tembusan disampaikan kepada :</p>
                <ul>
                    <li>Yth. Ketua Program Studi Informatika</li>
                </ul>
            </div>

        </div>

    </section>

    <script>
        window.print();
    </script>

    </body>

    </html>


<?php die();