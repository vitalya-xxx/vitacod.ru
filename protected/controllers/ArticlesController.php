<?php

class ArticlesController extends BaseController
{
    protected function beforeAction()
    {
        parent::beforeAction();
        return true;
    }


    /**
     * Список статей для разных вкладок
     */
    public function actionList_articles(){
        $criteria               = new CDbCriteria();
        $criteria->with         = array('idCategory0','idMenu0','idUser0','commentsCount','tagstoarticles');
        $criteria->condition    = 'moderationAppruv = 1 AND public = 1 AND deleted = 0';

        if (isset($_GET['listType']) || isset($_POST['listType'])) {
            $listType = isset($_GET['listType']) ? $_GET['listType'] : $_POST['listType'];
        }
        else {
            $listType = 'main';
        }

        switch ($listType) {

            case 'razdel' :
                if (isset($_GET['idMenu'])) {
                    $this->breadcrumbs = AuxiliaryFunctions::fillingBreadcrumbs($_GET['idMenu'], 'mainMenu');
                    $criteria->AddCondition('t.idMenu = :idMenu');
                    $criteria->params = array (':idMenu'=> $_GET['idMenu']);
                }
                $criteria->order        = 'dateCreate DESC';
                $this->_listCategory    = Categorys::getAllCategories($_GET['idMenu'], true, true);
                $this->render('_list_articles', $this->getArticlesDataProvider($criteria));
                break;

            case 'category' :
                if (isset($_GET['idMenu']) && isset($_GET['idCategory'])) {
                    $this->breadcrumbs = AuxiliaryFunctions::fillingBreadcrumbs($_GET['idCategory'], 'category');
                    $criteria->AddCondition('t.idMenu = :idMenu AND t.idCategory = :idCategory');
                    $criteria->params = array (':idMenu'=> $_GET['idMenu'], ':idCategory' => $_GET['idCategory']);
                }
                $criteria->order        = 'dateCreate DESC';
                $this->_listCategory    = Categorys::getAllCategories($_GET['idMenu'], true, true);
                $this->render('_list_articles', $this->getArticlesDataProvider($criteria));
                break;

            case 'tags' :
                if (isset($_GET['idTag'])) {
                    $idTag          = trim(htmlspecialchars($_GET['idTag']));
                    $criteria->join = 'INNER JOIN tagstoarticles AS t2a ON t2a.idTag = '.$idTag.'';
                    $criteria->AddCondition('t2a.idArticle = t.idArticle');
                }
                $criteria->order = 'dateCreate DESC';
                $this->render('_list_articles', $this->getArticlesDataProvider($criteria));
                break;

            case 'search' :
                if (isset($_POST['soughtValue'])) {
                    $searchResult = Articles::model()->getListArticles($_POST['soughtValue']);
                    if (!empty($searchResult)) {
                        $dataProvider   = new CArrayDataProvider($searchResult, array('keyField'=>'idArticle'));
                        $popup          = $this->renderPartial('_list_articles_search', array('dataProvider'=>$dataProvider), true);
                        echo CJSON::encode(array('popup' => $popup));
                        exit();
                    }
                    else {
                        echo CJSON::encode(array('result' => null));
                        exit();
                    }
                }
                break;

            case 'cabinet_appruve' :
                $criteria->condition = 'moderationAppruv = 0 AND deleted = 0';
                if (Yii::app()->user->id) {
                    $criteria->AddCondition('t.idUser = :idUser');
                    $criteria->params   = array (':idUser'=> Yii::app()->user->id);
                    $criteria->order    = 'dateCreate DESC';
                    $popup              = $this->renderPartial('_list_articles_cabinet', $this->getArticlesDataProvider($criteria), true);
                    echo CJSON::encode(array('popup' => $popup));
                    exit();
                }
                break;

            case 'cabinet_public' :
                if (Yii::app()->user->id) {
                    $criteria->AddCondition('t.idUser = :idUser');
                    $criteria->params   = array (':idUser'=> Yii::app()->user->id);
                    $criteria->order    = 'dateCreate DESC';
                    $popup              = $this->renderPartial('_list_articles_cabinet', $this->getArticlesDataProvider($criteria), true);
                    echo CJSON::encode(array('popup' => $popup));
                    exit();
                }
                break;

            case 'cabinet_bookmarks' :
                if (Yii::app()->user->id) {
                    if (isset($_POST['idMenu'])) {
                        $criteria->join = 'INNER JOIN bookmarks AS b ON b.idUser = '.Yii::app()->user->id.' AND b.idArticle = t.idArticle';
                        $criteria->AddCondition('t.idMenu = :idMenu');
                        $criteria->params = array (':idMenu'=> $_POST['idMenu']);

                        if (isset($_POST['idCategory'])) {
                            $criteria->AddCondition('t.idCategory = :idCategory');
                            $criteria->params[':idCategory'] = $_POST['idCategory'];
                        }
                    }
                    $criteria->order    = 'dateCreate DESC';
                    $popup              = $this->renderPartial('_list_articles_cabinet', $this->getArticlesDataProvider($criteria), true);
                    echo CJSON::encode(array('popup' => $popup));
                    exit();
                }
                break;
        }
    }

