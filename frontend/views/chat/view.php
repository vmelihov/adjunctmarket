<?php

use common\models\Chat;
use common\models\Message;
use common\src\helpers\Helper;

/** @var $chat Chat */
/** @var $newMessage Message */
/** @var $ajaxForm bool */

$this->title = 'Chat';

$user = Helper::getUserIdentity();
$opponent = $chat->getOpponentUser($user);
?>

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

<?php if ($ajaxForm) {
    echo $this->render('@frontend/views/message/createAjax', [
        'message' => $newMessage,
        'chat' => $chat,
    ]);
} else {
    echo $this->render('@frontend/views/message/create', [
        'message' => $newMessage,
        'chat' => $chat,
    ]);
} ?>