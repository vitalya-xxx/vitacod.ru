<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'                    => 'articles-form',
        'enableAjaxValidation'  => false,
        'htmlOptions'           => array(
            'class'     => 'form-container_with_border',
            'enctype'   => 'multipart/form-data'
        ),
    )); ?>

    <!--НАЗВАНИЕ-->
        <?php echo $form->labelEx($model,'title', array('class'=>'form-title')); ?><br />
        <?php echo $form->textField($model,'title', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'title'); ?>
        <br />
    <!--ТЕГИ-->
        <?php echo $form->labelEx($model,'tags', array('class'=>'form-title')); ?><br />
        <?php echo $form->textField($model,'tags', array('class'=>'form-field')); ?>
        <?php echo $form->error($model,'tags'); ?>
        <br />
    <!--КРАТКОЕ ОПИСАНИЕ-->
        <?php echo $form->labelEx($model,'description', array('class'=>'form-title')); ?><br />
        <?php echo $form->textArea($model,'description', array('class'=>'form-field', 'style'=>'height: 100px;')); ?>
        <?php echo $form->error($model,'description'); ?>
        <br />

    <!--ПУНКТ МЕНЮ-->
        <?php echo $form->labelEx($model,'idMenu', array('class'=>'form-title')); ?>
        <?php echo $form->dropDownList($model, 'idMenu', $menus, array('class'=>'form-field', 'style'=>'width: 616px;')); ?>
        <?php echo $form->error($model,'idMenu'); ?>

    <!--ВЫБОР КАТЕГОРИИ-->
        <label class="form-title">Выбрать категорию</label><br />
        <?php echo $form->dropDownList($model, 'idCategory', $category, array('class'=>'form-field', 'style'=>'width: 616px;')); ?>
        <?php echo $form->error($model, 'idCategory', array('class' => 'errorForm')); ?>
        <br />
    <!--ТЕКСТ-->
        <?php echo $form->labelEx($model,'text', array('class'=>'form-title')); ?><br />
        <?php
            $this->widget('application.extensions.tinymce.ETinyMce', array(
                'model'         => $model,
                'attribute'     => 'text',
                'editorTemplate'=> 'simple',
                'useCompression'=> false,
                'language'      => 'ru',
                'htmlOptions'   => array('style'=>'width: 600px; height: 500px;')
            ));
        ?>
        <?php echo $form->error($model,'text', array('id'=>'forTinyMceError')); ?>
        <br />

        <div class="photoContainer">

            <!--ПРЕДПРОСМОТР ФОТО-->
            <div class="divPreviewPhoto">
                <label class="form-title">Предпросмотр фото</label>
                <div class="form-field previewPhoto card">
                    <?php if (!empty($model->photo)) :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("uploads/articles/".$model->idArticle."/".$model->photo)->adaptive(257,173, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                    <?php else :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("images/default/Articles.png")->adaptive(257,173, Iwi::NONE)->cache(), '', array('class'=>'uploadImg'))?>
                    <?php endif;?>
                </div>

                <?php echo $form->labelEx($model,'photo', array('class'=>'form-title')); ?><br />
                <?php echo CHtml::activeFileField($model, 'image', array('class'=>'form-field addPhoto', 'id'=>'dialog-add-file')); ?>
                <?php echo $form->error($model,'photo'); ?>
            </div>
        </div>

    <!--КНОПКА-->
        <div class="submit-container" id="saveArticleButtons">
            <?php echo CHtml::submitButton('Сохранить', array('class'=>'submit-button')); ?>
            <?php if (!$model->isNewRecord) :?>
                <?php echo CHtml::submitButton('Удалить', array('class'=>'submit-button', 'name'=>'delete')); ?>
            <?php endif;?>
            <?php echo CHtml::submitButton('Отмена', array('class'=>'submit-button', 'name'=>'cancel')); ?>
        </div>
        <?php $this->endWidget(); ?>

</div><!-- form -->
