<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $message common\models\Message */
/* @var $form yii\widgets\ActiveForm */
/* @var $action string */

$formParams = isset($action) ? ['action' => Url::to(['message/' . $action])] : [];
$formParams['id'] = 'messageForm';
$formParams['fieldConfig'] = [
    'template' => "{input}\n{error}",
    'options' => [
        'tag' => false,
    ]
];

?>

<?php $form = ActiveForm::begin($formParams); ?>
<div class="g-chat__content-chat-send">
    <div class="g-chat__content-chat-send-attach">
        <div class="g-chat__content-chat-send-attach-icon fal fa-paperclip"></div>
        <input type="file" class="g-chat__content-chat-send-attach-input"/>
    </div>

    <?= $form->field($message, 'message')->textarea([
        'class' => 'g-chat__content-chat-send-message',
        'placeholder' => 'Write a message...',
        'maxlength' => true,
    ]) ?>

    <?= Html::submitButton('Send', ['class' => 'g-chat__content-chat-send-btn']) ?>

    <?= $form->field($message, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($message, 'chat_id')->hiddenInput()->label(false) ?>
    <?= $form->field($message, 'author_user_id')->hiddenInput()->label(false) ?>
</div>
<?php ActiveForm::end(); ?>

<?php $ajaxMessageUrl = Url::to(['/chat/view-ajax']); ?>
<script type="text/javascript">
    $('#messageForm').on('submit', function () {
        if (!$('#message-message').val()) {
            return false;
        }

        $.ajax({
            type: 'post',
            url: '<?= Url::to(['/message/create-ajax']) ?>',
            data: $(this).serialize(),
            success: function (data) {
                if (data.success === true) {
                    $('#chatAjax').html(data.body.html);
                }
            }
        });

        return false;
    });
</script>
