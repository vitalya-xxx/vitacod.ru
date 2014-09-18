<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'mainmenu-save_menu-form',
        'enableAjaxValidation'  => false,
        'htmlOptions'           => array(
            'class' => 'form-container_with_border menu',
        ),
    )); ?>
    
    <div class="form-title nameForm"><?php echo $model->isNewRecord ? 'Новая ссылка' : 'Редактировать "'.$model->link.'"'?></div>

    <?php echo $form->labelEx($model,'link', array('class'=>'form-title')); ?>
    <?php echo $form->textField($model,'link', array('class'=>'form-field')); ?>
    <?php echo $form->error($model,'link'); ?>

    <?php echo $form->labelEx($model,'description', array('class'=>'form-title')); ?>
    <?php echo $form->textField($model,'description', array('class'=>'form-field')); ?>
    <?php echo $form->error($model,'description'); ?>

    <br />

    <!--КНОПКА-->
    <div class="submit-container" id="saveMenuButtons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Редактировать', array('class'=>'submit-button')); ?>
        <?php if (!$model->isNewRecord) :?>
        <?php echo CHtml::submitButton('Удалить', array('class'=>'submit-button', 'name'=>'delete')); ?>
        <?php endif;?>
        <?php echo CHtml::submitButton('Отмена', array('class'=>'submit-button', 'name'=>'cancel')); ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
