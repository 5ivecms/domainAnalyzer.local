<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = 'Добавить домены';
$this->params['breadcrumbs'][] = ['label' => 'Домены', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title">Добавить списком</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Category::find()->asArray()->all(), 'id', 'title')); ?>
                    <?= $form->field($model, 'list')->textarea(['rows' => 10, 'placeholder' => 'Список доменов (каждый с новой строки)'])->label(false) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>