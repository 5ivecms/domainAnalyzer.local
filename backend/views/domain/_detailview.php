<?php

use common\models\Domain;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $model common\models\Domain */
/* @var $mode string */

?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'group' => true,
            'label' => 'Общая',
            'rowOptions' => ['class' => 'table-info']
        ],
        [
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => 'id',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                ],
                [
                    'attribute' => 'domain',
                    'label' => 'Домен',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'attribute' => 'category_id',
                    'label' => 'Категория',
                    'format' => 'raw',
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'type' => DetailView::INPUT_SELECT2,
                    'value' => '<a href="' . Url::to(['category/view', 'id' => $model->category_id]) . '" target="_blank">' . \common\models\Category::findOne(['id' => $model->category_id])->title . '</a>',
                    'widgetOptions' => [
                        'data' => ArrayHelper::map(\common\models\Category::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Категория ...'],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                ],
                [
                    'attribute' => 'is_available',
                    'label' => 'Статус',
                    'format' => 'raw',
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'type' => DetailView::INPUT_SELECT2,
                    'value' => ($model->is_available === Domain::STATUS_AVAILABLE)
                        ? '<span class="badge badge-success"> ' . Domain::STATUS_LABELS[$model->is_available] . '</span>'
                        : (
                        ($model->is_available === Domain::STATUS_NOT_AVAILABLE)
                            ? '<span class="badge badge-danger"> ' . Domain::STATUS_LABELS[$model->is_available] . '</span>'
                            : '<span class="badge badge-warning"> ' . Domain::STATUS_LABELS[$model->is_available] . '</span>'
                        ),
                    'widgetOptions' => [
                        'data' => Domain::STATUS_LABELS,
                        'options' => ['placeholder' => 'Категория ...'],
                        'pluginOptions' => ['allowClear' => true, 'width' => '100%'],
                    ],
                ],
            ]
        ],
        [
            'group' => true,
            'label' => 'MegaIndex',
            'rowOptions' => ['class' => 'table-info']
        ],
        [
            'columns' => [
                [
                    'label' => 'Trust Rank',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->megaindex->trust_rank
                ],
                [
                    'label' => 'Domain Rank',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->megaindex->domain_rank
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'label' => 'Доменов',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->megaindex->total_self_domains
                ],
                [
                    'label' => 'Ссылок',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->megaindex->total_self_uniq_links
                ],

            ],
        ],
        [
            'columns' => [
                [
                    'label' => 'Анкоров',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->megaindex->total_anchors_unique
                ],
                [
                    'label' => 'Проверено',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => ($model->megaindex->is_completed === 1) ? '<span class="badge badge-success">Проверено</span>' : '<span class="badge badge-danger">Не проверено</span>'
                ],
            ],
        ],
        [
            'group' => true,
            'label' => 'LinkPad',
            'rowOptions' => ['class' => 'table-info']
        ],
        [
            'columns' => [
                [
                    'label' => 'LinkPad Rank',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->linkpad_rank
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'label' => 'Доменов',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->referring_domains
                ],
                [
                    'label' => 'Ссылок',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->backlinks
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'label' => 'Количество IP',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->count_ips
                ],
                [
                    'label' => 'Количество подсетей',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->count_subnet
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'label' => 'Доменов Ru',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->domain_links_ru . '%'
                ],
                [
                    'label' => 'Доменов РФ',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->domain_links_rf . '%'
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'label' => 'Доменов Com',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->domain_links_com . '%'
                ],
                [
                    'label' => 'Доменов Su',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->domain_links_su . '%'
                ],
            ]
        ],
        [
            'columns' => [
                [
                    'label' => 'Других доменов',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->linkpad->domain_links_other . '%'
                ],
                [
                    'label' => 'Проверено',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => ($model->linkpad->is_completed === 1) ? '<span class="badge badge-success">Проверено</span>' : '<span class="badge badge-danger">Не проверено</span>'
                ],
            ]
        ],
        [
            'group' => true,
            'label' => 'Yandex',
            'rowOptions' => ['class' => 'table-info']
        ],
        [
            'columns' => [
                [
                    'label' => 'Икс',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => $model->yandex->sqi
                ],
                [
                    'label' => 'Проверено',
                    'format' => 'raw',
                    'displayOnly' => true,
                    'valueColOptions' => ['style' => 'width:10%'],
                    'labelColOptions' => ['style' => 'width: 10%'],
                    'value' => ($model->yandex->is_completed_sqi === 1) ? '<span class="badge badge-success">Проверено</span>' : '<span class="badge badge-danger">Не проверено</span>'
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
    'formOptions' => ['action' => Url::to(['update', 'id' => $model->id])], // your action to delete
    'deleteOptions' => ['url' => Url::to(['delete', 'id' => $model->id])],
    'mode' => $mode
]) ?>