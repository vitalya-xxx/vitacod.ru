<?php

class BaseController extends Controller
{
    public $_loginModel     = null;
    public $_user           = null;
    public $topMenu         = array();
    public $middleMenu      = array();
    public $_listCategory   = null;
    public $breadcrumbs     = array();
    public $listChat        = null;
    public $randomArt       = null;
    public $stateChat       = 1;

    /**
     * Конструктор
     * @return bool
     */

    protected function beforeAction()
    {
        $this->layout       = 'start_page';
        $this->topMenu      = Mainmenu::getMenu('top', 'site');
        $this->middleMenu   = Mainmenu::getMenu('middle', 'site');
        $this->listChat     = Chat::getListChat();
        $this->randomArt    = Articles::getRandomArticles(10);

        $settingChat        = Settings::model()->findByAttributes(array('parameter'=>Yii::app()->params['parameter']['chat']));
        $this->stateChat    = (null != $settingChat) ? (int)$settingChat->value : 0;

        if (!Yii::app()->user->isGuest) {
            $this->_user = Users::model()->findByPk(Yii::app()->user->id);
        }
        else {
            $this->_loginModel = new LoginForm;
        }
        return true;
    }


    /**
     * Стартовая страница
     */
    public function actionIndex()
	{
        $criteria               = new CDbCriteria;
        $criteria->with         = array('articlesMenuCount', 'categoryCount');
        $criteria->condition    = 'type = :type AND partSite = :partSite AND visible = 1';
        $criteria->params       = array(
            ':type'     => 'middle',
            ':partSite' => 'site'
        );
        $criteria->order        = 'position ASC';
        $result                 = Mainmenu::model()->findAll($criteria);
        $this->_listCategory    = Categorys::getAllCategories(null, true, true);

        $dataProvider           = new CArrayDataProvider($result, array('keyField'=>'idMenu'));

        if (isset($_GET['referrer']) && 'new_article' == $_GET['referrer']) {
            Yii::app()->clientScript->registerScript(
                'infoMessage',
                'showInfoPopup("success", true, "Все отлично))", "Ваша статья успешно добавлена, она будет опубликованна сразу после проверки администратором.");',
                CClientScript::POS_READY
            );
        }

		$this->render('index', array('dataProvider' => $dataProvider));
	}

