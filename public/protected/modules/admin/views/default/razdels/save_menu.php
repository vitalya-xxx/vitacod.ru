<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'mainmenu-save_menu-form',
        'enableAjaxValidation'  => false,
        'htmlOptions'           => array(
            'class'     => 'form-container_with_border menu',
            'enctype'   => 'multipart/form-data'
        ),
    )); ?>
    <div class="form-title nameForm"><?php echo $model->isNewRecord ? 'Новый пункт меню' : 'Редактировать "'.$model->title.'"'?></div>
    <!--НАЗВАНИЕ-->
    <?php echo $form->labelEx($model,'title', array('class'=>'form-title')); ?>
    <?php echo $form->textField($model,'title', array('class'=>'form-field')); ?>
    <?php echo $form->error($model,'title'); ?>

    <!--ПОЗИЦИЯ-->
    <?php echo $form->labelEx($model,'position', array('class'=>'form-title')); ?>
    <?php echo $form->dropDownList($model, 'position', Yii::app()->params['positionMenu'], array('class'=>'form-field', 'style'=>'width: 616px;')
); ?>
    <?php echo $form->error($model,'position'); ?>

    <!--ТИП-->
    <?php echo $form->labelEx($model,'type', array('class'=>'form-title')); ?>
    <?php echo $form->dropDownList($model, 'type', Yii::app()->params['typeMeny'], array('class'=>'form-field', 'style'=>'width: 616px;')
    ); ?>
    <?php echo $form->error($model,'type'); ?>

    <!--ССЫЛКА-->
    <?php echo $form->labelEx($model,'link', array('class'=>'form-title')); ?>
    <?php echo $form->dropDownList($model, 'link', $links, array('class'=>'form-field', 'style'=>'width: 616px;')); ?>
    <?php echo $form->error($model,'link'); ?>

    <!--ЧАСТЬ САЙТА-->
    <?php echo $form->labelEx($model,'partSite', array('class'=>'form-title')); ?>
    <?php echo $form->dropDownList($model, 'partSite', Yii::app()->params['partSite'], array('class'=>'form-field', 'style'=>'width: 616px;')
    ); ?>
    <?php echo $form->error($model,'partSite'); ?>
    <br />

    <div class="photoContainer">

        <!--ПРЕДПРОСМОТР ФОТО-->
        <div class="divPreviewPhoto">
            <label class="form-title">Предпросмотр фото</label>
            <div class="form-field previewPhoto card">
                <?php if (!empty($model->photo)) :?>
                <?php echo CHtml::image(Yii::app()->iwi->load("uploads/mainmenu/".$model->idMenu."/".$model->photo)->adaptive(257,173, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                <?php else :?>
                <?php echo CHtml::image(Yii::app()->iwi->load("images/default/mainmenu.png")->adaptive(257,173, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                <?php endif;?>
            </div>

            <?php echo $form->labelEx($model,'photo', array('class'=>'form-title')); ?><br />
            <?php echo CHtml::activeFileField($model, 'image', array('class'=>'form-field addPhoto', 'id'=>'dialog-add-file')); ?>
            <?php echo $form->error($model,'photo'); ?>
        </div>

        <!--ЧЕКБОКСЫ-->
        <div class="divUploadPhoto">
            <!--ВИДИМОСТЬ-->
            <div class="formCheckBoxs">
                <?php echo $form->checkBox($model, 'visible'); ?>
                <?php echo $form->labelEx($model,'visible', array('class'=>'form-title')); ?>
            </div>
            <!--МОЖЕТ ИМЕТЬ КАТЕГОРИИ-->
            <div class="formCheckBoxs">
                <?php echo $form->checkBox($model, 'mayBeCat'); ?>
                <?php echo $form->labelEx($model,'mayBeCat', array('class'=>'form-title')); ?>
            </div>
        </div>
    </div>

    <!--КНОПКА-->
    <div class="submit-container" id="saveMenuButtons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Редактировать', array('class'=>'submit-button')); ?>
        <?php if (!$model->isNewRecord) :?>
        <?php echo CHtml::submitButton('Удалить', array('class'=>'submit-button', 'name'=>'delete')); ?>
        <?php endif;?>
        <?php echo CHtml::submitButton('Отмена', array('class'=>'submit-button', 'name'=>'cancel')); ?>
    </div>

    <?php if (!empty($model->photo)) :?>
        <?php echo CHtml::link('Удалить фотографию', 'javascript:void(0)', array(
            'id'        => 'deletePhoto',
            'model'     => get_class($model),
            'idRow'     => $model->idMenu,
            'urlPhoto'  => strtolower(get_class($model)).'/'.$model->idMenu.'/'.$model->photo,
            'action'    => '/admin/default/delete_photo',
        ));?>
    <?php endif;?>
    <?php $this->endWidget(); ?>

</div><!-- form -->