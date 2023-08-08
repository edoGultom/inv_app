<?php

use kartik\date\DatePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
// use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PermintaanDataRwjabatan */
/* @var $form yii\widgets\ActiveForm */
// on your view layout file

?>

<div class="tolak-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6])->label('Alasan Penolakan') ?>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>