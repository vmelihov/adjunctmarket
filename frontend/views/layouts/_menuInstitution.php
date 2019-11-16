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
    ['label' => 'My Vacancies', 'url' => ['/vacancy/index']],
    ['label' => 'Post a Job', 'url' => ['/vacancy/create']],
    ['label' => 'Messages', 'url' => '#', 'options' => ['onclick' => '$(\'#chatList\').show()']],
    ['label' => 'Adjuncts', 'url' => ['/adjunct/index']],
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
        <a class="g-header__content-user-messages m-view" onclick="$('#chatList').show()">
            <span><?= $unreadMessageCount ?></span>
        </a>
    <?php else: ?>
        <a class="g-header__content-user-messages m-no" onclick="$('#chatList').show()"></a>
    <?php endif; ?>

    <div class="g-header__content-user-link js-activeOnOff" data-id="userMenu">
        <div class="g-header__content-user-link-icon fa fa-chevron-down"></div>
        <div class="g-header__content-user-link-ava">
            <div class="g-header__content-user-link-ava-nopict fa fa-user"></div>
            <img src="<?= UserImageHelper::getUrl($user) ?>" class="g-header__content-user-link-ava-img" alt="">
        </div>
        <div class="g-header__content-user-link-name">
            <div><?= Html::encode($user->getUsername()) ?></div>
            <div><?= Html::encode($user->profile->position) ?></div>
        </div>
    </div>

    <div class="g-header__content-user-menu">
        <div class="g-header__content-user-menu-item">
            <a href="<?= Url::to(['/site/profile']) ?>" class="g-header__content-user-menu-item-link">Profile</a>
        </div>

        <?= $this->render('_logoutForm') ?>
    </div>
</div>
