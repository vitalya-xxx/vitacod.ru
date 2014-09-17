<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 25.10.13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */

class WebUser extends CWebUser {
    private $_model = null;

    function getRole() {
        if($user = $this->getModel()){
            if ('Users' == Yii::app()->session->get("typeAuthorize")) {
                return $user->idRole;
            }
            else if ('Admins' == Yii::app()->session->get("typeAuthorize")) {
                return $user->role;
            }
        }
    }
    function getLogin() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->login;
        }
    }

    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            if ('Users' == Yii::app()->session->get("typeAuthorize")) {
                $this->_model = Users::model()->findByPk($this->id, array('select' => 'login, idRole'));
            }
            else if ('Admins' == Yii::app()->session->get("typeAuthorize")) {
                $this->_model = Admins::model()->findByPk($this->id, array('select' => 'login, role'));
            }
        }
        return $this->_model;
    }
}