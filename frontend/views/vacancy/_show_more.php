<?php

use yii\web\View;

/** @var int $pageCount */
?>

<div class="p-feed__load">
    <div id="showMore" style="
        width: 213px;
        height: 48px;
        text-align: center;
        background:#2259B5;
        color:#fff;
        line-height: 46px;
        cursor: pointer;
        margin: 20px auto">Load More Vacancies
    </div>
</div>

<?php
$script = <<< JS
    // запоминаем текущую страницу и их максимальное количество
    var page = 0;
    var pageCount = parseInt('{$pageCount}');
    var loadingFlag = false;
    
    console.log(page, pageCount);

    $('#showMore').click(function() {
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;
            
            page++;
            
            console.log(page, pageCount);
            
            $.ajax({
                type: 'post',
                url: window.location.href,
                data: {
                    // передаём номер нужной страницы методом POST
                    'page': page,
                },
                success: function(data) {
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
