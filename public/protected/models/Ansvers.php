<?php

/**
 * This is the model class for table "ansvers".
 *
 * The followings are the available columns in table 'ansvers':
 * @property string $idAnsver
 * @property string $idQuestion
 * @property string $text
 * @property string $idUser
 * @property string $nameUser
 *
 * The followings are the available model relations:
 * @property Questions $idQuestion0
 * @property Users $idUser0
 */
class Ansvers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ansvers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idQuestion, text', 'required'),
			array('idQuestion, idUser', 'length', 'max'=>10),
			array('nameUser', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idAnsver, idQuestion, text, idUser, nameUser', 'safe', 'on'=>'search'),
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
			'idQuestion0' => array(self::BELONGS_TO, 'Questions', 'idQuestion'),
			'idUser0' => array(self::BELONGS_TO, 'Users', 'idUser'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idAnsver' => 'Id Ansver',
			'idQuestion' => 'Id Question',
			'text' => 'Text',
			'idUser' => 'Id User',
			'nameUser' => 'Name User',
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

		$criteria->compare('idAnsver',$this->idAnsver,true);
		$criteria->compare('idQuestion',$this->idQuestion,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('idUser',$this->idUser,true);
		$criteria->compare('nameUser',$this->nameUser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ansvers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
