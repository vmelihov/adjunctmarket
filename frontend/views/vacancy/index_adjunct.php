<?php

use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use frontend\models\Relevance\AdjunctVacancyRelevance;
use frontend\models\VacanciesSearch;
use frontend\src\DataProviderWithSort;
use yii\helpers\Html;
use yii\log\Logger;

/* @var $this yii\web\View */
/* @var $dataProvider DataProviderWithSort */
/* @var $searchModel VacanciesSearch */

$this->title = 'Vacancies';
$this->params['breadcrumbs'][] = $this->title;

try {
    $this->registerCssFile('@web/css/feed-auth.css', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/vacancy-card.js', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$user = Helper::getUserIdentity();
$relevance = new AdjunctVacancyRelevance($user->profile);
?>
<div class="p-feed">
    <h1 class="p-jobs__title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <div id="itemList" class="g-vlist">
        <?php foreach ($dataProvider->getModels() as $vacancy) : ?>
            <?= $this->render('_one_adjunct', [
                'model' => $vacancy,
                'adjunct' => $user->profile
            ]) ?>
        <?php endforeach; ?>
    </div>

    <?php $pages = $dataProvider->getPagination()->getPageCount();
    if ($pages > 1) : ?>
        <?= $this->render('_show_more', ['pageCount' => $pages - 1]) ?>
    <?php endif; ?>
</div>
