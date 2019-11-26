<?php

use common\models\Adjunct;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use frontend\models\AdjunctSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $this View */
/** @var $searchModel AdjunctSearch */
/** @var $dataProvider ActiveDataProvider */
/** @var $favorites Adjunct[] */

$this->registerCssFile('@web/css/adjuncts-list.css', ['depends' => [AppAsset::class]]);

$this->title = 'Adjuncts List';

$user = Helper::getUserIdentity();
?>

<div class="p-al container">
    <h1 class="p-al__title"><?= Html::encode($this->title) ?></h1>

    <div class="p-al__filter">
        <a class="p-al__filter-sort-link active" data-value="p-al_list-all">All <span>Adjuncts</span>
            (<?= $dataProvider->getTotalCount() ?>)</a>
        <a class="p-al__filter-sort-link" data-value="p-al_list-favorites">Favorite <span>Adjuncts</span>
            (<?= count($favorites) ?>)</a>

        <!--        <label class="p-al__filter-free ui-checkbox">-->
        <!--            <input type="checkbox" name="">-->
        <!--            <span class="ui-checkbox__decor"></span>-->
        <!--            <span class="ui-checkbox__text">Free <span>in that moment</span></span>-->
        <!--        </label>-->

        <div class="p-al__filter-options js-openFilter">
                <span class="p-al__filter-options-text">
                    Search options
                </span>
            <span class="p-al__filter-options-icon far fa-sliders-h"></span>
        </div>
    </div>

    <?= $this->render('_search.php', ['model' => $searchModel]) ?>

    <div class="p-al__list p-al_list-all">
        <?php foreach ($dataProvider->getModels() as $adjunct): ?>
            <?= $this->render('_one', [
                'adjunct' => $adjunct,
                'user' => $user,
                'isFavorite' => $user->profile->isFavoriteAdjunct($adjunct->id),
            ]) ?>
        <?php endforeach; ?>
    </div>

    <div class="p-al__list p-al_list-favorites" style="display: none">
        <?php foreach ($favorites as $favorite): ?>
            <?= $this->render('_one', [
                'adjunct' => $favorite,
                'user' => $user,
                'isFavorite' => true,
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>

<?php
$ajaxUrl = Url::to(['institution/favorite']);
$script = <<< JS
$(".js-openFilter").on("click", function () {
    $(this).toggleClass("active");
    $(".js-filterContent").slideToggle();
});

$('.js-selectize').selectize({
    create: true,
    sortField: 'text'
});

$(".p-al__filter-sort-link").on("click", function () {
    let element = $(this);
    let listClass = element.attr('data-value');
    
    if (element.hasClass('active')) {
        return false;
    }
    
    $('.p-al__list').hide();
    $('.' + listClass).show();
    $(".p-al__filter-sort-link").toggleClass('active');
});

$(".p-al__list-one-content-block-fav").on("click", function () {
    let element = $(this);
    let action = element.hasClass('fas') ? 'remove' : 'save';
    let id = element.attr('data-value');

    if (!id) {
        return false;
    }

    $.ajax({
       type: 'post',
       url: '$ajaxUrl',
       data: {
           'adjunctId': id,
           'action': action,
       },
       success: function() {
           element.toggleClass("fas");
       }
    });

});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>