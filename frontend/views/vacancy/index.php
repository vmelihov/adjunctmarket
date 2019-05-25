<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $vacancies Vacancy[] */

$this->registerCssFile('@web/css/jobs.css', ['depends' => [AppAsset::class]]);

$this->title = 'Jobs';
$this->params['breadcrumbs'][] = $this->title;

$user = Helper::getUserIdentity();
?>
<div class="vacancy-index">
    <div class="p-jobs g-content">
        <h1 class="p-jobs__title"><?= Html::encode($this->title) ?></h1>

        <?php if ($user->isInstitution()): ?>
            <?= Html::a('Create Vacancy', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>

        <div class="p-jobs__list">
            <?php foreach ($vacancies as $vacancy) : ?>
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
</div>
