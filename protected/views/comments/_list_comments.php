<div class="listComments">
    <div class="blockCommentsHeader">Комментарии к статье:</div>
    <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'      => $dataProvider,                                 // переданный дата-провайдер
            'itemView'          => '//comments/_view_comment',                    // имя view для отрисовки отдельного поста
            'ajaxUpdate'        => true,                                          // не будем делать обновление через ajax
            'enablePagination'  => false,                                         // отключаем стандартную пагинацию CListView
            'pagerCssClass'     => 'result-list',                                 // css класс пэйджера
            'summaryText'       => false,  // текст с количество найденных постов
            'emptyText'         => false,
        ));
    ?>
</div>
