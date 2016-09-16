<?php

class CourseYearSemester extends CActiveRecord
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
		return 'course_year_semesters';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_year_id,semester_id', 'required')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'course_year_id' => 'Course Year Name',
                        'semester_id' =>'Semester'
		);
	}
	  
        
	public function getCourseName()
	{
		$course = Course::model()->findByPk($this->course_year_id);
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
        
        public function isSelectedBatchSubject($courseYearId,$semesterId,$batchId,$subjectId)
        {
            $criteria = new CDbCriteria;       
            $criteria->condition = 'course_year_id="'.$courseYearId.'" AND batch_id="'.$batchId.'" AND semester_id="'.$semesterId.'"  AND subject_id="'.$subjectId.'"';   
            if(BatchSubject::model()->find($criteria)) return true;else return false;
        }
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $semesterResult = self::model()->findByAttributes(array('course_year_id'=>$this->course_year_id,'semester_id'=>$this->semester_id), $condition);
            if($semesterResult) return true;
            else return false;
        }
        public function getSubjects()
        {
            $criteria = new CDbCriteria;           
            $criteria->order = 'subject ASC';   
            return Subject::model()->findAll($criteria);
        }
        public function getBatchSubjects($courseYearId,$batchId,$semesterId)
        {
            $criteria = new CDbCriteria;           
            $criteria->order = 'id ASC';   
            $criteria->condition = 'course_year_id="'.$courseYearId.'" AND batch_id="'.$batchId.'" AND semester_id="'.$semesterId.'"';   
            return BatchSubject::model()->findAll($criteria);
        }
        public function getSubjectTeacher($batch_subject_id)
        {
            return BatchSubjectTeacher::getSubjectTeacher($batch_subject_id,$subject_id);            
        }        
        public static function getCourseYearSemester($id)
	{
		return CourseYearSemester::model()->findByPk($id);                           
	}
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = "id ASC"; 
            return self::model()->findAll($criteria);
        }        
        public static function getSemesterCount($courseYearId)
        {
            $criteria=new CDbCriteria;            
            $criteria->condition = "course_year_id='".$courseYearId."'"; 
            return count(self::model()->findAll($criteria));
        }
        
}
