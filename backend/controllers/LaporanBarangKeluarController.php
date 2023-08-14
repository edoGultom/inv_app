<?php

namespace backend\controllers;

use common\models\DetailTransaksiKeluar;

class LaporanBarangKeluarController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $modelBarangKeluar = DetailTransaksiKeluar::find()->all();
        return $this->render('index', [
            'modelBarangKeluar' => $modelBarangKeluar
        ]);
    }
}
