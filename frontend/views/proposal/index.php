<?php

use common\models\Proposal;
use common\models\User;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\log\Logger;
use yii\web\View;

/* @var $this View */
/* @var $proposals Proposal[] */
/* @var $user User */

$this->title = 'Proposals';

try {
    $this->registerCssFile('@web/css/feed-auth.css', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}
?>

<div class="p-feed">
    <h1 class="p-jobs__title"><?= Html::encode($this->title) ?></h1>

    <div id="itemList" class="g-vlist">
        <?php foreach ($proposals as $proposal) : ?>
            <?= $this->render('@frontend/views/vacancy/_one_adjunct', [
                'model' => $proposal->vacancy,
                'adjunct' => $user->profile
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>
