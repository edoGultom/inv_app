<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pengguna */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pengguna-form">

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= "<h6> Hak Akses </h6>" ?>
    <?= $form->field($model, 'role[]')->checkboxList($role, [
        'item' => function ($index, $label, $name, $checked, $value) {
            if ($label == 'Site') {
                $label = 'Pengaturan Profil';
            }
            $checked = ($index === 0 || $index === 1) ? "checked" : null;
            return "<label  style='font-weight: normal;'><input type='checkbox' {$checked} name='{$name}' value='{$value}'> {$label}</label><br />";
        }
    ]); ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>