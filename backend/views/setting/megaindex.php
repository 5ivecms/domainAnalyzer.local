<?php

/* @var $this yii\web\View */
/* @var $settings array */


use kartik\form\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Настройки Megaindex';

?>


<div class="row">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title">Прокси</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['action' => '/admin/setting/update']); ?>
                <?= Html::input('hidden', 'back_url', 'setting/megaindex') ?>
                <?= Html::input('hidden', 'cache_key', 'settings.megaindex') ?>
                <?= Html::input('hidden', 'cache_dependency', 'settings.megaindex') ?>

                <div class="form-group">
                    <?= $form->field($settings['megaindex.proxy.enabled'], "[megaindex.proxy.enabled]value")
                        ->checkbox(['label' => $settings['megaindex.proxy.enabled']['label']])
                    ?>
                    <?= $form->field($settings['megaindex.proxy.enabled'], "[megaindex.proxy.enabled]id")->hiddenInput()->label(false) ?>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
