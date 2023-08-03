<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RefKategoriBarang */
?>
<div class="ref-kategori-barang-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                      'id',
          'kategori',
        ],
    ]) ?>

</div>