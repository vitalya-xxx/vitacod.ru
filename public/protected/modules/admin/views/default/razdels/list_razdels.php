<div id="newMenu">
    <?php echo CHtml::link('Добавить пункт меню', array('default/save_menu'), array('class' => 'button'))?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'      => 'idMenu',
            'value'     => '$data->idMenu',
        ),
        array(
            'name'      => 'photo',
            'type'      => 'raw',
            'value'     => '!empty($data->photo) ? CHtml::image(Yii::app()->iwi->load("uploads/mainmenu/".$data->idMenu."/".$data->photo)->adaptive(30,30, Iwi::NONE)->cache()) : ""',
        ),
        array(
            'name'      => 'title',
            'value'     => '$data->title',
        ),
        array(
            'name'      => 'position',
            'value'     => '$data->position',
        ),
        array(
            'name'      => 'type',
            'value'     => '$data->type',
            'filter'    => Yii::app()->params['typeMeny'],
        ),
        array(
            'name'      => 'link',
            'value'     => '$data->link',
        ),
        array(
            'name'      => 'partSite',
            'value'     => '$data->partSite',
            'filter'    => Yii::app()->params['partSite'],
        ),
        array(
            'name'      => 'visible',
            'value'     => '$data->visible',
            'filter'    => array(
                1 => 'Видно',
                0 => 'Скрыто',
            ),
        ),
        array(
            'name'      => 'mayBeCat',
            'value'     => '$data->mayBeCat',
            'filter'    => array(
                1 => 'Может иметь категории',
                0 => 'Без категорий',
            ),
        ),
        array(
            'class'             => 'CButtonColumn',
            'viewButtonOptions' => array('style' => 'display : none'),
            'updateButtonUrl'   => 'Yii::app()->controller->createUrl("default/save_menu", array(
                "idMenu"            => $data->idMenu,
                "Mainmenu_page"     => isset($_GET["Mainmenu_page"]) ? $_GET["Mainmenu_page"] : "",
                "sort"              => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Mainmenu"          => isset($_GET["Mainmenu"]) ? $_GET["Mainmenu"] : "")
                )',
            'deleteButtonUrl'   => 'Yii::app()->controller->createUrl("default/Delete_razdel", array(
                "idMenu"            => $data->idMenu,
                "Mainmenu_page"     => isset($_GET["Mainmenu_page"]) ? $_GET["Mainmenu_page"] : "",
                "sort"              => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Mainmenu"          => isset($_GET["Mainmenu"]) ? $_GET["Mainmenu"] : "")
                )',
        ),
    ),
));

?>
