<?php

class Teacher extends CActiveRecord
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
		return 'teachers';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,code', 'required')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
                        'name' => 'Instructor Name',	
			'code' => 'Instructor Code',					
		);
	}
	      
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = 'name asc'; 
            return self::model()->findAll($criteria);
        }
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getTeacher($id)
	{
		return self::model()->findByPk($id);                        
	}
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;                        
            $teacherResult = self::model()->findByAttributes(array('code'=>$this->code), $condition);
            if($teacherResult) return true;
            else return false;
        }
}
