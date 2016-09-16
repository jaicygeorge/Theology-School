<?php

class ExamsController extends Controller
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
        $criteria->order = "created DESC";
        $pages = new CPagination(Exam::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Exam::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages
        ));
    }

    public function actionAdd()
    {
        $model = new Exam();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Exam']);
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Exam already exist!');
            }
            else
            {
                if ($model->validate())
                {
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {
                        Yii::app()->user->setFlash('success', 'Exam details has been saved successfully!');
                        $this->redirect(array('view'));
                        exit;
                    }
                    else
                        Yii::app()->user->setFlash('error', 'Operation Failed!');
                }
            }
        }
        $courseList = $this->getCourseYearSemesterList(CourseYearSemester::getAll());
        $batchList = $this->getBatchList(Batch::getAll(), "id", "name");
        $this->render('add', array('model' => $model, 'courseList' => $courseList, 'batchList' => $batchList));
    }

    public function actionEdit()
    {
        if (isset($_GET['id']))
        {
            $id = $_GET['id'];
            $model = Exam::getExam($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Exam']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Exam already exist!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                Yii::app()->user->setFlash('success', 'Exam details has been updated successfully!');
                                $this->redirect(array('view'));
                                exit;
                            }
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                        }
                    }
                }

                $courseList = $this->getCourseYearSemesterList(CourseYearSemester::getAll());
                $batchList = $this->getBatchList(Batch::getAll(), "id", "name");
                $this->render('add', array('model' => $model, 'courseList' => $courseList, 'batchList' => $batchList));
                exit;
            }
        }
        Yii::app()->user->setFlash('error', 'Invalid operation!');
        $this->redirect(array('view'));
        exit;
    }

    public function getBatchList($data, $default = true)
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

    public function getCourseYearSemesterList($data, $default = true)
    {
        if ($default)
            $result = array("" => "-Select-");
        else
            $result = array();
        foreach ($data as $index => $model)
        {
            $courseYear = CourseYear::getCourseYear($model->course_year_id);
            $course = Course::getCourse($courseYear->course_id);
            $semester = Semester::getSemester($model->semester_id);
            $result[$model->id] = $course->name . " - " .$courseYear->year_name . " - " . $semester->name;
        }
        return $result;
    }

    public function actionDelete()
    {
        if (isset($_GET['id']))
        {
            if (Exam::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Exam has been deleted successfully!');
                $this->redirect(array('view'));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('view'));
            exit;
        }
    }

    public function actionStudents()
    {
        if (isset($_GET['examId']))
        {
            $exam = Exam::model()->findByPk($_GET['examId']);
            $studentList = Student::getActiveStudents($exam->batch_id);
            $this->render('students', array('studentList' => $studentList));
            exit;
        }
        Yii::app()->user->setFlash('error', 'Operation failed!');
        $this->redirect(array('view'));
        exit;
    }

    public function actionMarkEntry()
    {
        if (isset($_GET['examId']) && isset($_GET['id']))
        {
            $student = Student::getStudent($_GET['id']);
            $exam = Exam::model()->findByPk($_GET['examId']);
            $courseYearSemester = CourseYearSemester::getCourseYearSemester($exam->course_year_semester_id);
            $criteria = new CDbCriteria;
            $criteria->condition = "batch_id='" . $student->batch_id . "' AND course_year_id='" . $courseYearSemester->course_year_id . "' AND semester_id='" . $courseYearSemester->semester_id . "'";
            $subjects = BatchSubject::model()->findAll($criteria);
            $this->render('subjects', array('subjects' => $subjects, 'student' => $student,'course_year_id' => $courseYearSemester->course_year_id,'semester_id' => $courseYearSemester->semester_id));
            exit;
        }
      
        Yii::app()->user->setFlash('error', 'Operation failed!');
        $this->redirect(array('view'));
        exit;
    }

    public function actionSaveMarkEntry()
    {
        if (isset($_POST['subject_id']) && (isset($_POST['mark'])|| isset($_POST['mark1']) || isset($_POST['mark2'])) && isset($_POST['student_id']) && isset($_POST['course_year_id']) && isset($_POST['semester_id']))
        {
            $studentSubjectMark = new StudentSubjectMark();
            $studentSubjectMark->student_id = $_POST['student_id'];
            $studentSubjectMark->course_year_id = $_POST['course_year_id'];
            $studentSubjectMark->semester_id = $_POST['semester_id'];
            $studentSubjectMark->subject_id = $_POST['subject_id'];
            $studentSubjectMark->mark = $_POST['mark'];
            $studentSubjectMark->mark1 = $_POST['mark1'];
            $studentSubjectMark->mark2 = $_POST['mark2'];
            
            $subject = Subject::getSubject($_POST['subject_id']);
            $rowId = $studentSubjectMark->isRowAlreadyExist();
            if (!$rowId = $studentSubjectMark->isRowAlreadyExist())
            {
                $subjectType = $subject->type;
                $studentSubjectMark->subject_type = $subjectType;                
                $saveResult = $studentSubjectMark->save();
                if ($subject->total_mark)
                {
                    $studentSubjectMark->percentage = ($studentSubjectMark->getTotalMark() / $subject->total_mark) * 100;
                    $studentSubjectMark->grade = $studentSubjectMark->getGrade($studentSubjectMark->percentage);
                }
                if ($saveResult)
                    echo "Mark Added!";
                exit;
            }
            else
            { 
                //if (!$studentSubjectMark->isAlreadyExist())
                //{
                    $markObj = StudentSubjectMark::model()->findByPk($rowId);
                    
                    if (($markObj->mark != $_POST['mark']) || ($markObj->mark1 != $_POST['mark1']) || ($markObj->mark2 != $_POST['mark2']) )
                    {
                        $markObj->mark = $_POST['mark'];
                        $markObj->mark1 = $_POST['mark1'];
                        $markObj->mark2 = $_POST['mark2'];
                        
                        if ($subject->total_mark)
                        {
                            $markObj->percentage = (($markObj->mark+$markObj->mark1+$markObj->mark2) / ($subject->total_mark*3)) * 100;
                            $markObj->grade = $markObj->getGrade($markObj->percentage);
                        }
                         if ($markObj->save())  echo "Mark Edited!";
                         exit;
                    }
                //}
            }
        }
        echo "Operation failed";
    }

}
