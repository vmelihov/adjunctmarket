<?php

/* @var $this yii\web\View */
/* @var $message common\models\Message */
/* @var $chat common\models\Chat */

?>

<?= $this->render('_formAjax', [
    'message' => $message,
    'chat' => $chat,
    'action' => 'create',
]) ?>
