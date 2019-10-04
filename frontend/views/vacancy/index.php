<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use frontend\models\VacancySearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

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

    <div id="itemList" class="g-vlist">
        <?php foreach ($dataProvider->getModels() as $vacancy) : ?>
            <?= $this->render('_one', ['model' => $vacancy]) ?>
        <?php endforeach; ?>
    </div>

    <?php if ($dataProvider->getPagination()->getPageCount() > 1) : ?>
        <div class="p-feed__load">
            <div id="showMore" class="p-feed__load-btn">Load More Vacancies</div>
        </div>

        <?php
        $page = (int)Yii::$app->request->get('page', 0);
        $pageCount = $dataProvider->pagination->pageCount - 1;

        $script = <<< JS
        // запоминаем текущую страницу и их максимальное количество
        var page = parseInt('$page');
        var pageCount = parseInt('{$pageCount}');
        var loadingFlag = false;
    
        $('#showMore').click(function() {
            if (!loadingFlag) {
                // выставляем блокировку
                loadingFlag = true;
                
                $.ajax({
                    type: 'post',
                    url: window.location.href,
                    data: {
                        // передаём номер нужной страницы методом POST
                        'page': page + 1,
                    },
                    success: function(data) {
                        // увеличиваем номер текущей страницы и снимаем блокировку
                        page++;
                        loadingFlag = false;
    
                        // вставляем полученные записи после имеющихся в наш блок
                        $('#itemList').append(data);

                        // если достигли максимальной страницы, то прячем кнопку
                        if (page >= pageCount) {
                            $('#showMore').hide();
                        }
                    }
                });
            }
            return false;
        })
JS;
        $this->registerJs($script, View::POS_READY);
        ?>
    <?php endif; ?>
</div>
