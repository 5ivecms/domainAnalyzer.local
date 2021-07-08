<?php



/* @var $this yii\web\View */
/* @var $model common\models\MegaindexAccount */

use kartik\detail\DetailView;

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Аккаунты Megaindex', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

echo $this->render('_detailview', [
    'model' => $model,
    'mode' => DetailView::MODE_VIEW
]);