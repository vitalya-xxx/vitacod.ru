<div class="commentBlock">
    <div class="header">
        <div class="photo">
            <?php if (!empty($data->idUser0["photo"])) :?>
                <?php echo CHtml::image(Yii::app()->iwi->load("uploads/users/".$data->idUser0["idUser"]."/".$data->idUser0["photo"])->adaptive(22,18, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
            <?php else :?>
                <?php echo CHtml::image(Yii::app()->iwi->load("images/default/users.png")->adaptive(22,18, Iwi::NONE)->cache(), '')?>
            <?php endif;?>
        </div>
        <div class="userInfo">
            <span class="nameInfo">
                <?php if ('admin' == $data->typeUser):?>
                    Администратор сайта
                <?php elseif ('author' == $data->typeUser):?>
                    Автор статьи
                <?php elseif ('user' == $data->typeUser):?>
                    Читатель
                <?php endif;?>
            </span>
            <span class="valueInfo"> <?php echo (!empty($data->idUser0["lastFirstName"]) ? $data->idUser0["lastFirstName"] : $data->idUser0["login"])?></span>
            <span class="nameInfo">Добавленна:</span>
            <span class="valueInfo"><?php echo $data->date?></span>
        </div>
    </div>
    <div class="text">
        <?php
            $this->beginWidget('CMarkdown', array('purifyOutput'=>true));
                echo $data->text;
            $this->endWidget();
        ?>
    </div>
</div>