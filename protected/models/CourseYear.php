<?php

class CourseYear extends CActiveRecord
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
		return 'course_years';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id,year_name', 'required')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'course_id' => 'Course',
                        'year_name' =>'Year Name'
		);
	}
	  
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getCourseYear($id)
	{
		return self::model()->findByPk($id);                        
	}
        
         /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getCourseYearName($id)
	{
		$result =  self::model()->findByPk($id); 
                return $result->year_name;
	}
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getCourseName($courseYearId)
	{
		$result =  self::model()->findByPk($courseYearId);  
                return Course::getCourseName($result->course_id);
	}
        
        
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $yearResult = self::model()->findByAttributes(array('course_id'=>$this->course_id,'year_name'=>$this->year_name), $condition);
            if($yearResult) return true;
            else return false;
        }
       
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = "id ASC"; 
            return self::model()->findAll($criteria);
        }
        
        public static function getCourseYears($courseId)
        {
            $criteria=new CDbCriteria;
            $criteria->order = "id ASC"; 
            $criteria->condition = 'course_id="'.$courseId.'"';  
            return self::model()->findAll($criteria);
        }
}
