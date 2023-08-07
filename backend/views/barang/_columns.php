<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

$icon = '<i class="fas fa-solid fa-sort text-secondary"></i>';
$div = '<div class="d-flex justify-content-between align-items-center">';

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'No',
        'width' => '30px',
    ],


    [
        'class' => '\kartik\grid\DataColumn',
        'label' => $div .  'Kategori' . $icon . '</div>',
        'attribute' => 'id_kategori',
        'vAlign' => 'middle',
        'value' => function ($model) {
            return $model->refKategori->kategori ?? '-';
        },
        'encodeLabel' => false,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => $div .  'Nama Barang' . $icon . '</div>',
        'attribute' => 'nama_barang',
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => $div .  'Stok' . $icon . '</div>',
        'attribute' => 'stok',
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => $div .  'Keterangan' . $icon . '</div>',
        'attribute' => 'keterangan',
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '<div class="d-flex flex-row align-items-center justify-content-center gap-2">{edit} {delete} {view} {detail}</div>{stok_update}',
        'contentOptions' => ['style' => 'text-align: left;'],
        'width' => '10%',
        'vAlign' => 'middle',
        'buttons' => [
            "edit" => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-edit" width="16" height="16" class="me-1 align-middle"></i>', ['update', 'id' => $model->id], [
                    'class' => 'btn btn-warning',
                    'role' => 'modal-remote',
                    'title' => 'Edit',
                    'data-toggle' => 'tooltip'
                ]);
            },
            "delete" => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-trash" width="16" height="16" class="me-1 align-middle"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'role' => 'modal-remote', 'title' => 'Hapus',
                    'data-confirm' => false, 'data-method' => false, // for overide yii data api
                    'data-request-method' => 'post',
                    'data-toggle' => 'tooltip',
                    'data-confirm-title' => 'Hapus Barang',
                    'data-confirm-ok' => 'Yakin',
                    'data-confirm-cancel' => 'Kembali',
                    'data-confirm-message' => 'Apakah kamu yakin ingin menghapus Barang ini?'
                ]);
            },
            "view" => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-eye" width="16" height="16" class="me-1 align-middle"></i>', ['view', 'id' => $model->id], [
                    'class' => 'btn btn-info',
                    'role' => 'modal-remote',
                    'title' => 'Lihat',
                    'data-toggle' => 'tooltip'
                ]);
            },
            "stok_update" => function ($url, $model, $key) {
                if ($model->isUpdateStock) { //jika barang sudah diusulkan/dipinjam maka akan muncul update/stok
                    return Html::a('<span class="fas fa-file-pen" width="16" height="16" class="me-1 align-middle"></span> <i class=" tx-16"><u>Update Stok</u></i> ', ['update', 'id' => $model->id, 'isUpdateStock' => 'yes'], [
                        'class' => 'tx-warning',
                        'role' => 'modal-remote',
                        'title' => 'Update Stok',
                        'data-toggle' => 'tooltip'
                    ]);
                }
            },
        ]
    ],

];
