<?php

use common\models\Chat;
use yii\helpers\Html;

/** @var $chats Chat[] */

$this->title = 'Chat List';
?>

<div class="g-content">
    <?php foreach ($chats as $chat): ?>
        <div class="card p-2">
            <div>
                Name: <?= $chat->adjunctUser->getUsername() ?>
            </div>
            <div>
                Title: <?= $chat->vacancy ? $chat->vacancy->title : 'Direct' ?>
            </div>
            <div>
                <?= Html::a('To chat', ['chat/view', 'chatId' => $chat->id], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
