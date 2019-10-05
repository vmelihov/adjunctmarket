<?php

use common\src\helpers\DictionaryHelper;
use common\src\helpers\Helper;
use common\src\helpers\HtmlHelper;
use frontend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vacancy */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('@web/extension/selectize/css/selectize.css', ['depends' => [AppAsset::class]]);

$this->registerJsFile('@web/js/validation.js', ['depends' => [AppAsset::class]]);
$this->registerJsFile('@web/extension/selectize/js/standalone/selectize.min.js', ['depends' => [AppAsset::class]]);

$dictHelper = new DictionaryHelper();

$specialties = $dictHelper->prepareSpecialties()->getResult();
$areas = $dictHelper->prepareAreaWithState()->getResult();
$educations = $dictHelper->prepareEducation()->getResult();
$teachingTypes = $dictHelper->prepareTeachingType()->getResult();
$teachingTimes = $dictHelper->prepareTeachingTime()->getResult();
$teachingPeriods = $dictHelper->prepareTeachingPeriod()->getResult();

$user = Helper::getUserIdentity();
?>

<?php $form = ActiveForm::begin([
    'id' => 'create-vacancy-form',
    'options' => [
        'class' => 'p-cv__form js-form',
        'data-validate' => '2',
    ],
    'fieldConfig' => [
        'template' => "{input}\n{error}",
        'options' => [
            'tag' => false,
        ]
    ],
]); ?>

<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'institution_user_id')->hiddenInput(['value' => $user->getId()])->label(false) ?>


    <div class="row">
        <div class="col-sm-6">
            <div class="p-cv__form-iblock js-validateblock">
                <div class="p-cv__form-block-label">Title</div>

                <?= $form->field($model, 'title')->textInput([
                'maxlength' => true,
                    'id' => 'title',
                    'class' => 'p-cv__form-iblock-input js-textValidation',
            ]) ?>

                <div class="p-cv__form-iblock-error js-validateblockError">
                    Please enter any
                    words
                </div>
        </div>
    </div>
</div>

    <div class="p-cv__form-iblock js-validateblock">
        <div class="p-cv__form-block-label">Description</div>
        <?= $form->field($model, 'description')->textarea([
            'maxlength' => true,
            'id' => 'description',
            'class' => 'p-cv__form-iblock-textarea js-textValidation'
        ]) ?>
        <div class="p-cv__form-iblock-error js-validateblockError">
            Please enter any
            words
        </div>
</div>

    <div class="p-cv__form-block">
    <div class="row">
        <div class="col-sm-6">
            <div class="p-cv__form-block-label">Select category</div>
            <div class="p-cv__form-block-select">
                <?= $form->field($model, 'specialty_id')->dropDownList($specialties, [
                    'id' => 'category',
                    'class' => 'js-selectize',
                    'prompt' => ''
                ]) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="p-cv__form-block-label">Select location</div>
            <div class="p-cv__form-block-select">
                <?= $form->field($model, 'area_id')->dropDownList($areas, [
                    'id' => 'location',
                    'class' => 'js-selectize',
                    'prompt' => ''
                ]) ?>
            </div>
        </div>
    </div>
</div>

    <div class="p-cv__form-block">
    <div class="row">
        <div class="col-sm-6">
            <div class="p-cv__form-block-label">Higest education level obtained</div>
            <div class="p-cv__form-block-select">
                <?= $form->field($model, 'education_id')
                    ->dropDownList($educations, [
                        'id' => 'edLevel',
                        'class' => 'js-selectize',
                        'prompt' => ''
                    ])
                ?>
            </div>
        </div>
    </div>
    </div>

    <div class="p-cv__form-block">
    <div class="row">
        <div class="col-sm-4 g-mb20">
            <div class="p-cv__form-block-label">Teaching experience</div>
            <div class="g-mb20">
                <label class="ui-radio g-mr15 js-showLink" data-show="expirienceBlock">
                    <input type="radio" name="teachexperience" id="tExpYes"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">YES</span>
                </label>
                <label class="ui-radio js-hideLink" data-hide="expirienceBlock">
                    <input type="radio" name="teachexperience" id="tExpNo"/>
                    <span class="ui-radio__decor"></span>
                    <span class="ui-radio__text">NO</span>
                </label>
            </div>

            <div class="p-cv__form-exp" id="expirienceBlock">
                <?= $form->field($model, 'teach_type_id')
                    ->radioList($teachingTypes, [
                        'item' => HtmlHelper::getCallbackRadioItem('g-mb10'),
                    ])
                ?>
            </div>
        </div>

        <div class="col-sm-4 g-mb20">
            <div class="p-cv__form-block-label">Type of teaching</div>
            <?= $form->field($model, 'teach_period_id')
                ->radioList($teachingPeriods, [
                    'item' => HtmlHelper::getCallbackRadioItem('g-mb10'),
                ])
            ?>
        </div>

        <div class="col-sm-4">
            <div class="p-cv__form-block-label">Availability</div>
            <?= $form->field($model, 'teach_time_id')
                ->radioList($teachingTimes, [
                    'item' => HtmlHelper::getCallbackRadioItem('g-mb10'),
                ])
            ?>
        </div>
    </div>
