<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel pengguna\models\DaftarAksesAsnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$this->registerJs("$('.modal-dialog').addClass('modal-dialog-centered')");

?>
<div id="ajaxCrudDatatable">
    <?= GridView::widget([
        'id' => 'crud-datatable-usulan',
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        'export' => false,
        'summary' => "Menampilkan <b>{begin}</b> - <b>{end}</b> dari <b>{totalCount}</b> hasil",
        'columns' => require(__DIR__ . '/_columns.php'),
        'toolbar' => [
            [
                'content' => '{export}'
            ],
        ],
        'striped' => false,
        'condensed' => true,
        'responsive' => true,
        'panel' => [
            'type' => '',
            'heading' => '<div class="d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-dark title-index">List Barang Terpilih</h5></div>',
            'before' => false,
            // 'after' => false,
            'after'=>BulkButtonWidget::widget([
                'buttons'=>Html::a('<i class="fa-solid fa-envelopes-bulk"></i>&nbsp; Kirim Semua',
                    ["sendall"] ,
                    [
                        "class"=>"btn btn-success",
                        'role'=>'modal-remote-bulk',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-confirm-title'=>'Aapakah anda yakin?',
                        'data-confirm-message'=>'Apakah Anda yakin akan mengirim data ini?'
                    ]),
            ])
        ],
        'panelTemplate' => $this->render('panelTemplate', ['searchModel' => $searchModel]),

        'panelFooterTemplate' => '<div class="d-flex justify-content-between">{summary}{pager}</div>',
    ]) ?>
</div>

<?php Modal::begin([
    "options" => [
        "id" => "ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
    "id" => "ajaxCrudModal",
    "size" => "modal-lg",
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>