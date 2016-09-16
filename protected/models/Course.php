<?php

class Course extends CActiveRecord
{	
       const STATUS_ACTIVE = 1;
       const STATUS_DISABLED = 0;

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
		return 'courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, period,course_category_id', 'required'),
                        array('period', 'numerical'),
			array('description', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Course Name',
			'period' => 'Course Period in Years(No. of years)',
			'course_category_id' => 'Course category',
			'description' => 'description',
		);
	}

	  
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getCourse($id)
	{
		return self::model()->findByPk($id);                        
	}
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getCourseName($id)
	{
		$result =  self::model()->findByPk($id); 
                return $result->name;
	}
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $subjectResult = self::model()->findByAttributes(array('name'=>$this->name), $condition);
            $typeResult = self::model()->findByAttributes(array('course_category_id'=>$this->course_category_id), $condition);
            if($subjectResult && $typeResult) return true;
            else return false;
        }
        
        public function getCategoryName()
	{
		$category = CourseCategory::model()->findByPk($this->course_category_id);
                return $category->name;                
	}
        
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'status ='.self::STATUS_ACTIVE; 
            return self::model()->findAll($criteria);
        }
        
}
