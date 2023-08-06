<?php

namespace backend\controllers;

use backend\models\BarangSearch;
use Yii;
use common\models\Barang;
use backend\models\BarangUsulanSearch;
use common\models\PengusulanBarang;
use common\models\RefKategoriBarang;
use common\models\RefStatus;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\filters\AccessControl;


/**
 * UsulanBarangVerifikatorController implements the CRUD actions for Barang model.
 */
class UsulanBarangVerifikatorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['Verifikator'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Barang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangUsulanSearch();

        $query = PengusulanBarang::find()
            ->where(['status' => 1]);
        if ($searchModel->load(Yii::$app->request->queryParams)) {

            $query->andWhere([
                'or',
                ['ilike', 'lower(nama_barang)', strtolower($searchModel->cari)],
                ['ilike', 'lower(keterangan)', strtolower($searchModel->cari)],
            ]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $refStatus = RefStatus::find()->orderBy(['id' => SORT_ASC])->all();

        return $this->render('index', [
            'data' => $data,
            'pagination' => $pagination,
            'searchModel' => $searchModel,
            'refStatus' => $refStatus,
        ]);
    }

    public function actionTerima($id)
    {
        $request = Yii::$app->request;
        $model = PengusulanBarang::findOne($id);
        $model->keterangan = NULL;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->setTahap(PengusulanBarang::TERIMA_USULAN)) {
                return [
                    'title' => "Informasi",
                    'forceReload' => '#usulan-pjax',
                    'size' => "small",
                    'content' => '
                    <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                        <img src="/img/success.png" width="100" >
                        <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil memverifikasi usulan</span>
                    </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Informasi",
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal mengirim usulan</div>',
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-danger', 'role' => 'modal-remote'])
                ];
            }
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
}
