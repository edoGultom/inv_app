<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;

$appendBtn =  '<span class="ic-search"><i class="fas fa-search" width="16" height="16"></i></span>';
?>
<div class="panel {type}">
    {panelHeading}
    {panelBefore}
    <div class="px-4 pt-4">
        <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['id' => 'form-filter', 'data-pjax' => "1"]]); ?>

        <div class="filter-content">
            <div class="flex-grow-1">
                <?= $form->field($searchModel, 'cari', ['template' => ('{input}{error}' . $appendBtn), 'options' => ['class' => 'input-group']])
                    ->textInput([
                        'placeholder' => 'Cari...',
                        'class' => 'form-control rounded'
                    ])
                    ->label(false) ?>
            </div>
            <?php if ($isExtraFilter) { ?>
                <div class="flex-grow-1">
                    <?= $form->field($searchModel, 'tanggal')->widget(DateControl::classname(), [
                        'type' => DateControl::FORMAT_DATE,
                        'widgetOptions' => [
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'removeButton' => false,
                            'options' => [
                                'placeholder' => 'dd/mm/yyyy',
                                'class' => 'rounded'
                            ],
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ])->label(false); ?>
                </div>
            <?php } ?> <div>
                <div class=" form-group">
                    <?= Html::submitButton(
                        '<i data-feather="search" width="16" height="16" class="me-1"></i> Cari',
                        [
                            'class' => 'btn btn-primary text-white rounded btn-search',
                            'data-pjax' => true
                        ]
                    ) ?>
                </div>
            </div>
        </div>

        <div class="d-flex flex-row justify-content-start align-items-center gap-2">
            <div>
                <?= $form->field($searchModel, 'rowdata')->dropdownlist(
                    [20 => 20, 25 => 25, 100 => 100],
                    [
                        'prompt' => '10',
                        'onchange' => '$("#form-filter").submit();'

                    ],
                )->label(false) ?>
            </div>
            <span class="mb-3">Data/tampilan</span>
        </div>
        <?php ActiveForm::end(); ?>
        {items}
    </div>
</div>
<div class="d-flex justify-content-between px-4 py-3 align-items-center bg-footer">
    <div class="text-muted">{summary}</div>
    <div class="px-2">{pager}</div>
</div>