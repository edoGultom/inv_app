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
    <h3 class="tx-color-01 mg-b-5">Sign In</h3>
    <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>

    <div class="form-group">
        <label>Email address</label>
        <input type="email" class="form-control" placeholder="yourname@yourmail.com">
    </div>
    <div class="form-group">
        <div class="d-flex justify-content-between mg-b-5">
            <label class="mg-b-0-f">Password</label>
            <!-- <a href="" class="tx-13">Forgot password?</a> -->
        </div>
        <input type="password" class="form-control" placeholder="Enter your password">
    </div>
    <button class="btn btn-brand-02 w-100">Sign In</button>
</div>