<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'                    => 'users-edit_user-form',
    'enableAjaxValidation'  => false,
    'htmlOptions'           => array(
        'class' => 'form-container_with_border users',
    ),
)); ?>
    <div class="form-title nameForm">Редактирование пользователя ID - <?php echo $model->idUser ?></div>

    <div id="userDataContainer">
        <div id="userData">
            <table id="userDataTable">
                <tr>
                    <td>Логин</td>
                    <td><?php echo $model->login?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $model->email?></td>
                </tr>
                <tr>
                    <td>ФИО</td>
                    <td><?php echo $model->lastFirstName?></td>
                </tr>
            </table>
        </div>
        <div id="userPhoto">
            <div id="userPreviewPhoto" class="form-field previewPhoto card">
                <?php if (!empty($model->photo)) :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("uploads/users/".$model->idUser."/".$model->photo)->adaptive(186,146, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                <?php else :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("images/default/users.png")->adaptive(186,146, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                <?php endif;?>
            </div>
        </div>
    </div>

    <?php echo $form->labelEx($model,'idRole', array('class'=>'form-title')); ?><br />
    <?php echo $form->dropDownList($model, 'idRole', $roles, array('class'=>'form-field', 'style'=>'width: 243px;')); ?>
    <br />
    <?php echo $form->labelEx($model,'ban', array('class'=>'form-title')); ?><br />
    <?php echo $form->dropDownList($model, 'ban', array(
        1 => 'Забанен',
        0 => 'Нет бана',
    ), array('class'=>'form-field', 'style'=>'width: 243px;')); ?>

    <div class="submit-container" id="editUserDataButtons">
        <?php echo CHtml::submitButton('Редактировать', array('class'=>'submit-button')); ?><br />
        <?php echo CHtml::submitButton('Удалить', array('class'=>'submit-button', 'name'=>'delete')); ?><br />
        <?php echo CHtml::submitButton('Отмена', array('class'=>'submit-button', 'name'=>'cancel')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->