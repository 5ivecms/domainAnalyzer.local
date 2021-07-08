<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $parserSettings array */

$this->title = 'Домены';
$this->params['breadcrumbs'][] = $this->title;


echo $this->render('_dynagrid', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);

echo $this->render('_settingsModal', [
    'settings' => $parserSettings
]);

echo $this->render('_changeDomainCategoryModal', []);