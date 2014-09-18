<?php

/**
 * This is the model class for table "bookmarks".
 *
 * The followings are the available columns in table 'bookmarks':
 * @property string $idBookmarks
 * @property string $idUser
 * @property string $idArticle
 * @property integer $idMenu
 * @property string $idCategory
 *
 * The followings are the available model relations:
 * @property Users $idUser0
 * @property Articles $idArticle0
 * @property Mainmenu $idMenu0
 * @property Categorys $idCategory0
 */
class Bookmarks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bookmarks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idUser, idArticle, idMenu', 'required'),
			array('idMenu', 'numerical', 'integerOnly'=>true),
			array('idUser, idArticle, idCategory', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('idBookmarks, idUser, idArticle, idMenu, idCategory', 'safe', 'on'=>'search'),
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
			'idArticle0' => array(self::BELONGS_TO, 'Articles', 'idArticle'),
			'idMenu0' => array(self::BELONGS_TO, 'Mainmenu', 'idMenu'),
			'idCategory0' => array(self::BELONGS_TO, 'Categorys', 'idCategory'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idBookmarks' => 'Id Bookmarks',
			'idUser' => 'Id User',
			'idArticle' => 'Id Article',
			'idMenu' => 'Id Menu',
			'idCategory' => 'Id Category',
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

		$criteria->compare('idBookmarks',$this->idBookmarks,true);
		$criteria->compare('idUser',$this->idUser,true);
		$criteria->compare('idArticle',$this->idArticle,true);
		$criteria->compare('idMenu',$this->idMenu);
		$criteria->compare('idCategory',$this->idCategory,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bookmarks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * Возвращает массив закладок
     * @param $idUser
     * @return mixed
     */
    public function getUserBookmarks($idUser){
        $connection = Yii::app()->db1;

        $sql = "
            SELECT m.*, COUNT(a.`idArticle`) AS countArticleInMenu
                FROM mainmenu AS m
                    INNER JOIN bookmarks AS b
                        ON b.idUser = ".$idUser."
                    LEFT JOIN articles AS a
                        ON a.`idArticle` = b.`idArticle`
                            AND a.`idCategory` = 0
                            AND a.moderationAppruv = 1
                            AND a.public = 1
                            AND a.deleted = 0
                WHERE m.`idMenu` = b.idMenu
                GROUP BY m.`idMenu`
        ";

        $menusBookMarks = $connection->createCommand($sql)->query()->readAll();

        foreach ($menusBookMarks as $key => $menu) {
            $sql = "
                SELECT c.*, COUNT(a.`idArticle`) AS countArticleInCategory
                FROM categorys AS c
                    INNER JOIN bookmarks AS b
                        ON b.idUser = ".$idUser."
                        AND b.`idMenu` = ".$menu['idMenu']."
                    LEFT JOIN articles AS a
                        ON a.`idArticle` = b.`idArticle`
                            AND a.`idCategory` = c.`idCategory`
                            AND a.moderationAppruv = 1
                            AND a.public = 1
                            AND a.deleted = 0
                WHERE c.`idMenu` = ".$menu['idMenu']." AND c.idCategory = b.idCategory
                GROUP BY c.`idCategory`
            ";
            $menusBookMarks[$key]['categorys'] = $connection->createCommand($sql)->query()->readAll();
        }

        return $menusBookMarks;
    }
}
