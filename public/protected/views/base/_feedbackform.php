<?php
/* @var $this FeedbackFormController */
/* @var $model FeedbackForm */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'feedback-form-feedbackView-form',
        'enableAjaxValidation'  => false,
        'htmlOptions'           => array(
            'class' => 'form-container feedback',
        ),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name', array('class'=>'form-title')); ?>
        <?php echo $form->textField($model,'name', array('class'=>'form-field')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email', array('class'=>'form-title')); ?>
        <?php echo $form->textField($model,'email', array('class'=>'form-field')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'message', array('class'=>'form-title')); ?>
        <?php echo $form->textArea($model,'message', array('class'=>'form-field', 'style'=>'height: 100px;')); ?>
    </div>

    <div class="submit-container" id="feedbackBtnContainer">
        <?php echo CHtml::button('feedbackBtn', array('id'=>'feedbackBtn','class'=>'submit-button','value'=>'Отправить')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->