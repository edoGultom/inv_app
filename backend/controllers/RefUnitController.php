<?php

namespace backend\controllers;

use Yii;
use common\models\RefUnit;
use backend\models\RefUnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;


/**
 * RefUnitController implements the CRUD actions for RefUnit model.
 */
class RefUnitController extends Controller
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
                        //'actions' => ['index', 'view', 'update','create','delete','bulkdelete'],
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
     * Lists all RefUnit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefUnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RefUnit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "RefUnit",
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
     * Creates a new RefUnit model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new RefUnit();

        if ($request->isAjax) {
            /*
            * Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Tambah Ref Unit",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Tambah Ref Unit",
                    'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.png" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Ref Unit berhasil ditambahkan</span>
                            </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::a('Tambah Lagi', ['create'], ['class' => 'btn btn-danger', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Tambah Ref Unit",
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
     * Updates an existing RefUnit model.
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
                    'title' => "Ubah Ref Unit",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Batal', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-danger', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Ubah Ref Unit",
                    'content' => '
                            <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                                <img src="/img/success.png" >
                                <span style="font-size:14px;font-weight:400;line-height:21px;">Ref Unit berhasil diubah</span>
                            </div>',
                    'footer' => Html::button('Tutup', ['class' => 'btn btn-secondary pull-left', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Ubah Ref Unit",
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
     * Delete an existing RefUnit model.
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
                'title' => "Hapus Ref Unit",
                'content' => '
                        <div class="d-flex flex-column justify-content-center align-items-center gap-4">
                            <img src="/img/success.png" >
                            <span style="font-size:14px;font-weight:400;line-height:21px;">Berhasil Menghapus Ref Unit</span>
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
     * Delete multiple existing RefUnit model.
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
     * Finds the RefUnit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RefUnit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefUnit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
