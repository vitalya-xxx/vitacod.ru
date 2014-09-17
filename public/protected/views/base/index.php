<?php
$this->widget('application.components.ColumnListView', array(
    'dataProvider'      => $dataProvider,
    'itemView'          => '_preview_menu',
    'columns'           => array("one","two","three"),
     'ajaxUpdate'       => false,
    'enablePagination'  => false,
    'summaryText'       => false
));

