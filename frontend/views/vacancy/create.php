<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

$this->title = 'Create Vacancy';
$this->params['breadcrumbs'][] = ['label' => 'Vacancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
