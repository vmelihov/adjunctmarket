<?php

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Menu;

/* @var $this View */

$menuItems = [
    ['label' => 'How it works', 'url' => ['/site/index']],
    ['label' => 'Find Jobs', 'url' => ['/vacancy/index']],
    ['label' => 'Adjuncts', 'url' => ['/adjunct/index']],
    ['label' => 'Post a Job', 'url' => ['/vacancy/create']],
];

echo Menu::widget([
    'options' => ['class' => 'g-header__content-menu'],
    'itemOptions' => ['class' => 'g-header__content-menu-item'],
    'items' => $menuItems,
    'linkTemplate' => '<a class="g-header__content-menu-item-link" href="{url}"><span>{label}</span></a>',
    'encodeLabels' => false,
    'activeCssClass' => 'active',
]);
?>

<div class="g-header__content-controls">
    <div class="g-header__content-controls-one">
        <a href="<?= Url::to(['/site/login'], true) ?>" class="g-header__content-controls-one-link">Sign In</a>
    </div>
    <div class="g-header__content-controls-one">
        <a href="<?= Url::to(['/site/signup'], true) ?>" class="g-header__content-controls-one-link">Sign Up</a>
    </div>
</div>

