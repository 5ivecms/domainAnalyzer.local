<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;

?>

<?php Modal::begin([
    'id' => 'change-category-modal',
    'title' => 'Переместить в категорию',
    'closeButton' => ['tag' => 'button', 'label' => 'x',],
]); ?>

<?= Html::beginForm(['domain/change-category'], 'post', ['id' => 'change-category', 'enctype' => 'multipart/form-data']) ?>
    <div class="input-group mb-3">
        <?= Html::dropDownList('categoryId', '$currentUserId', ArrayHelper::map(\common\models\Category::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?>
        <div class="input-group-append">
            <?= Html::submitButton('Переместить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?= Html::endForm() ?>

<?php Modal::end(); ?>