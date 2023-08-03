<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use cangak\ajaxcrud\CrudAsset;
use cangak\ajaxcrud\BulkButtonWidget;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RefUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Ref Unit";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$appendBtn = '<span class="ic-search"><i data-feather="search" width="16" height="16"></i></span>';
$this->registerJs("$('.modal-dialog').addClass('modal-dialog-centered')");
?>

<div class="ref-unit-index">
    <?=GridView::widget(
            [
                'id'=> 'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => null,
                'pjax'=> true,
                'export'=> false,
                'summary'=> "Menampilkan <b>{begin}</b> - <b>{end}</b> dari <b>{totalCount}</b> hasil",
                'columns' => require(__DIR__.'/_columns.php'),
                'toolbar'=> [
                    [
                        'content' =>'{export}'
                    ],
                ],
                'striped' => false,
                'condensed' => true,
                'responsive' => true,
                'panelHeadingTemplate' => '{title}',
                'panel' => [
                    'type' => '',
                    'heading' => '<div class="d-flex justify-content-between align-items-center">
                                    <h5 class="m-0 text-dark title-index" style="text-transform:uppercase">Ref Unit</h5>' .
                                    Html::a(
                                        '<div class="d-flex align-items-center"><span class="align-middle"><i data-feather="plus-circle" class="me-1"></i></span> Tambah Ref Unit</div>',
                                        ['create'],
                                        ['role' => 'modal-remote', 'title' => 'Tambah Ref Unit', 'class' => 'btn btn-danger btn-sm']
                                    ) . 
                                 '</div>',
                    'before' => false,
                    'after' => false,
                ],
                'panelTemplate' => $this->render('panelTemplate',['searchModel'=>$searchModel, 'isExtraFilter' => false]),
                'panelFooterTemplate'=> '<div class="d-flex justify-content-between align-items-center">{summary} {pager}</div>',
                'pager' => [
                    'prevPageLabel' => 'Previous',
                    'maxButtonCount' => 5,
                    'nextPageLabel' => 'Next',
                ],
            ])
            ?>
</div>
<?php Modal::begin([
    "options" => [
        "id"=>"ajaxCrudModal",
        "tabindex" => false // important for Select2 to work properly
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>