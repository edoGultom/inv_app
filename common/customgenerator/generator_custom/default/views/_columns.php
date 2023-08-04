<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap\Modal;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";

?>
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

<?php
$div = '$div . ';
$icon = '. $icon';
$count = 0;
foreach ($generator->getColumnNames() as $name) {
    if ($name == 'id' || $name == 'created_at' || $name == 'updated_at') {
        echo "    // [\n";
        echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
        echo "        // 'attribute'=>'" . $name . "',\n";
        echo "    // ],\n";
    } else if (++$count < 6) {
        echo "    [\n";
        echo "        'class'=>'\kartik\grid\DataColumn',\n";
        echo "        'label'=> $div '" . Inflector::camel2words(StringHelper::basename($name)) . "' $icon . '</div>',\n";
        echo "        'attribute'=>'" . $name . "',\n";
        echo "        'vAlign' => 'middle',\n";
        echo "        'encodeLabel' => false,\n";
        echo "    ],\n";
    } else {
        echo "    // [\n";
        echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
        echo "        // 'label' => '" . $name . '<i class="icofont icofont-sort-alt"></i>' . "',\n";
        echo "        // 'attribute'=>'" . $name . "',\n";
        echo "        // 'vAlign' => 'middle',\n";
        echo "        // 'encodeLabel' => false,\n";
        echo "    // ],\n";
    }
}
?>

    [
        'class' => 'kartik\grid\ActionColumn',
        'header' => '',
        // jika button aksi berjajar ke bawah
        'template' => '<div class="d-flex align-items-center justify-content-center  flex-column" style="width:100px">{edit} {delete} {view} {detail}</div>',
        'width'=>'10%',
        // jika button aksi berjajar ke samping
        // 'template' => '{edit} {delete} {view} {detail}',
        // 'width'=>'28%',
        'vAlign' => 'middle',
        'buttons' => [
            "edit" => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-edit" width="16" height="16" class="me-1 align-middle"></i>', ['update', 'id' => $model->id], [
                    'class' => 'btn btn-warning btn-block',
                    'role' => 'modal-remote',
                    'title' => 'Edit',
                    'data-toggle' => 'tooltip'
                ]);
            },
            "delete" => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-trash" width="16" height="16" class="me-1 align-middle"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-block mt-2',
                    'role' => 'modal-remote', 'title' => 'Hapus',
                    'data-confirm' => false, 'data-method' => false, // for overide yii data api
                    'data-request-method' => 'post',
                    'data-toggle' => 'tooltip',
                    'data-confirm-title' => 'Hapus <?= Inflector::camel2words(StringHelper::basename($generator->modelClass))?>',
                    'data-confirm-ok' => 'Yakin',
                    'data-confirm-cancel' => 'Kembali',
                    'data-confirm-message' => 'Apakah kamu yakin ingin menghapus <?= Inflector::camel2words(StringHelper::basename($generator->modelClass))?> ini?'
                ]);
            },
            "view" => function ($url, $model, $key) {
                return Html::a('<i class="fas fa-eye" width="16" height="16" class="me-1 align-middle"></i>', ['view', 'id' => $model->id], [
                    'class' => 'btn btn-info btn-block mt-2',
                    'role' => 'modal-remote',
                    'title' => 'Lihat',
                    'data-toggle' => 'tooltip'
                ]);
            },
            //"detail" => function ($url, $model, $key) {
                //return Html::a('<i class="fa-solid fa-ellipsis-vertical" width="16" height="16" class="me-1 align-middle"></i> Detail', ['view', 'id' => $model->id], [
                    //  'class' => 'btn btn-info btn-block mt-2',
                    //'role' => 'modal-remote',
                    //'title' => 'Lihat',
                    //'data-toggle' => 'tooltip'
                    //]);
            //},
        ]
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