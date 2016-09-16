<?php

class CourseSemestersController extends Controller
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
        $courseModel = NULL;
        if(!empty($_GET['courseId']))
        {
            $criteria->condition = 'course_id="'.$_GET['courseId'].'"';
            $courseModel = Course::getCourse($_GET['courseId']);
        }
        $pages = new CPagination(CourseSemester::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = CourseSemester::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages,
            'courseModel' =>$courseModel
        ));
    }

    public function actionAdd()
    {
        $model = new CourseSemester();
        $courseModel = NULL;
        $redirectLink = "view";
        if(!empty($_GET['courseId']))
        {
            $courseModel = Course::getCourse($_GET['courseId']);
            $redirectLink = "/CourseSemesters/view/courseId/".$_GET['courseId'];
        }
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['CourseSemester']);            
           
            if ($model->validate())
            {        
                $flag = false;
                if(is_array($_POST['CourseSemester']['semester_id']))
                {
                    foreach($_POST['CourseSemester']['semester_id'] as $key=>$value)
                    {
                        if($value)
                        {
                            $newModel = new CourseSemester();
                            $newModel->course_id = $_POST['CourseSemester']['course_id'];
                            $newModel->semester_id = $value;
                            if (!$newModel->isAlreadyExist())
                            {                              
                                if($newModel->save(false)) $flag = true;
                            }
                            else
                            {
                                Yii::app()->user->setFlash('error', 'Semester is already exist in the selected course!');
                                $this->redirect(array($redirectLink));
                                exit;
                            }
                        }
                    }
                }
                if ($flag==true)
                {
                    Yii::app()->user->setFlash('success', 'Course semester details has been saved successfully!');
                    $this->redirect(array($redirectLink));
                    exit;
                }
                else
                    Yii::app()->user->setFlash('error', 'Operation Failed!');
            }
                
        }
        
        $courses = Course::getAll();
        $courseList = $this->getList($courses, "id", "name");
        $semesters = Semester::getAll();
        $semesterList = $this->getList($semesters, "id", "name");
        $this->render('add', array('courseList' => $courseList,"courseModel"=>$courseModel,'semesterList' => $semesterList, 'model' => $model));
        
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

    public function actionDelete()
    {
        if (isset($_GET['id']))
        {
            $redirectLink = "view";
            if(!empty($_GET['courseId']))
            {                
                $redirectLink = "/CourseSemesters/view/courseId/".$_GET['courseId'];
            }
            if (CourseSemester::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Course semester has been deleted successfully!');
                $this->redirect(array($redirectLink));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array($redirectLink));
            exit;
        }
    }
    
}
