<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use frontend\models\Relevance\AdjunctVacancyRelevance;
use frontend\models\VacancySearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $vacancies Vacancy[] */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel VacancySearch */

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
            <div class="p-feed__filter-vacancies-chosen js-vacanciesBtn">
                <div class="p-feed__filter-vacancies-chosen-text js-vacanciesBtnText">
                    All Vacancies
                </div>
                <div class="p-feed__filter-vacancies-chosen-icon fal fa-chevron-down"></div>
            </div>

            <div class="p-feed__filter-vacancies-list js-vacanciesList">
                <div class="p-feed__filter-vacancies-list-one">
                    <?= Html::a('All Vacancies', ['index']) ?>
                </div>
                <div class="p-feed__filter-vacancies-list-one">
                    <?= Html::a('Recomended', ['index', 'ff' => VacancySearch::FAST_FILTER_RECOMMENDED]) ?>
                </div>
            </div>
        </div>

        <div class="p-feed__filter-sort">
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
                    <div class="dropdown-item">Fewest proposals</div>
                    <div class="dropdown-item">Newest</div>
                    <div class="dropdown-item">Relevance</div>
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
