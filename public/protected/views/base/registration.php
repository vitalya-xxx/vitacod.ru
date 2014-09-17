<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'                    => 'users-save_user-form',
    'enableAjaxValidation'  => false,
    'htmlOptions'           => array(
        'class' => 'form-container',
    ),
)); ?>
        <div class="form-title nameForm">Регистрация</div>

        <?php echo $form->labelEx($model,'login', array('class'=>'form-title')); ?><br />
        <?php echo $form->textField($model,'login', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'login'); ?>

        <?php echo $form->labelEx($model,'email', array('class'=>'form-title')); ?><br />
        <?php echo $form->textField($model,'email', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'email'); ?>

        <?php echo $form->labelEx($model,'password', array('class'=>'form-title')); ?><br />
        <?php echo $form->textField($model,'password', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'password'); ?>

        <?php echo $form->labelEx($model,'lastFirstName', array('class'=>'form-title')); ?><br />
        <?php echo $form->textField($model,'lastFirstName', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'lastFirstName'); ?>

    <div class="submit-container" id="divRegisterButton">
        <?php echo CHtml::submitButton('Регистрация', array('class'=>'submit-button')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->