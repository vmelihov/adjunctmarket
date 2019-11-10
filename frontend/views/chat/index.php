<?php

use common\models\Chat;
use common\models\User;
use common\src\helpers\UserImageHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $chats Chat[] */
/** @var $user User */

$this->title = 'Chat List';
?>
    <div id="chatList" class="g-chat-wrap js-chat" style="display: none">
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
                        <img id="opponentAvatar" src="" alt="" class="g-chat__header-main-profile-ava-img">
                    </div>
                    <div id="opponentName" class="g-chat__header-main-profile-name"></div>
                </div>
                <div class="g-chat__header-main-close fal fa-times js-closeChat"></div>
            </div>
        </div>

        <div class="g-chat__content">
            <div class="g-chat__content-contacts js-niceScroll">
                <?php foreach ($chats as $chat): ?>
                    <?php $opponent = $chat->getOpponentUser($user); ?>
                    <div class="g-chat__content-contacts-one" onclick="openChat(<?= $chat->id ?>)">
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
                                <?php if ($lastMessage = $chat->getLastMessage()): ?>
                                    <?= Html::encode($lastMessage->message) ?>
                                <?php endif; ?>
                            </div>

                            <div class="g-chat__content-contacts-one-main-new">
                                <?= $chat->getCountUnreadMessagesForUserId($user->getId()) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="chatAjax" class="g-chat__content-chat"></div>
        </div>
    </div>
</div>

<?php
$ajaxChatUrl = Url::to(['/chat/view-ajax']);
$script = <<< JS

function openChat(chatId) {
    $('#chatList').show();

    $.ajax({
        type: 'post',
        url: '$ajaxChatUrl',
        data: {
            'chatId': chatId,
        },
        success: function(data) {
            if (data.success === true) {

                let result = data.body;

                $('#chatAjax').html(result.html);
                $('#chatList').addClass("m-chatOpened");
                $('#opponentName').text(result.opponent.name);
                $('#opponentAvatar').attr('src', result.opponent.img);
            }
        }
    });
}

JS;
$this->registerJs($script, View::POS_END);
?>