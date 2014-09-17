<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $idUser
 * @property string $login
 * @property string $email
 * @property string $password
 * @property integer $idRole
 * @property string $photo
 * @property string $lastFirstName
 * @property integer $ban
 *
 * The followings are the available model relations:
 * @property Ansvers[] $ansvers
 * @property Articles[] $articles
 * @property Chat[] $chats
 * @property Dialogs[] $dialogs
 * @property Roles $idRole0
 */
class Users extends CActiveRecord
{
    const ROLE_ADMIN    = 'administrator';
    const ROLE_MODER    = 'moderator';
    const ROLE_USER     = 'user';
    const ROLE_BANNED   = 'banned';

    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, email, password, idRole', 'required', 'on'=>'create'),
			array('idRole, ban', 'required', 'on'=>'update'),
			array('idRole', 'numerical', 'integerOnly'=>true),
			array('login, email, photo, lastFirstName, hash', 'length', 'max'=>255),
			array('password', 'length', 'max'=>32),
            array('email', 'email', 'on'=>'create, edit'),
            array('email, login', 'unique', 'on'=>'create, edit'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idUser, login, email, password, idRole, photo, lastFirstName, ban', 'safe', 'on'=>'search'),
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
			'ansvers' => array(self::HAS_MANY, 'Ansvers', 'idUser'),
			'articles' => array(self::HAS_MANY, 'Articles', 'idUser'),
			'chats' => array(self::HAS_MANY, 'Chat', 'idUser'),
			'dialogs' => array(self::HAS_MANY, 'Dialogs', 'idUser'),
			'idRole0' => array(self::BELONGS_TO, 'Roles', 'idRole'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idUser'        => 'Id пользователя',
			'login'         => 'Логин',
			'email'         => 'Email',
			'password'      => 'Пароль',
			'idRole'        => 'Роль',
			'photo'         => 'Фото',
			'lastFirstName' => 'ФИО',
			'ban'           => 'Бан',
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
		$criteria=new CDbCriteria;
        $criteria->with = 'idRole0';

		$criteria->compare('idUser',$this->idUser,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('t.idRole',$this->idRole);
		$criteria->compare('lastFirstName',$this->lastFirstName,true);
		$criteria->compare('ban',$this->ban);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * @return integer $idUser
     */
    public static function getIdUserForAdmin(){
        $hash       = md5(Yii::app()->user->id.Yii::app()->user->login.Yii::app()->user->role);
        $attributes = array(
            'login'         => Yii::app()->user->login,
            'idRole'        => 1,
            'hash'          => $hash,
            'lastFirstName' => 'Админ',
        );

        $model  = self::model()->findByAttributes($attributes);

        if (null === $model) {
            $model = new Users();
            $model->attributes = $attributes;
            $model->save(false);
        }
        return $model->idUser;
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
