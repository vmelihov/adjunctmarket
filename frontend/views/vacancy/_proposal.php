<?php

use common\models\Chat;
use common\models\Proposal;
use common\src\helpers\UserImageHelper;
use yii\helpers\Url;

/** @var Proposal $proposal */
/** @var int $vacancyId */
/** @var int $userId */
/** @var int $num */

?>
<div class="p-sj-proposals__content-one" style="display: none" data-value="<?= $num ?>">
    <div class="p-sj-proposals__content-one-header">
        <div class="p-sj-proposals__content-one-header-left">
            <div class="p-sj-proposals__content-one-header-left-ava">
                <img src="<?= UserImageHelper::getUrl($proposal->adjunct) ?>" alt=""
                     class="p-sj-proposals__content-one-header-left-ava-img">
            </div>
            <a href="" class="p-sj-proposals__content-one-header-left-name">
                <?= $proposal->adjunct->getUsername() ?>
            </a>
            <!--                        <div class="p-sj-proposals__content-one-header-left-date">-->
            <!--                            12:10 PM 03.25.2019-->
            <!--                        </div>-->
        </div>
        <div class="p-sj-proposals__content-one-header-right">
            <div class="p-sj-proposals__content-one-header-right-item m-mbHide">
                <!--                            <a href="" class="p-sj-proposals__content-one-header-right-item-link m-mbHide">-->
                <!--                                Approve the Candidacy-->
                <!--                            </a>-->
            </div>
            <div class="p-sj-proposals__content-one-header-right-item">
                <?php
                if ($chat = Chat::findByVacancyAndAdjunct($vacancyId, $proposal->adjunct_id)) {
                    $countUnreadMessages = $chat->getCountUnreadMessagesForUserId($userId);
                    $chatUrl = Url::to(['/chat/view', 'chatId' => $chat->id], true);
                    $chatTitle = $countUnreadMessages . ' new message';
                } else {
                    $chatUrl = Url::to(['/chat/create', 'param' => $proposal->adjunct_id], true);
                    $chatTitle = 'Start chatting';
                } ?>
                <a href="<?= $chatUrl ?>" class="p-sj-proposals__content-one-header-right-item-link">
                    <span class="fal fa-envelope"></span>
                    <span class="m-mbHide"><?= $chatTitle ?></span>
                </a>
            </div>
            <div class="p-sj-proposals__content-one-header-right-item">
                <div class="p-sj-proposals__content-one-header-right-item-fav fal fa-heart js-fav"></div>
            </div>
        </div>
    </div>

    <div class="p-sj-proposals__content-one-content">
        <div class="p-sj-proposals__content-one-content-text">
            <?= $proposal->letter ?>
        </div>
        <?php if ($attaches = $proposal->getAttachesUrlArray()): ?>
            <div class="p-sj-proposals__content-one-content-attachments">
                Attachments:
                <?php foreach ($attaches as $name => $url): ?>
                    <?= "<a href=\"$url\" download>$name</a>;" ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
