<?php

use common\models\PeminjamanBarang;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$icon = '<i class="fas fa-solid fa-sort text-secondary"></i>';
$div = '<div class="d-flex justify-content-between align-items-center">';

return [
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
            <p style="margin-top:-10px">' . ($model->peminjaman->barang->refKategori->label ?? '-') . '</p>
            <p class="text-muted">Nama Barang</p>
            <p style="margin-top:-10px">' . ($model->peminjaman->barang->nama_barang ?? '-') . '</p>';
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
            $jumlah = $model->peminjaman->jumlah . ' ';
            $jumlah .= ucwords($model->peminjaman->satuan->satuan) ?? '';

            $qty =  '<p class="text-muted">Qty</p>
            <p style="margin-top:-10px">' . $jumlah . '</p>';

            $tglPinjam =  '<p class="text-muted">Tanggal Pinjam</p>
            <p style="margin-top:-10px">' . Yii::$app->formatter->asDate($model->peminjaman->tanggal_pinjam, 'php:d/m/Y') . '</p>';

            $tglKembali =  '<p class="text-muted">Tanggal Kembali</p>
            <p style="margin-top:-10px">' . $model->peminjaman->infoPengembalian . '</p>';
            return $qty . $tglPinjam . $tglKembali;
        }
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'label' => 'jumlah_denda<i class="icofont icofont-sort-alt"></i>',
    // 'attribute'=>'jumlah_denda',
    // 'vAlign' => 'middle',
    // 'encodeLabel' => false,
    // ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Aksi',
        'template' => '<div class="d-flex align-items-center justify-content-center  flex-row">{verifikasi}</div>',
        'width' => '5%',
        'vAlign' => 'middle',
        'buttons' => [
            "verifikasi" => function ($url, $model, $key) {
                if ($model->peminjaman->status == PeminjamanBarang::TERIMA_PENGEMBALIAN_VERIFIKATOR) {
                    return Html::a(
                        'Selesai',
                        ['terima', 'id' => $model->id],
                        [
                            'role' => 'modal-remote',
                            'title' => 'Terima',
                            'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Konfirmasi',
                            'data-confirm-ok' => 'Terima',
                            'data-confirm-cancel' => 'Tutup',
                            'class' => 'btn btn-info',
                            'data-confirm-message' => 'Apakah Anda Yakin Ingin Menerima Data ini ???',
                        ]
                    );
                }
                return Html::a(
                    '<i class="fa-2x fa-solid fa-square-check wd-12 ht-12 stroke-wd-3 tx-success"></i>',
                    ['terima', 'id' => $model->id],
                    [
                        'role' => 'modal-remote',
                        'title' => 'Terima',
                        'data-confirm' => false, 'data-method' => false, // for overide yii data api
                        'data-request-method' => 'post',
                        'data-toggle' => 'tooltip',
                        'data-confirm-title' => 'Konfirmasi',
                        'data-confirm-ok' => 'Terima',
                        'data-confirm-cancel' => 'Tutup',
                        'class' => 'btn',
                        'data-confirm-message' => 'Apakah Anda Yakin Ingin Menerima Data ini ???',
                    ]
                ) . Html::a(
                    '<i class="fa-2x fa-solid fa-square-xmark wd-12 ht-12 stroke-wd-3 text-danger"></i>',
                    ['tolak', 'id' => $model->id_peminjaman_barang],
                    [
                        'role' => 'modal-remote',
                        'title' => 'Tolak',
                        'class' => 'btn',
                    ]
                );
            },
        ]
    ],

];
