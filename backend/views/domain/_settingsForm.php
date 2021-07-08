<?php

use kartik\switchinput\SwitchInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\Pjax;

/* @var $settings array */
?>

<?php Pjax::begin(); ?>
<?php $form = ActiveForm::begin(['id' => 'parser-settings-form', 'options' => ['data-pjax' => 1,]]); ?>

<div class="row">
    <div class="col-12 col-md-6">
        <?= $form->field($settings['parser.autoRefresh.enabled'], "[parser.autoRefresh.enabled]value")->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'size' => 'medium',
                'onColor' => 'success',
                'offColor' => 'danger',
                'onText' => 'Вкл',
                'offText' => 'Выкл',
            ]
        ])->label($settings['parser.autoRefresh.enabled']['label']); ?>
        <?= $form->field($settings['parser.autoRefresh.enabled'], "[parser.autoRefresh.enabled]id")->hiddenInput()->label(false); ?>
    </div>
    <div class="col-12 col-md-6">
        <?= $form->field($settings['parser.autoRefresh.timeout'], "[parser.autoRefresh.timeout]value")
            ->textInput(['type' => 'text'])
            ->label($settings['parser.autoRefresh.timeout']['label'])
        ?>
        <?= $form->field($settings['parser.autoRefresh.timeout'], "[parser.autoRefresh.timeout]id")->hiddenInput()->label(false) ?>
    </div>
</div>

<hr />

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>

<?php
ActiveForm::end();
Pjax::end();
?>