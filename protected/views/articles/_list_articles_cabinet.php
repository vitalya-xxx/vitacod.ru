<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'      => $dataProvider,                                   // переданный дата-провайдер
    'itemView'          => '_preview_article_cabinet',                              // имя view для отрисовки отдельного поста
    'ajaxUpdate'        => true,                                          // не будем делать обновление через ajax
    'enablePagination'  => false,                                           // отключаем стандартную пагинацию CListView
    'pagerCssClass'     => 'result-list',                                   // css класс пэйджера
    'summaryText'       => false,  // текст с количество найденных постов
));
$this->widget('CLinkPager', array(
    'header'            => '',                                              // пейджер без заголовка
    'firstPageLabel'    => '<<',
    'prevPageLabel'     => '<',
    'nextPageLabel'     => '>',
    'lastPageLabel'     => '<<',
    'pages'             => $pages,                                          // модель пагинации переданная во View
));