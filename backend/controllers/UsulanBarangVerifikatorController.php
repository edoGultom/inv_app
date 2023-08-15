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
            ->where(['status' => PengusulanBarang::KIRIM_USULAN]);
        if ($searchModel->load(Yii::$app->request->queryParams)) {

            $query->andWhere([
                'or',
                ['like', 'lower(nama_barang)', strtolower($searchModel->cari)],
                ['like', 'lower(keterangan)', strtolower($searchModel->cari)],
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
    public function actionTolak($id)
    {
        $request = Yii::$app->request;
        $model = PengusulanBarang::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Penolakan Usulan",
                    'size' => "small",
                    'content' => $this->renderAjax('_form_tolak', [
                        'model' => $model
                    ]),
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                $id_verifikator  = Yii::$app->user->identity->id;
                if ($model->setTahap(PengusulanBarang::TOLAK_USULAN, $model->keterangan, $id_verifikator)) {
                    return [
                        'forceReload' => '#verifikasi-usulan-pjax',
                        'size' => 'small',
                        'title' => "Penolakan Usulan",
                        'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.gif" width="150" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil melakukan penolakan</span>
                            </div>',
                        'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                    ];
                }
                return [
                    'title' => "Penolakan Usulan",
                    'forceReload' => '#verifikasi-usulan-pjax',
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal membatalkan usulan</div>',
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Penolakan Usulan",
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal membatalkan usulan</div>',
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Simpan', ['update', 'id' => $id], ['class' => 'btn btn-danger', 'role' => 'modal-remote'])
                ];
            }
        }
    }
    public function actionTerimaBersyarat($id)
    {
        $request = Yii::$app->request;
        $model = PengusulanBarang::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Form Terima Bersyarat",
                    'size' => "small",
                    'content' => $this->renderAjax('_form_bersyarat', [
                        'model' => $model
                    ]),
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                if ($model->checkStock < 1) {
                    return [
                        'forceReload' => '#verifikasi-usulan-pjax',
                        'size' => 'small',
                        'title' => "Terima Bersyarat",
                        'content' => '
                            <div class="alert alert-danger">Jumlah tidak boleh melebihi stok</div>',
                        'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                    ];
                }
                $id_verifikator  = Yii::$app->user->identity->id;
                if ($model->setTahap(PengusulanBarang::TERIMA_BERSYARAT_VERIFIKATOR, $model->keterangan, $id_verifikator)) {
                    return [
                        'forceReload' => '#verifikasi-usulan-pjax',
                        'size' => 'small',
                        'title' => "Terima Bersyarat",
                        'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.gif" width="150" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil melakukan penolakan</span>
                            </div>',
                        'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                    ];
                }
                return [
                    'title' => "Form Terima Bersyarat",
                    'forceReload' => '#verifikasi-usulan-pjax',
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal membatalkan usulan</div>',
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Form Terima Bersyarat",
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal membatalkan usulan</div>',
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Simpan', ['update', 'id' => $id], ['class' => 'btn btn-danger', 'role' => 'modal-remote'])
                ];
            }
        } else {
            return $this->render('_form_bersyarat', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function actionTerima($id)
    {
        $request = Yii::$app->request;
        $model = PengusulanBarang::findOne($id);
        $model->keterangan = NULL;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id_verifikator  = Yii::$app->user->identity->id;

            if ($model->setTahap(PengusulanBarang::TERIMA_USULAN, NULL, $id_verifikator) && $model->saveTransaksiKeluar()) {
                return [
                    'title' => "Informasi",
                    'forceReload' => '#verifikasi-usulan-pjax',
                    'size' => "small",
                    'content' => '
                    <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                        <img src="/img/success.gif" width="150" >
                        <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil memverifikasi usulan</span>
                    </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Informasi",
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal menerima usulan</div>',
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
