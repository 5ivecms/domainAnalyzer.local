<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\MegaindexAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\bootstrap4\Html;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => '\kartik\grid\SerialColumn'],

        'id',
        'login',
        'password',
        'proxy_id',
        'useragent_id',

        ['class' => '\kartik\grid\ActionColumn'],
    ],
    'toolbar' => [
        [
            'content' =>
                Html::a('<i class="fas fa-plus"></i>', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => 'Добавить аккаунт'
                ]) . ' ' .
                Html::a('<i class="fas fa-redo"></i>', ['index'], [
                    'class' => 'btn btn-outline-secondary',
                    'title' => 'Обновить таблицу',
                    'data-pjax' => 1,
                ]),
            'options' => ['class' => 'btn-group mr-2']
        ],
        '{export}',
        '{toggleData}',
    ],
    'toggleDataContainer' => ['class' => 'btn-group'],
    'exportContainer' => ['class' => 'btn-group mr-2'],
    'responsive' => true,
    'panel' => [
        'heading' => '<h3 class="card-title">Список аккаунтов</h3>',
        'type' => 'default',
        'after' => false,
        'before' => ''
    ],
]);