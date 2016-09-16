<?php

class BatchesController extends Controller
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
        $pages = new CPagination(Batch::model()->count($criteria));
        $pages->pageSize = Yii::app()->params['perPageCount'];
        $pages->applyLimit($criteria);
        $models = Batch::model()->findAll($criteria);
        $this->render('view', array(
            'models' => $models,
            'pages' => $pages
        ));
    }
    
    public function actionSemesters()
    {        
        $batchModel = Batch::getBatch($_GET['batchId']);
        if($batchModel===false)
        {
             $this->redirect(array("view"));exit;
        }       
        
        $courseYears = Yii::app()->db->createCommand()
        ->select('id,year_name')
        ->from('course_years')
        ->where('course_id=:id', array(':id'=>$batchModel->course_id))
        ->queryAll();   
        $CourseYearArray = array();
        foreach($courseYears as $courseYear)
        {
            $CourseYearArray[] = $courseYear['id'];
        }
        
        $criteria = new CDbCriteria;       
        $criteria->addInCondition('course_year_id', $CourseYearArray);   
        $criteria->order = 'semester_id ASC';        
        $models = CourseYearSemester::model()->findAll($criteria);        
        
        $courseModel = Course::getCourse($batchModel->course_id);
        $teachersModel = Teacher::getAll();
        $teachersList = $this->getList($teachersModel, "id", "code",false); 
        
        $subjectTeacher = new BatchSubjectTeacher;
        $this->render('semesters', array(
            'models' => $models,
            'courseYears' => $courseYears,
            'courseModel' =>$courseModel,
            'subjectTeacher'=>$subjectTeacher,
            'teachersList'=>$teachersList            
        ));
    }
    
    public function actionsubjectTeacher()
    {
        if (isset($_POST['batch_subject_id']))
        {             
             $teacherId = $_POST['teacher_id'];
             $batchSubjectId   = $_POST['batch_subject_id'];
             $subjectResult = BatchSubjectTeacher::model()->findByAttributes(array('batch_subject_id'=>$batchSubjectId));
             $teacherResult = BatchSubjectTeacher::model()->findByAttributes(array('teacher_id'=>$teacherId,'batch_subject_id'=>$batchSubjectId));
//             echo "<pre>ss";print_r($subjectResult);echo "jj";print_r($teacherId);echo "jd";print_r($batchId);exit;
             $flag =false;
             if(!$teacherResult && !$subjectResult && $teacherId)
             {                 
                 $model = new BatchSubjectTeacher();
                 $model->teacher_id = $teacherId;
                 $model->batch_subject_id = $batchSubjectId;
                 $model->created = date("Y-m-d H:i");  
                 if($model->save()) $flag = true;
             }
             else if($teacherResult && $teacherId)
             {
                 if($teacherResult->teacher_id!=$teacherId)
                 {
                     $teacherResult->teacher_id = $teacherId;
                     if($teacherResult->save()) $flag = true;
                 }
             }
             else if($subjectResult && $teacherId)
             {
                 if($subjectResult->teacher_id!=$teacherId)
                 {
                    $subjectResult->teacher_id = $teacherId;
                    if($subjectResult->save()) $flag = true;
                 }
             }
             else if(!$teacherId && ($teacherResult || $subjectResult))
             {
                 if($teacherResult) BatchSubjectTeacher::model()->deleteByPk($teacherResult->id);
                 else if($subjectResult) BatchSubjectTeacher::model()->deleteByPk($subjectResult->id);
                 $flag = true;
             }
             if($flag ==true){
                  echo 'Faculty assigned successfully!';
             }
             else
             {                 
                  echo 'Operation failed!';              
             }
        }
    }
    public function actionAdd()
    {
        $model = new Batch();
        if (isset($_POST['addSub']))
        {
            $model->setAttributes($_POST['Batch']);            
            if ($model->isAlreadyExist())
            {
                Yii::app()->user->setFlash('error', 'Batch already exist!');
            }
            else if (!$model->isValidDate())
            {
                Yii::app()->user->setFlash('error', 'Invalid batch year!');
            }
            else
            {
                if ($model->validate())
                {
                    $model->created = date("Y-m-d H:i");
                    if ($model->save(false))
                    {
                        $courseYears = CourseYear::getCourseYears($model->course_id);
                        $startArray = explode("-",$model->start_date);
                        $startYear =  $startArray[0];                       
                        foreach($courseYears as $key=>$value)
                        {
                            $SemesterCount = CourseYearSemester::getSemesterCount($value->id);
                            $batchYearModel = new BatchYear();
                            $batchYearModel->batch_id = $model->id;
                            $batchYearModel->start_year = $startYear;
                            $batchYearModel->end_year = $startYear+1;
                            $batchYearModel->course_year_id = $value->id;  
                            $batchYearModel->semester_count = $SemesterCount;
                            $batchYearModel->save();
                            $startYear = $startYear +1;
                        }
                        Yii::app()->user->setFlash('success', 'Batch details has been saved successfully!');
                        $this->redirect(array('view'));
                        exit;
                    }
                    else
                        Yii::app()->user->setFlash('error', 'Operation Failed!');
                }
                
            }
        }    
        $courses = Course::getAll();
        $courseList = $this->getList($courses, "id", "name");        
        $this->render('add', array('model' => $model,'courseList'=>$courseList));
    }
    

    public function actionEdit()
    {
        if (isset($_GET['id']))
        {
            $id = $_GET['id'];
            $model = Batch::getBatch($id);
            if ($model)
            {
                if (isset($_POST['addSub']))
                {
                    $model->setAttributes($_POST['Batch']);
                    if ($model->isAlreadyExist($id))
                    {
                        Yii::app()->user->setFlash('error', 'Batch already exist!');
                    }
                    else if (!$model->isValidDate())
                    {
                        Yii::app()->user->setFlash('error', 'Invalid batch year!');
                    }
                    else
                    {
                        if ($model->validate())
                        {
                            if ($model->save(false))
                            {
                                
                                $courseYears = CourseYear::getCourseYears($model->course_id);
                                $startArray = explode("-",$model->start_date);
                                $startYear =  $startArray[0];                       
                                foreach($courseYears as $key=>$value)
                                {
                                    BatchYear::deleteBatchYears($value->id,$model->id);
                                    $SemesterCount = CourseYearSemester::getSemesterCount($value->id);
                                    $batchYearModel = new BatchYear();
                                    $batchYearModel->batch_id = $model->id;
                                    $batchYearModel->start_year = $startYear;
                                    $batchYearModel->end_year = $startYear+1;
                                    $batchYearModel->course_year_id = $value->id;  
                                    $batchYearModel->semester_count = $SemesterCount;
                                    $batchYearModel->save();
                                    $startYear = $startYear +1;
                                }
                                Yii::app()->user->setFlash('success', 'Batch details has been updated successfully!');
                                $this->redirect(array('view'));
                                exit;
                            }
                            Yii::app()->user->setFlash('error', 'Operation Failed!');
                        }
                    }
                }
                 
                $courses = Course::getAll();
                $courseList = $this->getList($courses, "id", "name");        
                $this->render('add', array('model' => $model,'courseList'=>$courseList));                
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
            if (Batch::model()->deleteByPk($_GET['id']))
            {
                Yii::app()->user->setFlash('success', 'Batch has been deleted successfully!');
                $this->redirect(array('view'));
                exit;
            }
            Yii::app()->user->setFlash('error', 'Operation failed!');
            $this->redirect(array('view'));
            exit;
        }
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
    
    public function actionManageSubjects()
    {
        $batchModel = Batch::getBatch($_GET['batchId']);
//        var_dump($batchModel);exit;
        if($batchModel===NULL)
        {
             $this->redirect(array("/batches/view"));exit;
        }       
        
        $courseYears = Yii::app()->db->createCommand()
        ->select('id,year_name')
        ->from('course_years')
        ->where('course_id=:id', array(':id'=>$batchModel->course_id))
        ->queryAll();   
        
        $CourseYearArray = array();
        foreach($courseYears as $courseYear)
        {
            $CourseYearArray[] = $courseYear['id'];
        }
        
        $criteria = new CDbCriteria;       
        $criteria->addInCondition('course_year_id', $CourseYearArray);   
        $criteria->order = 'semester_id ASC';        
        $models = CourseYearSemester::model()->findAll($criteria);
        
        $batchSubject = new BatchSubject;
        $this->render('addSubjects', array(
            'models' => $models,
            'courseYears' => $courseYears,            
            'batchSubject'=>$batchSubject,
        ));
    }
    
    public function actionSaveSubjects()
    {
        if (isset($_POST['subjects']) && isset($_POST['batch_id'])  && isset($_POST['course_year_id'])  && isset($_POST['semester_id']))
        {
            $subjectArray   = $_POST['subjects'];
            $courseYearId   = $_POST['course_year_id'];
            $semesterId     = $_POST['semester_id'];
            $batchId        = $_POST['batch_id'];  
            
            foreach($subjectArray as $key=>$val){
                $criteria = new CDbCriteria;       
                $criteria->condition = 'course_year_id="'.$courseYearId.'" AND batch_id="'.$batchId.'" AND semester_id="'.$semesterId.'"  AND subject_id="'.$val.'"';   
                $batchModel = BatchSubject::model()->find($criteria);  
                if(!$batchModel){
                    $model = new BatchSubject();
                    $model->course_year_id = $courseYearId;
                    $model->batch_id = $batchId;
                    $model->semester_id = $semesterId;
                    $model->subject_id = $val;  
                    $model->save();  
                }
            }
            $criteria = new CDbCriteria;       
            $criteria->addNotInCondition('subject_id', $subjectArray);   
            $criteria->condition = 'course_year_id="'.$courseYearId.'" AND batch_id="'.$batchId.'" AND semester_id="'.$semesterId.'"';      
            $models = BatchSubject::model()->find($criteria);
            if($models)
            {
                //Check it is referred in another tables         
                $criteria = new CDbCriteria;       
                $criteria->addNotInCondition('subject_id', $subjectArray); 
                BatchSubject::model()->deleteAllByAttributes(array("course_year_id"=>$courseYearId,"batch_id"=>$batchId,"semester_id"=>$semesterId),$criteria);
            }
            echo 'Subjects saved sucessfully!';            
        }
    }
       

}
