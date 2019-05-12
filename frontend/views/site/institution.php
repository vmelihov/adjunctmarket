<?php

use common\models\University;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Adjunct */
/* @var $form ActiveForm */

$this->registerCssFile('@web/css/profile-type.css', ['depends' => [AppAsset::class]]);
$this->registerCssFile('@web/extension/select2/select2.min.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/js/profile-type.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/extension/bootstrap-4.0.0/js/popper.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/extension/select2/select2.min.js', ['depends' => [AppAsset::class]]);

$this->title = 'Employer profile';

$universities = ArrayHelper::map(University::find()->all(), 'id', 'name');
?>

    <div class="p-profile g-content">
        <h1 class="g-mb30">Creating User Profile</h1>

        <?php $form = ActiveForm::begin([
            'id' => 'institution-profile-form',
            'action' => Url::to(['institution/profile']),
            'fieldConfig' => [
                'template' => "{input}\n{error}",
                'options' => [
                    'class' => 'form-control form-control-lg',
                    'tag' => false,
                ],
            ],
        ]); ?>

        <div class="p-profile__block">
            <h2 class="g-mb20">
                Some choose
                <span class="fa fa-info-circle" data-toggle="tooltip"
                      title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor"></span>
            </h2>

            <div class="p-profile__select2 g-mb20">
                <?= $form->field($model, 'university_id')
                    ->dropDownList($universities, ['class' => 'p-profile__select2-select js-select2'])
                ?>
            </div>
        </div>


        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

        <div class="p-profile__submit">
            <?= Html::submitButton('APPLY', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
        </div>

        <div class="p-profile__sometext g-mb15">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut
            labore et dolore magna aliqua.
        </div>

        <div class="p-profile__read">
            <div class="p-profile__read-check">
                <label class="ui-checkbox">
                    <input type="checkbox" id="adjunctform-confirm" name="AdjunctForm[confirm]" value="1" checked="">
                    <span class="ui-checkbox__decor"></span>
                </label>
            </div>

            <div class="p-profile__read-text">
                I have read and agree to the AdjunktMarket <a href="" target="_blank">Terms and
                    Conditions</a>
                of Use and <a href="" target="_blank">Privacy Policy</a>.
            </div>
    </div>

    <?php ActiveForm::end(); ?>
    </div>

<?php
$script = <<< JS
    $('#adjunct-profile-form').on('afterValidate', function(e, m) {
        
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
$this->registerJs($script, View::POS_READY);
?>