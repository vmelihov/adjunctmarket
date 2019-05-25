<?php

use common\models\Chat;
use common\models\Message;
use common\src\helpers\Helper;
use yii\helpers\Html;

/** @var $chat Chat */
/** @var $newMessage Message */

$this->title = 'Chat';
$this->params['breadcrumbs'][] = $this->title;

$user = Helper::getUserIdentity();
$opponent = $chat->getOpponentUser();
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="g-content">
    <div class="card p-2">
        <div>Opponent: <?= Html::encode($opponent->getUsername()) ?></div>
        <?php if ($chat->vacancy_id): ?>
            <div>Vacancy: <?= Html::encode($chat->vacancy->title) ?></div>
        <?php endif; ?>
    </div>

    <?= $this->render('@frontend/views/message/create', [
        'message' => $newMessage,
        'chat' => $chat,
    ]) ?>

    <div class="container">
        <?php
        /** @var Message $message */
        foreach ($chat->messages as $message):?>
            <?= $this->render('@frontend/views/message/one', [
                'message' => $message,
                'isOwn' => $message->author_user_id === $user->getId(),
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>