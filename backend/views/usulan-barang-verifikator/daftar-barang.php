<?php

use yii\bootstrap5\Html;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\widgets\LinkPager;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

?>
<?php Pjax::begin(['id' => 'verifikasi-usulan-pjax']) ?>

<div class="col-lg-12 col-xl-12 mg-t-10">
    <div class="card mg-b-10">
        <div class="card-header pd-t-20 d-sm-flex align-items-center justify-content-between bd-b-0 pd-b-0">
            <div class="p-0">
                <h6 class="mg-b-5">List usulan</h6>
                <p class="tx-13 tx-color-03 mg-b-0">Silahkan verifikasi usulan </p>
            </div>
            <div class="flex-grow-1">
                <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['id' => 'form-filter', 'data-pjax' => "1"]]); ?>
                <div class="d-flex align-items-center justify-content-end gap-2  ">

                    <div class="inp-search">
                        <?=
                        $form->field($searchModel, 'cari')->textInput(
                            [
                                'class' => 'form-control',
                                'style' => 'width:400px',
                                'placeholder' => 'Masukkan pencarian Anda',
                            ]
                        )
                            ->label(false)
                        ?>
                    </div>

                    <div>
                        <?=
                        Html::submitButton(
                            '<span class="fas fa-search"></span> Search',
                            [
                                'class' => 'btn btn-primary rounded',
                                'data-pjax' => true
                            ]
                        )
                        ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div><!-- card-header -->
        <div class="card-body pd-y-30">
            <div class="d-sm-flex gap-3 flex-wrap">
                <?php
                foreach ($refStatus as $key => $value) {
                    $bgColor = $value->getBgColor($value->id);
                    $icLabel = $value->getIcLabel($value->id);
                ?>
                    <div class="media align-items-center">
                        <div class="wd-40 wd-md-50 ht-40 ht-md-50  <?= $bgColor ?> tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                            <i class="<?= $icLabel ?> "></i>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">
                                <?= $value->keterangan ?></h6>

                            <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">
                                <?= $value->jlhStatusBarang ?> </h4>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div><!-- card-body -->
        <div class="mx-3">
            <?php
            if (empty($data)) {
                echo '<div class="col bg-secondary-light text-center m-2 tx-secondary p-3 rounded" style="background-color:var(--secondary-light);">Data Tidak Ditemukan </div>';
            } else {
            ?>
                <table class="table table-dashboard mg-b-0">
                    <thead>
                        <tr>
                            <th class="tx-color-03">DATE</th>
                            <th class="text-right tx-color-03">NAMA</th>
                            <th class="text-right tx-color-03">KATEGORI</th>
                            <th class="text-right tx-color-03">BARANG</th>
                            <th class="text-right tx-color-03">KETERANGAN</th>
                            <th style="text-align:center" class="text-right tx-color-03">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        foreach ($data as $key => $value) {
                            $labelPermintaan = ($value->checkStock < 1) ?  'text-danger' : 'tx-teal';
                            $text = ($value->checkStock < 1) ? '<span class="mg-l-5 tx-10 tx-normal tx-danger d-inline-flex align-items-center"><ion-icon name="arrow-up-outline" class="mg-b-3"></ion-icon>Melebihi Stok</span>' : '';
                            $jlh = '<span class="' . $labelPermintaan . '">' . $value->jumlah . $text . '</span>';
                            $unit = $value->user->unit->nama_unit ?? '';
                        ?>
                            <tr>
                                <td class="tx-color-03 tx-normal"><?= Yii::$app->formatter->asDate($value->tanggal, 'php:d/m/yy')  ?></td>
                                <td class="tx-color-03 tx-normal"><?= $value->user->nama . '<p>' . $unit . '</p>' ?? '-' ?></td>
                                <td class="tx-normal text-right"><?= $value->barang->refKategori->label ?? '-' ?></td>
                                <td class="tx-medium text-right"><?= $value->nama_barang ?></td>
                                <td class="tx-medium text-right">
                                    <div>Stok : <span class="tx-teal"><?= $value->barang->stok ?> </span></div>
                                    <div>Jumlah Permintaan (<small>Qty</small>) : <?= $jlh ?></div>
                                </td>
                                <td align="center ">
                                    <div class="d-flex flex-wrap">
                                        <?php
                                        $btn = '';
                                        if ($value->checkStock > 1) {
                                            $btn .= Html::a(
                                                '<i class="fa-2x fa-solid fa-square-check wd-12 ht-12 stroke-wd-3 tx-success"></i>',
                                                ['terima', 'id' => $value->id],
                                                [
                                                    'role' => 'modal-remote',
                                                    'title' => 'Terima',
                                                    'data-confirm' => false, 'data-method' => false, // for overide yii data api
                                                    'data-request-method' => 'post',
                                                    'data-toggle' => 'tooltip',
                                                    'data-confirm-title' => 'Konfirmasi',
                                                    'data-confirm-ok' => 'Terima',
                                                    'data-confirm-cancel' => 'Tutup',
                                                    'class' => 'btn m-1',
                                                    'data-confirm-message' => 'Apakah Anda Yakin Ingin Menerima Data ini ???',
                                                ]
                                            );
                                        }
                                        $btn .= Html::a(
                                            '<i class="fa-2x fa-solid fa-check-to-slot wd-12 ht-12 stroke-wd-3 tx-warning"></i>',
                                            ['terima-bersyarat', 'id' => $value->id],
                                            [
                                                'role' => 'modal-remote',
                                                'title' => 'Terima Bersyarat',
                                                'class' => 'btn m-1',
                                            ]
                                        ) . Html::a(
                                            '<i class="fa-2x fa-solid fa-square-xmark wd-12 ht-12 stroke-wd-3 text-danger"></i>',
                                            ['tolak', 'id' => $value->id],
                                            [
                                                'role' => 'modal-remote',
                                                'title' => 'Tolak',
                                                'class' => 'btn m-1',
                                            ]
                                        );
                                        ?>
                                        <?= $btn ?>
                                    </div>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
            ?>

            <!-- <div class="styled-pagination"> -->
            <div class="d-flex justify-content-end align-items-end">
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => [
                        'class' => 'pagination pagination-circle p-2'
                    ],
                    'pageCssClass' => 'page-item',
                    'linkOptions' => [
                        'class' => 'page-link  tx-10'
                    ],
                    'disabledPageCssClass' => 'disabled',
                    'prevPageLabel' => '<i class="fas fa-angles-left"></i>',
                    'nextPageLabel' => '<i class="fas fa-angles-right"></i>',
                    'prevPageCssClass' => '',
                    'disabledListItemSubTagOptions' => [
                        'class' => 'page-link page-link-icon"'
                    ]
                    // 'firstPageLabel' => true
                ]);
                ?>
            </div>
            <!-- </div> -->
        </div><!-- table-responsive -->
    </div><!-- card -->

</div><!-- col -->
<?php Pjax::end() ?>