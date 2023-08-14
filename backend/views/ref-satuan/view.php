<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RefSatuan */
?>
<div class="ref-satuan-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                      'id',
          'satuan',
        ],
    ]) ?>

</div>