<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use kartik\form\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="wd-100p">
    <h3 class="tx-color-01 mg-b-5">Log In</h3>
    <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-group', 'placeholder' => 'Enter your username']) ?>

    <?= $form->field($model, 'password')->passwordInput(['class' => 'form-group', 'placeholder' => 'Enter your username']) ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-brand-02 w-100', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>