<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\MegaindexAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аккаунты Megaindex';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_gridview', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);
