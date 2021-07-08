<?php

use common\models\Domain;
use common\models\Setting;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $searchModel common\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

    <style>
        .btn-toolbar .btn-group {
            margin-left: 0.5rem;
        }

        .nowrap {
            white-space: nowrap;
        }

        .table tbody td {
            white-space: nowrap;
        }
    </style>


<?php $dynagrid = DynaGrid::begin([
    'options' => ['id' => 'dynagrid-domains'],
    'columns' => [
        [
            'class' => '\kartik\grid\CheckboxColumn',
            'rowSelectedClass' => GridView::BS_TABLE_INFO,
            'checkboxOptions' => function ($model) {
                return ['value' => $model->id];
            },
        ],
        'id',
        'domain',
        [
            'attribute' => 'linkpad_rank',
            'label' => 'LP R',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->is_completed)) ? $model->linkpad->linkpad_rank : '—';
            },
        ],
        [
            'attribute' => 'linkpad_backlinks',
            'label' => 'LP BL',
            'vAlign' => 'top',
            'width' => '120px',
            'format' => 'raw',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->backlinks)) ? number_format($model->linkpad->backlinks, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'linkpad_nofollow_links',
            'label' => 'LP NFL',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->nofollow_links)) ? number_format($model->linkpad->nofollow_links, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'linkpad_no_anchor_links',
            'label' => 'LP NAL',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->no_anchor_links)) ? number_format($model->linkpad->no_anchor_links, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'linkpad_count_ips',
            'label' => 'LP CI',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->count_ips)) ? number_format($model->linkpad->count_ips, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'linkpad_count_subnet',
            'label' => 'LP CS',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->count_subnet)) ? number_format($model->linkpad->count_subnet, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'linkpad_referring_domains',
            'label' => 'LP RD',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->referring_domains)) ? number_format($model->linkpad->referring_domains, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'linkpad_domain_links_ru',
            'label' => 'LP DLRu',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->domain_links_ru)) ? $model->linkpad->domain_links_ru . '%' : '—';
            },
        ],
        [
            'attribute' => 'linkpad_domain_links_rf',
            'label' => 'LP DLRf',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->domain_links_rf)) ? $model->linkpad->domain_links_rf . '%' : '—';
            },
        ],
        [
            'attribute' => 'linkpad_domain_links_com',
            'label' => 'LP DLCom',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->domain_links_com)) ? $model->linkpad->domain_links_com . '%' : '—';
            },
        ],
        [
            'attribute' => 'linkpad_domain_links_su',
            'label' => 'LP DLSu',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->domain_links_su)) ? $model->linkpad->domain_links_su . '%' : '—';
            },
        ],
        [
            'attribute' => 'linkpad_domain_links_other',
            'label' => 'LP DLO',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->linkpad->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->linkpad->domain_links_other)) ? $model->linkpad->domain_links_other . '%' : '—';
            },
        ],

        // Megaindex
        [
            'attribute' => 'megaindex_total_self_uniq_links',
            'label' => 'MI Links',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->total_self_uniq_links)) ? number_format($model->megaindex->total_self_uniq_links, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_total_anchors_unique',
            'label' => 'MI Anchors',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->total_anchors_unique)) ? number_format($model->megaindex->total_anchors_unique, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_total_self_domains',
            'label' => 'MI Domains',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->total_self_domains)) ? number_format($model->megaindex->total_self_domains, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_trust_rank',
            'label' => 'MI TR',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->trust_rank)) ? number_format($model->megaindex->trust_rank, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_domain_rank',
            'label' => 'MI DR',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->domain_rank)) ? number_format($model->megaindex->domain_rank, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_organic_traffic',
            'label' => 'MI Organic',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->organic_traffic)) ? number_format($model->megaindex->organic_traffic, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_increasing_search_traffic',
            'label' => 'MI Predict(%)',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->increasing_search_traffic)) ? number_format($model->megaindex->increasing_search_traffic, 0, '.', ' ') : '—';
            },
        ],
        [
            'attribute' => 'megaindex_popular_keywords',
            'label' => 'MI Keywords',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->megaindex->is_completed) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->megaindex->popular_keywords)) ? number_format($model->megaindex->popular_keywords, 0, '.', ' ') : '—';
            },
        ],

        [
            'attribute' => 'yandex_sqi',
            'label' => 'ИКС',
            'vAlign' => 'top',
            'width' => '120px',
            'contentOptions' => function ($data) {
                if ($data->yandex->is_completed_sqi) {
                    $class = 'table-success';
                } else {
                    $class = 'table-danger';
                }
                $class .= ' nowrap';
                return ['class' => $class];
            },
            'value' => function ($model, $key, $index, $widget) {
                return (isset($model->yandex->sqi)) ? number_format($model->yandex->sqi, 0, '.', ' ') : '—';
            },
        ],

        [
            'attribute' => 'category_id',
            'label' => 'Категория',
            'width' => '100px',
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
            'attribute' => 'is_available',
            'label' => 'Статус',
            'width' => '70px',
            'value' => function ($model) {
                return Domain::STATUS_LABELS[$model->is_available];
            },
            'filter' => Domain::STATUS_LABELS,
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ]
        ],

        [
            'width' => '90px',
            'class' => '\kartik\grid\ActionColumn'
        ],
    ],
    'theme' => 'panel-info',
    'showPersonalize' => true,
    'storage' => DynaGrid::TYPE_DB,
    'gridOptions' => [
        'id' => 'domains-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => false,
        'floatHeader' => false,
        'pjax' => true,
        'responsiveWrap' => false,
        'panel' => [
            'heading' => '<h5 class="panel-title m-0">Список доменов</h5>',
            'before' => $this->render('_panelBefore', []),
            'after' => false
        ],
        'toolbar' => [
            ['content' =>
                Html::a('<i class="fas fa-plus"></i>', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => 'Добавить домен',
                    'data-pjax' => 0
                ]) . ' ' .
                Html::a('<i class="fas fa-redo"></i>', ['domain/index'], ['data-pjax' => 1, 'class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid'])
            ],
            ['content' => '{dynagrid}'],
            '{export}',
        ]
    ],
]);
if (substr($dynagrid->theme, 0, 6) == 'simple') {
    $dynagrid->gridOptions['panel'] = true;
}
DynaGrid::end();

