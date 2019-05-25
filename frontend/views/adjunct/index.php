<?php

use common\models\Adjunct;
use common\models\Chat;
use common\src\helpers\Helper;
use yii\helpers\Url;

/** @var $adjuncts Adjunct[] */

$this->title = 'Chat List';

$user = Helper::getUserIdentity();
?>

<div class="g-content">
    <?php foreach ($adjuncts as $adjunct): ?>
        <div class="card p-2">
            <div>
                Name: <?= $adjunct->user->getUsername() ?>
            </div>

            <div>
                <?php if ($chat = Chat::findByInstitutionAndAdjunct($user->getId(), $adjunct->user->id)): ?>
                    <a href="<?= Url::to(['/chat/view', 'chatId' => $chat->id], true) ?>" class="btn btn-primary">К
                        чату</a>
                <?php else : ?>
                    <a href="<?= Url::to(['/chat/create', 'param' => $adjunct->user->id], true) ?>"
                       class="btn btn-primary">Директ</a>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>
