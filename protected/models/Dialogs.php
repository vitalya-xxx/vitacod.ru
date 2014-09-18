<?php

/**
 * This is the model class for table "dialogs".
 *
 * The followings are the available columns in table 'dialogs':
 * @property string $idDialog
 * @property string $idDiscussion
 * @property string $idUser
 * @property string $nameUser
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Discussions $idDiscussion0
 * @property Users $idUser0
 */
class Dialogs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dialogs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idDiscussion, idUser, nameUser', 'required'),
			array('idDiscussion, idUser', 'length', 'max'=>10),
			array('nameUser', 'length', 'max'=>255),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idDialog, idDiscussion, idUser, nameUser, date', 'safe', 'on'=>'search'),
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
			'idDiscussion0' => array(self::BELONGS_TO, 'Discussions', 'idDiscussion'),
			'idUser0' => array(self::BELONGS_TO, 'Users', 'idUser'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idDialog' => 'Id Dialog',
			'idDiscussion' => 'Id Discussion',
			'idUser' => 'Id User',
			'nameUser' => 'Name User',
			'date' => 'Date',
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

		$criteria->compare('idDialog',$this->idDialog,true);
		$criteria->compare('idDiscussion',$this->idDiscussion,true);
		$criteria->compare('idUser',$this->idUser,true);
		$criteria->compare('nameUser',$this->nameUser,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dialogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
