<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'      => $dataProvider,                                   // переданный дата-провайдер
    'itemView'          => '_preview_article',                              // имя view для отрисовки отдельного поста
    'ajaxUpdate'        => true,                                          // не будем делать обновление через ajax
    'enablePagination'  => false,                                           // отключаем стандартную пагинацию CListView
    'pagerCssClass'     => 'myPager',                                   // css класс пэйджера
    'summaryText'       => false,  // текст с количество найденных постов
));
$this->widget('CLinkPager', array(
    'header'            => '',                                              // пейджер без заголовка
    'firstPageLabel'    => 'На первую',
    'prevPageLabel'     => 'предидущая',
    'nextPageLabel'     => 'следующая',
    'lastPageLabel'     => 'На последнюю',
    'pages'             => $pages,                                          // модель пагинации переданная во View
));