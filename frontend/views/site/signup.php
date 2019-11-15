<?php

use common\models\University;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model frontend\forms\SignupForm */
/* @var $form ActiveForm */

$this->registerCssFile('@web/extension/selectize/css/selectize.css');
$this->registerCssFile('@web/css/registration.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/reg.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/validation.js', ['depends' => [AppAsset::class]]);

$universities = ArrayHelper::map(University::find()->all(), 'id', 'name');

$this->title = 'Registration';
?>
    <div class="p-reg g-content">

        <div class="p-reg__title">Registration</div>

        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'reg-form',
                'class' => 'p-reg__form needs-validation',
            ],
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'template' => "{input}\n{error}",
                'errorOptions' => [
                    'tag' => 'div',
                    'class' => 'p-reg__form-iblock-error js-validateblockError',
                ],
                'options' => [
                    'tag' => 'div',
                ],
            ],
        ]); ?>

        <div class="form-group">
            <div class="p-reg__form-profile-type">
                <div class="p-reg__form-profile-type-one active js-profileType" data-value="1">
                    Adjunct
                </div>
                <div class="p-reg__form-profile-type-one js-profileType" data-value="2">
                    Institution
                </div>
            </div>

            <div class="p-reg__form-acc-info">
                After registering, you cannot change the account type!
            </div>
        </div>

        <?= $form->field($model, 'user_type')->hiddenInput([
            'id' => 'user_type_input',
            'value' => '1',
        ]) ?>

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
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-reg__form-iblock js-validateblock">
                        <div class="p-reg__form-iblock-label">First name</div>
                        <div class="p-reg__form-iblock-icon fal fa-check js-validateblockOk"></div>

                        <?= $form->field($model, 'first_name')->textInput([
                            'class' => 'p-reg__form-iblock-input js-textValidation',
                            'placeholder' => 'Enter your first name',
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-reg__form-iblock js-validateblock">
                        <div class="p-reg__form-iblock-label">Last name</div>
                        <div class="p-reg__form-iblock-icon fal fa-check js-validateblockOk"></div>

                        <?= $form->field($model, 'last_name')->textInput([
                            'class' => 'p-reg__form-iblock-input js-textValidation',
                            'placeholder' => 'Enter your last name',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="p-reg__form-iblock js-validateblock">
                <div class="p-reg__form-iblock-icon fal fa-check js-validateblockOk"></div>

                <?= $form->field($model, 'email')->textInput([
                    'class' => 'p-reg__form-input',
                    'placeholder' => 'Work email address',
                    'type' => 'email',
                ]) ?>
            </div>
        </div>

        <div class="form-group d-none js-institution">
            <div class="p-reg__form-iblock">
                <div class="p-reg__form-iblock-label">Educational institution</div>

                <?= $form->field($model, 'university_id', [
                    'template' => '{input}',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => [
                        'tag' => false,
                    ]
                ])
                    ->dropDownList($universities, [
                        'class' => 'js-selectize',
                        'placeholder' => 'Choose institution',
                        'prompt' => 'Choose institution'
                    ])
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-lg-6 js-passParent">
                    <div class="js-passLine">
                        <div class="p-reg__form-iblock">
                            <div class="p-reg__form-iblock-icon js-passEye fa fa-eye"></div>

                            <?= $form->field($model, 'password')->passwordInput([
                                'class' => 'p-reg__form-input js-passInput',
                                'placeholder' => 'Password',
                            ]) ?>
                        </div>
                    </div>
                    <div class="js-passLine d-none">
                        <div class="p-reg__form-iblock">
                            <div class="p-reg__form-iblock-icon js-passEye fa fa-eye-slash"></div>
                            <input placeholder="Password" type="text"
                                   class="p-reg__form-input js-notPassInput"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 js-passParent">
                    <div class="js-passLine">
                        <div class="p-reg__form-iblock">
                            <div class="p-reg__form-iblock-icon js-passEye fa fa-eye"></div>

                            <?= $form->field($model, 'password_repeat')->passwordInput([
                                'class' => 'p-reg__form-input js-passInput',
                                'placeholder' => 'Confirm pasword',
                            ]) ?>
                        </div>
                    </div>
                    <div class="js-passLine d-none">
                        <div class="p-reg__form-iblock">
                            <div class="p-reg__form-iblock-icon js-passEye fa fa-eye-slash"></div>
                            <input placeholder="Confirm pasword" type="text"
                                   class="p-reg__form-input js-notPassInput"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-reg__form-submit">
            <?= Html::submitButton('Sign up', ['class' => 'p-reg__form-submit-input']) ?>
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
                I have read and agree to the AdjunktMarket <a href="" target="_blank">Terms and Conditions</a>
                of Use and <a href="" target="_blank">Privacy Policy</a>.
            </div>
        </div>

        <div class="p-reg__form-login">
            Already have an account? <a href="<?= Url::to(['/site/login'], true) ?>">Log in</a>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
    $('.p-reg__form-profile-type-one').on('click', function(){
        var val = $(this).attr('data-value');
        $('#user_type_input').val(val);
    });
 
    $('#reg-form').on('afterValidate', function(e, m) {
        
        $.each(m, function(key, errors){
            var id = '#' + key;

            if (errors.length > 0) {
                $(id).siblings().first().text(errors[0]).show();
            } else {
                $(id).siblings().first().text('').hide();
            }
        });

        return true;
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>