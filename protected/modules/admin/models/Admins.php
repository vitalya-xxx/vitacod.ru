<?php

/**
 * This is the model class for table "admins".
 *
 * The followings are the available columns in table 'admins':
 * @property string $idAdmin
 * @property string $login
 * @property string $password
 * @property string $role
 */
class Admins extends CActiveRecord
{
    const ROLE_SUPER_ADMIN  = '7';
    const ROLE_ADMIN        = '5';
    const ROLE_MODER        = '4';
    const ROLE_AUTHOR       = '3';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admins';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password', 'required'),
			array('login', 'length', 'max'=>255),
			array('password', 'length', 'max'=>32),
			array('role', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idAdmin, login, password, role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idAdmin'   => 'Id Admin',
			'login'     => 'Логин',
			'password'  => 'Пароль',
			'role'      => 'Роль',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idAdmin',$this->idAdmin,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Admins the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @param $userRole
     * @param $permission
     * @return bool
     */
    public function checkAccess($userRole, $permission){
        $roles = array();

        switch ($permission) {
            case Yii::app()->params['permission']['1'] :
                $roles = array(self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_MODER, self::ROLE_AUTHOR);
                break;
            case Yii::app()->params['permission']['2'] :
                $roles = array(self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_MODER);
                break;
            case Yii::app()->params['permission']['3'] :
                $roles = array(self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN);
                break;
        }

        if (in_array($userRole, $roles)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function beforeSave(){
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->password = md5($this->password);
            }
            return true;
        }else{
            return false;
        }
    }
}
