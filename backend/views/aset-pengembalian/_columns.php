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
        'class' => '\kartik\grid\DataColumn',
        'width' => '5%',
        'format' => 'raw',
        'label' => 'Keterangan',
        'attribute' => 'jumlah',
        'value' => function ($model) {
            $jumlah = $model->jumlah . ' ';
            $jumlah .= ucwords($model->satuan->satuan) ?? '';

            $qty =  '<p class="text-muted">Qty</p>
            <p style="margin-top:-10px">' . $jumlah . '</p>';

            $tglPinjam =  '<p class="text-muted">Tanggal Pinjam</p>
            <p style="margin-top:-10px">' . Yii::$app->formatter->asDate($model->tanggal_pinjam, 'php:d/m/Y') . '</p>';

            $tglKembali =  '<p class="text-muted">Tanggal Kembali</p>
            <p style="margin-top:-10px">' . $model->infoPengembalian . '</p>';
            return $qty . $tglPinjam . $tglKembali;
        }
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Aksi',
        'width' => '15%',
        'contentOptions' => ['style' => 'text-align: left;'],
        'template' => '{kirim}{extra}',
        'buttons' => [
            "kirim" => function ($url, $model, $key) {
                $btn = Html::a(
                    '<i class="fa-solid fa-square-arrow-up-right"></i> Usul Pengembalian',
                    [
                        'form-pengembalian',
                        'id_peminjaman' => $model->id,
                        'jumlah' => $model->jumlah,
                        'tanggal_pinjam' => $model->tanggal_pinjam,
                        'tanggal_kembali' => $model->tanggal_kembali
                    ],
                    [
                        'role' => 'modal-remote',
                        'class' => 'my-2 btn btn-warning d-block',
                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Apakah anda yakin?',
                        'data-confirm-message' => 'Apakah Anda Yakin Ingin Mengusulkan Pengembalian Aset ???',
                    ]
                );
                return  $btn;
            },
        ]
    ],



];
