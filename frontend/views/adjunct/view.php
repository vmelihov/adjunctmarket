<?php

use common\models\Adjunct;
use common\models\Chat;
use common\models\User;
use common\src\helpers\FileHelper;
use common\src\helpers\UserImageHelper;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\View;

/** @var $this View */
/** @var $adjunct Adjunct */
/** @var $user User */

try {
    $this->registerCssFile('@web/css/profile-adjunct.css', ['depends' => [AppAsset::class]]);
} catch (Exception $e) {
    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
}

$adjunctUserId = $adjunct->user->getId();
$adjunctName = Html::encode($adjunct->user->getUsername());
$this->title = 'Adjunct - ' . $adjunctName;
?>

<div class="p-pa">
    <div class="p-pa__header">
        <div class="p-pa__header-block m-man">
            <div class="p-pa__header-block-ava">
                <img src="<?= UserImageHelper::getUrl($adjunct->user) ?>"
                     alt="" class="p-pa__header-block-ava-img">
                <!--                <div class="p-pa__header-block-ava-status" title="Offline"></div>-->
            </div>
            <a href="" class="p-pa__header-block-name">
                <?= $adjunctName ?>
            </a>
            <!--            <div class="p-pa__header-block-status m-busy">Busy</div>-->
            <div class="p-pa__header-block-place">
                <?= $adjunct->location->name ?>
            </div>
        </div>
        <div class="p-pa__header-block m-tel">
            <a href="telTo:+<?= $adjunct->phone ?>" class="p-pa__header-block-tel"><?= $adjunct->phone ?></a>
            <div class="p-pa__header-block-tel-title">Cellphone</div>
        </div>
        <div class="p-pa__header-block m-social">
            <?php if ($adjunct->linledin): ?>
                <a href="<?= $adjunct->linledin ?>" target="_blank"
                   class="p-pa__header-block-social fab fa-linkedin-in"></a>
            <?php else: ?>
                <span class="p-pa__header-block-social fab fa-linkedin-in m-none"></span>
            <?php endif; ?>

            <?php if ($adjunct->facebook): ?>
                <a href="<?= $adjunct->facebook ?>" target="_blank"
                   class="p-pa__header-block-social fab fa-facebook-f"></a>
            <?php else: ?>
                <span class="p-pa__header-block-social fab fa-facebook-f m-none"></span>
            <?php endif; ?>

            <?php if ($adjunct->whatsapp): ?>
                <a href="<?= $adjunct->whatsapp ?>" target="_blank"
                   class="p-pa__header-block-social fab fa-whatsapp"></a>
            <?php else: ?>
                <span class="p-pa__header-block-social fab fa-whatsapp m-none"></span>
            <?php endif; ?>
        </div>

        <?php if ($user->getId() === $adjunctUserId): ?>
            <div class="p-pa__header-block m-settings">
                <a href="<?= Url::to(['site/profile']) ?>" class="p-pa__header-block-settings">
                    <span class="fal fa-cog p-pa__header-block-settings-icon"></span>
                    <span class="p-pa__header-block-settings-text">Settings</span>
                    <span class="p-pa__header-block-settings-info">Edit your profile</span>
                </a>
            </div>
        <?php elseif ($user->isInstitution()): ?>
            <?php
            if ($chat = Chat::findByInstitutionAndAdjunct($user->getId(), $adjunctUserId)) {
                $onClick = 'openChat(' . $chat->id . ')';
            } else {
                $onClick = 'createChat(' . $adjunctUserId . ')';
            } ?>
            <div class="p-pa__header-block m-links">
                <a href="#" class="p-pa__header-block-chatting" onclick="<?= $onClick ?>">
                    Start chatting
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="p-pa__content">
        <div class="p-pa__content-title">
            Information
        </div>
        <div class="p-pa__content-text">
            <?= Html::encode($adjunct->description) ?>
        </div>

        <div class="p-pa__content-data">
            <?php if ($adjunct->specialities): ?>
                <div class="p-pa__content-data-item">
                <span class="p-pa__content-data-item-name">
                    Category:
                </span>
                    <?php foreach ($adjunct->specialityArray as $specialty): ?>
                        <?= $specialty->getNameWithFaculty(' - ') ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($adjunct->teachType): ?>
                <div class="p-pa__content-data-item">
                <span class="p-pa__content-data-item-name">
                    Type of teaching:
                </span>
                    <?= $adjunct->teachType->name ?>
                </div>
            <?php endif; ?>

            <?php if ($adjunct->teach_locations): ?>
                <div class="p-pa__content-data-item">
                <span class="p-pa__content-data-item-name">
                    Location:
                </span>
                    <?php foreach ($adjunct->getLocations() as $location): ?>
                        <?= $location->name ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($adjunct->teaching_experience_type_id): ?>
                <div class="p-pa__content-data-item">
                <span class="p-pa__content-data-item-name">
                    Teaching experience:
                </span>
                    <?= $adjunct->teachingExperienceType->name ?>
                </div>
            <?php endif; ?>

            <?php if ($adjunct->education): ?>
                <div class="p-pa__content-data-item">
                <span class="p-pa__content-data-item-name">
                    Education:
                </span>
                    <?= $adjunct->education->name ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-pa__content-title">
            Diplomas and certificates
        </div>
        <div class="p-pa__content-sertificates">
            <?php foreach ($adjunct->getDocumentsArray() as $document): ?>
                <img src="<?= FileHelper::getDocumentUrl($adjunct->user->getId(), $document) ?>"
                     alt="" class="p-pa__content-sertificates-one js-img" data-toggle="modal"
                     data-target="#modal"/>
            <?php endforeach; ?>
        </div>

        <?php if ($instInFavors = $adjunct->getImInFavorites()): ?>
            <div class="p-pa__content-title">
                I'm in favorites
            </div>
            <div class="p-pa__content-fav">
                <?php foreach ($instInFavors as $institution): ?>
                    <div class="p-pa__content-fav-one">
                        <img src="<?= UserImageHelper::getUrl($institution->user) ?>" class="p-pa__content-fav-one-ava"
                             alt=""/>
                        <a class="p-pa__content-fav-one-link">
                            <div class="p-pa__content-fav-one-link-name">
                                <?= Html::encode($institution->user->first_name) ?>
                            </div>
                            <div class="p-pa__content-fav-one-link-name">
                                <?= Html::encode($institution->user->last_name) ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<?php
$script = <<< JS
$(".js-img").on("click", function () {
    $(".js-modalImg").attr("src", $(this).attr("src"));
});
JS;
$this->registerJs($script, View::POS_END);
?>
