<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use frontend\models\Relevance\AdjunctVacancyRelevance;
use frontend\models\VacanciesSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $vacancies Vacancy[] */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel VacanciesSearch */

$this->title = 'Vacancies';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/feed-auth.css', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/vacancy-card.js', ['depends' => [AppAsset::class]]);

$user = Helper::getUserIdentity();
$relevance = new AdjunctVacancyRelevance($user->profile);
?>
<div class="p-feed">
    <h1 class="p-jobs__title"><?= Html::encode($this->title) ?></h1>

    <div class="p-feed__filter">
        <div class="p-feed__filter-vacancies js-vacancies">
            <a href="<?= Url::to(['vacancy/index']) ?>" class="p-feed__filter-vacancies-chosen">
                <div class="p-feed__filter-vacancies-chosen-text">All Vacancies</div>
                <div class="p-feed__filter-vacancies-chosen-icon fal fa-chevron-down"></div>
            </a>

            <a href="<?= Url::to(['index', 'ff' => VacanciesSearch::FAST_FILTER_RECOMMENDED]) ?>"
               class="p-feed__filter-vacancies-chosen">
                <div class="p-feed__filter-vacancies-chosen-text">Recomended</div>
                <div class="p-feed__filter-vacancies-chosen-icon fal fa-chevron-down"></div>
            </a>
        </div>

        <div class="p-feed__filter-sort">
            <input type="hidden" class="js-sortInput"/>
            <div class="p-feed__filter-sort-text">Sort:</div>
            <div class="p-feed__filter-sort-drop dropdown">
                <div class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="p-feed__filter-sort-drop-chosen">
                        <div class="p-feed__filter-sort-drop-chosen-text js-sortText">
                            Fewest proposals
                        </div>
                        <div class="p-feed__filter-sort-drop-chosen-icon fal fa-chevron-down">
                        </div>
                    </div>
                </div>
                <div class="dropdown-menu js-sortItems">
                    <div class="dropdown-item" data-form="proposals">Fewest proposals</div>
                    <div class="dropdown-item" data-form="newest">Newest</div>
                    <div class="dropdown-item" data-form="relevance">Relevance</div>
                </div>
            </div>
        </div>

        <div class="p-feed__filter-options js-openFilter">
            <span class="p-feed__filter-options-text">
                Search options
            </span>
            <span class="p-feed__filter-options-icon far fa-sliders-h"></span>
        </div>
    </div>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <div id="itemList" class="g-vlist">
        <?php foreach ($dataProvider->getModels() as $vacancy) : ?>
            <?= $this->render('_one_adjunct', ['model' => $vacancy, 'adjunct' => $user->profile]) ?>
        <?php endforeach; ?>
    </div>

    <?php if ($dataProvider->getPagination()->getPageCount() > 1) : ?>
        <?= $this->render('_show_more', ['pageCount' => $dataProvider->pagination->pageCount - 1]) ?>
    <?php endif; ?>
</div>
