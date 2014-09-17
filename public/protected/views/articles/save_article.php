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
        <?php echo $form->labelEx($tags,'textTag', array('class'=>'form-title')); ?><br />
        <?php
            $this->widget('CAutoComplete',
                array(
                    'model'		    => $tags,
                    'name'		    => 'textTag',
                    'value'         => $model['tagArray'] ? $model['tagArray'] : '',
                    'url'		    => array('default/save_article'),
                    'minChars'	    => 1,
                    'multiple'      => true,
                    'htmlOptions'   => array(
                        'class' => 'form-field',
                        'style' => 'width: 599px;'
                    ),
                )
            );
        ?>
        <?php echo $form->error($tags,'tags'); ?>
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
        <label class="form-title">Выбрать категорию или </label><?php echo CHtml::link('добавить новую категорию', 'javascript:void(0)', array(
            'id'    => 'showNewCategoryPopup',
            'popup' => 'newCategory'
        ));?><br />
        <?php echo $form->dropDownList($model, 'idCategory', $category, array('class'=>'form-field', 'style'=>'width: 616px;')); ?>
        <?php echo $form->error($model, 'idCategory', array('class' => 'errorForm')); ?>
        <br />
    <!--ТЕКСТ-->
        <?php echo $form->labelEx($model,'text', array('class'=>'form-title')); ?><br />
        <?php
            $this->widget('application.extensions.tinymce.ETinyMce', array(
                'model'         => $model,
                'attribute'     => 'text',
                'editorTemplate'=> 'full',
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

            <!--ЧЕКБОКСЫ-->
            <div class="divUploadPhoto">
                <div class="formCheckBoxs">
                    <?php echo $form->checkBox($model, 'moderationAppruv'); ?>
                    <?php echo $form->labelEx($model,'moderationAppruv', array('class'=>'form-title')); ?>
                </div>
                <div class="formCheckBoxs">
                    <?php echo $form->checkBox($model, 'public'); ?>
                    <?php echo $form->labelEx($model,'public', array('class'=>'form-title')); ?>
                </div>
                <div class="formCheckBoxs">
                    <?php echo $form->checkBox($model, 'deleted'); ?>
                    <?php echo $form->labelEx($model,'deleted', array('class'=>'form-title')); ?>
                </div>
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
        <?php if (!empty($model->photo)) :?>
            <?php echo CHtml::link('Удалить фотографию', 'javascript:void(0)', array(
                'id'        => 'deletePhoto',
                'model'     => get_class($model),
                'idRow'     => $model->idArticle,
                'urlPhoto'  => strtolower(get_class($model)).'/'.$model->idArticle.'/'.$model->photo,
                'action'    => '/admin/default/delete_photo',
            ));?>
        <?php endif;?>
        <?php $this->endWidget(); ?>

</div><!-- form -->
