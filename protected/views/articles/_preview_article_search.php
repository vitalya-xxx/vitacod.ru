<div class="previewArticle">
    <div class="titleArticle">
        <?php echo CHtml::link($data['title'], 'javascript:void(0)', array(
        'onClick' => 'showArticlePopup('.$data['idArticle'].', '.((1 == $data['moderationAppruv']) ? "'public'" : "'appruve'").', "search")',
        ));?>
    </div>
    <div class="overheadInfo">
            <span class="nameInfo">Автор:</span><span class="valueInfo"><?php echo (!empty($data["lastFirstName"]) ? $data["lastFirstName"] : $data["login"])?></span>
            <span class="nameInfo">Добавленна:</span><span class="valueInfo"><?php echo date('d.m.Y H:i', strtotime($data['dateCreate']))?></span>
            <span class="nameInfo">Просмотров:</span><span class="valueInfo"><?php echo $data['numberOfViews']?></span>
            <span class="nameInfo">Комментариев:</span><span class="valueInfo"><?php echo $data['commentsCount']?></span>
    </div>
    <div class="previewArticleContainer">
        <div class="photoArticle">
            <?php echo CHtml::image(Yii::app()->iwi->load(
                !empty($data['photo']) ? "uploads/articles/".$data['idArticle']."/".$data['photo'] : "images/default/articles.png"
            )->resize(216,154)->cache(), '', array('class'=>'uploadImg'))?>
        </div>
        <div class="descriptionArticle">
            <?php
                $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
                    echo $data['description'];
                $this->endWidget();
            ?>
        </div>
        <div class="menuCategoryBlock">
            <span class="nameInfo">Раздел меню:</span><span class="valueInfo"><?php echo $data['titleMenu']?></span>
            <span class="nameInfo">Категория:</span><span class="valueInfo"><?php echo $data['titleCategory']?></span>
        </div>
        <div class="readMore">
            <?php echo CHtml::link('Читать далее...', 'javascript:void(0)', array(
                'onClick' => 'showArticlePopup('.$data['idArticle'].', '.((1 == $data['moderationAppruv']) ? "'public'" : "'appruve'").', "search")',
            ));?>
        </div>
        <div class="tagsContainer greanLink">
            <?php /* $this->widget('zii.widgets.CMenu',array(
                'items'         => $data['tagArray'],
                'htmlOptions'   => array('class'=>'tags'),
            )); */ ?>
        </div>
    </div>
</div>
