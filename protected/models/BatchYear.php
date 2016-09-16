<?php

class BatchYear extends CActiveRecord
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
		return 'batch_years';
	}

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('batch_id,start_year,end_year,semester_count', 'required')
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',	
                        'batch_id' => 'Batch',		
                        'start_year' => 'Starting Date',
                        'semester_count' => 'No of Semesters',
                        'end_year' => 'Ending Date',		
		);
	}
        
	      
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = 'id desc'; 
            $criteria->condition = 'status="'.self::STATUS_ACTIVE.'"'; 
            return self::model()->findAll($criteria);
        }
        
  	public static function getBatchYear($courseYearId,$batchId)
	{
            $criteria=new CDbCriteria;
            $criteria->order = 'id desc'; 
            $criteria->condition = 'course_year_id="'.$courseYearId.'" AND batch_id="'.$batchId.'"'; 
            return self::model()->findAll($criteria);                              
	}
        
        public static function deleteBatchYears($courseYearId,$batchId)
        {
            self::model()->deleteAll('course_year_id="'.$courseYearId.'" AND batch_id="'.$batchId.'"');
        }
        
}
