<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'      => 'idUser',
            'value'     => '$data->idUser',
        ),
        array(
            'name'      => 'login',
            'value'     => '$data->login',
        ),
        array(
            'name'      => 'email',
            'value'     => '$data->email',
        ),
        array(
            'name'      => 'idRole',
            'value'     => '$data->idRole0["description"]',
            'filter'    => $roles,
        ),
        array(
            'name'      => 'photo',
            'type'      => 'raw',
            'value'     => '!empty($data->photo) ? CHtml::image(Yii::app()->iwi->load("uploads/users/".$data->idUser."/".$data->photo)->adaptive(30,30, Iwi::NONE)->cache()) : ""',
        ),
        array(
            'name'      => 'lastFirstName',
            'value'     => '$data->lastFirstName',
        ),
        array(
            'name'      => 'ban',
            'value'     => '$data->ban ? "Забанен" : "Нет бана"',
            'filter'    => array(
                1 => 'Забанен',
                0 => 'Нет бана',
            ),
        ),
        array(
            'class'             => 'CButtonColumn',
            'viewButtonOptions' => array('style' => 'display : none'),
            'updateButtonUrl'   => 'Yii::app()->controller->createUrl("default/save_user", array(
                    "idUser"          => $data->idUser,
                    "Users_page"      => isset($_GET["Users_page"]) ? $_GET["Users_page"] : "",
                    "sort"            => isset($_GET["sort"]) ? $_GET["sort"] : "",
                    "Users"           => isset($_GET["Users"]) ? $_GET["Users"] : "")
                )',
            'deleteButtonUrl'   => 'Yii::app()->controller->createUrl("default/Delete_user", array(
                    "idUser"          => $data->idUser,
                    "Users_page"      => isset($_GET["Users_page"]) ? $_GET["Users_page"] : "",
                    "sort"            => isset($_GET["sort"]) ? $_GET["sort"] : "",
                    "Users"           => isset($_GET["Users"]) ? $_GET["Users"] : "")
                )',
        ),
    ),
));

?>
