<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'      => $dataProvider,            // переданный дата-провайдер
    'itemView'          => '_preview_article',       // имя view для отрисовки отдельного поста
    'ajaxUpdate'        => false,                     // не будем делать обновление через ajax
    'enablePagination'  => false,                    // отключаем стандартную пагинацию CListView
    'summaryText'       => false                     // текст с количество найденных постов
));