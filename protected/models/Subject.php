<?php

class Subject extends CActiveRecord
{
	
        const TYPE_COLLEGE_SUBJECT = 1; 
        const TYPE_UNIVERSITY_SUBJECT = 2;
        
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
		return 'subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject,type,total_mark', 'required'),   
                        array('total_mark', 'numerical'),   
			array('status,subject_code', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'subject' => 'Subject Name',
			'type' => 'Subject Type',
			'total_mark' => 'Total Mark',	
                        'subject_code' => 'Subject Code'
		);
	}

        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getSubject($id)
	{
		return self::model()->findByPk($id);                        
	}
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getSubjectName($id)
	{
		$subject = self::model()->findByPk($id);  
                if($subject)
                {
                    return $subject->subject;
                }
	}
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $subjectResult = self::model()->findByAttributes(array('subject'=>$this->subject,'type'=>$this->type), $condition);
            if($subjectResult) return true;
            else return false;
        }
        
       
        
        
}
