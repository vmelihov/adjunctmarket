<?php

use common\models\Chat;
use common\models\Message;
use common\src\helpers\Helper;

/** @var $chat Chat */
/** @var $newMessage Message */

$this->title = 'Chat';

$user = Helper::getUserIdentity();
$opponent = $chat->getOpponentUser($user);
?>

<div>
    <div class="g-chat__content-chat-body js-niceScroll">
        <?php
        /** @var Message $message */
        foreach ($chat->messages as $message):?>
            <?= $this->render('@frontend/views/message/one', [
                'message' => $message,
                'isOwn' => $message->author_user_id === $user->getId(),
            ]) ?>
        <?php endforeach; ?>
    </div>

    <?= $this->render('@frontend/views/message/create', [
        'message' => $newMessage,
        'chat' => $chat,
    ]) ?>

</div>