$linkpadStatisticUrl = Url::to(['domain/linkpad']);
$linkpadIsProcess = Setting::getLinkpadSettings()['isProcess'];

$megaindexStatisticUrl = Url::to(['domain/megaindex']);
$megaindexIsProcess = Setting::getMegaindexSettings()['isProcess'];

$availableStatisticUrl = Url::to(['domain/available']);
$availableIsProcess = Setting::getAvailableSettings()['isProcess'];

$yandexSqiStatisticUrl = Url::to(['domain/yandex-sqi']);
$yandexSqiProcess = Setting::getYandexSqiSettings()['isProcess'];

$autoReloadSettings = Setting::getAutoRefreshSettings();

$js = <<< JS

var isLinkpadProcess = {$linkpadIsProcess};
var isMegaindexProcess = {$megaindexIsProcess};
var isAvailableProcess = {$availableIsProcess};
var isYandexSqiProcess = {$availableIsProcess};
var isAutoRefreshFreshEnabled = Boolean({$autoReloadSettings['enabled']});
let autoRefreshIntervalId = 0;

autoRefresh();

function autoRefresh() {
    var status = getAutoRefreshStatus();
    if (status && autoRefreshIntervalId === 0) {
        console.log('стартуем');
        startAutoRefresh();
    }
    if (!status) {
        stopAutoRefresh();
        console.log('остангавливаем');
    }
}

function getAutoRefreshStatus() {
    var status = isAutoRefreshFreshEnabled && (Boolean(isLinkpadProcess) || Boolean(isMegaindexProcess) || Boolean(isAvailableProcess) || Boolean(isYandexSqiProcess))
    return Boolean(status);
}

