<?php

namespace backend\controllers;

use common\models\DetailTransaksiMasuk;
use kartik\mpdf\Pdf;

class LaporanBarangMasukController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $modelBarangMasuk = DetailTransaksiMasuk::find()->all();
        return $this->render('index', [
            'modelBarangMasuk' => $modelBarangMasuk
        ]);
    }
    public function actionCetak()
    {
        $modelBarangMasuk =  DetailTransaksiMasuk::find()->all();

        $content = $this->renderPartial('cetak', [
            'modelBarangMasuk' => $modelBarangMasuk,
        ]);

        $cssInline = "
        .font-tabel tr th, .font-tabel td {font-size: 16px;}
        .tr-center th {text-align: center;}
        tfoot td {font-size: 11px;}
        .tborder {border-collapse: collapse; border: 1px solid black;}
        .tborder th, .tborder td{border: 1px solid black;}
        ";

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // 'cssFile' => '@jasa/web/css/main.css',
            // any css to be embedded if required
            'cssInline' => $cssInline,
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
}
