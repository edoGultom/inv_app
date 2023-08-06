<?php

use yii\bootstrap5\Html;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;
use yii\bootstrap5\ActiveForm;

$appendBtn =  '<span class="ic-search"><i data-feather="search" width="16" height="16"></i></span>';
?>
<div class="panel {type}">
    {panelHeading}
    {panelBefore}
    <div class="px-4 pt-4">
        <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['id' => 'form-filter', 'data-pjax' => "1"]]); ?>
        <div class="row mb-3">
            <div class="col">
                <div class="row row-cols-12 field-search">
                    <div class="col">
                        <?=
                        $form->field($searchModel, 'cari')->textInput(
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Pencarian...',
                            ]
                        )
                            ->label(false)
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-auto ms-auto">
                <div class="form-group">
                    <?=
                    Html::submitButton(
                        '<span class="fas fa-search"></span> ',
                        [
                            'class' => 'btn btn-primary rounded btn-search',
                            'data-pjax' => true
                        ]
                    )
                    ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        {items}
    </div>
</div>
<div class="d-flex justify-content-between px-4 py-3 align-items-center bg-footer">
    <div class="text-muted">{summary}</div>
    <div class="px-2">{pager}</div>
</div>
</div>