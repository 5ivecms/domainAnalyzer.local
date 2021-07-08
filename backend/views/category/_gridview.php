<?php

use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => '\kartik\grid\SerialColumn'],

        [
            'attribute' => 'id',
            'label' => 'ID',
            'format' => 'raw',
            'width' => '38px',
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'content' => function ($model, $key) {
                return $model->id;
            },
        ],
        'title',
        'text:ntext',

        ['class' => '\kartik\grid\ActionColumn'],
    ],
    'toolbar' => [
        [
            'content' =>
                Html::a('<i class="fas fa-plus"></i>', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => 'Добавить категорию'
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
        'heading' => '<h3 class="card-title">Список категорий</h3>',
        'type' => 'default',
        'after' => false,
    ],
]);