<div class="formLogin">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'login-form',
        'action'                => array('default/index'),
        'method'                => 'post',
        'enableAjaxValidation'  => true,
        'htmlOptions'           => array(
            'class' => 'form-container_with_border login',
        ),
    )); ?>

    <div class="form-title nameForm">Авторизация</div>

    <?php echo $form->labelEx($this->_loginModel,'login', array('class'=>'form-title')); ?>
    <?php echo $form->textField($this->_loginModel,'login', array('class'=>'form-field')); ?>
    <?php echo $form->error($this->_loginModel,'login'); ?>


    <?php echo $form->labelEx($this->_loginModel,'password', array('class'=>'form-title')); ?>
    <?php echo $form->passwordField($this->_loginModel,'password', array('class'=>'form-field')); ?>
    <?php echo $form->error($this->_loginModel,'password'); ?>


    <?php echo $form->checkBox($this->_loginModel,'rememberMe'); ?>
    <?php echo $form->label($this->_loginModel,'rememberMe', array('class'=>'form-title')); ?>
    <?php echo $form->error($this->_loginModel,'rememberMe'); ?>

    <div class="submit-container" id="loginAdminButton">
        <?php echo CHtml::submitButton('Login', array('id' => 'loginBtnAdmin', 'class'=>'submit-button', 'value'=>'Вход')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
