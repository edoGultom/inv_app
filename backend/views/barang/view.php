<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Barang */
?>
<div class="barang-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
                      'id',
          'id_kategori',
          'nama_barang:ntext',
          'stok',
          'keterangan:ntext',
        ],
    ]) ?>

</div>