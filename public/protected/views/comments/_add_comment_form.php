<div class="formComment listComments">
    <div class="blockCommentsHeader">Оставить комментарий:</div>

    <?php if (!Yii::app()->user->isGuest) :?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'comments-add-form',
        'enableAjaxValidation'  => false,
        'htmlOptions'           => array(
            'class' => 'form-container',
        ),
    )); ?>

    <?php echo CHtml::hiddenField('idArticle', $idArticle)?>
    <?php echo CHtml::hiddenField('idAuthor', $idAuthor)?>

    <?php echo $form->labelEx($model,'text', array('class'=>'form-title')); ?><br />
    <?php echo $form->textArea($model,'text', array('class'=>'form-field', 'style'=>'height: 100px;')); ?>
    <?php echo $form->error($model,'text'); ?>

    <div class="submit-container" id="saveArticleButtons">
        <?php echo CHtml::button('Отправить', array('class'=>'submit-button', 'id' => 'addCommentButton')); ?>
    </div>

    <?php $this->endWidget(); ?>
    <?php else :?>
    <div class="blockCommentsAuthorize">Комментарии могут оставлять только авторизированные пользователи.</div>
    <?php endif;?>

</div><!-- form -->