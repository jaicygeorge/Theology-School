<?php

class Semester extends CActiveRecord
{
	
       	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'semesters';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Semester Name',					
		);
	}
	      
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = 'created asc'; 
            return self::model()->findAll($criteria);
        }
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getSemester($id)
	{
		return self::model()->findByPk($id);                        
	}
        
         public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $semesterResult = self::model()->findByAttributes(array('name'=>$this->name), $condition);
            if($semesterResult) return true;
            else return false;
        }
}
