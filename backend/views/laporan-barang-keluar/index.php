<?php

use yii\bootstrap5\Html;
use yii\widgets\Pjax;
// use yii\bootstrap5\ActiveForm;
use kartik\form\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;

$this->title = "Laporan Barang Keluar";
?>
<div class="row row-xs">
    <div class="content content-fixed bd-b">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h4 class="mg-b-0"><?= $this->title ?></h4>
                    <p class="mg-b-0 tx-color-03"><?= Yii::$app->formatter->asDate(date('Y-m-d'), 'php:d F Y') ?></p>
                </div>
                <div class="flex-grow-1">
                    <?php $form = ActiveForm::begin([
                        'method' => 'get',
                        'options' => [
                            'id' => 'form-filter', 'data-pjax' => "1"
                        ]
                    ]); ?>
                    <div class="d-flex flex-row justify-content-end gap-2">
                        <div class="">
                            <?= $form->field($filter, 'unit')->dropdownlist(
                                $filter->dataUnit,
                                ['prompt' => '-Semua Bidang-']
                            )->label(false) ?>
                        </div>
                        <div class="w-25">
                            <?= $form->field($filter, 'tanggal', [
                                'addon' => ['prepend' => ['content' => '<i class="fas fa-calendar-alt"></i>']],
                                'options' => ['class' => 'drp-container', 'placeholder' => 'Select range...'],
                            ])->widget(DateRangePicker::classname(), [
                                'useWithAddon' => true,
                                'convertFormat' => true,
                                'pluginOptions' => [
                                    'locale' => [
                                        'format' => 'd-m-Y',
                                        'separator' => ' s/d ',
                                    ],
                                ]
                            ])->label(false); ?>
                        </div>
                        <div class="">
                            <?= Html::submitButton(
                                '<i class="fas fa-search"></i> Cari',
                                [
                                    'class' => 'btn btn-primary text-white rounded btn-search',
                                    'data-pjax' => true
                                ]
                            ) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div><!-- container -->
    </div><!-- content -->
    <div class="content tx-13">
        <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="row">
                <div class="col-sm-6 tx-left d-none d-md-block">
                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Provinsi Sumatera Utara</label>
                    <h1 class="tx-normal tx-color-04 mg-b-10 tx-spacing--2">BADAN KEPEGAWAIAN (BAPEG)</h1>
                </div><!-- col -->
                <div class="col-sm-6 tx-right d-md-block">
                    <?= Html::a('<i class="fas fa-print" class="mg-r-5"></i> Print', ['laporan-barang-keluar', 'chooseTanggal' => $chooseTanggal, 'chooseUnit' => $chooseUnit], [
                        'class' => 'btn btn-white',
                        'data-pjax' => 0,
                        'target' => '_blank',
                        'title' => 'Print',
                        'data-toggle' => 'tooltip'
                    ]); ?>
                </div>
            </div><!-- row -->

            <div class="table-responsive mg-t-40">
                <table class="table table-invoice bd-b">
                    <thead>
                        <tr>
                            <th class="wd-20p">Kategori</th>
                            <th class="wd-20p">Nama Pemohon</th>
                            <th class="wd-40p d-none d-sm-table-cell">Deskripsi Barang</th>
                            <th class="tx-center">Tanggal Keluar</th>
                            <th class="tx-right">QNTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($modelBarangKeluar as $key => $value) {
                            $nama = ucwords(strtolower($value->transaksiKeluar->pengusul ?? '-'));
                            $unit = ucwords(strtolower($value->transaksiKeluar->unitPengusul ?? '-'));
                            $barang = ucwords(strtolower($value->barang->nama_barang ?? '-'));
                            $total +=  $value->jumlah;
                        ?>
                            <tr>
                                <td class="tx-nowrap"><?= $value->barang->refKategori->kategori ?? '-' ?></td>
                                <td class="tx-nowrap  tx-color-03"><?= $nama . '<br/>' . $unit ?></td>
                                <td class="d-none d-sm-table-cell tx-color-03"><?= $barang ?></td>
                                <td class="tx-center"><?= Yii::$app->formatter->asDate($value->transaksiKeluar->tanggal ?? NULL, 'php:d/m/Y') ?></td>
                                <td class="tx-right"><?= $value->jumlah ?></td>
                            </tr>
                        <?php
                        }
                        ?>


                    </tbody>
                </table>
            </div>

            <div class="row justify-content-between">
                <div class="col-sm-6 col-lg-6 order-2 order-sm-0 mg-t-40 mg-sm-t-0">
                    <label class="tx-sans tx-uppercase tx-10 tx-medium tx-spacing-1 tx-color-03">Notes</label>
                    <!-- <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p> -->
                </div>
                <div class="col-sm-6 col-lg-4 order-1 order-sm-0">
                    <ul class="list-unstyled lh-7 pd-r-10">
                        <!-- <li class="d-flex justify-content-between">
                            <span>Sub-Total</span>
                            <span>$5,750.00</span>
                        </li> -->
                        <!-- <li class="d-flex justify-content-between">
                            <span>Tax (5%)</span>
                            <span>$287.50</span>
                        </li> -->
                        <!-- <li class="d-flex justify-content-between">
                            <span>Discount</span>
                            <span>-$50.00</span>
                        </li> -->
                        <li class="d-flex justify-content-between">
                            <strong>Total Barang</strong>
                            <strong><?= $total ?></strong>
                        </li>
                    </ul>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div><!-- content -->
</div>