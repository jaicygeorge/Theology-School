<?php

class BatchSubjectTeacher extends CActiveRecord
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
		return 'subject_teachers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('batch_subject_id,teacher_id', 'required')                      
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'batch_id' => 'Batch Name',
			'subject_id' => 'Subject',
			'teacher_id' => 'Faculty',			
		);
	}

        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getBatchSubjectTeacher($id)
	{
		return self::model()->findByPk($id);                        
	}
        
//        public function isAlreadyExist($id="")
//        {
//            $condition = "";
//            if($id) $condition = "id !=".$id;            
//            $subjectResult = self::model()->findByAttributes(array('subject'=>$this->subject,'semester_id'=>$this->semester_id,'course_id'=>$this->course_id,'type'=>$this->type), $condition);
//            if($subjectResult) return true;
//            else return false;
//        }
        public static function getSubjectTeacher($batch_subject_id)
        {
            if($result = self::model()->findByAttributes(array('batch_subject_id'=>$batch_subject_id)))
            {
                return $result->teacher_id;
            }
            return 0;
        }
        
        
}
