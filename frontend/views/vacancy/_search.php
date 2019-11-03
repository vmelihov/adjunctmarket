<?php

use common\models\Area;
use common\models\Education;
use common\models\Specialty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use common\src\helpers\Helper;
use common\src\helpers\HtmlHelper;
use frontend\assets\AppAsset;
use frontend\models\VacanciesSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\VacanciesSearch */
/* @var $form yii\widgets\ActiveForm */

try {
    $this->registerCssFile('@web/extension/selectize/css/selectize.css', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/js/feed.js', ['depends' => [AppAsset::class]]);
    $this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$specialities = ArrayHelper::map(Specialty::findWithFacultyName(), 'id', 'name', 'faculty');
$areas = ArrayHelper::map(Area::findWithStateName(), 'id', 'name', 'state');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
$education = ArrayHelper::map(Education::find()->all(), 'id', 'name');

$user = Helper::getUserIdentity();
?>

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

    <div class="p-feed__filter">
        <div class="p-feed__filter-vacancies js-vacancies">
            <?php if ($user): ?>
                <a href="<?= Url::to(['vacancy/index']) ?>" class="p-feed__filter-vacancies-chosen">
                    <div class="p-feed__filter-vacancies-chosen-text">All Vacancies</div>
                    <div class="p-feed__filter-vacancies-chosen-icon fal fa-chevron-down"></div>
                </a>

                <a href="<?= Url::to(['index', 'ff' => VacanciesSearch::FAST_FILTER_RECOMMENDED]) ?>"
                   class="p-feed__filter-vacancies-chosen">
                    <div class="p-feed__filter-vacancies-chosen-text">Recomended</div>
                    <div class="p-feed__filter-vacancies-chosen-icon fal fa-chevron-down"></div>
                </a>
            <?php endif; ?>
        </div>

        <div class="p-feed__filter-sort">
            <?= $form->field($model, 'sort')->hiddenInput([
                'id' => 'user_type_input',
                'class' => 'js-sortInput',
            ]) ?>
            <div class="p-feed__filter-sort-text">Sort:</div>
            <div class="p-feed__filter-sort-drop dropdown">
                <div class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="p-feed__filter-sort-drop-chosen">
                        <div class="p-feed__filter-sort-drop-chosen-text js-sortText">
                            <?php if ($model->sort === VacanciesSearch::SORT_FEWEST_PROPOSALS) {
                                echo 'Fewest proposals';
                            } elseif ($model->sort === VacanciesSearch::SORT_RELEVANCE) {
                                echo 'Relevance';
                            } else {
                                echo 'Newest';
                            } ?>
                        </div>
                        <div class="p-feed__filter-sort-drop-chosen-icon fal fa-chevron-down">
                        </div>
                    </div>
                </div>
                <div class="dropdown-menu js-sortItems">
                    <div class="dropdown-item" data-form="<?= VacanciesSearch::SORT_NEWEST ?>">Newest</div>
                    <div class="dropdown-item" data-form="<?= VacanciesSearch::SORT_FEWEST_PROPOSALS ?>">Fewest
                        proposals
                    </div>
                    <?php if ($user): ?>
                        <div class="dropdown-item" data-form="<?= VacanciesSearch::SORT_RELEVANCE ?>">Relevance</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="p-feed__filter-options js-openFilter">
            <span class="p-feed__filter-options-text">
                Search options
            </span>
            <span class="p-feed__filter-options-icon far fa-sliders-h"></span>
        </div>
    </div>

    <div class="p-feed__filter-content js-filterContent" style="display: none;">
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
                            <?= $form->field($model, 'education_id')
                                ->dropDownList($education, [
                                    'class' => 'js-selectize',
                                    'prompt' => 'Select...',
                                ])
                            ?>
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

        <div class="p-feed__filter-content-btns">
            <?= Html::a('Reset filters', ['index'], ['class' => 'p-feed__filter-content-btns-reset']) ?>
            <div class="p-feed__filter-content-btns-one">
                <?= Html::submitButton('Search', ['class' => 'p-feed__filter-content-btns-one-btn']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>