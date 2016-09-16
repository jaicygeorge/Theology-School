<?php

class Application extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_user':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $profile
	 */
        const STATUS_PENDING = 0; 
        const STATUS_APPROVED = 1;
        const STATUS_HOLD = 2;
        const STATUS_DECLINED = 3;
        const STATUS_STUDENT = 4;
        const GENDER_MALE = 1;
        const GENDER_FEMALE = 2;       
        const HOLYSPIRIT_NO = 1;
        const HOLYSPIRIT_YES = 2;
    

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
		return 'applications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{            
            return array(
                    array('name, permenant_address, dob,place_of_birth,mother_tongue,gender,
                        email,mobile_phone,occupation,marital_status,church_denomination', 'required'),
                    array('email', 'email'),
                    array('mobile_phone', 'numerical'),   
                    array('temporary_address,church_address,received_time,date_of_baptism,holyspirit_info,educational_documents,photo,reson_for_study', 'safe'),
            );
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return array(
			'id' => 'Id',
			'name' => 'Name',
			'permenant_address' => 'Permenant Address',
			'dob' => 'Date of Birth',
			'place_of_birth' => 'Place of Birth',
                        'mother_tongue' => 'Mother Tongue',
			'gender' => 'Gender',
                        'email' => 'Email',
			'mobile_phone' => 'Mobile Phone',
                        'occupation' => 'Occupation',
			'marital_status' => 'Marital Status',
                        'church_denomination' => 'Church Denomination',
			'temporary_address' => 'Temporary Address',
                        'church_address' => 'Church Address',
			'received_time' => 'When did you receive Jesus Christ as your Personal Savior?',
                        'date_of_baptism' => 'Date of water baptism',
			'holyspirit_info' => 'Are you filled with Holy Spirit?',
                        'educational_documents' => 'Educational Qualifications',
			'photo' => 'Photo',
                        'reson_for_study' => 'Why you desire to study the word of God?'			
		);
	}
         /**
     * beforeSave function - involked automatically by Yii just before save()
     * @return boolean
     */
    protected function afterSave()
    {
        parent::afterSave();
        
        if ($_FILES['educational_documents'] || $_FILES['photo'])
            {                                                                    
                foreach ($_FILES['educational_documents']['name'] as $key => $val)
                {        
                    if ($val != '')
                    {
                        
                        $orginalFilename = basename($_FILES['educational_documents']['name'][$key]);
                        list($fileName,$extension) = explode(".",$orginalFilename);
                        $fileName = $fileName."_".rand()."_".time().".".$extension;
                        $attachment = new Attachment();
                        $ins  = $attachment->add(Attachment::TYPE_APPLICATION,$this->getPrimaryKey(),$fileName,$orginalFilename,1);
                        if($ins)
                        {
                            move_uploaded_file($_FILES['educational_documents']['tmp_name'][$key], Yii::app()->params['ApplicationFilePath'] . $fileName);
                        }
                    }
                }
                if ($_FILES['photo'])
                {
                    $orginalFilename = basename($_FILES['photo']['name']);
                    list($fileName,$extension) = explode(".",$orginalFilename);
                    $fileName = $fileName."_".rand()."_".time().".".$extension;
                    $attachment = new Attachment();
                    $ins = $attachment->add(Attachment::TYPE_APPLICATION,$this->getPrimaryKey(),$fileName,$orginalFilename,2);
                    if($ins)
                    {
                        move_uploaded_file($_FILES['photo']['tmp_name'],Yii::app()->params['ApplicationFilePath']. $fileName);
                    }
                }
            }
            return true;        
    }
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getApplication($id)
	{
		return self::model()->findByPk($id);                        
	}
        
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $emailResult = self::model()->findByAttributes(array('email'=>$this->email), $condition);
            if($emailResult) return true;
            else return false;
        }
        
       
}
