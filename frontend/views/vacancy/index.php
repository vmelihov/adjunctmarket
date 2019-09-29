<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use frontend\models\VacancySearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $vacancies Vacancy[] */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel VacancySearch */

$this->registerCssFile('@web/css/jobs.css', ['depends' => [AppAsset::class]]);

$this->title = 'Vacancies';
$this->params['breadcrumbs'][] = $this->title;

$user = Helper::getUserIdentity();
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
                    All Vacancies
                </div>
                <div class="p-feed__filter-vacancies-list-one">
                    Recomended
                </div>
                <div class="p-feed__filter-vacancies-list-one">
                    Saved
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

    <?php if ($user->isInstitution()): ?>
        <?= Html::a('Create Vacancy', ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>

    <div class="p-jobs__list">
        <?php foreach ($dataProvider->getModels() as $vacancy) : ?>
            <div class="p-jobs__list-one">
                <div class="p-jobs__list-one-name">
                    <?= Html::encode("#{$vacancy->id} {$vacancy->title}") ?>
                </div>
                <div class="p-jobs__list-one-cat">
                    <?= Html::encode("{$vacancy->specialty->faculty->name} - {$vacancy->specialty->name} / {$vacancy->user->profile->university->name}") ?>
                </div>
                <div class="p-jobs__list-one-btns">
                    <?= Html::a('<span class="fa fa-envelope-open-text"></span>', ['view', 'id' => $vacancy->id]) ?>
                    <?php if ($user->isInstitution()): ?>
                        <?= Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $vacancy->id]) ?>
                        <?= Html::a('<span class="fa fa-trash-alt"></span>', ['delete', 'id' => $vacancy->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php endif; ?>
                </div>
                <div class="p-jobs__list-one-stats">
                    <div class="p-jobs__list-one-stats-date">
                        <?= date('d/m/Y', $vacancy->updated) ?>
                    </div>
                    <div class="p-jobs__list-one-stats-views">
                        Views: <?= $vacancy->views ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
