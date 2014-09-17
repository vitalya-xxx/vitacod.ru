<div class="previewArticle">
    <div class="titleArticle">
        <?php echo CHtml::link($data->title, array(
            'articles/view_article',
            'idArticle' => $data->idArticle,
            'idMenu'    => $data->idMenu
        ))?>
    </div>
    <div class="overheadInfo">
            <span class="nameInfo">Автор:</span><span class="valueInfo"><?php echo (!empty($data->idUser0["lastFirstName"]) ? $data->idUser0["lastFirstName"] : $data->idUser0["login"])?></span>
            <span class="nameInfo">Добавленна:</span><span class="valueInfo"><?php echo $data->dateCreate?></span>
            <span class="nameInfo">Просмотров:</span><span class="valueInfo"><?php echo $data->numberOfViews?></span>
            <span class="nameInfo">Комментариев:</span><span class="valueInfo"><?php echo $data->commentsCount?></span>
    </div>
    <div class="previewArticleContainer">
        <div class="photoArticle">
            <?php echo CHtml::image(Yii::app()->iwi->load(
                !empty($data->photo) ? "uploads/articles/".$data->idArticle."/".$data->photo : "images/default/articles.png"
            )->resize(216,154)->cache(), '', array('class'=>'uploadImg'))?>
        </div>
        <div class="descriptionArticle">
            <?php
                $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
                    echo $data->description;
                $this->endWidget();
            ?>
        </div>
        <div class="menuCategoryBlock"></div>
        <div class="readMore">
            <?php echo CHtml::link('Читать далее...', array(
                'articles/view_article',
                'idArticle' => $data->idArticle,
                'idMenu'    => $data->idMenu
            ))?>
        </div>
        <div class="tagsContainer greanLink">
            <?php $this->widget('zii.widgets.CMenu',array(
                'items'         => $data->tagArray,
                'htmlOptions'   => array('class'=>'tags'),
            )); ?>
        </div>
    </div>
</div>
