<div id="chatOnOff" class="greenButton" data-action="<?php echo ($stateChat ? 'off' : 'on') ?>"><?php echo $stateChat ? 'Отключить чат' : 'Включить чат' ?></div>
<div id="multiActionChat" class="greenButton">Множественные действия с сообщениями</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'      => $model->search(),
    'filter'            => $model,
    'afterAjaxUpdate'   => "function() {
        jQuery('#datePicker').datepicker(jQuery.extend(jQuery.datepicker.regional['ru'],{'showAnim':'fold','dateFormat':'yy-mm-dd','changeMonth':'true','changeYear':'true'}));
    }",
    'columns' => array(
        array(
            'header'        => CHtml::checkBox("selectAll", false, array("class" => "selectAll")),
            'htmlOptions'   => array('width'=>50, 'class'=>'cGridViewCheckBox'),
            'type'          => 'raw',
            'value'         => 'CHtml::checkBox("selectOne", false, array("class" => "selectOne"))',
        ),
        array(
            'name'      => 'idChat',
            'value'     => '$data->idChat',
        ),
        array(
            'name'      => 'text',
            'value'     => '$data->text',
        ),
        array(
            'name'      => 'active',
            'value'     => '$data->active ? "Видно" : "Скрыто"',
            'filter'    => array(
                1 => 'видно',
                0 => 'скрыто',
            ),
        ),
        array(
            'name'      => 'idUser',
            'value'     => '$data->idUser',
        ),
        array(
            'name'      => 'login',
            'value'     => '$data->idUser0["login"]',
        ),
        array(
            'name'      => 'lastFirstName',
            'value'     => '$data->idUser0["lastFirstName"]',
        ),
        array(
            'name'      => 'date',
            'value'     => '$data->date',
            'filter'    =>  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'     => $model,
                'attribute' => 'date',
                'language'  => 'ru',
                'options'   => array(
                    'showOn'        => 'focus',
                    'dateFormat'    => 'yy-mm-dd',
                    'changeMonth'   => 'true',
                    'changeYear'    => 'true',
                ),
                'htmlOptions'   => array(
                    'id'    => 'datePicker',
                    'size'  => '10',
                    'value' => (!empty($model->date))
                        ? date('d.m.Y', $model->date)
                        : '',
                ),
            ),true),
        ),
        array(
            "header"    => "Скрыть/Открыть",
            "type"      => "raw",
            "value"     => 'CHtml::link(
                CHtml::image(
                    Yii::app()->request->baseUrl."/images/default/".(($data->active) ? "visible" : "hidden").".png",
                    "Скрыть/Открыть",
                    array(
                        "id"            => "showHideMsg",
                        "class"         => "btnInDataGrid",
                        "data-state"    => ($data->active) ? "visible" : "hidden",
                    )
                )
                ,"#"
            )',
        ),
//        array(
//            'class'     => 'CButtonColumn',
//            'template'  => '{visibleBtn}',
//            'buttons'   => array(
//                'visibleBtn' => array(
//                    'label'     => 'Открыть/Скрыть сообщение',
//                    'url'       => '',
//                    'imageUrl'  => Yii::app()->request->baseUrl.'/images/default/'.(($model->active) ? 'visible' : 'hidden').'.png',
//                    'imageUrl'  => '$data->active',
//                    'options'   => array('class' => 'btnInDataGrid'),
//                ),
//            ),
//        ),
        array(
            'class'                 => 'CButtonColumn',
            'viewButtonOptions'     => array('style' => 'display : none'),
            'updateButtonOptions'   => array('style' => 'display : none'),
            'deleteButtonUrl'       => 'Yii::app()->controller->createUrl("default/DeleteMsg", array(
                "idChat"      => $data->idChat,
                "Chat_page"   => isset($_GET["Chat_page"]) ? $_GET["Chat_page"] : "",
                "sort"        => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Chat"        => isset($_GET["Chat"]) ? $_GET["Chat"] : "")
            )',
        ),
    ),
));
?>
