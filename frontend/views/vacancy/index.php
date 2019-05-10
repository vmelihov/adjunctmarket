<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vacancies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancy-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Vacancy', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'institution_id',
            'title',
            'description',
            'faculty_id',
            //'area_id',
            //'education_id',
            //'teach_type_id',
            //'teach_time_id:datetime',
            //'teach_period_id',
            //'deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