    /**
     * AJAX авторизация
     *
     */
    public function actionLogin(){
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['popup'])) {
                $model = new Users();
                $popup = $this->renderPartial('_login', array(
                    'model' => $model,
                ), true);

                echo CJSON::encode(array('popup' => $popup));
                exit();
            }

            if (isset($_POST['LoginForm'])) {
                $this->_loginModel              = new LoginForm;
                $this->_loginModel->attributes  = $_POST['LoginForm'];
                if($this->_loginModel->validate() && $this->_loginModel->login()) {
                    echo CJSON::encode(array('url' => $_SERVER['HTTP_REFERER']));
                    exit();
                }
                else {
                    echo CJSON::encode(array('result' => 'error'));
                    exit();
                }
            }
        }
    }

    /* Разлогинивание пользователя
     *
     *
     * */
    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }


    /**
     * Регистрациия пользователя
     */
    public function actionRegistration(){
        $this->layout = 'start_page';

        if (isset($_GET['idUser'])) {
            $model = Users::model()->findByPk($_GET['idUser']);
        }
        else {
            $model = new Users();
        }

        if(isset($_POST['Users']))
        {
            $model->attributes  = $_POST['Users'];
            $model->idRole      = 2;
            
            if($model->validate())
            {
                if($model->save()){
                    $this->_loginModel              = new LoginForm;
                    $this->_loginModel->login       = $model->login;
                    $this->_loginModel->password    = $_POST['Users']['password'];
                    if ($this->_loginModel->login()) {
                        $this->redirect(Yii::app()->homeUrl);
                    }
                }
            }
        }

        $this->render('registration', array('model'=>$model));
    }


    /**
     * Отправка письма администратору
     */
    public function actionFeedback(){
        $model = new FeedbackForm();

        if (isset($_POST['FeedbackForm'])) {
            $model->attributes  = $_POST['FeedbackForm'];
            if ($model->validate()) {
                $headers="From: {$model->email}\r\nReply-To: {$model->email}";
                if (mail(Yii::app()->params['adminEmail'], $model->name, $model->message, $headers)) {
                    echo CJSON::encode(array('success' => 'ok'));
                    exit();
                }
            }
            else {
                echo CJSON::encode(array('error' => 'ok'));
                exit();
            }
        }
        else {
            $popup = $this->renderPartial('_feedbackform', array('model'=>$model), true);
            VarDumper::dump($popup);	
            echo CJSON::encode(array('popup' => $popup));
            exit();
        }
    }


    /**
     * Карта сайта
     */
    public function actionSite_map(){
        // ITEMS MENUS
        $menus = Mainmenu::model()->findAll(array(
            'condition' => 'type = "middle" AND partSite = "site" AND visible = 1',
        ));

        $itemsArray = array();

        foreach ($menus as $oneMenu) {
            $itemMenu = array(
                'label' => $oneMenu->title,
                'url'   => array(
                    $oneMenu->link,
                    'listType'  => 'razdel',
                    'idMenu'    => $oneMenu->idMenu
                ),
                'itemOptions' => array('class' => 'itemMenu'),
                'linkOptions' => array('class' => 'linkMenu')
            );

            // ITEMS CATEGORYS
            $categorys = Categorys::model()->findAll(array(
                'condition' => 'idMenu = :idMenu AND active = 1',
                'params'    => array(':idMenu' => $oneMenu->idMenu),
            ));

            // ITEMS ARTICLES (MENU)
            $articlesMenu = Articles::model()->findAll(array(
                'condition' => 'moderationAppruv = 1 AND public = 1 AND deleted = 0 AND idMenu = :idMenu AND idCategory = 0',
                'params'    => array(':idMenu' => $oneMenu->idMenu),
            ));

            $categoryItems = array();

            if (!empty($categorys)) {
                foreach ($categorys as $oneCategory) {
                    $itemCategory = array('label'=>$oneCategory->title, 'url'=>array(
                            'articles/list_articles',
                            'listType'      => 'category',
                            'idMenu'        => $oneCategory->idMenu,
                            'idCategory'    => $oneCategory->idCategory,
                        ),
                        'itemOptions' => array('class'=>'itemCategory'),
                        'linkOptions' => array('class'=>'linkCategory')
                    );

                    // ITEMS ARTICLES (MENU - CATEGORY)
                    $articles = Articles::model()->findAll(array(
                        'condition' => 'moderationAppruv = 1 AND public = 1 AND deleted = 0 AND idMenu = :idMenu AND idCategory = :idCategory',
                        'params'    => array(':idMenu' => $oneMenu->idMenu, ':idCategory' => $oneCategory->idCategory),
                    ));

                    if (!empty($articles)) {
                        $catMenuArtItem = array();

                        foreach ($articles as $oneArticle) {
                            $catMenuArtItem['items'][] = array('label'=>$oneArticle->title, 'url'=>array(
                                    'articles/view_article',
                                    'idArticle' => $oneArticle->idArticle,
                                    'idMenu'    => $oneArticle->idMenu
                                ),
                                'itemOptions' => array('class'=>'itemArticle'),
                                'linkOptions' => array('class'=>'linkArticle')
                            );
                        }

                        $categoryItems['items'][] = $itemCategory+$catMenuArtItem;
                    }
                    else {
                        $categoryItems['items'][] = $itemCategory;
                    }
                }
            }
            if (!empty($articlesMenu)) {
                foreach ($articlesMenu as $oneArticleMenu) {
                    $categoryItems['items'][] = array('label'=>$oneArticleMenu->title, 'url'=>array(
                            'articles/view_article',
                            'idArticle' => $oneArticleMenu->idArticle,
                            'idMenu'    => $oneArticleMenu->idMenu
                        ),
                        'itemOptions' => array('class'=>'itemArticle'),
                        'linkOptions' => array('class'=>'linkArticle')
                    );
                }
            }

            if (!empty( $categoryItems['items'])) {
                $itemsArray['items'][] = $itemMenu+$categoryItems;
            }
            else {
                $itemsArray['items'][] = $itemMenu;
            }
        }

        $this->render('site_map', array('itemsArray'=>$itemsArray));
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