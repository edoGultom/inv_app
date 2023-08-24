<?php

namespace backend\controllers;

use backend\models\BarangSearch;
use Yii;
use common\models\Barang;
use backend\models\BarangUsulanSearch;
use common\models\PengusulanBarang;
use common\models\RefKategoriBarang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\filters\AccessControl;


/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangUsulanController extends Controller
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
                        'roles' => ['ASN'],
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
        // echo   Yii::$app->user->identity->id;die();
        $searchModel = new BarangSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $model = $dataProvider->getModels(); $query = Artikel::find()->where(['aktif' => 1])->andWhere(['=', 'kategori', ($idKategori) ? $idKategori->id : '']);

        $query = Barang::find()->where(['id_kategori' => 1]);
        if ($searchModel->load(Yii::$app->request->queryParams)) {
            $query
                ->andWhere([
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
        $refKategori = RefKategoriBarang::find()->where(['id' => 1])->all();

        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = (object) Yii::$app->request->post();
            $id = $data->editableKey;
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
            $model = PengusulanBarang::find()->where(['id' => $id])->one();
            $stok = Barang::find()->where(['id' => $model->id_barang])->one()->stok;
            $result = '';
            if (isset($data->keterangan)) {
                $model->keterangan = $data->keterangan;
                $result = $data->keterangan;
            }
            if (isset($data->jumlah)) {
                $model->jumlah = $data->jumlah;;
                $result = $data->jumlah;
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save(false)) {
                return ['output' => $result, 'message' => ''];
            } else {
                return ['output' => 'failed', 'message' => ''];
            }
        }

        return $this->render('index', [
            'data' => $data,
            'pagination' => $pagination,
            'searchModel' => $searchModel,
            'refKategori' => $refKategori,
        ]);
    }
    public function actionIndexUsulan()
    {
        $searchModel = new BarangUsulanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->innerJoinWith('barang')
            ->andFilterWhere(['id_user' =>  Yii::$app->user->identity->id])
            ->andFilterWhere(['id_kategori' => 1]);
        return [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
    }
    public function actionSendall()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        Yii::$app->response->format = Response::FORMAT_JSON;
        foreach ($pks as $pk) {
            $model = PengusulanBarang::findOne(['id' => $pk, 'status' => NULL]);
            if ($model) {
                $model->tanggal = date('Y-m-d');
                if (empty($model->jumlah)) {
                    return [
                        'title' => "Informasi",
                        'size' => "small",
                        'content' => '<div class="alert alert-danger">Maaf, Jumlah(Qty) tidak boleh kosong!</div>',
                        'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                    ];
                }
                $model->setTahap(PengusulanBarang::KIRIM_USULAN);
            }
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-usulan-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }
    /**
     * Displays a single Barang model.
     * @param integer $id
     * @return mixed
     */
    public function actionKirimUsulan($id)
    {
        $request = Yii::$app->request;
        $model = PengusulanBarang::find()->where(['id' => $id])->one();
        $model->tanggal = date('Y-m-d');
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->jumlah < 1) {
                return [
                    'title' => "Peringatan",
                    'forceReload' => '#crud-datatable-usulan-pjax',
                    'size' => "small",
                    'content' => '
                    <div class="alert alert-danger">
                       Jumlah yang dimasukkan minimal  1
                    </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else if ($model->setTahap(PengusulanBarang::KIRIM_USULAN)) {
                return [
                    'title' => "Informasi",
                    'forceReload' => '#crud-datatable-usulan-pjax',
                    'size' => "small",
                    'content' => '
                    <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                        <img src="/img/success.gif" width="150" >
                        <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil mengirim usulan</span>
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
        }
    }
    public function actionTerima($id)
    {
        $request = Yii::$app->request;
        $model = PengusulanBarang::find()->where(['id' => $id])->one();
        $model->tanggal = date('Y-m-d');
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->setTahap(PengusulanBarang::TERIMA_USULAN, NULL) && $model->saveTransaksiKeluar()) {
                return [
                    'title' => "Informasi",
                    'forceReload' => '#crud-datatable-usulan-pjax',
                    'size' => "small",
                    'content' => '
                    <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                        <img src="/img/success.gif" width="150" >
                        <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil menerima data</span>
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
        }
    }
    public function actionTambahKeUsulan($id)
    {
        $request = Yii::$app->request;
        // $barang = $this->findModel($id);
        $barang = Barang::findOne($id);

        $model = new PengusulanBarang();
        $model->id_barang = $id;
        $model->cepat_kode_unit = Yii::$app->user->identity->cepat_kode_unit;
        $model->nama_barang = $barang->nama_barang;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (PengusulanBarang::find()->where(['id_barang' => $id, 'id_user' => Yii::$app->user->identity->id])->andWhere(['or', ['<', 'status', 1], ['IS', 'status', NULL]])->exists()) {
                return [
                    'forceReload' => '#crud-datatable-usulan-pjax',
                    'size' => "small",
                    'title' => "Peringatan!",
                    'content' => '
                        <div class="alert alert-warning">
                          Barang sudah ditambahkan kedalam list, silahkan pilih barang lainnya
                        </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            }
            $model->save();
            // return [
            //     'forceReload' => '#crud-datatable-usulan-pjax',
            //     'size' => "small",
            //     'title' => "Tambah Ke Usulan",
            //     'content' => '
            //             <div class="d-flex flex-column justify-content-center align-items-center gap-4">
            //                 <img src="/img/success.gif width="150"" >
            //                 <span style="font-size:14px;font-weight:400;line-height:21px;">Barang berhasil ditambahkan</span>
            //             </div>',
            //     'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
            // ];
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-usulan-pjax'];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Barang",
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-danger', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Barang model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Barang();

        if ($request->isAjax) {
            /*
            * Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Tambah Barang",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Tambah Barang",
                    'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.gif"  width="150" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Barang berhasil ditambahkan</span>
                            </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Tambah Lagi', ['create'], ['class' => 'btn btn-danger', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Tambah Barang",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            }
        } else {
            /*
            * Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Barang model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
            * Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Ubah Barang",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Ubah Barang",
                    'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.gif"  width="150" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Barang berhasil diubah</span>
                            </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Ubah Barang",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            }
        } else {
            /*
            * Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Barang model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            * Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-usulan-pjax'];
        } else {
            /*
            * Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing Barang model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            * Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            * Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Barang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Barang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PengusulanBarang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
