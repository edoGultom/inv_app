<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use kartik\editable\Editable;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'No',
        'width' => '2%',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Barang<i class="icofont icofont-sort-alt"></i>',
        'width' => '25%',
        'format' => 'raw',
        'attribute' => 'id_barang',
        'value' => function ($model) {
            return '<p class="text-muted">Kategori Barang</p>
            <p style="margin-top:-10px">' . ($model->barang->refKategori->kategori ?? '-') . '</p>
            <p class="text-muted">Nama Barang</p>
            <p style="margin-top:-10px">' . ($model->barang->nama_barang ?? '-') . '</p>';
        },
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],


    [
        'class' => '\kartik\grid\EditableColumn',
        'width' => '10%',
        'format' => 'raw',
        'label' => 'Jumlah Barang (Qty)',
        'attribute' => 'jumlah',
        'refreshGrid' => true,
        'editableOptions' => function ($model, $key, $index, $column)  {
            return [
                'name' => 'jumlah',
                'asPopover' => false,
                'header' => 'jumlah_barang',
                'size' => 'sm',
                'options' => [
                    'class' => 'form-control disabled',
                    'disabled' =>$model->status > 0 ,
                    'name' => 'jumlah'
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
                    $btn = '<div class="d-flex flex-column justify-content-center align-items-left">' . Html::a(
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
                    ) . Html::a('<i class="fas fa-trash" width="16" height="16" class="me-1 align-middle"></i> Hapus List', ['delete', 'id' => $model->id], [
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
