<?php

use common\models\Area;
use common\models\Education;
use common\models\Specialty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use common\src\helpers\HtmlHelper;
use frontend\assets\AppAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\VacancySearch */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('@web/css/feed.css', ['depends' => [AppAsset::class]]);
$this->registerCssFile('@web/extension/selectize/css/selectize.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/js/vacancy-card.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/feed.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);

$specialities = ArrayHelper::map(Specialty::findWithFacultyName(), 'id', 'name', 'faculty');
$areas = ArrayHelper::map(Area::findWithStateName(), 'id', 'name', 'state');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
$education = ArrayHelper::map(Education::find()->all(), 'id', 'name');
?>

<div class="p-feed__filter-content js-filterContent" style="display: none;">

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

    <div class="p-feed__filter-content-header">
        <div class="row">
            <div class="col-md-6">
                <div class="p-feed__filter-content-block">
                    <div class="p-feed__filter-content-block-title">
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
                <div class="p-feed__filter-content-block">
                    <div class="p-feed__filter-content-block-title">
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

        <div class="p-feed__filter-content-block">
            <div class="p-feed__filter-content-block-title">
                Higest education level obtained
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-feed__filter-content-block-select">
                        <select class="js-selectize">
                            <option></option>
                            <?php foreach ($education as $item): ?>
                                <option><?= $item ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="p-feed__filter-content-block">
                <div class="p-feed__filter-content-block-title">
                    Teaching experience
                </div>

                <label class="ui-radio g-mr30 js-showLink" data-show="expirienceBlock">
                    <input type="radio" name="exp"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">Yes</span>
                </label>
                <label class="ui-radio js-hideLink" data-hide="expirienceBlock">
                    <input type="radio" name="exp"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">No</span>
                </label>
            </div>

            <div class="p-feed__filter-content-block" id="expirienceBlock">
                <?= $form->field($model, 'teach_type_id')
                    ->radioList($teachingTypes, [
                        'item' => HtmlHelper::getCallbackRadioItem(),
                    ])
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-feed__filter-content-block">
                <div class="p-feed__filter-content-block-title">
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
            <div class="p-feed__filter-content-block">
                <div class="p-feed__filter-content-block-title">
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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <div class="p-feed__filter-content-btns">
        <a class="p-feed__filter-content-btns-reset" href="">Reset filters</a>
        <div class="p-feed__filter-content-btns-one">
            <div class="p-feed__filter-content-btns-one-btn">Search</div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
