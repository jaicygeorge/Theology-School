<?php

class Grade extends CActiveRecord
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
		return 'grades';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grade,percentage_from,percentage_to', 'required')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
                        'grade' => 'Grade',	
			'percentage_from' => 'Mark Percentage From',	
                        'percentage_to' => 'Mark Percentage To'	
		);
	}
	      
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = 'percentage_from asc'; 
            return self::model()->findAll($criteria);
        }
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getGrade($id)
	{
		return self::model()->findByPk($id);                        
	}
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;                        
            $teacherResult = self::model()->findByAttributes(array('grade'=>$this->grade,'percentage_from'=>$this->mark_from,'percentage_to'=>$this->mark_to), $condition);
            if($teacherResult) return true;
            else return false;
        }
}
