<?php

use common\models\Area;
use common\models\Education;
use common\models\Specialty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use common\models\User;
use common\src\helpers\FileHelper;
use common\src\helpers\HtmlHelper;
use common\src\helpers\UserImageHelper;
use frontend\assets\AppAsset;
use frontend\forms\AdjunctProfileForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\log\Logger;
use yii\web\View;

/* @var $this View */
/* @var $model AdjunctProfileForm */
/* @var $form ActiveForm */
/* @var $user User */

try {
    $this->registerCssFile('@web/extension/selectize/css/selectize.css');
    $this->registerCssFile('@web/css/profile-edit-adjunct.css', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/validation.js', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$this->title = 'Adjunct profile';

$specialities = ArrayHelper::map(Specialty::findWithFacultyName(), 'id', 'name', 'faculty');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
$education = ArrayHelper::map(Education::find()->all(), 'id', 'name');
$areas = ArrayHelper::map(Area::find()->all(), 'id', 'nameWithState');

$specialitiesArray = explode(' ', $model->specialities);
?>

<div class="p-epa">
    <div class="p-epa__menu-chosen js-tabLinkChosen">
        General Settings
    </div>
    <div class="p-epa__menu js-tabMenu">
        <div class="p-epa__menu-link js-tabLink active" data-tab="general">
            General Settings
        </div>
        <div id="ooooooo" class="p-epa__menu-link js-tabLink" data-tab="information">
            Information
        </div>
        <div class="p-epa__menu-link js-tabLink" data-tab="security">
            Security
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'adjunct-profile-form',
        'action' => Url::to(['adjunct/profile']),
        'fieldConfig' => [
            'template' => "{input}\n{error}",
            'options' => [
                'tag' => false,
            ],
            'errorOptions' => [
                'class' => 'p-epa__tab-iblock-error js-validateblockError',
                'tag' => 'div',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <div class="p-epa__tab js-tab active" id="general">
        <div class="p-epa__tab-title">General Settings</div>
            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    Edit category faculty
                </div>

                <div class="ui-hardselect js-hardSelect">
                    <div class="ui-hardselect__select js-hardSelectS">
                        <div class="ui-hardselect__select-btn js-hardSelectBtn">
                            <div class="ui-hardselect__select-btn-text">
                                Select category
                            </div>
                            <div class="ui-hardselect__select-btn-icon fal fa-chevron-down">
                            </div>
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
                                                <li<?= in_array($specialityId, $specialitiesArray, false) ? ' class="chosen"' : '' ?>
                                                        data-name="<?= $specialityId ?>">
                                                    <?= $speciality ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="ui-hardselect__body js-hardSelectBody" style="display: block">
                        <?php foreach ($specialities as $faculty => $specialityArray):
                            foreach ($specialityArray as $specialityId => $speciality):
                                if (in_array($specialityId, $specialitiesArray, false)): ?>
                                    <div class="ui-hardselect__body-item">
                                        <?= $speciality ?>&nbsp;<i class="ui-hardselect__body-item-icon fal fa-times"
                                                                   data-cat="<?= $faculty ?>"
                                                                   data-item="<?= $specialityId ?>"></i>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>

                    <?= $form->field($model, 'specialities')->hiddenInput(['class' => 'js-hardSelectInput']) ?>
                </div>
            </div>

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    Do you have teaching experience?
                </div>
                <div class="g-mb20">
                    <label class="ui-radio g-mr15 js-showLink" data-show="expirienceBlock">
                        <input type="radio" name="teaching_experience"
                               value="1" <?= $model->teaching_experience_type_id ? 'checked' : '' ?>/>
                        <span class="ui-radio__decor"></span>
                        <span class="ui-radio__text">Yes</span>
                    </label>
                    <label class="ui-radio js-hideLink" data-hide="expirienceBlock">
                        <input type="radio" name="teaching_experience" value="0"/>
                        <span class="ui-radio__decor"></span>
                        <span class="ui-radio__text">No</span>
                    </label>
                </div>

                <div class="p-epa__tab-block-exp" id="expirienceBlock" <?= $model->teaching_experience_type_id ? 'style="display: block"' : '' ?>>
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
                </div>
            </div>

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    Highest education level obtained
                </div>

                <div class="p-epa__tab-block-tooltip-line">
                    <?= $form->field($model, 'education_id')
                        ->dropDownList($education, [
                            'class' => 'js-selectize',
                        ])
                    ?>

                    <div class="p-epa__tab-block-tooltip g-mt10" data-toggle="tooltip"
                         title="Select «Both» to get more proposals for work">?</div>
                </div>
            </div>

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
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
                                $return .= '<span class="ui-radio__text">' . $label . '</span>';
                                $return .= '</label>';

                                return $return;
                            }
                        ])
                    ?>
                </div>

                <div class="p-profile__hidden" id="formatToTeaching">
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

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    Type of teaching
                </div>

                <?= $form->field($model, 'teach_period_id')
                    ->radioList($teachingPeriods, [
                        'item' => HtmlHelper::getCallbackRadioItem(),
                    ])
                ?>
            </div>

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    What is your availability?
                </div>

                <?= $form->field($model, 'teach_time_id')
                    ->radioList($teachingTimes, [
                        'item' => HtmlHelper::getCallbackRadioItem(),
                    ])
                ?>
            </div>

            <?= Html::submitButton('Apply changes', ['class' => 'p-epa__tab-submit']) ?>
    </div>

    <div class="p-epa__tab js-tab" id="information">
        <div class="p-epa__tab-title">Information</div>

            <div class="p-epa__tab-block m-ava">
                <div class="p-epa__tab-block-ava">
                    <img class="p-epa__tab-block-ava-img" src="<?= UserImageHelper::getUrl($user) ?>" alt="" />
                </div>
                <div class="p-epa__tab-block-label">
                    Edit Userpic
                </div>
                <div class="p-epa__tab-block-upload">
                    Upload a picture
                    <?= $form->field($model, 'image_file')->fileInput([
                            'class' => 'p-epa__tab-block-upload-input',
                    ]) ?>
                </div>
            </div>

            <div class="p-epa__tab-block">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-epa__tab-iblock js-validateblock">
                            <div class="p-epa__tab-iblock-label">First name</div>
                            <div class="p-epa__tab-iblock-icon fal fa-check js-validateblockOk">
                            </div>

                            <?= $form->field($model, 'first_name')->textInput([
                                    'class' => 'p-epa__tab-iblock-input js-textValidation',
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-epa__tab-iblock js-validateblock">
                            <div class="p-epa__tab-iblock-label">Last name</div>
                            <div class="p-epa__tab-iblock-icon fal fa-check js-validateblockOk">
                            </div>

                            <?= $form->field($model, 'last_name')->textInput([
                                'class' => 'p-epa__tab-iblock-input js-textValidation',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-epa__tab-iblock js-validateblock">
                            <div class="p-epa__tab-iblock-icon fal fa-check js-validateblockOk">
                            </div>

                            <?= $form->field($model, 'email')
                                ->input('email', [
                                    'class' => 'p-epa__tab-block-input js-mailValidation',
                                    'placeholder' => 'Work email address',
                            ]) ?>

                            <?php if ($eEmail = $model->getFirstError('email')): ?>
                                <div class="p-epa__tab-iblock-error js-validateblockError"
                                     style="display: block"><?= $eEmail ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="p-epa__tab-iblock js-validateblock">
                            <div class="p-epa__tab-iblock-icon fal fa-check js-validateblockOk">
                            </div>

                            <?= $form->field($model, 'phone')
                                ->input('tel', [
                                    'class' => 'p-epa__tab-block-input js-textValidation',
                                    'placeholder' => 'Cellphone',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="p-epa__tab-iblock">
                    <div class="p-epa__tab-iblock-label">Select location</div>
                    <?= $form->field($model, 'location_id')
                        ->dropDownList($areas, [
                            'id' => 'location',
                            'placeholder' => 'Select location',
                            'class' => 'js-selectize',
                        ])
                    ?>
                </div>
            </div>

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    About You
                </div>

                <?= $form->field($model, 'description')
                    ->textarea([
                        'class' => 'p-epa__tab-block-textarea',
                    ])
                ?>
            </div>

            <div class="p-epa__tab-iblock">
                <div class="p-epa__tab-iblock-label">
                    Your LinkedIn Profile
                </div>

                <?= $form->field($model, 'linledin')
                    ->input('url', [
                        'class' => 'p-epa__tab-iblock-input',
                        'placeholder' => 'https://link.com',
                    ])
                ?>
            </div>

            <div class="p-epa__tab-iblock">
                <div class="p-epa__tab-iblock-label">
                    Your Facebook Profile
                </div>

                <?= $form->field($model, 'facebook')
                    ->input('url', [
                        'class' => 'p-epa__tab-iblock-input',
                        'placeholder' => 'https://link.com',
                    ])
                ?>
            </div>

            <div class="p-epa__tab-iblock">
                <div class="p-epa__tab-iblock-label">
                    Your Whatsapp Number
                </div>

                <?= $form->field($model, 'whatsapp')
                    ->textInput([
                        'class' => 'p-epa__tab-iblock-input',
                    ])
                ?>
            </div>

            <div class="p-epa__tab-block">
                <div class="p-epa__tab-block-label">
                    Certifficates and Diplomas
                </div>
                <div class="p-epa__tab-block-upload">
                    Upload Documents
                    <?= $form->field($model, 'doc_files[]')->fileInput([
                        'class' => 'p-epa__tab-block-upload-input',
                        'multiple' => true,
                    ]) ?>
                </div>
            </div>

            <div class="p-epa__tab-block">
                <?php foreach ($model->getDocuments() as $document): ?>
                    <div class="p-epa__tab-block-sertificate">
                        <a href="<?= Url::to(['adjunct/unlink', 'fileName' => $document]) ?>"
                           class="p-epa__tab-block-sertificate-del fal fa-times"></a>
                        <img src="<?= FileHelper::getDocumentUrl($user->getId(), $document) ?>"
                             alt="" class="p-epa__tab-block-sertificate-img"/>
                        <div class="p-epa__tab-block-sertificate-name"><?= $document ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?= Html::submitButton('Apply changes', ['class' => 'p-epa__tab-submit']) ?>
    </div>

    <div class="p-epa__tab js-tab" id="security">
        <div class="p-epa__tab-title">Password Changing</div>

        <div class="p-epa__tab-iblock js-validateblock js-passParent">
            <div class="js-passLine">
                <div class="p-epa__tab-iblock-icon js-passEye fa fa-eye">
                </div>
                <?= $form->field($model, 'old_password')->passwordInput([
                    'class' => 'p-epa__tab-block-input js-passInput js-textValidation',
                    'placeholder' => 'Old Password',
                ]) ?>

                <?php if ($eOldPass = $model->getFirstError('old_password')): ?>
                    <div class="p-epa__tab-iblock-error js-validateblockError"
                         style="display: block"><?= $eOldPass ?></div>
                <?php endif; ?>
            </div>
            <div class="js-passLine d-none">
                <div class="p-epa__tab-iblock">
                    <div class="p-epa__tab-iblock-icon js-passEye fa fa-eye-slash">
                    </div>
                    <input placeholder="Old Password" type="text"
                           class="p-epa__tab-block-input js-notPassInput"/>
                </div>
            </div>
        </div>

        <div class="p-epa__tab-iblock js-validateblock js-passParent">
            <div class="js-passLine">
                <div class="p-epa__tab-iblock-icon js-passEye fa fa-eye">
                </div>

                <?= $form->field($model, 'new_password')->passwordInput([
                    'class' => 'p-epa__tab-block-input js-passInput js-passValidation js-passValidation1',
                    'placeholder' => 'New Password',
                ]) ?>
            </div>
            <div class="js-passLine d-none">
                <div class="p-epa__tab-iblock">
                    <div class="p-epa__tab-iblock-icon js-passEye fa fa-eye-slash">
                    </div>
                    <input placeholder="New Password" type="text"
                           class="p-epa__tab-block-input js-notPassInput"/>
                </div>
            </div>
        </div>

        <div class="p-epa__tab-iblock js-validateblock js-passParent">
            <div class="js-passLine">
                <div class="p-epa__tab-iblock">
                    <div class="p-epa__tab-iblock-icon js-passEye fa fa-eye">
                    </div>

                    <?= $form->field($model, 'repeat_password')->passwordInput([
                        'class' => 'p-epa__tab-block-input js-passInput js-passValidation js-passValidation2',
                        'placeholder' => 'Confirm Password',
                    ]) ?>
                </div>
            </div>
            <div class="js-passLine d-none">
                <div class="p-epa__tab-iblock">
                    <div class="p-epa__tab-iblock-icon js-passEye fa fa-eye-slash">
                    </div>
                    <input placeholder="Confirm pasword" type="text"
                           class="p-epa__tab-block-input js-notPassInput"/>
                </div>
            </div>

            <div class="p-epa__tab-iblock-error js-validateblockError">
                Password dont match
            </div>
        </div>

        <?= Html::submitButton('Apply changes', ['class' => 'p-epa__tab-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
    $('#adjunct-profile-form').on('afterValidate', function(e, m) {
        $.each(m, function(key, errors){
            var id = '#' + key;
            if (typeof errors !== 'undefined' && errors.length > 0) {
                $(id).parent().children('.p-epa__tab-iblock-error').text(errors[0]).show();
            } else {
                $(id).parent().children('.p-epa__tab-iblock-error').text('').hide();
            }
        });

        return true;
    });

    $('.js-selectize').selectize({
        create: true,
        sortField: 'text'
    });

    $('[data-toggle="tooltip"]').tooltip();

    var tabLink = $(".js-tabLink"),
        tab = $(".js-tab"),
        tabMenu = $(".js-tabMenu"),
        chosen = $(".js-tabLinkChosen");
    
    tabLink.on("click", function () {
        var _this = $(this);
        tabLink.removeClass("active");
        _this.addClass("active");

        tab.removeClass("active");
        $("#" + _this.data("tab")).addClass("active");

        if ($(window).width() < 768) {
            chosen.text(_this.text()).toggleClass("active");
            tabMenu.slideToggle();
        }
    });

    chosen.on("click", function () {
        tabMenu.slideToggle();
        chosen.toggleClass("active");
    });
    
    
    $('#ooooooo').click();
JS;
$this->registerJs($script, View::POS_END);
?>