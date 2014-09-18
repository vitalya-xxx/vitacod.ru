<?php

class UsersController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * Кабинет пользователя
     */
    public function actionUser_cabinet(){
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['Users']))
            {
                $model      = Users::model()->findByPk($_POST['Users']['idUser']);
                $oldFile    = null;
                $fileName   = null;

                // Генерим имя фото
                if ('' != $_FILES['Users']['name']['image']) {
                    $fileName                   = AuxiliaryFunctions::getUniquNamePhoto($_FILES['Users']['name']['image']);
                    $_POST['Users']['photo']    = $fileName;
                    $oldFile                    = $model->photo;
                }

                $model->attributes=$_POST['Users'];

                if($model->save(false)){
                    if ($fileName) {
                        AuxiliaryFunctions::savePhoto($model, $fileName, $oldFile);
                    }
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array('result' => 'ok'));
                        exit();
                    }
                }
                else {
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array('error' => 'save'));
                        exit();
                    }
                }
            }
        }

        if (
            Yii::app()->user->isGuest
            || 'Admins' == Yii::app()->session->get("typeAuthorize")
            || !isset($_GET['idUser'])
            || $_GET['idUser'] != Yii::app()->user->id
        ) {
            $this->redirect(Yii::app()->homeUrl);
        }
        else {
            $model = Users::model()->findByPk($_GET['idUser']);
        }

        $artWaitingModeration   = Articles::model()->count('idUser = :idUser AND moderationAppruv = 0', array(":idUser" => $_GET['idUser']));
        $artPublication         = Articles::model()->count('idUser = :idUser AND public = 1', array(":idUser" => $_GET['idUser']));

       $menuInBookmarks = Bookmarks::model()->getUserBookmarks(Yii::app()->user->id);

        $this->render('user_cabinet', array(
            'model'         => $model,
            'tabArticles'   => array(
                'artWaitingModeration'  => $artWaitingModeration,
                'artPublication'        => $artPublication,
                'menuInBookmarks'       => $menuInBookmarks,
            )
        ));
    }


    /* Удаление фото
     *
     * */
    public function actiondelete_photo($model = null, $idRow = null, $urlPhoto = null){

        if ($_POST) {
            $model      = $_POST['model'];
            $idRow      = $_POST['idRow'];
            $urlPhoto   = getcwd().$_POST['urlPhoto'];
        }

        if (null != $model || null != $idRow || null != $urlPhoto) {
            $classModel = new $model();
            if ($classModel->updateByPk($idRow, array('photo' => ''))) {
                if (file_exists($urlPhoto)) {
                    unlink($urlPhoto);
                    echo CJSON::encode(array('response' => 'ok'));
                    exit;
                }
            }
        }
        else {
            if ($_POST) {
                echo CJSON::encode(array('error' => 'Не все параметры'));
                exit;
            }
            else {
                return false;
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