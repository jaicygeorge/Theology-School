<?php

class StudentsController extends Controller
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
        $pages = new CPagination(Student::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Student::model()->findAll($criteria);
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
        $model = Student::getStudent($id);
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
        $model = new Student();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Student']);
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
                        Yii::app()->user->setFlash('success', 'Student details has been saved successfully!');
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
            $model = Student::getStudent($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Student']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Student already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Student details has been updated successfully!');
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
        if (isset($_GET['DId']) || isset($_GET['EId']))
        {
            $id = $_GET['DId'] ? $_GET['DId'] : $_GET['EId'];
            $status = $_GET['DId'] ? Student::STATUS_DISABLED : Student::STATUS_ENABLED;
            $model = Student::getStudent($id);
            if ($model)
            {
                $model->status = $status;
                if ($model->save(false))
                {
                    Yii::app()->user->setFlash('success', 'Status has been changed successfully!');
                    $this->redirect(array('view'));
                    exit;
                }
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
            if (Student::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Student has been deleted successfully!');
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
        $this->redirect(array('students/edit/id/'.$_GET['appId']));
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
    
    public function actionassignBatch()
    {
        $model = Student::getStudent($_GET['id']);
        if($model)
        {
            if (isset($_POST['addSub']))
            {
                if ($_POST['Student']['batch_id'])
                {
                    if($model->batch_id!=$_POST['Student']['batch_id'])
                    {
                        $model->batch_id = $_POST['Student']['batch_id'];    
                        if ($model->save(false))
                        {            
                            Yii::app()->user->setFlash('success', 'Batch has been assigned successfully!');
                            $this->redirect(array('view'));
                            exit;
                        }
                        else
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                    }                    
                }
                else
                {
                     Yii::app()->user->setFlash('error', 'Please select the course to be assigned!');
                }
            }
            
            $batchList = $this->getBatchList(Batch::getAll(), "id", "name"); 
            $this->render('assignBatch', array('model' => $model,'batchList'=>$batchList));
        }
    }    
    
    public function getBatchList($data,$default = true)
    {
        if ($default)
            $result = array("" => "-Select-");
        else
            $result = array();
        foreach ($data as $index => $model)
        {            
            $course = Course::getCourse($model->course_id);
            $result[$model->id] = substr($model->start_date,0,4)."-".substr($model->end_date,0,4). " ( " . $course->name. " ) ";
        }        
        return $result;
    }
}
