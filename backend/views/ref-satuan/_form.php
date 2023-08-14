<?php
use yii\bootstrap5\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RefSatuan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-satuan-form">
    <?php $form = ActiveForm::begin(); ?>
          <?= $form->field($model, 'satuan')->textInput(['maxlength' => true]) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
</div>