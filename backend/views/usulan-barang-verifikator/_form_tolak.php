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

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="card">
            <div class="card-header">
                <h5>Penolakan Aktivitas Harian</h5>
            </div>
            <div class="card-body">
            <?php } ?>

            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6])->label('Alasan Penolakan') ?>

            <?php if (!Yii::$app->request->isAjax) { ?>


            <?php } ?>

            <?php if (!Yii::$app->request->isAjax) { ?>
                <div class="form-group">
                    <div class="d-flex justify-content-end">
                        <?= Html::a('Kembali', ['/verifikasi-skp'], ['class' => 'btn btn-secondary btn-block float-end me-2']); ?>
                        <?= Html::submitButton($model->isNewRecord ? 'Hapus' : 'Hapus', ['class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger']) ?>
                    </div>
                    <?php
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>