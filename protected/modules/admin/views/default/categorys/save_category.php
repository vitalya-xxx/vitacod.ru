<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'                    => 'save_category-form',
	'enableAjaxValidation'  => false,
    'method'				=> 'post',
    'htmlOptions'           => array(
        'class'     => 'form-container_with_border category',
        'enctype'   => 'multipart/form-data'
    ),
)); ?>
    <div class="form-title nameForm"><?php echo $model->isNewRecord ? 'Новая категория' : 'Редактировать "'.$model->title.'"'?></div>

    <!--НАЗВАНИЕ-->
    <?php echo $form->labelEx($model,'title', array('class'=>'form-title')); ?>
    <?php echo $form->textField($model,'title', array('class'=>'form-field')); ?>
    <?php echo $form->error($model,'title'); ?>

    <!--ОПИСАНИЕ-->
    <?php echo $form->labelEx($model,'description', array('class'=>'form-title')); ?>
    <?php echo $form->textArea($model,'description', array('class'=>'form-field')); ?>
    <?php echo $form->error($model,'description'); ?>

    <!--ПУНКТ МЕНЮ-->
    <?php echo $form->labelEx($model,'idMenu', array('class'=>'form-title')); ?>
    <?php echo $form->dropDownList($model, 'idMenu', $menus, array('class'=>'form-field', 'style'=>'width: 616px;')); ?>
    <?php echo $form->error($model,'idMenu'); ?>

    <div class="photoContainer">
        <!--ПРЕДПРОСМОТР ФОТО-->
        <div class="divPreviewPhoto">
            <label class="form-title">Предпросмотр фото</label>
            <div class="form-field previewPhoto card">
                <?php if (!empty($model->photo)) :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("uploads/categorys/".$model->idCategory."/".$model->photo)->adaptive(257,173, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                <?php else :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("images/default/Categorys.png")->adaptive(257,173, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                <?php endif;?>
            </div>

            <?php echo $form->labelEx($model,'photo', array('class'=>'form-title')); ?><br />
            <?php echo CHtml::activeFileField($model, 'image', array('class'=>'form-field addPhoto', 'id'=>'dialog-add-file')); ?>
            <?php echo $form->error($model,'photo'); ?>
            <?php if (!empty($model->photo)) :?>
            <?php echo CHtml::link('Удалить фотографию', 'javascript:void(0)', array(
                'id'        => 'deletePhoto',
                'model'     => get_class($model),
                'idRow'     => $model->idCategory,
                'urlPhoto'  => strtolower(get_class($model)).'/'.$model->idCategory.'/'.$model->photo,
                'action'    => '/admin/default/delete_photo',
            ));?>
            <?php endif;?>
        </div>

        <!--ЧЕКБОКСЫ-->
        <div class="divUploadPhoto">
            <!--ВИДИМОСТЬ-->
            <div class="formCheckBoxs">
                <?php echo $form->checkBox($model, 'active'); ?>
                <?php echo $form->labelEx($model,'active', array('class'=>'form-title')); ?>
            </div>
        </div>

        <!--ФОТО-->
        <div class="divUploadPhoto">
        </div>
    </div>

	<div class="submit-container" id="saveArticleButtons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Редактировать', array('class'=>'submit-button', 'id'=>'saveCategoryButton')); ?>
        <?php echo CHtml::submitButton('Отмена', array('class'=>'submit-button', 'name'=>'cancel', 'id'=>'cancelButton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->