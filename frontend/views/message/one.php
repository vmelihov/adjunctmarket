<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $message common\models\Message */
/* @var $isOwn bool */

?>
<div class="message-view row">

    <div class="col text-<?= $isOwn ? 'left' : 'right' ?>">
        <div class="card p-2 mb-2">
            <?= $message->author->getUsername() . ' ' . date('H:i:s', $message->created) . '<br>' . $message->message ?>

            <?php if ($isOwn): ?>
                <div>
                    <?= Html::a('Update', ['message/update', 'id' => $message->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['message/delete', 'id' => $message->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
