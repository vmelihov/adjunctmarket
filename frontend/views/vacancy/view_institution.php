<?php

use common\models\Vacancy;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model Vacancy */

$this->title = $model->title;
$this->registerCssFile('@web/css/single-job.css', ['depends' => [AppAsset::class]]);

$user = Helper::getUserIdentity();
$proposals = $model->proposals;
$savedProposal = [];
foreach ($proposals as $prop) {
    if ($model->isSavedProposal($prop->id)) {
        $savedProposal[] = $prop;
    }
}
$suitableAdjuncts = [];
?>

    <div class="p-sj">
        <div class="p-sj__content">
            <div class="p-sj__content-title">
                <?= Html::encode($model->title) ?>
            </div>

            <div class="p-sj__content-text">
                <?= Html::encode($model->description) ?>
            </div>

            <div class="p-sj__content-params">
                <div class="p-sj__content-params-one">
                    <span class="p-sj__content-params-one-title">Category:</span>
                    <span class="p-sj__content-params-one-text">
                <?= Html::encode($model->specialty->faculty->name) ?> /
                <?= Html::encode($model->specialty->name) ?>
            </span>
                </div>

                <?php if ($model->teachType): ?>
                    <div class="p-sj__content-params-one">
                        <span class="p-sj__content-params-one-title">Teaching experience:</span>
                        <span class="p-sj__content-params-one-text"><?= Html::encode($model->teachType->name) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($model->education): ?>
                    <div class="p-sj__content-params-one">
                        <span class="p-sj__content-params-one-title">Education:</span>
                        <span class="p-sj__content-params-one-text"><?= Html::encode($model->education->name) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($model->teachPeriod): ?>
                    <div class="p-sj__content-params-one">
                        <span class="p-sj__content-params-one-title">Type of teaching:</span>
                        <span class="p-sj__content-params-one-text"><?= Html::encode($model->teachPeriod->name) ?></span>
                    </div>
                <?php endif; ?>


                <?php if ($model->teachTime): ?>
                    <div class="p-sj__content-params-one">
                        <span class="p-sj__content-params-one-title">Time of teaching:</span>
                        <span class="p-sj__content-params-one-text"><?= Html::encode($model->teachTime->name) ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($model->area): ?>
                    <div class="p-sj__content-params-one">
                        <span class="p-sj__content-params-one-title">Location:</span>
                        <span class="p-sj__content-params-one-text"><?= Html::encode($model->area->name) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-sj__content-posted">
                <div class="p-sj__content-posted-title">
                    Posted:
                </div>
                <div class="p-sj__content-posted-text">
                    <?= date('g:m A m/d/y', $model->created) ?>
                    (last changes <?= date('g:m A m/d/y', $model->updated) ?>)
                </div>
            </div>

            <div class="p-sj__content-btns">
                <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="p-sj__content-btns-one">Edit vacancy</a>
                <a href="<?= Url::to(['unpublish', 'id' => $model->id]) ?>" class="p-sj__content-btns-one">Unpublish</a>
            </div>
        </div>

        <div class="p-sj__aside">
            <div class="p-sj__aside-title">
                Suitable Adjuncts
            </div>
            <?php foreach ($suitableAdjuncts as $adjunct): ?>
                <div class="p-sj__aside-adjunct">
                    <img class="p-sj__aside-adjunct-ava"
                         src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2RHmCLDTk_bBOlgUjzhSUMK3cpF8JYBTkqoRtsmNKZXASWNj9HA"
                         alt=""/>
                    <a class="p-sj__aside-adjunct-name" href="">Chris Pratt</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="p-sj-proposals">
        <div class="p-sj-proposals__title">
            Adjuncts Proposals
        </div>

        <div class="p-sj-proposals__filter">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="p-sj-proposals__filter-btn active" id="all-link" data-toggle="list" href="#all"
                   role="tab" aria-controls="all">
                    All <span class="p-sj-proposals__filter-btn-mobi">Proposals</span> (<?= count($proposals) ?>)
                </a>
                <a class="p-sj-proposals__filter-btn" id="saved-link" data-toggle="list" href="#saved"
                   role="tab" aria-controls="saved">
                    Saved (<?= count($savedProposal) ?>)
                </a>
            </div>

            <div class="p-sj-proposals__filter-show">
                <label class="ui-checkbox">
                    <input type="checkbox" name=""/>
                    <span class="ui-checkbox__decor"></span>
                    <span class="ui-checkbox__text m-mbHide">Show only suitable</span>
                    <span class="ui-checkbox__text m-mbShow">Only suitable</span>
                </label>
            </div>
        </div>
        <div class="tab-content p-sj-proposals__content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-link">
                <?php $i = 1;
                foreach ($proposals as $proposal): ?>
                    <?= $this->render('_proposal', [
                        'proposal' => $proposal,
                        'vacancy' => $model,
                        'userId' => $user->getId(),
                        'num' => $i++,
                    ]) ?>
                <?php endforeach; ?>
                <div class="p-sj-proposals__content-more" id="loadMore">Load More</div>
            </div>
            <div class="tab-pane fade" id="saved" role="tabpanel" aria-labelledby="saved-link">
                <?php $i = 1;
                foreach ($savedProposal as $proposal): ?>
                    <?= $this->render('_proposal', [
                        'proposal' => $proposal,
                        'vacancy' => $model,
                        'userId' => $user->getId(),
                        'num' => $i++,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php
$ajaxUrl = Url::to(['vacancy/proposal']);
$script = <<< JS

window.proposalCount = $(".p-sj-proposals__content-one").length;
window.proposalLastShow = 0;
window.pageSize = 5;

function loadMore() {
    let cnt = 0;
    $(".p-sj-proposals__content-one").each(function(i, element) {
        let index = i+1;
        if (index <= (window.proposalLastShow + pageSize) && index > window.proposalLastShow) {
            $(element).show();
            cnt++;
        }
    });

    window.proposalLastShow = window.proposalLastShow + cnt;
    
    if (window.proposalCount <= window.proposalLastShow) {
        $('#loadMore').hide();
    }
}

loadMore();

$('#loadMore').on('click', loadMore);

$(".p-sj-proposals__content-one-header-right-item-fav").on("click", function () {
    let element = $(this);
    let action = element.hasClass('fas') ? 'remove' : 'save';
    let proposalId = element.attr('data-value');

    if (!proposalId) {
        return false;
    }
    
    $.ajax({
        type: 'post',
        url: '$ajaxUrl',
        data: {
            'vacancyId': $model->id,
            'proposalId': proposalId,
            'action': action,
        },
        success: function() {
            element.toggleClass("fas");
        }
    });    
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>