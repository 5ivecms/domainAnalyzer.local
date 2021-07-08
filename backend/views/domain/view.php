<?php

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Domain */

$this->title = $model->domain;
$this->params['breadcrumbs'][] = ['label' => 'Домены', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

echo $this->render('_detailview', [
    'model' => $model,
    'mode' => DetailView::MODE_VIEW
]);
