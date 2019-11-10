<?php

use common\models\Chat;
use common\models\User;
use common\src\helpers\UserImageHelper;
use yii\helpers\Html;

/** @var $chats Chat[] */
/** @var $user User */

$this->title = 'Chat List';
?>
<div class="g-chat-wrap js-chat">
    <div class="g-chat">
        <div class="g-chat__header">
            <div class="g-chat__header-aside">
                <div class="g-chat__header-aside-back fal fa-chevron-left js-closeChats"></div>
                <div class="g-chat__header-aside-contacts">
                    Сontacts (<?= count($chats) ?>)
                </div>
            </div>
            <div class="g-chat__header-main">
                <div class="g-chat__header-main-profile">
                    <div class="g-chat__header-main-profile-ava">
                        <img src="https://scontent-yyz1-1.cdninstagram.com/vp/a782e1ec40115333cf068bc0450c31f3/5E18A306/t51.2885-15/sh0.08/e35/c0.135.1080.1080a/s640x640/37209003_346561855879765_6130263244566167552_n.jpg?_nc_ht=scontent-yyz1-1.cdninstagram.com&_nc_cat=101"
                             alt="" class="g-chat__header-main-profile-ava-img">
                        <div class="g-chat__header-main-profile-ava-status" title="Offline"></div>
                    </div>
                    <div class="g-chat__header-main-profile-name">Chris Hemsworth Chris Hemsworth Chris</div>
                </div>
                <div class="g-chat__header-main-close fal fa-times js-closeChat"></div>
            </div>
        </div>

        <div class="g-chat__content">
            <div class="g-chat__content-contacts js-niceScroll">
                <?php foreach ($chats as $chat): ?>
                    <?php $opponent = $chat->getOpponentUser($user) ?>
                    <div class="g-chat__content-contacts-one js-openChat">
                        <div class="g-chat__content-contacts-one-ava">
                            <img src="<?= UserImageHelper::getUrl($opponent) ?>" alt=""
                                 class="g-chat__content-contacts-one-ava-img">
                        </div>

                        <div class="g-chat__content-contacts-one-main">
                            <div class="g-chat__content-contacts-one-main-name">
                                <?= Html::encode($opponent->getUsername()) ?>
                            </div>
                            <!--                            <div class="g-chat__content-contacts-one-main-time">-->
                            <!--                                12:10 PM-->
                            <!--                            </div>-->

                            <div class="g-chat__content-contacts-one-main-text">
                                <?= Html::encode($chat->getLastMessage()->message) ?>
                            </div>

                            <div class="g-chat__content-contacts-one-main-new">
                                <?= $chat->getCountUnreadMessagesForUserId($user->getId()) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="g-chat__content-chat">
                <div class="g-chat__content-chat-body js-niceScroll">
                    <div class="g-chat__content-chat-body-author">
                        Chris Hemsworth
                    </div>
                    <div class="g-chat__content-chat-body-message">
                        The department seeks papers that further our understanding of operations by explicitly
                        accounting for empirically observed human tendencies and influences, such as decision
                        biases, cognitive limitations, individual preferences.
                    </div>

                    <div class="g-chat__content-chat-body-answer">
                        Thanks for the answer. Can you tell us more about yourself?
                    </div>

                    <div class="g-chat__content-chat-body-author">
                        Chris Hemsworth
                    </div>
                    <div class="g-chat__content-chat-body-img">
                        <img src="https://scontent-yyz1-1.cdninstagram.com/vp/a782e1ec40115333cf068bc0450c31f3/5E18A306/t51.2885-15/sh0.08/e35/c0.135.1080.1080a/s640x640/37209003_346561855879765_6130263244566167552_n.jpg?_nc_ht=scontent-yyz1-1.cdninstagram.com&_nc_cat=101"
                             alt="" class="g-chat__content-chat-body-img-pict">
                        <div class="g-chat__content-chat-body-img-del fa fa-times"></div>
                        <div class="g-chat__content-chat-body-img-loading fal fa-hourglass"></div>
                    </div>


                    <div class="g-chat__content-chat-body-author">
                        Chris Hemsworth
                    </div>
                    <div class="g-chat__content-chat-body-typing"></div>
                </div>

                <div class="g-chat__content-chat-send">
                    <div class="g-chat__content-chat-send-attach">
                        <div class="g-chat__content-chat-send-attach-icon fal fa-paperclip"></div>
                        <input type="file" class="g-chat__content-chat-send-attach-input"/>
                    </div>
                    <textarea class="g-chat__content-chat-send-message" placeholder="Write a message..."></textarea>
                    <div class="g-chat__content-chat-send-btn">
                        Send
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
