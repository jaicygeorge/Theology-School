<?php

class SemestersController extends Controller
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

    public function actionView()
    {        
        $criteria = new CDbCriteria;
        $criteria->order = 'created DESC';        
        $pages = new CPagination(Semester::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Semester::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages
        ));
    }

    public function actionAdd()
    {
        $model = new Semester();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Semester']);            
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Semester already exist!');
            }
            else
            {
                if ($model->validate())
                {
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Semester details has been saved successfully!');
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
            $model = Semester::getSemester($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Semester']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Semester already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Semester details has been updated successfully!');
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


    public function actionDelete()
    {
        if (isset($_GET['id']))
        {
            if (Semester::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Semester has been deleted successfully!');
                $this->redirect(array('view'));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('view'));
            exit;
        }
    }

}
