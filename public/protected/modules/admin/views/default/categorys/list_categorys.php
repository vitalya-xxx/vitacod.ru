<div id="newCategory">
    <?php echo CHtml::link('Добавить категорию', array('default/save_category'), array('class' => 'button'))?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'      => 'idCategory',
            'value'     => '$data->idCategory',
        ),
        array(
            'name'      => 'title',
            'value'     => '($data->active) ? $data->title : $data->title." (Не активна)"',
        ),
        array(
            'name'      => 'active',
            'value'     => '$data->active',
            'filter'    => array(
                1   => 'Видна',
                0   => 'Не видна',
            ),
        ),
        array(
            'name'      => 'photo',
            'type'      => 'raw',
            'value'     => '!empty($data->photo) ? CHtml::image(Yii::app()->iwi->load("uploads/categorys/".$data->idCategory."/".$data->photo)->adaptive(30,30, Iwi::NONE)->cache()) : ""',
        ),
        array(
            'name'      => 'idMenu',
            'value'     => '$data->idMenu0["title"]',
            'filter'    => $menus,
        ),
        array(
            'class'             => 'CButtonColumn',
            'viewButtonOptions' => array('style' => 'display : none'),
            'updateButtonUrl'   => 'Yii::app()->controller->createUrl("default/save_category", array(
                "idCategory"       => $data->idCategory,
                "Categorys_page"   => isset($_GET["Categorys_page"]) ? $_GET["Categorys_page"] : "",
                "sort"             => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Categorys"        => isset($_GET["Categorys"]) ? $_GET["Categorys"] : "")
                )',
            'deleteButtonUrl'   => 'Yii::app()->controller->createUrl("default/delete_category", array(
                "idCategory"       => $data->idCategory,
                "Categorys_page"   => isset($_GET["Categorys_page"]) ? $_GET["Categorys_page"] : "",
                "sort"             => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Categorys"        => isset($_GET["Categorys"]) ? $_GET["Categorys"] : "")
                )',
        ),
    ),
));

?>
