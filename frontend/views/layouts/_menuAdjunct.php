<?php

use common\models\User;
use common\src\helpers\Helper;
use common\src\helpers\UserImageHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Menu;

/* @var $this View */
/* @var $user User */

$menuItems = [
    ['label' => 'Find Jobs', 'url' => ['/vacancy/index']],
    ['label' => 'Messages', 'url' => ['/chat/index']],
    ['label' => 'Proposals', 'url' => ['/proposal/index']],
];

echo Menu::widget([
    'options' => ['class' => 'g-header__content-menu'],
    'itemOptions' => ['class' => 'g-header__content-menu-item'],
    'items' => $menuItems,
    'linkTemplate' => '<a class="g-header__content-menu-item-link" href="{url}"><span>{label}</span></a>',
    'encodeLabels' => false,
    'activeCssClass' => 'active',
]);

$unreadMessageCount = Helper::getUnreadMessageCount($user);
?>

<div class="g-header__content-user" id="userMenu">
    <?php if ($unreadMessageCount > 0): ?>
        <a href="<?= Url::to(['/chat/index']) ?>" class="g-header__content-user-messages m-view">
            <span><?= $unreadMessageCount ?></span>
        </a>
    <?php else: ?>
        <a href="<?= Url::to(['/chat/index']) ?>" class="g-header__content-user-messages m-no"></a>
    <?php endif; ?>

    <div class="g-header__content-user-link js-activeOnOff" data-id="userMenu">
        <div class="g-header__content-user-link-icon fa fa-chevron-down"></div>
        <div class="g-header__content-user-link-ava">
            <div class="g-header__content-user-link-ava-nopict fa fa-user"></div>
            <img src="<?= UserImageHelper::getUrl($user) ?>" class="g-header__content-user-link-ava-img" alt="">
        </div>
        <div class="g-header__content-user-link-name">
            <div><?= Html::encode($user->getUsername()) ?></div>
        </div>
    </div>

    <div class="g-header__content-user-menu">
        <div class="g-header__content-user-menu-item">
            <a href="<?= Url::to(['/site/profile']) ?>" class="g-header__content-user-menu-item-link">Profile</a>
        </div>

        <div class="g-header__content-user-menu-out">
            <?=
            Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Log Out',
                ['class' => 'g-header__content-user-menu-out-link logout']
            )
            . Html::endForm()
            ?>
        </div>
    </div>
</div>