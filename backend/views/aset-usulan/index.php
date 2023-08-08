<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Permintaan Barang";
?>
<h4 class="mg-b-25"><?= $this->title ?></h4>
<?= $this->render('daftar-barang', [
    'searchModel' => $searchModel,
    'pagination' => $pagination,
    'data' => $data,
    'refKategori' => $refKategori,
]) ?>
<?php
$data =   Yii::$app->runAction('/aset-usulan/index-usulan');
echo $this->render('./list-usulan/index', [
    'searchModel' => $data['searchModel'],
    'dataProvider' => $data['dataProvider'],
]); ?>
<?php Modal::begin([
    "options" => [
        "id" => "ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>