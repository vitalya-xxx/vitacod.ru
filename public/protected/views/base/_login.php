<div class="formLogin">
    <div id="closeAuthorise" class="authorizeButton closeButton"></div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'login-form',
        'method'                => 'post',
        'enableAjaxValidation'  => true,
        'htmlOptions'           => array(
            'class' => 'form-container login',
        ),
    )); ?>

    <div class="form-title nameForm">Авторизация</div>

    <?php echo $form->labelEx($this->_loginModel,'login', array('class'=>'form-title')); ?>
    <?php echo $form->textField($this->_loginModel,'login', array('class'=>'form-field')); ?>


    <?php echo $form->labelEx($this->_loginModel,'password', array('class'=>'form-title')); ?>
    <?php echo $form->passwordField($this->_loginModel,'password', array('class'=>'form-field')); ?>

    <?php echo $form->checkBox($this->_loginModel,'rememberMe'); ?>
    <?php echo $form->label($this->_loginModel,'rememberMe', array('class'=>'form-title')); ?>
    <?php echo $form->error($this->_loginModel,'rememberMe'); ?>
    <br />
    <br />
    <?php echo CHtml::link('<div class="registerBtn redButton">Регистрация</div>', array('base/registration'), array('class'=>'form-title', 'id'=>'linkRegistration'))?>

    <div class="submit-container" id="loginButton">
        <?php echo CHtml::submitButton('Login', array('id'=>'baseLoginButton','class'=>'submit-button','value'=>'Вход')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->