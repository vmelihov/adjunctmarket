<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model ResetPasswordForm */

use frontend\assets\AppAsset;
use frontend\models\ResetPasswordForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/registration.css', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/reg.js', ['depends' => [AppAsset::class]]);
?>

<div class="p-reg p-login g-content js-regForm">
    <div class="p-reg__title"><?= Html::encode($this->title) ?></div>

    <?php $form = ActiveForm::begin([
        'id' => 'request-password-reset-form',
        'options' => ['class' => 'p-reg__form needs-validation'],
        'fieldConfig' => [
            'template' => "{input}\n{error}",
            'options' => [
                'tag' => false,
            ],
        ],
    ]); ?>

    <div class="form-group">
        <div class="p-reg__form-iblock">
            <div class="p-reg__form-iblock-icon fal fa-check"></div>

            <?= $form->field($model, 'password')->passwordInput([
                'autofocus' => true,
                'class' => 'p-reg__form-input',
            ]) ?>
        </div>
    </div>

    <div class="p-reg__form-submit">
        <?= Html::submitButton('Save', ['class' => 'p-reg__form-submit-input']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div class="p-reg__mail d-none js-regDone">
    <div class="p-reg__mail-title">
        We have sent an email with a confirmation link to your email address
    </div>
    <div class="p-reg__mail-text">
        Thank you for choosing our service
    </div>
</div>
