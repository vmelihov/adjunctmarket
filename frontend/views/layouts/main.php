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
            <div class="g-header__content">
                <div class="g-header__content-logo">
                    <a href="<?= Yii::$app->homeUrl ?>" class="g-header__content-logo-link">
                        ADJUNCT
                        <span>MARKET</span>
                    </a>
                </div>

                <div class="g-header__content-mobi" id="headerMobi">
                    <span class="fa fa-bars g-header__content-mobi-link js-activeOnOff" data-id="headerMobi"></span>

                    <div class="g-header__content-mobi-menu">
                        <?php
                        $menuItems = [
                            ['label' => 'Home', 'url' => ['/site/index']],
                            ['label' => 'Vacancies', 'url' => ['/vacancy/index']],
                            ['label' => 'Adjuncts', 'url' => ['/adjunct/index']],
                            ['label' => 'Chats', 'url' => ['/chat/index']],
                            ['label' => 'Home', 'url' => ['/site/index']],
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
                        <div class="g-header__content-controls">
                            <?php if ($user) : ?>
                                <?=
                                '<li>'
                                . Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                    'Logout (' . $user->getUsername() . ')',
                                    ['class' => 'btn btn-link logout']
                                )
                                . Html::endForm()
                                . '</li>'
                                ?>
                            <?php else: ?>
                                <div class="g-header__content-controls-one">
                                    <a href="<?= Url::to(['/site/login'], true) ?>"
                                       class="g-header__content-controls-one-link">Sign In</a>
                                </div>
                                <div class="g-header__content-controls-one">
                                    <a href="<?= Url::to(['/site/signup'], true) ?>"
                                       class="g-header__content-controls-one-link">Sign Up</a>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<div class="container">
    <div class="g-content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="g-footer">
    <div class="g-footer__text">
        &copy; 2019
        <br/>
        adjunctmarket.com
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
