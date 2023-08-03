<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RefUnit */
?>
<div class="ref-unit-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama_unit:ntext',
            'cepat_kode',
        ],
    ]) ?>

</div>