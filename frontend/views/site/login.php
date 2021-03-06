<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model LoginForm */

use common\models\LoginForm;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\log\Logger;

$this->title = 'Log in to get start';

try {
    $this->registerCssFile('@web/css/registration.css', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/reg.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/validation.js', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}
?>

<div class="p-reg p-login g-content js-regForm">
    <div class="p-reg__title"><?= Html::encode($this->title) ?></div>

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'login-form',
            'class' => 'p-reg__form needs-validation'
        ],
        'fieldConfig' => [
            'template' => "{input}\n{error}",
            'options' => [
                'tag' => false,
            ],
            'errorOptions' => [
                'tag' => 'div',
                'class' => 'p-reg__form-iblock-error js-validateblockError',
            ],
        ],
    ]); ?>

    <div class="form-group">
        <div class="p-reg__form-linkedin">
            <a href="<?= Url::to(['/site/auth?authclient=mylinkedin'], true) ?>" class="p-reg__form-linkedin-link">
                <span class="fab fa-linkedin-in"></span>
                Continue with LinkedIn
            </a>
        </div>
    </div>

    <div class="form-group">
        <div class="p-reg__form-or">or</div>
    </div>

    <div class="form-group">
        <div class="p-reg__form-iblock">
            <div class="p-reg__form-iblock-icon fal fa-check"></div>
            <?= $form->field($model, 'email')->textInput([
                'class' => 'p-reg__form-input',
                'placeholder' => 'Work email address',
                'required' => '',
            ]) ?>

            <?php if ($model->getErrors('email')) : ?>
                <div class="p-reg__form-iblock-error" style="display: block">
                    <?= $model->getErrors('email')[0] ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <div class="p-reg__form-iblock js-passParent">
            <div class="js-passLine">
                <div class="p-reg__form-iblock-icon js-passEye fa fa-eye"></div>
                <?= $form->field($model, 'password')->passwordInput([
                    'class' => 'p-reg__form-input js-passInput',
                    'placeholder' => 'Password',
                    'required' => '',
                ]) ?>
            </div>
            <div class="js-passLine d-none">
                <div class="p-reg__form-iblock">
                    <div class="p-reg__form-iblock-icon js-passEye fa fa-eye-slash"></div>
                    <input placeholder="Password" type="text"
                           class="p-reg__form-input js-notPassInput"/>
                </div>
            </div>
            <?php if (count($model->getErrors('password')) > 0)  : ?>
                <div class="p-reg__form-iblock-error" style="display: block">
                    <?= $model->getErrors('password')[0] ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Forgot password?', ['site/request-password-reset']) ?>
    </div>

    <div class="p-reg__form-submit">
        <?= Html::submitButton('Log in', ['class' => 'p-reg__form-submit-input', 'name' => 'login-button']) ?>
    </div>

    <div class="p-reg__form-login">
        Don't have an account yet? <?= Html::a('Create account', ['site/signup']) ?>
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
