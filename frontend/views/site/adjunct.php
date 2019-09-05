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

$this->registerCssFile('@web/extension/selectize/css/selectize.css');
$this->registerCssFile('@web/css/profile-type.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/profile-type.js', ['depends' => [AppAsset::class]]);

$this->title = 'Adjunct profile';

$specialities = ArrayHelper::map(Specialty::findWithFacultyName(), 'id', 'name', 'faculty');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
$education = ArrayHelper::map(Education::find()->all(), 'id', 'name');
$areas = ArrayHelper::map(Area::find()->all(), 'id', 'nameWithState');
?>

    <div class="p-profile g-content">
        <h1 class="p-profile__title">
            Creating User Profile
        </h1>

        <?php $form = ActiveForm::begin([
            'id' => 'adjunct-profile-form',
            'action' => Url::to(['adjunct/profile']),
            'fieldConfig' => [
                'template' => "{input}\n{error}",
                'options' => [
                    'tag' => false,
                ],
            ],
        ]); ?>

        <div class="p-profile__block">
            <div class="p-profile__block-label">
                Choose category faculty
            </div>

            <div class="ui-hardselect js-hardSelect">
                <div class="ui-hardselect__select js-hardSelectS">
                    <div class="ui-hardselect__select-btn js-hardSelectBtn">
                        <div class="ui-hardselect__select-btn-text">
                            Select category
                        </div>
                        <div class="ui-hardselect__select-btn-icon fa fa-chevron-down"></div>
                    </div>

                    <div class="ui-hardselect__select-drdn">
                        <ul>
                            <?php foreach ($specialities as $faculty => $specialityArray): ?>
                                <li data-name="<?= $faculty ?>">
                                    <div class="ui-hardselect__select-drdn-title">
                                        <?= $faculty ?>
                                    </div>

                                    <ul>
                                        <?php foreach ($specialityArray as $specialityId => $speciality): ?>
                                            <li data-name="<?= $specialityId ?>">
                                                <?= $speciality ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="ui-hardselect__body js-hardSelectBody"></div>
                <?= $form->field($model, 'specialities')->hiddenInput(['class' => 'js-hardSelectInput']) ?>
            </div>
        </div>

        <div class="p-profile__block">
            <div class="p-profile__block-label">
                Do you have teaching experience?
            </div>
            <div class="g-mb20">
                <label class="ui-radio g-mr15 js-showLink" data-show="expirienceBlock">
                    <input type="radio" name="exp" <?= $model->teaching_experience_type_id ? 'checked' : '' ?>/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">Yes</span>
                </label>
                <label class="ui-radio js-hideLink" data-hide="expirienceBlock">
                    <input type="radio" name="exp"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">No</span>
                </label>
            </div>

            <div class="p-profile__exp" id="expirienceBlock">
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
            <div class="p-profile__block-label">
                Highest education level obtained
            </div>

            <div class="p-profile__block-tooltip-line">
                <?= $form->field($model, 'education_id')
                    ->dropDownList($education, [
                        'class' => 'ui-select',
                    ])
                ?>
                <div class="p-profile__block-tooltip g-mt10" data-toggle="tooltip"
                     title="Select «Both» to get more proposals for work">?
                </div>
            </div>
        </div>

        <div class="p-profile__block">
            <div class="p-profile__block-label">
                What format are you open to teaching in?
            </div>

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

            <div id="formatToTeaching"<?= ($model->teach_type_id > 1) ? '' : ' class="p-profile__hidden" ' ?>>
                <div class="g-selectize">
                    <div class="g-selectize-label">Select location</div>
                    <?= $form->field($model, 'teach_locations')
                        ->dropDownList($areas, [
                            'placeholder' => 'Select location',
                            'class' => 'js-selectize',
                        ])
                    ?>
                </div>
            </div>
        </div>

        <div class="p-profile__block">
            <div class="p-profile__block-label">
                Type of teaching
            </div>

            <?= $form->field($model, 'teach_period_id')
                ->radioList($teachingPeriods, [
                    'item' => static function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? ' checked' : '';
                        $return = '<div class="g-mb15">';
                        $return .= '<label class="ui-radio">';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '"' . $check . '>';
                        $return .= '<span class="ui-radio__decor"></span>';
                        $return .= '<span class="ui-radio__text">' . $label . '</span>';
                        $return .= '</label></div>';

                        return $return;
                    }
                ])
            ?>
        </div>

        <div class="p-profile__block">
            <div class="p-profile__block-label">
                What is your availability?
            </div>

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

        <div class="p-profile__block">
            <div class="p-profile__submit">
                <?= Html::submitButton('APPLY', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>
        </div>

        <div class="p-profile__block">
            <div class="p-profile__read">
                <div class="p-profile__read-check">
                    <label class="ui-checkbox">
                        <input type="checkbox" name="" checked/>
                        <span class="ui-checkbox__decor"></span>
                    </label>
                </div>

                <div class="p-profile__read-text">
                    I have read and agree to the AdjunktMarket <a href="" target="_blank">Terms and
                        Conditions</a>
                    of Use and <a href="" target="_blank">Privacy Policy</a>.
                </div>
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