<?php

/**
 * This is the model class for table "mainmenu".
 *
 * The followings are the available columns in table 'mainmenu':
 * @property integer $idMenu
 * @property string $title
 * @property integer $position
 * @property string $type
 * @property string $link
 * @property string $partSite
 * @property integer $visible
 *
 * The followings are the available model relations:
 * @property Articles[] $articles
 * @property Categorys[] $categorys
 */
class Mainmenu extends CActiveRecord
{
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mainmenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, position, type, partSite, mayBeCat', 'required'),
			array('position, visible', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('type', 'length', 'max'=>6),
			array('link, photo', 'length', 'max'=>255),
			array('partSite', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idMenu, title, position, type, link, partSite, visible, mayBeCat', 'safe', 'on'=>'search'),
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
            'articles'      => array(self::HAS_MANY, 'Articles', 'idMenu'),
            'bookmarks'     => array(self::HAS_MANY, 'Bookmarks', 'idMenu'),
            'categorys'     => array(self::HAS_MANY, 'Categorys', 'idMenu'),
            'articlesMenuCount' => array(self::STAT, 'Articles', 'idMenu',
                'select'        => 'COUNT(*)',
                'condition'     => 'moderationAppruv = 1 AND public = 1 AND deleted = 0',
            ),
            'categoryCount' => array(self::STAT, 'Categorys', 'idMenu',
                'select'        => 'COUNT(*)',
                'condition'     => 'active = 1',
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idMenu'    => 'Id Menu',
			'title'     => 'Название',
			'position'  => 'Позиция',
			'type'      => 'Тип',
			'link'      => 'Ссылка',
			'partSite'  => 'Часть сайта',
			'visible'   => 'Видимость',
            'mayBeCat'  => 'Категории',
            'photo'     => 'Обложка',
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

		$criteria->compare('idMenu',$this->idMenu);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('partSite',$this->partSite,true);
		$criteria->compare('visible',$this->visible);
        $criteria->compare('mayBeCat',$this->mayBeCat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mainmenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    // Возвращает массив основного меню.
    public static function getMenu($typeMenu, $partSite){
        $criteria = new CDbCriteria;

        $criteria->condition    = 'type = :type AND partSite = :partSite AND visible = 1';
        $criteria->params       = array(
            ':type'     => $typeMenu,
            ':partSite' => $partSite
        );
        $criteria->order = 'position ASC';

        $result         = self::model()->findAll($criteria);
        $menuArray      = array();
        $closedLinks    = Yii::app()->params['accessDeniedPage'][!empty(Yii::app()->user->role) ? Yii::app()->user->role : 'guest'];

        foreach ($result as $one) {
            if (!empty($closedLinks) && in_array($one->link, $closedLinks)) {
                continue;
            }
            else {
                $menuArray[] = array('label'=>$one->title, 'url'=>array($one->link, 'listType' => 'razdel', 'idMenu'=>$one->idMenu), array('class'=>'middleMenu'));
            }
        }

        return $menuArray;
    }

    // Меню для выпадающих списков (для добавления статей в категорию)
    public function getDropDownMenu(){
        $criteria               = new CDbCriteria;
        $criteria->condition    = 'visible = 1 AND mayBeCat = 1 AND partSite = "site"';
        $result                 = self::model()->findAll($criteria);
        return CHtml::listData($result, 'idMenu', 'title');
    }
}
