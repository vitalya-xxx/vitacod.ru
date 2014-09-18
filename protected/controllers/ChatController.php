<?php

class ChatController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * Добавление, редактирование, удаление сообщений в чате
     */
    public function actionSave_chat(){
        if (!Yii::app()->user->isGuest) {
            if (Yii::app()->request->isAjaxRequest) {
                $result = false;

                if (isset($_POST['idChat'])) {
                    $model = Chat::model()->findAllByPk((int)$_POST['idChat']);
                }
                else {
                    $model = new Chat();
                }

                switch ($_POST['action']) {
                    case 'add' :
                        $model->text    = trim(htmlspecialchars($_POST['text']));
                        $model->idUser  = (empty($this->_user)) ? Users::getIdUserForAdmin() : $this->_user['idUser'];
                        if ($model->save()){
                            $model->date        = date('d.m.Y H:i', $model->date);
                            $model->nameUser    = (empty($this->_user)) ? 'Админ' : (!empty($this->_user['lastFirstName']) ? $this->_user['lastFirstName'] : $this->_user['login']);
                            $result             = $model;
                        }
                        break;
                    case 'edit' :
                        if ($model->update(array('active' => (int)$_POST['active']))){
                            $result = $model;
                        }
                        break;
                    case 'delete' :
                        if ($model->delete()){
                            $result = true;
                        }
                        break;
                }

                echo CJSON::encode(array('result' => $result));
                exit();
            }
        }
    }

    /**
     * Обновление сообщений в чате
     */
    public function actionUpdateListChat(){
        if (Yii::app()->request->isAjaxRequest) {
            $listChat = '';

            if (isset($_POST['lastMsgId'])) {
//                $lastId = (int)Chat::getLastId();
//                if ($lastId != (int)$_POST['lastMsgId']) {
                    $result     = Chat::getListChat();
                    $listChat   = $this->renderPartial('//chat/_listChat', array(
                        'dataProvider' => $result,
                    ), true);
//                }
            }

            echo CJSON::encode(array('listChat' => $listChat));
            exit();
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