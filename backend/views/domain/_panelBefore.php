<?php

use common\models\Setting;
use yii\bootstrap4\Html;

?>

<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#parsing-settings-modal">
    <i class="nav-icon fas fa-cog"></i>
</button>
<div class="btn-group">
    <button id="available-icon" type="button" class="btn btn-outline-info">Общее</button>
    <button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split"
            id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-reference="parent">
        <span class="sr-only">Переключатель выпадающего списка</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
        <?php $availableIsProcess = Setting::getAvailableSettings()['isProcess']; ?>
        <?= Html::beginForm(['domain/available'], 'post', ['id' => 'available-start-form', 'class' => ($availableIsProcess) ? 'available-start-form d-none' : 'available-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.available.isProcess]value', 1) ?>
        <?= Html::submitButton('Проверить статус', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/available'], 'post', ['id' => 'available-stop-form', 'class' => (!$availableIsProcess) ? 'd-none' : '', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.available.isProcess]value', 0) ?>
        <?= Html::submitButton('Остановить проверку статуса', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/available'], 'post', ['id' => 'available-start-selected-form', 'class' => ($availableIsProcess) ? 'available-start-form d-none' : 'available-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.available.isProcess]value', 1) ?>
        <?= Html::submitButton('Проверить статус только выбранных', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/available'], 'post', ['id' => 'available-start-category-form', 'class' => ($availableIsProcess) ? 'available-start-form d-none' : 'available-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.available.isProcess]value', 1) ?>
        <?= Html::submitButton('Проверить статус только из текущей категории', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <div class="dropdown-divider"></div>
        <?= Html::beginForm(['domain/delete-selected'], 'post', ['id' => 'delete-selected', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::submitButton('Удалить выбранные', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/delete-not-available-domains'], 'post', ['id' => 'delete-not-available-domains', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::submitButton('Удалить занятые домены', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/delete-not-available-domains-from-category'], 'post', ['id' => 'delete-not-available-domains-from-category', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::submitButton('Удалить занятые домены из текущей категории', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/delete-all'], 'post', ['id' => 'delete-all-domains', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::submitButton('Удалить все домены', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <div class="dropdown-divider"></div>
        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#change-category-modal">Переместить выбранные в другую категорию</button>
    </div>
</div>
<div class="btn-group">
    <button id="linkpad-icon" type="button" class="btn btn-outline-info d-flex align-items-center justify-content-center">
        <img height="16" src="https://www.linkpad.ru/favicon.ico" alt="Linkpad" />
    </button>
    <button type="button"
            class="btn btn-outline-info dropdown-toggle dropdown-toggle-split"
            id="dropdownMenuReference"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            data-reference="parent">
        <span class="sr-only">Переключатель выпадающего списка</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
        <?php $linkpadIsProcess = Setting::getLinkpadSettings()['isProcess']; ?>
        <?= Html::beginForm(['domain/linkpad'], 'post', ['id' => 'linkpad-start-form', 'class' => ($linkpadIsProcess) ? 'linkpad-start-form d-none' : 'linkpad-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.linkpad.isProcess]value', 1) ?>
        <?= Html::submitButton('Запустить сбор', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/linkpad'], 'post', ['id' => 'linkpad-stop-form', 'class' => (!$linkpadIsProcess) ? 'd-none' : '', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.linkpad.isProcess]value', 0) ?>
        <?= Html::submitButton('Остановить сбор', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/linkpad'], 'post', ['id' => 'linkpad-selected-start-form', 'class' => ($linkpadIsProcess) ? 'linkpad-start-form d-none' : 'linkpad-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.linkpad.isProcess]value', 1) ?>
        <?= Html::submitButton('Собрать выбранные', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/linkpad'], 'post', ['id' => 'linkpad-start-category-form', 'class' => ($linkpadIsProcess) ? 'linkpad-start-form d-none' : 'linkpad-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.linkpad.isProcess]value', 1) ?>
        <?= Html::submitButton('Собрать из текущей категории', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
<div class="btn-group">
    <button id="megaindex-icon" type="button" class="btn btn-outline-info d-flex align-items-center justify-content-center">
        <img height="16" src="https://ru.megaindex.com/template/main/images/favicon.ico" alt="Megaindex" />
    </button>
    <button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split"
            id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-reference="parent">
        <span class="sr-only">Переключатель выпадающего списка</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
        <?php $megaindexIsProcess = Setting::getMegaindexSettings()['isProcess']; ?>
        <?= Html::beginForm(['domain/megaindex'], 'post', ['id' => 'megaindex-start-form', 'class' => ($megaindexIsProcess) ? 'megaindex-start-form d-none' : 'megaindex-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.megaindex.isProcess]value', 1) ?>
        <?= Html::submitButton('Запустить сбор', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/megaindex'], 'post', ['id' => 'megaindex-stop-form', 'class' => (!$megaindexIsProcess) ? 'd-none' : '', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.megaindex.isProcess]value', 0) ?>
        <?= Html::submitButton('Остановить сбор', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/megaindex'], 'post', ['id' => 'megaindex-selected-start-form', 'class' => ($megaindexIsProcess) ? 'megaindex-start-form d-none' : 'megaindex-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.megaindex.isProcess]value', 1) ?>
        <?= Html::submitButton('Собрать выбранные', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/megaindex'], 'post', ['id' => 'megaindex-start-category-form', 'class' => ($megaindexIsProcess) ? 'megaindex-start-form d-none' : 'megaindex-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.megaindex.isProcess]value', 1) ?>
        <?= Html::submitButton('Собрать из текущей категории', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
    </div>
</div>

<div class="btn-group">
    <button id="yandex-icon" type="button" class="btn btn-outline-info d-flex align-items-center justify-content-center">
        <img height="16" src="/admin/images/yandex.svg" alt="Yandex" />
    </button>
    <button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split"
            id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-reference="parent">
        <span class="sr-only">Переключатель выпадающего списка</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
        <?php $yandexSqiIsProcess = Setting::getYandexSqiSettings()['isProcess']; ?>
        <?= Html::beginForm(['domain/yandex-sqi'], 'post', ['id' => 'yandex-sqi-start-form', 'class' => ($yandexSqiIsProcess) ? 'yandex-sqi-start-form d-none' : 'yandex-sqi-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.yandexSqi.isProcess]value', 1) ?>
        <?= Html::submitButton('Сбор Yandex ИКС', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/yandex-sqi'], 'post', ['id' => 'yandex-sqi-stop-form', 'class' => (!$yandexSqiIsProcess) ? 'd-none' : '', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.yandexSqi.isProcess]value', 0) ?>
        <?= Html::submitButton('Остановить сбор Yandex ИКС', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/yandex-sqi'], 'post', ['id' => 'yandex-sqi-selected-start-form', 'class' => ($megaindexIsProcess) ? 'yandex-sqi-start-form d-none' : 'yandex-sqi-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.yandexSqi.isProcess]value', 1) ?>
        <?= Html::submitButton('Собрать Yandex ИКС у выбранных', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
        <?= Html::beginForm(['domain/yandex-sqi'], 'post', ['id' => 'yandex-sqi-start-category-form', 'class' => ($megaindexIsProcess) ? 'yandex-sqi-start-form d-none' : 'yandex-sqi-start-form', 'enctype' => 'multipart/form-data']) ?>
        <?= Html::hiddenInput('Setting[parser.yandexSqi.isProcess]value', 1) ?>
        <?= Html::submitButton('Собрать Yandex ИКС из текущей категории', ['class' => 'dropdown-item']) ?>
        <?= Html::endForm() ?>
    </div>
</div>