function startAutoRefresh() {
    autoRefreshIntervalId = setInterval(() => refreshGrid(), {$autoReloadSettings['timeout']} * 1000);
}

function stopAutoRefresh() {
    clearInterval(autoRefreshIntervalId);
    autoRefreshIntervalId = 0
}

if (isLinkpadProcess) {
    linkpadActiveState();
    linkpadParser();
}

if (isMegaindexProcess) {
    megaindexActiveState();
    megaindexParser();
}

if (isAvailableProcess) {
    availableActiveState();
    availableParser();
}

if (isYandexSqiProcess) {
    yandexSqiActiveState();
    yandexSqiParser();
}

// Linkpad
function linkpadStart() {
    if (!isLinkpadProcess) {
        linkpadParser();
    }
    linkpadActiveState();
    autoRefresh();
}

function linkpadStop() {
    linkpadInactiveSate();
    autoRefresh();
}

function getLinkpadIcon() {
    return $('body').find('#linkpad-icon');
}

function getLinkpadStartForms() {
    return $('body').find('.linkpad-start-form');
}

function getLinkpadStopForm() {
    return $('body').find('#linkpad-stop-form');
}

function linkpadActiveState() {
    isLinkpadProcess = true;
    getLinkpadIcon().addClass('active');
    getLinkpadStartForms().each(function (i, item) {
        $(item).addClass('d-none');
    }) 
    getLinkpadStopForm().removeClass('d-none');
}

function linkpadInactiveSate() {
    isLinkpadProcess = false;
    getLinkpadIcon().removeClass('active');
    getLinkpadStartForms().each(function (i, item) {
        $(item).removeClass('d-none');
    }) 
    getLinkpadStopForm().addClass('d-none');
}

function linkpadParser() {
    xhr('{$linkpadStatisticUrl}', '')
    .then(function(response) {
        if (response == 1 && isLinkpadProcess) {
         linkpadParser();
        } else {
            linkpadInactiveSate();
            getLinkpadStopForm().trigger('submit');
        }
    })
    .catch(function(error) {
        linkpadInactiveSate();
        getLinkpadStopForm().trigger('submit');
    });
}

$('body').on('submit', '#linkpad-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), linkpadStart, linkpadStop)
});

$('body').on('submit', '#linkpad-stop-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), linkpadStop, linkpadStop)
});

