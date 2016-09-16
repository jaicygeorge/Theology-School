<?php

class User extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_user':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $profile
	 */
        const STATUS_UN_CONFIRMED = 0; 
        const STATUS_ACTIVE = 1;
        const STATUS_DISABLED = 2;
    

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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
                        array('name, roles', 'required', 'on'=>"create"),
			array('email', 'email'),
			array('profile,phone', 'safe'),
		);
	}

//	/**
//	 * @return array relational rules.
//	 */
//	public function relations()
//	{
//		// NOTE: you may need to adjust the relation name and the related
//		// class name for the relations automatically generated below.
//		return array(
//			'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
//		);
//	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'profile' => 'Profile',
		);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->password);
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
        
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function getRoleName()
	{
		$role = Role::model()->findByPk($this->roles);
                return $role->name;                
	}
              
        /**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public static function getUser($id)
	{
		return self::model()->findByPk($id);                        
	}
        
        public function isAlreadyExist($id="")
        {
            $condition = "";
            if($id) $condition = "id !=".$id;            
            $emailResult = self::model()->findByAttributes(array('email'=>$this->email), $condition);
            $usernameResult = self::model()->findByAttributes(array('username'=>$this->username), $condition);
            if($emailResult || $usernameResult) return true;
            else return false;
        }
}
