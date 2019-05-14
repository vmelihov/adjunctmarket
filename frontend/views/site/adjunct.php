<?php

use common\models\Area;
use common\models\Education;
use common\models\Specialty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Adjunct */
/* @var $form ActiveForm */

$this->registerCssFile('@web/extension/select2/select2.min.css', ['depends' => [AppAsset::class]]);
$this->registerCssFile('@web/css/profile-type.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/extension/bootstrap-4.0.0/js/popper.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/extension/select2/select2.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/profile-type.js', ['depends' => [AppAsset::class]]);

$this->title = 'Adjunct profile';

$specialities = ArrayHelper::map(Specialty::find()->all(), 'id', 'nameWithFaculty');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
$education = ArrayHelper::map(Education::find()->all(), 'id', 'name');
$areas = ArrayHelper::map(Area::find()->all(), 'id', 'nameWithState');
?>

    <div class="p-profile g-content">
        <h1 class="g-mb30">
            Creating User Profile
        </h1>

        <?php $form = ActiveForm::begin([
            'id' => 'adjunct-profile-form',
            'action' => Url::to(['adjunct/profile']),
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
                Choose category faculty
                <span class="fa fa-info-circle" data-toggle="tooltip"
                      title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor"></span>

            </h2>

            <div class="js-categoryFaculty">
                <div class="js-cfBlock g-mb20">
                    <div class="p-profile__select2 g-mb10">
                        <?= $form->field($model, 'specialities')
                            ->dropDownList($specialities, [
                                'multiple' => 'multiple',
                                'class' => 'p-profile__select2-select js-select2'
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-profile__block">
            <h2 class="g-mb20">
                Do you have teaching experience?
                <span class="fa fa-info-circle" data-toggle="tooltip"
                      title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor"></span>
            </h2>
            <div class="g-mb15">
                <label class="ui-radio g-mr15 js-showLink" data-show="expirienceBlock">
                    <input type="radio" name="exp" <?= $model->teaching_experience_type_id ? 'checked' : '' ?>/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">YES</span>
                </label>
                <label class="ui-radio js-hideLink" data-hide="expirienceBlock">
                    <input type="radio" name="exp"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">NO</span>
                </label>
            </div>

            <div<?= !$model->teaching_experience_type_id ? ' class="p-profile__exp"' : '' ?> id="expirienceBlock">
                <div class="g-mb20">
                    <?= $form->field($model, 'teaching_experience_type_id')
                        ->radioList($teachingTypes, [
                            'item' => static function ($index, $label, $name, $checked, $value) {
                                $check = $checked ? ' checked' : '';
                                $return = '<label class="ui-checkbox g-mr15">';
                                $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
                                $return .= '<span class="ui-radio__decor"></span>';
                                $return .= '<span class="ui-radio__text">' . strtoupper($label) . '</span>';
                                $return .= '</label>';

                                return $return;
                            }
                        ])
                    ?>
                </div>

                <div class="p-profile__exp-label g-mb10">
                    Please specify *
                </div>
                <?= $form->field($model, 'description')
                    ->textarea([
                        'class' => 'p-profile__exp-textarea',
                        'placeholder' => 'Please specify'
                    ])
                ?>
            </div>
        </div>

        <div class="p-profile__block">
            <h2 class="g-mb20">
                Highest education level obtained
                <span class="fa fa-info-circle" data-toggle="tooltip"
                      title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor"></span>
            </h2>

            <?= $form->field($model, 'education_id')
                ->dropDownList($education, [
                    'class' => 'form-control form-control-lg',
                ])
            ?>
        </div>

        <div class="p-profile__block">
            <h2 class="g-mb20">
                What format are you open to teaching in?
                <span class="fa fa-info-circle" data-toggle="tooltip"
                      title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor"></span>
            </h2>

            <div class="g-mb20">
                <?= $form->field($model, 'teach_type_id')
                    ->radioList($teachingTypes, [
                        'item' => static function ($index, $label, $name, $checked, $value) {
                            $check = $checked ? ' checked' : '';
                            $return = ($value === 1) ?
                                '<label class="ui-checkbox g-mr15">' :
                                '<label class="ui-checkbox g-mr15 js-showLink" data-show="formatToTeaching">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
                            $return .= '<span class="ui-radio__decor"></span>';
                            $return .= '<span class="ui-radio__text">' . strtoupper($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ])
                ?>
            </div>

            <div class="js-categoryFaculty">
                <div class="js-cfBlock g-mb20">
                    <div class="p-profile__select2<?= ($model->teach_type_id > 1) ? '' : ' p-profile__hidden' ?>"
                         id="formatToTeaching">
                        <?= $form->field($model, 'teach_locations')
                            ->dropDownList($areas, [
                                'multiple' => 'multiple',
                                'class' => 'p-profile__select2-select js-select2',
                            ])
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-profile__block">
            <h2 class="g-mb20">What type of teaching are you available for? </h2>

            <div class="g-mb15">
                <?= $form->field($model, 'teach_period_id')
                    ->radioList($teachingPeriods, [
                        'item' => static function ($index, $label, $name, $checked, $value) {
                            $check = $checked ? ' checked' : '';
                            $return = '<div class="g-mb15">';
                            $return .= '<label class="ui-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
                            $return .= '<span class="ui-radio__decor"></span>';
                            $return .= '<span class="ui-radio__text">' . strtoupper($label) . '</span>';
                            $return .= '</label></div>';

                            return $return;
                        }
                    ])
                ?>
            </div>
        </div>


        <div class="p-profile__block">
            <h2 class="g-mb20">What is your availability?</h2>

            <?= $form->field($model, 'teach_time_id')
                ->radioList($teachingTimes, [
                    'item' => static function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? ' checked' : '';
                        $return = '<div class="g-mb20">';
                        $return .= '<label class="ui-radio">';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
                        $return .= '<span class="ui-radio__decor"></span>';
                        $return .= '<span class="ui-radio__text">' . strtoupper($label) . '</span>';
                        $return .= '</label></div>';

                        return $return;
                    }
                ])
            ?>
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