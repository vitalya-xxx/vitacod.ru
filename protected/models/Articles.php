<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property string $idArticle
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $photo
 * @property string $idUser
 * @property string $dateCreate
 * @property string $dateUpdate
 * @property integer $moderationAppruv
 * @property integer $public
 * @property integer $deleted
 * @property integer $idMenu
 * @property string $idCategory
 *
 * The followings are the available model relations:
 * @property Users $idUser0
 * @property Razdels $idMenu0
 * @property Categorys $idCategory0
 * @property Discussions[] $discussions
 */
class Articles extends CActiveRecord
{
    public $image;
    public $tagArray = null;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'articles';
	}

    public function primaryKey(){
        return 'idArticle';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('title, text, idUser, idMenu', 'required'),
            array('moderationAppruv, public, deleted, idMenu', 'numerical', 'integerOnly'=>true),
            array('title, photo', 'length', 'max'=>255),
            array('idUser, idCategory', 'length', 'max'=>10),
            array('description, dateCreate, dateUpdate, numberOfViews', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idArticle, title, description, text, photo, idUser, dateCreate, dateUpdate, moderationAppruv, public, deleted, idCategory, idMenu, numberOfViews', 'safe', 'on'=>'search'),
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
            'idUser0'           => array(self::BELONGS_TO, 'Users', 'idUser'),
            'idCategory0'       => array(self::BELONGS_TO, 'Categorys', 'idCategory'),
            'idMenu0'           => array(self::BELONGS_TO, 'Mainmenu', 'idMenu'),
            'bookmarks'         => array(self::HAS_MANY, 'Bookmarks', 'idArticle'),
            'comments'          => array(self::HAS_MANY, 'Comments', 'idArticle'),
            'discussions'       => array(self::HAS_MANY, 'Discussions', 'idArticle'),
            'tagstoarticles'    => array(self::HAS_MANY, 'TagsToArticles', 'idArticle',
                'with'=>'idTag0',
            ),
            'commentsCount'     => array(self::STAT, 'Comments', 'idArticle',
                'select'     => 'COUNT(*)',
                'condition'  => 'deleted = 0 AND public = 1',
            ),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idArticle'         => 'Id статьи',
			'title'             => 'Название',
			'description'       => 'Краткое описание',
			'text'              => 'Текст',
			'photo'             => 'Обложка',
			'idUser'            => 'Автор',
			'dateCreate'        => 'Написана',
			'dateUpdate'        => 'Обновлена',
			'moderationAppruv'  => 'Прошла модерацию',
			'public'            => 'Опубликованна',
			'deleted'           => 'Удалена',
			'idMenu'            => 'Раздел',
			'idCategory'        => 'Категория',
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
        $this->dateCreate = date('Y-m-d', strtotime($this->dateCreate));

        $criteria       = new CDbCriteria;
        $criteria->with = array('idCategory0','idMenu0','idUser0');

        if (!empty($this->dateCreate) && '1970-01-01' != $this->dateCreate) {
            $criteria->compare('dateCreate', $this->dateCreate, true);
        }

        $criteria->compare('idArticle',$this->idArticle,true);
        $criteria->compare('title',$this->title,true);
//        $criteria->compare('description',$this->description,true);
//        $criteria->compare('text',$this->text,true);
        $criteria->compare('photo',$this->photo,true);
        $criteria->compare('t.idUser',$this->idUser);
//        $criteria->compare('dateCreate',$this->dateCreate,true);
//        $criteria->compare('dateUpdate',$this->dateUpdate,true);
        $criteria->compare('moderationAppruv',$this->moderationAppruv);
        $criteria->compare('public',$this->public);
        $criteria->compare('deleted',$this->deleted);
        $criteria->compare('t.idCategory',$this->idCategory);
        $criteria->compare('t.idMenu',$this->idMenu);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Articles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * Полнотекстовый поиск
     * @param $termin
     * @return mixed
     */
    public function getListArticles($termin){
        $connection = Yii::app()->db1;

        $sql = "
            SELECT a.*, u.`login`, u.`email`,u.`lastFirstName`, c.`title` AS titleCategory, m.`title` AS titleMenu, COUNT(com.`idComment`) AS commentsCount
            FROM `articles` AS a
                INNER JOIN `searcharticles` AS sa
                    ON sa.`idArticle` = a.`idArticle`
                LEFT JOIN `users` AS u
                    ON u.`idUser` = a.`idUser`
                LEFT JOIN `categorys` AS c
                    ON c.`idCategory` = a.`idCategory`
                LEFT JOIN `mainmenu` AS m
                    ON m.`idMenu` = a.`idMenu`
                LEFT JOIN `comments` AS com
                    ON com.`idArticle` = sa.`idArticle`
                    AND com.`deleted` = 0 AND com.`public` = 1
            WHERE
                a.`moderationAppruv` = 1 AND a.`public` = 1 AND a.`deleted` = 0 AND
                MATCH(sa.`title`, sa.`description`, sa.`text`) AGAINST ('".$termin."' IN BOOLEAN MODE) > 0
                GROUP BY a.`idArticle`
                ORDER BY MATCH(sa.`title`, sa.`description`, sa.`text`) AGAINST ('".$termin."' IN BOOLEAN MODE) DESC
        ";

        $command    = $connection->createCommand($sql);
        $dataReader = $command->query();
        $rows       = $dataReader->readAll();

        return $rows;
    }

    /**
     * Возвращает случайные статьи
     * @param $limit
     * @return array|bool
     */
    public static function getRandomArticles($limit){
        $linksArray = array();
        $randomIds  = self::model()->findAll(array(
            'select'    =>'idArticle',
            'condition' => 'moderationAppruv = 1 AND public = 1 AND deleted = 0',
            'order'     => 'rand()',
            'limit'     => $limit,
        ));

        $idArray = array();
        foreach ($randomIds as $item) {
            $idArray[] = $item['idArticle'];
        }
        
        if (!empty($idArray)) {
            $in = join(',', $idArray);

            $result = self::model()->findAll(array(
                'select'    => 'idArticle, title, idMenu',
                'condition' => 'idArticle IN ('.$in.')',
            ));

            if (null === $result) {
                return false;
            }
            else {
                foreach ($result as $one) {
                    $linksArray[] = array('label'=>$one->title, 'url'=>array(
                        'articles/view_article',
                        'idArticle' => $one->idArticle,
                        'idMenu'    => $one->idMenu
                    ));
                }
            }
        }

        return $linksArray;
    }


    protected function afterFind() {
        if (!empty($this->dateCreate)) {
            $this->dateCreate = date('d.m.Y H:i', strtotime($this->dateCreate));
        }
        parent::afterFind();
    }


    protected function beforeSave() {
        if(parent::beforeSave()){
            $string     = !empty($this->description) ? $this->description : $this->text;
            $charset    = mb_detect_encoding($string);
            $strLength  = iconv_strlen($string, $charset);
            
            if (500 < $strLength) {
                $string = strip_tags($string);
                $string = substr($string, 0, 500);
                $string = rtrim($string, "!,.-");
                $string = substr($string, 0, strrpos($string, ' '));

                $this->description = $string."… ";
            }
            
            if($this->isNewRecord){
                $this->dateCreate = new CDbExpression('NOW()');
                if (Admins::model()->checkAccess(Yii::app()->user->role, Yii::app()->params['permission']['2'])) {
                    $this->moderationAppruv = 1;
                }
            }
            else {
                $this->dateCreate = date('Y-m-d H:i:s', strtotime($this->dateCreate));
                $this->dateUpdate = new CDbExpression('NOW()');
            }
            return true;
        }else{
            return false;
        }
    }
}
