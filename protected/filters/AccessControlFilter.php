<?php

/**
 * Description of AccessControlFilter
 * 
 */
class AccessControlFilter extends CFilter
{
	protected function preFilter($filterChain)
	{
            if (Yii::app()->user->isGuest)
            {
                 Yii::app()->user->loginRequired();
                exit;
            }
            else return TRUE;            
	}
}

?>
