<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use common\src\helpers\UserImageHelper;
use frontend\assets\AppAsset;
use frontend\models\VacanciesSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\View;

/* @var $this View */
/* @var $vacancies Vacancy[] */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel VacanciesSearch */

$this->title = 'Vacancies';
$this->params['breadcrumbs'][] = $this->title;

try {
    $this->registerCssFile('@web/css/profile-institution.css', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/profile-institution.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/vacancy-card.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/validation.js', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$user = Helper::getUserIdentity();
$favorites = $user->profile->getFavoriteAdjuncts();
?>
<div class="p-prflinst">
    <div class="p-prflinst__filter">
        <h1 class="p-prflinst__filter-title">My Vacancies</h1>
        <div class="p-prflinst__filter-vacancies js-vacancies">
            <div class="p-prflinst__filter-vacancies-chosen js-vacanciesBtn">
                <div class="p-prflinst__filter-vacancies-chosen-text js-vacanciesBtnText">
                    <?= Html::a("All Vacancies ({$dataProvider->getTotalCount()})", ['index']) ?>
                </div>
                <div class="p-prflinst__filter-vacancies-chosen-icon fal fa-chevron-down"></div>
            </div>

            <div class="p-prflinst__filter-vacancies-list js-vacanciesList">
                <div class="p-prflinst__filter-vacancies-list-one">
                    <?= Html::a('All Vacancies', ['index']) ?>
                </div>
                <div class="p-prflinst__filter-vacancies-list-one">
                    <?= Html::a('Actual vacancies', ['index', 'ff' => VacanciesSearch::FAST_FILTER_ACTUAL]) ?>
                </div>
                <div class="p-prflinst__filter-vacancies-list-one">
                    <?= Html::a('Archive', ['index', 'ff' => VacanciesSearch::FAST_FILTER_ARCHIVE]) ?>
                </div>
            </div>
        </div>

        <div class="p-prflinst__filter-add">
            <a href="<?= Url::to(['vacancy/create']) ?>" class="p-prflinst__filter-add-link">Publish a vacancy</a>
        </div>
    </div>

    <?php if ($dataProvider->getTotalCount() === 0): ?>
        <div class="p-prflinst__nov">
            You don’t have any created vacancies. <a href="<?= Url::to(['vacancy/create']) ?>">Create</a> your fist
            vacancy to start searching
            an adjuncts
        </div>
    <?php else: ?>
        <div id="itemList" class="g-vlist">
            <?php foreach ($dataProvider->getModels() as $vacancy) : ?>
                <?= $this->render('_one_institution', ['model' => $vacancy]) ?>
            <?php endforeach; ?>
        </div>

        <?php if ($dataProvider->getPagination()->getPageCount() > 1) : ?>
            <?= $this->render('_show_more', ['pageCount' => $dataProvider->pagination->pageCount - 1]) ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($favorites): ?>
        <div class="p-prflinst__fav">
            <div class="p-prflinst__fav-title">
                Favorite adjuncts
            </div>

            <?php foreach ($favorites as $favorite): ?>
                <div class="p-prflinst__fav-one">
                    <img src="<?= UserImageHelper::getUrl($favorite->user) ?>" class="p-prflinst__fav-one-ava" alt=""/>
                    <a href="" class="p-prflinst__fav-one-link">
                        <div class="p-prflinst__fav-one-link-name">
                            <?= Html::encode($favorite->user->first_name) ?>
                        </div>
                        <div class="p-prflinst__fav-one-link-name">
                            <?= Html::encode($favorite->user->last_name) ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
