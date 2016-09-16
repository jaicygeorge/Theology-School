<?php

class CourseCategory extends CActiveRecord
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
		return 'course_categories';
	}

	      
         public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->order = 'name asc'; 
            return self::model()->findAll($criteria);
        }
}
