<?php

class CourseSemester extends CActiveRecord
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
		return 'course_semesters';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id,semester_id', 'required')
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
                        'semester_id' =>'Semester'
		);
	}
	  
        
	public function getCourseName()
	{
		$course = Course::model()->findByPk($this->course_id);
                return $course->name;                
	}
        
        public function getCourseObj($semesterId)
        {
                $course = Course::model()->findByAttributes(array("semester_id"=>$semesterId));
                return $course->name;
        }
        
        public function getSemesterName()
	{
		$semester = Semester::model()->findByPk($this->semester_id);
                return $semester->name;                
	}
        
        
         public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $semesterResult = self::model()->findByAttributes(array('course_id'=>$this->course_id,'semester_id'=>$this->semester_id), $condition);
            if($semesterResult) return true;
            else return false;
        }
        public function getSubjects()
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'semester_id="'.$this->semester_id.'" AND course_id="'.$this->course_id.'"';
            $criteria->order = 'subject ASC';   
            return Subject::model()->findAll($criteria);
        }
        public function getSubjectTeacher($batch_id,$subject_id)
        {
            return BatchSubjectTeacher::getSubjectTeacher($batch_id,$subject_id);            
        }        
        public static function getCourseSemester($id)
	{
		return CourseSemester::model()->findByPk($id);                           
	}
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = "id ASC"; 
            return self::model()->findAll($criteria);
        }
}