$('body').on('submit', '#linkpad-selected-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var ids = $('#domains-grid').yiiGridView('getSelectedRows');
    
    if (confirm('Точно собрать выбранные?')) {
        linkpadActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, ids: ids},
            success: function (resp) {
                linkpadInactiveSate();
                getLinkpadStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
            },
            error: function(request, status, error) {
                linkpadInactiveSate();
                getLinkpadStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#linkpad-start-category-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var params = (new URL(document.location)).searchParams; 
    var categoryId = params.get('DomainSearch[category_id]');
    
    if (categoryId && confirm('Точно собрать выбранные?')) {
        linkpadActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, categoryId: categoryId},
            success: function (resp) {
                linkpadInactiveSate();
                getLinkpadStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
            },
            error: function(request, status, error) {
                linkpadInactiveSate();
                getLinkpadStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

// Megaindex
function megaindexStart() {
    if (!isMegaindexProcess) {
        megaindexParser();
    }
    megaindexActiveState();
    autoRefresh();
}

function megaindexStop() {
   megaindexInactiveSate();
   autoRefresh();
}

function getMegaindexIcon() {
    return $('body').find('#megaindex-icon');
}

function getMegaindexStartForms() {
    return $('body').find('.megaindex-start-form');
}

function getMegaindexStopForm() {
    return $('body').find('#megaindex-stop-form');
}

function megaindexActiveState() {
    isMegaindexProcess = true;
    getMegaindexIcon().addClass('active');
    getMegaindexStartForms().each(function (i, item) {
        $(item).addClass('d-none');
    })
    getMegaindexStopForm().removeClass('d-none');
}

function megaindexInactiveSate() {
    isMegaindexProcess = false;
    getMegaindexIcon().removeClass('active');
    getMegaindexStartForms().each(function (i, item) {
        $(item).removeClass('d-none');
    })
    getMegaindexStopForm().addClass('d-none');
}

function megaindexParser() {
    xhr('{$megaindexStatisticUrl}', '')
    .then(function(response) {
        if (response == 1 && isMegaindexProcess) {
         megaindexParser();
        } else if (response == 2) {
            alert('Ошибка webdriver.');
            megaindexInactiveSate();
            getMegaindexStopForm().trigger('submit');
        } else {
            megaindexInactiveSate();
            getMegaindexStopForm().trigger('submit');
        }
    })
    .catch(function(error) {
        alert('Ошибка при выполнении запроса.');
        megaindexInactiveSate();
        getMegaindexStopForm().trigger('submit');
    });
}

$('body').on('submit', '#megaindex-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), megaindexStart, megaindexStop)
});

$('body').on('submit', '#megaindex-stop-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), megaindexStop, megaindexStop)
});

$('body').on('submit', '#megaindex-selected-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var ids = $('#domains-grid').yiiGridView('getSelectedRows');
    
    if (confirm('Точно собрать выбранные?')) {
        megaindexActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, ids: ids},
            success: function (resp) {
                megaindexInactiveSate();
                getMegaindexStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
            },
            error: function(request, status, error) {
                megaindexInactiveSate();
                getMegaindexStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#megaindex-start-category-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var params = (new URL(document.location)).searchParams; 
    var categoryId = params.get('DomainSearch[category_id]');
    
    if (categoryId && confirm('Точно собрать из текущей категории?')) {
        megaindexActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, categoryId: categoryId},
            success: function (resp) {
                megaindexInactiveSate();
                getMegaindexStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
            },
            error: function(request, status, error) {
                megaindexInactiveSate();
                getMegaindexStopForm().trigger('submit');
                autoRefresh();
                refreshGrid();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

// Available
function availableStart() {
    if (!isAvailableProcess) {
        availableParser();
    }
    availableActiveState();
    autoRefresh();
}

function availableStop() {
   availableInactiveSate();
   autoRefresh();
}

function getAvailableIcon() {
    return $('body').find('#available-icon');
}

function getAvailableStartForms() {
    return $('body').find('.available-start-form');
}

function getAvailableStopForm() {
    return $('body').find('#available-stop-form');
}

function availableActiveState() {
    isAvailableProcess = true;
    getAvailableIcon().addClass('active');
    getAvailableStartForms().each(function (i, item) {
        $(item).addClass('d-none');    
    })
    getAvailableStopForm().removeClass('d-none');
}

function availableInactiveSate() {
    isAvailableProcess = false;
    getAvailableIcon().removeClass('active');
    getAvailableStartForms().each(function (i, item) {
        $(item).removeClass('d-none');    
    })
    getAvailableStopForm().addClass('d-none');
}

function availableParser() {
    xhr('{$availableStatisticUrl}', '')
    .then(function(response) {
        if (response == 1 && isAvailableProcess) {
         availableParser();
        } else {
            availableInactiveSate();
            getAvailableStopForm().trigger('submit');
        }
    })
    .catch(function(error) {
        availableInactiveSate();
        getAvailableStopForm().trigger('submit');
    });
}

$('body').on('submit', '#available-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), availableStart, availableStop)
});

$('body').on('submit', '#available-start-selected-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var ids = $('#domains-grid').yiiGridView('getSelectedRows');
    
    if (confirm('Точно проверить выбранные?')) {
        availableActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, ids: ids},
            success: function (resp) {
                if (resp == 1) {
                    availableInactiveSate();
                    getAvailableStopForm().trigger('submit');
                    autoRefresh();
                    refreshGrid();
                }
            },
            error: function(request, status, error) {
                availableInactiveSate();
                getAvailableStopForm().trigger('submit');
                autoRefresh();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#available-start-category-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var params = (new URL(document.location)).searchParams; 
    var categoryId = params.get('DomainSearch[category_id]');

    if (categoryId && confirm('Точно проверить выбранные?')) {
        availableActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, categoryId: categoryId},
            success: function (resp) {
                console.log(resp)
                if (resp == 1) {
                    availableInactiveSate();
                    getAvailableStopForm().trigger('submit');
                    autoRefresh();
                    refreshGrid();
                }
            },
            error: function(request, status, error) {
                availableInactiveSate();
                getAvailableStopForm().trigger('submit');
                autoRefresh();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#available-stop-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), availableStop, availableStop)
});

function getParam(key) {
    var p = window.location.search;
    p = p.match(new RegExp(key + '=([^&=]+)'));
    return p ? p[1] : false;
}

// YandexSqi
function yandexSqiStart() {
    if (!isYandexSqiProcess) {
        yandexSqiParser();
    }
    yandexSqiActiveState();
    autoRefresh();
}

function yandexSqiStop() {
   yandexSqiInactiveSate();
   autoRefresh();
}

function getYandexSqiIcon() {
    return $('body').find('#yandex-icon');
}

function getYandexSqiStartForms() {
    return $('body').find('.yandex-sqi-start-form');
}

function getYandexSqiStopForm() {
    return $('body').find('#yandex-sqi-stop-form');
}

function yandexSqiActiveState() {
    isYandexSqiProcess = true;
    getYandexSqiIcon().addClass('active');
    getYandexSqiStartForms().each(function (i, item) {
        $(item).addClass('d-none');        
    })
    getYandexSqiStopForm().removeClass('d-none');
}

function yandexSqiInactiveSate() {
    isYandexSqiProcess = false;
    getYandexSqiIcon().removeClass('active');
    getYandexSqiStartForms().each(function (i, item) {
        $(item).removeClass('d-none');        
    })
    getYandexSqiStopForm().addClass('d-none');
}

function yandexSqiParser() {
    xhr('{$yandexSqiStatisticUrl}', '')
    .then(function(response) {
        if (response == 1 && isYandexSqiProcess) {
         yandexSqiParser();
        } else {
            yandexSqiInactiveSate();
            getYandexSqiStopForm().trigger('submit');
        }
    })
    .catch(function(error) {
        yandexSqiInactiveSate();
        getYandexSqiStopForm().trigger('submit');
    });
}

$('body').on('submit', '#yandex-sqi-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), yandexSqiStart, yandexSqiStop)
});

$('body').on('submit', '#yandex-sqi-stop-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateOption($(this).serialize(), yandexSqiStop, yandexSqiStop)
});

$('body').on('submit', '#yandex-sqi-selected-start-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var ids = $('#domains-grid').yiiGridView('getSelectedRows');
    
    if (confirm('Точно проверить выбранные?')) {
        yandexSqiActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, ids: ids},
            success: function (resp) {
                if (resp == 1) {
                    yandexSqiInactiveSate();
                    getYandexSqiStopForm().trigger('submit');
                    autoRefresh();
                    refreshGrid();
                }
            },
            error: function(request, status, error) {
                yandexSqiInactiveSate();
                getYandexSqiStopForm().trigger('submit');
                autoRefresh();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#yandex-sqi-start-category-form', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var params = (new URL(document.location)).searchParams; 
    var categoryId = params.get('DomainSearch[category_id]');

    if (categoryId && confirm('Точно проверить из текущей категории?')) {
        yandexSqiActiveState();
        autoRefresh();
        
         $.ajax({
            type: type,
            url: action,
            data: {data: data, categoryId: categoryId},
            success: function (resp) {
                if (resp == 1) {
                   yandexSqiInactiveSate();
                    getYandexSqiStopForm().trigger('submit');
                    autoRefresh();
                    refreshGrid();
                }
            },
            error: function(request, status, error) {
                yandexSqiInactiveSate();
                getYandexSqiStopForm().trigger('submit');
                autoRefresh();
                alert('При обновлении доменов произошла ошибка');
            }
        });   
    }
});

// Общее
function updateOption(data, successCallback, errorCallback) {
    $.ajax({
        'type': 'POST',
        'url': '/admin/ajax/update-option',
        'data': data,
        success: function(data) {
            if (Boolean(data) === true) {
                successCallback();
            } else {
                errorCallback();                
            }
        },
        error: function(request, status, error) {
            errorCallback();
        }
    });
}

function refreshGrid() {
    $.pjax.reload({container: '#dynagrid-domains-pjax'});
}

function xhr(url, data, type = 'GET') {
    return new Promise(function(succeed, fail) {
        var request = new XMLHttpRequest();
        request.open(type, url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.addEventListener('load', function() {
          if (request.status < 400) {
              succeed(request.response);  
          } else {
              fail(new Error('Request failed: ' + request.statusText));
          }
        });
        request.addEventListener('error', function() {
            fail(new Error('Network error'));
        });
        request.send(data);
    });
}


$("#dynagrid-domains-pjax").on("pjax:end", function() { 
    if (isLinkpadProcess) {
        linkpadActiveState();
    } else {
        linkpadInactiveSate();
    }
    
    if (isMegaindexProcess) {
        megaindexActiveState();
    } else {
        megaindexInactiveSate();
    }
    
    if (isAvailableProcess) {
        availableActiveState();
    } else {
        availableInactiveSate();
    }
    
    if (isYandexSqiProcess) {
        yandexSqiActiveState();
    } else {
        yandexSqiInactiveSate();
    }
});
JS;

$js2 = <<< JS
$('body').on('submit', '#delete-selected', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var ids = $('#domains-grid').yiiGridView('getSelectedRows');
    
    if (confirm('Точно удалить выбранные?')) {
         $.ajax({
            type: type,
            url: action,
            data: {data: data, ids: ids},
            success: function (resp) {
                if (resp == 1) {
                    $.pjax.reload({container: '#dynagrid-domains-pjax'});
                }
            },
            error: function(request, status, error) {
                alert('При удалении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#delete-not-available-domains', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    
    if (confirm('Точно удалить все занятые?')) {
         $.ajax({
            type: type,
            url: action,
            data: {data: data},
            success: function (resp) {
                $.pjax.reload({container: '#dynagrid-domains-pjax'});
            },
            error: function(request, status, error) {
                alert('При удалении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#delete-not-available-domains-from-category', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    var params = (new URL(document.location)).searchParams; 
    var categoryId = params.get('DomainSearch[category_id]');
    
    if (confirm('Точно удалить все занятые из текущей категории?')) {
         $.ajax({
            type: type,
            url: action,
            data: {data: data, categoryId: categoryId},
            success: function (resp) {
                $.pjax.reload({container: '#dynagrid-domains-pjax'});
            },
            error: function(request, status, error) {
                alert('При удалении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#delete-all-domains', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serialize();
    
    if (confirm('Точно все домены?')) {
         $.ajax({
            type: type,
            url: action,
            data: {data: data},
            success: function (resp) {
                $.pjax.reload({container: '#dynagrid-domains-pjax'});
            },
            error: function(request, status, error) {
                alert('При удалении доменов произошла ошибка');
            }
        });   
    }
});

$('body').on('submit', '#change-category', function (e) {
    e.stopPropagation();
    e.preventDefault();
    
    var action = $(this).attr('action');
    var type = $(this).attr('method');
    var data = $(this).serializeArray();
    var ids = $('#domains-grid').yiiGridView('getSelectedRows');

    if (ids.length && confirm('Точно переместить выбранные домены в другую категорию?')) {
         $.ajax({
            type: type,
            url: action,
            data: {data: data, ids: ids},
            success: function (resp) {
                $('#change-category-modal').modal('hide');
                $.pjax.reload({container: '#dynagrid-domains-pjax'});
            },
            error: function(request, status, error) {
                alert('При смене категории доменов произошла ошибка');
            }
        });   
    }
});
JS;


$this->registerJs($js, \yii\web\View::POS_READY);
$this->registerJs($js2, \yii\web\View::POS_READY);