    /**
     * Возвращает dataProvider и pagination для видов списка статей
     * @param $criteria
     * @return array
     */
    public function getArticlesDataProvider($criteria){
        $count = Articles::model()->count($criteria);
        $pages = new CPagination($count);

        $pages->setPageSize(10);
        $pages->applyLimit($criteria);

        $result         = Articles::model()->findAll($criteria);
        $dataProvider   = new CArrayDataProvider($result, array('keyField'=>'idArticle'));

        // Формируем массив тегов для каждой статьи
        foreach ($dataProvider->rawData as $art) {
            $art['tagArray'] = AuxiliaryFunctions::getTagsList($art->tagstoarticles);
        }

        return array(
            'dataProvider'  => $dataProvider,
            'pages'         => $pages
        );
    }


    /**
     * Просмотр статьи с комментами
     */
    public function actionView_article(){
        if (isset($_GET['idArticle']) || isset($_POST['idArticle'])) {
            $idArticle = isset($_GET['idArticle']) ? $_GET['idArticle'] : $_POST['idArticle'];
            $criteria = new CDbCriteria();

            // Комментарии к статье
            $criteria->with         = array('idUser0');
            $criteria->condition    = 'idArticle = :idArticle AND deleted = 0 AND public = 1';
            $criteria->params       = array(':idArticle' => $idArticle);
            $comments               = Comments::model()->findAll($criteria);
            $commentsDataProvider   = new CArrayDataProvider($comments, array(
                'keyField'      => 'idComment',
                'pagination'    => array(
                    'pageSize' => 50,
                ),
            ));

            // Статья
            $criteria->with         = array('idCategory0','idMenu0','idUser0','commentsCount','tagstoarticles');
            $criteria->condition    = 't.idArticle = :idArticle AND moderationAppruv = 1 AND public = 1 AND deleted = 0';
            if (Yii::app()->request->isAjaxRequest) {
                if (isset($_POST['type'])) {
                    if ('appruve' == $_POST['type']) {
                        $criteria->condition = 't.idArticle = :idArticle AND moderationAppruv = 0 AND deleted = 0';
                    }
                }
            }
            $criteria->params       = array(':idArticle' => $idArticle);
            $model                  = Articles::model()->find($criteria);

            // Теги
            $model['tagArray'] = AuxiliaryFunctions::getTagsList($model->tagstoarticles);

            // Счетчик просмотров статьи
            if (($model->idUser != Yii::app()->user->id) && ('Admins' != Yii::app()->session->get("typeAuthorize"))) {
                $model->saveCounters(array('numberOfViews' => 1));
            }

            if (isset($_GET['idMenu'])) {
                // Категории раздела
                $this->_listCategory = Categorys::getAllCategories($_GET['idMenu'], true, true);
            }

            $bookmarks = Bookmarks::model()->find(array(
                'select'        => 'idBookmarks',
                'condition'     => 'idUser = :idUser AND idArticle = :idArticle AND idMenu = :idMenu AND idCategory = :idCategory',
                'params'        => array(
                    ':idUser'        => Yii::app()->user->id,
                    ':idArticle'     => $model->idArticle,
                    ':idMenu'        => $model->idMenu,
                    ':idCategory'    => $model->idCategory,
                ),
            ));

            if (Yii::app()->request->isAjaxRequest) {
                $articlePopup = $this->renderPartial('view_article', array(
                    'model'                 => $model,
                    'commentsDataProvider'  => $commentsDataProvider,
                    'modelComment'          => new Comments(),
                    'idBookmarks'           => (null === $bookmarks) ? null : $bookmarks->idBookmarks,
                ), true);

                echo CJSON::encode(array('popup' => $articlePopup));
                exit();
            }

            $this->breadcrumbs  = AuxiliaryFunctions::fillingBreadcrumbs($idArticle, 'article');

            $this->render('view_article', array(
                'model'                 => $model,
                'commentsDataProvider'  => $commentsDataProvider,
                'modelComment'          => new Comments(),
                'idBookmarks'           => (null === $bookmarks) ? null : $bookmarks->idBookmarks,
            ));
        }
    }

