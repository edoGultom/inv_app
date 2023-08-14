<?php

use kartik\date\DatePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
// use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datecontrol\DateControl;

?>

<div class="tolak-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'jumlah')->textInput(['disabled' => 'disabled'])->label('Jumlah') ?>
    <?= $form->field($model, 'tanggal_pinjam')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATE,
        'widgetOptions' => [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeButton' => false,
            'options' => [
                'placeholder' => 'dd/mm/yyyy',
                'disabled' => 'disabled',
                'class' => 'rounded'
            ],
            'pluginOptions' => [
                'autoclose' => true,
            ]
        ]
    ])->label('Tanggal Pinjam'); ?>

    <?= $form->field($model, 'tanggal_kembali')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATE,
        'widgetOptions' => [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeButton' => false,
            'options' => [
                'placeholder' => 'dd/mm/yyyy',
                'class' => 'rounded'
            ],
            'pluginOptions' => [
                'autoclose' => true,
            ]
        ]
    ])->label('Tanggal Kembali'); ?>


    <?php ActiveForm::end(); ?>
</div>
</div>
</div>