</div>

    <button class="p-cv__form-submit js-submit" disabled>Create</button>

    <div style="display: none">
        <?= Html::submitButton('Publish', ['class' => 'btn', 'id' => 'submitButton']) ?>
    </div>

    <div class="modal fade" id="vacancyModal" tabindex="-1" role="dialog" aria-labelledby="vacancyModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="p-cv__modal">
                <div class="p-cv__modal-title" id="modalTitle"></div>
                <div class="p-cv__modal-description" id="modalDescription"></div>
                <div class="p-cv__modal-text">
                    <span class="p-cv__modal-text-title">
                        Category:
                    </span>
                    <span class="p-cv__modal-text-param" id="modalCategory"></span>
                </div>
                <div class="p-cv__modal-text">
                    <span class="p-cv__modal-text-title">
                        Teaching experience:
                    </span>
                    <span class="p-cv__modal-text-param" id="modalTExp"></span>
                </div>
                <div class="p-cv__modal-text">
                    <span class="p-cv__modal-text-title">
                        Education:
                    </span>
                    <span class="p-cv__modal-text-param" id="modalEducation"></span>
                </div>
                <div class="p-cv__modal-text">
                    <span class="p-cv__modal-text-title">
                        Type of teaching:
                    </span>
                    <span class="p-cv__modal-text-param" id="modalTypeOfTeaching"></span>
                </div>
                <div class="p-cv__modal-text">
                    <span class="p-cv__modal-text-title">
                        Location:
                    </span>
                    <span class="p-cv__modal-text-param" id="modalLocation"></span>
                </div>
                <div class="p-cv__modal-text">
                    <span class="p-cv__modal-text-title">
                        University:
                    </span>
                    <span class="p-cv__modal-text-param" id="modalUniversity">Some univercity</span>
                </div>


                <div class="p-cv__modal-btns">
                    <div id="modalPublishButton" class="p-cv__modal-btns-publish" data-dismiss="modal"
                         aria-label="Close">Publish
                    </div>
                    <div class="p-cv__modal-btns-edit" data-dismiss="modal" aria-label="Close">Edit vacancy</div>
                </div>
            </div>
        </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $('.js-selectize').selectize({
        create: true,
        sortField: 'text'
    });

    $('#modalPublishButton').on('click', function() {
        $('#submitButton').submit();
    });

    $(".js-submit").on("click", function () {
        if (!$(this).prop('disabled')) {
            $('#vacancyModal').modal();

            $("#modalTitle").text($("#title").val());
            $("#modalDescription").text($("#description").val());
            $("#modalCategory").text($("#category").val());

            if ($("#tExpYes").prop("checked")) {
                var _text = "";

                if ($("#online").prop("checked")) {
                    _text = "Online";
                }
                if ($("#inPerson").prop("checked")) {
                    _text += "In person";
                }
                if ($("#online").prop("checked") && $("#inPerson").prop("checked")) {
                    _text += "Online, In person";
                }
                $("#modalTExp").text(_text);
            }
            $("#modalEducation").text($("#edLevel").val());

            if ($("#fullSemester").prop("checked")) {
                $("#modalTypeOfTeaching").text("Full Semester");
            }
            if ($("#occasionalLecturing").prop("checked")) {
                $("#modalTypeOfTeaching").text("Occasional Lecturing");
            }
            if ($("#either").prop("checked")) {
                $("#modalTypeOfTeaching").text("Either of the two");
            }

            $("#modalLocation").text($("#location").val());
        }
        event.preventDefault();
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>