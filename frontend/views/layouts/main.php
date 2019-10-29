<?php

/* @var $this View */
/* @var $content string */

use common\src\helpers\Helper;
use yii\helpers\Html;
use yii\web\View;
use frontend\assets\AppAsset;

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
            if (!$user) {
                echo $this->render('_menuGuest', ['user' => null]);
            } elseif ($user->isInstitution()) {
                echo $this->render('_menuInstitution', ['user' => $user]);
            } elseif ($user->isAdjunct()) {
                echo $this->render('_menuAdjunct', ['user' => $user]);
            }
            ?>

        </div>
    </div>
</header>

<div class="container">
    <?php // Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="g-footer">
    <div class="g-footer__part">
        <div class="g-footer__part-text">
            &copy; 2019 <a href="/">instructorshub.com</a>
        </div>
        <div class="g-footer__part-text">
            <a href="">Privacy Policy</a>
        </div>
    </div>

    <div class="g-footer__part">
        <?php if ($user): ?>
            <div class="g-footer__part-text">
                <a href="/">How it Works</a>
            </div>
        <?php endif; ?>
        <div class="g-footer__part-text">
            <i class="fal fa-keyboard"></i> <a href="">Support</a>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
