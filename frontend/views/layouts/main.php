<?php

/* @var $this View */
/* @var $content string */

use common\src\helpers\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\Menu;

$user = Helper::getUserIdentity();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="g-header">
    <div class="container">
        <div class="g-header__mobi-link js-activeOnOff" data-id="header">
            <span class="fal fa-bars"></span>
            <span class="fal fa-times"></span>
        </div>
        <div class="g-header__content">
            <div class="g-header__content-logo">
                <a href="<?= Yii::$app->homeUrl ?>" class="g-header__content-logo-link"></a>
            </div>

            <?php
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Vacancies', 'url' => ['/vacancy/index']],
                ['label' => 'Adjuncts', 'url' => ['/adjunct/index']],
                ['label' => 'Chats', 'url' => ['/chat/index']],
            ];

            if ($user) {
                $menuItems[] = ['label' => 'Profile', 'url' => ['/site/profile']];
            }

            echo Menu::widget([
                'options' => ['class' => 'g-header__content-menu'],
                'itemOptions' => ['class' => 'g-header__content-menu-item'],
                'items' => $menuItems,
                'linkTemplate' => '<a class="g-header__content-menu-item-link" href="{url}"><span>{label}</span></a>',
                'encodeLabels' => false,
                'activeCssClass' => 'active',
            ]);
            ?>

            <?php if ($user) : ?>
                <div class="g-header__content-user" id="userMenu">
                    <div class="g-header__content-user-link js-activeOnOff" data-id="userMenu">
                        <div class="g-header__content-user-link-ava">
                            <div class="g-header__content-user-link-ava-nopict fa fa-user"></div>
                            <img src="https://cdn.technicpack.net/platform2/pack-icons/827089.png?1460226445"
                                 class="g-header__content-user-link-ava-img" alt=""/>
                        </div>
                        <div class="g-header__content-user-link-name"><?= $user->getUsername() ?></div>
                        <div class="g-header__content-user-link-icon fa fa-chevron-down"></div>
                    </div>

                    <div class="g-header__content-user-menu">
                        <div class="g-header__content-user-menu-title">
                            Jobs
                        </div>

                        <div class="g-header__content-user-menu-block">
                            <div class="g-header__content-user-menu-block-item">
                                <a class="g-header__content-user-menu-block-item-link">
                                    Recommended jobs
                                </a>
                            </div>
                            <div class="g-header__content-user-menu-block-item">
                                <a class="g-header__content-user-menu-block-item-link">
                                    Saved jobs
                                </a>
                            </div>
                            <div class="g-header__content-user-menu-block-item">
                                <a class="g-header__content-user-menu-block-item-link">
                                    My responses
                                </a>
                            </div>
                            <div class="g-header__content-user-menu-block-item">
                                <a class="g-header__content-user-menu-block-item-link">
                                    Search jobs
                                </a>
                            </div>
                        </div>

                        <div class="g-header__content-user-menu-title">
                            Profile
                        </div>

                        <div class="g-header__content-user-menu-block">
                            <div class="g-header__content-user-menu-block-item">
                                <a href="" class="g-header__content-user-menu-block-item-link">
                                    Edit profile
                                </a>
                            </div>
                            <div class="g-header__content-user-menu-block-item">
                                <a href="" class="g-header__content-user-menu-block-item-link">
                                    My portfolio
                                </a>
                            </div>
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
            <?php else: ?>
                <div class="g-header__content-controls">
                    <div class="g-header__content-controls-one">
                        <a href="<?= Url::to(['/site/login'], true) ?>" class="g-header__content-controls-one-link">Sign
                            In</a>
                    </div>
                    <div class="g-header__content-controls-one">
                        <a href="<?= Url::to(['/site/signup'], true) ?>" class="g-header__content-controls-one-link">Sign
                            Up</a>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</header>

<div class="container">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="g-footer">
    <div class="g-footer__text">
        &copy; 2019 instructorshub.com
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
