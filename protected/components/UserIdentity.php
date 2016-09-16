<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{	
        private $_name;
        private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{           
            $user=User::model()->findByAttributes(array('username'=>$this->username));

            if($user===null || $user->status!=User::STATUS_ACTIVE)
            {		
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }		
            else if($user->password!==md5($this->password))
            {                
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else
            {                
                $this->_name=$user->username;
                $this->_id=$user->id;
                $this->setState('LoggedUser', $user);

                Yii::log($this->_name . ' has logged in ');

                //loading some roles
                //$this->setState('title', $record->title);
                $this->errorCode=self::ERROR_NONE;
            }
            return $this->errorCode;
	}

	public function getName()
        {
            return $this->_name;
        }
        
        public function getId()
        {
            return $this->_id;
        }
}