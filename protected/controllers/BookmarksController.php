<?php

class BookmarksController extends BaseController
{
	public function actionSave_bookmark()
	{
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('base'));
        }

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Bookmarks']['idArticle']) && isset($_POST['Bookmarks']['idMenu'])) {
                $model = new Bookmarks();
                $model->attributes=$_POST['Bookmarks'];
                $model->idUser = Yii::app()->user->id;
                if($model->save()){
                    echo CJSON::encode(array('idBookmarks' => $model->idBookmarks));
                    exit();
                }
                else {
                    echo CJSON::encode(array('error' => 'ok'));
                    exit();
                }
            }
        }
	}


    public function actionDelete_bookmark()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('base'));
        }

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['idBookmarks'])) {
                Bookmarks::model()->deleteByPk($_POST['idBookmarks']);
                echo CJSON::encode(array('status' => 'ok'));
                exit();
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