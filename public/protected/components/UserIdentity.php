<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    // Будем хранить id.
    protected $_id;
    public $controller;

    public function __construct($username,$password,$controller)
    {
        parent::__construct($username,$password);
        $this->controller = $controller;
        return true;
    }

    // Данный метод вызывается один раз при аутентификации пользователя.
    public function authenticate(){
        $id         = null;
        $controller = null;

        switch ($this->controller) {
            case 'default' :
                $id         = 'idAdmin';
                $controller = 'Admins';
                break;
            case 'base' :
                $id         = 'idUser';
                $controller = 'Users';
                break;
        }
        // Производим стандартную аутентификацию, описанную в руководстве.
        $classModel     = new $controller();
        $user           = $classModel->find('LOWER(login)=?', array(strtolower($this->username)));

        if(($user===null) || (md5($this->password)!==$user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            // В качестве идентификатора будем использовать id, а не username,
            // как это определено по умолчанию. Обязательно нужно переопределить
            // метод getId(см. ниже).
            $this->_id = $user->$id;
            Yii::app()->session->add("typeAuthorize", $controller);
            // Далее логин нам не понадобится, зато имя может пригодится
            // в самом приложении. Используется как Yii::app()->user->name.
            // realName есть в нашей модели. У вас это может быть name, firstName
            // или что-либо ещё.
//            $this->username = $user->realName;

            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }
}