<?php

/**
 * This is the model class for table "discussions".
 *
 * The followings are the available columns in table 'discussions':
 * @property string $idDiscussion
 * @property string $idArticle
 *
 * The followings are the available model relations:
 * @property Dialogs[] $dialogs
 * @property Articles $idArticle0
 */
class Discussions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'discussions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idArticle', 'required'),
			array('idArticle', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idDiscussion, idArticle', 'safe', 'on'=>'search'),
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
			'dialogs' => array(self::HAS_MANY, 'Dialogs', 'idDiscussion'),
			'idArticle0' => array(self::BELONGS_TO, 'Articles', 'idArticle'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idDiscussion' => 'Id Discussion',
			'idArticle' => 'Id Article',
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

		$criteria->compare('idDiscussion',$this->idDiscussion,true);
		$criteria->compare('idArticle',$this->idArticle,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Discussions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
