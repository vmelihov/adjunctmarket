<?php

use yii\web\View;

/** @var int $pageCount */
?>

<div class="p-feed__load">
    <div id="showMore" class="p-feed__load-btn">Load More Vacancies</div>
</div>

<?php
$page = (int)Yii::$app->request->get('page', 0);

$script = <<< JS
    // запоминаем текущую страницу и их максимальное количество
    var page = parseInt('$page');
    var pageCount = parseInt('{$pageCount}');
    var loadingFlag = false;

    $('#showMore').click(function() {
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;
            
            $.ajax({
                type: 'post',
                url: window.location.href,
                data: {
                    // передаём номер нужной страницы методом POST
                    'page': page + 1,
                },
                success: function(data) {
                    // увеличиваем номер текущей страницы и снимаем блокировку
                    page++;
                    loadingFlag = false;

                    // вставляем полученные записи после имеющихся в наш блок
                    $('#itemList').append(data);

                    // если достигли максимальной страницы, то прячем кнопку
                    if (page >= pageCount) {
                        $('#showMore').hide();
                    }
                }
            });
        }
        return false;
    })
JS;
$this->registerJs($script, View::POS_READY);
?>
