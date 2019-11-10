<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $message common\models\Message */
/* @var $isOwn bool */

?>

<?php if (!$isOwn): ?>
    <div class="g-chat__content-chat-body-author">
        <?= Html::encode($message->author->getUsername()) ?>
    </div>
    <div class="g-chat__content-chat-body-message">
        <?= Html::encode($message->message) ?>
    </div>
<?php else: ?>
    <div class="g-chat__content-chat-body-answer">
        <?= Html::encode($message->message) ?>
    </div>
<?php endif; ?>

<?php /*
<?= Html::a('Update', ['message/update', 'id' => $message->id], ['class' => 'btn btn-primary']) ?>
<?= Html::a('Delete', ['message/delete', 'id' => $message->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method' => 'post',
    ],
]) ?>
*/ ?>
