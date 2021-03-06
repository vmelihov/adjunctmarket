<?php

use common\models\Vacancy;
use yii\helpers\Html;

/** @var Vacancy $model */

?>
<div class="g-vlist__one js-one">
    <div class="g-vlist__one-header">
        <?= Html::a(HTML::encode($model->title), ['/vacancy/view', 'id' => $model->id], ['class' => 'g-vlist__one-header-title']) ?>

        <div class="g-vlist__one-header-cat">
            <?= Html::encode("{$model->specialty->faculty->name} - {$model->specialty->name} / {$model->institution->profile->university->name}") ?>
        </div>

        <div class="g-vlist__one-header-right">
            <div class="g-vlist__one-header-right-views">
                <div class="g-vlist__one-header-right-views">
                    <span class="g-vlist__one-header-right-views-icon fal fa-eye"></span>
                    <span class="g-vlist__one-header-right-views-num"><?= $model->views ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="g-vlist__one-content">
        <div class="g-vlist__one-content-head">
            <div class="g-vlist__one-content-head-time">
                Posted <?= date('m/d/Y', $model->created) ?> -
                Proposals <?= count($model->proposals) ?>
            </div>
            <div class="g-vlist__one-content-head-control active js-view">
                <div class="g-vlist__one-content-head-control-text">
                    Expanded view
                    <br/>
                    Compact view
                </div>
            </div>
        </div>
        <div class="g-vlist__one-content-body js-body" style="display: none;">
            <?= nl2br(HTML::encode($model->description)) ?>
        </div>
    </div>

    <div class="g-vlist__one-footer js-footer">
        <div class="g-vlist__one-footer-column">
            <?php if ($model->teachType): ?>
                <div class="g-vlist__one-footer-item">
                    <span class="g-vlist__one-footer-item-name">Teaching experience:</span> <?= $model->teachType->name ?>
                </div>
            <?php endif; ?>

            <?php if ($model->education): ?>
                <div class="g-vlist__one-footer-item">
                    <span class="g-vlist__one-footer-item-name">Education:</span> <?= $model->education->name ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="g-vlist__one-footer-column">
            <?php if ($model->teachTime): ?>
                <div class="g-vlist__one-footer-item">
                    <span class="g-vlist__one-footer-item-name">Type of teaching:</span> <?= $model->teachTime->name ?>
                </div>
            <?php endif; ?>

            <?php if ($model->area): ?>
                <div class="g-vlist__one-footer-item">
                    <span class="g-vlist__one-footer-item-name">Location:</span> <?= $model->area->state->name . ', ' . $model->area->name ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="g-vlist__one-footer-column">
            <?php if ($model->teachPeriod): ?>
                <div class="g-vlist__one-footer-item">
                    <span class="g-vlist__one-footer-item-name">Type of teaching:</span> <?= $model->teachPeriod->name ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>