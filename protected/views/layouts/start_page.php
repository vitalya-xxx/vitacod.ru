<?php $this->beginContent('//layouts/main'); ?>
    <div class="body">
        <!-- ЛЕВАЯ БОКОВАЯ КОЛОНКА -->
        <div class="leftColumn">
            <!-- КАТЕГОРИИ -->
            <?php
                if (!empty($this->_listCategory)) {
                    echo '<div class="categoryLinks sidePanel">';
                    echo '<div class="title">Категории</div>';
                    $this->widget('zii.widgets.CMenu',array(
                        'items' => $this->_listCategory,
                    ));
                    echo '</div>';
                }
            ?>

            <!-- ЧАТ -->
            <div class="sidePanel">
                <div class="title">Чат</div>
                <div id="chat">
                    <div id="formChat">

                        <?php if ($this->stateChat):?>
                            <?php if (!Yii::app()->user->isGuest):?>
                                <div class="inputChat">
                                    <?php echo CHtml::TextArea('chatInput', '', array('id' => 'inputChat', 'style'=>'width: 185px; height: 60px;')); ?>
                                </div>
                                <div class="buttonChat">
                                    <?php echo CHtml::submitButton('Отправить', array('id' => 'sendChat', 'name'=>'sendChat', 'class'=>'submit-button')); ?>
                                </div>
                                <?php else:?>
                                <div class="authorizeLink">
                                    <?php echo CHtml::link('Для добавления необходима авторизация', 'javascript:void(0)', array('class' => 'baseLoginLink', 'popup' => 'baseLogin'))?>
                                </div>
                            <?php endif;?>
                        <?php else :?>
                            <div class="serviceMsg">Чат отключен администратором.</div>
                        <?php endif;?>


                    </div>
                    <div class="listChat">
                        <!--  СООБЩЕНИЯ ИЗ ЧАТА  -->
                        <?php $this->renderPartial('//chat/_listChat', array(
                            'dataProvider' => $this->listChat,
                        )); ?>
                    </div>
                </div>
            </div>

            <!-- СЛУЧАЙНЫЕ -->
            <div class="sidePanel">
                <div class="title">Случайные</div>
                <?php if (!empty($this->randomArt)):?>
                    <?php
                        $this->widget('zii.widgets.CMenu',array(
                            'items' => $this->randomArt,
                        ));
                    ?>
                <?php endif;?>
            </div>

        </div>
        <div class="content">
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'homeLink'  => CHtml::link('Главная', Yii::app()->homeUrl),
                'links'     => $this->breadcrumbs,
                'separator' => ' / ',
                'htmlOptions' => array('class'=>'breadcrumbs divStyle1')
            )); ?>
            <?php echo $content; ?>
        </div>
        <!-- ПРАВАЯ БОКОВАЯ КОЛОНКА -->
        <div class="rightColumn">
            <!-- 111 -->
            <div class="sidePanel">
                <div class="title">111</div>
            </div>

            <!-- 222 -->
            <div class="sidePanel">
                <div class="title">222</div>
            </div>

            <!-- TAGS -->
            <div class="sidePanel">
                <div class="title">Теги</div>
                <div class="listTags">
                    <?php foreach ($this->tags as $tag): ?>
                        <?php echo CHtml::link($tag['label'], $tag['url'])?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
<?php $this->endContent(); ?>