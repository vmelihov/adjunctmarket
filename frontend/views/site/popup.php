<?php
/* @var $this yii\web\View */
/* @var $text string */
/* @var $class string */
?>

    <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="mailModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="g-info-modal <?= $class ?>">
                <div class="g-info-modal__close" data-dismiss="modal" aria-label="Close"></div>
                <div class="g-info-modal__title">
                    <?= $text ?>
                </div>
                <div class="g-info-modal__text">
                    Thank you for choosing our service
                </div>
            </div>
        </div>
    </div>

<?php
$script = <<< JS
    $('#mailModal').modal();
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>