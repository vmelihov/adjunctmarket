<?php

use common\models\Chat;
use common\models\Vacancy;
use common\src\helpers\Helper;
use common\src\helpers\UserImageHelper;
use frontend\assets\AppAsset;
use frontend\forms\ProposalForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\View;

/* @var $this View */
/* @var $model Vacancy */

$this->title = $model->title;
try {
    $this->registerCssFile('@web/css/single-job-adjunct.css', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$user = Helper::getUserIdentity();
$institution = $model->institution;

if ($chat = Chat::findByInstitutionAndAdjunct($model->institution_user_id, $user->getId())) {
    $countUnreadMessages = $chat->getCountUnreadMessagesForUserId($user->getId());
    $chatAttr = 'href="#" onclick="openChat(' . $chat->id . ')"';
} else {
    $chatAttr = 'href="' . Url::to(['/chat/create', 'param' => $model->institution_user_id], true) . '"';
}

$proposalForm = new ProposalForm();
$proposalForm->adjunct_id = $user->getId();
$proposalForm->vacancy_id = $model->id;
$proposalForm->state = 1;

$proposal = $model->getProposalForAdjunct($user->getId());
?>

<div class="p-sja">
    <div class="p-sja__settings">
        <div class="p-sja__settings-ava">
            <img src="<?= UserImageHelper::getUrl($institution) ?>" alt="" class="p-sja__settings-ava-img"/>
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
                <a class="p-sja__settings-right-chat-link" <?= $chatAttr ?>>Start chatting</a>
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
            <?php if (!$proposal): ?>
                <a href="" class="p-sja__content-btns-one" data-toggle="modal" data-target="#modal">Apply for job</a>
            <?php endif; ?>
            <a href="<?= Url::to(['index']) ?>" class="p-sja__content-btns-link">See other Vacancies</a>
        </div>
    </div>
</div>

<?php if (!$proposal): ?>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="p-sja__modal">
                <div class="p-sja__modal-header">
                    <div class="p-sja__modal-header-title">
                        Your Proposal
                    </div>
                    <div class="p-sja__modal-header-close fal fa-times" data-dismiss="modal" aria-label="Close"></div>
                </div>
                <div class="p-sja__modal-content">
                    <?= $this->render('@frontend/views/proposal/create', ['model' => $proposalForm]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    $script = <<< JS
    $(".js-fav").on("click", function () {
        $(this).toggleClass("fas");
    });
JS;
    $this->registerJs($script, yii\web\View::POS_READY);
    ?>

<?php else: ?>

    <?php $institution = $proposal->vacancy->institution; ?>

    <div class="p-sja-proposals">
        <div class="p-sja-proposals__title">
            Your Proposal
        </div>

        <div class="p-sja-proposals__content">
            <div class="p-sja-proposals__content-one">
                <div class="p-sja-proposals__content-one-header">
                    <div class="p-sja-proposals__content-one-header-left">
                        <div class="p-sja-proposals__content-one-header-left-ava">
                            <img src="<?= UserImageHelper::getUrl($institution) ?>" alt=""
                                 class="p-sja-proposals__content-one-header-left-ava-img">
                        </div>
                        <a href="" class="p-sja-proposals__content-one-header-left-name">
                            <?= Html::encode($institution->getUsername()) ?>
                        </a>

                        <?php /*
                    <div class="p-sja-proposals__content-one-header-left-date">
                        12:10 PM 03.25.2019
                    </div>
                    */ ?>
                    </div>

                    <?php if ($chat): ?>
                        <div class="p-sja-proposals__content-one-header-right">
                            <div class="p-sja-proposals__content-one-header-right-item">
                                <a <?= $chatAttr ?> class="p-sja-proposals__content-one-header-right-item-link">
                                    <span class="fal fa-envelope"></span>
                                    <span class="p-sja-proposals__content-one-header-right-item-link-text"><?= $countUnreadMessages ?> new message</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="p-sja-proposals__content-one-content">
                    <div class="p-sja-proposals__content-one-content-text">
                        <?= Html::encode($proposal->letter) ?>
                    </div>
                    <?php if ($attaches = $proposal->getAttachesUrlArray()): ?>
                        <div class="p-sja-proposals__content-one-content-attachments">
                            Attachments:
                            <?php foreach ($attaches as $name => $url): ?>
                                <?= "<a href=\"$url\" download>$name</a>;" ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-sja-proposals__content-one-footer">
                    <a href="<?= Url::to(['proposal/edit', 'id' => $proposal->id]) ?>"
                       class="p-sja-proposals__content-one-footer-edit">
                        Edit Proposal
                    </a>
                    <a href="<?= Url::to(['proposal/delete', 'id' => $proposal->id]) ?>"
                       class="p-sja-proposals__content-one-footer-delete">
                        Delete Proposal
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>