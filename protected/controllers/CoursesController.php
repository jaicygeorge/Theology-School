<?php

class CoursesController extends Controller
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
        $pages = new CPagination(Course::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Course::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages
        ));
    }

    public function actionAdd()
    {
        $model = new Course();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Course']);            
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Course already exist!');
            }
            else
            {
                if ($model->validate())
                {
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Course details has been saved successfully!');
                        $this->redirect(array('view'));
                        exit;
                    }
                    else
                        Yii::app()->user->setFlash('error', 'Operation Failed!');
                }
                
            }
        }

        $categories = CourseCategory::getAll();
        $categoryList = $this->getList($categories, "id", "name");       
        $this->render('add', array('model' => $model,'categoryList'=>$categoryList));
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

    public function actionEdit()
    {
        if (isset($_GET['id']))
        {
            $id = $_GET['id'];
            $model = Course::getCourse($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Course']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Course already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Course details has been updated successfully!');
                                $this->redirect(array('view'));
                                exit;
                            }
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                        }
                    }
                }
                $categories = CourseCategory::getAll();
                $categoryList = $this->getList($categories, "id", "name");       
                $this->render('add', array('model' => $model,'categoryList'=>$categoryList));
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
            $status = $_GET['DId'] ? Course::STATUS_DISABLED : Course::STATUS_ACTIVE;
            $model = Course::getCourse($id);
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
            if (Course::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Course has been deleted successfully!');
                $this->redirect(array('view'));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('view'));
            exit;
        }
    }
    
    public function actionViewYears()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = ' course_id='.$_GET['courseId'];
        $criteria->order = 'created DESC';
        $pages = new CPagination(CourseYear::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = CourseYear::model()->findAll($criteria);
        $this->render('courseYears', array(
            'models' => $models,
            'pages' => $pages
        ));
    }
    
    public function actionAddCourseYear()
    {
        $model = new CourseYear();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['CourseYear']);      
            $model->course_id = $_GET['courseId'];
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Course year already exist!');
            }
            else
            {
                if ($model->validate())
                {
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Course year details has been saved successfully!');
                        $this->redirect(array('/courses/viewYears/courseId/'.$_GET['courseId']));
                        exit;
                    }
                    else
                        Yii::app()->user->setFlash('error', 'Operation Failed!');
                }
                
            }
        }

        $this->render('addCourseYear', array('model' => $model));
    }
    
 
    public function actionEditCourseYear()
    {
        if (isset($_GET['id']))
        {
            $id = $_GET['id'];
            $model = CourseYear::getCourseYear($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['CourseYear']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Course year name already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Course year details has been updated successfully!');
                                $this->redirect(array('/courses/viewYears/courseId/'.$model->course_id));
                                exit;
                            }
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                        }
                    }
                }
               
                $this->render('addCourseYear', array('model' => $model));
                exit;
            }
        }
        Yii::app()->user->setFlash('error', 'Invalid operation!');
        $this->redirect(array('/courses/viewYears/courseId/'.$_GET['courseId']));
        exit;
    }
    
     public function actionDeleteCourseYear()
    {
        if (isset($_GET['id']))
        {
            if (CourseYear::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Course year has been deleted successfully!');
                $this->redirect(array('/courses/viewYears/courseId/'.$_GET['courseId']));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('/courses/viewYears/courseId/'.$_GET['courseId']));
            exit;
        }
    }

}
