<?php

namespace backend\controllers;

use backend\models\BarangSearch;
use Yii;
use common\models\Barang;
use backend\models\AsetPengembalianSearch;
use backend\models\AsetUsulanSearch;
use common\models\PeminjamanBarang;
use common\models\PengembalianBarang;
use common\models\RefKategoriBarang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\filters\AccessControl;


/**
 * AsetPengembalianController implements the CRUD actions for Barang model.
 */
class AsetPengembalianController extends Controller
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
        $searchModel = new AsetUsulanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->innerJoinWith('barang')
            ->andFilterWhere(['id_user' =>  Yii::$app->user->identity->id])
            ->andFilterWhere(['id_kategori' => 2])
            ->andFilterWhere(['status' =>  PeminjamanBarang::TERIMA_USULAN]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionFormPengembalian($id_peminjaman, $jumlah, $tanggal_pinjam, $tanggal_kembali)
    {
        $request = Yii::$app->request;
        $pengembalianModel = new PengembalianBarang();
        $pengembalianModel->id_peminjaman_barang = $id_peminjaman;
        $pengembalianModel->jumlah = $jumlah;
        $pengembalianModel->tanggal_pinjam = $tanggal_pinjam;
        $pengembalianModel->tanggal_kembali = $tanggal_kembali;
        $pengembalianModel->terlambat =  Yii::$app->helper->calculate2Date($tanggal_kembali, date('Y-m-d'));

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = PeminjamanBarang::findOne(['id' => $id_peminjaman]);
            if ($pengembalianModel->save() && $model->setTahap(PeminjamanBarang::KIRIM_USULAN_PENGEMBALIAN)) {
                return [
                    'title' => "Informasi",
                    'forceReload' => '#crud-datatable-usulan-pjax',
                    'size' => "small",
                    'content' => '
                    <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                        <img src="/img/success.gif" width="150" >
                        <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil mengirim usulan pengembalian</span>
                    </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Informasi",
                    'size' => "small",
                    'content' => '<div class="alert alert-danger">Gagal mengirim usulan</div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            }
        }
    }

    public function actionSendall()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        Yii::$app->response->format = Response::FORMAT_JSON;
        foreach ($pks as $pk) {
            $model = PeminjamanBarang::findOne(['id' => $pk, 'status' => NULL]);
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
                $model->setTahap(PeminjamanBarang::KIRIM_USULAN);
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
        $model = PeminjamanBarang::find()->where(['id' => $id])->one();
        $model->tanggal = date('Y-m-d');
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->setTahap(PeminjamanBarang::KIRIM_USULAN)) {
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
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            }
        }
    }
    public function actionTerima($id)
    {
        $request = Yii::$app->request;
        $model = PeminjamanBarang::find()->where(['id' => $id])->one();
        $model->tanggal = date('Y-m-d');
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->setTahap(PeminjamanBarang::TERIMA_BERSYARAT_ASN)) {
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

        $model = new PeminjamanBarang();
        $model->id_barang = $id;
        $model->cepat_kode_unit = Yii::$app->user->identity->cepat_kode_unit;
        $model->nama_barang = $barang->nama_barang;
        $model->save(false);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
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
        if (($model = PeminjamanBarang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
