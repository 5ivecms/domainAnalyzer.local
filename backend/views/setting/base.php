<?php

$this->title = 'Базовые настройки';

?>

<div class="row">
    <?php
    if (Yii::$app->request->getHeaders()->has('X-PJAX') && Yii::$app->request->queryParams) {
        echo $this->renderAjax('base/_parser', [
            'settings' => $parserSettings
        ]);
        echo $this->renderAjax('base/_cache', [
            'settings' => $cacheSettings
        ]);
    } else {
        echo $this->render('base/_parser', [
            'settings' => $parserSettings
        ]);
        echo $this->render('base/_cache', [
            'settings' => $cacheSettings
        ]);
    }
    ?>
</div>