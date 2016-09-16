<?php

class ApplicationsController extends Controller
{

    public $layout = 'column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter - login,logout'
            )
        );
    }

  
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->render('error');
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionView()
    {        
        $criteria = new CDbCriteria;
        $criteria->order = 'created DESC';
        $pages = new CPagination(Application::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Application::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages
        ));
        
    }
    
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionViewDetails()
    {        
        $id = $_GET['id'];
        $model = Application::getApplication($id);
        if($model)
        {            
            $criteria = new CDbCriteria;
            $criteria->condition = "entity_id='$id'";
            $files = Attachment::model()->findAll($criteria);
            $this->render('view-details', array(
            'model' => $model,
             'attachments'=>$files
            ));
            exit;            
        }
        else Yii::app()->user->setFlash('error', 'Invalid Item');
        $this->render('view-details', array(
            'model' => $model
        ));
        
    }
    
     /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionDownload()
    {        
        $id = $_GET['file'];
        $model = Attachment::model()->findByPk($id);
        
        if($model)
        {
           if (!$model->attachment || !file_exists(Yii::app()->params['ApplicationFilePath'].$model->attachment))
            {
                 Yii::app()->user->setFlash('error', 'Invalid Operation');   
            }           
            try
            {
                $file = Yii::app()->params['ApplicationFilePath'].$model->attachment;
                header('Content-Description: File Transfer');
                header("Content-Type: application/force-download");
                header('Content-Type: application/octet-stream');
                header("Content-Type: application/download");
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                {
                    return true;
                }
                return false;
            }
            catch (Exception $e)
            {
               
            }
        }
        else Yii::app()->user->setFlash('error', 'Invalid Operation');              
    }

    public function actionAdd()
    {        
        $model = new Application();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Application']);
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Email-id already exist!');
            }
            else
            {                
                if ($model->validate())
                {            
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {            
                        Yii::app()->user->setFlash('success', 'Application details has been saved successfully!');
                        $this->redirect(array('view'));
                        exit;
                    }
                    else
                        Yii::app()->user->setFlash('error', 'Operation Failed!');
                }
            }
        }        
        $this->render('add', array('model' => $model));
    }

    public function actionEdit()
    {
        if (isset($_GET['id']))
        {
            $id = $_GET['id'];
            $model = Application::getApplication($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Application']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Application already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Application details has been updated successfully!');
                                $this->redirect(array('view'));
                                exit;
                            }
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                        }
                    }
                }
                
                $criteria = new CDbCriteria;
                $criteria->condition = "entity_id='$id'";
                $files = Attachment::model()->findAll($criteria);   
                $this->render('add', array('model' => $model,'attachments'=>$files));
                exit;
            }
        }
        Yii::app()->user->setFlash('error', 'Invalid operation!');
        $this->redirect(array('view'));
        exit;
    }

    public function actionStatus()
    {        
        if (isset($_GET['PId']) || isset($_GET['AId']) || isset($_GET['HId']) || isset($_GET['DId']))
        {
            $id = $_GET['DId'] ? $_GET['DId'] : $_GET['EId'];
            if(isset($_GET['PId'])) { $id = $_GET['PId'];$status = Application::STATUS_PENDING;}
            if(isset($_GET['AId'])) {$id = $_GET['AId'];$status = Application::STATUS_APPROVED;}
            if(isset($_GET['HId'])) {$id = $_GET['HId'];$status = Application::STATUS_HOLD;}
            if(isset($_GET['DId'])) {$id = $_GET['DId'];$status = Application::STATUS_DECLINED;}
            
            $model = Application::getApplication($id);
            if ($model)
            {
                
                if($model->status!=$status)
                {       
                    $model->status = $status;
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Status has been changed successfully!');
                        
                    }
                }
                else
                {
                    Yii::app()->user->setFlash('success', "Can't update status.");
                }
                
                $this->redirect(array('view'));
                        exit;
            }
        }
        Yii::app()->user->setFlash('error', 'Invalid operation!');
        $this->redirect(array('view'));
        exit;       
    }

    public function actionDelete()
    {
        if (isset($_GET['id']))
        {
            if (Application::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Application has been deleted successfully!');
                $this->redirect(array('view'));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('view'));
            exit;
        }
    }
    
    public function actionDeleteFile()
    {
        if (isset($_GET['id']) && isset($_GET['appId']))
        {
            if (Attachment::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'File has been deleted successfully!');                
            }           
            else Yii::app()->user->setFlash('error', 'Operation failed!'); 
        }
        else Yii::app()->user->setFlash('error', 'Operation failed!'); 
        $this->redirect(array('applications/edit/id/'.$_GET['appId']));
                exit;
        
    }

    public function getList($data, $value, $label, $default = true)
    {

        if ($default)
            $result = array("" => "-Select-");
        else
            $result = array();
        foreach ($data as $index => $model)
        {
            $result[$model->$value] = $model->$label;
        }
        return $result;
    }
    
    public function actionStudent()
    {                
         if (isset($_GET['appId']))
        {
            $studentArray = Student::model()->findByAttributes(array('application_id'=>$_GET['appId']));            
            if(!$studentArray)
            {
                $model = Application::getApplication($_GET['appId']);
                $studentModel = new Student();
                $studentModel->attributes = $model->attributes;
                $studentModel->application_id = $_GET['appId'];
                $studentModel->created = date("Y-m-d H:i");
                $studentModel->status = Student::STATUS_ENABLED;
                if ($studentModel->isAlreadyExist())
                { 
                    Yii::app()->user->setFlash('error', 'Student already enrolled!');
                }
                else
                {               
                    if ($studentModel->validate())
                    {            
                        
                        if ($studentModel->save(false))
                        {     
                            $model = Application::getApplication($_GET['appId']);
                            if ($model)
                            {
                                $model->status=Application::STATUS_STUDENT;
                                $model->save(false);
                            }                        
                            $criteria = new CDbCriteria;                                    
                            $criteria->condition = "entity_id='".$_GET['appId']."'";
                            $files = Attachment::model()->findAll($criteria);
                            if(is_array($files))
                            {
                                foreach($files as $key=>$val)
                                {                                    
                                    $attachmentModel = new Attachment();
                                    $attachmentModel->attributes = $val->attributes;
                                    $attachmentModel->entity = 2;
                                    $attachmentModel->entity_id = $studentModel->getPrimaryKey();                             
                                    $attachmentModel->save();
                                }
                            }
                            Yii::app()->user->setFlash('success', 'Successfully enrolled student!');
                            $this->redirect(array('view'));
                            exit;
                        }                        
                    }
                }
            }
        }                
        Yii::app()->user->setFlash('error', 'Operation Failed!');
        $this->redirect(array('applications/view'));
        exit;
        
    }

  
}
