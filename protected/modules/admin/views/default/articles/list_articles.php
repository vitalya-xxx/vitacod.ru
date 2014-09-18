<div id="newCategory">
    <?php echo CHtml::link('Добавить статью', array('default/save_article'), array('class' => 'button'))?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'afterAjaxUpdate'   => "function() {
        jQuery('#datePicker').datepicker(jQuery.extend(jQuery.datepicker.regional['ru'],{'showAnim':'fold','dateFormat':'yy-mm-dd','changeMonth':'true','changeYear':'true'}));
    }",
    'columns'      => array(
        array(
            'name'      => 'idArticle',
            'value'     => '$data->idArticle',
        ),
        array(
            'name'      => 'title',
            'value'     => '$data->title',
        ),
        array(
            'name'      => 'photo',
            'type'      => 'raw',
            'value'     => '!empty($data->photo) ? CHtml::image(Yii::app()->iwi->load("uploads/articles/".$data->idArticle."/".$data->photo)->adaptive(30,30, Iwi::NONE)->cache()) : ""',
        ),
        array(
            'name'      => 'idUser',
            'value'     => '$data->idUser0["login"]',
        ),
        array(
            'name'      => 'dateCreate',
            'value'     => '$data->dateCreate',
            'filter'    =>  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'     => $model,
                'attribute' => 'dateCreate',
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
                    'value' => (!empty($model->dateCreate) && '1970-01-01' != $model->dateCreate)
                        ? date('d.m.Y', strtotime($model->dateCreate))
                        : '',
                ),
            ),true),
        ),
        array(
            'name'      => 'moderationAppruv',
            'value'     => '$data->moderationAppruv',
            'filter'    => array(
                1 => 'прошла модеррацию',
                0 => 'ожидает',
            ),
        ),
        array(
            'name'      => 'public',
            'value'     => '$data->public',
            'filter'    => array(
                1 => 'опубликовнна',
                0 => 'скрыта',
            ),
        ),
        array(
            'name'      => 'deleted',
            'value'     => '$data->deleted',
            'filter'    => array(
                1 => 'удалена',
                0 => 'не удалена',
            ),
        ),
        array(
            'name'      => 'idMenu',
            'value'     => '$data->idMenu0["title"]',
            'filter'    => $menus,
        ),
        array(
            'name'      => 'idCategory',
            'value'     => '$data->idCategory0["title"]',
            'filter'    => $category,
        ),
        array(
            'class'             => 'CButtonColumn',
            'viewButtonOptions' => array('style' => 'display : none'),
            'updateButtonUrl'   => 'Yii::app()->controller->createUrl("default/save_article", array(
                "idMenu"          => $data->idMenu,
                "idArticle"       => $data->idArticle,
                "Articles_page"   => isset($_GET["Articles_page"]) ? $_GET["Articles_page"] : "",
                "sort"            => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Articles"        => isset($_GET["Articles"]) ? $_GET["Articles"] : "")
            )',
            'deleteButtonUrl'   => 'Yii::app()->controller->createUrl("default/delete_article", array(
                "idArticle"       => $data->idArticle,
                "Articles_page"   => isset($_GET["Articles_page"]) ? $_GET["Articles_page"] : "",
                "sort"            => isset($_GET["sort"]) ? $_GET["sort"] : "",
                "Articles"        => isset($_GET["Articles"]) ? $_GET["Articles"] : "")
            )',
        ),
    ),
));

?>
