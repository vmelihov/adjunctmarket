<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\forms\SignupForm */
/* @var $form ActiveForm */
?>
<div class="signup">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_type')->radioList(User::getUserTypes()) ?>

    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'email')->textInput([
        'type' => 'email',
    ])->label(false) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model, 'confirm')->checkbox(['checked' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
