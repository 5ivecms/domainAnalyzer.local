<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MegaindexAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-12 col-md-6">
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title">Добавить</h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'login')->textInput(['maxlength' => true, 'placeholder' => 'Логин']) ?>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => 'Пароль']) ?>

            <div class="form-group m-0 text-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>