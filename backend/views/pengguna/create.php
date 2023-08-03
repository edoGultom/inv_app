<?php

use yii\bootstrap5\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

?>
<div class="user-create">
    <?= $this->render('_form', [
        'role' => $role,
        'model' => $model,
    ]) ?>
</div>