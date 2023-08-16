<?php

namespace backend\controllers;

use common\models\DetailTransaksiKeluar;
use common\models\DetailTransaksiMasuk;
use common\models\TransaksiKeluar;
use kartik\mpdf\Pdf;
use Yii;

class LaporanBarangKeluarController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $filter = new TransaksiKeluar();
        $model = DetailTransaksiKeluar::find()
            ->innerJoinWith('transaksiKeluar')
            ->InnerJoin("`user`", 'transaksi_keluar.id_user = user.id');

        $chooseUnit = '';
        $chooseTanggal = null;
        $count = 0;
        if ($dataPost = Yii::$app->request->get()) {
            $data = $dataPost['TransaksiKeluar'];
            $chooseUnit = $data['unit'];
            $chooseTanggal = $data['tanggal'];
            $unit =  Yii::$app->helper->getTrimCepatKodeV2($data['unit']);
            $tanggal =  $data['tanggal'];
            $tanggalStart = NULL;
            $tanggalEnd = NULL;

            if (!empty($tanggal)) {
                $expDate = explode(' s/d ', $data['tanggal']);

                $tanggalStart = (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[0], 'php:Y-m-d') : NULL;
                $tanggalEnd =  (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[1], 'php:Y-m-d') : NULL;
                $model->where(['between', 'tanggal', $tanggalStart, $tanggalEnd]);
            }

            $model->andWhere(['like', "cepat_kode_unit", $unit]);
            $filter->unit = $chooseUnit;
            $filter->tanggal = $chooseTanggal;
            $count = $model->sum('jumlah');
        }
        // echo "<pre>";
        // print_r($chooseUnit);
        // print_r($chooseTanggal);
        // echo "</pre>";
        // exit();

        $modelBarangKeluar = $model->orderBy(['tanggal' => SORT_ASC])->all();

        return $this->render('index', [
            'modelBarangKeluar' => $modelBarangKeluar,
            'filter' => $filter,
            'count' => $count
        ]);
    }
    public function actionCetak()
    {
        $modelBarangKeluar =  DetailTransaksiKeluar::find()->all();

        $content = $this->renderPartial('cetak', [
            'modelBarangKeluar' => $modelBarangKeluar,
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
