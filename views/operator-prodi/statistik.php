<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

$_lists = CDosen::_gi()->_gets(array(
    'prodi_id' => PRODI_KODE,
    'prodi_id2' => PRODI_KODE2,
    'count_as_pembimbing' => true,
    'count_as_penguji' => true,
    'order' => 'ASC',
    'order_by' => '_pembimbing_berlangsung, _pembimbing_selesai',
    'number' => -1
)); ?>

<div class="ibox float-e-margins">

    <div class="ibox-title">
        <h5>Statistik</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="ibox-content">

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Berlangsung</th>
                    <th>Selesai</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var MDosen $_item */
                foreach ($_lists as $_item): ?>
                    <tr>
                        <td><?php echo $_item->getDosenKode(); ?></td>
                        <td><?php echo $_item->getDosenNama(); ?></td>
                        <td><?php echo $_item->getPembimbingBerlangsung(); ?></td>
                        <td><?php echo $_item->getPembimbingSelesai(); ?></td>
                        <th><?php echo $_item->getPembimbing(); ?></th>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>