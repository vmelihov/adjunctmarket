<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $message common\models\Message */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$formParams = isset($action) ? ['action' => Url::to(['message/' . $action])] : [];

?>

<div class="message-form">

    <?php $form = ActiveForm::begin($formParams); ?>

    <?= $form->field($message, 'id')->hiddenInput()->label(false) ?>

    <?= $form->field($message, 'chat_id')->hiddenInput()->label(false) ?>

    <?= $form->field($message, 'author_user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($message, 'message')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Send message', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
