<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'username',
        'auth_key',
        'password_hash',
        'password_reset_token',
        'email:email',
        'status',
        'id_unit',
        'created_at',
        'updated_at',
        'verification_token',
    ],
]) ?>