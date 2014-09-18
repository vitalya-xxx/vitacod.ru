<?php

class DefaultController extends Controller
{
    public $_loginModel = null;
    public $_admin      = null;
    public $topMenu     = array();
    public $middleMenu  = array();


    protected function beforeAction()
    {
        $this->layout = 'base_page';

        if (!Yii::app()->user->isGuest) {
            $this->topMenu      = Mainmenu::getMenu('top', 'admin');
            $this->middleMenu   = Mainmenu::getMenu('middle', 'admin');
            $this->_admin       = Admins::model()->findByPk(Yii::app()->user->id, array('select' => 'login'));
            if (null === $this->_admin  || 'Users' == Yii::app()->session->get("typeAuthorize")) {
                $this->redirect(Yii::app()->homeUrl);
            }
        }
        return true;
    }


    /* Стартоая страница
     * Авторизация администратора
     *
     * */
    public function actionIndex()
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/list_razdels'));
        }

        $this->_loginModel = new LoginForm;

        if (isset($_POST['LoginForm']) && null !== $this->_loginModel) {
            if ($this->login()) {
                $this->redirect($this->createAbsoluteUrl('default/list_razdels'));
            }
        }

        $this->render('index');
    }


    public function login(){
        $this->_loginModel->attributes=$_POST['LoginForm'];
        // validate user input and redirect to the previous page if valid
        if($this->_loginModel->validate() && $this->_loginModel->login()) {
            return true;
        }
        else {
            return false;
        }
    }


    /* Разлогинивание администратра
     *
     *
     * */
    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }


    /* Управление разделами (меню сайта)
     * Список всех разделов
     *
     * */
    public function actionList_razdels(){
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $model = new Mainmenu('search');
        $model->unsetAttributes();

        if (isset($_GET['Mainmenu'])) {
            $model->setAttributes($_GET['Mainmenu'], false);
        }

        $this->render('razdels/list_razdels', array(
            'model' => $model,
        ));
    }


    /* Управление разделами (меню сайта)
     * Создать новое, редактровать старое.
     *
     * */
    public function actionSave_menu(){
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }
        if (isset($_POST['cancel'])) {
            $this->redirect($this->createAbsoluteUrl('default/list_razdels', $_GET));
        }

        if (isset($_GET['idMenu'])) {
            $model = Mainmenu::model()->findByPk($_GET['idMenu']);
        }
        else {
            $model = new Mainmenu;
        }

        if(isset($_POST['Mainmenu']))
        {
            $fileName = null;
            $oldFile  = $model->photo;

            // Генерим имя фото
            if ('' != $_FILES['Mainmenu']['name']['image']) {
                $fileName                   = AuxiliaryFunctions::getUniquNamePhoto($_FILES['Mainmenu']['name']['image']);
                $_POST['Mainmenu']['photo'] = $fileName;
                $oldFile                    = $model->photo;
            }

            $model->attributes=$_POST['Mainmenu'];
            if($model->validate())
            {
                if($model->save()){
                    if ($fileName) {
                        AuxiliaryFunctions::savePhoto($model, $fileName, $oldFile);
                    }
                    $this->redirect($this->createAbsoluteUrl('default/list_razdels', $_GET));
                }
            }
        }

        $links = CHtml::listData(Links::model()->findAll(), 'link', 'link');
        $this->render('razdels/save_menu', array(
            'model' => $model,
            'links' => $links,
        ));
    }
    
    public function actionList_links(){
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $model = new Links('search');
        $model->unsetAttributes();

        if (isset($_GET['Links'])) {
            $model->setAttributes($_GET['Links'], false);
        }

        $this->render('links/list_links', array(
            'model' => $model,
        ));
    }
    
    public function actionSave_link(){
        if (isset($_POST['cancel'])) {
            $this->redirect($this->createAbsoluteUrl('default/list_links', $_GET));
        }
        if (isset($_POST['delete'])) {
            $this->actionDelete_link();
            $this->redirect($this->createAbsoluteUrl('default/list_links', $_GET));
        }
        
        if (isset($_GET['link_id'])) {
            $model = Links::model()->findByPk($_GET['link_id']);
        }
        else {
            $model = new Links;
        }
        
        if (isset($_POST['Links'])) {
            $model->attributes = $_POST['Links'];

            if ($model->validate()) {	
                $model->save();
                $this->redirect($this->createAbsoluteUrl('default/list_links', $_GET));
            }
        }

        $this->render('links/save_link', array(
            'model' => $model,
        ));
    }
    
    public function actionDelete_link(){
        if (!empty($_GET['link_id'])) {
            Links::model()->deleteByPk($_GET['link_id']);
        }
    }


    /* Управление категориями
     * Список всех категорий
     *
     * */
    public function actionList_categorys(){
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $model = new Categorys('search');
        $model->unsetAttributes();

        if (isset($_GET['Categorys'])) {
            $model->setAttributes($_GET['Categorys'], false);
        }
        $menus = Mainmenu::model()->getDropDownMenu();
        $this->render('categorys/list_categorys', array(
            'model' => $model,
            'menus' => $menus,
        ));
    }


    /* Управление категориями
     * Создать новое, редактровать старое.
     *
     * */
    public function actionSave_category(){
        // Проверки на доступ к странице
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }
        if (isset($_POST['cancel'])) {
            $this->redirect($this->createAbsoluteUrl('default/list_categorys', $_GET));
        }

        // Редактирование или добавление новой
        if (isset($_GET['idCategory'])) {
            $model = Categorys::model()->findByPk($_GET['idCategory']);
        }
        else {
            $model=new Categorys;
        }

        if(isset($_POST['Categorys']))
        {
            $fileName = null;
            $oldFile  = $model->photo;
                
            // Генерим имя фото
            if (!empty($_FILES) && '' != $_FILES['Categorys']['name']['image']) {
                $fileName                       = AuxiliaryFunctions::getUniquNamePhoto($_FILES['Categorys']['name']['image']);
                $_POST['Categorys']['photo']    = $fileName;
                $oldFile                        = $model->photo;
            }

            $model->attributes=$_POST['Categorys'];
            if($model->validate())
            {
                if($model->save()){
                    if ($fileName) {
                        AuxiliaryFunctions::savePhoto($model, $fileName, $oldFile);
                    }
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array('result' => array(
                            'id'    => $model->idCategory,
                            'title' => $model->title,
                        )));
                        exit();
                    }
                    else {
                        $this->redirect($this->createAbsoluteUrl('default/list_categorys', $_GET));
                    }
                }
                else {
                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array('error' => 'save'));
                        exit();
                    }
                }
            }
            else {
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode(array('error' => 'validation'));
                    exit();
                }
            }
        }

        $menus = Mainmenu::model()->getDropDownMenu();

        if (isset($_POST['popup'])) {
            $popup = $this->renderPartial('categorys/save_category', array(
                'model' => $model,
                'menus' => $menus,
            ), true);

            echo CJSON::encode(array('popup' => $popup));
            exit();
        }
        else {
            $this->render('categorys/save_category', array(
                'model' => $model,
                'menus' => $menus,
            ));
        }
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

    /* Управление администраторами
     * Список всех админов
     *
     * */
    public function actionList_admins(){
        if (Yii::app()->user->isGuest || '7' != Yii::app()->user->role) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $model = new Admins('search');
        $model->unsetAttributes();

        if (isset($_GET['Admins'])) {
            $model->setAttributes($_GET['Admins'], false);
        }

        $this->render('admins/list_admins', array(
            'model' => $model,
        ));
    }


    /* Управление администраторами
     * Список всех админов
     *
     * */
    public function actionList_users(){
        if (Yii::app()->user->isGuest || !Admins::model()->checkAccess(Yii::app()->user->role, Yii::app()->params['permission']['3'])) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $model = new Users('search');
        $model->unsetAttributes();

        if (isset($_GET['Users'])) {
            $model->setAttributes($_GET['Users'], false);
        }

        $roles = CHtml::listData(Roles::model()->findAll(), 'idRole', 'description');

        $this->render('users/list_users', array(
            'model' => $model,
            'roles' => $roles,
        ));
    }


    /* Управление администраторами
     * Добавить/редактировать админа.
     *
     * */
    public function actionSave_admin(){
        if (Yii::app()->user->isGuest || '7' != Yii::app()->user->role) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        if (isset($_GET['idAdmin'])) {
            $model = Admins::model()->findByPk($_GET['idAdmin']);
        }
        else {
            $model = new Admins;
        }

        if(isset($_POST['Admins']))
        {
            $model->attributes=$_POST['Admins'];
            if($model->validate())
            {
                if($model->save()){
                    $this->redirect($this->createAbsoluteUrl('default/list_admins', $_GET));
                }
            }
        }
        $this->render('admins/save_admin', array('model'=>$model));
    }

    /* Управление пользователями
     * Редактировать пользователя.
     *
     * */
    public function actionSave_user(){
        if (Yii::app()->user->isGuest || !Admins::model()->checkAccess(Yii::app()->user->role, Yii::app()->params['permission']['3'])) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }
        if (isset($_POST['cancel'])) {
            $this->redirect($this->createAbsoluteUrl('default/list_users', $_GET));
        }
        if (isset($_POST['delete'])) {
            $this->actionDelete_article();
            $this->redirect($this->createAbsoluteUrl('default/list_users', $_GET));
        }

        if (isset($_GET['idUser'])) {
            $model = Users::model()->findByPk($_GET['idUser']);
            $model->scenario = 'update';
        }
        else {
            $model = new Users('update');
        }

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->validate()) {
                if ($model->save()) {
                    $this->redirect($this->createAbsoluteUrl('default/list_users', $_GET));
                }
//                $model->update(array('idRole'=>$model->idRole, 'ban'=>$model->ban));
            }
        }

        $allRoles = Roles::model()->findAll(array(
            'condition' => 'idRole != :idRole',
            'params'    => array(
                ':idRole' => ('7' != Yii::app()->user->role) ? '7' : '',
            ),
        ));

        $roles = CHtml::listData($allRoles, 'idRole', 'description');

        $this->render('users/save_user', array(
            'model' => $model,
            'roles' => $roles,
        ));
    }

    /**
     * Список сообщений в чате
     */
    public function actionList_chat_msg(){
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $settingChat = Settings::model()->findByAttributes(array('parameter'=>Yii::app()->params['parameter']['chat']));

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['action'])) {
                // Скрыть - открыть - удалить сообщения из чата
                if ('hide' == $_POST['action'] || 'delete' == $_POST['action']) {
                    if (isset($_POST['msgIds']) && !empty($_POST['msgIds'])) {
                        switch ($_POST['action']) {
                            case 'hide' :
                                $modifiedMsg = array();
                                foreach ($_POST['msgIds'] as $one) {
                                    $msgModel = Chat::model()->findByPk((int)$one);

                                    if (null != $msgModel) {
                                        $val                = $msgModel->active ? 0 : 1 ;
                                        $msgModel->active   = $val;

                                        if ($msgModel->update(array('active'))) {
                                            $modifiedMsg[] = $msgModel->idChat;
                                        }
                                    }
                                }
                                echo CJSON::encode(array('modifiedMsg' => $modifiedMsg));
                                exit();
                                break;

                            case 'delete' :
                                $deletedMsg = array();
                                foreach ($_POST['msgIds'] as $one) {
                                    $this->deleteChatMsg((int)$one);
                                    $deletedMsg[] = (int)$one;
                                }
                                echo CJSON::encode(array('deletedMsg' => $deletedMsg));
                                exit();
                                break;
                        }
                    }
                }
                else { // Включить - отключить чат
                    if ($settingChat) {
                        $setModel = $settingChat;
                    }
                    else {
                        $setModel = new Settings();
                        $setModel->parameter = Yii::app()->params['parameter']['chat'];
                    }

                    if ('on' == $_POST['action']) {
                        $setModel->value = 1;
                    }
                    elseif ('off' == $_POST['action']) {
                        $setModel->value = 0;
                    }
                    if ($setModel->save()) {
                        echo CJSON::encode(array('result' => $setModel->value));
                        exit();
                    }
                }

            }
        }

        $model = new Chat('search');
        $model->unsetAttributes();

        if (isset($_GET['Chat'])) {
            $model->setAttributes($_GET['Chat'], false);
            $model->login           = isset($_GET['Chat']['login']) ? $_GET['Chat']['login'] : '';
            $model->lastFirstName   = isset($_GET['Chat']['lastFirstName']) ? $_GET['Chat']['lastFirstName'] : '';
        }

        $this->render('chat/list_chat_msg', array(
            'model'     => $model,
            'stateChat' => (null != $settingChat) ? (int)$settingChat->value : 0,
        ));
    }

    public function actionDeleteMsg(){
        if (isset($_GET['idChat'])) {
            $this->deleteChatMsg((int)$_GET['idChat']);
        }
    }

    public function deleteChatMsg($idChat){
        Chat::model()->deleteByPk($idChat);
    }

    /* Управление статьями
     * Список всех статей
     *
     * */
    public function actionList_articles(){
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }

        $model = new Articles('search');
        $model->unsetAttributes();

        if (isset($_GET['Articles'])) {
            $model->setAttributes($_GET['Articles'], false);
        }

        $category   = Categorys::getAllCategories();
        $menus      = Mainmenu::model()->getDropDownMenu();

        $this->render('articles/list_articles', array(
            'model'     => $model,
            'menus'     => $menus,
            'category'  => $category,
        ));
    }


    /* Управление статьями
     * Создать новое, редактровать статью.
     *
     * */
    public function actionSave_article(){
        $idArticle = null;

        // Проверки на доступ к странице
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createAbsoluteUrl('default/index'));
        }
        if (isset($_POST['cancel'])) {
            $this->redirect($this->createAbsoluteUrl('default/list_articles', $_GET));
        }
        if (isset($_POST['delete'])) {
            $this->actionDelete_article();
            $this->redirect($this->createAbsoluteUrl('default/list_articles', $_GET));
        }

        // Автокомплитер тегов
        if (isset($_GET['q'])) {
            $lastTag = end(explode(",", $_GET['q']));

            $criteria               = new CDbCriteria;
            $criteria->condition    = 'textTag LIKE :tag';
            $criteria->params       = array(':tag' => '%'.trim(htmlspecialchars($lastTag)).'%');

            if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
                $criteria->limit = $_GET['limit'];
            }

            $tags = Tags::model()->findAll($criteria);

            if ($tags) {
                $resStr = '';
                foreach ($tags as $tag) {
                    $resStr .= $tag->textTag."\n";
                }
                echo $resStr;
            }
            exit;
        }

        // Редактирование или добавление новой
        if (isset($_GET['idArticle'])) {
            $idArticle          = $_GET['idArticle'];
            $model              = Articles::model()->findByPk($_GET['idArticle']);
            $model['tagArray']  = AuxiliaryFunctions::getTagsList($model->tagstoarticles, false);
        }
        else {
            $model = new Articles('create');
        }

        // Нажата кнопка "Редактировать" или "Добавить"
        if(isset($_POST['Articles']))
        {
            $oldFile    = null;
            $oldFile    = $model->photo;
            $fileName   = null;

            // Генерим имя фото
            if ('' != $_FILES['Articles']['name']['image']) {
                $fileName                   = AuxiliaryFunctions::getUniquNamePhoto($_FILES['Articles']['name']['image']);
                $_POST['Articles']['photo'] = $fileName;
                $oldFile                    = $model->photo;
            }

            $model->attributes = $_POST['Articles'];

            if (empty($model->idUser)) {
                $model->idUser = Users::getIdUserForAdmin();
            }

            if($model->validate())
            {
                if($model->save()){
                    $idArticle = $model->idArticle;

                    if ($fileName) {
                        AuxiliaryFunctions::savePhoto($model, $fileName, $oldFile);
                    }

                    // Теги для статьи
                    if (isset($_POST['textTag'])) {
                        $tagsArray  = explode(",", $_POST['textTag']);
                        $idArray    = array();

                        foreach ($tagsArray as $item) {
                            $tagId  = null;
                            if (!empty($item)) {
                                $item = trim(htmlspecialchars($item));
                            }
                            else {
                                continue;
                            }

                            $tagResult = Tags::model()->findByAttributes(array('textTag' => $item));
                            if (null === $tagResult) {
                                $newTag             = new Tags();
                                $newTag->textTag    = $item;
                                if ($newTag->save()) {
                                    $tagId = $newTag->idTag;
                                }
                            }
                            else {
                                $tagId = $tagResult->idTag;
                            }
                            $idArray[] = $tagId;
                        }

                        if ($idArray) {
                            foreach ($idArray as $item) {
                                $item       = (int)$item;
                                $idArticle  = (int)$idArticle;

                                if (!TagsToArticles::model()->exists('idArticle = :idArticle AND idTag = :idTag', array(':idArticle' => $idArticle, ':idTag' => $item))) {
                                    $newTags2Art            = new TagsToArticles();
                                    $newTags2Art->idArticle = $idArticle;
                                    $newTags2Art->idTag     = (int)$item;
                                    $newTags2Art->save();
                                }
                            }
                        }

                    }
                    $this->redirect($this->createAbsoluteUrl('default/list_articles', $_GET));
                }
            }
        }

        $menus      = Mainmenu::model()->getDropDownMenu();
        $idMenu     = (!empty($model->idMenu) ? $model->idMenu : key($menus));

        $category1  = array('' => 'Без категории');
        $category2  = Categorys::getAllCategories($idMenu);
        $category   = $category1 + $category2;

        $tags = new Tags();

        $this->render('//articles/save_article', array(
            'model'     => $model,
            'menus'     => $menus,
            'category'  => $category,
            'tags'      => $tags,
        ));
    }

    /**
     * Удаление модели (для всех)
     * @param $model
     * @param $idRow
     */
    public function deleteRowModel($model, $idRow){
        if (isset($idRow)) {
            $classModel = new $model();
            $classModel->deleteByPk($idRow);
            $dirName = 'uploads/'.strtolower($model).'/'.$idRow;
            $this->removeDirectory($dirName);
        }
    }

    /**
     * Вспомогательная - удаляет каталог с файлами
     * @param $dir
     */
    public function removeDirectory($dir) {
        if (is_dir($dir)) {
            if ($objs = glob($dir."/*")) {
                foreach($objs as $obj) {
                    is_dir($obj) ? removeDirectory($obj) : unlink($obj);
                }
            }
            rmdir($dir);
        }
    }

    // УДАЛЕНИЕ
    /* Управление пользователями
     * Удаление пользователя
     *
     * */
    public function actionDelete_user(){
        if (isset($_GET['idUser'])) {
            $this->deleteRowModel('Users', $_GET['idUser']);
            $this->redirect($this->createAbsoluteUrl('default/list_users', $_GET));
        }
    }
    /* Управление категориями
     * Удаление категории
     *
     * */
    public function actionDelete_category(){
        if (isset($_GET['idCategory'])) {
            $this->deleteRowModel('Categorys', $_GET['idCategory']);
            $this->redirect($this->createAbsoluteUrl('default/list_categorys', $_GET));
        }
    }
    /* Управление администраторами
     * Удаление адимна
     *
     * */
    public function actionDelete_admin(){
        if (isset($_GET['idAdmin'])) {
            Admins::model()->deleteByPk($_GET['idAdmin']);
            $this->redirect($this->createAbsoluteUrl('default/list_admins', $_GET));
        }
    }
    /* Управление разделами (меню сайта)
     * Удаление раздела
     *
     * */
    public function actionDelete_razdel(){
        if (isset($_GET['idMenu'])) {
            $this->deleteRowModel('Mainmenu', $_GET['idMenu']);
            $this->redirect($this->createAbsoluteUrl('default/list_razdels', $_GET));
        }
    }
    /* Управление статьями
     * Удаление статьи
     *
     * */
    public function actionDelete_article(){
        if (isset($_GET['idArticle'])) {
            $this->deleteRowModel('Articles', $_GET['idArticle']);
            $this->redirect($this->createAbsoluteUrl('default/list_articles', $_GET));
        }
    }

    /**
     *
     */
    public function actionPopups(){
        if (isset($_POST['popup'])) {
            $popup = '';
            switch($_POST['popup']) {
                case 'newCategory':
                    $model = new Categorys();
                    $menus = Mainmenu::model()->getDropDownMenu();
                    $popup = $this->renderPartial('categorys/save_category', array(
                        'model' => $model,
                        'menus' => $menus,
                    ), true);
                    break;
            }

            echo CJSON::encode(array('popup' => $popup));
            exit();
        }
    }
}