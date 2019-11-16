<?php

use common\src\helpers\DictionaryHelper;
use common\src\helpers\HtmlHelper;
use frontend\assets\AppAsset;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\log\Logger;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AdjunctSearch */
/* @var $form yii\widgets\ActiveForm */

try {
    $this->registerCssFile('@web/extension/selectize/css/selectize.css', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/extension/jquery.nicescroll.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
} catch (InvalidConfigException $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$dictHelper = new DictionaryHelper();
$specialities = $dictHelper->prepareSpecialtiesWithFacultyGroup()->getResult();
$areas = $dictHelper->prepareAreaWithStateGroup()->getResult();
$educations = $dictHelper->prepareEducation()->getResult();
$teachingTypes = $dictHelper->prepareTeachingType()->getResult();
$teachingTimes = $dictHelper->prepareTeachingTime()->getResult();
$teachingPeriods = $dictHelper->prepareTeachingPeriod()->getResult();
$education = $dictHelper->prepareEducation()->getResult();
?>

<div class="p-al__filter-content js-filterContent" style="display: none;">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => [
            'template' => "{input}\n{error}",
            'options' => [
                'tag' => false,
            ],
        ],
    ]); ?>
    <div class="p-al__filter-content-header">
        <div class="row">
            <div class="col-md-6">
                <div class="p-al__filter-content-block">
                    <div class="p-al__filter-content-block-title">
                        Select category
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
            </div>
            <div class="col-md-6">
                <div class="p-al__filter-content-block">
                    <div class="p-al__filter-content-block-title">
                        Select location
                    </div>
                    <div class="ui-hardselect js-hardSelect">
                        <div class="ui-hardselect__select js-hardSelectS">
                            <div class="ui-hardselect__select-btn js-hardSelectBtn">
                                <div class="ui-hardselect__select-btn-text">
                                    Select location
                                </div>
                                <div class="ui-hardselect__select-btn-icon fal fa-chevron-down">
                                </div>
                            </div>

                            <div class="ui-hardselect__select-drdn">
                                <ul>
                                    <?php foreach ($areas as $state => $areasArray): ?>
                                        <li data-name="<?= $state ?>">
                                            <div class="ui-hardselect__select-drdn-title">
                                                <?= $state ?>
                                            </div>

                                            <ul>
                                                <?php foreach ($areasArray as $areaId => $areaName): ?>
                                                    <li data-name="<?= $areaId ?>">
                                                        <?= $areaName ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="ui-hardselect__body js-hardSelectBody"></div>
                        <?= $form->field($model, 'areas')->hiddenInput(['class' => 'js-hardSelectInput']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-al__filter-content-block">
            <div class="p-al__filter-content-block-title">
                Higest education level obtained
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-al__filter-content-block-select">
                        <?= $form->field($model, 'education_id')
                            ->dropDownList($education, [
                                'prompt' => 'Select education',
                                'class' => 'js-selectize',
                            ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="p-al__filter-content-block">
                <div class="p-al__filter-content-block-title">
                    Teaching experience
                </div>

                <label class="ui-radio g-mr30 js-showLink" data-show="expirienceBlock">
                    <input type="radio" name="yn"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">Yes</span>
                </label>
                <label class="ui-radio js-hideLink" data-hide="expirienceBlock">
                    <input type="radio" name="yn"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">No</span>
                </label>
            </div>
            <div class="p-al__filter-content-block" id="expirienceBlock" style="display: none;">
                <?= $form->field($model, 'teach_type_id')
                    ->radioList($teachingTypes, [
                        'item' => HtmlHelper::getCallbackRadioItem(),
                    ])
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-al__filter-content-block">
                <div class="p-al__filter-content-block-title">
                    Type of teaching
                </div>
                <?= $form->field($model, 'teach_period_id')
                    ->radioList($teachingPeriods, [
                        'item' => HtmlHelper::getCallbackRadioItem(),
                    ])
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-al__filter-content-block">
                <div class="p-al__filter-content-block-title">
                    Aviability
                </div>
                <?= $form->field($model, 'teach_time_id')
                    ->radioList($teachingTimes, [
                        'item' => HtmlHelper::getCallbackRadioItem(),
                    ])
                ?>
            </div>
        </div>
    </div>

    <div class="p-al__filter-content-btns">
        <?= Html::a('Reset filters', ['index'], ['class' => 'p-al__filter-content-btns-reset']) ?>
        <div class="p-al__filter-content-btns-one">
            <?= Html::submitButton('Search', ['class' => 'p-al__filter-content-btns-one-btn']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
