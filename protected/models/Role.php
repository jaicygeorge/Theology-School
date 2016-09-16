<?php

class Role extends CActiveRecord
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
		return 'roles';
	}
        
        public static function getAll()
        {
            $criteria=new CDbCriteria;
            $criteria->condition = 'id != 1'; 
            return self::model()->findAll($criteria);
        }
	
}
