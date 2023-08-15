<?php

namespace backend\controllers;

use Yii;
use common\models\Barang;
use backend\models\BarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;


/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangController extends Controller
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
        $searchModel = new BarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Barang model.
     * @param integer $id
     * @return mixed
     */
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
            } else if ($model->load($request->post()) && $model->save() && $model->saveTransaksiMasukNewRecord()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Tambah Barang",
                    'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.gif " width="150" >
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
    public function actionUpdate($id, $isUpdateStock = 'no')
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
                    'title' => ($isUpdateStock == 'yes') ?  "Update Stock Barang" :  "Ubah Barang",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'isUpdateStock' => $isUpdateStock
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post())) {
                if ($isUpdateStock == 'yes') {
                    $model->saveTransaksiMasuk();
                }

                $model->save();
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => ($isUpdateStock == 'yes') ?  "Update Stock Barang" :  "Ubah Barang",
                    'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.gif " width="150" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Barang berhasil diubah</span>
                            </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => ($isUpdateStock == 'yes') ?  "Update Stock Barang" :  "Ubah Barang",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'isUpdateStock' => $isUpdateStock
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            }
        } else {
            /*
            * Process for non-ajax request
            */
            if ($model->load($request->post())) {
                if ($isUpdateStock == 'yes') {
                    $model->saveTransaksiMasuk();
                }

                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'isUpdateStock' => $isUpdateStock
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
            return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => "Hapus Barang",
                'content' => '
                        <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                            <img src="/img/success.gif" width="150" >
                            <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil Menghapus Barang</span>
                        </div>',
                'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
            ];
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
        if (($model = Barang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
