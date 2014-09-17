<div class="form userCabinet">
    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'                    => 'users-edit_user-form',
    'enableAjaxValidation'  => false,
    'htmlOptions'           => array(
        'class'           => 'form-container users_cabinet',
        'ajaxUploadPhoto' => true,
    ),
)); ?>
    <div class="form-title nameForm">Ваш личный кабинет</div>

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
        <div id="userPhoto" class="divPreviewPhoto">
            <div id="userPreviewPhoto" class="form-field previewPhoto card" widthImg="186" heightImg="146">
                <?php if (!empty($model->photo)) :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("uploads/users/".$model->idUser."/".$model->photo)->resize(186,146, Image::AUTO)->cache(), '', array('class'=>'uploadImg'))?>
                <?php else :?>
                    <?php echo CHtml::image(Yii::app()->iwi->load("images/default/users.png")->resize(186,146, Image::AUTO)->cache(), '', array('class'=>'uploadImg'))?>
                <?php endif;?>
            </div>
            <?php echo $form->hiddenField($model, 'idUser'); ?>
            <?php echo CHtml::activeFileField($model, 'image', array('class'=>'form-field addPhoto', 'id'=>'dialog-add-file')); ?>
            <?php if (!empty($model->photo)) :?>
                <?php echo CHtml::link('Удалить фотографию', 'javascript:void(0)', array(
                    'id'        => 'deletePhoto',
                    'model'     => get_class($model),
                    'idRow'     => $model->idUser,
                    'urlPhoto'  => strtolower(get_class($model)).'/'.$model->idUser.'/'.$model->photo,
                    'action'    => '/users/delete_photo',
                    'widthImg'  => 186,
                    'heightImg' => 146,
                ));?>
            <?php endif;?>
        </div>
    </div>
    <div id="tabs">
        <ul>
<!--            <li><a href="#tabs-1">Ваши статьи</a></li>-->
            <li><a href="#tabs-2">Ваши закладки</a></li>
        </ul>
<!--        <div id="tabs-1" class="tabContainer">-->
<!--            --><?php //echo CHtml::link('Ожидают модерацию - '.$tabArticles['artWaitingModeration'].' шт.', 'javascript:void(0)', array(
//                'class'     => 'userListArticles',
//                'listType'  => 'cabinet_appruve',
//            ));?>
<!--            <br />-->
<!--            --><?php //echo CHtml::link('Опубликованны - '.$tabArticles['artPublication'].' шт.', 'javascript:void(0)', array(
//                'class'     => 'userListArticles',
//                'listType'  => 'cabinet_public',
//            ));?>
<!--        </div>-->
        <div id="tabs-2" class="tabContainer">
            <!--  ЗАКЛАДКИ  -->
            <?php $this->renderPartial('//bookmarks/_menuInBookmarks', array(
                'menuInBookmarks' => $tabArticles['menuInBookmarks'],
            )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->