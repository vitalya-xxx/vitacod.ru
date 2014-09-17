<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property string $idComment
 * @property string $idUser
 * @property string $idArticle
 * @property string $text
 * @property integer $deleted
 * @property integer $public
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Users $idUser0
 * @property Articles $idArticle0
 */
class Comments extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idUser, idArticle, text, typeUser', 'required'),
            array('deleted, public', 'numerical', 'integerOnly'=>true),
            array('idUser, idArticle', 'length', 'max'=>10),
            array('date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idComment, idUser, idArticle, text, deleted, public, date, typeUser', 'safe', 'on'=>'search'),
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
            'idUser0'       => array(self::BELONGS_TO, 'Users', 'idUser'),
            'idArticle0'    => array(self::BELONGS_TO, 'Articles', 'idArticle'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'idComment' => 'Id Comment',
            'idUser'    => 'Id User',
            'idArticle' => 'Id Article',
            'text'      => 'Текст комментария',
            'deleted'   => 'Deleted',
            'public'    => 'Public',
            'date'      => 'Date',
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

        $criteria->compare('idComment',$this->idComment,true);
        $criteria->compare('idUser',$this->idUser,true);
        $criteria->compare('idArticle',$this->idArticle,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('deleted',$this->deleted);
        $criteria->compare('public',$this->public);
        $criteria->compare('date',$this->date,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    protected function afterFind() {
        $this->date  = date('d.m.Y H:i', strtotime($this->date));
        parent::afterFind();
    }


    protected function beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->date     = date("Y-m-d H:i:s");
                $this->deleted  = 0;
                $this->public   = 1;
            }
            return true;
        }else{
            return false;
        }
    }
}