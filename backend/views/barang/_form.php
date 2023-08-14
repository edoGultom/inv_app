<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Barang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo $form->field($model, 'id_kategori')->widget(Select2::classname(), [
        'data' => $model->dataKategori,
        'pluginOptions' => [
            'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
        ],
        'options' => ['placeholder' => '-Pilih Kategori-', 'id' => 'id_kategori',],
    ])->label('Kategori');
    ?>
    <?= $form->field($model, 'nama_barang')->textarea(['rows' => 6]) ?>
    <?php
    echo $form->field($model, 'id_satuan')->widget(Select2::classname(), [
        'data' => $model->dataSatuan,
        'pluginOptions' => [
            'dropdownParent' => new yii\web\JsExpression('$("#ajaxCrudModal")'),
        ],
        'options' => ['placeholder' => '-Pilih Satuan-', 'id' => 'id_satuan',],
    ])->label('Satuan');
    ?>
    <?= $form->field($model, 'stok')->textInput(['disabled' => ($model->isUpdateStock) ? 'disabled' : false]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>