<div class="articleContainer">
    <div class="titleArticle"><?php echo $model->title?></div>
    <div class="overheadInfo">
        <span class="nameInfo">Автор:</span><span class="valueInfo"><?php echo (!empty($model->idUser0["lastFirstName"]) ? $model->idUser0["lastFirstName"] : $model->idUser0["login"])?></span>
        <span class="nameInfo">Добавленна:</span><span class="valueInfo"><?php echo $model->dateCreate?></span>
        <span class="nameInfo">Просмотров:</span><span class="valueInfo"><?php echo $model->numberOfViews?></span>
        <span class="nameInfo">Комментариев:</span><span class="valueInfo"><?php echo $model->commentsCount?></span>
    </div>
    <div class="tagsContainer greanLink">
        <?php $this->widget('zii.widgets.CMenu',array(
        'items'         => $model->tagArray,
        'htmlOptions'   => array('class'=>'tags'),
    )); ?>
    </div>
    <div class="viewPhotoArticle photoArticle">
        <?php if (!empty($model->photo)) :?>
            <?php echo CHtml::image(Yii::app()->iwi->load("uploads/articles/".$model->idArticle."/".$model->photo)->resize(400,300, Iwi::AUTO)->cache(), '', array('class'=>'viewArtImg'))?>
        <?php endif;?>
    </div>
    <div class="textArticle">
        <?php
            $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
                echo $model->text;
            $this->endWidget();
        ?>
    </div>

    <!--  КНОПКА ДОБАВЛЕНИЯ В ЗАКЛАДКИ  -->
    <?php if (!Yii::app()->user->isGuest && 'Users' == Yii::app()->session->get("typeAuthorize")):?>
        <div id = "buttonBookMarks"
             class              = "greenButton"
             data-type          = "<?php echo (empty($idBookmarks) ? 'add' : 'delete')?>"
             data-idBookmarks   = "<?php echo (empty($idBookmarks) ? '' : $idBookmarks)?>"
             data-idArticle     = "<?php echo $model->idArticle?>"
             data-idMenu        = "<?php echo $model->idMenu?>"
             data-idCategory    = "<?php echo $model->idCategory?>"
         ><?php echo (empty($idBookmarks) ? 'Добавить в закладки' : 'Удалить из закладок')?></div>
    <?php endif;?>

    <!--  БЛОК КОММЕНТАРИЕВ  -->
    <?php $this->renderPartial('//comments/_list_comments', array(
        'dataProvider'  => $commentsDataProvider,
    )); ?>

    <!--  ФОРМА ДОБАВЛЕНИЯ КОММЕНТАРИЯ  -->
    <?php $this->renderPartial('//comments/_add_comment_form', array(
        'model'     => $modelComment,
        'idArticle' => $model->idArticle,
        'idAuthor'  => $model['idUser0']['idUser'],
    )); ?>
</div>