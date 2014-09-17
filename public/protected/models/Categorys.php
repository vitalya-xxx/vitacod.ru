<?php

/**
 * This is the model class for table "categorys".
 *
 * The followings are the available columns in table 'categorys':
 * @property string $idCategory
 * @property string $title
 * @property string $description
 * @property string $photo
 * @property integer $idMenu
 *
 * The followings are the available model relations:
 * @property Articles[] $articles
 * @property Mainmenu $idMenu0
 */
class Categorys extends CActiveRecord
{
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categorys';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, idMenu', 'required'),
            array('idMenu', 'numerical', 'integerOnly'=>true),
            array('title, photo', 'length', 'max'=>255),
            array('description, active', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idCategory, title, description, photo, idMenu, active', 'safe', 'on'=>'search'),
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
			'articles'      => array(self::HAS_MANY, 'Articles', 'idCategory'),
            'idMenu0'       => array(self::BELONGS_TO, 'Mainmenu', 'idMenu'),
            'articlesCount' => array(self::STAT, 'Articles', 'idCategory',
                'select'        => 'COUNT(*)',
                'condition'     => 'moderationAppruv = 1 AND public = 1 AND deleted = 0',
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idCategory'    => 'Id Category',
            'idMenu'        => 'Раздел меню',
			'title'         => 'Название',
			'description'   => 'Описание',
			'photo'         => 'Фото',
            'active'        => 'Видимость',
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
        $criteria->with = 'idMenu0';

		$criteria->compare('idCategory',$this->idCategory,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('photo',$this->photo,true);
        $criteria->compare('t.idMenu',$this->idMenu);
        $criteria->compare('active',$this->active);


        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categorys the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    // Возвращает массив категорий раздела или все.
    public static function getAllCategories($idMenu = null, $active = false, $asLinks = false){
        $criteria               = new CDbCriteria;
        $criteria->with         = array('articlesCount');
        $criteria->condition    = '';

        if ($idMenu) {
            $criteria->condition = 'idMenu = :idMenu';
            $criteria->params = array(
                ':idMenu' => $idMenu,
            );
        }

        if ($active) {
            $criteria->addCondition('active = 1');
        }

        $result = self::model()->findAll($criteria);

        if (null === $result) {
            return false;
        }
        else {
            $resultArray  = array();

            if ($asLinks) {
                $linksArray = array();

                foreach ($result as $one) {
                    $one->title = $one->title.' ('.$one->articlesCount.')';
                    $linksArray[] = array('label'=>$one->title, 'url'=>array(
                        'articles/list_articles',
                        'listType'      => 'category',
                        'idMenu'        => $one->idMenu,
                        'idCategory'    => $one->idCategory,
                    ));
                }
                $resultArray = $linksArray;
            }
            else {
                foreach ($result as $one) {
                    $resultArray[$one->idCategory] = ($one->active) ? $one->title : $one->title.' (Не активна)';
                }
            }
            return $resultArray;
        }
    }
}
