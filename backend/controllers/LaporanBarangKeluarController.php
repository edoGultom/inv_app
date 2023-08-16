<?php

namespace backend\controllers;

use common\models\DetailTransaksiKeluar;
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
            ->leftJoin("pengusulan_barang", 'pengusulan_barang.id = transaksi_keluar.id_pengusulan')
            ->leftJoin("peminjaman_barang", 'transaksi_keluar.id_peminjaman = peminjaman_barang.id')
            ->InnerJoin("`user`", 'pengusulan_barang.id_user = user.id or peminjaman_barang.id_user = user.id');

        $chooseUnit = '';
        $chooseTanggal = null;
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
                $model->where(['between', 'transaksi_keluar.tanggal', $tanggalStart, $tanggalEnd]);
            }

            $model->andWhere(['like', "user.cepat_kode_unit", $unit]);
            $filter->unit = $chooseUnit;
            $filter->tanggal = $chooseTanggal;
        }

        // echo "<pre>";
        // print_r($chooseUnit);
        // print_r($chooseTanggal);
        // echo "</pre>";
        // exit();
        $count = $model->sum('detail_transaksi_keluar.jumlah');
        $modelBarangKeluar = $model->orderBy(['transaksi_keluar.tanggal' => SORT_ASC])->all();

        return $this->render('index', [
            'modelBarangKeluar' => $modelBarangKeluar,
            'filter' => $filter,
            'count' => $count,
            'chooseTanggal' => $chooseTanggal,
            'chooseUnit' => $chooseUnit
        ]);
    }
    public function actionLaporanBarangKeluar($chooseTanggal = NULL, $chooseUnit = NULL)
    {

        $model = DetailTransaksiKeluar::find()
            ->innerJoinWith('transaksiKeluar')
            ->leftJoin("pengusulan_barang", 'pengusulan_barang.id = transaksi_keluar.id_pengusulan')
            ->leftJoin("peminjaman_barang", 'transaksi_keluar.id_peminjaman = peminjaman_barang.id')
            ->InnerJoin("`user`", 'pengusulan_barang.id_user = user.id or peminjaman_barang.id_user = user.id');


        if (!empty($chooseTanggal)) {
            $expDate = explode(' s/d ', $chooseTanggal);
            $tanggalStart = (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[0], 'php:Y-m-d') : NULL;
            $tanggalEnd =  (!empty($expDate)) ? Yii::$app->formatter->asDate($expDate[1], 'php:Y-m-d') : NULL;
            $model->where(['between', 'transaksi_keluar.tanggal', $tanggalStart, $tanggalEnd]);
        }
        if (!empty($chooseUnit)) {
            $unit =  Yii::$app->helper->getTrimCepatKodeV2($chooseUnit);
            $model->andWhere(['like', "user.cepat_kode_unit", $unit]);
        }

        $count = $model->sum('detail_transaksi_keluar.jumlah');
        $modelBarangKeluar = $model->orderBy(['transaksi_keluar.tanggal' => SORT_ASC])->all();

        $content = $this->renderPartial('cetak', [
            'modelBarangKeluar' => $modelBarangKeluar,
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
