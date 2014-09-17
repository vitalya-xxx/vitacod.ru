<div id="newCategory">
    <?php echo CHtml::link('Добавить ссылку', array('default/save_link'), array('class' => 'button'))?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'      => 'link_id',
            'value'     => '$data->link_id',
        ),
        array(
            'name'      => 'link',
            'value'     => '$data->link',
        ),
        array(
            'name'      => 'description',
            'value'     => '$data->description',
        ),
        array(
            'class'             => 'CButtonColumn',
            'viewButtonOptions' => array('style' => 'display : none'),
            'updateButtonUrl'   => 'Yii::app()->controller->createUrl("default/save_link", array(
                "link_id"    => $data->link_id,
                "Links_page" => isset($_GET["Links_page"]) ? $_GET["Links_page"] : "",
                "sort"       => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Links"      => isset($_GET["Links"]) ? $_GET["Links"] : "")
                )',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("default/delete_link", array(
                "link_id"    => $data->link_id,
                "Links_page" => isset($_GET["Links_page"]) ? $_GET["Links_page"] : "",
                "sort"       => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Links"      => isset($_GET["Links"]) ? $_GET["Links"] : "")
                )',
        ),
    ),
));

?>
