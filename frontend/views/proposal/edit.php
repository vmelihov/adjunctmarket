<?php

use frontend\assets\AppAsset;
use frontend\forms\ProposalForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ProposalForm */
/* @var $form ActiveForm */

try {
    $this->registerCssFile('@web/css/single-job-adjunct.css', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log('Error creating profile. ' . $e->getMessage(), Logger::LEVEL_ERROR);
}

?>

    <div class="container">

        <?php $form = ActiveForm::begin([
            'id' => 'proposal-form',
            'action' => Url::to(['proposal/update']),
            'fieldConfig' => [
                'template' => "{input}\n{error}",
                'options' => [
                    'tag' => false,
                ]
            ],
]); ?>

        <div class="p-sja__modal-content-title">
            Cover Letter
        </div>
        <div class="p-sja__modal-content-message">
            <?= $form->field($model, 'letter')->textarea([
                'class' => 'p-sja__modal-content-message-textarea',
                'maxlength' => true
            ]) ?>
        </div>

        <div class="p-sja__modal-content-files">
            <div class="p-sja__modal-content-files-title">
                Attached Files:
                <div style="margin-bottom: 20px">
                    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>
                </div>
                <?php foreach ($model->getAttachesArray() as $file): ?>
                    <div class="p-sja__modal-content-files-one">
                    <span class="p-sja__modal-content-files-one-text">
                        <?= $file ?>
                    </span>
                        <a href="<?= Url::to(['unlink', 'proposalId' => $model->id, 'fileName' => $file]) ?>">delete</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?= $form->field($model, 'id')->hiddenInput() ?>
        <?= $form->field($model, 'state')->hiddenInput() ?>
        <?= $form->field($model, 'adjunct_id')->hiddenInput() ?>
        <?= $form->field($model, 'vacancy_id')->hiddenInput() ?>
        <?= $form->field($model, 'attaches')->hiddenInput() ?>

        <?= Html::submitButton('Edit', ['class' => 'p-sja__modal-content-submit']) ?>

        <?php ActiveForm::end(); ?>

    </div>

<?php
$script = <<< JS
    $('#proposal-form').on('afterValidate', function(e, m) {
        $.each(m, function(key, errors){
            let id = '#' + key;
            if (typeof errors !== 'undefined' && errors.length > 0) {
                $(id).parent().children('.help-block-error').text(errors[0]).addClass('error');
            } else {
                $(id).parent().children('.help-block-error').text('').removeClass('error');
            }
        });

        return true;
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>