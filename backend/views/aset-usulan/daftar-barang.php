<?php

use yii\bootstrap5\Html;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\widgets\LinkPager;
use yii\bootstrap5\ActiveForm;

?>
<div class="col-lg-12 col-xl-12 mg-t-10">
    <div class="card mg-b-10">
        <div class="card-header pd-t-20 d-sm-flex align-items-center justify-content-between bd-b-0 pd-b-0">
            <div class="p-0">
                <h6 class="mg-b-5">List barang</h6>
                <p class="tx-13 tx-color-03 mg-b-0">Silahkan temukan barang yang ingin anda usulkan</p>
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
                foreach ($refKategori as $key => $value) {
                ?>
                    <div class="media align-items-center">
                        <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-indigo-light tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                            <i class="fas fa-toolbox fa-2x tx-indigo"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">
                                <?= $value->kategori ?></h6>

                            <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">
                                <?= $value->jlhTipeKategori ?> </h4>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div><!-- card-body -->
        <div class="table-responsive mx-3">
            <?php
            if (empty($data)) {
                echo '<div class="col bg-secondary-light text-center m-2 tx-secondary p-3 rounded" style="background-color:var(--secondary-light);">Data Tidak Ditemukan </div>';
            } else {
            ?>
                <table class="table table-dashboard mg-b-0">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="15%" class="text-right">Kategori Barang</th>
                            <th width="35%" class="text-right">Nama Barang</th>
                            <th width="5%" class="text-right">Keterangan</th>
                            <th style="text-align:center" width="5%" class="text-right">Add List</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        foreach ($data as $key => $value) {
                        ?>
                            <tr>
                                <td class="tx-color-03 tx-normal"><?= $no++ ?></td>
                                <td class="tx-normal tx-color-03 text-right"><?= $value->refKategori->kategori ?? '-' ?></td>
                                <td class="tx-medium text-right"><?= $value->nama_barang ?></td>
                                <td class="tx-medium text-right"><?= $value->keterangan ?></td>
                                <td align="center">
                                    <?=
                                    Html::a('<i class="fa-2x fa-solid fa-square-plus wd-12 ht-12 stroke-wd-3 text-danger"></i>', ['tambah-ke-usulan', 'id' => $value->id], [
                                        'class' => ' mx-2',
                                        'role' => 'modal-remote', 'title' => 'Tambah',
                                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                                        'data-request-method' => 'post',
                                        'data-toggle' => 'tooltip',
                                        'data-confirm-title' => 'Tambah',
                                        'data-confirm-ok' => 'Yakin',
                                        'data-confirm-cancel' => 'Kembali',
                                        'data-confirm-message' => 'Apakah kamu yakin ingin menambah Barang ini?'
                                    ]) ?>
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