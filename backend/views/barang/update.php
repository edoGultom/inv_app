<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Barang */
?>
<div class="barang-update">

    <?= ($isUpdateStock=='yes') ?  $this->render('_form_stock', [
        'model' => $model,
    ]) :
        $this->render('_form', [
            'model' => $model,
        ])
    ?>

</div>