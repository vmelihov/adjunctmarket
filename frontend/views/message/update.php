<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $message common\models\Message */

$this->title = 'Update Message: ' . $message->id;
?>
<div class="message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'message' => $message,
    ]) ?>

</div>
