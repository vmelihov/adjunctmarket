<?php

use common\models\Vacancy;
use common\src\helpers\DateTimeHelper;
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

    <div class="g-vlist">
        <?php
        /** @var Vacancy $vacancy */
        foreach ($dataProvider->getModels() as $vacancy) : ?>
            <div class="g-vlist__one js-one">
                <div class="g-vlist__one-header">
                    <?= Html::a(HTML::encode($vacancy->title), ['view', 'id' => $vacancy->id], ['class' => 'g-vlist__one-header-title']) ?>

                    <div class="g-vlist__one-header-cat">
                        <?= Html::encode("{$vacancy->specialty->faculty->name} - {$vacancy->specialty->name} / {$vacancy->user->profile->university->name}") ?>
                    </div>

                    <div class="g-vlist__one-header-right">
                        <div class="g-vlist__one-header-right-views">
                            <div class="g-vlist__one-header-right-views">
                                <span class="g-vlist__one-header-right-views-icon fal fa-eye"></span>
                                <span class="g-vlist__one-header-right-views-num"><?= $vacancy->views ?></span>
                            </div>
                        </div>

                        <div class="g-vlist__one-header-right-fav fal fa-heart js-fav"></div>
                    </div>
                </div>

                <div class="g-vlist__one-content">
                    <div class="g-vlist__one-content-head">
                        <div class="g-vlist__one-content-head-time">
                            Posted <?= DateTimeHelper::getTimeAgo($vacancy->created) ?? '-' ?> minutes ago - Proposals
                            12
                        </div>
                        <div class="g-vlist__one-content-head-control active js-view">
                            <div class="g-vlist__one-content-head-control-text">
                                Expanded view
                                <br/>
                                Compact view
                            </div>
                        </div>
                    </div>
                    <div class="g-vlist__one-content-body js-body">
                        <?= HTML::encode($vacancy->description) ?>
                    </div>
                </div>

                <div class="g-vlist__one-footer js-footer">
                    <div class="g-vlist__one-footer-column">
                        <div class="g-vlist__one-footer-item">
                            <span class="g-vlist__one-footer-item-name">Teaching experience:</span> <?= $vacancy->teachType->name ?>
                        </div>
                        <div class="g-vlist__one-footer-item">
                            <span class="g-vlist__one-footer-item-name">Education:</span> <?= $vacancy->education->name ?>
                        </div>
                    </div>

                    <div class="g-vlist__one-footer-column">
                        <div class="g-vlist__one-footer-item m-none">
                            <span class="g-vlist__one-footer-item-name">Type of teaching:</span> <?= $vacancy->teachTime->name ?>
                        </div>
                        <div class="g-vlist__one-footer-item">
                            <span class="g-vlist__one-footer-item-name">Location:</span> <?= $vacancy->area->state->name . ', ' . $vacancy->area->name ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="p-feed__load">
        <div class="p-feed__load-btn">Load More Vacancies</div>
    </div>
</div>
