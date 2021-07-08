<?php


use yii\bootstrap4\Modal;


/* @var $settings array */

Modal::begin([
    'id' => 'parsing-settings-modal',
    'title' => 'Настройки',
    'closeButton' => ['tag' => 'button', 'label' => 'x',],
]);

echo $this->render('_settingsForm', ['settings' => $settings]);

Modal::end();
