<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
?>

<div class="g-header__content-user-menu-item">
    <a href="#" class="g-header__content-user-menu-item-link" onclick="$('#verstalaNeMojetSverstatKnopku').submit()">Log
        Out</a>
</div>

<div style="display: none">
    <?=
    Html::beginForm(['/site/logout'], 'post', ['id' => 'verstalaNeMojetSverstatKnopku'])
    . Html::submitButton(
        'Log Out',
        ['class' => 'g-header__content-user-menu-out-link logout']
    )
    . Html::endForm()
    ?>
</div>