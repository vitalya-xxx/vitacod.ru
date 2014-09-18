<?php

class CommentsController extends BaseController
{
    /**
     * Добавление / редактирование комментариев
     */
    public function actionSave_comment()
	{
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('base'));
        }

        // Редактирование или добавление новой
        if (isset($_GET['idComment'])) {
            $model = Comments::model()->findByPk($_GET['idComment']);
        }
        else {
            $model=new Comments();
        }

        if (isset($_POST['idArticle']) && isset($_POST['text']) && isset($_POST['idAuthor'])) {
            $model->idArticle   = $_POST['idArticle'];
            $model->text        = $_POST['text'];
            $model->idUser      = (empty($this->_user)) ? Users::getIdUserForAdmin() : $this->_user['idUser'];
            $model->typeUser    = ($model->idUser == $_POST['idAuthor']) ? 'author' : ((empty($this->_user)) ? 'admin' : 'user');

            if($model->save()){
                if (Yii::app()->request->isAjaxRequest) {
                    $criteria               = new CDbCriteria();
                    $criteria->with         = array('idUser0');
                    $criteria->condition    = 'idArticle = :idArticle AND deleted = 0 AND public = 1';
                    $criteria->params       = array(':idArticle' => $_POST['idArticle']);
                    $comments               = Comments::model()->findAll($criteria);
                    $commentsDataProvider   = new CArrayDataProvider($comments, array(
                        'keyField'      => 'idComment',
                        'pagination'    => array(
                            'pageSize' => 50,
                        ),
                    ));
                    $listComments = $this->renderPartial('_list_comments', array('dataProvider' => $commentsDataProvider), true);

                    echo CJSON::encode(array('listComments' => $listComments));
                    exit();
                }
            }
        }
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}