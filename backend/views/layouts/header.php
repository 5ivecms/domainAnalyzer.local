<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */

use yii\helpers\Html;

?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/domain/index" class="nav-link">Домены</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/category/index" class="nav-link">Категории</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/megaindex-account/index" class="nav-link">Аккаунты Megaindex</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/proxy/index" class="nav-link">Прокси</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/useragent/index" class="nav-link">Юзерагенты</a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">Alexander Pierce</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-footer">
                    <?= Html::a(
                        'Sign out',
                        ['site/logout'],
                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']
                    ) ?>
                </li>
            </ul>
        </li>
    </ul>
</nav>
