<?php

class CourseYearSemestersController extends Controller
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
        $criteria->condition = 'course_year_id="'.$_GET['courseYearId'].'"';
        $courseYearModel = CourseYear::getCourseYear($_GET['courseYearId']);
       
        $pages = new CPagination(CourseYearSemester::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = CourseYearSemester::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages,
            'courseYearModel' =>$courseYearModel
        ));
    }

    public function actionAdd()
    {
        $model = new CourseYearSemester();
        $courseModel = NULL;       
        $courseYearModel = CourseYear::getCourseYear($_GET['courseYearId']);
        $redirectLink = "/CourseYearSemesters/view/courseYearId/".$_GET['courseYearId'];
        
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['CourseYearSemester']);            
            $model->course_year_id = $_GET['courseYearId'];
            if ($model->validate())
            {        
                $flag = false;
                if(is_array($_POST['CourseYearSemester']['semester_id']))
                {
                    foreach($_POST['CourseYearSemester']['semester_id'] as $key=>$value)
                    {
                        if($value)
                        {
                            $newModel = new CourseYearSemester();
                            $newModel->course_year_id = $_GET['courseYearId'];
                            $newModel->semester_id = $value;
                            if (!$newModel->isAlreadyExist())
                            {                              
                                if($newModel->save(false)) $flag = true;
                            }
                            else
                            {
                                Yii::app()->user->setFlash('error', 'Semester is already exist in this course year!');
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
        
        $semesters = Semester::getAll();
        $semesterList = $this->getList($semesters, "id", "name");
        $this->render('add', array("courseYearModel"=>$courseYearModel,'semesterList' => $semesterList, 'model' => $model));
        
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
                         
            $redirectLink = "/CourseYearSemesters/view/courseYearId/".$_GET['courseYearId'];
            
            if (CourseYearSemester::model()->deleteByPk($_GET['id']))
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
