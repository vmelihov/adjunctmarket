<?php

use common\models\Chat;
use common\src\helpers\Helper;
use common\src\helpers\UserImageHelper;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

$this->title = $model->title;
$this->registerCssFile('@web/css/single-job-adjunct.css', ['depends' => [AppAsset::class]]);
YiiAsset::register($this);

$user = Helper::getUserIdentity();
$institution = $model->institution;

if ($chat = Chat::findForVacancyAndAdjunct($model->id, $user->getId())) {
    $chatUrl = Url::to(['/chat/view', 'chatId' => $chat->id], true);
} else {
    $chatUrl = Url::to(['/chat/create', 'param' => $model->id], true);
}

?>

<div class="p-sja">
    <div class="p-sja__settings">
        <div class="p-sja__settings-ava">
            <img src="<?= UserImageHelper::getUserImageUrl($institution) ?>" alt="" class="p-sja__settings-ava-img"/>
        </div>

        <div class="p-sja__settings-name">
            <?= Html::encode($institution->profile->university->name) ?>
        </div>
        <div class="p-sja__settings-status">
            <?= Html::encode($institution->getUsername()) ?>
            <?= $institution->profile->position ? ' - ' . Html::encode($institution->profile->position) : '' ?>
        </div>

        <div class="p-sja__settings-right">
            <div class="p-sja__settings-right-chat">
                <span class="fa fa-envelope p-sja__settings-right-chat-icon"></span>
                <a class="p-sja__settings-right-chat-link" href="<?= $chatUrl ?>">Start chatting</a>
            </div>
        </div>
    </div>

    <div class="p-sja__content">
        <div class="p-sja__content-title">
            <?= Html::encode($model->title) ?>
        </div>

        <div class="p-sja__content-text">
            <?= Html::encode($model->description) ?>
        </div>

        <div class="p-sja__content-params">
            <div class="p-sja__content-params-one">
                <span class="p-sja__content-params-one-title">Category:</span>
                <span class="p-sja__content-params-one-text">
                    <?= Html::encode($model->specialty->faculty->name) ?> /
                    <?= Html::encode($model->specialty->name) ?>
                </span>
            </div>

            <?php if ($model->teachType): ?>
                <div class="p-sja__content-params-one">
                    <span class="p-sja__content-params-one-title">Teaching experience:</span>
                    <span class="p-sja__content-params-one-text"><?= Html::encode($model->teachType->name) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($model->education): ?>
                <div class="p-sja__content-params-one">
                    <span class="p-sja__content-params-one-title">Education:</span>
                    <span class="p-sja__content-params-one-text"><?= Html::encode($model->education->name) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($model->teachPeriod): ?>
                <div class="p-sja__content-params-one">
                    <span class="p-sja__content-params-one-title">Type of teaching:</span>
                    <span class="p-sja__content-params-one-text"><?= Html::encode($model->teachPeriod->name) ?></span>
                </div>
            <?php endif; ?>


            <?php if ($model->teachTime): ?>
                <div class="p-sja__content-params-one">
                    <span class="p-sja__content-params-one-title">Time of teaching:</span>
                    <span class="p-sja__content-params-one-text"><?= Html::encode($model->teachTime->name) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($model->area): ?>
                <div class="p-sja__content-params-one">
                    <span class="p-sja__content-params-one-title">Location:</span>
                    <span class="p-sja__content-params-one-text"><?= Html::encode($model->area->name) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-sja__content-posted">
            <div class="p-sja__content-posted-title">
                Posted:
            </div>
            <div class="p-sja__content-posted-text">
                <?= date('g:m A m/d/y', $model->created) ?>
                (last changes <?= date('g:m A m/d/y', $model->updated) ?>)
            </div>
        </div>

        <div class="p-sja__content-btns">
            <a href="" class="p-sja__content-btns-one" data-toggle="modal" data-target="#modal">Apply
                for job</a>
            <a href="<?= Url::to(['index']) ?>" class="p-sja__content-btns-link">See other Vacancies</a>
        </div>
    </div>
</div>

