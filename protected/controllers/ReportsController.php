<?php

class ReportsController extends Controller
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
        if(isset($_POST['addSub']))
        {
          $studentId = $_POST['student'];
          $batchId = $_POST['batch'];
          $semesterId = !empty($_POST['semester'])? $_POST['semester']:"";
          $yearId = !empty($_POST['courseYears'])? $_POST['courseYears']:"";
          if(!empty($studentId) && !empty($batchId))
          {
              $this->showReport($batchId,$studentId,$yearId,$semesterId);
              exit;
          }
        }
        $batchModel = Batch::model()->findAll();    
        $this->render('view', array(
            'batchModel' => $batchModel           
        ));
    }
    
    public function actionStudent()
    {        
        $batchId = $_POST['batch_id'];
        if(!empty($batchId))
        {
            $criteria = new CDbCriteria;
            $criteria->condition = 'batch_id="'.$batchId.'"';  
            $criteria->order = 'name ASC';  
            $studentModel = Student::model()->findAll($criteria);               
            if($studentModel)
            {         
                $testArray = array();
                foreach($studentModel as $key=>$val)
                {
                    $testArray[$val['id']]= $val['name'];
                }                
               echo json_encode($testArray);
            }
        }
    }
     public function actionCourseYears()
    {        
        $studentId = $_POST['student_id'];
        $batchId   = $_POST['batch_id'];        
        if(!empty($studentId) && !empty($batchId))
        {           
            $batchModel = Batch::model()->findByPk($batchId);    
            $course = $batchModel->course_id;
            $criteria = new CDbCriteria;
            $criteria->condition = 'course_id="'.$course.'"';  
            $criteria->order = 'id ASC';  
            $courseYearModel = CourseYear::model()->findAll($criteria);               
            if($courseYearModel)
            {         
                $testArray = array();
                foreach($courseYearModel as $key=>$val)
                {                    
                    $testArray[$val['id']]= $val->year_name;
                }                
               echo json_encode($testArray);
            }
        }
    }
    
    public function actionSemester()
    {        
        $studentId      = $_POST['student_id'];
        $batchId        = $_POST['batch_id'];
        $courseYearId   = $_POST['year_id'];
        
        if(!empty($studentId) && !empty($batchId) && !empty($courseYearId))
        {           
            $criteria = new CDbCriteria;
            $criteria->condition = 'course_year_id="'.$courseYearId.'"';  
            $criteria->order = 'semester_id ASC';  
            $courseYearSemesterModel = CourseYearSemester::model()->findAll($criteria);               
            if($courseYearSemesterModel)
            {         
                $testArray = array();
                foreach($courseYearSemesterModel as $key=>$val)
                {
                    $semModel = Semester::model()->findByPk($val['semester_id']);
                    $testArray[$val['semester_id']]= $semModel['name'];
                }                
               echo json_encode($testArray);
            }
        }
    }
    
    public function showReport($batchId,$studentId,$yearId,$semesterId)
    {
        $studentModel = Student::model()->findByPk($studentId);
        $batchModel = Batch::model()->findByPk($batchId);
        $courseName = Course::getCourseName($batchModel->course_id);
        $semesterString = NULL;
        if($semesterId) $semesterString =  " AND semester_id='".$semesterId."'";  
        $CourseYearArray = array();
        if(empty($yearId))
        {
            $courseYears = Yii::app()->db->createCommand()
                ->select('id,year_name')
                ->from('course_years')
                ->where('course_id=:id', array(':id'=>$batchModel->course_id))
                ->queryAll(); 
           
            foreach($courseYears as $courseYear)
            {
                $CourseYearArray[] = $courseYear['id'];
                //$courseYear['year_name']
            }
        }
        
        $courseListArray = !empty($CourseYearArray)? $CourseYearArray :array($yearId);        
        $yearFlag = null;
        $markArray = array(); 
        $subjectCount = 0;
        foreach($courseListArray as $courseYear)
        {
            if(($yearFlag || $yearFlag==null) && $yearFlag!=$courseYear)
            {
                $yearFlag = $courseYear;
            }            
            else $yearFlag = "";
            
            $criteria = new CDbCriteria;
            $criteria->condition = 'course_year_id="'.$courseYear.'"';  
            $criteria->order = 'semester_id ASC';       
            $CourseYearSemesterModels = CourseYearSemester::model()->findAll($criteria);            
            $semFlag = null;      
            
            foreach($CourseYearSemesterModels as $cyskey=>$cysvalue)
            { 
                $criteria = new CDbCriteria;
                $criteria->condition = 'course_year_semester_id="'.$cysvalue->id.'" AND batch_id="'.$batchId.'"';  
                $examModel = Exam::model()->find($criteria);     
//                echo "<pre>";var_dump($examModel);exit;
                if($CourseYearSemesterModels && $examModel)
                {
                    if(($semFlag || $semFlag==null) && $semFlag!=$cysvalue)
                    {
                        $semFlag = $cysvalue->semester_id ;
                    }            
                    else $semFlag = "";
                    $criteria = new CDbCriteria;
                    $criteria->condition = 'batch_id="'.$studentModel->batch_id.'" AND course_year_id="'.$courseYear.'" AND semester_id="'.$cysvalue->semester_id.'"';  
                    $subjectModel = BatchSubject::model()->findAll($criteria);  
                    
                    foreach($subjectModel as $key=>$subject)
                    {       
                        $subjectActualModel = $subject->getSubject($subject->subject_id);
                        $studentSubjectMark = StudentSubjectMark::model()->findByAttributes(array("course_year_id"=>$courseYear,"semester_id"=>$cysvalue->semester_id,"subject_id"=>$subject->subject_id,"student_id"=>$studentModel->id));
                        if($studentSubjectMark)
                        {            
                            $yearRange = "";
                            if($yearFlag)
                            {                                
                                $courseYearModel = CourseYear::model()->findByPk($yearFlag);
                                $yearRange = Batch::getYearRange($yearFlag,$batchId);
                                
                                $yearFlag = $courseYearModel->year_name;
                            }  
                            if($semFlag)
                            {
                                $semesterModel = Semester::model()->findByPk($semFlag);
                                $semFlag = $semesterModel->name;
                            }       
                            $tempArray = array();
                            $tempArray['course_year'] = $yearFlag;
                            $tempArray['course_year_range'] = $yearRange;
                            $tempArray['semester'] = $semFlag;                        
                            $tempArray['subject'] = $subjectActualModel->subject;
                            $tempArray['subject_code'] = $subjectActualModel->subject_code;
                            $tempArray['mark'] = $studentSubjectMark->mark;
                            $tempArray['grade'] = $studentSubjectMark->grade;
                            $tempArray['subject_type'] = $studentSubjectMark->subject_type;  
                            //$batchSubjectModel = BatchSubject::getBatchSubjectModel($batchId,)

                            $subjectBatchModel = BatchSubjectTeacher::model()->findByAttributes(array("batch_subject_id"=>$subject->id));
    //                         echo "<pre>";var_dump($subjectBatchModel);exit;
                            $techerModel = Teacher::getTeacher($subjectBatchModel->teacher_id);
                            $tempArray['teacher_code'] = $techerModel->code;
                            $markArray[] = $tempArray;
                            $subjectCount++;
                        }
                    }
                }
            }
        
        }
        
        
        
        
        
//        if($subjectModel)
//        {
//            if($yearId) 
//        {
//            $yearString =  " AND course_year_id='".$yearId."'";
//        }
//        else
//        {
//            $courseYears = Yii::app()->db->createCommand()
//            ->select('id,year_name')
//            ->from('course_years')
//            ->where('course_id=:id', array(':id'=>$batchModel->course_id))
//            ->queryAll();   
//            $CourseYearArray = array();
//            foreach($courseYears as $courseYear)
//            {
//                $CourseYearArray[] = $courseYear['id'];
//            }
//            $criteria->addInCondition('course_year_id', $CourseYearArray);  
//        }     
//       
//        $criteria->condition = 'status="'.Subject::STATUS_ACTIVE.'" '.$semesterString.$yearString;  
//        $criteria->order = 'semester_id ASC';  
//      //  echo "<pre>";var_dump($criteria);exit;
//            $subjectModel = Subject::model()->findAll($criteria);
//            $markArray = array();
//            $semesterArray = array();
//            $tempSemesterArray = NULL;
//            foreach($subjectModel as $key=>$subject)
//            {
//                $semesterModel = Semester::model()->findByPk($subject['semester_id']);
//                $studentSubjectMark = StudentSubjectMark::model()->findByAttributes(array("subject_id"=>$subject->id,"student_id"=>$studentModel->id));
//                if($studentSubjectMark)
//                {
//                    if($tempSemesterArray!=$semesterModel->id){
//                            $semesterArray[] = $semesterModel->id;
//                    }
//                    $tempSemesterArray = $semesterModel->id;
//                    $tempArray['semester_id'] = $semesterModel->id;
//                    $tempArray['semester'] = $semesterModel->name;
//                    $tempArray['subject'] = $subject->subject;
//                    $tempArray['subject_code'] = $subject->subject_code;
//                    $tempArray['mark'] = $studentSubjectMark->mark;
//                    $tempArray['grade'] = $studentSubjectMark->grade;
//                    $tempArray['subject_type'] = $studentSubjectMark->subject_type;                   
//                    $subjectTecherModel = BatchSubjectTeacher::model()->findByAttributes(array("batch_id"=>$batchId,"subject_id"=>$subject['id']));
//                    $techerModel = Teacher::getTeacher($subjectTecherModel->teacher_id);
//                    $tempArray['teacher_code'] = $techerModel->code;
//                    $markArray[] = $tempArray;
//                    
//                }
//            }
//            $resultArray = array();
//             
//            foreach($semesterArray as $key=>$val){               
//                $tempSemesterArray = array();
//                foreach($markArray as $key1=>$val1){                    
//                    if($val==$val1['semester_id'])
//                    {
//                        $tempArray['semester_id'] = $val1['semester_id'];
//                        $tempArray['semester'] = $val1['semester'];
//                        $tempArray['subject'] = $val1['subject'];
//                        $tempArray['subject_code'] = $val1['subject_code'];
//                        $tempArray['mark'] = $val1['mark'];
//                        $tempArray['grade'] = $val1['grade'];
//                        $tempArray['subject_type'] = $val1['subject_type'];  
//                        $tempArray['teacher_code'] = $val1['teacher_code'];  
//                        $tempSemesterArray[] = $tempArray;
//                    }
//                }
//                $resultArray[$val] = $tempSemesterArray;                           
//            }
//        }      
//   echo "<pre>";var_dump($markArray[0]);exit;
//        $markArray = array_merge($markArray,$markArray);
        $this->render('markSheet', array(
            'studentModel' => $studentModel,
            'markArray'=>$markArray,
            'subjectCount'=>$subjectCount,
            'courseName'=>$courseName
                
        ));
    }
}
