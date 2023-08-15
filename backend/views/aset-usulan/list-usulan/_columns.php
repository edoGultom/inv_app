<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use kartik\editable\Editable;

return [
    //    [
    //        'class' => 'kartik\grid\CheckboxColumn',
    //        'width' => '2%',
    //     ],
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '2%',
        'checkboxOptions' => function ($model) {
            return ['value' => $model->id];
        },
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'No',
        'width' => '2%',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Barang<i class="icofont icofont-sort-alt"></i>',
        'width' => '20%',
        'format' => 'raw',
        'attribute' => 'id_barang',
        'value' => function ($model) {
            return '<p class="text-muted">Kategori Barang</p>
            <p style="margin-top:-10px">' . ($model->barang->refKategori->label ?? '-') . '</p>
            <p class="text-muted">Nama Barang</p>
            <p style="margin-top:-10px">' . ($model->barang->nama_barang ?? '-') . '</p>';
        },
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],


    [
        'class' => '\kartik\grid\EditableColumn',
        'width' => '5%',
        'format' => 'raw',
        'label' => 'Jumlah (Qty)',
        'attribute' => 'jumlah',
        'refreshGrid' => true,
        'value' => function ($model) {
            $jumlah = isset($model->jumlah) ? $model->jumlah : 0;
            return $jumlah . ' ' . ucwords($model->barang->refSatuan->satuan ?? 0);
        },
        'editableOptions' => function ($model, $key, $index, $column) {
            return [
                'name' => 'jumlah',
                'asPopover' => false,
                'header' => 'jumlah_barang',
                'size' => 'sm',
                'options' => [
                    'class' => 'form-control disabled',
                    'disabled' => $model->status > 0 && $model->status < 99,
                    'name' => 'jumlah'
                ],
            ];
        },
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'width' => '15%',
        'format' => 'raw',
        'label' => 'Tanggal Pinjam',
        'attribute' => 'tanggal_pinjam',
        'value' => function ($model) {
            return  Yii::$app->formatter->asDate($model->tanggal_pinjam, 'php:d/m/Y');
        },
        'refreshGrid' => true,
        'editableOptions' => function ($model, $key, $index, $column) {
            return [
                'name' => 'tanggal_pinjam',
                'inputType' => Editable::INPUT_WIDGET,
                'widgetClass' => '\kartik\datecontrol\DateControl',
                'asPopover' => false,
                'header' => 'tanggal_pinjam_barang',
                'size' => 'sm',
                'options' => [
                    'class' => 'form-control',
                    'disabled' => $model->status > 0,
                    'name' => 'tanggal_pinjam'
                ],
            ];
        },
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'width' => '15%',
        'format' => 'raw',
        'label' => 'Tanggal Kembali',
        'attribute' => 'tanggal_kembali',
        'value' => function ($model) {
            return  Yii::$app->formatter->asDate($model->tanggal_kembali, 'php:d/m/Y');
        },
        'refreshGrid' => true,
        'editableOptions' => function ($model, $key, $index, $column) {
            return [
                'name' => 'tanggal_kembali',
                'inputType' => Editable::INPUT_WIDGET,
                'widgetClass' => '\kartik\datecontrol\DateControl',
                'asPopover' => false,
                'asPopover' => false,
                'header' => 'tanggal_kembali_barang',
                'size' => 'sm',
                'options' => [
                    'class' => 'form-control disabled',
                    'disabled' => $model->status > 0,
                    'name' => 'tanggal_kembali'
                ],
            ];
        },
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Aksi',
        'width' => '15%',
        'contentOptions' => ['style' => 'text-align: left;'],
        'template' => '{kirim}{extra}',
        'buttons' => [
            "kirim" => function ($url, $model, $key) {
                $tanggal = '';
                $btn = '';
                $label = '';
                if ($model->status >= 1) {
                    $tanggal =  '<span class="text-muted">Tanggal :</span> 
                    <span style="margin-top:-10px">' . Yii::$app->formatter->asDate($model->tanggal, 'php:d F Y') . '</span>';
                    $label =  '<span class="text-muted mt-2">Status :</span> ' . $model->tahap;
                }
                if (empty($model->status) || $model->status == '99') {
                    $btnKirimUsulan = ($model->jumlah > 0) ? Html::a(
                        '<i class="fa-solid fa-square-arrow-up-right"></i> Kirim Usulan',
                        ['kirim-usulan', 'id' => $model->id],
                        [
                            'role' => 'modal-remote',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Apakah anda yakin?',
                            'data-confirm-message' => 'Apakah Anda Yakin Ingin Menambah Data ini ???',
                            'class' => 'my-2 btn btn-success d-block',
                        ]
                    )  : NULL;
                    $btn = '<div class="d-flex flex-column justify-content-center align-items-left">' .
                        $btnKirimUsulan . Html::a('<i class="fas fa-trash" width="16" height="16" class="me-1 align-middle"></i> Hapus List', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger d-block',
                            'role' => 'modal-remote', 'title' => 'Hapus List',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Hapus List',
                            'data-confirm-ok' => 'Yakin',
                            'data-confirm-cancel' => 'Kembali',
                            'data-confirm-message' => 'Apakah kamu yakin ingin menghapus Barang ini?'
                        ]) . '</div>';
                }
                return $tanggal . '<br/>' . $label . '<br/>' . $btn;
            },
            "extra" => function ($url, $model, $key) {
                if ($model->isVerify) {
                    return Html::a(
                        '<span class=" tx-white"><i class="fa-2x fa-solid fa-check wd-12 ht-12 stroke-wd-3"></i> Terima</span>',
                        ['terima', 'id' => $model->id],
                        [
                            'role' => 'modal-remote',
                            'title' => 'Terima Bersyarat',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Konfirmasi',
                            'data-confirm-ok' => 'Terima',
                            'data-confirm-cancel' => 'Tutup',
                            'class' => 'btn btn-success',
                            'data-confirm-message' => 'Apakah Anda Yakin Ingin Menerima Data ini ???',
                        ]
                    );
                }
            }
        ]
    ],



];
