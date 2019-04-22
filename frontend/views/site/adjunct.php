<?php

use common\models\Area;
use common\models\Education;
use common\models\Faculty;
use common\models\TeachingPeriod;
use common\models\TeachingTime;
use common\models\TeachingType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adjunct */
/* @var $form ActiveForm */

$faculties = ArrayHelper::map(Faculty::find()->all(), 'id', 'name');
$teachingTypes = ArrayHelper::map(TeachingType::find()->all(), 'id', 'name');
$teachingTimes = ArrayHelper::map(TeachingTime::find()->all(), 'id', 'name');
$teachingPeriods = ArrayHelper::map(TeachingPeriod::find()->all(), 'id', 'name');
$education = ArrayHelper::map(Education::find()->all(), 'id', 'name');
$areas = ArrayHelper::map(Area::find()->all(), 'id', 'name');

?>
<div class="adjunct">

    <?php $form = $formGoogle = ActiveForm::begin([
        'id' => 'google-auth-form',
        'action' => Url::to(['adjunct/profile']),
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'faculties')->dropDownList($faculties, ['multiple' => 'multiple'])->label('Choose category faculty') ?>

    <?= $form->field($model, 'teaching_experience_type_id')->radioList($teachingTypes)->label('') ?>
    <?= $form->field($model, 'description')->textarea()->label('Please specify * ') ?>

    <?= $form->field($model, 'education_id')->dropDownList($education)->label('Highest education level obtained') ?>

    <?= $form->field($model, 'teach_type_id')->radioList($teachingTypes)->label('What format are you open to teaching in?') ?>
    <?= $form->field($model, 'teach_locations')->dropDownList($areas, ['multiple' => 'multiple']) ?>

    <?= $form->field($model, 'teach_period_id')->radioList($teachingPeriods)->label('What type of teaching are you available for? ') ?>

    <?= $form->field($model, 'teach_time_id')->radioList($teachingTimes)->label('What is your availability?') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'confirm')->checkbox(['checked' => true]) ?>

    <?php ActiveForm::end(); ?>

</div><!-- adjunct -->
