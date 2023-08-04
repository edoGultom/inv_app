<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'No',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Barang<i class="icofont icofont-sort-alt"></i>',
        'format' => 'raw',
        'attribute' => 'id_barang',
        'value' => function ($model) {
            return '<p class="text-muted">Kategori Barang</p>
            <p style="margin-top:-10px">' . ($model->barang->refKategori->kategori ?? '-') . '</p>
            <p class="text-muted">Barang</p>
            <p style="margin-top:-10px">' . ($model->barang->nama_barang ?? '-') . '</p>';
        },
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'template' => '{detail}',
        'buttons' => [
            "detail" => function ($url, $model, $key) {
                return Html::a(
                    '<span class="material-symbols-outlined align-middle">add</span> Kirim Usulan',
                    ['tambah-data-siasn', 'id_usulan' => $model->id],
                    [
                        'role' => 'modal-remote',
                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Apakah anda yakin?',
                        'data-confirm-message' => 'Apakah Anda Yakin Ingin Menambah Data ini ???',
                        'class' => 'mx-2 btn btn-success',
                    ]
                );
            },
        ]
    ],



];
