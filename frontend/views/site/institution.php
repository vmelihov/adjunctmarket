<?php

use common\src\helpers\DictionaryHelper;
use frontend\assets\AppAsset;
use frontend\forms\InstitutionProfileForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model InstitutionProfileForm */

$this->registerCssFile('@web/extension/selectize/css/selectize.css', ['depends' => [AppAsset::class]]);
$this->registerCssFile('@web/css/profile-institution.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/profile-institution.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/validation.js', ['depends' => [AppAsset::class]]);

$this->title = 'Institution Profile';

$dictionaryHelper = new DictionaryHelper();
$universities = $dictionaryHelper->prepareUniversity()->getResult();

?>

    <div class="p-prflinst">
        <div class="p-prflinst__settings">
            <div class="p-prflinst__settings-ava">
                <img src="https://www.harvard.edu/sites/default/files/user13/harvard_shield_wreath.png"
                     alt="" class="p-prflinst__settings-ava-img"/>
                <div class="p-prflinst__settings-ava-status" title="Offline"></div>
                <div class="p-prflinst__settings-ava-status m-online" title="Online"></div>
            </div>

            <div class="p-prflinst__settings-name">
                <?= Html::encode($universities[$model->university_id]) ?>
            </div>
            <div class="p-prflinst__settings-status">
                <?= Html::encode($model->first_name . ' ' . $model->last_name) ?> <?= $model->position ? ' - ' . Html::encode($model->position) : '' ?>
            </div>

            <div class="p-prflinst__settings-right">
                <div class="p-prflinst__settings-right-add">
                    <a href="" class="p-prflinst__settings-right-add-link">Publish a vacancy</a>
                </div>
            </div>
        </div>

        <div class="p-prflinst__settings-content" style="display: block">
            <?php $form = ActiveForm::begin([
                'id' => 'institution-profile-form',
                'options' => [
                    'class' => 'p-prflinst__sform',
//                'data-validate' => '6',
                ],
                'action' => Url::to(['institution/profile']),
                'fieldConfig' => [
                    'template' => "{input}\n{error}",
                    'options' => [
                        'tag' => false,
                    ],
                ],
            ]); ?>

            <div class="p-prflinst__sform-block">
                <div class="p-prflinst__sform-block-title">
                    Edit Userpic
                </div>
                <div class="p-prflinst__sform-block-upload">
                    Upload a picture
                </div>
                <div class="p-prflinst__sform-block-tooltip">
                    <div class="p-prflinst__sform-block-tooltip-question">?</div>
                    <div class="p-prflinst__sform-block-tooltip-popup">
                        Upload the symbol of institution to make your profile more recognizable
                    </div>
                </div>
            </div>

            <div class="p-prflinst__sform-block">
                <div class="p-prflinst__sform-block-title">
                    General Settings
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-prflinst__sform-block-iblock js-validateblock">
                            <div class="p-prflinst__sform-block-iblock-label">First name</div>
                            <div class="p-prflinst__sform-block-iblock-icon fal fa-check js-validateblockOk"></div>

                            <?= $form->field($model, 'first_name')->textInput([
                                'class' => 'p-prflinst__sform-block-iblock-input js-textValidation',
                            ]) ?>

                            <div class="p-prflinst__sform-block-iblock-error js-validateblockError">
                                Please enter any
                                words
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-prflinst__sform-block-iblock js-validateblock">
                            <div class="p-prflinst__sform-block-iblock-label">Last name</div>
                            <div class="p-prflinst__sform-block-iblock-icon fal fa-check js-validateblockOk"></div>

                            <?= $form->field($model, 'last_name')->textInput([
                                'class' => 'p-prflinst__sform-block-iblock-input js-textValidation',
                            ]) ?>

                            <div class="p-prflinst__sform-block-iblock-error js-validateblockError">
                                Please enter any
                                words
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-prflinst__sform-block-iblock js-validateblock">
                            <div class="p-prflinst__sform-block-iblock-icon fal fa-check js-validateblockOk"></div>

                            <?= $form->field($model, 'email')->textInput([
                                'class' => 'p-prflinst__sform-block-input js-mailValidation',
                                'placeholder' => 'Work email address',
                                'type' => 'email',
                            ]) ?>

                            <div class="p-prflinst__sform-block-iblock-error js-validateblockError">
                                Please enter any
                                words
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-prflinst__sform-block-iblock js-validateblock">
                            <div class="p-prflinst__sform-block-iblock-label">Position</div>
                            <div class="p-prflinst__sform-block-iblock-icon fal fa-check js-validateblockOk"></div>

                            <?= $form->field($model, 'position')->textInput([
                                'class' => 'p-prflinst__sform-block-iblock-input js-textValidation',
                            ]) ?>

                            <div class="p-prflinst__sform-block-iblock-error js-validateblockError">
                                Please enter any
                                words
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-prflinst__sform-block-iblock js-validateblock">
                    <div class="p-prflinst__sform-block-iblock-label">Educational institution</div>

                    <?= $form->field($model, 'university_id')
                        ->dropDownList($universities, [
                            'class' => 'js-selectize',
                        ])
                    ?>
                </div>
            </div>

            <div class="p-prflinst__sform-block">
                <div class="p-prflinst__sform-block-title">
                    Security
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-prflinst__sform-block-iblock js-validateblock js-passParent">
                            <div class="js-passLine">
                                <div class="p-prflinst__sform-block-iblock-icon js-passEye fa fa-eye"></div>
                                <input placeholder="Password" type="password"
                                       class="p-prflinst__sform-block-input js-passInput js-passValidation js-passValidation1"/>
                            </div>
                            <div class="js-passLine d-none">
                                <div class="p-prflinst__sform-block-iblock">
                                    <div class="p-prflinst__sform-block-iblock-icon js-passEye fa fa-eye-slash"></div>
                                    <input placeholder="Password" type="text"
                                           class="p-prflinst__sform-block-input js-notPassInput"/>
                                </div>
                            </div>

                            <div class="p-prflinst__sform-block-iblock-error js-validateblockError">
                                Please enter any words
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-prflinst__sform-block-iblock js-validateblock js-passParent">
                            <div class="js-passLine">
                                <div class="p-prflinst__sform-block-iblock">
                                    <div
                                            class="p-prflinst__sform-block-iblock-icon js-passEye fa fa-eye">
                                    </div>
                                    <input placeholder="Confirm pasword" type="password"
                                           class="p-prflinst__sform-block-input js-passInput js-passValidation js-passValidation2"/>
                                </div>
                            </div>
                            <div class="js-passLine d-none">
                                <div class="p-prflinst__sform-block-iblock">
                                    <div
                                            class="p-prflinst__sform-block-iblock-icon js-passEye fa fa-eye-slash">
                                    </div>
                                    <input placeholder="Confirm pasword" type="text"
                                           class="p-prflinst__sform-block-input js-notPassInput"/>
                                </div>
                            </div>

                            <div class="p-prflinst__sform-block-iblock-error js-validateblockError">
                                Password dont match
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-prflinst__sform-block">
                <?= Html::submitButton('Apply changes', ['class' => 'p-prflinst__sform-block-submit js-submit']) ?>
            </div>

            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php
$script = <<< JS
    $('.js-selectize').selectize({
        create: true,
        sortField: 'text'
    });
JS;
$this->registerJs($script, View::POS_READY);
?>