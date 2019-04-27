<?php

use common\models\User;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/* @var $this View */
/* @var $model frontend\forms\SignupForm */
/* @var $form ActiveForm */

$this->registerCssFile('@web/css/registration.css', [
    'depends' => [AppAsset::class],
]);
$this->registerJsFile('@web/js/reg.js"', [
    'depends' => [AppAsset::class],
]);

$this->title = 'Registration';
?>
    <div class="p-reg g-content">

        <div class="p-reg__title">Registration</div>

        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'options' => [
                'id' => 'reg-form',
                'class' => 'needs-validation',
            ],
            'fieldConfig' => [
                'template' => "{beginWrapper}\n{label}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'ui-radio g-mr20',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'form-group',
                    'hint' => '',
                ],
                'options' => [
                    'class' => 'form-control form-control-lg',
                    'tag' => false,
                ],
            ],
        ]); ?>

        <div class="form-group">
            <h2 class="g-mb20">Choose account type</h2>

            <?= $form->field($model, 'user_type')->radioList(User::getUserTypes(), [
                'item' => static function ($index, $label, $name, $checked, $value) {

                    $return = '<label class="ui-radio g-mr20">';
                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '">';
                    $return .= '<span class="ui-radio__decor"></span>';
                    $return .= '<span class="ui-radio__text">' . strtoupper($label) . '</span>';
                    $return .= '</label>';

                    return $return;
                }
            ])->label(false) ?>

            <div class="p-reg__form-acc-info">
                <div class="p-reg__form-acc-info-icon fa fa-exclamation-triangle"></div>
                After registering, you cannot change the account type!
            </div>
        </div>

        <?= $form->field($model, 'first_name')->textInput([
            'placeholder' => 'Enter your first name',
            'required' => '',
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'placeholder' => 'Enter your last name',
            'required' => '',
        ]) ?>

    <?= $form->field($model, 'email')->textInput([
        'placeholder' => 'Enter your work email',
        'type' => 'email',
        'required' => '',
    ]) ?>

        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Password',
            'required' => '',
        ]) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput([
            'placeholder' => 'Repeat password',
            'required' => '',
        ]) ?>

        <div class="p-reg__form-submit">
            <?= Html::submitButton('SIGN UP', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
        </div>

        <div class="p-reg__form-read">
            <div class="p-reg__form-read-check">
                <label class="ui-checkbox">
                    <input type="checkbox" id="signupform-confirm" name="SignupForm[confirm]" value="1" checked=""
                           aria-invalid="true">
                    <span class="ui-checkbox__decor"></span>
                    <?= $errors['confirm'] ?? '' ?>
                </label>
            </div>

            <div class="p-reg__form-read-text">
                I have read and agree to the AdjunktMarket <a href="" target="_blank">Terms and
                    Conditions</a>
                of Use and <a href="" target="_blank">Privacy Policy</a>.
            </div>
        </div>

        <div class="p-reg__form-sometext">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua.
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
    $('#reg-form').on('afterValidate', function(e, m) {
        $.each(m, function(key, errors){
            var id = '#' + key;
            if (typeof errors !== 'undefined' && errors.length > 0) {
                console.log(id, $(id).parent());
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