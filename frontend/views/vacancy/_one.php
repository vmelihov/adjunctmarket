<?php

use common\models\Vacancy;
use common\src\helpers\DateTimeHelper;
use yii\helpers\Html;

/** @var Vacancy $model */

?>
<div class="g-vlist__one js-one">
    <div class="g-vlist__one-header">
        <?= Html::a(HTML::encode($model->title), ['view', 'id' => $model->id], ['class' => 'g-vlist__one-header-title']) ?>

        <div class="g-vlist__one-header-cat">
            <?= Html::encode("{$model->specialty->faculty->name} - {$model->specialty->name} / {$model->user->profile->university->name}") ?>
        </div>

        <div class="g-vlist__one-header-right">
            <div class="g-vlist__one-header-right-views">
                <div class="g-vlist__one-header-right-views">
                    <span class="g-vlist__one-header-right-views-icon fal fa-eye"></span>
                    <span class="g-vlist__one-header-right-views-num"><?= $model->views ?></span>
                </div>
            </div>

            <div class="g-vlist__one-header-right-fav fal fa-heart js-fav"></div>
        </div>
    </div>

    <div class="g-vlist__one-content">
        <div class="g-vlist__one-content-head">
            <div class="g-vlist__one-content-head-time">
                Posted <?= DateTimeHelper::getTimeAgo($model->created) ?? '-' ?> minutes ago - Proposals 12
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
            <?= HTML::encode($model->description) ?>
        </div>
    </div>

    <div class="g-vlist__one-footer js-footer">
        <div class="g-vlist__one-footer-column">
            <div class="g-vlist__one-footer-item">
                <span class="g-vlist__one-footer-item-name">Teaching experience:</span> <?= $model->teachType ? $model->teachType->name : '' ?>
            </div>
            <div class="g-vlist__one-footer-item">
                <span class="g-vlist__one-footer-item-name">Education:</span> <?= $model->education ? $model->education->name : '' ?>
            </div>
        </div>

        <div class="g-vlist__one-footer-column">
            <div class="g-vlist__one-footer-item m-none">
                <span class="g-vlist__one-footer-item-name">Type of teaching:</span> <?= $model->teachTime ? $model->teachTime->name : '' ?>
            </div>
            <div class="g-vlist__one-footer-item">
                <span class="g-vlist__one-footer-item-name">Location:</span> <?= $model->area ? $model->area->state->name . ', ' . $model->area->name : '' ?>
            </div>
        </div>
    </div>
</div>