<?php

use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $searchModel common\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Pjax::begin(['id' => 'notes', 'timeout' => 0]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($model, $key, $index) {
        $class = $model->is_available ? 'table-success' : 'table-danger';
        return [
            'key' => $key,
            'index' => $index,
            'class' => $class
        ];
    },
    'columns' => [
        [
            'class' => '\kartik\grid\CheckboxColumn',
            'rowSelectedClass' => GridView::BS_TABLE_INFO,
            'checkboxOptions' => function ($model) {
                return ['value' => $model->id];
            },
        ],
        'domain',
        [
            'attribute' => 'category_id',
            'label' => 'Категория',
            'value' => function ($model) {
                return $model->category->title;
            },
            'filter' => ArrayHelper::map(\common\models\Category::find()->asArray()->all(), 'id', 'title'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ]
        ],
        [
            'attribute' => 'yandex_zen',
            'vAlign' => 'top',
            'width' => '120px',
            'value' => function ($model, $key, $index, $widget) {
                return ($model->yandex_zen) ? 'Есть' : 'Нет';
            },
        ],
        'yandex_sqi',
        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'is_available',
            'vAlign' => 'top',
            'width' => '120px',
            'trueLabel' => 'Свободен',
            'falseLabel' => 'Занят',
            'trueIcon' => 'Свободен',
            'falseIcon' => 'Занят'
        ],
        [
            'class' => '\kartik\grid\BooleanColumn',
            'attribute' => 'isChecked',
            'vAlign' => 'top',
            'width' => '100px',
            'trueLabel' => 'Да',
            'falseLabel' => 'Нет',
        ],
        [
            'width' => '90px',
            'class' => '\kartik\grid\ActionColumn'
        ],
    ],
    'toolbar' => [
        [
            'content' =>
                Html::a('<i class="fas fa-plus"></i>', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => 'Добавить песню'
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
        'heading' => '<h3 class="card-title">Список Доменов</h3>',
        'type' => 'default',
        'after' => false,
        'before' =>
            '<a href="' . Url::to(['get-stat']) . '" class="btn btn-primary">Получить данные</a>' .
            '<a href="' . Url::to(['yandex-zen-checker']) . '" class="btn btn-primary ml-2">Проверить Yandex.Zen</a>' .
            '<a href="' . Url::to(['yandex-sqi']) . '" class="btn btn-primary ml-2">Проверить Yandex ИКС</a>' .
            '<a href="' . Url::to(['clear']) . '" class="btn btn-danger ml-2" data-confirm="Точно удалить все записи?" data-method="get">Очистить</a>'
    ],
]);
Pjax::end();