<?php

class BatchSubject extends CActiveRecord
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
		return 'batch_subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_id,course_year_id,semester_id,batch_id', 'required')
		);
	}

       
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getBatchSubject($id)
	{
		return self::model()->findByPk($id);                        
	}
      
        public function getSubject($subjectId)
        {          
            return Subject::model()->findByPk($subjectId);   
        }
        
        public function getStudentMark($student_id,$course_Year_id,$semester_id)
        {
            $studentSubjectMark  = StudentSubjectMark::model()->findByAttributes(array('course_year_id'=>$course_Year_id,'semester_id'=>$semester_id,'subject_id'=>$this->subject_id,'student_id'=>$student_id));
            if($studentSubjectMark===FALSE)
            {
                return 0;
            }
            return $studentSubjectMark->mark;
        }
        
        
}
