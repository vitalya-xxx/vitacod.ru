<?php
/* @var $this AdminsController */
/* @var $model Admins */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'                    => 'admins-save_admin-form',
    'enableAjaxValidation'  => false,
    'htmlOptions'           => array(
        'class' => 'form-container_with_border admins',
    ),
)); ?>
    <div class="form-title nameForm"><?php echo $model->isNewRecord ? 'Добавить админа' : 'Редактировать "'.$model->login.'"'?></div>
    <!--ЛОГИН-->
        <?php echo $form->labelEx($model,'login', array('class'=>'form-title')); ?>
        <?php echo $form->textField($model,'login', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'login'); ?>

    <!--ПАРОЛЬ-->
    <?php if ($model->isNewRecord) :?>
        <?php echo $form->labelEx($model,'password', array('class'=>'form-title')); ?>
        <?php echo $form->textField($model,'password', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'password'); ?>
    <?php endif;?>
    <!--РОЛЬ-->
        <?php echo $form->labelEx($model,'role', array('class'=>'form-title')); ?>
        <?php echo $form->dropDownList($model, 'role', Yii::app()->params['adminRoles'], array('class'=>'form-field', 'style'=>'width: 616px;')); ?>
        <?php echo $form->error($model,'role'); ?>

    <div class="submit-container" id="saveAdminButton">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Редактировать', array('class'=>'submit-button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->