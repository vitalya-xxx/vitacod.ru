<?php

/**
 * This is the model class for table "questions".
 *
 * The followings are the available columns in table 'questions':
 * @property string $idQuestion
 * @property string $title
 * @property string $text
 * @property string $idUser
 * @property string $nameUser
 * @property string $idThem
 *
 * The followings are the available model relations:
 * @property Ansvers[] $ansvers
 * @property Thems $idThem0
 */
class Questions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idUser, idThem', 'required'),
			array('title, nameUser', 'length', 'max'=>255),
			array('idUser, idThem', 'length', 'max'=>10),
			array('text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idQuestion, title, text, idUser, nameUser, idThem', 'safe', 'on'=>'search'),
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
			'ansvers' => array(self::HAS_MANY, 'Ansvers', 'idQuestion'),
			'idThem0' => array(self::BELONGS_TO, 'Thems', 'idThem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idQuestion' => 'Id Question',
			'title' => 'Title',
			'text' => 'Text',
			'idUser' => 'Id User',
			'nameUser' => 'Name User',
			'idThem' => 'Id Them',
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

		$criteria->compare('idQuestion',$this->idQuestion,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('idUser',$this->idUser,true);
		$criteria->compare('nameUser',$this->nameUser,true);
		$criteria->compare('idThem',$this->idThem,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Questions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
