<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

<div class="col-12 col-md-6">
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title">Парсер</h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['action' => '/admin/setting/update']); ?>
            <?= Html::input('hidden', 'back_url', 'setting/base') ?>
            <?= Html::input('hidden', 'cache_key', 'settings.parser') ?>
            <?= Html::input('hidden', 'cache_dependency', 'settings.parser') ?>

            <?= $form->field($settings['parser.enabled'], "[parser.enabled]value")
                ->checkbox(['label' => $settings['parser.enabled']['label']])
            ?>
            <?= $form->field($settings['parser.enabled'], "[parser.enabled]id")->hiddenInput()->label(false) ?>

            <div class="row">
                <div class="col-12 col-md-6">
                    <?= $form->field($settings['parser.tryLimit'], "[parser.tryLimit]value")
                        ->textInput(['type' => 'number'])
                        ->label($settings['parser.tryLimit']['label'])
                    ?>
                    <?= $form->field($settings['parser.tryLimit'], "[parser.tryLimit]id")->hiddenInput()->label(false) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>