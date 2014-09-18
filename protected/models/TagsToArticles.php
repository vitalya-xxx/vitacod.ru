<?php

/**
 * This is the model class for table "tags2articles".
 *
 * The followings are the available columns in table 'tags2articles':
 * @property string $idTags2Art
 * @property string $idArticle
 * @property string $idTag
 *
 * The followings are the available model relations:
 * @property Tags $idTag0
 * @property Articles $idArticle0
 */
class TagsToArticles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tagstoarticles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idArticle, idTag', 'required'),
			array('idArticle, idTag', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idTags2Art, idArticle, idTag', 'safe', 'on'=>'search'),
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
			'idTag0' => array(self::BELONGS_TO, 'Tags', 'idTag'),
			'idArticle0' => array(self::BELONGS_TO, 'Articles', 'idArticle'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTags2Art' => 'Id Tags2 Art',
			'idArticle' => 'Id Article',
			'idTag' => 'Id Tag',
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

		$criteria->compare('idTags2Art',$this->idTags2Art,true);
		$criteria->compare('idArticle',$this->idArticle,true);
		$criteria->compare('idTag',$this->idTag,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tags2articles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
