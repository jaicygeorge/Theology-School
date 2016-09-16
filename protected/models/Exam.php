<?php

class Exam extends CActiveRecord
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
		return 'exams';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_year_semester_id,batch_id', 'required')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'course_year_semester_id' => 'Course Year Semester',
                        'name' =>'Exam Name',
                        'batch_id' =>'Batch'
		);
	}
	
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $examResult = self::model()->findByAttributes(array('course_year_semester_id'=>$this->course_year_semester_id,'batch_id'=>$this->batch_id), $condition);
            if($examResult) return true;
            else return false;
        }
        
        public function getBatchName($id)
        {            
            $result = Batch::getBatch($id);
            return $result ? substr($result->start_date,0,4)." - ".substr($result->end_date,0,4): "";
        }
        
        public function getCourseYearName($id)
        {            
            $name = "";
            $result = CourseYearSemester::getCourseYearSemester($id);
            if($result) 
            {   
                $courseYear = CourseYear::getCourseYear($result->course_year_id);                
                if($courseYear) 
                {
                    $course = Course::getCourse($courseYear->course_id);
                    $name = $course->name." - ".$courseYear->year_name;
                }
            }            
            return $name;
        }
        
        public function getSemesterName($id)
        {            
            $result = CourseYearSemester::getCourseYearSemester($id);
            if($result) 
            {
                $semester = Semester::getSemester($result->semester_id);
                return $semester ? $semester->name: "";
            }
            else return "";
        }
        
        public static function getExam($id)
	{
            return self::model()->findByPk($id);                        
	}
}
