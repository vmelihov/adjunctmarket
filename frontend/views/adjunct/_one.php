<?php

use common\models\Adjunct;
use common\models\Chat;
use common\models\User;
use common\src\helpers\UserImageHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $adjunct Adjunct */
/** @var $user User */
/** @var $isFavorite bool */

?>
<div class="p-al__list-one js-one">
    <div class="p-al__list-one-content">
        <div class="p-al__list-one-content-block m-man">
            <div class="p-al__list-one-content-block-ava">
                <img src="<?= UserImageHelper::getUrl($adjunct->user) ?>"
                     alt="" class="p-al__list-one-content-block-ava-img">
            </div>
            <a href="<?= Url::to(['/adjunct/view', 'id' => $adjunct->id]) ?>" class="p-al__list-one-content-block-name">
                <?= Html::encode($adjunct->user->getUsername()) ?>
            </a>
            <!--            <div class="p-al__list-one-content-block-status m-busy">Busy</div>-->
            <div class="p-al__list-one-content-block-place">
                <?= $adjunct->location->name ?>
            </div>
        </div>
        <div class="p-al__list-one-content-block m-tel">
            <a href="telTo:+<?= $adjunct->phone ?>" class="p-al__list-one-content-block-tel"><?= $adjunct->phone ?></a>
            <div class="p-al__list-one-content-block-tel-title">Cellphone</div>
        </div>
        <div class="p-al__list-one-content-block m-social">
            <?php if ($adjunct->linledin): ?>
                <a href="<?= $adjunct->linledin ?>" target="_blank"
                   class="p-al__list-one-content-block-social fab fa-linkedin-in"></a>
            <?php else: ?>
                <span class="p-al__list-one-content-block-social fab fa-linkedin m-none"></span>
            <?php endif; ?>

            <?php if ($adjunct->facebook): ?>
                <a href="<?= $adjunct->facebook ?>" target="_blank"
                   class="p-al__list-one-content-block-social fab fa-facebook-f"></a>
            <?php else: ?>
                <span class="p-al__list-one-content-block-social fab fa-facebook m-none"></span>
            <?php endif; ?>

            <?php if ($adjunct->whatsapp): ?>
                <a href="<?= $adjunct->whatsapp ?>" target="_blank"
                   class="p-al__list-one-content-block-social fab fa-whatsapp"></a>
            <?php else: ?>
                <span class="p-al__list-one-content-block-social fab fa-whatsapp m-none"></span>
            <?php endif; ?>
        </div>
        <div class="p-al__list-one-content-block m-links">
            <?php if ($chat = Chat::findByInstitutionAndAdjunct($user->getId(), $adjunct->user->id)): ?>
                <a href="#" class="p-al__list-one-content-block-chatting" onclick="openChat(<?= $chat->id ?>)">
                    To chat
                </a>
            <?php else : ?>
                <a href="#" onclick="createChat(<?= $adjunct->user->id ?>)"
                   class="p-al__list-one-content-block-chatting">
                    Start chatting
                </a>
            <?php endif; ?>
            <div class="p-al__list-one-content-block-fav fal fa-heart js-fav<?= $isFavorite ? ' fas' : '' ?>"
                 data-value="<?= $adjunct->id ?>"></div>
        </div>
    </div>
    <div class="p-al__list-one-control active js-view">
        <div class="p-al__list-one-control-wrap">
            <div class="p-al__list-one-control-text">
                Expanded view
                <br/>
                Compact view
            </div>
        </div>
    </div>
    <div class="p-al__list-one-footer js-footer">
        <div class="p-al__list-one-footer-column">
            <?php if ($adjunct->teaching_experience_type_id): ?>
                <div class="p-al__list-one-footer-item">
                    <span class="p-al__list-one-footer-item-name">Teaching experience:</span> <?= $adjunct->teachingExperienceType->name ?>
                </div>
            <?php endif; ?>

            <?php if ($adjunct->education): ?>
                <div class="p-al__list-one-footer-item">
                    <span class="p-al__list-one-footer-item-name">Education:</span> <?= $adjunct->education->name ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-al__list-one-footer-column">
            <?php if ($adjunct->teach_time_id): ?>
                <div class="p-al__list-one-footer-item">
                    <span class="p-al__list-one-footer-item-name">Type of teaching:</span> <?= $adjunct->teachTime->name ?>
                </div>
            <?php endif; ?>

            <?php if ($adjunct->teach_locations): ?>
                <div class="p-al__list-one-footer-item">
                    <span class="p-al__list-one-footer-item-name">Location:</span>
                    <?php foreach ($adjunct->getLocations() as $location) {
                        echo $location->getNameWithState() . '<br>';
                    } ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-al__list-one-footer-column">
            <?php if ($adjunct->teachPeriod): ?>
                <div class="p-al__list-one-footer-item">
                    <span class="p-al__list-one-footer-item-name">Type of teaching:</span> <?= $adjunct->teachPeriod->name ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
