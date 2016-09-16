<?php

class SubjectsController extends Controller
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
        $pages = new CPagination(Subject::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Subject::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages
        ));  
    }

   public function actionAdd()
    {
        $model = new Subject();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Subject']);
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Subject already exist!');
            }
            else
            {
                if ($model->validate())
                {
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Subject details has been saved successfully!');
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
            $model = Subject::getSubject($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Subject']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Subject already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Subject details has been updated successfully!');
                                $this->redirect(array('view'));
                                exit;
                            }
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                        }
                    }
                }
                $this->render('add', array('model' => $model));
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
            $status = $_GET['DId'] ? User::STATUS_DISABLED : User::STATUS_ACTIVE;
            $model = Subject::getSubject($id);
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
            if (Subject::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Subject has been deleted successfully!');
                $this->redirect(array('view'));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('view'));
            exit;
        }
    }

}
