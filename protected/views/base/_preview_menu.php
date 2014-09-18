<a href="<?php echo $this->createAbsoluteUrl('articles/list_articles', array('listType' => 'razdel', 'idMenu' => $data->idMenu))?>">
    <div class="menuContainer">
        <div class="photoMenu">
            <?php echo CHtml::image(Yii::app()->iwi->load(
                !empty($data->photo) ? "uploads/mainmenu/".$data->idMenu."/".$data->photo : "images/default/mainmenu.png"
                )->adaptive(239,228)->cache(), '', array('class'=>'previewMenu'))
            ?>
        </div>
        <div class="titleMenu"><?php echo $data->title?></div>
        <div class="infoMenu">
            <span class="nameInfo">Категорий:</span><span class="valueInfo"><?php echo $data->categoryCount?></span>
            <span class="nameInfo">Статей:</span><span class="valueInfo"><?php echo $data->articlesMenuCount?></span>
        </div>
    </div>
</a>