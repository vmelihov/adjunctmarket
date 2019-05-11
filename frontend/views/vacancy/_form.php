<?php

use common\models\Area;
use common\models\Education;
use common\models\Specialty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use common\src\helpers\Helper;
use frontend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('@web/extension/select2/select2.min.css', ['depends' => [AppAsset::class]]);
$this->registerCssFile('@web/css/createjobs.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/extension/bootstrap-4.0.0/js/popper.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/extension/select2/select2.min.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/js/searchjob.js', ['depends' => [AppAsset::class]]);

$specialties = ArrayHelper::map(Specialty::find()->all(), 'id', 'nameWithFaculty');
$areas = ArrayHelper::map(Area::find()->all(), 'id', 'nameWithState');
$educations = ArrayHelper::map(Education::find()->all(), 'id', 'name');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');

$user = Helper::getUserIdentity();
?>

<?php $form = ActiveForm::begin([
    'id' => 'create-vacancy-form',
    'fieldConfig' => [
        'template' => "{input}\n{error}",
    ],
]); ?>

<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'institution_id')->hiddenInput(['value' => $user->profile->id])->label(false) ?>

<div class="p-cj__block">
    <div class="row">
        <div class="col-sm-6">
            <div class="p-cj__sub-title">Title</div>
            <?= $form->field($model, 'title')->textInput([
                'maxlength' => true,
                'class' => 'form-control form-control-lg',
                'placeholder' => 'Title jobs'
            ]) ?>
        </div>
    </div>
</div>

<div class="p-cj__block">
    <div class="p-cj__sub-title">Description</div>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'class' => 'form-control']) ?>
</div>

<div class="p-cj__block">
    <div class="row">
        <div class="col-sm-6 g-mb20">
            <div class="p-cj__sub-title">Select speciality</div>
            <?= $form->field($model, 'specialty_id')->dropDownList($specialties, [
                'class' => 'form-control form-control-lg',
            ]) ?>
        </div>
        <div class="col-sm-6">
            <div class="p-cj__sub-title">Select location</div>
            <?= $form->field($model, 'area_id')->dropDownList($areas, [
                'class' => 'form-control form-control-lg',
            ]) ?>
        </div>
    </div>
</div>

<div class="p-cj__block">
    <div class="row">
        <div class="col-sm-6">
            <div class="p-cj__sub-title">Highest education level obtained</div>
            <?= $form->field($model, 'education_id')
                ->dropDownList($educations, [
                    'class' => 'form-control form-control-lg',
                ])
            ?>
        </div>
    </div>
    </div>

<div class="p-cj__block">
    <div class="row">
        <div class="col-sm-4 g-mb20">
            <div class="p-cj__sub-title">Teaching experience</div>
            <div class="g-mb10">
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
        </div>

        <div class="col-sm-4 g-mb20">
            <div class="p-cj__sub-title">Type of teaching</div>
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

        <div class="col-sm-4">
            <div class="p-cj__sub-title">Availability</div>
            <?= $form->field($model, 'teach_time_id')
                ->radioList($teachingTimes, [
                    'item' => static function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? ' checked' : '';
                        $return = '<div class="g-mb10">';
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
</div>

<div class="p-cj__submit">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
</div>

<?php ActiveForm::end(); ?>
