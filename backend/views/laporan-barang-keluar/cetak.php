<?php

use yii\bootstrap5\Html;

$this->title = "Laporan Barang Keluar";
?>
<div class="row row-xs">
    <div class="content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mg-b-5"><?= $this->title ?></h4>
                    <p class="mg-b-0 tx-color-03"><?= Yii::$app->formatter->asDate(date('Y-m-d'), 'php:d F Y') ?></p>
                </div>
            </div>
        </div><!-- container -->
    </div><!-- content -->
    <div class="content tx-13">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="row">
                <div class="col-sm-12 tx-right d-none d-md-block" style="text-align: right;">
                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Provinsi Sumatera Utara</label>
                    <h2 class="tx-normal tx-color-04 mg-b-10 tx-spacing-2">BADAN KEPEGAWAIAN (BAPEG)</h2>
                </div><!-- col -->
            </div><!-- row -->

            <div class="table-responsive mg-t-40">
                <table class="table table-invoice bd-b">
                    <thead>
                        <tr>
                            <th class="wd-20p">Kategori</th>
                            <th class="wd-20p">Nama Pemohon</th>
                            <th class="wd-40p d-none d-sm-table-cell">Deskripsi Barang</th>
                            <th style="text-align:center">Tanggal Keluar</th>
                            <th style="text-align:right">QNTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($modelBarangKeluar as $key => $value) {
                            $nama = ucwords(strtolower($value->transaksiKeluar->pengusul)) ?? '-';
                            $unit = ucwords(strtolower($value->transaksiKeluar->unitPengusul)) ?? '-';
                            $barang = ucwords(strtolower($value->barang->nama_barang)) ?? '-';
                            $total +=  $value->jumlah;
                        ?>
                            <tr>
                                <td class="tx-nowrap"><?= $value->barang->refKategori->kategori ?? '-' ?></td>
                                <td class="tx-nowrap  tx-color-03"><?= $nama . '<br/>' . $unit ?></td>
                                <td class="d-none d-sm-table-cell tx-color-03"><?= $barang ?></td>
                                <td style="text-align:center"><?= Yii::$app->formatter->asDate($value->transaksiKeluar->tanggal, 'php:d/m/Y') ?></td>
                                <td style="text-align:right"><?= $value->jumlah ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3">Notes</td>
                            <td style="text-align:center"><strong>Total Barang</strong></td>
                            <td style="text-align:right"><strong><?= $total ?></strong></td>
                        </tr>


                    </tbody>
                </table>
            </div>

        </div><!-- container -->
    </div><!-- content -->
</div>