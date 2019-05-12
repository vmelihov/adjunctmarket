<?php

use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

$this->title = $model->title;
$this->registerCssFile('@web/css/one-job.css', ['depends' => [AppAsset::class]]);
YiiAsset::register($this);

$user = Helper::getUserIdentity();
?>

<div class="p-job g-content">

    <h1 class="g-mb10"><?= Html::encode("#{$model->id} {$this->title}") ?></h1>

    <a href="<?= Url::to(['/vacancy/index'], true) ?>" class="p-job__back">&#139; back jobs list</a>

    <?php if ($user->isInstitution()): ?>
        <p>
            <?= Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->id]) ?>
            <?= Html::a('<span class="fa fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <p class="p-job__content">
        <?= Html::encode($model->description) ?>
    </p>

    <div class="p-job__footer">
        <div class="p-job__footer-column">
            <div class="p-job__footer-item">
                <span class="p-job__footer-item-name">Category:</span> <?= Html::encode($model->specialty->getNameWithFaculty()) ?>
            </div>
            <div class="p-job__footer-item">
                <span class="p-job__footer-item-name">Teaching experience:</span> <?= Html::encode($model->teachType->name) ?>
            </div>
            <div class="p-job__footer-item">
                <span class="p-job__footer-item-name">Education:</span> <?= Html::encode($model->education->name) ?>
            </div>
        </div>

        <div class="p-job__footer-column">
            <div class="p-job__footer-item">
                <span class="p-job__footer-item-name">Type of teaching:</span> <?= Html::encode($model->teachPeriod->name) ?>
            </div>
            <div class="p-job__footer-item">
                <span class="p-job__footer-item-name">Location:</span> <?= Html::encode($model->area->getNameWithState()) ?>
            </div>
            <div class="p-job__footer-item">
                <span class="p-job__footer-item-name">University:</span> <?= Html::encode($model->institution->university->name) ?>
            </div>
        </div>
    </div>

    <div class="p-job__proposals">
    </div>

    <div class="p-job__add-proposal">
    </div>

</div>