    /**
     * Добавление статьи пользователем
     */
    public function actionNew_article(){
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['idMenu'])) {
                $category1          = array('' => 'Без категории');
                $category2          = Categorys::getAllCategories($_POST['idMenu']);
                $category           = $category1 + $category2;
                $filteredCategory   = array();
                $i                  = 0;

                foreach ($category as $key => $val) {
                    $filteredCategory[$i]['id']       = $key;
                    $filteredCategory[$i]['title']    = $val;
                    $i++;
                }

                echo CJSON::encode(array('categorys'=>$filteredCategory));
                exit();
            }
        }

        // Проверки на доступ к странице
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        if (isset($_POST['cancel'])) {
            $this->redirect(Yii::app()->homeUrl);
        }

        $model = new Articles('create');

        // Нажата кнопка "Редактировать" или "Добавить"
        if(isset($_POST['Articles']))
        {
            $oldFile    = null;
            $oldFile    = $model->photo;

            // Генерим имя фото
            if ('' != $_FILES['Articles']['name']['image']) {
                $fileName                   = AuxiliaryFunctions::getUniquNamePhoto($_FILES['Articles']['name']['image']);
                $_POST['Articles']['photo'] = $fileName;
                $oldFile                    = $model->photo;
            }

            $model->attributes  = $_POST['Articles'];
            $model->idUser      = Yii::app()->user->id;

            if($model->validate())
            {
                if($model->save()){
                    if ($fileName) {
                        AuxiliaryFunctions::savePhoto($model, $fileName, $oldFile);
                    }
                    if (1 == $model->public && 1 == $model->moderationAppruv) {
                        $this->redirect($this->createAbsoluteUrl('articles/view_article', array(
                            'idArticle' => $model->idArticle,
                            'idMenu'    => $model->idMenu
                        )));
                    }

                    $this->redirect($this->createAbsoluteUrl('base/index', array('referrer'=>'new_article')));
                }
            }
        }

        $menus      = Mainmenu::model()->getDropDownMenu();
        $idMenu     = (!empty($model->idMenu) ? $model->idMenu : key($menus));

        $category1  = array('' => 'Без категории');
        $category2  = Categorys::getAllCategories($idMenu);
        $category   = $category1 + $category2;

        $this->render('new_article', array(
            'model'     => $model,
            'menus'     => $menus,
            'category'  => $category,
        ));
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