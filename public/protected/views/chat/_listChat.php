<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'      => $dataProvider,                                 // переданный дата-провайдер
        'itemView'          => '//chat/_viewChat',                    // имя view для отрисовки отдельного поста
        'ajaxUpdate'        => true,                                          // не будем делать обновление через ajax
        'enablePagination'  => false,                                         // отключаем стандартную пагинацию CListView
        'pagerCssClass'     => 'result-list',                                 // css класс пэйджера
        'summaryText'       => false,  // текст с количество найденных постов
        'emptyText'         => false,
    ));
?>
