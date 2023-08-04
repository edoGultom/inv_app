<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Barang";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$this->registerJs("$('.modal-dialog').addClass('modal-dialog-centered')");
?>

<div class="barang-index">
    <?= GridView::widget(
        [
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => null,
            'pjax' => true,
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
            'panelHeadingTemplate' => '{title}',
            'panel' => [
                'type' => '',
                'heading' => '<div class="d-flex justify-content-between align-items-center">
                                    <h5 class="m-0 text-dark title-index" style="text-transform:uppercase">Barang</h5>' .
                    Html::a(
                        '<div class="d-flex align-items-center"><i class="fas fa-solid fa-square-plus me-1" ></i> Tambah Barang</div>',
                        ['create'],
                        ['role' => 'modal-remote', 'title' => 'Tambah Barang', 'class' => 'btn btn-danger btn-sm']
                    ) .
                    '</div>',
                'before' => false,
                'after' => false,
            ],
            'panelTemplate' => $this->render('panelTemplate', ['searchModel' => $searchModel, 'isExtraFilter' => false]),
            'panelFooterTemplate' => '<div class="d-flex justify-content-between align-items-center">{summary} {pager}</div>',
            'pager' => [
                'prevPageLabel' => 'Previous',
                'maxButtonCount' => 5,
                'nextPageLabel' => 'Next',
            ],
        ]
    )
    ?>
</div>
<?php Modal::begin([
    "options" => [
        "id" => "ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>