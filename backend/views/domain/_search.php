<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DomainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="domain-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'domain') ?>

    <?= $form->field($model, 'linkpad_rank') ?>

    <?= $form->field($model, 'backlinks') ?>

    <?= $form->field($model, 'nofollow_links') ?>

    <?php // echo $form->field($model, 'no_anchor_links') ?>

    <?php // echo $form->field($model, 'count_ips') ?>

    <?php // echo $form->field($model, 'count_subnet') ?>

    <?php // echo $form->field($model, 'cost_links') ?>

    <?php // echo $form->field($model, 'isChecked') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
