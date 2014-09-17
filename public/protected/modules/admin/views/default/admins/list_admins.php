<div id="newMenu">
    <?php echo CHtml::link('Добавить админа', array('default/save_admin'), array('class' => 'button'))?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'      => 'idAdmin',
            'value'     => '$data->idAdmin',
        ),
        array(
            'name'      => 'login',
            'value'     => '$data->login',
        ),
        array(
            'name'      => 'role',
            'value'     => '$data->role',
            'filter'    => Yii::app()->params['adminRoles'],
        ),
        array(
            'class'             => 'CButtonColumn',
            'viewButtonOptions' => array('style' => 'display : none'),
            'updateButtonUrl'   => 'Yii::app()->controller->createUrl("default/save_admin", array(
                    "idAdmin"         => $data->idAdmin,
                    "Admins_page"     => isset($_GET["Admins_page"]) ? $_GET["Admins_page"] : "",
                    "sort"            => isset($_GET["sort"]) ? $_GET["sort"] : "",
                    "Admins"          => isset($_GET["Admins"]) ? $_GET["Admins"] : "")
                )',
            'deleteButtonUrl'   => 'Yii::app()->controller->createUrl("default/Delete_admin", array(
                    "idAdmin"         => $data->idAdmin,
                    "Admins_page"     => isset($_GET["Admins_page"]) ? $_GET["Admins_page"] : "",
                    "sort"            => isset($_GET["sort"]) ? $_GET["sort"] : "",
                    "Admins"          => isset($_GET["Admins"]) ? $_GET["Admins"] : "")
                )',
        ),
    ),
));

?>
