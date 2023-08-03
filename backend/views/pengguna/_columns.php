<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

$icon = '<i class="fas fa-solid fa-sort text-secondary"></i>';
$div = '<div class="d-flex justify-content-between align-items-center">';

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'No',
        'width' => '5%',
    ],


    [
        'class' => '\kartik\grid\DataColumn',
        'label' => $div .  'Username' . $icon . '</div>',
        'width' => '20%',
        'attribute' => 'username',
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => $div .  'Email' . $icon . '</div>',
        'attribute' => 'email',
        'width' => '20%',
        'vAlign' => 'middle',
        'encodeLabel' => false,
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        'width' => '10%',
        'contentOptions' => ['style' => 'text-align: left;'],
        'template' => '{reset}',
        'buttons' => [
            "reset" => function ($url, $model, $key) {
                return 
                // Html::a('Reset Password', ['pengguna/reset-password', 'id' => $model->id], ['class' => 'btn btn-info btn-block', 'data-pjax' => "0", 'role' => 'modal-remote', 'title' => 'Reset', 'data-toggle' => 'tooltip']) .
                    Html::a('Hak Akses', ['pengguna/hakakses', 'id' => $model->id], ['class' => 'mt-2 btn btn-info btn-block', 'data-pjax' => "0", 'role' => 'modal-remote', 'title' => 'Hak Akses', 'data-toggle' => 'tooltip']);
            },

        ],
        'vAlign' => 'middle',

    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '10%',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'template' => '{delete} {update}',

        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => [
            'role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'
        ],
    ],

    //[
    //'class' => 'kartik\grid\ActionColumn',
    //'dropdown' => false,
    //'vAlign' => 'middle',
    //'urlCreator' => function ($action, $model, $key, $index) {
    //return Url::to([$action, 'id' => $key]);
    //},
    //'viewOptions' => ['role' => 'modal-remote', 'title' => 'Lihat', 'data-toggle' => 'tooltip'],
    //'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
    //'deleteOptions' => [
    //'role' => 'modal-remote', 'title' => 'Hapus',
    //'data-confirm' => false, 'data-method' => false, // for overide yii data api
    //'data-request-method' => 'post',
    //'data-toggle' => 'tooltip',
    //'data-confirm-title' => 'Anda Yakin?',
    //'data-confirm-message' => 'Apakah Anda yakin akan menghapus data ini?'
    //],
    //],
];