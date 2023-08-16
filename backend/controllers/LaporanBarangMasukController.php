<?php

namespace backend\controllers;

use common\models\DetailTransaksiMasuk;
use common\models\TransaksiMasuk;
use Yii;
use kartik\mpdf\Pdf;

class LaporanBarangMasukController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $filter = new TransaksiMasuk();
        $model = DetailTransaksiMasuk::find()
            ->innerJoinWith('transaksiMasuk')
            ->InnerJoin("`user`", 'transaksi_masuk.id_user = user.id');

        $chooseTanggal = null;
        if ($dataPost = Yii::$app->request->get()) {
            $data = $dataPost['TransaksiMasuk'];
            $chooseTanggal = $data['tanggal'];

            $tanggal =  $data['tanggal'];
            $tanggalStart = NULL;
            $tanggalEnd = NULL;

            if (!empty($tanggal)) {
                $expDate = explode(' s/d ', $data['tanggal']);

                $tanggalStart = (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[0], 'php:Y-m-d') : NULL;
                $tanggalEnd =  (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[1], 'php:Y-m-d') : NULL;
                $model->where(['between', 'tanggal', $tanggalStart, $tanggalEnd]);
            }

            $filter->tanggal = $chooseTanggal;
        }
        // echo "<pre>";
        // print_r($chooseUnit);
        // print_r($chooseTanggal);
        // echo "</pre>";
        // exit();
        $count = $model->sum('jumlah');
        $modelBarangMasuk = $model->orderBy(['tanggal' => SORT_ASC])->all();

        return $this->render('index', [
            'modelBarangMasuk' => $modelBarangMasuk,
            'filter' => $filter,
            'count' => $count,
            'chooseTanggal' => $chooseTanggal
        ]);
    }
    public function actionLaporanBarangMasuk($chooseTanggal = NULL)
    {

        $model = DetailTransaksiMasuk::find()
            ->innerJoinWith('transaksiMasuk')
            ->InnerJoin("`user`", 'transaksi_masuk.id_user = user.id');

        if (isset($chooseTanggal)) {
            // echo "<pre>";
            // print_r($chooseTanggal);
            // echo "</pre>";
            // exit();
            $expDate = explode(' s/d ', $chooseTanggal);
            $tanggalStart = (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[0], 'php:Y-m-d') : NULL;
            $tanggalEnd =  (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[1], 'php:Y-m-d') : NULL;
            $model->where(['between', 'tanggal', $tanggalStart, $tanggalEnd]);
        }
        // echo "<pre>";
        // print_r($chooseUnit);
        // print_r($chooseTanggal);
        // echo "</pre>";
        // exit();
        $count = $model->sum('jumlah');
        $modelBarangMasuk = $model->orderBy(['tanggal' => SORT_ASC])->all();


        $content = $this->renderPartial('cetak', [
            'modelBarangMasuk' => $modelBarangMasuk,
            'count' => $count,
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
