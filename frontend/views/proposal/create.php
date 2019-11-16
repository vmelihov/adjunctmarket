<?php

use frontend\forms\ProposalForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ProposalForm */
/* @var $form ActiveForm */

$model->letter = nl2br($model->letter);

?>

<?php $form = ActiveForm::begin([
    'id' => 'lll-form',
    'action' => Url::to(['proposal/create']),
    'fieldConfig' => [
        'template' => "{input}\n{error}",
        'options' => [
            'tag' => false,
        ],
        'errorOptions' => [
            'class' => 'proposal__form-iblock-error',
            'style' => 'position: absolute;left: 20px;top: 100%;margin-top: 5px;font-size: 15px;color:#EB5757;display: none;',
            'tag' => 'div'
        ],
    ],
]); ?>

    <div class="p-sja__modal-content-title">
        Cover Letter
    </div>
    <div class="p-sja__modal-content-message" style="position: relative">
        <?= $form->field($model, 'letter')->textarea([
            'class' => 'p-sja__modal-content-message-textarea',
            'maxlength' => true
        ]) ?>
    </div>

    <div class="p-sja__modal-content-files">
        <div class="p-sja__modal-content-files-title">
            Attached Files:
        </div>
        <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>
    </div>

<?= $form->field($model, 'state')->hiddenInput() ?>
<?= $form->field($model, 'adjunct_id')->hiddenInput() ?>
<?= $form->field($model, 'vacancy_id')->hiddenInput() ?>

<?= Html::submitButton('Publish', ['class' => 'p-sja__modal-content-submit']) ?>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $('#lll-form').on('afterValidate', function(e, m) {
        $.each(m, function(key, errors){
            let id = '#' + key;
            if (typeof errors !== 'undefined' && errors.length > 0) {
                $(id).parent().children('.proposal__form-iblock-error').text(errors[0]).show();
            } else {
                $(id).parent().children('.proposal__form-iblock-error').text('').hide();
            }
        });

        return true;
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>