<?php

/**
 * This is the model class for table "chat".
 *
 * The followings are the available columns in table 'chat':
 * @property string $idChat
 * @property string $text
 * @property string $idUser
 * @property string $nameUser
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Users $idUser0
 */
class Chat extends CActiveRecord
{
    public $login;
    public $lastFirstName;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			array('text, nameUser', 'length', 'max'=>255),
			array('idUser', 'length', 'max'=>10),
			array('date, active', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idChat, text, idUser, nameUser, date, active', 'safe', 'on'=>'search'),
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
			'idUser0' => array(self::BELONGS_TO, 'Users', 'idUser'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idChat'    => 'ID',
			'text'      => 'Текст',
			'idUser'    => 'Id Пользователя',
			'nameUser'  => 'Name User',
			'date'      => 'Дата',
			'active'    => 'Видимость',
			'login'     => 'Логин',
			'lastFirstName'  => 'Ф.И.О.',
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
		$criteria       = new CDbCriteria;
        $criteria->with = 'idUser0';

        if (!empty($this->date)) {
            $this->date = strtotime($this->date);
            $rest       = substr($this->date, 0, 5);
            $criteria->compare('t.date', $rest, true);
        }

		$criteria->compare('t.idChat',$this->idChat);
		$criteria->compare('t.text',$this->text,true);
		$criteria->compare('t.idUser',$this->idUser);
		$criteria->compare('t.active',$this->active);
        $criteria->compare('idUser0.login', $this->login, true);
        $criteria->compare('idUser0.lastFirstName', $this->lastFirstName, true);

        $sort               = new CSort();
        $sort->defaultOrder = 't.date DESC';
        $sort->attributes   = array(
            'login' => array(
                'ASC'   => 'idUser0.login',
                'DESC'  => 'idUser0.login DESC',
            ),
            'lastFirstName' => array(
                'ASC'   => 'idUser0.lastFirstName',
                'DESC'  => 'idUser0.lastFirstName DESC',
            ),
            '*',
        );

		return new CActiveDataProvider($this, array(
			'criteria'      => $criteria,
            'sort'          => $sort,
            'pagination'    => array('pageSize' => 50),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave() {
        if(parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->date = time();
            }
            return true;
        } else {
            return false;
        }
    }

    protected function afterFind() {
        $this->date = date('d.m.Y H:i', $this->date);
        parent::afterFind();
    }

    /**
     * Все сообщения чата
     * @param bool $active
     * @return array|CActiveRecord|mixed|null
     */
    public static function getListChat($active = true){
        $criteria       = new CDbCriteria();
        $criteria->with = array('idUser0');

        if ($active) {
            $criteria->condition = 'active = 1';
        }

        $result             = self::model()->findAll($criteria);
        $chatDataProvider   = new CArrayDataProvider($result, array(
            'keyField'      => 'idChat',
            'sort'          => array('defaultOrder' => 'idChat DESC'),
            'pagination'    => array(
                'pageSize'  => 20,
            ),
        ));

        return $chatDataProvider;
    }

    /**
     * Возвращает ID последнего сообщения
     * @return mixed
     */
    public static function getLastId(){
        $lastId = Yii::app()->db->createCommand('SELECT idChat FROM chat ORDER BY idChat DESC LIMIT 1')->queryScalar();
        return $lastId;
    }
}
