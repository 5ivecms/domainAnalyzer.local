<?php

use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $model common\models\MegaindexAccount */
/* @var $mode string */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => 'id',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => 'login',
                    'label' => 'Логин',
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                ],
                [
                    'attribute' => 'password',
                    'label' => 'Пароль',
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => 'proxy_id',
                    'label' => 'Прокси',
                    'format' => 'raw',
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'type' => DetailView::INPUT_SELECT2,
                    'value' => $model->proxy->ip . ':' . $model->proxy->port,
                    'widgetOptions' => [
                        'data' => ArrayHelper::map(\common\models\Proxy::find()->orderBy('id')->asArray()->all(), 'id', function ($model) {
                            return $model['ip'] . ':' . $model['port'];
                        }),
                        'options' => ['placeholder' => 'Прокси ...'],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                ],
                [
                    'attribute' => 'useragent_id',
                    'label' => 'Юзерагент',
                    'format' => 'raw',
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'type' => DetailView::INPUT_SELECT2,
                    'value' => $model->useragent->useragent,
                    'widgetOptions' => [
                        'data' => ArrayHelper::map(\common\models\Useragent::find()->orderBy('id')->asArray()->all(), 'id', 'useragent'),
                        'options' => ['placeholder' => 'Юзерагент ...'],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                ],
            ]
        ],
    ],
    'striped' => false,
    'fadeDelay' => 100,
    'panel' => [
        'heading' => '<h3 class="card-title">Информация о домене</h3>',
        'type' => DetailView::TYPE_DEFAULT,
    ],
    'vAlign' => DetailView::ALIGN_TOP,
    'formOptions' => ['action' => Url::to(['update', 'id' => $model->id])],
    'deleteOptions' => ['url' => Url::to(['delete', 'id' => $model->id])],
    'mode' => $mode
]);