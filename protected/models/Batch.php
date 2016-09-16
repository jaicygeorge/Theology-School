<?php

class Batch extends CActiveRecord
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
		return 'batches';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id,start_date,end_date', 'required')                       
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Batch Name',		
                        'course_id' => 'Course',		
                        'start_date' => 'Starting Date',		
                        'end_date' => 'Ending Date',		
		);
	}
	      
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = 'name asc'; 
            $criteria->condition = 'status="'.self::STATUS_ACTIVE.'"'; 
            return self::model()->findAll($criteria);
        }
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getBatch($id)
	{
            return self::model()->findByPk($id);                        
	}
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getBatchName($id)
	{
            $model =  self::model()->findByPk($id);              
            return substr($model->start_date,0,4)."-".substr($model->end_date,0,4);
	}
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = " AND id !=".$id;    
            $criteria=new CDbCriteria;
            $criteria->condition = 'course_id="'.$this->course_id.'" AND YEAR(start_date)='.substr($this->start_date,0,4).' AND YEAR(end_date)='.substr($this->end_date,0,4).$condition; 
            $batchResult =  self::model()->findAll($criteria);
            if($batchResult) return true;
            else return false;
        }
        public function isValidDate()
        {
            if(strtotime($this->start_date)<strtotime($this->end_date)) return true;else return false;
        }        
        
        public function getCourseName($id)
        {
            $course = Course::getCourse($id);
            return $course->name;
        }
        
        public static function getYearRange($courseYearId,$batchId)
        {
            $batchYear = BatchYear::getBatchYear($courseYearId,$batchId);
            return $batchYear[0]->start_year." - ".$batchYear[0]->end_year;
        }
        
        
        
        
}
