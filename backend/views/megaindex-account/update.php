<?php

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MegaindexAccount */

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Аккаунты Megaindex', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

echo $this->render('_detailview', [
    'model' => $model,
    'mode' => DetailView::MODE_EDIT
]);