<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */

$this->registerCssFile('@web/css/create-vacancy.css', ['depends' => [AppAsset::class]]);

$this->title = 'Create Vacancy';
?>

<div class="p-cv g-content">
    <h1 class="p-cv__title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
