<?php

class Attachment extends CActiveRecord
{
	const TYPE_APPLICATION = 1;
        const TYPE_STUDENT = 2;
        const TYPE_DOCUMENT = 1;
        const TYPE_PHOTO = 2;
    
        
        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{            
            return array(
                    array('entity,entity_id,attachment,original_name,type', 'safe'),
            );
	}
        
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
		return 'student_attachments';
	}

        public function add($entity,$id,$fileName,$original,$type)
        {
           $this->entity =  $entity;
           $this->entity_id = $id;
           $this->attachment = $fileName;
           $this->original_name = $original;
           $this->type = $type;
           if($this->save()) return true;
            else return false;
        }
}
