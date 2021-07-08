<?php

/* @var $settings array */

use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title = 'Настройки парсера';

?>

<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title">Список юзерагентов</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['action' => '/admin/setting/update']); ?>
                <?= Html::input('hidden', 'back_url', 'setting/parser') ?>
                <?= Html::input('hidden', 'cache_key', 'settings.parser') ?>
                <?= Html::input('hidden', 'cache_dependency', 'settings.parser') ?>

                <div class="form-group">
                    <?= $form->field($settings['parser.useragentList'], "[parser.useragentList]value")
                        ->textarea(['rows' => 5])
                        ->label($settings['parser.useragentList']['label'])
                    ?>
                    <?= $form->field($settings['parser.useragentList'], "[parser.useragentList]id")->hiddenInput()->label(false) ?>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>