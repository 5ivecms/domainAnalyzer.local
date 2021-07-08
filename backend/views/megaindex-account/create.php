<?php

/* @var $this yii\web\View */
/* @var $model common\models\MegaindexAccount */

$this->title = 'Добавить Аккаунт';
$this->params['breadcrumbs'][] = ['label' => 'Аккаунты Megaindex', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="megaindex-account-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
